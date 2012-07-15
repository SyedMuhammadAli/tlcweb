<?php

class Tlc_model extends CI_Model{
	
	private $cipher_authlock_salt = "35n8d8sakf66y..j9fnfivsi@iqm_21w9j=chs";
	private $cipher_authkey_salt = "3wjw#1,=+800.ctk+8-fghao6pp7t7giy9zlz_";
	private $cipher_authkey = "l2ddd2k7+590.1z5s5udto7mcq.ndb3.lg5i99";
	
	function __construct(){
		parent::__construct();
		$this->load->library('encrypt');
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
			"inst_id"	=> $this->input->post("institute"), //bounds checking required
			"email"		=> $this->input->post("email")
		);
		
		$this->db->insert("members", $account_info);
		
		$q = $this->db->get_where("members", array("usr" => $this->input->post("username")));
		
		$this->db->insert("not_activated", array("user_id" => $q->row()->id));
		
		return true;
	}
	
	function login_user(){
		$this->db->where("usr", $this->input->post("username"));
		$this->db->where("pswd", md5($this->input->post("password")));
		
		$query = $this->db->get("members");

		if($query->num_rows() == 1){
			$inactive = $this->db->get_where("not_activated", array("user_id" => $query->row()->id));
			
			if($inactive->num_rows() == 1){
				return false;
			} else {
				return true;
			}
		}
	}
	
	function get_profile(){
		$username = $this->get_username();
		
		/* Fetching profile information */
		$this->db->select(	"members.id AS user_id,
							members.usr AS user,
							members.firstname AS firstname,
							members.lastname AS lastname,
							members.email AS email,
							institutes.name AS institute,");
		
		$this->db->from("members, institutes");
		
		$this->db->where("members.inst_id = institutes.id");
		$this->db->where("members.usr", $username);
		
		$profile = $this->db->get();
		
		//tmp var to hold user_id for query
		$id_tmp = $profile->row()->user_id;
		
		/* Fetching events information */
		$this->db->distinct();
		$this->db->select("events.name AS name,
							events.id AS id");
		$this->db->from("members, events, event_organizers");
		$this->db->where("event_organizers.user_id = {$id_tmp}");
		$this->db->where("event_organizers.event_id = events.id");
		
		
		/* Validating and returning result */
		if($profile->num_rows() == 1){
			$data = $profile->row_array();
			$data["username"] = $username;
			$data["events"] = $this->db->get();
			
			return $data;
		} else {
			return false; //die("Couldn"t get proper data for profile.");
		}
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
		
		$uid = $this->db->get_where("members", array('usr' => $user))->row()->id;
		
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
	
	function update_profile($profile){
		$this->db->where("usr", $this->get_username());
		$this->db->update("members", $profile);
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
