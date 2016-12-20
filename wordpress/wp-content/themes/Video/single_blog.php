<?php get_header(); ?>

<div id="content" class="clearfix" >
      <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/library/js/fancbox/jquery.min.js"></script>  
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/library/js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>

  <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url'); ?>/library/js/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
            <script type="text/javascript">
			jQuery.noConflict();
                jQuery(document).ready(function() {
         
                    jQuery("a[rel=example_group]").fancybox({
                        'transitionIn'		: 'none',
                        'transitionOut'		: 'none',
                        'titlePosition' 	: 'over',
                        'titleFormat'		: function(title, currentArray, currentIndex, currentOpts) {
                            return '<span id="fancybox-title-over">Image ' + (currentIndex + 1) + ' / ' + currentArray.length + (title.length ? ' &nbsp; ' + title : '') + '</span>';
                        }
                    });
        
                });
        </script>   
        
        <div class="single_post">
        
        <?php if ( get_option( 'ptthemes_breadcrumbs' )) { yoast_breadcrumb('<div class="breadcrumb">','</div>'); } ?>

        <h1 class="head"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>">
                      <?php the_title(); ?>
                      </a></h1>
                      
                       
        
     
      <?php if(have_posts()) : ?>
         <?php $post_images = bdw_get_images($post->ID,'large');?>
		  <?php while(have_posts()) : the_post() ?>
	
              <div id="post-<?php the_ID(); ?>" class="posts post_spacer" <?php post_class(); ?>>
               <p class="date"> 
               <span class="fl"> Posted by   By <?php the_author_posts_link(); ?> at  <?php the_time('j F') ?>, at <?php the_time('H : s A') ?> </span>    
               <span class="i_print"> <a href="#" onclick="window.print();return false;" >Print</a></span>  </p>
              
              
              
               <?php if(count($post_images)){?>
                <?php
				$img_size = bdw_get_images_with_info($post->ID,'large');
				$post_images = $img_size[0]['file'];
	       ?>
               <a href="<?php echo $post_images[0];?>" rel="example_group" title="<?php the_title(); ?>">  <img src="<?php echo $post_images;?>" alt="<?php the_title(); ?>"  /> </a>
                <?php }?>
                
                <div  class="small_thumb" >
                <?php
                if(count($post_images)>1)
				{
					for($im=1;$im<count($post_images);$im++)
					{
					?>
                        <a href="<?php echo $post_images[$im];?>" rel="example_group" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" >   
                        <?php
				$img_size = bdw_get_images_with_info($post->ID,'small-thumb');
				$post_images = $img_size[0]['file'];
	       ?>
                       <img src="<?php echo $post_images;?>"  alt="" /> 
                       </a>
                     <?php	
					}
				}
				?></div>
                 
                <?php if(get_post_meta($post->ID,'video',true)){?>
                    <div class="video_main">
                    <?php echo get_post_meta($post->ID,'video',true);?>
                    </div>
                 <?php }?>
                 
                 
               
              		
                        
                      <?php the_content(); ?>
             
                    
                  
                   <p class="post_bottom clearfix"> <span class="category"> <?php the_category(", "); ?> </span>   <?php the_tags('<span class="tags">', ', ', '<br /> </span>'); ?>   </p>
          				
              </div> <!-- post #end -->
              
               
<div class="pos_navigation clearfix">
			<div class="post_left fl"><?php previous_post_link('%link','&laquo; '.__('Previous')) ?></div>
			<div class="post_right fr"><?php next_post_link('%link',__('Next').' &raquo;') ?></div>
	</div>
              </div> <!-- single post content #end -->
          		<?php get_related_posts($post); ?>		
      <?php endwhile; ?>
 <?php endif; ?>
 
          <div id="comments" class="clearfix"> <?php comments_template(); ?></div>
          
          
  </div> <!-- content #end -->
  <div id="sidebar">
      <?php dynamic_sidebar(6);  ?>
  </div>    
 <?php get_footer(); ?>