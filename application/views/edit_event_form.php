<!DOCTYPE html>

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 
	<title><?php echo $title; ?></title>
</head>
<body>
	<div id="create_event">
	
	<?php
		echo form_open("events/edit/{$event_id}/done");
		
		echo "<p>Name: " . form_input("name", set_value("Event Name", $name)) . "</p>";
		
		sscanf(date("m j Y", $event_date), "%d %d %d", $month, $day, $year);
		
		echo "<p>" .
			 "Event Date: " .
			 "Day: " . form_input("day", set_value("day", $day)) .
			 "Month: " . form_input("month", set_value("month", $month)) .
			 "Year: " . form_input("year", set_value("year", $year)) .
			 "</p>";
		
		echo "<p>About: " . form_textarea("about", set_value("about", $about)) . "</p>";
		echo "<p>Rules: " . form_textarea("rules", set_value("rules", $rules)) . "</p>";

		echo form_submit("submit", "Edit Event");
		
		echo form_close();
	?>
	
	<h3><?php if(isset($error)){ echo $error; } ?></h3>
	
	</div>
</body>
</html>	