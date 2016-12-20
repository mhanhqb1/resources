<?php
// Register widgetized areas
if ( function_exists('register_sidebar') ) {
	 register_sidebars(1,array('name' => 'Front Banner','before_widget' => '<div class="widget">','after_widget' => '</div>','before_title' => '<h3><span>','after_title' => '</span></h3>'));
	 register_sidebars(1,array('name' => 'Front Banner Right Side Advt','before_widget' => '<div class="widget">','after_widget' => '</div>','before_title' => '<h3><span>','after_title' => '</span></h3>'));
	 register_sidebars(1,array('name' => 'Front content','before_widget' => '<div class="widget">','after_widget' => '</div>','before_title' => '<h3><span>','after_title' => '</span></h3>'));
	 register_sidebars(1,array('name' => 'Sidebar Front Page','before_widget' => '<div class="widget">','after_widget' => '</div>','before_title' => '<h3><span>','after_title' => '</span></h3>'));
	 register_sidebars(1,array('name' => 'Sidebar Blog Listing','before_widget' => '<div class="widget">','after_widget' => '</div>','before_title' => '<h3><span>','after_title' => '</span></h3>'));
	 register_sidebars(1,array('name' => 'Sidebar Blog Detail','before_widget' => '<div class="widget">','after_widget' => '</div>','before_title' => '<h3><span>','after_title' => '</span></h3>'));
	 register_sidebars(1,array('name' => 'Sidebar Video Listing','before_widget' => '<div class="widget">','after_widget' => '</div>','before_title' => '<h3><span>','after_title' => '</span></h3>'));
	 register_sidebars(1,array('name' => 'Sidebar Video Detail','before_widget' => '<div class="widget">','after_widget' => '</div>','before_title' => '<h3><span>','after_title' => '</span></h3>'));
	 register_sidebars(5,array('name' => 'Footer content %d ','before_widget' => '<div class="widget">','after_widget' => '</div>','before_title' => '<h3><span>','after_title' => '</span></h3>'));
	 register_sidebars(1,array('name' => 'Header Right side Advt','before_widget' => '<div class="widget">','after_widget' => '</div>','before_title' => '<h3><span>','after_title' => '</span></h3>'));
	 register_sidebars(1,array('name' => 'Top Navigation','before_widget' => '<div class="widget">','after_widget' => '</div>','before_title' => '<h3><span>','after_title' => '</span></h3>'));
	 register_sidebars(1,array('name' => 'Main Navigation','before_widget' => '<div class="widget">','after_widget' => '</div>','before_title' => '<h3><span>','after_title' => '</span></h3>'));
}
	
// Check for widgets in widget-ready areas http://wordpress.org/support/topic/190184?replies=7#post-808787
// Thanks to Chaos Kaizer http://blog.kaizeku.com/
function is_sidebar_active( $index = 1){
	$sidebars	= wp_get_sidebars_widgets();
	$key		= (string) 'sidebar-'.$index;
 
	return (isset($sidebars[$key]));
}


 // =============================== Feedburner Subscribe widget ======================================
class subscribeWidget extends WP_Widget {
	function subscribeWidget() {
	//Constructor
		$widget_ops = array('classname' => 'widget Subscribe', 'description' => 'Subscribe' );		
		$this->WP_Widget('widget_subscribeWidget', 'PT &rarr; Subscribe', $widget_ops);
	}
	function widget($args, $instance) {
	// prints the widget
		extract($args, EXTR_SKIP);
		$id = empty($instance['id']) ? '' : apply_filters('widget_id', $instance['id']);
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
		$text = empty($instance['text']) ? '' : apply_filters('widget_text', $instance['text']);
 ?>
	 
    	<div class="widget" >
        	
        	<?php if ( $title <> "" ) { ?>	 
   		    <h3><?php echo $title; ?></h3>
            <?php } ?>
      
          	<?php if ( $text <> "" ) { ?>	 
         		<?php echo $text; ?> 
            <?php } ?>
         
		<form class="subscribe_form"  action="http://feedburner.google.com/fb/a/mailverify" method="post" target="popupwindow"  onsubmit="window.open('http://feedburner.google.com/fb/a/mailverify?uri=<?php echo $id; ?>', 'popupwindow', 'scrollbars=yes,width=550,height=520');return true">    
     <input type="text" class="field" onfocus="if (this.value == 'Your Email Address') {this.value = '';}" onblur="if (this.value == '') {this.value = 'Your Email Address';}" name="email"/>
     <input type="hidden" value="<?php echo $id; ?>" name="uri"/><input type="hidden" name="loc" value="en_US"/>
     <input class="btn_submit" type="submit" name="submit" value="" /> 
     </form>
		  </div>	 
       

<?php
	}
	function update($new_instance, $old_instance) {
	//save the widget
		$instance = $old_instance;		
		$instance['id'] = strip_tags($new_instance['id']);
		$instance['title'] = ($new_instance['title']);
		$instance['text'] = ($new_instance['text']);	
		return $instance;
	}
	function form($instance) {
	//widgetform in backend
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'id' => '','text' => '') );		
		$id = strip_tags($instance['id']);
		$title = strip_tags($instance['title']);
		$text = strip_tags($instance['text']);

 ?>
 <p><label for="<?php echo $this->get_field_id('title'); ?>">Title 
  <input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr($title); ?>"></label></p>
  <p><label for="<?php echo $this->get_field_id('text'); ?>">Sort Description <textarea class="widefat" rows="6" cols="20" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>"><?php echo esc_attr($text); ?></textarea></label></p>
  
  <p><label for="<?php echo $this->get_field_id('id'); ?>">Feedburner ID: (example:- templatic/eKPs) 
  <input type="text" class="widefat" id="<?php echo $this->get_field_id('id'); ?>" name="<?php echo $this->get_field_name('id'); ?>" value="<?php echo esc_attr($id); ?>"></label></p>
   
<?php
	}}
register_widget('subscribeWidget');



// =============================== socialmedia widget ======================================
class socialmedia extends WP_Widget {
	function socialmedia() {
	//Constructor
		$widget_ops = array('classname' => 'widget Bookmark Link', 'description' => 'Bookmark Link' );		
		$this->WP_Widget('widget_socialmedia', 'PT &rarr; Bookmark Link', $widget_ops);
	}
	function widget($args, $instance) {
	// prints the widget
		extract($args, EXTR_SKIP);
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
		$id = empty($instance['id']) ? '' : apply_filters('widget_id', $instance['id']);
 		$twitter = empty($instance['twitter']) ? '' : apply_filters('widget_twitter', $instance['twitter']);
		$facebook = empty($instance['facebook']) ? '' : apply_filters('widget_facebook', $instance['facebook']);
		$digg = empty($instance['digg']) ? '' : apply_filters('widget_digg', $instance['digg']);
		$myspace = empty($instance['myspace']) ? '' : apply_filters('widget_myspace', $instance['myspace']);
		$rss = empty($instance['rss']) ? '' : apply_filters('widget_rss', $instance['rss']);
?>
	
      
          
          
          <div class="widget">
          	<?php if ( $title <> "" ) { ?>	 
   		    <h3><?php echo $title; ?></h3>
            <?php } ?>
            
            <ul>
            <?php if ( $twitter <> "" ) { ?>	 
            	<li><a href="<?php echo $twitter; ?>"> Twitter</a></li>
            <?php } ?>
            
            <?php if ( $facebook <> "" ) { ?>
            	<li><a href="<?php echo $facebook; ?>">Facebook</a></li>
            <?php } ?>
            
            
             
             <?php if ( $myspace <> "" ) { ?>
            	<li> <a href="<?php echo $myspace; ?>">Myspace</a></li>
            <?php } ?>
            
             <?php if ( $id <> "" ) { ?>
              <li><a href="http://feedburner.google.com/fb/a/mailverify?uri=<?php echo $id; ?>"> Rss Feed</a></li>
            <?php } ?>
            
            </ul>
            
          </div> 
          <!-- social_media #end -->
          
          
      

<?php
	}
	function update($new_instance, $old_instance) {
	//save the widget
		$instance = $old_instance;		
		$instance['id'] = strip_tags($new_instance['id']);
		$instance['title'] = ($new_instance['title']);
		$instance['text'] = ($new_instance['text']);
		$instance['twitter'] = ($new_instance['twitter']);
		$instance['facebook'] = ($new_instance['facebook']);
		$instance['myspace'] = ($new_instance['myspace']);
		
		return $instance;
	}
	function form($instance) {
	//widgetform in backend
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'advt1' => '','text' => '','twitter' => '','facebook' => '','digg' => '','myspace' => '' ) );		
		$id = strip_tags($instance['id']);
		$title = strip_tags($instance['title']);
		$text = strip_tags($instance['text']);
		$twitter = strip_tags($instance['twitter']);
		$facebook = strip_tags($instance['facebook']);
 		$myspace = strip_tags($instance['myspace']);

 ?>
     <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title','templatic'); ?> 
  <input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr($title); ?>"></label></p>  
  <p><label for="<?php echo $this->get_field_id('id'); ?>"><?php _e('Feedburner ID: (example:- templatic/eKPs)','templatic'); ?> 
  <input type="text" class="widefat" id="<?php echo $this->get_field_id('id'); ?>" name="<?php echo $this->get_field_name('id'); ?>" value="<?php echo esc_attr($id); ?>"></label></p>
   
  <p><label for="<?php echo $this->get_field_id('twitter'); ?>"><?php _e('Twitter Full URL','templatic'); ?> 
  <input type="text" class="widefat" id="<?php echo $this->get_field_id('twitter'); ?>" name="<?php echo $this->get_field_name('twitter'); ?>" value="<?php echo esc_attr($twitter); ?>"></label></p>
