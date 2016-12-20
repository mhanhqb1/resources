<?php get_header(); ?>
<?php
if(isset($_GET['author_name'])) :
	$curauth = get_userdatabylogin($author_name);
else :
	$curauth = get_userdata(intval($author));
endif;
?>
   <div id="content" class="clearfix">
    
 <?php if ( get_option( 'ptthemes_breadcrumbs' )) { yoast_breadcrumb('<div class="breadcrumb">','</div>'); } ?>
    
    <?php if (is_category()) { ?>
			<h1 class="cat_head"  ><?php echo get_option('ptthemes_browsing_category'); ?><?php echo single_cat_title(); ?></h1>  

			<?php } elseif (is_day()) { ?>
			<h1 class="cat_head" ><?php echo get_option('ptthemes_browsing_day'); ?><?php the_time('F jS, Y'); ?> </h1>

			<?php } elseif (is_month()) { ?>
			<h1  class="cat_head" ><?php echo get_option('ptthemes_browsing_month'); ?><?php the_time('F, Y'); ?> </h1>

			<?php } elseif (is_year()) { ?>
			<h1  class="cat_head" ><?php echo get_option('ptthemes_browsing_year'); ?><?php the_time('Y'); ?> </h1>
			
			<?php } elseif (is_author()) { ?>
			<h1  class="cat_head"><?php echo $curauth->nickname; ?> </h1>
							
			<?php } elseif (is_tag()) { ?>
			<h1 class="cat_head" ><?php echo get_option('ptthemes_browsing_tag'); ?><?php echo single_tag_title('', true); ?> </h1>
 			<?php } ?>
            
            
           

       <?php
		
			if(isset($_GET['author_name'])) :
			$curauth = get_userdatabylogin($author_name);
			else :
			$curauth = get_userdata(intval($author));
			endif;
			
		?>
     
	<ul class="news_list">
    
      <?php if(have_posts()) : ?>
      <?php while(have_posts()) : the_post() ?>
      <?php $post_images = bdw_get_images($post->ID,'large');?>
       	
        
        	<li id="post-<?php the_ID(); ?>" class="clearfix"> 
                
                <p class="date"><?php the_time('j F Y') ?> at <?php the_time('H : s A') ?></p>
                <h3> <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3> 
                 <p class="postedby clearfix">
				<span class="author" >Posted by <?php the_author_posts_link(); ?> in  <?php the_category(" , "); ?> </span>
                
               <a href="<?php the_permalink(); ?>#commentarea" class="pcomments" ><?php comments_number('0', '1', '%'); ?> </a> </p>
                
                
            	<?php if($post_images[0]){ global $thumb_url;?>
                <?php
				$img_size = bdw_get_images_with_info($post->ID,'large');
				$post_images = $img_size[0]['file'];
	       ?>
                   <a class="widget-title" href="<?php the_permalink(); ?>"><img src="<?php echo $post_images;?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>"  /> </a>  
            <?php }?>
            		
                    <p> <?php the_excerpt(20); ?>  </p>
                    
                    
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
      
   
  </div><!--/content -->
        
     <div id="sidebar">
	<?php dynamic_sidebar(5);  ?>
</div> <!-- sidebar right--> 
<?php get_footer(); ?>