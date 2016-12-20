<?php 

// Custom fields for WP write panel
// This code is protected under Creative Commons License: http://creativecommons.org/licenses/by-nc-nd/3.0/


//Custom Settings

$pt_metaboxes = array(
		"video" => array (
			"name"		=> "video",
			"default" 	=> "",
			"label" 	=> "Custom Video code",
			"type" 		=> "textarea",
			"desc"      => "Enter Embedded code for video. Example : You can get the code from youtube, vimeo, etc websites"
		),
		"time" => array (
			"name"		=> "time",
			"default" 	=> "",
			"label" 	=> "Video Time",
			"type" 		=> "text",
			"desc"      => "Enter video playback time (ex.2:02,2:42)"
		),
		"twitter" => array (
			"name"		=> "twitter",
			"default" 	=> "",
			"label" 	=> "Video Author Twitter ID",
			"type" 		=> "text",
			"desc"      => "Twitter ID (ex.http://twitter.com/templatic)"
		),
		"facebook" => array (
			"name"		=> "facebook",
			"default" 	=> "",
			"label" 	=> "Video Author Facebook ID",
			"type" 		=> "text",
			"desc"      => "Facebook ID (ex.http://facebook.com/templatic)"
		),
	);

// Excerpt length

// Custom fields for WP write panel
// This code is protected under Creative Commons License: http://creativecommons.org/licenses/by-nc-nd/3.0/

function ptthemes_meta_box_content() {
    global $post, $pt_metaboxes;
    $output = '';
    $output .= '<div class="pt_metaboxes_table">'."\n";
    foreach ($pt_metaboxes as $pt_id => $pt_metabox) {
    if($pt_metabox['type'] == 'text' OR $pt_metabox['type'] == 'select' OR $pt_metabox['type'] == 'checkbox' OR $pt_metabox['type'] == 'textarea')
            $pt_metaboxvalue = get_post_meta($post->ID,$pt_metabox["name"],true);
            if ($pt_metaboxvalue == "" || !isset($pt_metaboxvalue)) {
                $pt_metaboxvalue = $pt_metabox['default'];
            }
            if($pt_metabox['type'] == 'text'){
            
                $output .= "\t".'<div>';
                $output .= "\t\t".'<br/><p><strong><label for="'.$pt_id.'">'.$pt_metabox['label'].'</label></strong></p>'."\n";
                $output .= "\t\t".'<p><input size="100" class="pt_input_text" type="'.$pt_metabox['type'].'" value="'.$pt_metaboxvalue.'" name="ptthemes_'.$pt_metabox["name"].'" id="'.$pt_id.'"/></p>'."\n";
                $output .= "\t\t".'<p><span style="font-size:11px">'.$pt_metabox['desc'].'</span></p>'."\n";
                $output .= "\t".'</div>'."\n";
                              
            }
            
            elseif ($pt_metabox['type'] == 'textarea'){
            			
				$output .= "\t".'<div>';
                $output .= "\t\t".'<br/><p><strong><label for="'.$pt_id.'">'.$pt_metabox['label'].'</label></strong></p>'."\n";
                $output .= "\t\t".'<p><textarea rows="5" cols="98" class="pt_input_textarea" name="ptthemes_'.$pt_metabox["name"].'" id="'.$pt_id.'">' . $pt_metaboxvalue . '</textarea></p>'."\n";
                $output .= "\t\t".'<p><span style="font-size:11px">'.$pt_metabox['desc'].'</span></p>'."\n";
                $output .= "\t".'</div>'."\n";
                              
            }

            elseif ($pt_metabox['type'] == 'select'){
                            
                $output .= "\t".'<div>';
                $output .= "\t\t".'<br/><p><strong><label for="'.$pt_id.'">'.$pt_metabox['label'].'</label></strong></p>'."\n";
                $output .= "\t\t".'<p><select class="pt_input_select" id="'.$pt_id.'" name="ptthemes_'. $pt_metabox["name"] .'"></p>'."\n";
                $output .= '<option>Select a Upload</option>';
                
                $array = $pt_metabox['options'];
                
                if($array){
                    foreach ( $array as $id => $option ) {
                        $selected = '';
                        if($pt_metabox['default'] == $option){$selected = 'selected="selected"';} 
                        if($pt_metaboxvalue == $option){$selected = 'selected="selected"';}
                        $output .= '<option value="'. $option .'" '. $selected .'>' . $option .'</option>';
                    }
                }
                
                $output .= '</select><p><span style="font-size:11px">'.$pt_metabox['desc'].'</span></p>'."\n";
                $output .= "\t".'</div>'."\n";
            }
            
            elseif ($pt_metabox['type'] == 'checkbox'){
                if($pt_metaboxvalue == 'on') { $checked = 'checked="checked"';} else {$checked='';}
                
				$output .= "\t".'<div>';
                $output .= "\t\t".'<br/><p><strong><label for="'.$pt_id.'">'.$pt_metabox['label'].'</label></strong></p>'."\n";
                $output .= "\t\t".'<p><input type="checkbox" '.$checked.' class="pt_input_checkbox"  id="'.$pt_id.'" name="ptthemes_'. $pt_metabox["name"] .'" /></p>'."\n";
                $output .= "\t\t".'<p><span style="font-size:11px">'.$pt_metabox['desc'].'</span></p>'."\n";
                $output .= "\t".'</div>'."\n";

            }
        
        }
    
    $output .= '</div>'."\n\n";
    echo $output;
}