<p><label for="<?php echo $this->get_field_id('facebook'); ?>"><?php _e('Facebook Full URL','templatic'); ?>
  <input type="text" class="widefat" id="<?php echo $this->get_field_id('facebook'); ?>" name="<?php echo $this->get_field_name('facebook'); ?>" value="<?php echo esc_attr($facebook); ?>"></label></p>
  <p><label for="<?php echo $this->get_field_id('myspace'); ?>"><?php _e('Myspace Full URL','templatic'); ?>
  <input type="text" class="widefat" id="<?php echo $this->get_field_id('myspace'); ?>" name="<?php echo $this->get_field_name('myspace'); ?>" value="<?php echo esc_attr($myspace); ?>"></label></p>

<?php
	}}
register_widget('socialmedia');

// =============================== Sidebar Advt second  ======================================
class advtwidget extends WP_Widget {
	function advtwidget() {
	//Constructor
		$widget_ops = array('classname' => 'widget Advertise', 'description' => 'common advertise widget in sidebar, bottom section' );		
		$this->WP_Widget('advtwidget', 'PT &rarr; Advertise', $widget_ops);
	}
	function widget($args, $instance) {
	// prints the widget
		extract($args, EXTR_SKIP);
		$title = empty($instance['title']) ? '&nbsp;' : apply_filters('widget_title', $instance['title']);
		$desc1 = empty($instance['desc1']) ? '&nbsp;' : apply_filters('widget_desc1', $instance['desc1']);
		 ?>						
 	 
  		<?php /*?><h3><?php echo $title; ?> </h3><?php */?>
          
       <div class="advt">
        <?php if ( $desc1 <> "" ) { ?>	
         <?php echo $desc1; ?> 
         <?php } ?>
       </div>  
                     
	<?php
	}
	function update($new_instance, $old_instance) {
	//save the widget
		$instance = $old_instance;		
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['desc1'] = ($new_instance['desc1']);
		return $instance;
	}
	function form($instance) {
	//widgetform in backend
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 't1' => '', 't2' => '', 't3' => '',  'img1' => '', 'desc1' => '' ) );		
		$title = strip_tags($instance['title']);
		$desc1 = ($instance['desc1']);
?>
        <p><label for="<?php echo $this->get_field_id('desc1'); ?>">your advt code (ex.google adsense etc.) <textarea class="widefat" rows="6" cols="20" id="<?php echo $this->get_field_id('desc1'); ?>" name="<?php echo $this->get_field_name('desc1'); ?>"><?php echo esc_attr($desc1); ?></textarea></label></p>
       
<?php
	}}
register_widget('advtwidget');

// =============================== Featured Videos (particular category) ======================================

class news2columns extends WP_Widget {
	function news2columns() {
	//Constructor
		$widget_ops = array('classname' => 'widget Featured Videos', 'description' => 'List of latest posts in particular category' );
		$this->WP_Widget('news2columns', 'PT &rarr; Featured Videos', $widget_ops);
	}

	function widget($args, $instance) {
	// prints the widget

		extract($args, EXTR_SKIP);
		echo $before_widget;
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
 		$category = empty($instance['category']) ? '' : apply_filters('widget_category', $instance['category']);
		$post_number = empty($instance['post_number']) ? '&nbsp;' : apply_filters('widget_post_number', $instance['post_number']);
		$post_link = empty($instance['post_link']) ? '&nbsp;' : apply_filters('widget_post_link', $instance['post_link']);
		$desc_count = empty($instance['desc_count']) ? '50' : apply_filters('widget_desc_count', $instance['desc_count']);
		
		// if ( !empty( $title ) ) { echo $before_title . $title . $after_title; };
		global $wpdb;
		 ?>
         
         <div  class="popular_post">
         
          <h3> <?php echo $title; ?> </h3>
          <ul><?php 
			        global $post,$wpdb;
					$sqb_sql='';
				   if($category)
				   {
						$sqb_sql = " and p.ID in (select tr.object_id from $wpdb->term_relationships tr join $wpdb->term_taxonomy t on t.term_taxonomy_id=tr.term_taxonomy_id where t.term_id in ($category)) ";   
				   }
				   $sql = "select p.* from $wpdb->posts p where p.post_type='videos' and p.post_status in ('publish','private') $sqb_sql  order by p.post_date desc,p.post_title limit $post_number";
				   $latest_menus = $wpdb->get_results($sql);
                    foreach($latest_menus as $post) :
				?>
                <?php $post_images = bdw_get_images($post->ID,'large');?>
           
           		<li class="clearfix"> 
                
                <?php 
            if(get_the_post_thumbnail( $post->ID, array())){?>
             <a class="video_thumb" href="<?php echo get_permalink($post->ID) ?>" rel="bookmark" title="<?php the_title(); ?>">
             <?php echo get_the_post_thumbnail( $post->ID, array(100,100),array('class'	=> "",));?>
             	
                <?php if(get_post_meta($post->ID,'time',true)){?>
                  <span class="time"> <?php echo get_post_meta($post->ID,'time',true);?> </span>
             <?php }?> 
             
             </a>
            <?php }else if($post_images[0]){ global $thumb_url;             
                $thumb_url1 = $thumb_url.get_image_cutting_edge($args);
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
               <a  href="<?php echo get_permalink($post->ID) ?>"> <span class="img_not_available"> <?php _e('Image Not Available ','templatic');?> </span> </a>
               
               <?php if(get_post_meta($post->ID,'time',true)){?>
                  <span class="time"> <?php echo get_post_meta($post->ID,'time',true);?> </span>
             <?php }?> 
               
            <?php }?> 
                
                 <p class="title"><a href="<?php echo get_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php echo get_the_title();  ?></a></p>
 
                 <p class="author">  by  <a href="<?php echo get_author_posts_url($post->post_author); ?>"><?php echo $wpdb->get_var("select display_name from $wpdb->users where ID='".$post->post_author."'");?></a></p>
                 <p><?php 
				 $text = $post->post_content;
				$text = strip_tags($text);
				$text = substr($text, 0, $desc_count);
				$text = substr($text, 0, strrpos($text, " "));
				echo $text;
				 ?></p>
                   
            	 </li>
    
<?php endforeach; ?>
<?php

	    echo '</ul> </div>';

		echo $after_widget;
	}

