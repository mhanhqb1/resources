<?php get_header(); ?>
 <div id="content" class="clearfix">

 <?php if ( get_option( 'ptthemes_breadcrumbs' )) { yoast_breadcrumb('<div class="breadcrumb">','</div>'); } ?>
    
    <?php 
	global $wp_query, $post;
	$current_term = $wp_query->get_queried_object();	
	
	if (is_category()) { ?>
			<h1 class="cat_head"  ><?php echo get_option('ptthemes_browsing_category'); ?><?php echo single_cat_title(); ?></h1>  

			<?php } elseif (is_day()) { ?>
			<h1 class="cat_head" ><?php echo get_option('ptthemes_browsing_day'); ?><?php the_time('F jS, Y'); ?> </h1>

			<?php } elseif (is_month()) { ?>
			<h1  class="cat_head" ><?php echo get_option('ptthemes_browsing_month'); ?><?php the_time('F, Y'); ?> </h1>

			<?php } elseif (is_year()) { ?>
			<h1  class="cat_head" ><?php echo get_option('ptthemes_browsing_year'); ?><?php the_time('Y'); ?> </h1>
			
			<?php } elseif (is_author()) { ?>
			<h1  class="head"><?php echo get_option('ptthemes_browsing_author'); ?><?php echo $curauth->nickname; ?> </h1>
							
			<?php } elseif (is_tag()) { ?>
			<h1 class="cat_head" ><?php echo get_option('ptthemes_browsing_tag'); ?><?php echo single_tag_title('', true); ?> </h1>
 			<?php } ?>
	
	 <ul class="categories_list">
                    	
     <?php if(have_posts()) : ?>
     <?php  $pcount=0; while (have_posts()) : the_post();  $pcount++; ?>
      <?php $post_images = bdw_get_images($post->ID,'large');?>
       	
        
        	<li class="clearfix"> 
                
                <?php 
            if(get_the_post_thumbnail( $post->ID, array())){?>
             <a class="video_thumb" href="<?php echo get_permalink($post->ID) ?>" rel="bookmark" title="<?php the_title(); ?>">
             <?php echo get_the_post_thumbnail( $post->ID, array(125,102),array('class'	=> "",));?>
             
             <?php if(get_post_meta($post->ID,'time',true)){?>
                  <span class="time"> <?php echo get_post_meta($post->ID,'time',true);?> </span>
             <?php }?> 
             
             </a>
            <?php }else if($post_images[0]){ global $thumb_url;
            ?>
             <a class="video_thumb" href="<?php echo get_permalink($post->ID) ?>" rel="bookmark" title="<?php the_title(); ?>">
             <?php
				$img_size = bdw_get_images_with_info($post->ID,'video-thumb');
				$post_images = $img_size[0]['file'];
	       ?>
             <img src="<?php echo $post_images;?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>"  /> 
             <?php if(get_post_meta($post->ID,'time',true)){?>
                  <span class="time"> <?php echo get_post_meta($post->ID,'time',true);?> </span>
             <?php }?> 
             </a>
            <?php
            } else { ?> 
               <a  href="<?php echo get_permalink($post->ID) ?>" > 
                	<span class="img_not_available"> <?php _e('Image Not Available ','templatic');?> </span> 
                 </a>
                
                 <?php if(get_post_meta($post->ID,'time',true)){?>
                  <small class="time"> <?php echo get_post_meta($post->ID,'time',true);?> </small>
             <?php }?> 
                
            <?php }?> 
                
                 <p class="title"><a href="<?php echo get_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php echo get_the_title();  ?></a></p>
 
                 <p class="author">  by <?php the_author_posts_link(); ?></p>
                 <p><?php echo excerpt(9); ?></p>
                   
            	 </li>
                 <?php if($pcount!=0 && ($pcount%(4))==0){?>
                 <li class="hr clearfix"></li>
                 <?php }?>
              <?php endwhile; ?>
                    	
                    </ul>

 
    
    
    
    <?php if ($current_term->count > get_option('posts_per_page')) { ?>
      <div class="pagination">       
       <span class="i_previous fl"> <?php previous_posts_link(__('Previous','templatic')) ?> </span>
       <span class="i_next fr" ><?php next_posts_link(__('Next','templatic')) ?> </span>
       
     </div>
      <?php } ?> 
      
     
      
   <?php endif; ?>
    
    
  
    
 		</div><!--/content -->
        
         <div id="sidebar">
	<?php dynamic_sidebar(7);  ?>
</div> <!-- sidebar right--> 
<?php get_footer(); ?>