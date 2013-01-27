<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US">
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>TLC | The Literary Club</title>
<!------Slider Stylesheets -->

<!-- End. Slider Stylesheets -->
<?php echo link_tag(array('href' => 'css/style.css', 'rel' => 'stylesheet', 'type' => 'text/css', 'media' => 'screen' )); ?>
<?php echo link_tag(array('href' => 'css/colorpicker.css', 'rel' => 'stylesheet', 'type' => 'text/css', 'media' => 'screen' )); ?>
<?php echo link_tag(array('href' => 'css/responsive.css', 'rel' => 'stylesheet', 'type' => 'text/css', 'media' => 'screen' )); ?>

<?php echo link_tag(array('href' => 'http://fonts.googleapis.com/css?family=Droid+Sans:regular,bold', 'rel' => 'stylesheet', 'type' => 'text/css')); ?>
<?php echo link_tag(array('href' => 'http://fonts.googleapis.com/css?family=Kreon:light,regular', 'rel' => 'stylesheet', 'type' => 'text/css')); ?>

<!--[if lt IE 7]>
	<link rel="stylesheet" type="text/css" href="http://www.elegantthemes.com/preview/Aggregate/wp-content/themes/Aggregate/css/ie6style.css" />
	<script type="text/javascript" src="../../js/DD_belatedPNG_0.0.8a-min.js"></script>
	<script type="text/javascript">DD_belatedPNG.fix('img#logo, span.overlay, a.zoom-icon, a.more-icon, #menu, #menu-right, #menu-content, ul#top-menu ul, #menu-bar, .footer-widget ul li, span.post-overlay, #content-area, .avatar-overlay, .comment-arrow, .testimonials-item-bottom, #quote, #bottom-shadow, #quote .container');</script>
<![endif]-->
<!--[if IE 7]>
	<link rel="stylesheet" type="text/css" href="http://www.elegantthemes.com/preview/Aggregate/wp-content/themes/Aggregate/css/ie7style.css" />
<![endif]-->
<!--[if IE 8]>
	<link rel="stylesheet" type="text/css" href="http://www.elegantthemes.com/preview/Aggregate/wp-content/themes/Aggregate/css/ie8style.css" />
<![endif]-->

<script type="text/javascript">
	document.documentElement.className = 'js';
</script>

<meta name='robots' content='noindex,nofollow' />
<meta content="Aggregate v.2.2" name="generator"/>
<?php echo link_tag(array('href' => 'css/shortcodes.css', 'rel' => 'stylesheet', 'id' => 'et-shortcodes-css-css', 'type' => 'text/css', 'media' => 'all' )); ?>
<?php echo link_tag(array('href' => 'css/pagenavi-css.css', 'rel' => 'stylesheet', 'id' => 'wp-pagenavi-css', 'type' => 'text/css', 'media' => 'all' )); ?>
<?php echo link_tag(array('href' => 'css/jquery.fancybox-1.3.4.css', 'rel' => 'stylesheet', 'id' => 'fancybox-css', 'type' => 'text/css', 'media' => 'screen' )); ?>
<?php echo link_tag(array('href' => 'css/page_templates.css', 'rel' => 'stylesheet', 'id' => 'et_page_templates-css', 'type' => 'text/css', 'media' => 'screen' )); ?>