	function update($new_instance, $old_instance) {
	//save the widget
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['category'] = strip_tags($new_instance['category']);
		$instance['post_number'] = strip_tags($new_instance['post_number']);
		$instance['post_link'] = strip_tags($new_instance['post_link']);
		$instance['desc_count'] = strip_tags($new_instance['desc_count']);
		return $instance;

	}

	function form($instance) {
	//widgetform in backend
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'category' => '', 'post_number' => '' ) );
		$title = strip_tags($instance['title']);
		$category = strip_tags($instance['category']);
		$post_number = strip_tags($instance['post_number']);
		$post_link = strip_tags($instance['post_link']);
		$desc_count = strip_tags($instance['desc_count']);

?>
<p>
  <label for="<?php echo $this->get_field_id('title'); ?>">Title:
    <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id('category'); ?>">Categories (<code>IDs</code> separated by commas):
  <input class="widefat" id="<?php echo $this->get_field_id('category'); ?>" name="<?php echo $this->get_field_name('category'); ?>" type="text" value="<?php echo esc_attr($category); ?>" />
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id('post_number'); ?>">Number of posts:
  <input class="widefat" id="<?php echo $this->get_field_id('post_number'); ?>" name="<?php echo $this->get_field_name('post_number'); ?>" type="text" value="<?php echo esc_attr($post_number); ?>" />
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id('desc_count'); ?>">Description character count:
  <input class="widefat" id="<?php echo $this->get_field_id('desc_count'); ?>" name="<?php echo $this->get_field_name('desc_count'); ?>" type="text" value="<?php echo esc_attr($desc_count); ?>" />
  </label>
</p>
<?php
	}

}

register_widget('news2columns');

// =============================== Slider (particular category) ======================================

class homebanner extends WP_Widget {
	function homebanner() {
	//Constructor
		$widget_ops = array('classname' => 'widget Home Banner Slider', 'description' => 'Home Banner Slider -> List of latest posts in particular category' );
		$this->WP_Widget('homebanner', 'PT &rarr; Home Banner Slider', $widget_ops);
	}

	function widget($args, $instance) {
	// prints the widget

		extract($args, EXTR_SKIP);
		echo $before_widget;
		$title = empty($instance['title']) ? '&nbsp;' : apply_filters('widget_title', $instance['title']);
 		$category = empty($instance['category']) ? '' : apply_filters('widget_category', $instance['category']);
		$post_number = empty($instance['post_number']) ? '5' : apply_filters('widget_post_number', $instance['post_number']);
		$post_link = empty($instance['post_link']) ? '&nbsp;' : apply_filters('widget_post_link', $instance['post_link']);
		$desc_count = empty($instance['desc_count']) ? '50' : apply_filters('widget_desc_count', $instance['desc_count']);
		
		// if ( !empty( $title ) ) { echo $before_title . $title . $after_title; };
		global $wpdb;
		 ?>
         
 <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/library/js/jquery.easing.1.2.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/library/js/jquery.anythingslider.js" type="text/javascript" charset="utf-8"></script>

         
         <script type="text/javascript">
        function formatText(index, panel) {
		  return index + "";
	    }
    jQuery.noConflict();
       jQuery(function () {
        
            jQuery('.anythingSlider').anythingSlider({
                easing: "easeInOutExpo",        // Anything other than "linear" or "swing" requires the easing plugin
                autoPlay: true,                 // This turns off the entire FUNCTIONALY, not just if it starts running or not.
                delay: 5900,                    // How long between slide transitions in AutoPlay mode
                startStopped: false,            // If autoPlay is on, this can force it to start stopped
                animationTime: 900,             // How long the slide transition takes
                hashTags: true,                 // Should links change the hashtag in the URL?
                buildNavigation: true,          // If true, builds and list of anchor links to link to each slide
        		pauseOnHover: true,             // If true, and autoPlay is enabled, the show will pause on hover
        		startText: "Go",             // Start text
		        stopText: "Stop",               // Stop text
		        navigationFormatter: formatText       // Details at the top of the file on this use (advanced use)
            });
            
            jQuery("#slide-jump").click(function(){
               jQuery('.anythingSlider').anythingSlider(6);
            });
            
        });
    </script>
         <?php /*?> <h3> <?php echo $title; ?> </h3><?php */?>
          
           <div class="anythingSlider">
 				 <div class="wrapper">
  					<ul> 
                    <?php 
			        global $post;
			       // $latest_menus = get_posts('numberposts='.$post_number.'postlink='.$post_link.'&category='.$category.'');
				  $sqb_sql='';
                    if($category)
				   {
						$sqb_sql = " and p.ID in (select tr.object_id from $wpdb->term_relationships tr join $wpdb->term_taxonomy t on t.term_taxonomy_id=tr.term_taxonomy_id where t.term_id in ($category)) ";   
				   }
				   $sql = "select p.* from $wpdb->posts p where p.post_type='videos' and post_status='publish' $sqb_sql  order by p.post_date desc,p.post_title limit $post_number";
				   $latest_menus = $wpdb->get_results($sql);
				   foreach($latest_menus as $post) :
				?>
                    <li>
                    	
                    
                      <?php if(get_post_meta($post->ID,'video',true)){?>
                    <div class="video_section">
                   		<?php echo get_post_meta($post->ID,'video',true);?>
                    </div> 
                 <?php }?> 
				 
				 		<h4> <a href="<?php echo get_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php echo get_the_title();  ?></a> </h4>
                     
                
                  
					</li>
                   <?php endforeach; ?>
          
<?php

	    echo '</ul></div></div>';

		echo $after_widget;
	}

	function update($new_instance, $old_instance) {
	//save the widget
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['category'] = strip_tags($new_instance['category']);
		$instance['post_number'] = strip_tags($new_instance['post_number']);
		$instance['post_link'] = strip_tags($new_instance['post_link']);
		$instance['desc_count'] = strip_tags($new_instance['desc_count']);
		return $instance;

	}

	function form($instance) {
	//widgetform in backend
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'category' => '', 'post_number' => '' ) );
		$title = strip_tags($instance['title']);
		$category = strip_tags($instance['category']);
		$post_number = strip_tags($instance['post_number']);
		$post_link = strip_tags($instance['post_link']);
		$desc_count = strip_tags($instance['desc_count']);

?>
<p>
  <label for="<?php echo $this->get_field_id('category'); ?>">Categories (<code>IDs</code> separated by commas):
  <input class="widefat" id="<?php echo $this->get_field_id('category'); ?>" name="<?php echo $this->get_field_name('category'); ?>" type="text" value="<?php echo esc_attr($category); ?>" />
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id('post_number'); ?>">Number of posts:
  <input class="widefat" id="<?php echo $this->get_field_id('post_number'); ?>" name="<?php echo $this->get_field_name('post_number'); ?>" type="text" value="<?php echo esc_attr($post_number); ?>" />
  </label>
</p>
<?php
	}

}

register_widget('homebanner');


/*---- latest posts in particular category  (particular category)----*/

class latestnews extends WP_Widget {
	function latestnews() {
	//Constructor
		$widget_ops = array('classname' => 'widget Latest News', 'description' => 'List of latest posts in particular category' );
		$this->WP_Widget('latestvideos', 'PT &rarr; Latest News', $widget_ops);
	}

