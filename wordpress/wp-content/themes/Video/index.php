<?php
/*
  Template Name: Home Page
 */
?>
<?php get_header(); ?>

<div id="banner_section" class="row">

    <div id="slider" class="col-md-9 col-sm-12">
        <?php dynamic_sidebar(1); ?>  
    </div>



    <div class="advertisement col-md-3 col-sm-12">
        <?php dynamic_sidebar(2); ?>  
    </div> <!-- advertisement #end -->

</div>

<div class="row">
    <div id="content" class="col-md-9 clearfix">

        <?php dynamic_sidebar(3); ?>  

    </div> <!-- content #end -->
    <div class="col-md-3">       
        <?php get_sidebar(); ?>
    </div>  <!-- side_bar #end -->
</div>
<?php get_footer(); ?>