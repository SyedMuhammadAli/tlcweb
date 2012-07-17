<?php

class Tlc_model extends CI_Model{
	
	private $cipher_authlock_salt = "35n8d8sakf66y..j9fnfivsi@iqm_21w9j=chs";
	private $cipher_authkey_salt = "3wjw#1,=+800.ctk+8-fghao6pp7t7giy9zlz_";
	private $cipher_authkey = "l2ddd2k7+590.1z5s5udto7mcq.ndb3.lg5i99";
	
	private $uid;
	
	function __construct(){
		parent::__construct();
		$this->load->library('encrypt');
		$this->uid = $this->get_user_id();
	}
	
	//Returns cipher keys, currently hard coded
	function get_cipher_key($arg){
		switch($arg){
			case 1:
				return $this->cipher_authlock_salt; //lock slat
			case 2:
				return $this->cipher_authkey_salt; //key salt
			case 3:
				return $this->cipher_authkey; //key
		}
	}
	
	function create_user(){
		$account_info = array(
			"usr"		=> $this->input->post("username"),
			"pswd"		=> md5($this->input->post("password")),
			"firstname"	=> $this->input->post("firstname"),
			"lastname"	=> $this->input->post("lastname"),
			"contact_num" => $this->input->post("phone_num"),
			"inst_id"	=> $this->input->post("institute"),
			"email"		=> $this->input->post("email")
		);
		
		$this->db->insert("members", $account_info);
	}
	
	function login_user(){
		$this->db->where("usr", $this->input->post("username"));
		$this->db->where("pswd", md5($this->input->post("password")));
		
		$query = $this->db->get("members");

		if($query->num_rows() == 1 && $query->row()->active != false)
			return true;
		else
			return false;
	}
	
