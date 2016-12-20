</div> <!-- wrapper #end -->
<div id="bottom" class="clearfix">
    <div class="first_col"><?php dynamic_sidebar(9);  ?></div>
    <div class="second_col fl"><?php dynamic_sidebar(10);  ?></div>
    <div class="common fl"><?php dynamic_sidebar(11);  ?></div>
     <div class="common fl"><?php dynamic_sidebar(12);  ?></div>
     <div class="common fr"><?php dynamic_sidebar(13);  ?></div>
</div>  
<div id="footer" class="clearfix">
<p class="copy">&copy; <?php echo date('Y'); ?> <?php bloginfo(); ?>  All rights reserved.</p>
<p class="fr"><span class="designby">Designed by </span>  
<span class="templatic"> <a href="http://templatic.com" alt="wordpress themes" title="wordpress themes"><strong>Wordpress Themes</strong></a>  </span></p>	
<a href="http://templatic.com" alt="wordpress themes" title="wordpress themes"></a>
</div> <!-- footer #end -->
</div>
<script src="<?php echo get_template_directory_uri(); ?>/library/js/jquery.helper.js" type="text/javascript" ></script>
<?php wp_footer(); ?><?php if ( get_option('ptthemes_google_analytics') <> "" ) { echo stripslashes(get_option('ptthemes_google_analytics')); } ?>
</body></html>