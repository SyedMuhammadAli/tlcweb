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

.jqui-form-label, .jqui-form-input {
	display: block;
}

input.text {
	margin-bottom: 12px;
	width: 95%;
	padding: .4em;
}

fieldset {
	padding: 0;
	border: 0;
	margin-top: 25px;
}

.flexigrid-menu-button {
	margin: 0px;
	padding: 0px;
	font-weight: bold;
	font-family: sans-serif;
	text-decoration: none;
}

#article-modal-dialog {
	text-decoration: none;
	font-family: sans-serif;
	font-size: 16px;
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
            <div id="article-modal-dialog" title="Article Title"></div>
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
	            height: 200,
	            buttons: [ {name: 'View Article', bclass: 'article-view', onpress: viewArticleAction} ]
            });
            
            function viewArticleAction(){
            	var grid = $('#content_table');
            	var aid = $('.trSelected td:nth-child(1) div', grid).text();
				
				$.post("http://localhost/apricot/index.php/admin/article_json/",
						{ article_id : aid },
						function(done){
							var article_view = $("#article-modal-dialog");
							article_view.attr({ title : done.title });
							article_view.text(done.post);
							article_view.dialog({title: done.title});
							article_view.dialog("open");
						}, "json" );
            }
            
            $(function(){
                $("#article-modal-dialog").dialog({
                    autoOpen: false,
                    height: 400,
                    width: 500,
                    modal: true,
                    show: "clip",
                    hide: "clip"
                });
            });
        	</script>
		</div>
		<div id="events">
			<script>
			$(function(){
				var event_name = $( "#event_name" ),
					event_caption = $( "#event_caption" ),
					event_date = $( "#event_date" ),
					event_about = $( "#event_about" ),
			      	event_rules = $("#event_rules"),
			      	allFields = $( [] ).add( event_name ).add( event_date ).add( event_about ).add( event_rules ),
			      	tips = $( ".validateTips" );

				function updateTips( t ) {
				      tips
				        .text( t )
				        .addClass( "ui-state-highlight" );
				      setTimeout(function() {
				        tips.removeClass( "ui-state-highlight", 1500 );
				      }, 500 );
				}
				 
				function checkLength( o, n, min, max ) {
					if ( o.val().length > max || o.val().length < min ) {
						o.addClass( "ui-state-error" );
						updateTips( "Length of " + n + " must be between " + min + " and " + max + "." );
						return false;
					} else {
						return true;
					}
				}
			 	
				$( "#dialog-form" ).dialog({
			      autoOpen: false,
			      height: 600,
			      width: 500,
			      modal: true,
			      buttons: {
			        "Create Event": function() {
			          var bValid = true;
			          //allFields.removeClass( "ui-state-error" );
			 		  
			          bValid = bValid && checkLength( event_name, "event_name", 2, 48 );
			          bValid = bValid && checkLength( event_caption, "event_caption", 2, 128);
			          bValid = bValid && checkLength( event_about, "event_about", 6, 512 );
			          bValid = bValid && checkLength( event_rules, "event_rules", 6, 512 );
			          
			          if ( bValid ) {
			        	$.post("http://localhost/apricot/index.php/events/create/done",
			        	{
			        		name : event_name.val(), 
			        		slogan : event_caption.val(),
			        		date : event_date.val(),
			        		about: event_about.val(), 
			        		rules: event_rules.val()
			        	})
			        	.done( function(done) { $('#events_table').flexReload(); });
			        	
			          	$( this ).dialog( "close" );
			          }
			        },
			        Cancel: function() {
			          $( this ).dialog( "close" );
			        }
			      },
			      close: function() {
			        allFields.val( "" ).removeClass( "ui-state-error" );
			      },
                  show: "clip",
                  hide: "clip"
			    });
			 	
			});
			</script>
			<div id="dialog-form" title="Create a new Event.">
				<p class="validateTips">All form fields are required.</p>

				<form>
					<fieldset>
						<label for="event_name" class="jqui-form-label">Event Name</label>
						<input type="text"
							name="event_name" id="event_name"
							class="text ui-widget-content ui-corner-all" />
						<label for="event_caption" class="jqui-form-label">Event Caption</label>
						<input type="text"
							name="event_caption" id="event_caption"
							class="text ui-widget-content ui-corner-all" />
						<label for="event_date" class="jqui-form-label">Event Date</label>
						<input type="date"
							name="event_date" id="event_date"
							class="ui-widget-content ui-corner-all" />
						<label for="event_about" class="jqui-form-label">About</label>
						<textarea type="text" name="event_about" id="event_about" maxlength=512 cols=48
							class="text ui-widget-content ui-corner-all"></textarea>

						<label for="event_rules" class="jqui-form-label">Rules</label>
						<textarea type="text" name="event_rules" id="event_rules" maxlength=512 cols=48
							class="text ui-widget-content ui-corner-all"></textarea>
					</fieldset>
				</form>
			</div>
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
	            buttons : [ {name: 'New Event', bclass: 'flexigrid-menu-button', onpress: openCreateEventForm},
	        	            {name: 'Activate User', bclass: 'flexigrid-menu-button', onpress : activateEventAction},
	                        {name: 'Deactivate User', bclass: 'flexigrid-menu-button', onpress : deactivateEventAction} ]
            });


            function activateEventAction(){
            	var grid = $('#events_table');
            	var eid = $('.trSelected td:nth-child(1) div', grid).text();

				if(eid == ""){
					alert("No cell selected");
					return;
				}
            	
            	$.get("event_action/activate/"+eid);
            	grid.flexReload();
            }
            
            function deactivateEventAction(){
                var grid = $('#events_table');
            	var eid = $('.trSelected td:nth-child(1) div', grid).text();

				if(eid == ""){
					alert("No cell selected");
					return;
				}
            	
            	$.get("event_action/deactivate/"+eid);
            	grid.flexReload();
            }

            function openCreateEventForm(){
            	$( "#dialog-form" ).dialog( "open" );
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