<?php echo script_tag('js/jquery.js');?>
<?php echo script_tag('js/jquery.cycle.all.min.js');?>
<?php echo script_tag('js/et_shortcodes_frontend.js');?>
</head>
<body class="home blog chrome">
	<div id="top-header">
		<div id="top-shadow"></div>
		<div id="bottom-shadow"></div>
	</div> <!-- end #top-header -->

	<div id="content-area">
		<div id="content-top-light">
			<div id="top-stitch"></div>
			<div class="container">
				<div id="logo-area">
                	<?php echo img(array('src'=>'images/logo.png', 'alt' => 'Logo', 'href'=>'http://www.tlc.net46.net','id'=>'logo'));?>
					<p id="slogan">Welcome To The Literary Club</p>
				</div> <!-- end #logo-area -->
				<div id="content">
					<div id="inner-border">
						<div id="content-shadow">
							<div id="content-top-shadow">
								<div id="content-bottom-shadow">
									<div id="second-menu" class="clearfix">										
                                    	<?php include("menu.php"); ?>							
									</div> <!-- end #second-menu -->
                             	<div id="main-content" class="clearfix">
                                	<div id="left-area">
                                    	<h1 class="main-title"><?php echo $title?></h1>
                                        <div class="validation_errors"><h5><?php if(isset($validation_errors)){ echo "Vadidation Errors: {$validation_errors}"; } ?></h5></div>
										<div id="profile">
											<?php
                                                echo form_open("events/register/{$event_id}");
                                        
                                                echo "<p>Team Name: " . form_input("team_name", set_value("team_name", "Team's Name")) . "</p>";
                                                echo "<p>Contact: " . form_input("contact", set_value("contact", "Contact Number")) . "</p>";
                                                echo "<p>Alt Contact: " . form_input("alt_contact", set_value("alt_contact", "Alternate Conact Number")) . "</p>";
                                                echo "<p>Email: " . form_input("email", set_value("email", "user@host.com")) . "</p>";
                                                echo "<p>Participants: " . form_input("participants_name", set_value("participants_name", "Name, Name2, Name3, ...")) . "</p>";
                                                echo "<p>Select Institute: " . form_dropdown("inst_id", $institute_array)."</p>";
                                                                                             
												echo "<p>" . form_submit("submit", "Done") . "</p>";
												
                                                
                                                echo form_close();
                                            ?>
                                            
                                    	</div>
									</div><!-- end left area -->
                                    <div id="sidebar">
                             		</div> <!-- #sidebar -->
                                    </div> <!-- end #main-content -->
								</div> <!-- end #content-bottom-shadow -->
							</div> <!-- end #content-top-shadow -->
						</div> <!-- end #content-shadow -->
					</div> <!-- end #inner-border -->
				</div> <!-- end #content -->
			</div> <!-- end .container -->
		</div> <!-- end #content-top-light -->
		<div id="bottom-stitch"></div>
	</div> <!-- end #content-area -->
	<div id="footer">
		<div id="footer-top-shadow" class="clearfix">
			<div class="container">
				<div id="footer-widgets" class="clearfix">
					
      	            <div id="recent-comments-7" class="footer-widget widget_recent_comments"><h4 class="widgettitle"><?php echo "Recent Comments" ?></h4>
                       	<ul id="recentcomments">
                           	<li>Comment 1</li>
                           	<li>Comment 2</li>
                            <li>Comment 3</li>
                            <li>Comment 4</li>
                            <li>Comment 5</li>
                            <li>Comment 6</li>
         				</ul>
         			</div><!--end.recent-posts-7-->
					
         		</div> <!-- end .footer-widget -->
        		<p id="copyright"><?php echo "Designed and Developed by Tulsi Das and Syed Muhammad Ali" ?> </p>
           	</div> <!-- end .container -->
		</div> <!-- end #footer-top-shadow -->
		<div id="footer-bottom-shadow"></div>
		<div id="footer-bottom">
			<div class="container clearfix">
				<ul id="bottom-nav" class="bottom-nav">
                	<li><?php echo anchor('home','Home');?></li>
                    <li><?php echo anchor('https://www.facebook.com/TLCFAST','FB Page');?></li>
                    <li><?php echo anchor('home/contact','Contact Us');?></li>
                    <li><?php echo anchor('home/about','About Us');?></li>
                    <li><?php echo anchor('http://maps.google.com/maps?f=q&source=embed&hl=en&geocode=&q=nuces+karachi&sll=37.0625,-95.677068&sspn=33.214763,79.013672&ie=UTF8&hq=nuces&hnear=Karachi,+Sindh,+Pakistan&cid=5544500434171878748&ll=24.856846,67.264652&spn=0.046728,0.051498&z=13&iwloc=A','Sitemap');?></li>
                    <li><?php echo anchor('home','Advanced Search');?></li>
				</ul>			
          	</div> <!-- end .container -->
		</div> <!-- end #footer-bottom -->
	</div> <!-- end #footer -->
	
	<?php echo script_tag('js/superfish.js');?>
    <?php echo script_tag('js/custom.js');?>	     
	<script type="text/javascript"> 
		var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
		document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
	</script> 
	<script type="text/javascript"> 
		var pageTracker = _gat._getTracker("UA-5205247-2");
		pageTracker._trackPageview();
	</script> 
 
	<?php
		echo script_tag('js/jquery.easing.1.3.js');
		echo script_tag('js/colorpicker.js');
		echo script_tag('js/jquery.cookie.js');
		echo script_tag('js/et_control_panel.js');
		echo script_tag('js/jquery.fitvids.js');
		echo script_tag('js/jquery.flexslider-min.js');
		echo script_tag('js/et_flexslider.js');
		echo script_tag('js/jquery.fancybox-1.3.4.pack.js');
		echo script_tag('js/et-ptemplates-frontend.js');
	?>

</body>
</html>	
</body>
</html>