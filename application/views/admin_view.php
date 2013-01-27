<?php 
class Profile {
	private $obj, $caller;
	
	function __construct($caller){
		$this->caller = $caller;
	}
	
	function setRecord($r){
		$this->obj = $r;
	}
	
	function getName(){
		switch($this->caller){
			case "members":
				return "{$this->obj->lastname}, {$this->obj->firstname}";
			case "teams":
				return $this->obj->team_name;
			case "events":
				return $this->obj->name;
			case "departments":
				return $this->obj->name;
		}
	}
	
	function getUrl(){
		$url = base_url("index.php");
		
		switch($this->caller){
			case "members":
				$url .= "/home/profile/{$this->obj->id}"; break;
			case "teams":
				return "home/participant/id";
			case "events":
				$url .= "/events/view/{$this->obj->id}"; break;
			case "departments":
				$url .= "/admin/departments/{$this->obj->id}"; break;
		}
		
		return $url;
	}
	
	function getActionUrl(){
		$action_uri = "/apricot/index.php/admin/";
		
		switch($this->caller){
			case "members":
				$action_uri .= "members/" . ($this->obj->active ? "deactivate" : "activate") . "/{$this->obj->id}";
				break;
			case "teams":
				$action_uri .= "team_operation/" . ($this->obj->active ? "deactivate" : "activate") . "/{$this->obj->id}";
				return $action_uri;
			case "events":
				$action_uri .= "events/" . ($this->obj->registration_allowed ? "deactivate" : "activate") . "/{$this->obj->id}";
				break;
			case "departments":
				return "action/d";
		}
		
		return $action_uri;
	}
	
	function isActive(){
		switch($this->caller){
			case "members":
			case "teams":
				return $this->obj->active ? "deactivate.png" : "activate.png";
			case "events":
				return $this->obj->registration_allowed ? "deactivate.png" : "activate.png";
			case "departments":
				return "action/d";
		}
	}
	
	function getButton(){
		$button = img(   array(	'src'=>"images/".$this->isActive(),
				'alt' => 'activate/deactivate button',
				'href'=>'http://www.tlc.net46.net',
				'id'=>'logo') );
		
		return $button;
	}
}

?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php echo link_tag(array('href' => 'css/admin_styles.css', 'rel' => 'stylesheet', 'type' => 'text/css', 'media' => 'screen' )); ?>
<title>Admin Panel</title>
<script>
function eventYearChangeListener(){
	var s = document.getElementById("event_selector");
	var selectorValue = s.options[s.selectedIndex].text;
	window.location = "http://localhost/apricot/index.php/admin/events/" + selectorValue;
}

function eventListChangeListener(){
	var s = document.getElementById("event_list");
	var selectorValue = s.options[s.selectedIndex].value;
	window.location = "http://localhost/apricot/index.php/admin/teams/" + selectorValue;
}
</script>
</head>
<body>
	<div id="container">
    	<div id="header">
        	<ul>
            	<a href=<?php echo base_url(); ?>><li>Home</li></a>
                <a href=<?php echo base_url("index.php/admin/"); ?>><li>Admin Panel</li></a>
                <a href=<?php echo base_url("index.php/home/logout"); ?>>Logout</a>
            </ul>
        </div>
        <div id="logo-panel"><?php echo img(array('src'=>'images/logo.png', 'alt' => 'Logo', 'href'=>'http://www.tlc.net46.net','id'=>'logo'));?></div>
        <div id="main">
        	<div id="tabs">
            	<ul>
                	<a href=<?php echo base_url("index.php/members"); ?>><li>Account Settings</li></a>
                    <a href=<?php echo base_url("index.php/admin"); ?>><li class="active-list-left">System Settings</li></a>
                </ul>
        	</div>
            <div id="left-panel">
            	<div class="heading">CMS</div>
                <div id="menu">
                	<ul>
                    	<li><?php echo anchor("admin/members", "Members"); ?></li>
                    	<li><?php echo anchor("admin/teams", "Teams"); ?></li>
                    	<li><?php echo anchor("admin/events", "Events"); ?></li>
                    	<li><?php echo anchor("admin/tlc_members", "TLC Members"); ?></li>
                    	<li><?php echo anchor("admin/departments", "Departments"); ?></li>
                    	<li><?php echo anchor("events/create", "Create Event"); ?></li>
                    	<li><?php echo anchor("members/post", "Create Post"); ?></li>
                    </ul>
                </div>
            </div>
            <div id="right-panel">
				<ul>
					<?php
						$p = new Profile($page);
						foreach($record->result() as $r):
							$p->setRecord($r);
					?>
					
					<li>
						<span class="title"><a href=<?php echo $p->getUrl(); ?>><?php echo $p->getName(); ?></a></span>
						<div class="button"><a href=<?php echo $p->getActionUrl(); ?>><?php echo $p->getButton(); ?></a></div>
					</li>
					
					<?php endforeach;
						if($record->num_rows() == 0){
							echo "No records found...";
						}
					?>
				</ul>
				<div style="text-align:center; background:#ccc;">
				<?php
					if($page == "members") echo $page_links;
					
					switch($page){
						case "events":
						echo form_dropdown("event_year", array(null, 2010, 2011, 2012, 2013, 2014), 2013, "id='event_selector' onChange='eventYearChangeListener();'");
						break;
						
						case "teams":
						echo form_dropdown("event_list", array(null => null)+$event_list, current($event_list), "id='event_list' onChange='eventListChangeListener();'");
						break;
					}
				?>
				</div>
			</div>
        </div>
        <div id="footer">Developed by TLC WebDev</div>
    </div>
</body>
</html>
