<?php 
/*************************************************************
* Do not modify unless you know what you're doing, SERIOUSLY!
*************************************************************/
//error_reporting(E_ERROR);

load_theme_textdomain('default');
/*load_textdomain( 'default', TEMPLATEPATH.'/en_US.mo' );*/

define('CUSTOM_CATEGORY_TYPE1','videoscategory');
if (defined('WP_DEBUG') and WP_DEBUG == true){
    error_reporting(E_ALL ^ E_NOTICE);
} else {
    error_reporting(0);
}
global $blog_id;
if(get_option('upload_path') && !strstr(get_option('upload_path'),'wp-content/uploads'))
{
	$upload_folder_path = "wp-content/blogs.dir/$blog_id/files/";
}else
{
	$upload_folder_path = "wp-content/uploads/";
}
global $blog_id;
if($blog_id){ $thumb_url = "&amp;bid=$blog_id";}

if ( function_exists( 'add_theme_support' ) ){
	add_theme_support( 'post-thumbnails' );
	}
define('DOMAIN','templatic');
// Theme variables
require_once (TEMPLATEPATH . '/library/functions/theme_variables.php');

//** ADMINISTRATION FILES **//

    // Theme admin functions
    require_once ($functions_path . 'admin_functions.php');

    // Theme admin options
    require_once ($functions_path . 'admin_options.php');

    // Theme admin Settings
    require_once ($functions_path . 'admin_settings.php');

   
//** FRONT-END FILES **//

    // Widgets
    require_once ($functions_path . 'widgets_functions.php');

    // Custom
    require_once ($functions_path . 'custom_functions.php');


    // Comments
    require_once ($functions_path . 'comments_functions.php');
	
	// require_once ($functions_path . 'yoast-canonical.php');

	require_once ($functions_path . 'yoast-breadcrumbs.php');
	
	require_once ($functions_path . 'most-popular.php');
	
	include_once ($functions_path . 'custom_post_type.php'); // custom texonomy
	
//theme.php
add_action("admin_head", "autoinstall_admin_header"); // please comment this line if you wish to DEACTIVE SAMPLE DATA INSERT.
function autoinstall_admin_header(){
	global $wpdb;
	if(strstr($_SERVER['REQUEST_URI'],'themes.php') && !isset($_REQUEST['template']) && !isset($_GET['page'])){
		if(isset($_REQUEST['dummy']) && $_REQUEST['dummy']=='del'){
			delete_dummy_data();	
			wp_redirect(admin_url().'themes.php');
		}
		if(isset($_REQUEST['dummy_insert'])){
			require_once (TEMPLATEPATH . '/auto_install.php');
			wp_redirect(admin_url().'themes.php');
		}
		$menu_msg = "<p><b>CUSTOMIZE:</b> <a href='".site_url("/wp-admin/customize.php")."'><b>Customize your Theme Options.</b></a><br/> <b>HELP:</b> <a href='http://templatic.com/docs/video-theme-guide/'> <b>Theme Documentation Guide</b></a> | <b>SUPPORT:</b><a href='http://templatic.com/forums'> <b>Community Forum</b></a></p>";
		$post_counts = $wpdb->get_var("select count(post_id) from $wpdb->postmeta where (meta_key='pt_dummy_content' || meta_key='tl_dummy_content') and meta_value=1");
		if($post_counts>0){
			$dummy_data_msg = 'Sample data has been <b>populated</b> on your site. Your sample portal website is ready, click <strong><a href='.site_url().'>here</a></strong> to see how its looks.'.$menu_msg.'<p> Wish to delete sample data?  <a class="button_delete button-primary" href="'.home_url().'/wp-admin/themes.php?dummy=del">Yes Delete Please!</a></p>';
		}else{
			$dummy_data_msg = 'Install sample data: Would you like to <b>auto populate</b> sample data on your site?  <a class="button_insert button-primary" href="'.home_url().'/wp-admin/themes.php?dummy_insert=1">Yes, insert please</a>'.$menu_msg;
		}
		echo '<div id="ajax-notification" class="updated templatic_autoinstall"><p> '.$dummy_data_msg.'</p></div>';
	}
}
function delete_dummy_data(){
	global $wpdb;
	delete_option('sidebars_widgets'); //delete widgets
	$productArray = array();
	$pids_sql = "select p.ID from $wpdb->posts p join $wpdb->postmeta pm on pm.post_id=p.ID where (meta_key='pt_dummy_content' || meta_key='tl_dummy_content') and meta_value=1";
	$pids_info = $wpdb->get_results($pids_sql);
	foreach($pids_info as $pids_info_obj){
		wp_delete_post($pids_info_obj->ID,true);
	}
}
	
	function get_image_cutting_edge($args=array())
{
	if(isset($args['image_cut']))
	{
		$cut_post =$args['image_cut'];
	}else
	{
		$cut_post = get_option('ptthemes_image_x_cut');
	}
	$thumb_url='';
	if($cut_post)
	{		
		if($cut_post=='top')
		{
			$thumb_url .= "&amp;a=t";	
		}elseif($cut_post=='bottom')
		{
			$thumb_url .= "&amp;a=b";	
		}elseif($cut_post=='left')
		{
			$thumb_url .= "&amp;a=l";
		}elseif($cut_post=='right')
		{
			$thumb_url .= "&amp;a=r";
		}elseif($cut_post=='top right')
		{
			$thumb_url .= "&amp;a=tr";
		}elseif($cut_post=='top left')
		{
			$thumb_url .= "&amp;a=tl";
		}elseif($cut_post=='bottom right')
		{
			$thumb_url .= "&amp;a=br";
		}elseif($cut_post=='bottom left')
		{
			$thumb_url .= "&amp;a=bl";
		}
	}
	return $thumb_url;
}

add_action( 'after_setup_theme', 'setup' );
function setup() {
        add_theme_support( 'post-thumbnails' ); // This feature enables post-thumbnail support for a theme  
		add_image_size( 'listing-thumb', 250, 180, true ); //(cropped)
		add_image_size( 'video-thumb', 123, 100, true ); //(cropped)
		add_image_size( 'small-thumb', 94, 75, true ); //(cropped)
		add_image_size( 'category-thumb', 158, 105, true ); //(cropped)
}

add_filter( 'image_size_names_choose', 'custom_image_sizes_crop' );
function custom_image_sizes_crop( $sizes ) {
	$custom_sizes = array(
		'listing-thumb' => 'Listing Thumb',
		'video-thumb' => 'Video Thumb',
		'small-thumb' => 'Small Thumb',
		'category-thumb' => 'Category Thumb'
	);
	return array_merge( $sizes, $custom_sizes );
}
add_action('admin_footer','delete_sample_data');
if(!function_exists('delete_sample_data')){
function delete_sample_data()
{
?>
<script type="text/javascript">
jQuery(document).ready( function(){
	jQuery('.button_delete').click( function() {
		if(confirm('All the sample data and your modifications done with it, will be deleted forever! Still you want to proceed?')){
			window.location = "<?php echo home_url()?>/wp-admin/themes.php?dummy=del";
		}else{
			return false;
		}	
	});
});
</script>
<?php } }?>