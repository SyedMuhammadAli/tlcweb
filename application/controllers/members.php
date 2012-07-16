<?php

class Members extends CI_Controller{
	private		$total_threads,
				$total_comments,
				$total_members;
	
	private		$is_logged_in = array();
	
	function __construct(){
		parent::__construct();
		$this->load->model('tlc_model');
		
		$this->is_logged_in = $this->tlc_model->is_user_logged_in();
		
		if(!$this->is_logged_in){
			echo "<h3>You are not allowed to view this page.</h3>";
			echo anchor("home/", "[Home]") . "  ";
			echo anchor("home/login", "[Login]");
			die();
		}
	}
	
	function index(){
		echo "<h3>Welcome to Members Lounge, ". $this->tlc_model->get_username() . "</h3>";
		echo anchor('home/index', 'Home'); echo "<br>";
		echo anchor('members/post', "Create a Thread"); echo "<br>";
		echo anchor('members/profile', "View Profile"); echo "<br>";
		echo anchor('home/logout', "Logout"); echo "<br>"; echo "<br>"; echo "<br>";
		
		//$this->load->view('member_cp', $data);
	}
	
	//added 16 jul 12
	function edit($arg = ""){
		$data['title'] = "The Literary Club - Edit Profile";
		$data['is_logged_in'] = $this->is_logged_in;
		
		if($arg == "done" && $this->input->post("submit")){
			$this->load->libarary("validation");
			
			$this->form_validation->set_rules("fb_user_name", "Fcebook Username", "trim|required|max_length[16]");
			$this->form_validation->set_rules("website_link", "Website Link", "trim|required|max_length[48]");			
			$this->form_validation->set_rules("phone_num", "Contact Number", "trim|required|max_length[13]");
			$this->form_validation->set_rules("email_addr", "Email Address", "trim|required|valid_email|max_length[28]");
			
			if($this->form_validation->run() == false){
				$data["validation_errors"] = validation_errors();
				$this->load->view("edit_profile", $data);
			} else {
				$this->tlc_model->update_editable_profile(
						$this->input->post('fb_user_name'),
						$this->input->post('website_link'),
						$this->input->post('phone_num'),
						$this->input->post('email_addr'));
			}
		} else {
			$data = $data + $this->tlc_model->get_editable_from_profile();
			$this->load->view('edit_profile', $data);
		}
	}
	
	function profile($arg = ""){
		echo "<h2>Page scheduled for removal. to be replaced by the Control Panel</h2>";
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
