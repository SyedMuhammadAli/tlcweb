<?php

/* TODO List v1
 * Make a general view for error messages and pass in the message. [TDK]
 * Add facebook like, and tweet to posts and events.  [TDK]
 * Add CAPTCHA to register
 * Save additional profile info inside session file.
 ** Enable the /home/profile method to display all but disabled profiles, if the user is logged in
 * Profile control panel with links to allowed actions:
 * 		edit profile, change password,
 * 		rem members/profile, (hit count?), hide personal data but not profile,
 * 		upload profile picture.
 * 
 * Make primitive administration panel
 * 		- view/modify priviledges table
 * 		- list view/delete/edit threads
 * 		- list view/delete/edit/download events + add members to events
 * 		- add/remove institute
 * 		- enable/disable accounts accounts
 * 
 * TODO beyond v1
 * Login with facebook support
 * Add domain/username functionality.
 *  * MicroBlogging platform to allow people to write and share...
 * 		How much to allow?
 * 		How to make visible
 * 		why differennt from facebook, twitter
 * 		why on this web?
 * Add society affiliations (student society groups) - needs refining: student social network
 * 
 * Bugs:
 * If there are no upcomming events. There are errors on line 78, 79
 * 
 * RC1 TODO:
 * Add event registration link to homepage below the event date.
 * Remove "User Registration" from the homepage.
 * Keep the header and footer in seprate header.php, and footer.php files.
 * Remove all instances of 'create thread' and 'create event' buttons from all pages.
 * Remove dummy image placeholder from showtopic.php view.
 * Fix design of Events profile page.
 * Fix design of Event registration page.
 * Add something to the right sidebar of the showtopic.php that makes sense.
 * Teams are not an entity. The system only keeps records as statis - non linking
 * independent entity.
 */

error_reporting(E_ALL | E_STRICT);
ini_set("display_errors", 1);

class Home extends CI_Controller {
	private		$total_threads,
				$total_comments,
				$total_members;
	
	function __construct(){
		parent::__construct();
		
		$this->load->model('tlc_model');
		$this->load->model('events_model');
		$this->load->library('pagination');
		$this->load->library('table');
		
		//fix
		$this->total_threads = $this->tlc_model->total_threads();
		$this->total_comments = $this->tlc_model->total_comments();
		$this->total_members = $this->tlc_model->total_members();
		
		//$this->output->enable_profiler(TRUE);
	}
	
	function index(){
		$config['base_url'] = base_url()."index.php/home/index/";
		$config['total_rows'] = $this->db->get('posts')->num_rows();
		$config['per_page'] = 3;
		$config['num_links'] = 20;
		$config['uri_segment'] = 3;
		$config['next_link'] = 'Next';
		$config['prev_link'] = 'Prev';
		
		$this->pagination->initialize($config);
		
		$info['title'] = "The Literary Club - Welcome";
		
		//fetch model
		$info['records'] = $this->tlc_model->get_threads($config['per_page'], $this->uri->segment(3));
		
		//get event info
		$nxt_evt = $this->events_model->get_next_event();
		
		$info['event_name'] = $nxt_evt['name'];
		$info['event_id'] = $nxt_evt['id'];
		$info['event_countdown_timer'] = $this->calc_time_remaining($nxt_evt['event_date']);
		
		//stats
		$info['total_threads'] = $this->total_threads;
		$info['total_comments'] = $this->total_comments;
		$info['total_members'] = $this->total_members;
		
		//login info
		$info['is_logged_in'] = $this->tlc_model->is_user_logged_in();
		
		$info['page_links'] = $this->pagination->create_links();
		
		$this->load->view('home_view', $info);
	}
	
	/* Returns a string of the time remaining in d-h-m format using a unix timestamp */
	private function calc_time_remaining($unix_evt_time){
		$this->load->helper("date");
		
		return timespan(time(), $unix_evt_time);
		
		/*//old
		$evt_d = intval( ($unix_evt_time - time())/(60*60*24) );
		$evt_h = intval( ($unix_evt_time - time())/(60*60) ) - $evt_d*24;
		$evt_m = intval( ($unix_evt_time - time())/(60) ) - $evt_h*60 - $evt_d*24*60;
		
		return ($evt_d . "d, " . $evt_h . "hr, ".  $evt_m . "m. ". " Remaining");
		*/
	}
	
	function about(){
		redirect("home/showtopic/2");
	}
	
	function login(){ //already logeed in user can't view this
		if(!$this->input->post("submit")){
			die("<h4>You can't access this page directly.</h4>");
		}
		
		if($this->tlc_model->login_user()){
			$data = array(
				'auth_lock' => $this->input->post('username'),
				'auth_key'	=> true
			);
			
			$this->session->set_userdata($data);
			
			redirect("home/");
		} else {
			echo "<h3>Login failure. Please try again. <br>If you entered the correct details, your account might be inactive.</h3>";
			echo anchor("home/", "[Home]") . "  ";
			echo anchor("home/login", "[Login]");
		}
	}
	
