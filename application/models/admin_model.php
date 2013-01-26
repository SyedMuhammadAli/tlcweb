<?php

class Admin_model extends CI_Model{
	
	function __construct(){
		parent::__construct();
	}
	
	function activate_member($user_id){
		$data = array('active' => 1);

		$this->db->where('id', $user_id);
		$this->db->update('members', $data); 		
	}
	
	function deactivate_member($user_id){
		$data = array('active' => 0);

		$this->db->where('id', $user_id);
		$this->db->update('members', $data); 		
	}
	
	function enable_event_registration($event_id){
		$data = array('registration_allowed' => 1);
		
		$this->db->where('id', $event_id);
		$this->db->update('events', $data);
	}
	
	function disable_event_registration($event_id){
		$data = array('registration_allowed' => 0);
		
		$this->db->where('id', $event_id);
		$this->db->update('events', $data);
	}
	
	function activate_team($team_id) {}	//left the implementation blank for now
	function decativate_team($team_id) {}	//left the implementation blank for now
	
	function add_department($dept_name)
	{
		$dept_record = array("name" => $dept_name);
		$this->db->insert("departments", $dept_record);		
	}
	
	function remove_department($dept_id)
	{
		$this->db->delete('departments', array('id' => $dept_id));
	}
	
	function add_institute($inst_name)
	{
		$inst_record = array("name" => $inst_name);
		$this->db->insert("institutes", $inst_record);		
	}
	
	function remove_institute($inst_id)
	{
		$this->db->delete('institutes', array('id' => $inst_id));
	}
	
	function add_organizer($user_id, $event_id)
	{
		$org_record = array("user_id" => $user_id,
				     "event_id" => $event_id);
		$this->db->insert("event_organizers", $org_record);		
	}
	
	function get_memberlist_in_dept($dept_id){
		$this->db->where('dept_id', $dept_id);
		$this->db->where('active', 1);
		return $this->db->get('members');
	}
	
	function get_members($per_page, $uri_segment){
		$this->db->select("id, firstname, lastname, active");
		return $this->db->get('members', $per_page, $uri_segment);
	}
	
	function get_teams($per_page, $uri_segment, $event_id=NULL){
		$this->db->select("id, team_name, active");
		
		if($event_id != NULL){
			$this->db->where( array('event_id', $event_id) );
		} else {
			//$this->db->where( array('event_id', 1) );
		}
		
		return $this->db->get("participant_teams");
	}
	
	function get_events($year = NULL ){
		if($year == NULL)
			$year = date("Y", time());
		
		$this->db->where("event_date >", mktime(0,0,0,1,1,$year));
		$this->db->where("event_date <", mktime(0,0,0,12,31,$year));
		
		return $this->db->get("events"); 
	}
	
	function get_departments(){
		return $this->db->get("departments");
	}
}