	function get_profile($id){
		/* Fetching profile information */
		$this->db->select(" members.usr,
							members.fb_usr,
							members.firstname,
							members.lastname,
							members.web_link,
							members.email,
							members.contact_num,
							members.hidden,
							members.active,
							departments.name AS department_name,
							institutes.name AS institute_name");
		
		$this->db->from("members");
		
		$this->db->join("institutes", "members.inst_id = institutes.id");
		$this->db->join("departments", "members.dept_id = departments.id");
		
		$this->db->where("members.id", $id);
		
		$profile = $this->db->get();
		
		if($profile->num_rows() == 1){
			return $profile->row_array();
		} else {
			return false; //die("Couldn"t get proper data for profile.")
		}
	}
	
	function get_events_organized($id){
		$this->db->select("events.id, events.name");
		$this->db->from("event_organizers, members");
		$this->db->join("events", "event_organizers.event_id = events.id");
		$this->db->where("members.id", $id);
		
		return $this->db->get();
	}
	
	function get_editable_from_profile(){
		$this->db->select("fb_usr, web_link, contact_num, email, hidden");
		$this->db->from("members");
		$this->db->where(array('id' => $this->uid));
		
		$q = $this->db->get();
		
		if($q->num_rows() == 1){
			return $q->row_array();
		} else {
			//something really bad happened
			return false;
		}
	}
	
	function update_editable_profile($fb_usr, $web_link, $contact_num, $email_addr){
		$this->db->where(array("id" => $this->uid));
		$this->db->update("members", array('fb_user'	=> $fb_usr,
											'web_link'	=> $web_link,
											'contact_num' => $contact_num,
											'email'		=> $email_addr));
	}
	
	function validate_password($pswd){
		$user_row = $this->db->get_where("members", array("id" => $this->uid))->row();
		
		return ($user_row->pswd == md5($pswd)) ? true : false;
	}
	
	function change_password_to($new_password){
		$this->db->where("id", $this->uid);
		$this->db->update("members", array("pswd" => md5($new_password)));
	}
	
	function get_institute_array(){
		$q = $this->db->get('institutes');
		$result = array();
		
		foreach($q->result() as $inst){
			$result[$inst->id] = $inst->name;
		}
		
		return $result;
	}

	//consider storing in session - cant think on any reason why not
	function get_user_id(){
		$user = $this->get_username();
		
		if(!$user){ return false; } //if not set
		
		//$uid = $this->db->get_where("members", array('usr' => $user))->row()->id;
		
		$this->db->select("id");
		$this->db->from("members");
		$this->db->where('usr', $user);
		$uid = $this->db->get()->row()->id;
		
		return $uid;
	}
	
	function user_is_admin(){
		$uid = $this->get_user_id();

		if(!$uid){ return false; } //if not logged in
		
		$this->db->where("user_id", $uid);
		
		$permission = $this->db->get("permission")->row_array();
		
		if(isset($permission["level"]) && $permission["level"] == 16){ //Admin level is 16
			return true;
		} else {
			return false;
		}
		
	}
	
	function post_news(){
		$profile = $this->get_profile();
		
		//check permission to post
		$this->db->where("user_id", $profile["user_id"]);
		$permission = $this->db->get("permission")->row_array();
		
		//Author has clearence lvl 4
		if(!isset($permission["level"]) || $permission["level"] < 4){
			return false; //if permission not given OR permission level is lower than required
		} else {
			$this->load->helper('typography');
			
			$data = array(
						"title" => $this->input->post("title"),
						"post" => nl2br_except_pre( $this->input->post("text") ),
						"author_id" => $profile["user_id"]
			);
			
			$this->db->insert("posts", $data);
			
			return true;
		}
	}
	
	function post_comment($author_id, $thread_id, $text){
		$this->db->insert("comments", array("author_id" => $author_id,
											"thread_id" => $thread_id,
											"text" => $text));
	}
	
	function get_threads($per_page, $uri_segment){
		$this->db->select("posts.id AS post_id,
							posts.title,
							posts.post AS post,
							posts.time AS time,
							members.id AS user_id,
							members.usr");
		$this->db->from("posts, members");
		$this->db->where("posts.author_id = members.id");
		$this->db->limit($per_page, $uri_segment); //limit, offset
		$this->db->order_by("posts.id", "desc");
		
		return $this->db->get();
	}
	
	function get_comments($per_page, $uri_segment, $thread_id){
		$this->db->select("comments.text AS text, comments.time as time, members.id AS profile_id, members.usr AS author");
		$this->db->from("comments, members");
		$this->db->where("thread_id", $thread_id);
		$this->db->where("members.id = comments.author_id");
		$this->db->limit($per_page, $uri_segment);
		$this->db->order_by("comments.id", "desc");
			
		return $this->db->get();
	}
	
	function get_thread_by_id($thread_id){
		$this->db->where("id", $thread_id);
		return $this->db->get("posts");
	}
	
	function userexist($usr, $email){
		$user = $this->db->get_where("members", array("usr" => $usr));
		$email = $this->db->get_where("members", array("email" => $email));
		
		if( ($user->num_rows() == 0) && ($email->num_rows() == 0) ){
			return false;
		} else {
			return true;
		}
	}
	
	function total_threads(){
		return $this->db->get("posts")->num_rows();
	}
	
	function total_comments(){
		return $this->db->get("comments")->num_rows();
	}
	
	function total_members(){
		return $this->db->get("members")->num_rows();
	}
	
	//decript session data
	function is_user_logged_in(){
		return $this->session->userdata('auth_key');
		
		/* EXPERIMENTAL CODE
		$key = $this->session->userdata('auth_key');
		
		if($this->encrypt->decode($key, $this->cipher_authkey_salt) == $this->cipher_authkey){
			return true;
		} else {
			return false;
		}*/
	}
	
	function get_username(){
		$user = $this->session->userdata('auth_lock');
		
		if($user == false){
			return false;
		} else {
			return $this->encrypt->decode($user, $this->cipher_authlock_salt);
		}
	}
}