	function widget($args, $instance) {
	// prints the widget

		extract($args, EXTR_SKIP);
		echo $before_widget;
		$title = empty($instance['title']) ? '&nbsp;' : apply_filters('widget_title', $instance['title']);
 		$category = empty($instance['category']) ? '&nbsp;' : apply_filters('widget_category', $instance['category']);
		$post_number = empty($instance['post_number']) ? '&nbsp;' : apply_filters('widget_post_number', $instance['post_number']);
		$post_link = empty($instance['post_link']) ? '&nbsp;' : apply_filters('widget_post_link', $instance['post_link']);

		// if ( !empty( $title ) ) { echo $before_title . $title . $after_title; };
		echo ''; ?>
		<h3> <?php echo $title; ?> </h3>
          <ul class="categories_list">
                
				<?php 
			        global $post;
			        $latest_menus = get_posts('numberposts='.$post_number.'postlink='.$post_link.'&category='.$category.'');
                    foreach($latest_menus as $post) :
                    setup_postdata($post);
				?>
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
                $thumb_url1 = $thumb_url.get_image_cutting_edge($args);
            ?>
             <a class="video_thumb" href="<?php echo get_permalink($post->ID) ?>" rel="bookmark" title="<?php the_title(); ?>">
             <?php
			$img_size = bdw_get_images_with_info($post->ID,'video-thumb');
			$post_images = $img_size[0]['file']; ?>
            <img src="<?php echo $post_images;?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>"  /> 
             
             <?php if(get_post_meta($post->ID,'time',true)){?>
                  <span class="time"> <?php echo get_post_meta($post->ID,'time',true);?> </span>
             <?php }?> 
             
             </a>
            <?php
            } else { ?> 
               <a  href="<?php echo get_permalink($post->ID) ?>"> <span class="img_not_available"> <?php _e('Image Not Available ','templatic');?> </span> </a>
               
               <?php if(get_post_meta($post->ID,'time',true)){?>
                  <span class="time"> <?php echo get_post_meta($post->ID,'time',true);?> </span>
             <?php }
			 }?> 
				<p class="title"><a href="<?php echo get_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php echo get_the_title();  ?></a></p>
				<p class="author">  by <?php the_author_posts_link(); ?></p>
                <p><?php echo excerpt(9); ?></p>
                </li>
    
<?php endforeach; 

	    echo '</ul> ';

		echo $after_widget;
	}

	function update($new_instance, $old_instance) {
	//save the widget
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['category'] = strip_tags($new_instance['category']);
		$instance['post_number'] = strip_tags($new_instance['post_number']);
		$instance['post_link'] = strip_tags($new_instance['post_link']);
		return $instance;

	}

	function form($instance) {
	//widgetform in backend
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'category' => '', 'post_number' => '' ) );
		$title = strip_tags($instance['title']);
		$category = strip_tags($instance['category']);
		$post_number = strip_tags($instance['post_number']);
		$post_link = strip_tags($instance['post_link']);

?>
<p>
  <label for="<?php echo $this->get_field_id('title'); ?>">Title:
    <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id('category'); ?>">Categories (<code>IDs</code> separated by commas):
  <input class="widefat" id="<?php echo $this->get_field_id('category'); ?>" name="<?php echo $this->get_field_name('category'); ?>" type="text" value="<?php echo esc_attr($category); ?>" />
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id('post_number'); ?>">Number of posts:
  <input class="widefat" id="<?php echo $this->get_field_id('post_number'); ?>" name="<?php echo $this->get_field_name('post_number'); ?>" type="text" value="<?php echo esc_attr($post_number); ?>" />
  </label>
</p>
<?php
	}

}

register_widget('latestnews');


/*------latest posts in particular category  (particular category)-----------*/

class latestvideos extends WP_Widget {
	function latestvideos() {
	//Constructor
		$widget_ops = array('classname' => 'widget Latest Videos', 'description' => 'List of latest posts in particular category' );
		$this->WP_Widget('latestvideos', 'PT &rarr; Latest Videos', $widget_ops);
	}

	function widget($args, $instance) {
	// prints the widget

		extract($args, EXTR_SKIP);
		echo $before_widget;
		$title = empty($instance['title']) ? '&nbsp;' : apply_filters('widget_title', $instance['title']);
 		$category = empty($instance['category']) ? '' : apply_filters('widget_category', $instance['category']);
		$post_number = empty($instance['post_number']) ? '&nbsp;' : apply_filters('widget_post_number', $instance['post_number']);
		$post_link = empty($instance['post_link']) ? '&nbsp;' : apply_filters('widget_post_link', $instance['post_link']);

		// if ( !empty( $title ) ) { echo $before_title . $title . $after_title; };
		echo ''; ?>
        <h3> <?php echo $title; ?> </h3>
        <ul class="categories_list">
        <?php 
			global $post,$wpdb;
			if($category){
			$sqb_sql = " and p.ID in (select tr.object_id from $wpdb->term_relationships tr join $wpdb->term_taxonomy t on t.term_taxonomy_id=tr.term_taxonomy_id where t.term_id in ($category)) ";   
			}
			$sql = "select p.* from $wpdb->posts p where p.post_type='videos' and post_status='publish' $sqb_sql  order by p.post_date desc,p.post_title limit $post_number";
            $latest_menus = $wpdb->get_results($sql);
			foreach($latest_menus as $post) :
            setup_postdata($post);
			$post_images = bdw_get_images($post->ID,'large');?>
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
                $thumb_url1 = $thumb_url.get_image_cutting_edge($args);
            ?>
            <a class="video_thumb" href="<?php echo get_permalink($post->ID) ?>" rel="bookmark" title="<?php the_title(); ?>">
				<?php $img_size = bdw_get_images_with_info($post->ID,'video-thumb');
				  $post_images = $img_size[0]['file']; ?>
				<img src="<?php echo $post_images;?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>"  /> 
             
				<?php if(get_post_meta($post->ID,'time',true)){?>
                  <span class="time"> <?php echo get_post_meta($post->ID,'time',true);?> </span>
				<?php }?> 
            </a>
            <?php
            } else { ?> 
               <a  href="<?php echo get_permalink($post->ID) ?>"> <span class="img_not_available"> <?php _e('Image Not Available ','templatic');?> </span> </a>
               
               <?php if(get_post_meta($post->ID,'time',true)){?>
                  <span class="time"> <?php echo get_post_meta($post->ID,'time',true);?> </span>
             <?php }?> 
               
            <?php }?> 
                
                 <p class="title"><a href="<?php echo get_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php echo get_the_title();  ?></a></p>
 
                 <p class="author">  by <?php the_author_posts_link(); ?></p>
                 <p><?php echo excerpt(9); ?></p>
            </li>
    
<?php endforeach; 
	    echo '</ul> ';
		echo $after_widget;
	}

	function update($new_instance, $old_instance) {
	//save the widget
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['category'] = strip_tags($new_instance['category']);
		$instance['post_number'] = strip_tags($new_instance['post_number']);
		$instance['post_link'] = strip_tags($new_instance['post_link']);
		return $instance;

	}

	function form($instance) {
	//widgetform in backend
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'category' => '', 'post_number' => '' ) );
		$title = strip_tags($instance['title']);
		$category = strip_tags($instance['category']);
		$post_number = strip_tags($instance['post_number']);
		$post_link = strip_tags($instance['post_link']);
?>
<p>
  <label for="<?php echo $this->get_field_id('title'); ?>">Title:
    <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id('category'); ?>">Categories (<code>IDs</code> separated by commas):
  <input class="widefat" id="<?php echo $this->get_field_id('category'); ?>" name="<?php echo $this->get_field_name('category'); ?>" type="text" value="<?php echo esc_attr($category); ?>" />
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id('post_number'); ?>">Number of posts:
  <input class="widefat" id="<?php echo $this->get_field_id('post_number'); ?>" name="<?php echo $this->get_field_name('post_number'); ?>" type="text" value="<?php echo esc_attr($post_number); ?>" />
  </label>
</p>
<?php
	}
}

register_widget('latestvideos');

// =============================== Popular Posts Widget ======================================

class sidebar_popularposts extends WP_Widget {
	function sidebar_popularposts() {
	//Constructor
		$widget_ops = array('classname' => 'widget Popular Posts', 'description' => 'Popular Posts' );
		$this->WP_Widget('widget_popularposts', 'PT &rarr; Popular Posts', $widget_ops);
	}

