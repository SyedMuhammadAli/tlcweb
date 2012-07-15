<?php

class Members extends CI_Controller{
	private		$total_threads,
				$total_comments,
				$total_members;
	
	function __construct(){
		parent::__construct();
		$this->load->model('tlc_model');
		
		if(!$this->tlc_model->is_user_logged_in()){
			echo "<h3>You are not allowed to view this page.</h3>";
			echo anchor("home/", "[Home]") . "  ";
			echo anchor("home/login", "[Login]");
			die();
		}
		
		//fix
		$this->total_threads = $this->tlc_model->total_threads();
		$this->total_comments = $this->tlc_model->total_comments();
		$this->total_members = $this->tlc_model->total_members();
	}
	
	function index(){
		echo "<h3>Welcome to Members Lounge, ". $this->tlc_model->get_username() . "</h3>";
		echo anchor('home/index', 'Home'); echo "<br>";
		echo anchor('members/post', "Create a Thread"); echo "<br>";
		echo anchor('members/profile', "View Profile"); echo "<br>";
		echo anchor('home/logout', "Logout"); echo "<br>"; echo "<br>"; echo "<br>";
	}
	
	function profile($arg = ""){
		$data = $this->tlc_model->get_profile(); //load current profile data
		$data['title'] = 'The Literary Club - Profile'; //set page title

		//login info
		$data['is_logged_in'] = $this->tlc_model->is_user_logged_in();

		if($arg == "edit"){
			//$data = $this->tlc_model->get_profile();
			$data['title'] = 'The Lirerary Club - Edit Profile';
			//$data['is_logged_in'] = $this->tlc_model->is_user_logged_in();

			$this->load->view('edit_profile', $data);
			
			return;
		}

		if($arg == "save"){
			$this->load->library('form_validation');
			
			//rules
			$this->form_validation->set_rules("firstname", "First Name", "trim|required");
			$this->form_validation->set_rules("lastname", "Last Name", "trim|required");
			$this->form_validation->set_rules("email", "Email Address", "trim|required|valid_email");
			$this->form_validation->set_rules("password", "Password", "trim|required|min_length[6]|max_length[17]");
			$this->form_validation->set_rules("password2", "Password Confirmation", "trim|required|matches[password]");
			
			if($data['pswd'] != md5($this->input->post('password'))){
				die("<h3>Invalid Password</h3>");
			}
			
			if($this->form_validation->run() == false){
				redirect('members/profile/edit');
				return;
			} else {
				$updated_profile = array(	'firstname' => $this->input->post('firstname'),
											'lastname' => $this->input->post('lastname'),
											'email' => $this->input->post('email'));
					
				$this->tlc_model->update_profile($updated_profile);
					
				echo "<h3>Profile saved.</h3>";
			}
		}
		
		$data = $this->tlc_model->get_profile(); //reload updated profile info
		$data['title'] = 'The Literary Club - Profile'; //set page title - tmx fix
		$data['is_logged_in'] = $this->tlc_model->is_user_logged_in(); //fix this dependence too

		$this->load->view('profile', $data);
	}
	
	function post(){ //create a new post
		//stats
		$data['total_threads'] = $this->total_threads;
		$data['total_comments'] = $this->total_comments;
		$data['total_members'] = $this->total_members;

		//login info
		$data['is_logged_in'] = $this->tlc_model->is_user_logged_in();

		if(!$this->input->post("submit")){
			$data['title'] = "The Literary Club - Topic";
			$this->load->view('post', $data);
			
			return;
		}
		
		if($this->tlc_model->post_news()){
			redirect("home");
		} else {
			echo "<h3>You do not have permission to post. Sorry</h3>";
		}
	}
	
	function comment(){
		$profile = $this->tlc_model->get_profile();
		
		$this->tlc_model->post_comment($profile['user_id'], $this->input->post('thread_id'), $this->input->post('text'));
		
		redirect("home/showtopic/".$this->input->post('thread_id'));
	}
}

?>
