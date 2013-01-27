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
	
	function activate_team($team_id){
		$data = array("active" => 1);
		$this->db->where("id", $team_id);
		$this->db->update("participant_teams", $data);
	}
	
	function deactivate_team($team_id) {
		$data = array("active" => 0);
		$this->db->where("id", $team_id);
		$this->db->update("participant_teams", $data);
	}
	
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
	
	/* Return the teams associated with the event_id.
	 * */
	function get_teams($per_page, $uri_segment, $event_id=NULL){
		if($event_id == NULL) $event_id = 1;
		
		$this->db->select("id, team_name, active");
		$this->db->where("event_id", $event_id);
		
		return $this->db->get("participant_teams");
	}
	
	/* Returns the events of the current year.
	 * If year is passed as an argument then
	 * it returns the list of events for that year.
	 * */
	function get_events($year = NULL ){
		if($year == NULL)
			$year = date("Y", time());
		
		$this->db->where("event_date >", mktime(0,0,0,1,1,intval($year)));
		$this->db->where("event_date <", mktime(0,0,0,12,31,intval($year)));
		
		return $this->db->get("events"); 
	}
	
	/* Returns all departments.
	 * */
	function get_departments(){
		return $this->db->get("departments");
	}
}