	function widget($args, $instance) {
	// prints the widget

		extract($args, EXTR_SKIP);
		echo $before_widget;
		$name = empty($instance['name']) ? 'Popular Posts' : apply_filters('widget_name', $instance['name']);
		$number = empty($instance['number']) ? '10;' : apply_filters('widget_number', $instance['number']);
		$desc_count = empty($instance['desc_count']) ? '50' : apply_filters('widget_desc_count', $instance['desc_count']);
?>
<div  class="popular_post">
<h3 class="popular" ><?php echo $name; ?></h3>

<ul>
    <?php
    global $wpdb,$post;
    $now = gmdate("Y-m-d H:i:s",time());
    $lastmonth = gmdate("Y-m-d H:i:s",gmmktime(date("H"), date("i"), date("s"), date("m")-12,date("d"),date("Y")));
    $popularposts = "SELECT ID, post_title,post_content,post_author, COUNT($wpdb->comments.comment_post_ID) AS 'stammy' FROM $wpdb->posts, $wpdb->comments WHERE comment_approved = '1' AND $wpdb->posts.ID=$wpdb->comments.comment_post_ID AND post_status = 'publish' and post_type='videos' AND post_date < '$now' AND post_date > '$lastmonth' AND comment_status = 'open' GROUP BY $wpdb->comments.comment_post_ID ORDER BY stammy DESC LIMIT $number";
    $posts = $wpdb->get_results($popularposts);
    $post = $posts;     
    $popular = '';
    if($posts){
        foreach($posts as $post){
            $post_title = stripslashes($post->post_title);
               $guid = get_permalink($post->ID);
               
                  $first_post_title=substr($post_title,0,26);
                  
                  
    ?>
      <?php $post_images = bdw_get_images($post->ID,'large');?>
    
        <li class="clearfix">
            <?php 
    if(get_the_post_thumbnail( $post->ID, array())){?>
     <a class="video_thumb" href="<?php echo get_permalink($post->ID) ?>" rel="bookmark" title="<?php the_title(); ?>">
     <?php echo get_the_post_thumbnail( $post->ID, array(105,70),array('class'	=> "",));?>
     </a>
    <?php }else if($post_images[0]){ global $thumb_url;             
        $thumb_url1 = $thumb_url.get_image_cutting_edge($args);
    ?>
     <a class="video_thumb" href="<?php echo get_permalink($post->ID) ?>" rel="bookmark" title="<?php the_title(); ?>">
      <?php
		$img_size = bdw_get_images_with_info($post->ID,'video-thumb');
		$post_images = $img_size[0]['file'];
      ?>
     <img src="<?php echo $post_images;?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>"  /> </a>
    <?php
    } else { ?> 
       <a  href="<?php echo get_permalink($post->ID) ?>"> <span class="img_not_available"> <?php _e('Image Not Available ','templatic');?> </span> </a>
    <?php }?>  
            
            <p class="title"><a href="<?php echo $guid; ?>" rel="bookmark" title="<?php the_title(); ?>"><?php echo $post_title; ?></a></p>
            <p class="author">  by  <a href="<?php echo get_author_posts_url($post->post_author); ?>"><?php echo $wpdb->get_var("select display_name from $wpdb->users where ID='".$post->post_author."'");?></a></p>
            <p><?php 
         $text = $post->post_content;
        $text = strip_tags($text);
        $text = substr($text, 0, $desc_count);
        $text = substr($text, 0, strrpos($text, " "));
        echo $text;
         ?></p>
             
             </li>
    <?php } } ?>

</ul>

</div>
<?php
	}

	function update($new_instance, $old_instance) {
	//save the widget
		$instance = $old_instance;
		$instance['name'] = strip_tags($new_instance['name']);
		$instance['number'] = strip_tags($new_instance['number']);
		$instance['desc_count'] = strip_tags($new_instance['desc_count']);
		return $instance;

	}

	function form($instance) {
	//widgetform in backend
		$instance = wp_parse_args( (array) $instance, array('name' => '',  'desc_count' => '50', 'number' => '10') );
		$name = strip_tags($instance['name']);
		$number = strip_tags($instance['number']);
		$desc_count = strip_tags($instance['desc_count']);
?>

<p>
  <label for="<?php echo $this->get_field_id('name'); ?>">Title:
    <input class="widefat" id="<?php echo $this->get_field_id('name'); ?>" name="<?php echo $this->get_field_name('name'); ?>" type="text" value="<?php echo esc_attr($name); ?>" />
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id('number'); ?>">Number of popular posts:
    <input class="widefat" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo esc_attr($number); ?>" />
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id('desc_count'); ?>">Description character count:
    <input class="widefat" id="<?php echo $this->get_field_id('desc_count'); ?>" name="<?php echo $this->get_field_name('desc_count'); ?>" type="text" value="<?php echo esc_attr($desc_count); ?>" />
  </label>
</p>
<?php
	}

}

register_widget('sidebar_popularposts');
 
// =============================== All Categories one post display ======================================

class categories_post extends WP_Widget {
	function categories_post() {
	//Constructor
		$widget_ops = array('classname' => 'widget All Categories First Post', 'description' => 'List of Categories first posts in particular category' );
		$this->WP_Widget('widget_posts1', 'PT &rarr; All Categories First Post', $widget_ops);
	}

	function widget($args, $instance) {
	// prints the widget

		extract($args, EXTR_SKIP);
		echo $before_widget;
		$title = empty($instance['title']) ? '&nbsp;' : apply_filters('widget_title', $instance['title']);
 		
		$category = empty($instance['category']) ? '&nbsp;' : apply_filters('widget_category', $instance['category']);
		$post_number = empty($instance['post_number']) ? '4' : apply_filters('widget_post_number', $instance['post_number']);
		$desc_count = empty($instance['desc_count']) ? '50' : apply_filters('widget_desc_count', $instance['desc_count']);

		// if ( !empty( $title ) ) { echo $before_title . $title . $after_title; };
		echo '';
		 ?>
         <ul class="categories_list cat_main">
         
         <?php 
	
		 //   $catQuery =  get_categories('include=9999999' . get_inc_categories("cat_exclude_") .''); 
		 if($category)
		 {
			$catids_qu = "include=$category";
		 }
		$catQuery =  get_categories($catids_qu); 
	
		$catCounter = 0;
		$pcount=0;
		 global $post,$wpdb;
		foreach ($catQuery as $category) {

		$catCounter++;

		$catLink = get_category_link($category->term_id);
		$posts = get_posts('numberposts=1&post_type=post&offset=1&orderby=post_date&order=DESC&category='.$category->term_id);
		
		$posts = $posts[0];
		?> 
        <?php $post_images = bdw_get_images($posts->ID,'large');	?>
          <?php    $pcount++; ?>
         <li> 
            <h3> <a href="<?php echo get_category_link($category->term_id);?>" ><?php echo $category->name ?></a> </h3>
          <?php 
            if(get_the_post_thumbnail( $posts->ID, array())){?>
             <a class="video_thumb" href="<?php echo get_permalink($posts->ID) ?>" rel="bookmark" title="<?php get_the_title($posts->ID); ?>">
             <?php echo get_the_post_thumbnail( $posts->ID, array(125,102),array('class'	=> "",));?>
             
              
             
             </a>
            <?php }else if($post_images[0]){ global $thumb_url;             
                $thumb_url1 = $thumb_url.get_image_cutting_edge($args);
            ?>
             <a class="video_thumb" href="<?php echo get_permalink($posts->ID) ?>" rel="bookmark" title="<?php get_the_title($posts->ID); ?>">
             <?php
			$img_size = bdw_get_images_with_info($posts->ID,'video-thumb');
			$post_images = $img_size[0]['file'];
		    ?>
             <img src="<?php echo $post_images;?>" alt="<?php get_the_title($posts->ID); ?>" title="<?php the_title(); ?>"  /> 
             
              
             
             </a>
            <?php
            } else { ?> 
               <a  href="<?php echo get_permalink($posts->ID) ?>" class="img" > <span class="img_not_available"> <?php _e('Image Not Available ','templatic');?> </span> 
                </a>
                 
            <?php }?> 
                           <p class="title"><a href="<?php echo get_permalink($posts->ID) ?>" rel="bookmark" title="<?php get_the_title($posts->ID); ?>"><?php echo get_the_title($posts->ID);  ?></a></p>
                            <p class="author">  by <a href="<?php echo get_author_posts_url($posts->post_author); ?>"><?php echo $wpdb->get_var("select display_name from $wpdb->users where ID='".$posts->post_author."'");?></a></p>
                             <p><?php 
							 $text = $posts->post_content;
							$text = strip_tags($text);
							$text = substr($text, 0, $desc_count);
							$text = substr($text, 0, strrpos($text, " "));
							echo $text;
							 ?></p>
                        </li>
                        <?php if($pcount!=0 && ($pcount%4)==0){?>
                             <li class="hr clearfix"></li>
                             <?php }?>
	<?php }	?>
 <?php
		echo $after_widget;
	}

