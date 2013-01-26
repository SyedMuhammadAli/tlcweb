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
		$action_uri = "index.php/admin/";
		
		switch($this->caller){
			case "members":
				$action_uri .= "members/" . ($this->obj->active ? "deactivate" : "activate") . "/{$this->obj->id}";
				break;
			case "teams":
				return "action/t";
			case "events":
				$action_uri .= "events/" . ($this->obj->registration_allowed ? "deactivate" : "activate") . "/{$this->obj->id}";
				break;
			case "departments":
				return "action/d";
		}
		
		return base_url($action_uri);
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

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php echo link_tag(array('href' => 'css/admin_styles.css', 'rel' => 'stylesheet', 'type' => 'text/css', 'media' => 'screen' )); ?>
<title>Admin Panel</title>
</head>

<body>
	<div id="container">
    	<div id="header">
        	<ul>
            	<a href=<?php echo base_url(); ?>><li>Home</li></a>
                <a href=<?php echo base_url("index.php/admin/"); ?>><li>Admin Panel</li></a>
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
                    	<li><?php echo anchor("admin/departments", "Departments"); ?></li>
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
							echo "No. Nothing. Nada...";
						}
					?>
				</ul>
				<div style="text-align:center; background:#ccc;">
				<?php
					if($page == "members") echo $page_links;
					if($page == "events"){
						echo anchor("admin/events/2011", "2011") . "     " .
							anchor("admin/events/2012", "2012") . "     " .
							anchor("admin/events/2014", "2014");
					} 
				?>
				</div>
			</div>
        </div>
        <div id="footer">Copyright The Literary Club 2012</div>
    </div>
</body>
</html>
