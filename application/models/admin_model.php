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
		$data = array('active' => 1);
		
		$this->db->where('id', $event_id);
		$this->db->update('events', $data);
	}
	
	function disable_event_registration($event_id){
		$data = array('active' => 0);
		
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

	function get_all_tlc_members($sort_name = null, 
								$sort_order = null, 
								$col_name = null,
								$search_term = null,
								$per_page = null,
								$offset = null){
		/** SELECT m.id, m.usr, m.firstname, m.lastname, d.name, m.contact_num, m.email
		 * FROM members m, departments d, tlc_member tm
		 * WHERE m.id = tm.member_id and tm.dept_id = d.id and m.active = 1;
		 */
		
		$this->db->select("m.id as user_id, 
				m.usr as username,
				m.firstname as firstname, 
				m.lastname as lastname, 
				d.name as department_name, 
				m.contact_num as contact_num, 
				m.email as email");
		$this->db->from("members m, departments d, tlc_member tm");
		$this->db->where("m.id = tm.member_id and tm.dept_id = d.id and m.active = 1");
		
		if($sort_name != null)
			$this->db->order_by($sort_name, $sort_order);
		
		if($col_name != null && $search_term != null)
			$this->db->where("{$col_name} like '{$search_term}%'");
		
		$this->db->limit($per_page, $offset);
		
		return $this->db->get();
	}
	
	function get_all_members($sort_name = null, 
								$sort_order = null, 
								$col_name = null,
								$search_term = null,
								$per_page = null,
								$offset = null){
		$this->db->select("id, usr, firstname, lastname, contact_num, email, active");
		
		if($sort_name != null)
			$this->db->order_by($sort_name, $sort_order);
		
		if($col_name != null && $search_term != null)
			$this->db->where("{$col_name} like '{$search_term}%'");
		
		$this->db->limit($per_page, $offset);
		
		return $this->db->get("members");
	}
	
	/** 
	 * Deprecated
	 * Returns the events of the current year.
	 * If year is passed as an argument then
	 * it returns the list of events for that year.
	 */
	function get_events($year = NULL ){
		if($year == NULL)
			$year = date("Y", time());
		
		$this->db->where("event_date >", mktime(0,0,0,1,1,intval($year)));
		$this->db->where("event_date <", mktime(0,0,0,12,31,intval($year)));
		
		return $this->db->get("events"); 
	}
	
	function get_all_events($sort_name = null, 
								$sort_order = null, 
								$col_name = null,
								$search_term = null,
								$per_page = null,
								$offset = null){
		$this->db->select("m.usr as usr,
							e.id as event_id,
							e.name as event_name,
							e.event_date as event_date,
							e.active as active");
		$this->db->from("members m, events e");
		$this->db->where("m.id = e.creator_id");
		

		if($sort_name != null)
			$this->db->order_by($sort_name, $sort_order);
		
		if($col_name != null && $search_term != null)
			$this->db->where("{$col_name} like '{$search_term}%'");
		
		$this->db->limit($per_page, $offset);
		
		return $this->db->get();
	}
	
	/** 
	 * Returns all departments.
	 */
	function get_all_departments(){
		return $this->db->get("departments");
	}
	
	function get_all_articles($sort_name = null, 
								$sort_order = null, 
								$col_name = null,
								$search_term = null,
								$per_page = null,
								$offset = null){
		$this->db->select("article.id as id,
						   article.title as title,
						   article.time as time,
						   content_creator.usr as author");
		$this->db->from("posts as article, members as content_creator");
		$this->db->where("article.author_id = content_creator.id");

		if($sort_name != null)
			$this->db->order_by($sort_name, $sort_order);
		
		if($col_name != null && $search_term != null)
			$this->db->where("{$col_name} like '{$search_term}%'");
		
		$this->db->limit($per_page, $offset);
		
		return $this->db->get();
	}
	
	function get_all_teams($sort_name = null, 
								$sort_order = null, 
								$col_name = null,
								$search_term = null,
								$per_page = null,
								$offset = null){
		/** SELECT team.id, team.team_name, team.participants, team.contact, team.alt_contact, team.email_add, team.active, event.name, institute.name
		   	FROM participant_teams as team, events as event, institutes as institute
		    WHERE team.event_id = event.id and team.inst_id = institute.id; */
		
		$this->db->select("team.id as id,
						team.team_name as team_name, 
						team.participants as participants, 
						team.contact as contact_num, 
						team.alt_contact as alt_contact, 
						team.email_add as email,
						team.active as active, 
						event.name as event_name, 
						institute.name as institute_name");
		
		$this->db->from("participant_teams as team,
						events as event, 
						institutes as institute");
		
		$this->db->where("team.event_id = event.id and team.inst_id = institute.id");

		if($sort_name != null)
			$this->db->order_by($sort_name, $sort_order);
		
		if($col_name != null && $search_term != null)
			$this->db->where("{$col_name} like '{$search_term}%'");
		
		$this->db->limit($per_page, $offset);
		
		return $this->db->get();
	}
}