function ptthemes_metabox_insert() {
    global $pt_metaboxes;
    global $globals;
	if(isset($_POST['post_ID']) && $_POST['post_ID'] !='')
    $pID = $_POST['post_ID'];
    $counter = 0;

    
    foreach ($pt_metaboxes as $pt_metabox) { // On Save.. this gets looped in the header response and saves the values submitted
    if($pt_metabox['type'] == 'text' OR $pt_metabox['type'] == 'select' OR $pt_metabox['type'] == 'checkbox' OR $pt_metabox['type'] == 'textarea') // Normal Type Things...
        {
            $var = "ptthemes_".$pt_metabox["name"];
            if (isset($_POST[$var])) {            
                if( get_post_meta( $pID, $pt_metabox["name"] ) == "" )
                    add_post_meta($pID, $pt_metabox["name"], $_POST[$var], true );
                elseif($_POST[$var] != get_post_meta($pID, $pt_metabox["name"], true))
                    update_post_meta($pID, $pt_metabox["name"], $_POST[$var]);
                elseif($_POST[$var] == "")
                    delete_post_meta($pID, $pt_metabox["name"], get_post_meta($pID, $pt_metabox["name"], true));
            }  
        } 
    }
}

function ptthemes_header_inserts(){
	echo '<link rel="stylesheet" type="text/css" href="'.get_template_directory_uri().'/library/functions/admin_style.css" media="screen" />';
}

function ptthemes_meta_box() {
    if ( function_exists('add_meta_box') ) {
		 add_meta_box('ptthemes-settings',$GLOBALS['themename'].' Custom Settings','ptthemes_meta_box_content','videos','normal','high');
    }
}

add_action('admin_menu', 'ptthemes_meta_box');
add_action('admin_head', 'ptthemes_header_inserts');
add_action('save_post', 'ptthemes_metabox_insert');


