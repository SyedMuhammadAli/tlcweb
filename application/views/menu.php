<ul id="secondary-menu" class="nav">
	<li>
		<?php echo anchor("home", "Home");?>
	</li>
	<li>
		<?php echo anchor("events/index", "Events"); ?>
		<ul class="sub-menu">
			<?php if($is_logged_in):?>
			<li>
				<?php //echo anchor("events/create","Create Event");?>
			</li>
			<?php endif?>
			<li>
				<?php echo anchor("events/timeline/future","Upcoming Events");?>
			</li>
			<li>
				<?php echo anchor("events/timeline/past","Past Events");?>
			</li>
		</ul>
	</li>
	<?php if(!$is_logged_in):?>
	<li>
		<?php /*echo anchor("home/signup", "Register");*/?>
	</li>
	<?php endif ?>
	<li>
		<?php echo anchor("home/contact", "Contact Us"); ?>
	</li>
	<li>
		<?php echo anchor("home/about", "About Us"); ?>
	</li>
	<?php if($is_logged_in){
          	  echo "<li>".anchor("members/", "Account Settings")."</li>";
              echo "<li>".anchor("home/logout", "Logout")."</li>";
     }
    ?>
</ul>
