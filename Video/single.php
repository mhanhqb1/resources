<?php
global $wp_query, $post;
$cat_array = array();
$blog_cat = array();
$blog_cat = get_option('ptthemes_blogcategory');
$blog_cat = get_blog_sub_cats_str($type='array');
$cagInfo = get_the_category();
foreach($cagInfo as $cagInfo_obj)
{
	$cat_array[] = $cagInfo_obj->term_id;
}
$is_blog_post = 1;
require_once (TEMPLATEPATH . '/single_blog.php');
?>