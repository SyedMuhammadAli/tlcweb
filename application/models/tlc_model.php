<?php

class Tlc_model extends CI_Model{
	
	function __construct(){
		parent::__construct();
		$this->load->library('enigma');
	}
	
	function create_user($account_info){
		
		$this->db->insert("members", $account_info);
	}
	
	function login_user($user, $pass){
		$this->db->where("usr", $user);
		
		$query = $this->db->get("members");

		foreach ($query->result() as $row)
		{
		    if($this->enigma->checkPass($pass, $row->pswd, $row->salt))
		     {   echo "was there";
			return true;	}
		}
		
		return false;
	}
	
	function get_profile($id){
		/* Fetching profile information */
		$this->db->select(" members.id,
							members.usr,
							members.firstname,
							members.lastname,
							members.email,
							members.contact_num,
							members.hidden,
							members.active ");
							//departments.name AS department_name");
		
		$this->db->from("members");
		
		//$this->db->join("departments", "members.dept_id = departments.id");
		
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
	
	/* Code scheduled for removal ***
	function get_editable_from_profile(){
		$this->db->select("contact_num, email, hidden");
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
	*/
	
	function validate_password($uid, $pswd){
		$user_row = $this->db->get_where("members", array("id" => $uid))->row();
		
		return ($user_row->pswd == md5($pswd)) ? true : false;
	}
	
	function change_password_to($uid, $new_password){
		$this->db->where("id", $uid);
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
	
	/* Return the permission level of the user */
	function get_user_permission($uid){
		$this->db->where("user_id", $uid);
		
		return $this->db->get("permission")->row()->level;
	}
	
	function user_is_admin($uid){
		$permission = $this->get_user_permission($uid);
		
		if($permission == 16){ //Admin level is 16
			return true;
		} else {
			return false;
		}
	}
	
	function post_news($uid, $title, $text){
		if($this->get_user_permission($uid) < 4){
			return false; //if permission not given OR permission level is lower than required
		} else {
			$this->load->helper('typography');
			$data = array($title, $text, $uid);
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
	
	function get_user_by_id($user_id){
		$this->db->select("usr");
		$this->db->from("members");
		$this->db->where("id", $user_id);
		
		return $this->db->get()->row()->usr;
	}
	
	function get_uid_by_username($username){
		$this->db->select("id");
		$this->db->from("members");
		$this->db->where("usr", $username);
		
		return $this->db->get()->row()->id;
	}
}
