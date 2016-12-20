<?php
/*
Template Name: Home Page
*/
?>
<?php get_header(); ?>

	<div id="banner_section">

        <div id="slider">
        	<?php dynamic_sidebar(1);  ?>  
        </div>
       
    
    
    	<div class="advertisement">
        	<?php dynamic_sidebar(2);  ?>  
        </div> <!-- advertisement #end -->
        
    </div>
 

               <div id="content" class="clearfix">
               		
                      <?php dynamic_sidebar(3);  ?>  
                          
               </div> <!-- content #end -->
                     
           <?php get_sidebar(); ?>
  
<?php  get_footer(); ?>