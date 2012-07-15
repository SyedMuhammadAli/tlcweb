<?php

class events extends CI_Controller{
	private		$total_threads,
			$total_comments,
			$total_members;
	
	function __construct(){
		parent::__construct();
		
		$this->load->model('tlc_model');
		$this->load->model('events_model');
		
		//fix
		$this->total_threads = $this->tlc_model->total_threads();
		$this->total_comments = $this->tlc_model->total_comments();
		$this->total_members = $this->tlc_model->total_members();
	}
	
	function index(){
		//Relace with view!
		echo anchor("home/", "[Home]"); echo "  ";
		echo anchor("events/create", "[Create Event]"); echo "  ";
		echo anchor("events/upcomingevents", "[Upcoming Event]"); echo "  ";
		echo anchor("events/pastevents", "[Past Event]"); echo "  ";
	}
	
	function about($event_id){
		//if invalid event id then print error
		//information about the event
	}
	
	function view($event_id){ //single event
		$evt = $this->events_model->get_event($event_id);
		
		if($evt == false){
			die("<strong>Invalid Event Id</strong>");
		} else {
			//get event comments
			$evt['comments'] = $this->events_model->get_event_comments($event_id);
			
			//get event organizers
			$evt['organizers'] = $this->events_model->get_event_organizers($event_id);
			
			//login info
			$evt['is_logged_in'] = $this->tlc_model->is_user_logged_in();

			//load view
			$this->load->view('view_event', $evt);
		}
	}
	
	function upcomingevents(){
		$evt['events'] = $this->events_model->get_upcoming_events();
		$evt['title'] = "The Literary Club - Upcomming Events";
		
		$evt['total_threads'] = $this->total_threads;
		$evt['total_comments'] = $this->total_comments;
		$evt['total_members'] = $this->total_members;
		
		$evt['is_logged_in'] = $this->tlc_model->is_user_logged_in();

		$this->load->view("viewevents", $evt);
	}

	function pastevents(){
		$evt['events'] = $this->events_model->get_past_events();
		$evt['title'] = "The Literary Club - Past Events";
		
		$evt['total_threads'] = $this->total_threads;
		$evt['total_comments'] = $this->total_comments;
		$evt['total_members'] = $this->total_members;
		
		$evt['is_logged_in'] = $this->tlc_model->is_user_logged_in();

		$this->load->view("viewevents", $evt);
	}
	
	function comment(){
		$profile = $this->tlc_model->get_profile();
		
		$this->events_model->post_comment($profile['user_id'],
											$this->input->post('event_id'),
											$this->input->post('text'));
		
		redirect("events/view/".$this->input->post('event_id'));
	}
	
	function register($event_id){
		if(!$this->tlc_model->is_user_logged_in()){
			die("<h2>You must be logged in to register for events. " . anchor("home/", "Click here") . " to log in </h2>");
		}
		
		if(!$this->events_model->registration_allowed($event_id)){ //currently allowed is set to 0. Fix taht!
			die("<h2>Either the registration for this event is not yet enabled, or the event does not exist.</h2>");
		}
		
		if($this->input->post("submit")){ //submit will be false if not set
			$this->load->library('form_validation');
			
			$this->form_validation->set_rules("teammate_one", "Teammate 1", "trim|max_length[24]");
			$this->form_validation->set_rules("teammate_two", "Teammate 2", "trim|max_length[24]");
			$this->form_validation->set_rules("alt_contact", "Alternate Contact No.", "trim|required|numeric");
			$this->form_validation->set_rules("extra_info", "Extra Information", "trim");
			
			if($this->form_validation->run() == false){
				redirect("events/register/{$event_id}");
			} else {
				$this->events_model->register_team(	$this->tlc_model->get_user_id(),
													$event_id,
													$this->input->post("teammate_one"),
													$this->input->post("teammate_two"),
													$this->input->post("alt_contact"),
													$this->input->post("extra_infos") );
				
				echo "<h2>Thank you for registering. " . anchor("home", "Click here") . " to go back.</h2>";
			}
		} else {
			echo "You don't need to add you name. You'll automatically be added to our db. <br/>";
			echo form_open("events/register/{$event_id}") . "<br />";
			echo form_input("teammate_one", "Teammate 1") . "<br />";
			echo form_input("teammate_two", "Teammate 2") . "<br />";
			echo form_input("alt_contact", "Alternate Cotnact") . "<br />";
			echo form_textarea("extra_info", "Extra Info") . "<br />";
			echo form_submit("submit", "Register for this event!");
			echo form_close();
			//die("<h2>Our code monkeys are confused. Please report error code: ERD2 to the webmaster.</h2>");
		}
	}
	
