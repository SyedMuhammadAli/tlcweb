<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US">
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>TLC | The Literary Club</title>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<!-- End. fb like box ecript -->
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
									<!---- Slider Start ---------->
									<div id="featured" class="flexslider et_slider_auto et_slider_speed_7000">
										<?php echo anchor('#','Previous',array('id'=>'left-arrow')); ?>
										<?php echo anchor('#','Next',array('id'=>'right-arrow')); ?>
										<ul class="slides">
											<li class="slide">
												<?php echo img(array('src' =>'uploads/screen1.jpg', 'width'=>'960px', 'height'=>'340px'));?>				
           										<div class="featured-top-shadow"></div>
												<div class="featured-bottom-shadow"></div>	
											</li> <!-- end .slide -->
											<li class="slide">
												<?php echo img(array('src' =>'uploads/screen2.jpg', 'width'=>'960px', 'height'=>'340px'));?>
           										<div class="featured-top-shadow"></div>
												<div class="featured-bottom-shadow"></div>	
											</li> <!-- end .slide -->
											<li class="slide">
												<?php echo img(array('src' =>'uploads/screen3.jpg', 'width'=>'960px', 'height'=>'340px'));?>				
        										<div class="featured-top-shadow"></div>
												<div class="featured-bottom-shadow"></div>	
											</li> <!-- end .slide -->
											<li class="slide">
												<?php echo img(array('src' =>'uploads/screen4.jpg', 'width'=>'960px', 'height'=>'340px'));?>				
       	 										<div class="featured-top-shadow"></div>
												<div class="featured-bottom-shadow"></div>	
											</li> <!-- end .slide -->
											<li class="slide">
												<?php echo img(array('src' =>'uploads/screen5.jpg', 'width'=>'960px', 'height'=>'340px'));?>				
        										<div class="featured-top-shadow"></div>
												<div class="featured-bottom-shadow"></div>	
											</li> <!-- end .slide -->
											<li class="slide">
												<?php echo img(array('src' =>'uploads/screen6.jpg', 'width'=>'960px', 'height'=>'340px'));?>				
           										<div class="featured-top-shadow"></div>
												<div class="featured-bottom-shadow"></div>	
											</li> <!-- end .slide -->
											<li class="slide">
												<?php echo img(array('src' =>'uploads/screen7.jpg', 'width'=>'960px', 'height'=>'340px'));?>				
           							 			<div class="featured-top-shadow"></div>
												<div class="featured-bottom-shadow"></div>	
											</li> <!-- end .slide -->
											<li class="slide">
												<?php echo img(array('src' =>'uploads/screen8.jpg', 'width'=>'960px', 'height'=>'340px'));?>				
            									<div class="featured-top-shadow"></div>
												<div class="featured-bottom-shadow"></div>	
											</li> <!-- end .slide -->
										</ul> <!-- end .slides -->
									</div> <!-- end #featured -->

									<div id="controllers" class="clearfix">
										<ul>
											<li>
												<div class="controller">
												<a href="#" class="active">
                									<?php echo img(array('src' =>'uploads/screen1-icon.jpg', 'width'=>'95px', 'height'=>'54px'));?>
													<span class="overlay"></span>
												</a>
												</div>	
											</li>
											<li>
												<div class="controller">
												<a href="#">
                									<?php echo img(array('src' =>'uploads/screen2-icon.jpg', 'width'=>'95px', 'height'=>'54px'));?>						
                    								<span class="overlay"></span>
												</a>
												</div>	
											</li>
											<li>
												<div class="controller">
												<a href="#">
                									<?php echo img(array('src' =>'uploads/screen3-icon.jpg', 'width'=>'95px', 'height'=>'54px'));?>					
                    								<span class="overlay"></span>
												</a>
												</div>	
											</li>
											<li>
												<div class="controller">
												<a href="#">
                								<?php echo img(array('src' =>'uploads/screen4-icon.jpg', 'width'=>'95px', 'height'=>'54px'));?>                    			  				<span class="overlay"></span>
                                                </a>
                                                </div>	
                                            </li>
                                            <li>
                                                <div class="controller">
                                                <a href="#">
                                                	<?php echo img(array('src' =>'uploads/screen5-icon.jpg', 'width'=>'95px', 'height'=>'54px'));?>
                                                    <span class="overlay"></span>
                                                </a>
                                                </div>	
                                            </li>
                                            <li>
                                                <div class="controller">
                                                <a href="#">
                                                   	<?php echo img(array('src' =>'uploads/screen6-icon.jpg', 'width'=>'95px', 'height'=>'54px'));?>
                                                  	<span class="overlay"></span>
                                                </a>
                                                </div>	
                                            </li>
                                            <li>
                                                <div class="controller">
                                                <a href="#">
                                                  	<?php echo img(array('src' =>'uploads/screen7-icon.jpg', 'width'=>'95px', 'height'=>'54px'));?>
                                                   	<span class="overlay"></span>
                                                </a>
                                               	</div>	
                                            </li>
                                            <li>
                                                <div class="controller">
                                                <a href="#">
                                                   	<?php echo img(array('src' =>'uploads/screen8-icon.jpg', 'width'=>'95px', 'height'=>'54px'));?>
                                                    <span class="overlay"></span>
                                                </a>
                                                </div>	
                                            </li>
                                        </ul>
                                       	<div id="active_item"></div>
                                  	</div> <!-- end #controllers -->
									<div class="clear"></div>
