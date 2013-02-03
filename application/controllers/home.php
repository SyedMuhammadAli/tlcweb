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
 */

error_reporting(E_ALL | E_STRICT);
ini_set("display_errors", 1);

class Home extends CI_Controller {
	private		$total_threads,
			$total_comments,
			$total_members;
	
	function __construct(){
		parent::__construct();
		
		$this->load->library('enigma');
		$this->load->model('tlc_model');
		$this->load->model('events_model');
		$this->load->library('pagination');
		$this->load->library('table');
		$this->load->library("userauthorization", array("session_object" => $this->session));
		
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
		
		if(count($nxt_evt) != 0):
		$info['upcoming_event_exists'] = true;
		$info['event_name'] = $nxt_evt['name'];
		$info['event_id'] = $nxt_evt['id'];
		$info['event_countdown_timer'] = $this->calc_time_remaining($nxt_evt['event_date']);
		$info['registration_allowed'] = $nxt_evt['registration_allowed'];
		else:
		$info['upcoming_event_exists'] = false;
		endif;
		
		//stats
		$info['total_threads'] = $this->total_threads;
		$info['total_comments'] = $this->total_comments;
		$info['total_members'] = $this->total_members;
		
		//login info
		$info['is_logged_in'] = $this->userauthorization->isUserLoggedIn();
		
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
		
		if($this->tlc_model->login_user($this->input->post("username"), $this->input->post("password"))){
			$uid = $this->tlc_model->get_uid_by_username( $this->input->post('username') );
			
			$profile = $this->tlc_model->get_profile( $uid );
			
			$data = array(
				'uid' => $uid,
				'username' => $profile['usr'],
				'fname' => $profile['firstname'],
				'lname' => $profile['lastname'],
				'email' => $profile['email'],
				'active' => $profile['active'],
				'contact' => $profile['contact_num'],
				'is_logged_in'	=> true,
				'is_user_admin' => $this->tlc_model->user_is_admin($uid)
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
			$data['is_logged_in'] = $this->userauthorization->isUserLoggedIn();
			
			if(count($nxt_evt) != 0):
			$data['upcoming_event_exists'] = true;
			$data['event_name'] = $nxt_evt['name'];
			$data['event_id'] = $nxt_evt['id'];
			$data['event_countdown_timer'] = $this->calc_time_remaining($nxt_evt['event_date']);
			else:
			$data['upcoming_event_exists'] = false;
			endif;
			
			$this->load->view('show_topics', $data);
		} else {
			die("Invalid topic id.");
		}
	}
	
	function profile($id = -1){
		if(!$this->userauthorization->isUserLoggedIn()) die("<h2>You must be logged in to view member profiles.</h2>");
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
		if($this->userauthorization->isUserLoggedIn()) //if already logged in
			redirect("/home");
		
		$data['title'] = "The Literary Club - Signup";
		
		//stats
		$data['total_threads'] = $this->total_threads;
		$data['total_comments'] = $this->total_comments;
		$data['total_members'] = $this->total_members;

		//login info
		$data['is_logged_in'] = $this->userauthorization->isUserLoggedIn();
		$data['institute_array'] = $this->tlc_model->get_institute_array();
		
		if($arg == "validate"){
			$this->load->library("form_validation");
			
			//rules
			$this->form_validation->set_rules("username", "Username", "trim|required|max_length[24]");
			$this->form_validation->set_rules("password", "Password", "trim|required|min_length[6]|max_length[17]");
			$this->form_validation->set_rules("password2", "Password Confirmation", "trim|required|matches[password]");
			$this->form_validation->set_rules("firstname", "First Name", "trim|required|max_length[24]");
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
				$data['error'] = "Validation Error: " + validation_errors();
				$this->load->view("signup", $data);
				return;
			} else {
				
				$pass_arr = $this->enigma->Encrypt($this->input->post("password"));
								
				$account_info = array(
					"usr"		=> $this->input->post("username"),
					"pswd"		=> $pass_arr['hash'],
					"firstname"	=> $this->input->post("firstname"),
					"lastname"	=> $this->input->post("lastname"),
					"contact_num" =>   $this->input->post("phone_num"),
					"inst_id"	=> $this->input->post("institute"),
					"email"		=> $this->input->post("email"),
					"salt"		=> $pass_arr['rand_str'],
				);
		
				
				$this->tlc_model->create_user($account_info); //create user
				echo "<h3>Thank You. Please wait while an administrator accepts your signup request.</h3>";
				echo anchor('home', "Click here to go back to the main page.");
			}
		} else {
			$this->load->view("signup", $data);
		}
	}

}

?>
