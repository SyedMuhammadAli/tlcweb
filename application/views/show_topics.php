<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US">
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php echo $title ?></title>
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
<body>
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
                                    	<?php include("menu.html"); ?>								
									</div> <!-- end #second-menu -->
                              	<div id="main-content" class="clearfix">
                                    	<div id="left-area">
                                            <div id="breadcrumbs">
                                            <?php echo anchor('home/index', "<< Home"); ?>
                                            </div> <!-- end #breadcrumbs -->		
                                            <div id="entries">	
                                                <div class="entry post clearfix">
                                                    <h1 class="title"><?php echo $post['title'];?></h1>
                                                    <div class="post-meta">
                                                        <p class="meta-info">
                                                        <?php echo "Posted  by "?><?php echo anchor('home/profile/'.$post['author_id'],$post['author_id']);?>
                                                   <?php echo date("F j, Y, g:i a", strtotime($post['time']));?>
                                                        </p>
                                                    </div> <!-- end .post-meta -->
                                                    <!-- 
                                                    <div class="thumb">
                                                        <?php //echo img(array('src'=>'uploads/ad-2-post.gif','class'=>'single-thumb','width'=>'200px', 'height' => '200px','alt'=>'Profile Photo'))?>
                                                        
                                                    </div> 	<!-- end .thumb -->
                                                     -->
                                                    <p><?php echo $post['post']; ?></p>
                                                    <p>&nbsp;</p>
                                                </div> <!-- end .entry -->
                                    
                                            <!-- You can start editing here. -->
                                    
                                                <div id="comment-wrap" class="clearfix">
                                                    <h3 id="comments" class="main-title"><?php echo "Comments"?></h3>
                                                    <ol class="commentlist clearfix">
                                                        <?php foreach($comments->result() as $comment): ?>
                                                        <li class="comment byuser comment-author-admin bypostauthor even thread-even depth-1" id="li-comment-708">
                                                            <div class="comment-body">
                                                                <div id="comment-708" class="clearfix">
                                                                    <div class="avatar-box">
                                                                        <?php echo img(array('src'=>'uploads/ad-2-comment.gif', 'class'=>'avatar avatar-67 photo', 'height'=>'67', 'width'=>'67'));?>
                                                                        <span class="avatar-overlay"></span>
                                                                    </div> <!-- end .avatar-box -->
                                                                    <div class="comment-wrap">
                                                                        <div class="comment-meta commentmetadata"><span class="fn"><?php echo anchor("home/profile/".$comment->profile_id, $comment->author);?>
                                                                        </span><?php echo "/"?>
                                                                        <span class="comment-date"><?php echo date("F j, Y, g:i a", strtotime($comment->time));?></span> 
                                                                    </div>
                                                                        <div class="comment-content">
                                                                            <p><?php echo $comment->text;?></p>
                                                                        </div> <!-- end comment-content-->
                                                                    </div> <!-- end comment-wrap-->
                                                                    <div class="comment-arrow"></div>
                                                                </div> <!-- end comment-body-->
                                                            </div> <!-- end comment-body-->
                                                        </li>
                                                        <?php 
                                                            endforeach; 
                                                            echo $page_links;
                                                        ?>
                                                    </ol>
                                                    <div id="respond">
                                                        <h3 id="reply-title"><?php echo "Leave a Comment" ?></h3>
                                                        <?php
                                                            if($is_logged_in){
                                                                echo form_open('members/comment',array('id'=>'commentform'));
                                                                echo form_textarea("text", set_value("text", "Add some text here..."));
                                                                echo form_hidden("thread_id", $post['id']);
                                                                echo form_submit("submit", "Comment");
                                                                echo form_close();
                                                            } else {
                                                                echo "<h4>You must be logged in to comment.</h4>";
                                                            }
                                                        ?>
                                                    </div><!-- #respond -->
                                                </div>	<!-- end comment-wrap -->
                                            </div> <!-- end #entries -->	
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