<!-----------------------Slider Ends --------------------------------->
									<div id="main-content" class="clearfix">
                                        <div id="left-area">
                                            <h4 class="main-title"><?php echo "Most Recent Articles"?></h4>
                                            <div id="entries">
                                                 <?php foreach($records->result() as $blogpost): ?>
                                                    <div class="post entry clearfix latest">
                                                        <h3 class="title"><?php echo anchor("home/showtopic/{$blogpost->post_id}", $blogpost->title); ?></h3>
                                                        <p class="meta-info"><?php echo "Posted  by" ?> <?php echo anchor('home/profile/'.$blogpost->user_id, $blogpost->usr); ?><?php echo " ".date("F j, Y, g:i a", strtotime($blogpost->time)); ?>| <?php echo anchor("home/showtopic/{$blogpost->post_id}", "Comments");?></p>
                                                        <p><?php echo $blogpost->post; ?></p>
                                                         <?php echo anchor("home/showtopic/{$blogpost->post_id}","<span>Read More</span>",array('class'=>'more'));?>
                                                    </div> 	<!-- end .post-->
                                                <?php endforeach; ?>
                                                <div class='wp-pagenavi'>
                                                    <?php echo $page_links; ?>
                                                </div>		
                                            </div> <!-- end #entries -->
                                        </div> <!-- end #left-area -->
                                        <div id="sidebar">
                                            <?php if(!$is_logged_in): ?>
                                            <div id="loginForm">
                                                <h4 class="main-title widget-title"><?php echo "Login Here" ?></h4>
                                                <div class="widget">
                                                        <?php echo form_open("home/login"); ?>
                                                        <p><?php echo form_input("username", set_value("username", "Username")); ?></p>
                                                        <p><?php echo form_password("password", set_value("password", "Password")); ?></p>
                                                        <span><?php echo form_submit("submit", "Login"); ?></span>
                                                        <?php echo form_close(); ?>
                                                </div><!--end.widgit-->          				
                                            </div><!--end.login-->
                                            <?php endif; ?>
                                            <?php if($is_logged_in): ?>
                                            <h4 class="main-title widget-title"><?php echo"Stats"?></h4>
                                            <div class="widget">
                                                <p><?php echo "Members:  ".$total_members; ?></p>
                                                <p><?php echo "Threads:  ".$total_threads; ?></p>
                                                <p><?php echo "Comments: ".$total_comments; ?></p>
                                            </div> <!-- end .widget -->
                                            <?php endif; ?>
                                            
                                            <h4 class="main-title widget-title"><?php echo "Upcoming Event"?></h4>
                                            <div class="widget">	
                                                <p><?php echo anchor("events/view/{$event_id}", $event_name); ?></p>
                                                <p><?php echo $event_countdown_timer; ?></p>
                                                <p>
                                                	<h4>
                                                	<?php if($registration_allowed) echo anchor("events/register/{$event_id}","Register Now"); ?>
                                                	</h4>
                                                </p>
                                                <div class="adwrap">
                                                    <?php echo img(array('href'=>'#','target'=>'_blank','src'=>'uploads/zauq_standee_dark.png','alt'=>'advertisement','title'=>'Next Event'))?>
                                                </div> <!-- end adwrap -->
                                            </div> <!-- end .widget -->	
											<h4 class="main-title widget-title"><?php echo "Like Here"?></h4>
											<div class="widget">
												<div class="fb-like-box" data-href="https://www.facebook.com/TLCFAST" data-width="210" data-show-faces="true" data-stream="false" data-header="true"></div>
											</div><!--end .widget -->
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
		<?php include("footer.php"); ?>
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
<!-- Performance optimized by W3 Total Cache. Learn more: http://www.w3-edge.com/wordpress-plugins/

Database Caching 25/77 queries in 0.019 seconds using disk: basic

Served from: www.elegantthemes.com @ 2012-06-05 07:36:29 -->