	function update($new_instance, $old_instance) {
	//save the widget
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['category'] = strip_tags($new_instance['category']);
		$instance['post_number'] = strip_tags($new_instance['post_number']);
		$instance['desc_count'] = strip_tags($new_instance['desc_count']);
		return $instance;

	}

	function form($instance) {
	//widgetform in backend
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'category' => '', 'post_number' => '' ) );
		$title = strip_tags($instance['title']);
		$category = strip_tags($instance['category']);
		$post_number = strip_tags($instance['post_number']);
		$desc_count = strip_tags($instance['desc_count']);

?>
<p>
  <label for="<?php echo $this->get_field_id('category'); ?>">Categories (<code>IDs</code> separated by commas):
  <input class="widefat" id="<?php echo $this->get_field_id('category'); ?>" name="<?php echo $this->get_field_name('category'); ?>" type="text" value="<?php echo esc_attr($category); ?>" />
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id('desc_count'); ?>">Description charater count:
  <input class="widefat" id="<?php echo $this->get_field_id('desc_count'); ?>" name="<?php echo $this->get_field_name('desc_count'); ?>" type="text" value="<?php echo esc_attr($desc_count); ?>" />
  </label>
</p>
<?php
	}
}
register_widget('categories_post');

// =============================== All  Videos  Categories one post display ======================================

class video_categories_post extends WP_Widget {
	function video_categories_post() {
	//Constructor
		$widget_ops = array('classname' => 'widget All Video Categories First Post', 'description' => 'List of Categories first video in particular category' );
		$this->WP_Widget('widget_video_allcat', 'PT &rarr; All Categories First Video', $widget_ops);
	}

	function widget($args, $instance) {
	// prints the widget

		extract($args, EXTR_SKIP);
		echo $before_widget;
		$title = empty($instance['title']) ? '&nbsp;' : apply_filters('widget_title', $instance['title']);
 		$category = empty($instance['category']) ? '' : apply_filters('widget_category', $instance['category']);
		$post_number = empty($instance['post_number']) ? '4' : apply_filters('widget_post_number', $instance['post_number']);
		$desc_count = empty($instance['desc_count']) ? '50' : apply_filters('widget_desc_count', $instance['desc_count']);

		// if ( !empty( $title ) ) { echo $before_title . $title . $after_title; };
		 ?>
         <ul class="categories_list cat_main">
         <?php 
	    $sub_sql_cat='';
		 if($category)
		 {
			$catids = $category; 
			$sub_sql_cat = " and t.term_id in ($catids)";
		 }
		//$catQuery =  get_categories('include='.$catids); 
		global $wpdb;

	  
		$catQuery = $wpdb->get_results("select t.* from $wpdb->terms t join $wpdb->term_taxonomy tt on tt.term_id=t.term_id where tt.taxonomy=\"videoscategory\"   $sub_sql_cat order by t.name");
		$catCounter = 0;
		$pcount=0;
		 global $post,$wpdb;
		foreach ($catQuery as $category) {

		$catCounter++;
		//$post = get_posts('numberposts=1&offset=1&category='.$category->term_id);
		$categoryid = $category->term_id;
		 $sql = "select p.* from $wpdb->posts p where p.post_type='videos' and post_status='publish' and p.ID in (select tr.object_id from $wpdb->term_relationships tr join $wpdb->term_taxonomy t on t.term_taxonomy_id=tr.term_taxonomy_id where t.term_id=\"$categoryid\"  ) order by p.post_date desc,p.ID desc limit $post_number";
		 $post = $wpdb->get_results($sql);
		 ?> 
        <?php $post_images = bdw_get_images($post[0]->ID,'large');	
			  $pcount++; ?>
         <li> 
          <?php if(get_post_meta($post[0]->ID,'time',true)){?>
                  <span class="time"> <?php echo get_post_meta($post[0]->ID,'time',true);?> </span>
          <?php }?> 
          <h3> <a href="<?php echo get_term_link( (int)$category->term_id, 'videoscategory' );?>" ><?php echo $category->name; ?></a> </h3>
          <?php 
            if(get_the_post_thumbnail( $post[0]->ID, array())){?>
             <a class="video_thumb" href="<?php echo get_permalink($post[0]->ID) ?>" rel="bookmark" title="<?php get_the_title($post[0]->ID); ?>">
             <?php echo get_the_post_thumbnail( $post[0]->ID, array(125,102),array('class'	=> "",));?>
			</a>
          <?php }else if($post_images[0]){ global $thumb_url;             
                $thumb_url1 = $thumb_url.get_image_cutting_edge($args); ?>
          <a class="video_thumb" href="<?php echo get_permalink($post[0]->ID) ?>" rel="bookmark" title="<?php get_the_title($post[0]->ID); ?>">
              <?php
			$img_size = bdw_get_images_with_info($post[0]->ID,'video-thumb');
			$post_images = $img_size[0]['file'];
		    ?>
             <img src="<?php echo $post_images;?>" alt="<?php get_the_title($post[0]->ID); ?>" title="<?php the_title(); ?>"  /> 
          </a>
            <?php
            } else { ?> 
               <a  href="<?php echo get_permalink($post[0]->ID) ?>" class="img" > <span class="img_not_available"> <?php _e('Image Not Available ','templatic');?> </span> 
                </a>
        <?php }?> 
                           <p class="title"><a href="<?php echo get_permalink($post[0]->ID) ?>" rel="bookmark" title="<?php get_the_title($post[0]->ID); ?>"><?php echo get_the_title($post[0]->ID);  ?></a></p>
                            <p class="author">  by <a href="<?php echo get_author_posts_url($post[0]->post_author); ?>"><?php echo $wpdb->get_var("select display_name from $wpdb->users where ID='".$post[0]->post_author."'");?></a></p>
                             <p><?php 
							 $text = $post[0]->post_content;
							$text = strip_tags($text);
							$text = substr($text, 0, $desc_count);
							$text = substr($text, 0, strrpos($text, " "));
							echo $text;
							 ?></p>
                        </li>
                        <?php if($pcount!=0 && ($pcount%4)==0){?>
                             <li class="hr clearfix"></li>
                             <?php }?>
	<?php }	?>
    </ul>
 <?php
		echo $after_widget;
	}

	function update($new_instance, $old_instance) {
	//save the widget
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['category'] = strip_tags($new_instance['category']);
		$instance['post_number'] = strip_tags($new_instance['post_number']);
		$instance['desc_count'] = strip_tags($new_instance['desc_count']);
		return $instance;

	}

	function form($instance) {
	//widgetform in backend
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'category' => '', 'post_number' => '' ) );
		$title = strip_tags($instance['title']);
		$category = strip_tags($instance['category']);
		$post_number = strip_tags($instance['post_number']);
		$desc_count = strip_tags($instance['desc_count']);

?>
<p>
  <label for="<?php echo $this->get_field_id('category'); ?>">Categories (<code>IDs</code> separated by commas):
  <input class="widefat" id="<?php echo $this->get_field_id('category'); ?>" name="<?php echo $this->get_field_name('category'); ?>" type="text" value="<?php echo esc_attr($category); ?>" />
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id('desc_count'); ?>">Description charater count:
  <input class="widefat" id="<?php echo $this->get_field_id('desc_count'); ?>" name="<?php echo $this->get_field_name('desc_count'); ?>" type="text" value="<?php echo esc_attr($desc_count); ?>" />
  </label>
</p>
<?php
	}

}

register_widget('video_categories_post');

