<?php get_header(); ?>
<?php global $is_home; ?>
 	
    <div id="content" class="content_inner" > 
            
           <?php if ( get_option( 'ptthemes_breadcrumbs' )) { yoast_breadcrumb('<div class="breadcrumb">','</div>'); } ?>

             <h1 class="cat_head" ><span><?php the_title(); ?></span></h1>
                			 
                   
 		<?php if(have_posts()) : ?>
			<?php while(have_posts()) : the_post() ?>
            		<?php $pagedesc = get_post_meta($post->ID, 'pagedesc', $single = true); ?>
            
        
                    <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                        <div class="entry"> 
                            <?php the_content(); ?>
                        </div>
                    </div><!--/post-->
                
            <?php endwhile; else : ?>
        
                    <div class="posts">
                        <div class="entry-head"><h2><?php echo get_option('ptthemes_404error_name'); ?></h2></div>
                        <div class="entry-content"><p><?php echo get_option('ptthemes_404solution_name'); ?></p></div>
                    </div>
        
        <?php endif; ?>
        
	   
      </div> <!-- content #end -->
        
        
		    <?php get_sidebar(); ?>
          
          
<?php get_footer(); ?>