	function logout(){
		$this->session->sess_destroy();
		redirect('home');
	}
	
	function showtopic($thread_id = -1){
		if($thread_id >= 0){
			//Pagination Configuration
			$config['base_url'] = base_url()."index.php/home/showtopic/{$thread_id}/";
			$config['total_rows'] = $this->db->get_where('comments', array('thread_id' => $thread_id))->num_rows();
			$config['per_page'] = 5;
			$config['num_links'] = 20;
			$config['uri_segment'] = 4;
			$config['next_link'] = 'Next';
			$config['prev_link'] = 'Prev';

			$this->pagination->initialize($config);
			
			//echo "Total Rows" . $config['total_rows']; //DEBUG
			
			//Load topic
			$query = $this->tlc_model->get_thread_by_id($thread_id);

			//Load Comments
			$comments_query = $this->tlc_model->get_comments($config['per_page'],
															 $this->uri->segment(4),
															 $thread_id);

			//Load view
			$data['title'] = "The Literary Club - Show Topic";
			$data['post'] = $query->row_array();
			$data['author_name'] = $this->tlc_model->get_user_by_id($data['post']['author_id']);
			$data['comments'] = $comments_query;
			$data['thread_id'] = $thread_id;
			$data['page_links'] = $this->pagination->create_links();
			
			//Changes Start
			//stats
			$data['total_threads'] = $this->total_threads;
			$data['total_comments'] = $this->total_comments;
			$data['total_members'] = $this->total_members;
			
			//fetch model
			$data['records'] = $this->tlc_model->get_threads($config['per_page'], $this->uri->segment(3));
			//Changes End 
			
			//get event info
			$nxt_evt = $this->events_model->get_next_event();
			
			//login info
			$data['is_logged_in'] = $this->tlc_model->is_user_logged_in();
		
			$data['event_name'] = $nxt_evt['name'];
			$data['event_id'] = $nxt_evt['id'];
			$data['event_countdown_timer'] = $this->calc_time_remaining($nxt_evt['event_date']);
			
			$this->load->view('show_topics', $data);
		} else {
			die("Invalid topic id.");
		}
	}
	
	function profile($id = -1){
		if(!$this->tlc_model->is_user_logged_in()) die("<h2>You must be logged in to view member profiles.</h2>");
		if(!is_int($id) && $id < 0) die("<h2>Invalid profile id. Error Code HPi1</h2>");
		
		$data['title'] = "The Literary Club - User Profile";
		$data['profile'] = $this->tlc_model->get_profile($id);
		$data['events_organized'] = $this->tlc_model->get_events_organized($id);
		
		if(	$data['profile'] && $data['profile']['active'] && !$data['profile']['hidden'] )
			$this->load->view('public_profile', $data);
		else
			die("<h2>Invalid profile id. Error Code HPie2</h2>");
	}
	
	function signup($arg = ""){
		//BLOCK ACCESS IS USER IS ALREADY LOGGED IN
		
		$data['title'] = "The Literary Club - Signup";
		
		//stats
		$data['total_threads'] = $this->total_threads;
		$data['total_comments'] = $this->total_comments;
		$data['total_members'] = $this->total_members;

		//login info
		$data['is_logged_in'] = $this->tlc_model->is_user_logged_in();
		$data['institute_array'] = $this->tlc_model->get_institute_array();
		
		if($arg == "validate"){
			$this->load->library("form_validation");
			
			//rules
			$this->form_validation->set_rules("username", "Username", "trim|required|max_length[24]");
			$this->form_validation->set_rules("password", "Password", "trim|required|min_length[6]|max_length[17]");
			$this->form_validation->set_rules("password2", "Password Confirmation", "trim|required|matches[password]");
			$this->form_validation->set_rules("firstname", "First Name", "trim|required|alpha|max_length[24]");
			$this->form_validation->set_rules("lastname", "Last Name", "trim|required|alpha|max_length[24]");
			$this->form_validation->set_rules("institute", "1", "trim|required|numeric");
			$this->form_validation->set_rules("phone_num", "Only numbers", "trim|required|min_length[8]|max_length[13]|numeric");
			$this->form_validation->set_rules("email", "Email Address", "trim|required|valid_email|max_length[48]");
			
			$already_exists = $this->tlc_model->userexist($this->input->post('username'),
														  $this->input->post('email'));
			
			if($already_exists)
			{
				$data['validation_error'] = "User already exists with the same username or email.";
				$this->load->view("signup", $data);
				return;
			}
			
			if($this->form_validation->run() == FALSE){
				$data['error'] = "Form Validation Failed.";
				$this->load->view("signup", $data);
				return;
			} else {
				$this->tlc_model->create_user(); //create user
				echo "<h3>Thank You. Please wait while an administrator accepts your signup request.</h3>";
				echo anchor('home', "Click here to go back to the main page.");
			}
		} else {
			$this->load->view("signup", $data);
		}
	}

}

?>
