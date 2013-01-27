<?php

class Events_model extends CI_Model{
	function create($event_details){
		$this->db->insert('events', $event_details);
	}
	
	function edit($event_id, $event_details){
		$this->db->where('id', $event_id);
		$this->db->update('events', $event_details);
	}
	
	function post_comment($author_id, $event_id, $text){
		$this->db->insert('event_comments', array('author_id' => $author_id,
												  'event_id' => $event_id,
												  'text' => $text));
	}
	
	function get_event($event_id){
		$this->db->select("	events.id as event_id,
							events.name as event_name,
							events.about as event_about,
							events.rules as event_rules,
							events.creator_id,
							events.event_date,
							events.registration_allowed,
							members.usr as creator_name");
		$this->db->from("events");
		$this->db->join("members", "events.creator_id = members.id");
		$this->db->where("events.id", $event_id);
		$query = $this->db->get();
		
		if($query->num_rows() == 0){
			return false;
		} else {
			return $query->row_array();
		}
	}
	
	function get_event_comments($event_id){
		$this->db->select("event_comments.text AS comment, event_comments.time AS time, event_comments.author_id AS profile_id, members.usr AS author");
		$this->db->from("event_comments, members");
		$this->db->where("event_comments.author_id = members.id");
		
		return $this->db->get();
	}
	
	function get_event_organizers($event_id){
		$this->db->select(" members.id AS member_id,
							members.firstname AS firstname,
							members.lastname AS lastname");
		$this->db->from("members, event_organizers");
		$this->db->where("event_organizers.event_id = {$event_id}");
		$this->db->where("event_organizers.user_id = members.id");
		
		return $this->db->get();
	}
	
	function get_upcoming_events(){
		$this->db->where("event_date >", time());
		return $this->db->get("events");
	}
	
	function get_past_events(){
		$this->db->where("event_date <", time());
		return $this->db->get("events");
	}
	
	function get_next_event(){
		$this->db->select('id, name, event_date, registration_allowed');
		$this->db->from('events');
		$this->db->where("event_date >", time());
		$this->db->order_by('event_date', 'asc');
		$this->db->limit(1);
		return $this->db->get()->row_array();
	}
	
	/* returns false if either the event is invalid, the registation is not allowed or the event is history */
	function registration_allowed($event_id){
		$evt = $this->db->get_where('events', array('id' => $event_id))->row();
		
		if($evt == null){
			return false;
		} else if($evt->registration_allowed == 0 && ($evt->event_date - time()) > 0){ //change == to !=
			return true;
		} else {
			return false;
		}
	}
	
	function register_team($event_id, $inst_id, $team_name, $participants_name, $contact, $alt_contact, $email){
		//make this a boolean fn and return false if the team is already registered for this event
		$team = array( 'event_id'		=> $event_id,
						'inst_id'		=> $inst_id,
						'team_name'		=> $team_name,
						'participants'	=> $participants_name,
						'contact'		=> $contact,
						'alt_contact'	=> $alt_contact,
						'email_add'		=> $email );
		
		$this->db->insert("participant_teams", $team);
	}
}