function relativeDate($posted_date) {
    
    $tz = 0;    // change this if your web server and weblog are in different timezones
                // see project page for instructions on how to do this
    
    $month = substr($posted_date,4,2);
    
    if ($month == "02") { // february
    	// check for leap year
    	$leapYear = isLeapYear(substr($posted_date,0,4));
    	if ($leapYear) $month_in_seconds = 2505600; // leap year
    	else $month_in_seconds = 2419200;
    }
    else { // not february
    // check to see if the month has 30/31 days in it
    	if ($month == "04" or 
    		$month == "06" or 
    		$month == "09" or 
    		$month == "11")
    		$month_in_seconds = 2592000; // 30 day month
    	else $month_in_seconds = 2678400; // 31 day month;
    }
  
/* 
some parts of this implementation borrowed from:
http://maniacalrage.net/archives/2004/02/relativedatesusing/ 
*/
  
    $in_seconds = strtotime(substr($posted_date,0,8).' '.
                  substr($posted_date,8,2).':'.
                  substr($posted_date,10,2).':'.
                  substr($posted_date,12,2));
    $diff = time() - ($in_seconds + ($tz*3600));
    $months = floor($diff/$month_in_seconds);
    $diff -= $months*2419200;
    $weeks = floor($diff/604800);
    $diff -= $weeks*604800;
    $days = floor($diff/86400);
    $diff -= $days*86400;
    $hours = floor($diff/3600);
    $diff -= $hours*3600;
    $minutes = floor($diff/60);
    $diff -= $minutes*60;
    $seconds = $diff;

    if ($months>0) {
        // over a month old, just show date ("Month, Day Year")
        echo ''; the_time('F jS, Y');
    } else {
        if ($weeks>0) {
            // weeks and days
            $relative_date .= ($relative_date?', ':'').$weeks.' '.get_option('ptthemes_relative_week').''.($weeks>1?''.get_option('ptthemes_relative_s').'':'');
            $relative_date .= $days>0?($relative_date?', ':'').$days.' '.get_option('ptthemes_relative_day').''.($days>1?''.get_option('ptthemes_relative_s').'':''):'';
        } elseif ($days>0) {
            // days and hours
            $relative_date .= ($relative_date?', ':'').$days.' '.get_option('ptthemes_relative_day').''.($days>1?''.get_option('ptthemes_relative_s').'':'');
            $relative_date .= $hours>0?($relative_date?', ':'').$hours.' '.get_option('ptthemes_relative_hour').''.($hours>1?''.get_option('ptthemes_relative_s').'':''):'';
        } elseif ($hours>0) {
            // hours and minutes
            $relative_date .= ($relative_date?', ':'').$hours.' '.get_option('ptthemes_relative_hour').''.($hours>1?''.get_option('ptthemes_relative_s').'':'');
            $relative_date .= $minutes>0?($relative_date?', ':'').$minutes.' '.get_option('ptthemes_relative_minute').''.($minutes>1?''.get_option('ptthemes_relative_s').'':''):'';
        } elseif ($minutes>0) {
            // minutes only
            $relative_date .= ($relative_date?', ':'').$minutes.' '.get_option('ptthemes_relative_minute').''.($minutes>1?''.get_option('ptthemes_relative_s').'':'');
        } else {
            // seconds only
            $relative_date .= ($relative_date?', ':'').$seconds.' '.get_option('ptthemes_relative_minute').''.($seconds>1?''.get_option('ptthemes_relative_s').'':'');
        }
        
        // show relative date and add proper verbiage
    	echo ''.get_option('ptthemes_relative_posted').' '.$relative_date.' '.get_option('ptthemes_relative_ago').'';
    }
    
}

function isLeapYear($year) {
        return $year % 4 == 0 && ($year % 400 == 0 || $year % 100 != 0);
}

    if(!function_exists('how_long_ago')){
        function how_long_ago($timestamp){
            $difference = time() - $timestamp;

            if($difference >= 60*60*24*365){        // if more than a year ago
                $int = intval($difference / (60*60*24*365));
                $s = ($int > 1) ? ''.get_option('ptthemes_relative_s').'' : '';
                $r = $int . ' '.get_option('ptthemes_relative_year').'' . $s . ' '.get_option('ptthemes_relative_ago').'';
            } elseif($difference >= 60*60*24*7*5){  // if more than five weeks ago
                $int = intval($difference / (60*60*24*30));
                $s = ($int > 1) ? ''.get_option('ptthemes_relative_s').'' : '';
                $r = $int . ' '.get_option('ptthemes_relative_month').'' . $s . ' '.get_option('ptthemes_relative_ago').'';
            } elseif($difference >= 60*60*24*7){        // if more than a week ago
                $int = intval($difference / (60*60*24*7));
                $s = ($int > 1) ? ''.get_option('ptthemes_relative_s').'' : '';
                $r = $int . ' '.get_option('ptthemes_relative_week').'' . $s . ' '.get_option('ptthemes_relative_ago').'';
            } elseif($difference >= 60*60*24){      // if more than a day ago
                $int = intval($difference / (60*60*24));
                $s = ($int > 1) ? ''.get_option('ptthemes_relative_s').'' : '';
                $r = $int . ' '.get_option('ptthemes_relative_day').'' . $s . ' '.get_option('ptthemes_relative_ago').'';
            } elseif($difference >= 60*60){         // if more than an hour ago
                $int = intval($difference / (60*60));
                $s = ($int > 1) ? ''.get_option('ptthemes_relative_s').'' : '';
                $r = $int . ' '.get_option('ptthemes_relative_hour').'' . $s . ' '.get_option('ptthemes_relative_ago').'';
            } elseif($difference >= 60){            // if more than a minute ago
                $int = intval($difference / (60));
                $s = ($int > 1) ? ''.get_option('ptthemes_relative_s').'' : '';
                $r = $int . ' '.get_option('ptthemes_relative_minute').'' . $s . ' '.get_option('ptthemes_relative_ago').'';
            } else {                                // if less than a minute ago
                $r = ''.get_option('ptthemes_relative_moments').' '.get_option('ptthemes_relative_ago').'';
            }

            return $r;
        }
    }
	
	
