<?php
//----------------------------------------------------------------------//
// Initiate the plugin to add custom post type of "places" and "events"
//----------------------------------------------------------------------//
add_action("init", "custom_posttype_menu_wp_admin1");
function custom_posttype_menu_wp_admin1()
{
//===============Custom SECTION START================
register_post_type(	'videos', 
				array(	'label' 			=> __('Videos','templatic'),
						'labels' 			=> array(	'name' 					=> __('Video','templatic'),
														'singular_name' 		=> __('Video','templatic'),
														'add_new' 				=> __('Add Video','templatic'),
														'add_new_item' 			=> __('Add New Video','templatic'),
														'edit' 					=> __('Edit','templatic'),
														'edit_item' 			=> __('Edit Video','templatic'),
														'new_item' 				=> __('New Video','templatic'),
														'view_item'				=> __('View Video','templatic'),
														'search_items' 			=> __('Search Videos','templatic'),
														'not_found' 			=> __('No Videos found','templatic'),
														'not_found_in_trash' 	=> __('No Videos found in trash','templatic')	),
						'public' 			=> true,
						'can_export'		=> true,
						'show_ui' 			=> true, // UI in admin panel
						'_builtin' 			=> false, // It's a custom post type, not built in
						'_edit_link' 		=> 'post.php?post=%d',
						'capability_type' 	=> 'post',
						'menu_icon' 		=> get_bloginfo('template_url').'/images/favicon.ico',
						'hierarchical' 		=> false,
						'rewrite' 			=> array("slug" => "videos"), // Permalinks
						'query_var' 		=> "videos", // This goes to the WP_Query schema
						'supports' 			=> array(	'title',
														'author', 
														'excerpt',
														'thumbnail',
														'comments',
														'editor', 
														'trackbacks',
														'custom-fields',
														'revisions') ,
						'show_in_nav_menus'	=> true ,
						'taxonomies'		=> array('videoscategory','videostags')
					)
				);

// Register custom taxonomy
register_taxonomy(	"videoscategory", 
				array(	"videos"	), 
				array (	"hierarchical" 		=> true, 
						"label" 			=> "Category", 
						'labels' 			=> array(	'name' 				=> __('Category','templatic'),
														'singular_name' 	=> __('Category','templatic'),
														'search_items' 		=> __('Search Category','templatic'),
														'popular_items' 	=> __('Popular Category','templatic'),
														'all_items' 		=> __('All Category','templatic'),
														'parent_item' 		=> __('Parent Category','templatic'),
														'parent_item_colon' => __('Parent Category:','templatic'),
														'edit_item' 		=> __('Edit Category','templatic'),
														'update_item'		=> __('Update Category','templatic'),
														'add_new_item' 		=> __('Add New Category','templatic'),
														'new_item_name' 	=> __('New Make Category','templatic')	), 
						'public' 			=> true,
						'show_ui' 			=> true,
						"rewrite" 			=> true	)
				);
register_taxonomy(	"videostags", 
				array(	"videos"	), 
				array(	"hierarchical" 		=> false, 
						"label" 			=> "Tags", 
						'labels' 			=> array(	'name' 				=> __('Tags','templatic'),
														'singular_name' 	=> __('Tags','templatic'),
														'search_items' 		=> __('Video Tags','templatic'),
														'popular_items' 	=> __('Popular Video Tags','templatic'),
														'all_items' 		=> __('All Video Tags','templatic'),
														'parent_item' 		=> __('Parent Video Tags','templatic'),
														'parent_item_colon' => __('Parent Video Tags:','templatic'),
														'edit_item' 		=> __('Edit Video Tags','templatic'),
														'update_item'		=> __('Update Video Tags','templatic'),
														'add_new_item' 		=> __('Add New Video Tags','templatic'),
														'new_item_name' 	=> __('New Video Tags Name','templatic')	),  
						'public' 			=> true,
						'show_ui' 			=> true,
						"rewrite" 			=> true	)
				);
}
//===============Custom SECTION END================

/////The filter code to get the custom post type in the RSS feed
function myfeed_request($qv) {
	if (isset($qv['feed']))
		$qv['post_type'] = get_post_types();
	return $qv;
}
add_filter('request', 'myfeed_request');

?>