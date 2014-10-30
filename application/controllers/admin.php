<?php 

class Admin extends CI_Controller {
	private $_title = "Admin Panel v1.0";
	
	function __construct(){
		parent::__construct();
		
		$this->load->model('tlc_model');
		$this->load->model('admin_model');
		$this->load->library("userauthorization", array("session_object" => $this->session));
		
		if( !$this->userauthorization->isUserAdmin() ) //authorize access
			redirect("/home");
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
			
		$this->load->view("admin_view", $data);
	}

	function members_json(){
		$rp = $this->input->post("rp");
		$page = $this->input->post("page");
		
		$per_page = intval($this->input->post("rp"));
		$offset = !is_null($page) ? intval($rp)*(intval($page)-1) : 0;
		
		$table_data = $this->admin_model->get_all_members($this->input->post("sortname"), 
														$this->input->post("sortorder"),
														$this->input->post("qtype"),
														$this->input->post("query"),
														$per_page,
														$offset);
	
		$json_data = array( "page" => intval($page), "total" => $this->tlc_model->total_members(), "rows" => array() );
	
		foreach($table_data->result_array() as $row){
			$row["active"] = ($row["active"] ? "true" : "false");
			$entry = array( "id" => $row["id"],
					"cell" => $row );
			array_push($json_data["rows"], $entry);
		}
	
		echo json_encode($json_data);
	}
	
	function content_json(){
		$rp = $this->input->post("rp");
		$page = $this->input->post("page");
		
		$per_page = intval($this->input->post("rp"));
		$offset = !is_null($page) ? intval($rp)*(intval($page)-1) : 0;
		
		$table_data = $this->admin_model->get_all_articles($this->input->post("sortname"), 
														$this->input->post("sortorder"),
														$this->input->post("qtype"),
														$this->input->post("query"),
														$per_page,
														$offset);
	
		$json_data = array( "page" => intval($page), "total" => $this->tlc_model->total_threads(), "rows" => array() );
	
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
		$rp = $this->input->post("rp");
		$page = $this->input->post("page");
		
		$per_page = intval($this->input->post("rp"));
		$offset = !is_null($page) ? intval($rp)*(intval($page)-1) : 0;
		
		$table_data = $this->admin_model->get_all_events($this->input->post("sortname"), 
														$this->input->post("sortorder"),
														$this->input->post("qtype"),
														$this->input->post("query"),
														$per_page,
														$offset);
		
		$json_data = array( "page" => intval($page), "total" => $this->tlc_model->total_events(), "rows" => array() );
		
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
		$rp = $this->input->post("rp");
		$page = $this->input->post("page");
		
		$per_page = intval($this->input->post("rp"));
		$offset = !is_null($page) ? intval($rp)*(intval($page)-1) : 0;
		
		$table_data = $this->admin_model->get_all_teams($this->input->post("sortname"), 
														$this->input->post("sortorder"),
														$this->input->post("qtype"),
														$this->input->post("query"),
														$per_page,
														$offset);
		
		$json_data = array( "page" => intval($page), "total" => $this->tlc_model->total_teams(), "rows" => array() );
		
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
		
		$json_data = array( "page" => ceil($table_data->num_rows()/10), "total" => $table_data->num_rows(), "rows" => array() );
		
		foreach($table_data->result_array() as $row){
			$entry = array( "id" => $row["id"],
					"cell" => $row );
			array_push($json_data["rows"], $entry);
		}
		
		echo json_encode($json_data);
	}
	
	function tlcmember_json(){
		$rp = $this->input->post("rp");
		$page = $this->input->post("page");
		
		$per_page = intval($this->input->post("rp"));
		$offset = !is_null($page) ? intval($rp)*(intval($page)-1) : 0;
		
		$table_data = $this->admin_model->get_all_tlc_members($this->input->post("sortname"), 
															$this->input->post("sortorder"),
															$this->input->post("qtype"),
															$this->input->post("query"),
															$per_page,
															$offset);
	
		$json_data = array( "page" => intval($page), "total" => $this->tlc_model->total_tlc_members(), "rows" => array() );
	
		foreach($table_data->result_array() as $row){
			$entry = array( "id" => $row["user_id"],
					"cell" => $row );
			array_push($json_data["rows"], $entry);
		}
	
		echo json_encode($json_data);
	}
	
	function tlc_members(){
		echo "on todo list";
	}
	
	function member_action($action, $uid){
		switch($action){
			case "activate":
				$this->admin_model->activate_member($uid);
				break;
			case "deactivate":
				$this->admin_model->deactivate_member($uid);
				break;
			default:
				die("invalid member action.");
		}
	}
	
	function event_action($action, $eid){
		switch($action){
			case "activate":
				$this->admin_model->enable_event_registration($eid);
				break;
			case "deactivate":
				$this->admin_model->disable_event_registration($eid);
				break;
			default:
				die("invalid member action.");
		}
	}
	
	function article_json(){
		$q = $this->tlc_model
			->get_thread_by_id( $this->input->post("article_id") )
			->row_array();
		
		echo json_encode($q);
	}
}
?>