/* popular posts*/



$mostwanted_ver = "0.1.9v";

$total_hits = -1;
//$futureSpamOption = "";
$futureSpamOption = "and spam=0";
$cache_until = 0;
$cached_result = "";

// what's the table name?
$tablestattraq = $table_prefix . 'stattraq';


function rjb_mostwanted($top_n=5, $curtail=0, $showviews=false, $show_views_in_tt=true, $duration = null, $pre="<li>", $post="</li>", $method="ip", $as_percentage = false) {
    MostWanted::mostwanted($top_n, $curtail, $showviews, $show_views_in_tt, $duration, $pre, $post, $method, $as_percentage);
}

	function mostwanted_conf() {
		global $tablestattraq;
	?>
	<div class="wrap">
		<h2>MostWanted Configuration</h2>
		<?php
			if ( isset($_POST['submit']) ) {
				MostWanted::fixstats($_POST['sleep']);
			} else { ?>
				<p>MostWanted uses the database tables from StatTraq to provide a list of the most popular articles.</p>
				<p>There is a small quirk in StatTraq that results in all page views showing up as &quot;Multiple Posts&quot; in cases where permalinks are used.  These stats are not lost, they&apos;re just incorrectly recorded, and can be fixed.</p>

				<p>Currently there are <?php 
				
				global $wpdb;
				
				$q = "SELECT count(*) FROM $tablestattraq WHERE article_id = '0' AND url LIKE '/index.php?name=%'";
				$potential = $wpdb->get_var( $q );
            _e( $potential );
				
				?> rows in your database that could be repaired.</p>
				
				<p>Between each update, the fix mechanism can pause in order to give the database a rest.  This is handy if you're running a live service and don't want the update to be noticed - a value of &quot;0&quot; can safely be used if you are the sole user of the DB and you just want to get the fix done.</p>
				<form action="" method="post" id="akismet-conf" style="margin: auto; width: 25em; ">
					<p>Pause time (in seconds)<input type="text" name="sleep" value="1" /></p>
					<p class="submit"><input type="submit" name="submit" value="Fix stats &raquo;" /></p>
				</form><?php 
			}
		?>
	</div>
	<?php	
	}

class MostWanted {