// =============================== Category wise Widget (particular category) ======================================

class categorylist extends WP_Widget {
	function categorylist() {
	//Constructor
		$widget_ops = array('classname' => 'widget Category wise News', 'description' => 'List of latest posts in particular category' );
		$this->WP_Widget('categorylist', 'PT &rarr; Category wish News List', $widget_ops);
	}

	function widget($args, $instance) {
	// prints the widget

		extract($args, EXTR_SKIP);
		echo $before_widget;
		$title = empty($instance['title']) ? '&nbsp;' : apply_filters('widget_title', $instance['title']);
 		$category = empty($instance['category']) ? '&nbsp;' : apply_filters('widget_category', $instance['category']);
		$post_number = empty($instance['post_number']) ? '&nbsp;' : apply_filters('widget_post_number', $instance['post_number']);
		$post_link = empty($instance['post_link']) ? '&nbsp;' : apply_filters('widget_post_link', $instance['post_link']);
		$desc_count = empty($instance['desc_count']) ? '50' : apply_filters('widget_desc_count', $instance['desc_count']);

		// if ( !empty( $title ) ) { echo $before_title . $title . $after_title; };
		echo '';
		 ?>
         
          <h3 class="clearfix"><?php echo $title; ?></h3>
          <ul class="popular_post clearfix">
                
				<?php 
			        global $post;
			        $latest_menus = get_posts('numberposts='.$post_number.'postlink='.$post_link.'&category='.$category.'');
                    $pcount=0;
					foreach($latest_menus as $post) :
                    setup_postdata($post);
					$pcount++;
			    ?>
                 <?php $post_images = bdw_get_images($post->ID,'large');?>
           
           		<li class="clearfix"> 
                
                 <?php 
            if(get_the_post_thumbnail( $post->ID, array())){?>
             <a class="video_thumb" href="<?php echo get_permalink($post->ID) ?>" rel="bookmark" title="<?php the_title(); ?>">
             <?php echo get_the_post_thumbnail( $post->ID, array(100,100),array('class'	=> "",));?>
             	
                <?php if(get_post_meta($post->ID,'time',true)){?>
                  <span class="time"> <?php echo get_post_meta($post->ID,'time',true);?> </span>
             <?php }?> 
             
             </a>
            <?php }else if($post_images[0]){ global $thumb_url;             
                $thumb_url1 = $thumb_url.get_image_cutting_edge($args);
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
               <a  href="<?php echo get_permalink($post->ID) ?>"> <span class="img_not_available"> <?php _e('Image Not Available ','templatic');?> </span> </a>
               
               <?php if(get_post_meta($post->ID,'time',true)){?>
                  <span class="time"> <?php echo get_post_meta($post->ID,'time',true);?> </span>
             <?php }?> 
               
            <?php }?> 
                
                 <p class="title"><a href="<?php echo get_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php echo get_the_title();  ?></a></p>
  				<p><?php 
				 $text = $post->post_content;
				$text = strip_tags($text);
				$text = substr($text, 0, $desc_count);
				$text = substr($text, 0, strrpos($text, " "));
				echo $text;
				 ?></p>
               </li>
 <?php endforeach; 
	    echo '</ul>';

		echo $after_widget;
	}

	function update($new_instance, $old_instance) {
	//save the widget
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['category'] = strip_tags($new_instance['category']);
		$instance['post_number'] = strip_tags($new_instance['post_number']);
		$instance['post_link'] = strip_tags($new_instance['post_link']);
		$instance['desc_count'] = strip_tags($new_instance['desc_count']);
		return $instance;

	}

	function form($instance) {
	//widgetform in backend
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'category' => '', 'post_number' => '' ) );
		$title = strip_tags($instance['title']);
		$category = strip_tags($instance['category']);
		$post_number = strip_tags($instance['post_number']);
		$post_link = strip_tags($instance['post_link']);
		$desc_count = strip_tags($instance['desc_count']);

?>
<p>
  <label for="<?php echo $this->get_field_id('title'); ?>">Title:
    <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id('category'); ?>">Categories (<code>IDs</code> separated by commas):
  <input class="widefat" id="<?php echo $this->get_field_id('category'); ?>" name="<?php echo $this->get_field_name('category'); ?>" type="text" value="<?php echo esc_attr($category); ?>" />
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id('post_number'); ?>">Number of posts:
  <input class="widefat" id="<?php echo $this->get_field_id('post_number'); ?>" name="<?php echo $this->get_field_name('post_number'); ?>" type="text" value="<?php echo esc_attr($post_number); ?>" />
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id('desc_count'); ?>">Description character count:
  <input class="widefat" id="<?php echo $this->get_field_id('desc_count'); ?>" name="<?php echo $this->get_field_name('desc_count'); ?>" type="text" value="<?php echo esc_attr($desc_count); ?>" />
  </label>
</p>
<?php
	}

}

register_widget('categorylist');

// =============================== Flickr widget ======================================

class flickrWidget extends WP_Widget {
	function flickrWidget() {
	//Constructor
		$widget_ops = array('classname' => 'widget Flickr Photos ', 'description' => 'Flickr Photos' );
		$this->WP_Widget('widget_flickrwidget', 'PT &rarr; Flickr Photos', $widget_ops);
	}

	function widget($args, $instance) {
	// prints the widget

		extract($args, EXTR_SKIP);
		echo $before_widget;
		$id = empty($instance['id']) ? '&nbsp;' : apply_filters('widget_id', $instance['id']);
		$number = empty($instance['number']) ? '&nbsp;' : apply_filters('widget_number', $instance['number']);

?>
		
        <h3 ><span>Photo Gallery</span> </h3>
<div class="flickr clearfix">
			
 		  <script type="text/javascript" src="http://www.flickr.com/badge_code_v2.gne?count=<?php echo $number; ?>&amp;display=latest&amp;size=s&amp;layout=x&amp;source=user&amp;user=<?php echo $id; ?>"></script>
 		 
</div>
</div>	

<?php
	}

	function update($new_instance, $old_instance) {
	//save the widget
		$instance = $old_instance;
		$instance['id'] = strip_tags($new_instance['id']);
		$instance['number'] = strip_tags($new_instance['number']);
		return $instance;

	}

	function form($instance) {
	//widgetform in backend
		$instance = wp_parse_args( (array) $instance, array('title' => '',  'id' => '', 'number' => '') );
		$id = strip_tags($instance['id']);
		$number = strip_tags($instance['number']);
?>

<p>
  <label for="<?php echo $this->get_field_id('id'); ?>">Flickr ID (<a href="http://www.idgettr.com">idGettr</a>):
    <input class="widefat" id="<?php echo $this->get_field_id('id'); ?>" name="<?php echo $this->get_field_name('id'); ?>" type="text" value="<?php echo esc_attr($id); ?>" />
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id('number'); ?>">Number of photos:
    <input class="widefat" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo esc_attr($number); ?>" />
  </label>
</p>
<?php
	}

}

register_widget('flickrWidget');

/*
 * Create the templatic twiter post widget
 */	

// Display Twitter messages
if(!function_exists('is_curl_installed')){
	function is_curl_installed() {
		if  (in_array  ('curl', get_loaded_extensions())) {
			return true;
		}
		else {
			return false;
		}
	}
}

