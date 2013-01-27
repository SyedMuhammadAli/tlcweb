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
			$data['title'] = "The Literary Club - View Event";
			$data['comments'] = $this->events_model->get_event_comments($event_id);
			$data['organizers'] = $this->events_model->get_event_organizers($event_id);
			$data['is_logged_in'] = $this->tlc_model->is_user_logged_in();
			$data = $data + $evt;
			
			//load view
			$this->load->view('view_event', $data);
		}
	}
	
	function timeline($time){
		if($time != "future" && $time != "past"){ return; } //ADD APPROPRIATE ERROR MSG HERE
		
		$evt['events'] = $time == "future" ? $this->events_model->get_upcoming_events() : $this->events_model->get_past_events();
		
		$evt['title'] = "The Literary Club - Upcomming Events";
		
		$evt['total_threads'] = $this->total_threads;
		$evt['total_comments'] = $this->total_comments;
		$evt['total_members'] = $this->total_members;
		
		$evt['is_logged_in'] = $this->tlc_model->is_user_logged_in();

		$this->load->view("events_list", $evt);
	}
	
	function comment(){
		$this->events_model->post_comment($this->tlc_model->get_user_id(),
											$this->input->post('event_id'),
											$this->input->post('text'));
		
		redirect("events/view/".$this->input->post('event_id'));
	}
	
	function register($event_id){
		if($this->events_model->registration_allowed($event_id)){ //currently allowed is set to 0. Fix taht!
			die("<h2>Either the registration for this event is not yet enabled, or the event does not exist.</h2>");
		} //end validation
		
		if($this->input->post("submit")){ //submit will be false if not set
			$this->load->library('form_validation');
			
			$this->form_validation->set_rules("inst_id", "Institute Id", "trim|required|numeric");
			$this->form_validation->set_rules("team_name", "Team Name", "trim|required|alpha_dash|max_length[20]");
			$this->form_validation->set_rules("participants_name", "participants_name", "trim|required|min_length[3]|max_length[50]");
			$this->form_validation->set_rules("contact", "Contact", "trim|required|min_length[8]|max_length[12]");
			$this->form_validation->set_rules("alt_contact", "Alternate Contact", "trim|required|min_length[8]|max_length[12]");
			$this->form_validation->set_rules("email", "Email address", "trim|required|valid_email");
			
			if($this->form_validation->run() == false){
				$data['title'] = "The Literary Club - Event Registration";
				$data['event_id'] = $event_id;
				$data['validation_errors'] = validation_errors();
				$data['is_logged_in'] = $this->tlc_model->is_user_logged_in();
				$data['institute_array'] = $this->tlc_model->get_institute_array();
				
				$this->load->view("events_register", $data);
			} else {
				$this->events_model->register_team(	$event_id,
													$this->input->post("inst_id"),
													$this->input->post("team_name"),
													$this->input->post("participants_name"),
													$this->input->post("contact"),
													$this->input->post("alt_contact"),
													$this->input->post("email") );
				
				echo "<h2>Thank you for registering. " . anchor("home", "Click here") . " to go back.</h2>";
			}
		} else {
			$data['title'] = "The Literary Club - Event Registration";
			$data['event_id'] = $event_id;
			$data['is_logged_in'] = $this->tlc_model->is_user_logged_in();
			$data['institute_array'] = $this->tlc_model->get_institute_array();
			
			$this->load->view("events_register", $data);
		}
	}
	
	//administrative functions
	function create($arg = ""){
		if($this->tlc_model->user_is_admin()){
			if($arg != "done"){
				$data['title'] = "The Literary Club - Create Event";
				$data['is_logged_in'] = $this->tlc_model->is_user_logged_in();
				
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
					$data['is_logged_in'] = $this->tlc_model->is_user_logged_in();
					$this->load->view('create_event_form', $data);
					return;
				} else {
					$profile = $this->tlc_model->get_profile();
					$profile['id'] = $this->tlc_model->get_user_id();
					
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