	function config_page() {
		global $wpdb;
	//	if ( function_exists('add_theme_page') )
			//add_theme_page('plugins.php', 'MostWanted Configuration', 'MostWanted Config', 1, basename(__FILE__), 'mostwanted_conf');
	}

	
	function mostwanted($top_n=5, $curtail=0, $showviews=false, $show_views_in_tt=true, $duration="", $pre="<li>", $post="</li>", $method="ip", $as_percentage = false, $timeout=1800){
		global $wpdb, $tablestattraq, $tableposts, $user_level, $mostwanted_ver, $total_hits, $cache_until, $cached_result;

		$time_now = time();
		if ($time_now > $cache_until) {
			// the cache_until time has been passed so the cache is invalid.
			// the content must therefore be regenerated.
			$cache_until = $time_now+$timeout;
			_e("<!-- MostWanted Generated ".$time_now." Expires ".$cache_until." -->");

			get_currentuserinfo();

   		$dateOption = "";
        	$durationExplained = "";
			if ($duration != "") {
				$dateOption .= "AND DATE_SUB(CURDATE(),INTERVAL ".$duration." DAY) < st.access_time";
				$durationExplained = " in the last ".$duration." days";
			}
			if ($method == "ip") {
				$method="ip_address";
			} else {
				$method="session_id";
			}

			$distinct = ($as_percentage?" of":"")." distinct viewers";

			$q = "SELECT p.post_title, st.article_id, COUNT( DISTINCT (st.$method) ) as cnt FROM $tablestattraq st, $tableposts p where p.ID=st.article_id AND p.post_status='publish' ".$futureSpamOption." AND st.user_agent_type='0' ".$dateOption." GROUP BY st.article_id ORDER BY cnt DESC LIMIT 0,$top_n";
			$output = $wpdb->get_results( $q );
			$cached_result="";

			_e("<!-- ");
			_e($q);
			_e(" -->");

        if (isset($output)) {
            foreach ($output as $line) {
                if ($showviews) {
                    $views = " ".MostWanted::getHits($as_percentage, $line->cnt, $dateOption)."";
                }
                if ($show_views_in_tt) {
                    $ttviews = " (".MostWanted::getHits($as_percentage, $line->cnt, $dateOption).$distinct.$durationExplained.")".$append;
                }
					 
                $short = MostWanted::curtail($line->post_title, $curtail) ;
                $t= str_replace("'","&apos;", $line->post_title);
                
					 $cached_result .= $pre . "<a title='". $t . $ttviews . "' href='" . get_permalink($line->article_id) . "'>" . ($short) . "</a>".$post;
            }
        } else {
            $cached_result .= $pre . "No results available.".$post;
        }
		} else {
			_e("<!-- MostWanted Cache Hit -->");
			// the cache is still valid
			// there no need to do anything 
		}
		echo $cached_result;

		// reset the hits value so it is checked once when
		// the next page is loaded.
		$total_hits = -1;
		return;
    }


	function getHits($as_percentage, $count, $dateOption) {
		global $total_hits, $wpdb;
		// start percentage lookup
		if ($as_percentage) {
			// get the total number of hits if it's not known already
			if ($total_hits == -1) {
				$q = "SELECT COUNT( * ) as cnt FROM $tablestattraq st where st.user_agent_type='0'" . $futureSpamOption." ".$dateOption;
				$total_hits = $wpdb->get_var( $q );
			}
			return "" . round((($count / $total_hits) * 100), 1) . "%";
		} else {
			return $count;
		}
		// end percentage lookup
	}


	// trims a message down so that it is shorter than the length
	// specified in the $trim_chars argument.
	function curtail($trim_this, $trim_chars=0) {
		if ($trim_chars > 0 && strlen($trim_this) > $trim_chars) {
			return substr($trim_this,0,($trim_chars-3)) . “…”;
		}
		return $trim_this;
	}


	// adds a signature to the end of your page describing the 
	// version of MostWanted, which is rather handy when debugging
	// from afar.
	function signature() {
		global $mostwanted_ver;
		echo "\n\n<link href='http://boakes.org/most-wanted?v=".$mostwanted_ver."' />\n";
	}


