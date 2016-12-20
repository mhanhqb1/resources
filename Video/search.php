<?php get_header(); ?>
 

    <?php if (is_paged()) $is_paged = true; ?>
 
        		<div id="content" class="content_index clearfix">
              	
                 <?php if ( get_option( 'ptthemes_breadcrumbs' )) { yoast_breadcrumb('<div class="breadcrumb">','</div>'); } ?>

    			 <?php if (is_search()) { ?>
                    <h1 class="cat_head" ><?php _e('Search Result','templatic'); ?> "<?php printf(__('%s','templatic'), $s) ?>"</h1>
                    <?php } ?>
                      
            
<ul class="news_list">


			<?php if(have_posts()) : ?>
 			<?php while(have_posts()) : the_post() ?>
              <?php $post_images = bdw_get_images($post->ID,'large');?>
        
                  
                <li class="clearfix"  id="post-<?php the_ID(); ?>" > 
                
                <p class="date"><?php the_time('j F Y') ?> at <?php the_time('H : s A') ?></p>
                <h3> <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3> 
                 <p class="postedby clearfix">
				<span class="author" >Posted by <?php the_author_posts_link(); ?> in  <?php the_category(" , "); ?> </span>
                
               <a href="<?php the_permalink(); ?>#commentarea" class="pcomments" ><?php comments_number('0', '1', '%'); ?> </a> </p>
                
                
            	<?php if($post_images[0]){ global $thumb_url;?>
                 <?php
					$img_size = bdw_get_images_with_info($post->ID,'listing-thumb');
					$post_images = $img_size[0]['file'];
				?>
                   <a class="widget-title" href="<?php the_permalink(); ?>"><img src="<?php echo $post_images;?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>"  /> </a>  
            <?php }?>
            		
                    <p> <?php echo excerpt(360); ?> </p>
                    
                    
                    <a href="<?php the_permalink(); ?>" class="more" > Read More </a> 
                   
            	 </li>
                            
                  
                
             
      <?php endwhile; ?>
      
      </ul>
      
      
      <div class="pagination">
        <?php if (function_exists('wp_pagenavi')) { ?>
        <?php wp_pagenavi(); ?>
        <?php } ?>
      </div>
      <?php endif; ?>
			 
      </div> <!-- content #end -->
        
        
		 <?php get_sidebar(); ?>
		
<?php get_footer(); ?>
