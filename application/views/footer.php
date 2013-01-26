<div id="footer-top-shadow" class="clearfix">
			<div class="container">
				<div id="footer-widgets" class="clearfix">
					<div id="recent-posts-7" class="footer-widget widget_recent_entries">		
                        <h4 class="widgettitle"><?php echo "Recent Posts" ?></h4>		
                        <ul>
                           	<?php //foreach($records->result() as $blogpost): ?>
                           	<li><?php //echo anchor("home/showtopic/{$blogpost->post_id}", "$blogpost->title");?></li>
                           	<?php //endforeach; ?>
						</ul>
					</div><!--end.recent-posts-7-->
      	            <div id="recent-comments-7" class="footer-widget widget_recent_comments"><h4 class="widgettitle"><?php echo "Recent Comments" ?></h4>
                       	<ul id="recentcomments">
                           	<li>Comment 1</li>
                           	<li>Comment 2</li>
                            <li>Comment 3</li>
                            <li>Comment 4</li>
                            <li>Comment 5</li>
                            <li>Comment 6</li>
         				</ul>
         			</div><!--end.recent-posts-7->
         		</div> <!-- end .footer-widget -->
        		<p id="copyright">Developed by TLC WebDev Dept.</p>
           	</div> <!-- end .container -->
		</div> <!-- end #footer-top-shadow -->
		<div id="footer-bottom-shadow"></div>
		<div id="footer-bottom">
			<div class="container clearfix">
				<ul id="bottom-nav" class="bottom-nav">
                	<li><?php echo anchor('home','Home');?></li>
                	<li><?php echo anchor('home/#', 'Member Login')?>
                    <li><?php echo anchor('home/contact','Contact Us');?></li>
                    <li><?php echo anchor('home/about','About Us');?></li>
                    <li><?php echo anchor('#sitemap','Sitemap');?></li>
				</ul>			
          	</div> <!-- end .container -->
		</div> <!-- end #footer-bottom -->