if(!class_exists('templ_twitter')){
	require_once('Oauth/twitteroauth.php');
	class templ_twitter extends WP_Widget{
		function templ_twitter(){
			$this->options = array(
				array(
					'name'	=> 'title',
					'label'	=> __( 'Title', DOMAIN ),
					'type'	=> 'text'
				),			
				array(
					'name'	=> 'twitter_username',
					'label'	=> __( 'Twitter Username', DOMAIN ),
					'type'	=> 'text'
				),
				array(
					'name'	=> 'consumer_key',
					'label'	=> __( 'Consumer Key', DOMAIN ),
					'type'	=> 'text'
				),
				array(
					'name'	=> 'consumer_secret',
					'label'	=> __( 'Consumer Secret', DOMAIN ),
					'type'	=> 'text'
				),
				array(
					'name'	=> 'access_token',
					'label'	=> __( 'Access Token', DOMAIN ),
					'type'	=> 'text'
				),
				array(
					'name'	=> 'access_token_secret',
					'label'	=> __( 'Access Token Secret', DOMAIN ),
					'type'	=> 'text'
				),
				array(
					'name'	=> 'twitter_number',
					'label'	=> __( 'Number Of Tweets', DOMAIN ),
					'type'	=> 'text'
				),
				array(
					'name'	=> 'follow_text',
					'label'	=> __( 'Twitter button text <small>(for eg. Follow us, Join me on Twitter, etc.)</small>', DOMAIN ),
					'type'	=> 'text'
				),			
			);
			$widget_options = array(
				'classname'		=>	'widget Templatic twitter',
				'description'	=>	__('Show your latest tweets on your site.','templatic')
			);
			$this->WP_Widget(false, __('T &rarr; Latest Twitter Feeds','templatic'), $widget_options);
		}
		
		function widget($args, $instance){
			extract($args, EXTR_SKIP );
			$title = ($instance['title']) ? $instance['title'] : 'Latest Tweets';
			$twitter_username = ($instance['twitter_username']) ? $instance['twitter_username'] : '';
			$consumer_key = ($instance['consumer_key']) ? $instance['consumer_key'] : '3';
			$consumer_secret = ($instance['consumer_secret']) ? $instance['consumer_secret'] : '3';
			$access_token = ($instance['access_token']) ? $instance['access_token'] : '3';
			$access_token_secret = ($instance['access_token_secret']) ? $instance['access_token_secret'] : '3';
			$twitter_number = ($instance['twitter_number']) ? $instance['twitter_number'] : '3';
			$follow_text = apply_filters('widget_title', $instance['follow_text']);
			
			echo $before_widget;
			echo '<div id="twitter" style="margin: auto;" >';
			if ( $title ) {
				$title_icon = ($instance['title_icon']) ? '<img src="'.WP_PLUGIN_URL.'/'.basename(dirname(__FILE__)).'/twitter_small.png" alt="'.$title.'" title="'.$title.'" /> ' : '';
				echo '<h3 class="i_twitter">' . $title_icon . $title . '</h3>';
			}
			if (!is_curl_installed()) {
				_e("cURL is NOT installed on this server",DOMAIN);
			}else{
			if ($twitter_username != '') {
				templatic_twitter_messages($instance);
				}
			}
			echo '</div>';
			echo $after_widget;
		}
		
		/** @see WP_Widget::update */
		function update($new_instance, $old_instance) {				
			$instance = $old_instance;
			foreach ($this->options as $val) {
				if ($val['type']=='text') {
					$instance[$val['name']] = strip_tags($new_instance[$val['name']]);
				} else if ($val['type']=='checkbox') {
					$instance[$val['name']] = ($new_instance[$val['name']]=='on') ? true : false;
				}
			}
			return $instance;
		}
		function form($instance){
			if (empty($instance)) {
				$instance['title']					= __( 'Latest Tweets', DOMAIN );			
				$instance['twitter_username']		= 'templatic';
				$instance['consumer_key']			= '';
				$instance['consumer_secret']		= '';
				$instance['access_token']			= '';
				$instance['access_token_secret']	= '';
				$instance['twitter_number']			= '3';			
				$instance['follow_text']			= __('Follow Us','templatic');
			}
			echo '<p><span style="font-size:11px">To use this widget, <a href="https://dev.twitter.com/apps/new" style="text-decoration:none;" target="_blank">create</a> an application or <a href="https://dev.twitter.com/apps" target="_blank" style="text-decoration:none;" >click here</a> if you already have it, and fill required fields below. Need help? Read <a href="http://templatic.com/docs/latest-changes-in-twitter-widget-for-all-templatic-themes/" title="Tweeter Widget Guide" target="_blank" style="text-decoration:none;" >Tweeter Guide</a>.</small></p>';
			foreach ($this->options as $val) {
				$label = '<label for="'.$this->get_field_id($val['name']).'">'.$val['label'].'</label>';
				if ($val['type']=='separator') {
					echo '<hr />';
				} else if ($val['type']=='text') {
					echo '<p>'.$label.'<br />';
					echo '<input class="widefat" id="'.$this->get_field_id($val['name']).'" name="'.$this->get_field_name($val['name']).'" type="text" value="'.esc_attr($instance[$val['name']]).'" /></p>';
				} else if ($val['type']=='checkbox') {
					$checked = ($instance[$val['name']]) ? 'checked="checked"' : '';
					echo '<input id="'.$this->get_field_id($val['name']).'" name="'.$this->get_field_name($val['name']).'" type="checkbox" '.$checked.' /> '.$label.'<br />';
				}
			}
		}
	}
	// Register Widget
	add_action('widgets_init', create_function('', 'return register_widget("templ_twitter");'));
}

//Function to convert date to time ago format
//eg.1 day ago, 1 year ago, etc...
function time_elapsed_string($ptime) {
    $etime = time() - $ptime;
    
    if ($etime < 1) {
        return __('0 seconds','templatic');
    }
    
    $a = array( 12 * 30 * 24 * 60 * 60  =>  'year',
                30 * 24 * 60 * 60       =>  'month',
                24 * 60 * 60            =>  'day',
                60 * 60                 =>  'hour',
                60                      =>  'minute',
                1                       =>  'second'
                );
    
    foreach ($a as $secs => $str) {
        $d = $etime / $secs;
        if ($d >= 1) {
            $r = round($d);
            return __($r . ' ' . $str . ($r > 1 ? 's' : '').' ago','templatic');
        }
    }
}
//Function to convert date to time ago format

function templatic_twitter_messages($options){
	$twitter_username	 = $options['twitter_username'];
	$consumer_key		 = $options['consumer_key'];
	$consumer_secret	 = $options['consumer_secret'];
	$access_token		 = $options['access_token'];
	$access_token_secret = $options['access_token_secret'];
	$twitter_number		 = $options['twitter_number'];
	$follow_text		 = $options['follow_text'];
	
	function getConnectionWithAccessToken($cons_key, $cons_secret, $oauth_token, $oauth_token_secret) {
		$connection = new TwitterOAuth($cons_key, $cons_secret, $oauth_token, $oauth_token_secret);
		return $connection;
	}
	$connection = getConnectionWithAccessToken($consumer_key, $consumer_secret, $access_token, $access_token_secret);
	$tweets = $connection->get("https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=".$twitter_username."&count=".$twitter_number);
	$tweet_errors = (array) $tweets->errors;
	if (empty($tweets)) {
	    _e('No public tweets','templatic');
	}elseif(!empty($tweet_errors)){
		$twitter_error = $tweet_errors;
		$debug = '<br />Error:('.$twitter_error[0]->code.')<br/> '.$twitter_error[0]->message;
		_e('Unable to get tweets'.$debug,'templatic');
	}else{
		echo '<ul id="twitter_update_list" class="templatic_twitter_widget">';
		foreach ($tweets  as $tweet) {
			$exact_link = $tweet->entities->urls[0]->url;
			$twitter_timestamp = strtotime($tweet->created_at);
			$tweet_date = time_elapsed_string( $twitter_timestamp );
			echo '<li>';
				$msg = $tweet->text;
				$flag = 0;
				if(strpos($msg, "http://") !== false){
					$flag = 1;
				}
				if($flag==1){
					$msg = substr($msg,0,strpos($msg, "http://"));
				}
				$msg = utf8_encode($msg);	
				echo $msg;
				if($flag==1){
					echo '<br/><a href="'.$exact_link.'" target="_blank" class="twitter-link" >'.$exact_link.'</a>';
				}
				echo '<span class="twit_time" style="display: block;">'.$tweet_date.'</span>';
			echo '</li>';
		}
		echo '</ul>';
		if($follow_text){				
			echo "<a href='http://www.twitter.com/$twitter_username/' title='$follow_text' class='b_twitter' target='_blank'>$follow_text</a>";				
		}
	}
}
?>