	// This utility method is not used by the main plugin.  It is as a
	// repair tool for stattraq data which may be incorrectly recorded
	// without an article_id, which means that the data can't show up
	// in the MostWanted output.
	//
	// If you've not hacked your stattraq plugin to fix this, then
	// a call to this method will repair all entries in your database.
    function fixstats($sleep = 1){
        global $wpdb, $tablestattraq, $tableposts;
        get_currentuserinfo();

        // calculate duration
        $output = $wpdb->get_results( "SELECT COUNT( DISTINCT (ID) ) as cnt FROM $wpdb->posts;" );
        foreach ($output as $line) {
            $duration = ($sleep * $line->cnt) /60;
        }
        _e("<p>MostWanted is now updating your stattraq database as a LOW_PRIORITY task.  This will probably take around " . $duration . " minutes.  Your previous statistics are being ever-so-slightly-repaired.  Every record of a post that was accessed using a permalink is having it's post id added to it.</p><ol>",'templatic');
        _e("<p>This page shows the progress of that process.  If you wander off to another page, the process will continue in the background, but you won't know precicely when it's complete.</p>",'templatic');
        $output = $wpdb->get_results( "SELECT id, post_name FROM $wpdb->posts where post_status = 'publish' ORDER BY id DESC;" );

        foreach ($output as $line) {
            $q = "SELECT count(*) from $tablestattraq WHERE (article_id = '0' and url like '%name=" . $line->post_name . "%');";
            $changes = $wpdb->get_var( $q );

				if ($changes > 0) {
	            $q = "UPDATE low_priority $tablestattraq SET article_id = '" . $line->id . "' WHERE (article_id = '0' and url like '%name=" . $line->post_name . "%');";
	            _e("<li class='active'><span class='name'>Converting " . $line->post_name,'templatic');
   	         $o2 = $wpdb->get_results( $q );
					_e(" - $changes rows altered",'templatic');
		   
	 				if ($sleep > 0) {
					 	_e(" - sleeping for " . $sleep . " seconds",'templatic');
					}
					_e("</span></li>");
            	flush();
            	sleep($sleep);
				} else {
	            _e("<li>Skipping " . $line->post_name . " because no rows require update</li>");
				}
            ob_end_flush();
        }
        _e("</ol>");
        _e("<h1>Finished!</h1>");
       return;
    }
}

add_action('wp_head', array('MostWanted', 'signature'));
add_action('admin_menu', array('MostWanted', 'config_page'));

// NOTE the ">" symbol in the following line must
// be the last character in the file - do not add
// any spaces, tabs or newlines after it, or you
// will get "header already sent" errors.
	
	
/*
Plugin Name: WP-PageNavi 
Plugin URI: http://www.lesterchan.net/portfolio/programming.php 
*/ 

function wp_pagenavi($before = '', $after = '', $prelabel = '', $nxtlabel = '', $pages_to_show = 5, $always_show = false) {

	global $request, $posts_per_page, $wpdb, $paged;
	if(empty($prelabel)) {
		$prelabel  = '<strong>&laquo;</strong>';
	}
	if(empty($nxtlabel)) {
		$nxtlabel = '<strong>&raquo;</strong>';
	}
	$half_pages_to_show = round($pages_to_show/2);
	if (!is_single()) {
		if(is_tag()) {
			preg_match('#FROM\s(.*)\sGROUP BY#siU', $request, $matches);		
		} elseif (!is_category()) {
			preg_match('#FROM\s(.*)\sORDER BY#siU', $request, $matches);	
		} else {
			preg_match('#FROM\s(.*)\sGROUP BY#siU', $request, $matches);		
		}
		$fromwhere = $matches[1];
		$numposts = $wpdb->get_var("SELECT COUNT(DISTINCT ID) FROM $fromwhere");
		$max_page = ceil($numposts /$posts_per_page);
		if(empty($paged)) {
			$paged = 1;
		}
		if($max_page > 1 || $always_show) {
			echo "$before <div class='Navi'>";
			if ($paged >= ($pages_to_show-1)) {
				echo '<a href="'.get_pagenum_link().'">&laquo; '.get_option('ptthemes_pagination_first_name').'</a>';
			}
			previous_posts_link($prelabel);
			for($i = $paged - $half_pages_to_show; $i  <= $paged + $half_pages_to_show; $i++) {
				if ($i >= 1 && $i <= $max_page) {
					if($i == $paged) {
						echo "<strong class='on'>$i</strong>";
					} else {
						echo ' <a href="'.get_pagenum_link($i).'">'.$i.'</a> ';
					}
				}
			}
			next_posts_link($nxtlabel, $max_page);
			if (($paged+$half_pages_to_show) < ($max_page)) {
				echo '<a href="'.get_pagenum_link($max_page).'">'.get_option('ptthemes_pagination_last_name').' &raquo;</a>';
			}
			echo "</div> $after";
		}
	}
}

