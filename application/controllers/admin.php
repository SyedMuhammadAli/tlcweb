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
		$this->load->library("userauthorization", array("session_object" => $this->session));
		
		if( !$this->userauthorization->isUserAdmin() ) //authorize access
			redirect("/home");
		
		$config['base_url'] = "http://localhost/apricot/index.php/admin/";
		$config['per_page'] = $this->_perpage;
		$config['total_rows'] = $this->tlc_model->total_members();
		$config['next_link'] = "Next";
		$config['prev_link'] = "Prev";
		$this->pagination->initialize($config);
	}
	
	function index(){
		redirect("admin/dashboard");
	}
	
	function dashboard(){
		$data['title'] = $this->_title;
		$this->load->view("admin_view", $data);
	}
	
	function members(){
		$data['title'] = $this->_title;
		$data['page'] = "members";
		$data['page_links'] = $this->pagination->create_links();
			
		$this->load->view("admin_view", $data);
	}

	function members_json(){
		$table_data = $this->admin_model->get_all_members();
	
		$json_data = array( "page" => ceil($table_data->num_rows()/15), "total" => $table_data->num_rows(), "rows" => array() );
	
		foreach($table_data->result_array() as $row){
			$row["active"] = ($row["active"] ? "true" : "false");
			$entry = array( "id" => $row["id"],
					"cell" => $row );
			array_push($json_data["rows"], $entry);
		}
	
		echo json_encode($json_data);
	}
	
	function content_json(){
		$table_data = $this->admin_model->get_all_articles();
	
		$json_data = array( "page" => ceil($table_data->num_rows()/15), "total" => $table_data->num_rows(), "rows" => array() );
	
		foreach($table_data->result_array() as $row){
			//$row["active"] = ($row["active"] ? "true" : "false");
			$row["time"] = date("F j, Y", strtotime($row["time"]));
			$entry = array( "id" => $row["id"],
					"cell" => $row );
			array_push($json_data["rows"], $entry);
		}
	
		echo json_encode($json_data);
	}
	
	function events_json(){
		$table_data = $this->admin_model->get_all_events();
		
		$json_data = array( "page" => ceil($table_data->num_rows()/15), "total" => $table_data->num_rows(), "rows" => array() );
		
		foreach($table_data->result_array() as $row){
			$row["active"] = ($row["active"] ? "true" : "false");
			$row["event_date"] = date("F j, Y", $row["event_date"]);
			$entry = array( "event_id" => $row["event_id"],
					"cell" => $row );
			array_push($json_data["rows"], $entry);
		}
		
		echo json_encode($json_data);
	}
	
	function teams_json(){
		$table_data = $this->admin_model->get_all_teams();
		
		$json_data = array( "page" => ceil($table_data->num_rows()/15), "total" => $table_data->num_rows(), "rows" => array() );
		
		foreach($table_data->result_array() as $row){
			$row["active"] = ($row["active"] ? "true" : "false");
			$entry = array( "id" => $row["id"],
					"cell" => $row );
			array_push($json_data["rows"], $entry);
		}
		
		echo json_encode($json_data);
	}
	
	function departments_json(){
		$table_data = $this->admin_model->get_all_departments();
		
		$json_data = array( "page" => ceil($table_data->num_rows()/15), "total" => $table_data->num_rows(), "rows" => array() );
		
		foreach($table_data->result_array() as $row){
			$entry = array( "id" => $row["id"],
					"cell" => $row );
			array_push($json_data["rows"], $entry);
		}
		
		echo json_encode($json_data);
	}
	
	function teams($event_id = NULL){
		$data['title'] = $this->_title;
		$data['record'] = $this->admin_model->get_teams($this->_perpage,
				$this->uri->segment($this->_urisegment),
				$event_id);
		$data['page'] = "teams";
	
		$event_list = $this->admin_model->get_events(2013);
		$tmp_evt_array = array();
	
		foreach ($event_list->result() as $event){
			$tmp_evt_array[$event->id] = $event->name;
		}
	
		$data['event_list'] = $tmp_evt_array;
	
		$this->load->view("admin_view", $data);
	}
	
	function team_operation($action = NULL, $team_id = NULL){
		switch($action){
			case "activate":
				if($team_id == NULL) die("Error ap57");
				$this->admin_model->activate_team($team_id);
				$this->teams();
				break;
				
			case "deactivate":
				if($team_id == NULL) die("Error ap63");
				$this->admin_model->deactivate_team($team_id);
				$this->teams();
				break;
				
			default:
				die("Error ap69");
		}
	}
	
	function tlc_members(){
		echo "on todo list";
	}
	
}
?>