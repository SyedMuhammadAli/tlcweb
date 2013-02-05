<!doctype html>

<html lang="en">
<head>
<meta charset="utf-8" />
<title>Admin's Panel</title>
<link rel="stylesheet"
	href="http://code.jquery.com/ui/1.10.0/themes/base/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.8.3.js"></script>
<script src="http://code.jquery.com/ui/1.10.0/jquery-ui.js"></script>
<?php echo link_tag(array('href' => '/resources/demos/style.css', 'rel' => 'stylesheet', 'type' => 'text/css', 'media' => 'screen' )); ?>
<?php echo link_tag(array('href' => 'css/flexigrid.css', 'rel' => 'stylesheet', 'type' => 'text/css', 'media' => 'screen' )); ?>
<?php echo script_tag("js/flexigrid.js"); ?>
<script>
  $(function() {
    $( "#tabs" ).tabs();
  });
  </script>
<style>
body,div,section,acticle {
	margin: 0px;
	padding: 0px;
}

#tabs {
	font-family: sans-serif;
	font-size: 14px;
}

#tabs ul {
	text-decoration: none;
	text-shadow: 2px 2px #e1e1e1;
	font-weight: bold;
}

header img {
	display: block;
	margin: 20px auto;
}

header h3 {
	text-align: center;
	margin: 10px auto;
}

#members {
	display: none;
}

footer {
	text-align: center;
	text-decoration: none;
	text-weight: bold;
	text-shadow: 1px 1px #e0e0e0;
	font-family: arial;
	font-size: 12px;
	position: absolute;
	bottom: 10px;
	left: 450px;
}

