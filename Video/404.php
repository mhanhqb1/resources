<?php get_header(); ?>

   <div id="content" class="clearfix">
            
             <?php if ( get_option( 'ptthemes_breadcrumbs' )) { yoast_breadcrumb('<div class="breadcrumb">','</div>'); } ?>

             <h1 class="cat_head" ><?php echo get_option('ptthemes_404error_name'); ?></h1>
             
             	<h1> 404 Error !</h1>
             
	    
		
	
		  <div class="cat-spot"><p><?php echo get_option('ptthemes_404solution_name'); ?></p></div>
 		
 </div> <!-- content  #end -->
         
		 <?php get_sidebar(); ?>
    
 <?php get_footer(); ?>