// Use Noindex for sections specified in theme admin

function ptthemes_noindex_head() { 

	$meta_string='';
    if ((is_category() && get_option('ptthemes_noindex_category')) ||
	    (is_tag() && get_option('ptthemes_noindex_tag')) ||
		(is_day() && get_option('ptthemes_noindex_daily')) ||
		(is_month() && get_option('ptthemes_noindex_monthly')) ||
		(is_year() && get_option('ptthemes_noindex_yearly')) ||
		(is_author() && get_option('ptthemes_noindex_author')) ||
		(is_search() && get_option('ptthemes_noindex_search'))) {

		$meta_string .= '<meta name="robots" content="noindex,follow" />';
	}
	
	echo $meta_string;
	
}

add_action('wp_head', 'ptthemes_noindex_head');

///////////NEW FUNCTIONS  START//////
function bdw_get_images($iPostID,$img_size='thumb') 
{
    $arrImages =& get_children('order=ASC&orderby=menu_order ID&post_type=attachment&post_mime_type=image&post_parent=' . $iPostID );
	//$images =& get_children( 'post_type=attachment&post_mime_type=image' );
	//$videos =& get_children( 'post_type=attachment&post_mime_type=video/mp4' );
	$return_arr = array();
	if($arrImages) 
	{		
       foreach($arrImages as $key=>$val)
	   {
	   		$id = $val->ID;
			if($img_size == 'large')
			{
				//$return_arr[] = '<img src="'.wp_get_attachment_url($id).'" alt="">';	// THE FULL SIZE IMAGE INSTEAD
				$img_arr = wp_get_attachment_image_src($id,'full');	// THE FULL SIZE IMAGE INSTEAD
				$return_arr[] = $img_arr[0];
			}
			elseif($img_size == 'medium')
			{
				//$return_arr[] = '<img src="'.wp_get_attachment_url($id, $size='medium').'" alt="">'; //THE medium SIZE IMAGE INSTEAD
				$img_arr = wp_get_attachment_image_src($id, 'medium'); //THE medium SIZE IMAGE INSTEAD
				$return_arr[] = $img_arr[0];
			}
			elseif($img_size == 'thumb')
			{
				//$return_arr[] = '<img src="'.wp_get_attachment_thumb_url($id).'" alt="">'; // Get the thumbnail url for the attachment
				$img_arr = wp_get_attachment_image_src($id, 'thumbnail'); // Get the thumbnail url for the attachment
				$return_arr[] = $img_arr[0];
				
			}
	   }
	  return $return_arr;
	}
}

function bdw_get_images_with_info($iPostID,$img_size='thumb') 
{
    $arrImages =& get_children('order=ASC&orderby=menu_order ID&post_type=attachment&post_mime_type=image&post_parent=' . $iPostID );
	$return_arr = array();
	if($arrImages) 
	{		
       foreach($arrImages as $key=>$val)
	   {
	   		$id = $val->ID;
			if($img_size == 'large')
			{
				$img_arr = wp_get_attachment_image_src($id,'full');	// THE FULL SIZE IMAGE INSTEAD
				$imgarr['id'] = $id;
				$imgarr['file'] = $img_arr[0];
				$return_arr[] = $imgarr;
			}
			elseif($img_size == 'medium')
			{
				$img_arr = wp_get_attachment_image_src($id, 'medium'); //THE medium SIZE IMAGE INSTEAD
				$imgarr['id'] = $id;
				$imgarr['file'] = $img_arr[0];
				$return_arr[] = $imgarr;
			}
			elseif($img_size == 'thumb')
			{
				$img_arr = wp_get_attachment_image_src($id, 'thumbnail'); // Get the thumbnail url for the attachment
				$imgarr['id'] = $id;
				$imgarr['file'] = $img_arr[0];
				$return_arr[] = $imgarr;
				
			}
			else
			{
				$img_arr = wp_get_attachment_image_src($id, $img_size); // Get the thumbnail url for the attachment
				$imgarr['id'] = $id;
				$imgarr['file'] = $img_arr[0];
				$return_arr[] = $imgarr;
				
			}
	   }
	  return $return_arr;
	}
}