#departments .flexigrid {
	float: left;
}
</style>
</head>
<body>
	<header>
		<?php echo img(array('src'=>'images/logo.png', 'alt' => 'Logo', 'href'=>'http://www.tlcnuces.com','id'=>'logo'));?>
		<h3>Welcome to the Admin's Panel</h3>
	</header>
	<nav id="tabs">
		<ul>
			<li><a href="#dashboard">DASHBOARD</a></li>
			<li><a href="#members">MEMBERS</a></li>
			<li><a href="#content">CONTENT</a></li>
			<li><a href="#events">EVENTS</a></li>
			<li><a href="#teams">TEAMS</a></li>
			<li><a href="#departments">DEPARTMENTS</a></li>
		</ul>
		<div id="dashboard">
			<p>dashboard</p>
		</div>
		<div id="members">
			<table id="members_table" style="display: none"></table>
			<script type="text/javascript">
            $("#members_table").flexigrid({
	            url: 'http://localhost/apricot/index.php/admin/members_json',
	            dataType: 'json',
	            colModel : [
		            {display: 'Id', name : 'id', width : 15, align: 'left', sortable: true},
		            {display: 'Username', name : 'usr', width : 100, align: 'left', sortable: true},
		            {display: 'FirstName', name : 'firstname', width : 100, align: 'left', sortable: true},
		            {display: 'LastName', name : 'lastname', width : 100, align: 'left', sortable: true},
		            {display: 'ContactNumber', name : 'contact_num', width : 100, align: 'left'},
		            {display: 'Email', name : 'email', width : 150, align: 'left'},
		            {display: 'Active', name : 'active', width : 50, align: 'left'}
		            ],
	            searchitems : [ {display: 'Username', name : 'usr', isdefault: true },
	                            {display: 'First Name', name : 'firstname'},
	                            {display: 'Last Name', name : 'lastname'} ],
	            sortname: "id",
	            sortorder: "asc",
	            rp: 10,
	            usepager: true,
	            title: 'Members',
	            useRp: false,
	            showTableToggleBtn: false,
	            singleSelect: true,
	            width: window.size,
	            height: 200,
	            buttons : [ {name: 'Activate User', bclass: 'add', onpress : activateUserAction},
	                        {name: 'Deactivate User', bclass: 'edit', onpress : deactivateUserAction} ]
            });
			
            function activateUserAction(){
            	var grid = $('#members_table');
            	var uid = $('.trSelected td:nth-child(1) div', grid).text();
            	$.get("member_action/activate/"+uid);
            	grid.flexReload();
            }
            
            function deactivateUserAction(){
                var grid = $('#members_table');
            	var uid = $('.trSelected td:nth-child(1) div', grid).text();
            	$.get("member_action/deactivate/"+uid);
            	grid.flexReload();
            }
        	</script>
		</div>
		<div id="content">
			<table id="content_table" style="display: none"></table>
			<script type="text/javascript">
            $("#content_table").flexigrid({
	            url: 'http://localhost/apricot/index.php/admin/content_json',
	            dataType: 'json',
	            colModel : [
		            {display: 'Id', name : 'id', width : 15, align: 'left'},
		            {display: 'Title', name : 'title', width : 200, align: 'left'},
		            {display: 'Author', name : 'author', width : 150, align: 'left', sortable: true },
		            {display: 'Time', name : 'time', width : 150, align: 'left'}//,
		            //{display: 'Active', name : 'active', width : 100, align: 'left'}
		            ],
	            searchitems : [ {display: 'Author', name : 'author', isdefault: true },
	                            {display: 'Title', name : 'title'} ],
	            sortname: "id",
	            sortorder: "asc",
	            rp: 10,
	            usepager: true,
	            title: 'Articles',
	            useRp: false,
	            showTableToggleBtn: false,   
	            singleSelect: true,
	            width: window.size,
	            height: 200
            });
        </script>
		</div>
		<div id="events">
			<table id="events_table" style="display: none"></table>
			<script type="text/javascript">
            $("#events_table").flexigrid({
	            url: 'http://localhost/apricot/index.php/admin/events_json',
	            dataType: 'json',
	            colModel : [
		            {display: 'Id', name : 'event_id', width : 15, align: 'left', sortable: true},
		            {display: 'Author', name : 'usr', width : 100, align: 'left', sortable: true},
		            {display: 'Event Name', name : 'event_name', width : 100, align: 'left', sortable: true},
		            {display: 'Date', name : 'event_date', width : 100, align: 'left'},
		            {display: 'Active', name : 'active', width : 100, align: 'left'}
		            ],
	            searchitems : [ {display: 'Author', name : 'usr'},
	                            {display: 'Event Name', name : 'e.name', isdefault: true} ],
	            sortname: "event_id",
	            sortorder: "asc",
	            rp: 10,
	            usepager: true,
	            title: 'Events',
	            useRp: false,
	            showTableToggleBtn: false,   
	            singleSelect: true,
	            width: window.size,
	            height: 200,
	            buttons : [ {name: 'Activate User', bclass: 'add', onpress : activateEventAction},
	                        {name: 'Deactivate User', bclass: 'edit', onpress : deactivateEventAction} ]
            });


            function activateEventAction(){
            	var grid = $('#events_table');
            	var eid = $('.trSelected td:nth-child(1) div', grid).text();
            	$.get("event_action/activate/"+eid);
            	grid.flexReload();
            }
            
            function deactivateEventAction(){
                var grid = $('#events_table');
            	var eid = $('.trSelected td:nth-child(1) div', grid).text();
            	$.get("event_action/deactivate/"+eid);
            	grid.flexReload();
            }
        </script>
		</div>
		<div id="teams">
			<table id="teams_table" style="display: none"></table>
			<script type="text/javascript">
            $("#teams_table").flexigrid({
	            url: 'http://localhost/apricot/index.php/admin/teams_json',
	            dataType: 'json',
	            colModel : [{display: 'Id', name : 'id', width : 15, align: 'left'},
	    		            {display: 'Team Name', name : 'team_name', width : 100, align: 'left'},
	    		            {display: 'Event Name', name : 'event_name', width : 100, align: 'left'},
	    		            {display: 'Institute', name : 'institute_name', width : 100, align: 'left'},
	    		            {display: 'Participants', name : 'participants', width : 250, align: 'left'},
	    		            {display: 'Contact', name : 'contact_num', width : 100, align: 'left'},
	    		            {display: 'Email', name : 'email', width : 100, align: 'left'},
	    		            {display: 'Active', name : 'active', width : 70, align: 'left'} ],
	            searchitems : [ {display: 'Name', name : 'name'} ],
	            sortname: "id",
	            sortorder: "asc",
	            rp: 10,
	            usepager: true,
	            title: 'Departments',
	            useRp: false,
	            showTableToggleBtn: false,
	            singleSelect: true,
	            width: window.size,
	            height: 200
            });
        </script>
		</div>
		<div id="departments" style="height: 300px">
			<table id="dept_table" style="display: none"></table>
			<script type="text/javascript">
            $("#dept_table").flexigrid({
	            url: 'http://localhost/apricot/index.php/admin/departments_json',
	            dataType: 'json',
	            colModel : [
		            {display: 'Id', name : 'id', width : 20, align: 'left'},
		            {display: 'Name', name : 'name', width : 150, align: 'left'}
		            ],
	            searchitems : [ {display: 'Name', name : 'name'} ],
	            sortname: "id",
	            sortorder: "asc",
	            usepager: false,
	            title: 'Departments',
	            useRp: false,
	            showTableToggleBtn: false,
	            singleSelect: true,
	            width: 200,
	            height: 230
            });
        </script>
		<table id="dept_members_table" style="display: none"></table>
			<script type="text/javascript">
            $("#dept_members_table").flexigrid({
	            url: 'http://localhost/apricot/index.php/admin/tlcmember_json',
	            dataType: 'json',
	            colModel : [
		            {display: 'Id', name : 'user_id', width : 15, align: 'left', sortable: true},
		            {display: 'Username', name : 'username', width : 75, align: 'left'},
		            {display: 'First Name', name : 'firstname', width : 75, align: 'left', sortable: true},
		            {display: 'Last Name', name : 'lastname', width : 75, align: 'left', sortable: true},
		            {display: 'Department', name : 'department_name', width : 100, align: 'left', sortable: true},
		            {display: 'Phone', name : 'contact_num', width : 75, align: 'left'},
		            {display: 'Email', name : 'email', width : 100, align: 'left'}
		            ],
	            searchitems : [ {display: 'Username', name : 'm.usr'},
	                            {display: 'Department', name : 'd.name', isdefault: true},
	                            {display: 'Last Name', name : 'm.lastname'} ],
	            sortname: "user_id",
	            sortorder: "asc",
	            rp: 10,
	            usepager: true,
	            title: 'TLC Members',
	            useRp: false,
	            showTableToggleBtn: false,
	            singleSelect: true,
	            width: 700,
	            height: 200
            });
        </script>
		</div>
	</nav>
	<footer>
		<p>DEVELOPED BY TLC WM</p>
	</footer>
</body>
</html>
