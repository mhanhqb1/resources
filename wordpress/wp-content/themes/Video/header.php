<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">
<title>
<?php if ( is_home() ) { ?><?php bloginfo('description'); ?>&nbsp;|&nbsp;<?php bloginfo('name'); ?><?php } ?>
<?php if ( is_search() ) { ?>Search Results&nbsp;|&nbsp;<?php bloginfo('name'); ?><?php } ?>
<?php if ( is_author() ) { ?>Author Archives&nbsp;|&nbsp;<?php bloginfo('name'); ?><?php } ?>
<?php if ( is_single() ) { ?><?php wp_title(''); ?><?php } ?>
<?php if ( is_page() ) { ?><?php wp_title(''); ?><?php } ?>
<?php if ( is_archive() ) { ?>
<?php 
if(is_category())
{
	single_cat_title();
}else
{
	global $wp_query, $post;
	$current_term = $wp_query->get_queried_object();	
	echo $current_term->name;	
}
?>
&nbsp;|&nbsp;<?php bloginfo('name'); ?><?php } ?>
<?php if ( is_month() ) { ?><?php the_time('F'); ?>&nbsp;|&nbsp;<?php bloginfo('name'); ?><?php } ?>
<?php if (function_exists('is_tag')) { if ( is_tag() ) { ?><?php bloginfo('name'); ?>&nbsp;|&nbsp;Tag Archive&nbsp;|&nbsp;<?php single_tag_title("", true); } } ?>
</title>

<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<?php if (is_home()) { ?>
<?php if ( get_option('ptthemes_meta_description') <> "" ) { ?>
<meta name="description" content="<?php echo stripslashes(get_option('ptthemes_meta_description')); ?>" />
<?php } ?>
<?php if ( get_option('ptthemes_meta_keywords') <> "" ) { ?>
<meta name="keywords" content="<?php echo stripslashes(get_option('ptthemes_meta_keywords')); ?>" />
<?php } ?>
<?php if ( get_option('ptthemes_meta_author') <> "" ) { ?>
<meta name="author" content="<?php echo stripslashes(get_option('ptthemes_meta_author')); ?>" />
<?php } ?>
<?php } ?>
<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_url'); ?>" media="screen" />
<?php if ( get_option('ptthemes_favicon') <> "" ) { ?>
<link rel="shortcut icon" type="image/png" href="<?php echo get_option('ptthemes_favicon'); ?>" />
<?php } ?>
<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php if ( get_option('ptthemes_feedburner_url') <> "" ) { echo get_option('ptthemes_feedburner_url'); } else { echo get_bloginfo_rss('rss2_url'); } ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<?php if ( get_option('ptthemes_scripts_header') <> "" ) { echo stripslashes(get_option('ptthemes_scripts_header')); } ?>
<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/library/css/print.css" media="print" />
<link href="<?php echo get_template_directory_uri(); ?>/library/css/slimbox.css" rel="stylesheet" type="text/css" />
<?php
	if ( is_singular() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );
?>
<?php wp_head(); ?>

 <?php if ( get_option('ptthemes_customcss') ) { ?>
<link href="<?php echo get_template_directory_uri(); ?>/custom.css" rel="stylesheet" type="text/css">
<?php } ?>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/library/js/jquery.min.js"></script> 
</head>
<body <?php body_class(); ?>>
<div class="outer">
 <div id="page_nav">
  <?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('Top Navigation') ){}else{  ?>
         <ul>    
             <li class="hometab <?php if ( is_home() && !isset($_REQUEST['page']) ) { ?> current_page_item <?php } ?>"><a href="<?php echo get_option('home'); ?>/"><?php _e('Home'); ?></a></li>     
             <?php wp_list_pages('title_li=&depth=0&exclude=' . get_inc_pages("pag_exclude_") .'&sort_column=menu_order');  ?>
        </ul>
        <?php }?>
         
 </div> <!-- page nav #end -->
<div id="header" class="clearfix">
<?php if ( get_option('ptthemes_show_blog_title') ) { ?>
   <div class="blog-title"><a href="<?php echo  home_url() ; ?>/"><?php bloginfo('name'); ?></a> 
		
		 <p class="blog-description">
		  <?php bloginfo('description'); ?>
		</p>
   </div> 
                <?php } else { ?>
                
                <div class="logo"> 
                <a href="<?php echo get_option('home'); ?>/">
                <img src="<?php if ( get_option('ptthemes_logo_url') <> "" ) { echo get_option('ptthemes_logo_url'); } else { echo get_template_directory_uri().'/skins/'.str_replace('.css','',get_option('ptthemes_alt_stylesheet')).'/logo.png'; } ?>" alt="<?php bloginfo('name'); ?>"   /></a>
                	
                      
                  </div>      
                
                <?php } ?>
                
                
                
                <div id="banner">
                	 <?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('Header Right side Advt') ){}else{  ?>
                      <?php }?>
                </div>
                
                
                
 
          
        	 
      
   </div> <!-- header #end -->
   <div id="main_nav"> 
   		
         <?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('Main Navigation') ){}else{  ?>
        	
            <ul>	
                <?php
	  $blog_cat = get_option('ptthemes_videocategory');
      if(is_array(get_option('ptthemes_videocategory')) && $blog_cat[0]!='')
      {
        $blog_cat = implode(',',get_option('ptthemes_videocategory'));  
		$catlist_blog =  wp_list_categories('title_li=&include=' . $blog_cat .'&echo=1&taxonomy=videoscategory');
      }
     ?> 
     
     
      <?php
	  $blog_cat = get_option('ptthemes_blogcategory');
      if(is_array(get_option('ptthemes_blogcategory')) && $blog_cat[0]!='')
      {
        $blog_cat = implode(',',get_option('ptthemes_blogcategory'));  
		$catlist_blog =  wp_list_categories('title_li=&include=' . $blog_cat .'&echo=0');
      }
    if(!strstr($catlist_blog,'No categories'))
	 {
		 echo $catlist_blog;
	 }
     ?> 
     
     <?php wp_list_pages('title_li=&depth=0&include=' . get_multiselect_val('ptthemes_header_nav') . '&sort_column=menu_order'); ?>
        
      </ul>  
        <?php }?>
        
        <?php get_search_form(); ?>
   		
   </div>
          
<div id="wrapper" class="clearfix">       