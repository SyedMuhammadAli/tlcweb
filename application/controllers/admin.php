<?php 

class Admin extends CI_Controller {
	private $_title = "Admin Panel v1.0";
	private $_perpage = 10;
	private $_urisegment = 3;
	
	function __construct(){
		parent::__construct();
		
		$this->load->model('tlc_model');
		$this->load->model('admin_model');
		$this->load->library('pagination');
		
		if( !$this->tlc_model->user_is_admin() ) //authorize access
			redirect("/home");
		
		$config['base_url'] = "http://localhost/apricot/index.php/admin/";
		$config['per_page'] = $this->_perpage;
		$config['total_rows'] = $this->tlc_model->total_members();
		$config['next_link'] = "Next";
		$config['prev_link'] = "Prev";
		$this->pagination->initialize($config);
	}
	
	function index(){
		redirect("admin/members");
	}
	
	function members($action=NULL, $user_id=NULL){
		if(is_null($action)){
			$data['title'] = $this->_title;
			$data['record'] = $this->admin_model->get_members($this->_perpage,
															  $this->uri->segment($this->_urisegment));
			$data['page'] = "members";
			$data['page_links'] = $this->pagination->create_links();
			
			$this->load->view("admin_view", $data);
		} else {
			$user_id = intval($user_id);
			if($action == "activate")
				$this->admin_model->activate_member($user_id);
			else if($action == "deactivate")
				$this->admin_model->deactivate_member($user_id);
			
			$this->members(); //redirect to home
		}
	}
	
	function teams(){
		$data['title'] = $this->_title;
		$data['record'] = $this->admin_model->get_teams($this->_perpage,
														$this->uri->segment($this->_urisegment));
		$data['page'] = "teams";
		
		$this->load->view("admin_view", $data);
	}
	
	function departments($dept_id = NULL){
		if(is_null($dept_id)){
			$data['title'] = $this->_title;
			$data['record'] = $this->admin_model->get_departments();
			$data['page'] = "departments";
			
			$this->load->view("admin_view", $data);
		} else {
			//add excel sheet download mechanism
			
			$members = $this->admin_model->get_memberlist_in_dept($dept_id);
			foreach($members->result() as $m){
				echo $m->firstname . ", " . $m->lastname;
			}
		}
	}
	
	function events($action = NULL, $event_id = NULL){
		if(is_null($action)){
			$data['title'] = $this->_title;
			$data['record'] = $this->admin_model->get_events($this->uri->segment(3));
			$data['page'] = "events";
			
			$this->load->view("admin_view", $data);
		} else {
			$event_id = intval($event_id);
			if($action == "activate")
				$this->admin_model->enable_event_registration($event_id);
			else if($action == "deactivate")
				$this->admin_model->disable_event_registration($event_id);
			
			$this->events();
		}
	}
	
	function accountsettings(){
		
	}
}
?>