function excerpt($limit=10) {
  $excerpt = explode(' ', get_the_excerpt(),$limit);
  if (count($excerpt)>=$limit) {
    array_pop($excerpt);
    $excerpt = implode(" ",$excerpt).'...';
  } else {
    $excerpt = implode(" ",$excerpt);
  }	
  $excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
  return $excerpt;
}
 
function content($limit) {
  $content = explode(' ', get_the_content(), $limit);
  if (count($content)>=$limit) {
    array_pop($content);
    $content = implode(" ",$content).'...';
  } else {
    $content = implode(" ",$content);
  }	
  $content = preg_replace('/\[.+\]/','', $content);
  $content = apply_filters('the_content', $content); 
  $content = str_replace(']]>', ']]&gt;', $content);
  return $content;
}



function get_related_posts($postdata)
{
	$postCatArr = wp_get_post_categories($postdata->ID);
	$post_array = array();
	for($c=0;$c<count($postCatArr);$c++)
	{
		$category_posts=get_posts('category='.$postCatArr[$c]);
		foreach($category_posts as $post) 
		{
			if($post->ID !=  $postdata->ID)
			{
				$post_array[$post->ID] = $post;
			}
		}
	}
if($post_array)
{
?>
<div class="realated_post clearfix">
<h3><span>Related Posts</span></h3><ul class="categories_list clearfix">
<?php
	$relatedprd_count = 0;
	foreach($post_array as $postval)
	{
		$product_id = $postval->ID;
		$post_title = $postval->post_title;
		$productlink = get_permalink($product_id);
		$post_date = $postval->post_date;
		$comment_count = $postval->comment_count;
		if($postval->post_status == 'publish')
		{
			$post_images = bdw_get_images($postval->ID,'large');
			
			if($post_images[0]!='')
			{
				$relatedprd_count++;
			?>
            <li class="clearfix"> 
             <?php 
            if(get_the_post_thumbnail( $postval->ID, array())){?>
             <a class="video_thumb" href="<?php echo get_permalink($postval->ID) ?>" rel="bookmark" title="<?php the_title(); ?>">
             <?php echo get_the_post_thumbnail( $postval->ID, array(123,100),array('class'	=> "",));?>
             </a>
            <?php }else if($post_images[0]){ global $thumb_url;             
                $thumb_url1 = $thumb_url.get_image_cutting_edge();
            ?>
             <a class="video_thumb" href="<?php echo get_permalink($postval->ID) ?>" rel="bookmark" title="<?php the_title(); ?>">
             <?php
			$img_size = bdw_get_images_with_info($postval->ID,'video-thumb');
			$post_images = $img_size[0]['file'];
		    ?>
             <img src="<?php echo $post_images;?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>"  /> </a>
            <?php
            } else { ?> 
               <a  href="<?php echo get_permalink($postval->ID) ?>"> <span class="img_not_available"> <?php _e('Image Not Available ','templatic');?> </span> </a>
            <?php }?> 
    
   
     
     <p class="title"> <a href="<?php echo $productlink; ?>"><?php echo $post_title; ?></a></p> 
       <p class="author">  by <?php the_author_posts_link(); ?></p>
      
      
            </li>
            <?php
			if($relatedprd_count==4){ break;}
			}
		}
	}
?>
</ul>
</div>
<?php
}
}

function get_blog_sub_cats_str($type='array')
{
	$catid_arr = get_option('ptthemes_blogcategory');
	$blogcatids = '';
	$subcatids_arr = array();
	for($i=0;$i<count($catid_arr);$i++)
	{
		if($catid_arr[$i])
		{
			$subcatids_arr = array_merge($subcatids_arr,array($catid_arr[$i]),get_term_children( $catid_arr[$i],'category'));
		}
	}
	if($subcatids_arr && $type=='string')
	{
		$blogcatids = implode(',',$subcatids_arr);
		return $blogcatids;	
	}else
	{
		return $subcatids_arr;
	}			
}
?>