	//administrative functions
	function create($arg = ""){
		if($this->tlc_model->user_is_admin()){
			if($arg != "done"){
				$data['title'] = "The Literary Club - Create Event";
				$this->load->view('create_event_form', $data);
			} else { //if $arg is 'done'
				$this->load->library('form_validation');
				
				$this->form_validation->set_rules("name", "Event Name", "trim|required|max_length[48]");
				$this->form_validation->set_rules("day", "Day", "trim|required|is_natural");
				$this->form_validation->set_rules("month", "Month", "trim|required|is_natural");
				$this->form_validation->set_rules("year", "Year", "trim|required|is_natural");
				$this->form_validation->set_rules("about", "Write event description here.", "trim|required|max_length[512]");
				$this->form_validation->set_rules("rules", "Write event rules here.", "trim|required|max_length[512]");
				
				if($this->form_validation->run() == false){
					$data['error'] = validation_errors();
					$data['title'] = "The Literary Club - Create Event";
					$this->load->view('create_event_form', $data);
					return;
				} else {
					$profile = $this->tlc_model->get_profile();
					
					$evt = array(
						'name' => $this->input->post('name'),
						'about' => $this->input->post('about'),
						'rules' => $this->input->post('rules'),
						'creator_id' => $profile['id'],
						'event_date' => mktime(9, 30, 0,
											$this->input->post('month'),
											$this->input->post('day'),
											$this->input->post('year'))
					);
					
					$this->events_model->create($evt);
					
					//echo "DEBUG: " . $evt['event_date'];
					
					redirect('home');
				}
			}
		} else {
			die("<h4>You do not have permission to create an event.</h4>");
		}
	}
	
	function edit($event_id, $arg = ""){
		if($this->tlc_model->user_is_admin()){
			if($arg != "done"){
				$data = $this->events_model->get_event($event_id);
				$data['event_id'] = $event_id;
				$data['title'] = "The Literary Club - Edit Event";
				
				$this->load->view('edit_event_form', $data);
			} else { //if $arg is 'done'
				$this->load->library('form_validation');
				
				$this->form_validation->set_rules("name", "Event Name", "trim|required|max_length[48]");
				$this->form_validation->set_rules("day", "Day", "trim|required|is_natural");
				$this->form_validation->set_rules("month", "Month", "trim|required|is_natural");
				$this->form_validation->set_rules("year", "Year", "trim|required|is_natural");
				$this->form_validation->set_rules("about", "Write event description here.", "trim|required|max_length[512]");
				$this->form_validation->set_rules("rules", "Write event rules here.", "trim|required|max_length[512]");
				
				if($this->form_validation->run() == false){
					$data['error'] = validation_errors();
					$data['title'] = "The Literary Club - Edit Event";
					$this->load->view('edit_event_form', $data);
					return;
				} else {
					$evt = array(
						'name' => $this->input->post('name'),
						'about' => $this->input->post('about'),
						'rules' => $this->input->post('rules'),
						'event_date' => mktime(9, 30, 0,
											$this->input->post('month'),
											$this->input->post('day'),
											$this->input->post('year'))
					);
					
					$this->events_model->edit($event_id, $evt);

					redirect("events/view/{$event_id}");
				}
			}
		} else {
			die("<h4>You do not have permission to edit an event.</h4>");
		}
	}
	
	function manage($event_id){
		//if invalid event if then print error
		//if not admin print error
		//add/delete teams.
		//open/close registration
		//delete event
	}
}

?>
