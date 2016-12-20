<?php
set_time_limit(0);
global  $wpdb;
//require_once (TEMPLATEPATH . '/delete_data.php');
$dummy_image_path = get_template_directory_uri().'/images/dummy/';

//====================================================================================//
/////////////// TERMS START ///////////////
require_once(ABSPATH.'wp-admin/includes/taxonomy.php');
$category_array = array('Blog');
insert_category($category_array);
function insert_category($category_array)
{
	for($i=0;$i<count($category_array);$i++)
	{
		$parent_catid = 0;
		if(is_array($category_array[$i]))
		{
			$cat_name_arr = $category_array[$i];
			for($j=0;$j<count($cat_name_arr);$j++)
			{
				$catname = $cat_name_arr[$j];
				$last_catid = wp_create_category( $catname, $parent_catid);
				if($j==0)
				{
					$parent_catid = $last_catid;
				}
			}
			
		}else
		{
			$catname = $category_array[$i];
			wp_create_category( $catname, $parent_catid);
		}
	}
}
/////////////// TERMS END ///////////////
//====================================================================================//
$post_info = array();
////post start 1///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/img1.jpg";
$image_array[] = "dummy/img2.jpg";
$image_array[] = "dummy/img3.jpg";
$image_array[] = "dummy/img4.jpg";
$image_array[] = "dummy/img5.jpg";
$image_array[] = "dummy/img6.jpg";
$image_array[] = "dummy/img7.jpg";
$post_meta = array(
				   "video"	=> '',
					"tl_dummy_content"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'Stevens Real Legacy',
					"post_content"	=>	'Within two minutes, or even less, he had forgotten all his troubles. Not because his troubles were one whit less heavy and bitter to him than a man are to a man, but because a new and powerful interest bore them down and drove them out of his mind for the time–just as men misfortunes are forgotten in the excitement of new enterprises. This new interest was a valued novelty in whistling, which he had just acquired from a negro, and he was suffering to practise it undisturbed. It consisted in a peculiar bird-like turn, a sort of liquid warble, produced by touching the tongue to the roof of the mouth at short intervals in the midst of the music–the reader probably remembers how to do it, if he has ever been a boy. Diligence and attention soon gave him the knack of it, and he strode down the street with his mouth full of harmony and his soul full of gratitude. He felt much as an astronomer feels who has discovered a new planet–no doubt, as far as strong, deep, unalloyed pleasure is concerned, the advantage was with the boy, not the astronomer

The summer evenings were long. It was not dark, yet. Presently Tomchecked his whistle. A stranger was before him–a boy a shade larger than himself. A new-comer of any age or either sex was an impressive curiosity in the poor little shabby village of St. Petersburg. This boy was well dressed, too–well dressed on a week-day. This was simply astounding. His cap was a dainty thing, his close-buttoned blue cloth roundabout was new and natty, and so were his pantaloons. He had shoes on–and it was only Friday. He even wore a necktie, a bright bit of ribbon. He had a citified air about him that ate into Tom vitals. The more Tom stared at the splendid marvel, the higher he turned up his nose at his finery and the shabbier and shabbier his own outfit seemed to him to grow. Neither boy spoke. If one moved, the other moved–but only sidewise, in a circle; they kept face to face and eye to eye all the time. Finally Tom said:',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Blog'),
					"post_tags"		=>	array('Tags','Sample Tags')
					);
////post end///
////post start 2 ///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/img2.jpg";
$image_array[] = "dummy/img1.jpg";
$image_array[] = "dummy/img3.jpg";
$image_array[] = "dummy/img4.jpg";
$image_array[] = "dummy/img5.jpg";
$image_array[] = "dummy/img6.jpg";
$image_array[] = "dummy/img7.jpg";
$post_meta = array(
				   "video"	=> '',
					"tl_dummy_content"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'Immigration law supporters rally in Arizona',
					"post_content"	=>	'PHOENIX -- Hundreds of people supporting Arizonas new law cracking down on illegal immigration gathered near the state Capitol on Saturday as soaring temperatures were expected to hit 107 degrees. The Pennsylvania-based group Voice of the People USA organized the demonstration, which it touts as a grass-roots effort. Attendees came from every region of the U.S., Voice of the People President Daniel Smeriglio said. The rally turnout fell far short of the march organized by opponents of the law last weekend, when an estimated 20,000 people gathered.The immigration law requires that police conducting traffic stops or questioning people about possible legal violations ask them about their immigration status if there is "reasonable suspicion" that theyre in the country illegally. Reasonable suspicion is not defined. The law also makes it a state crime to be in the country illegally or to impede traffic while hiring day laborers, regardless of the workers immigration status. It would become a crime for illegal immigrants to solicit work. The law takes effect July 29 unless blocked by a court as requested under pending legal challenges. Hundreds of motorcycle riders kicked off the rally by riding in a procession around the Capitol.The rally at a park in downtown Phoenix follows dueling events last weekend that drew thousands of opponents and supporters of the law to the area.',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Blog'),
					"post_tags"		=>	array('New','Popular')
					);
////post end///
////post start 3 ///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/img3.jpg";
$image_array[] = "dummy/img2.jpg";
$image_array[] = "dummy/img1.jpg";
$image_array[] = "dummy/img4.jpg";
$image_array[] = "dummy/img5.jpg";
$image_array[] = "dummy/img6.jpg";
$image_array[] = "dummy/img7.jpg";
$post_meta = array(
				   "video"	=> '',
					"tl_dummy_content"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'Lakers looking to get the low-down again in Game 3 against Celtics',
					"post_content"	=>	'The Lakers went away from their strength, 7-footers Pau Gasol and Andrew Bynum, in the fourth quarter of Game 2 loss. They say they intend to go back to trying to exploit their size advantage in the low post Tuesday in Boston.
	Reporting from Boston The Lakers were dominant down low, the Boston Celtics unable to stop Pau Gasol and Andrew Bynum, when good fortune smiled on the Celtics as a most unusual event took place, something called the start of the fourth quarter.

Gasol had one shot, Bynum had two over the final 12 minutes and the Celtics evened up the NBA Finals with a 103-94 victory in Game 2 on Sunday.

Gasol had 25 points in the game, only one in the fourth quarter, and Bynum had 21 in the game, four in the fourth quarter, part of the reason the Lakers headed to Boston in a deadlocked series that resumes Tuesday with Game 3 at certain-to-be-raucous TD Garden.Neither Garnett (six points) nor Paul Pierce (10 points) were problems for the Lakers in Game 2, though Pierce could be heard proclaiming, "Aint coming back to L.A.," after helping up Kendrick Perkins near the baseline on a play late in the game.

The Lakers issues, more specifically, were Ray Allen hitting from the outside, which is never a shocker, and Rajon Rondo also shooting well from the perimeter, somewhat surprising for the 24-year-old who drives and rebounds as well as any guard in the league but isnt known for his steady shotThe Lakers are looking internally, however, at getting more touches for their big men.

Gasol made seven of 10 shots and Bynum made six of 10, but should Ron Artest really have taken 10 shots, especially since he made only one?

Our big guys played great, Bynum and Paul Lakers Coach Phil Jackson said. We didnt get the ball often enough to them.

Both post players took the diplomatic approach, presumably because the series is so young.

Obviously, we can get more touches Bynum said. But thats still not going to help us beat this team because you cant beat them one on one.

Gasol, to his credit, said the work he and Bynum did down low was not wasted.

I think our effort was a positive thing, Gasol said. And its going to have to be even better, greater in Boston, because its going to be tougher to play there.

The Lakers were also dominant defensively in the paint.',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Blog'),
					"post_tags"		=>	array('Sample Tag')
					);
////post end///
////post start 4 ///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/img4.jpg";
$image_array[] = "dummy/img2.jpg";
$image_array[] = "dummy/img1.jpg";
$image_array[] = "dummy/img3.jpg";
$image_array[] = "dummy/img5.jpg";
$image_array[] = "dummy/img6.jpg";
$image_array[] = "dummy/img7.jpg";
$post_meta = array(
				   "video"	=> '',
					"tl_dummy_content"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'Critics Notebook: Glee sings to a forgotten generation',
					"post_content"	=>	'Journey, Young MC and Cyndi Lauper. The show grooves to the 80s while turning stereotypes on their head. Finally, the music of tail-end boomers is heard.
still till she asked who did the mischief; and then he would tell, and there would be nothing so good in the world as to see that pet model catch it. Glees first season has included such musical blasts from the past as Aerosmiths Dream On, performed by series lead Matthew Morrison, left, and guest star Neil Patrick Harris. Glee allows this particular sliver of between-generations a nostalgia that is, for once, neither borrowed nor assigned.Foxs musical comedy hit Glee has revolutionized TV in many ways (including the fact that TV critics can now write the term musical comedy hit, and who thought that would ever happen?). But watching the recent Safety Dance episode, it all came together: Here is a show celebrating popular music and there isnt even a whiff of boomage.

Those of us who had the misfortune to be born in the first half of the 1960s are truly a lost generation. Not quite boomers, not quite Gen X, we came of age as the Carter White House succumbed to the Reagan years, when women rediscovered shoulder pads and men wore penny loafers with no socks, when everyone found the conceits of Bosom Buddies and Threes Company racy and hilarious. Our musical taste, as I remember it, was eclectic — yes, there was Bruce Springsteen, Aerosmith and Genesis, but there was also Duran Duran, the Go-Gos, Stray Cats, Wham and Men Without Hats.',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Blog'),
					"post_tags"		=>	array('Tag 1')
					);
////post end///
////post start 5 ///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/img5.jpg";
$image_array[] = "dummy/img2.jpg";
$image_array[] = "dummy/img3.jpg";
$image_array[] = "dummy/img1.jpg";
$image_array[] = "dummy/img4.jpg";
$image_array[] = "dummy/img6.jpg";
$image_array[] = "dummy/img7.jpg";
$image_array[] = "dummy/img8.jpg";
$image_array[] = "dummy/img9.jpg";
$post_meta = array(
				   "video"	=> '',
					"tl_dummy_content"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'Apple announces new iPhone 4: the Steve Jobs keynote',
					"post_content"	=>	'Steve Jobs took the stage at Apple Incs Worldwide Developers Conference to announce new features and products from the company.

The chief executive began by giving an update on the iPad. The tablet computing device sold 2 million units in the first two months since its debut and has 8,500 apps on Apples online store. So far, 35 million apps have been downloaded, he said, which breaks down to 17 apps per iPad.In an update on the iPads built-in book software, Jobs said the iBookstore platform had sold more than 5 million books in the first 65 days -- or about 2.5 books per iPad.Further, Jobs said that for five of the six largest publishers, about 22% of e-book purchases are being sold through the iPads bookstore.In an addition to the iBook reading apps functionality, the app will allow users to do inline note-taking.Jobs also invited Netflix CEO Reed Hastings to the stage to announce a new, free Netflix application for the iPhone. Hastings said the Netflix app for iPad has been among the most popular apps in Apples App Store, and No. 1 in the entertainment category.

Its been a tremendous success for us, Hastings said. Its our fastest growing platform.The Netflix iPhone app will be available starting this summer. Marc Pincus, the CEO of Zynga, came to the stage to announce an iPad version of Farmville, which is played by 35 million people every day, largely on Facebook. Jobs said the company crossed 5 billion downloads. He followed that comment with what he called his favorite stat of the whole show, which is that Apple has paid out $1 billion to its app developers. We were thrilled about it, he said. Jobs announces the iPhone 4. Stop me if you have already seen this, he said, referring to the leak of the phone by Gizmodo. But believe me, you aint seen it. Its one of the most beautiful designs you have ever seen. Its beyond a doubt the most precise things and one of the most beautiful things we have ever made. Jobs shows photos of the phone, familiar from the leak. He calls it the thinnest smart phone on the planet, noting that the iPhone 4 is 24% thinner than its predecessor.',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Blog'),
					"post_tags"		=>	array('Apple')
					);
////post end///
////post start 6///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/img6.jpg";
$image_array[] = "dummy/img7.jpg";
$image_array[] = "dummy/img8.jpg";
$image_array[] = "dummy/img9.jpg";
$image_array[] = "dummy/img10.jpg";
$image_array[] = "dummy/img11.jpg";
$image_array[] = "dummy/img12.jpg";
$post_meta = array(
				   "video"	=> '',
					"tl_dummy_content"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'Vehicles travel during rush hour on Interstates 10 and 110 near downtown.',
					"post_content"	=>	'Within two minutes, or even less, he had forgotten all his troubles. Not because his troubles were one whit less heavy and bitter to him than a man are to a man, but because a new and powerful interest bore them down and drove them out of his mind for the time–just as men misfortunes are forgotten in the excitement of new enterprises. This new interest was a valued novelty in whistling, which he had just acquired from a negro, and he was suffering to practise it undisturbed. It consisted in a peculiar bird-like turn, a sort of liquid warble, produced by touching the tongue to the roof of the mouth at short intervals in the midst of the music–the reader probably remembers how to do it, if he has ever been a boy. Diligence and attention soon gave him the knack of it, and he strode down the street with his mouth full of harmony and his soul full of gratitude. He felt much as an astronomer feels who has discovered a new planet–no doubt, as far as strong, deep, unalloyed pleasure is concerned, the advantage was with the boy, not the astronomer.

The summer evenings were long. It was not dark, yet. Presently Tomchecked his whistle. A stranger was before him–a boy a shade larger than himself. A new-comer of any age or either sex was an impressive curiosity in the poor little shabby village of St. Petersburg. This boy was well dressed, too–well dressed on a week-day. This was simply astounding. His cap was a dainty thing, his close-buttoned blue cloth roundabout was new and natty, and so were his pantaloons. He had shoes on–and it was only Friday. He even wore a necktie, a bright bit of ribbon. He had a citified air about him that ate into Tom vitals. The more Tom stared at the splendid marvel, the higher he turned up his nose at his finery and the shabbier and shabbier his own outfit seemed to him to grow. Neither boy spoke. If one moved, the other moved–but only sidewise, in a circle; they kept face to face and eye to eye all the time. Finally Tom said:',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Blog'),
					"post_tags"		=>	array('Tags','Sample Tags')
					);
////post end///
////post start 7 ///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/img7.jpg";
$image_array[] = "dummy/img8.jpg";
$image_array[] = "dummy/img9.jpg";
$image_array[] = "dummy/img10.jpg";
$image_array[] = "dummy/img11.jpg";
$image_array[] = "dummy/img12.jpg";
$image_array[] = "dummy/img1.jpg";
$post_meta = array(
				   "video"	=> '',
					"tl_dummy_content"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'Today Is the Best Tax Day of Your Life',
					"post_content"	=>	'SATURDAY morning was come, and all the summer world was bright and fresh, and brimming with life. There was a song in every heart; and if the heart was young the music issued at the lips. There was cheer in every face and a spring in every step. The locust-trees were in bloom and the fragrance of the blossoms filled the air. Cardiff Hill, beyond the village and above it, was green with vegetation and it lay just far enough away to seem a Delectable Land, dreamy, reposeful, and inviting.

Tom appeared on the sidewalk with a bucket of whitewash and a long-handled brush. He surveyed the fence, and all gladness left him and a deep melancholy settled down upon his spirit. Thirty yards of board fence nine feet high. Life to him seemed hollow, and existence but a burden. Sighing, he dipped his brush and passed it along the topmost plank; repeated the operation; did it again; compared the insignificant whitewashed streak with the far-reaching continent of unwhitewashed fence, and sat down on a tree-box discouraged. Jim came skipping out at the gate with a tin pail, and singing Buffalo Gals. Bringing water from the town pump had always been hateful work in Tom eyes, before, but now it did not strike him so. He remembered that there was company at the pump. White, mulatto, and negro boys and girls were always there waiting their turns, resting, trading playthings, quarrelling, fighting, skylarking.',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Blog'),
					"post_tags"		=>	array('Business')
					);
////post end///
////post start 8 ///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/img8.jpg";
$image_array[] = "dummy/img9.jpg";
$image_array[] = "dummy/img10.jpg";
$image_array[] = "dummy/img11.jpg";
$image_array[] = "dummy/img12.jpg";
$image_array[] = "dummy/img1.jpg";
$image_array[] = "dummy/img2.jpg";
$post_meta = array(
				   "video"	=> '',
					"tl_dummy_content"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'The Job Hunt',
					"post_content"	=>	' The raft drew beyond the middle of the river; the boys pointed her head right, and then lay on their oars.

	<blockquote> The river was not high, so there was not more than a two or three mile current. Hardly a word was
said during the next three-quarters of an hour. Now the raft was passing before the distant town. Two or three glimmering lights showed where it lay, peacefully sleeping, beyond the vague vast sweep of star-gemmed water, unconscious of the tremendous event that was happening. </blockquote>
	<ul>
     <li>The Black Avenger stood still with folded arms, "looking his last" upon </li>
    <li>the scene of his former joys and his later sufferings, and wishing</li>
     <li>"she" could see him now, abroad on the wild sea, facing peril and death with dauntless heart, going to his doom with a grim smile on his lips. It was but a small strain on his imagination to remove Jackson Island</li>
     <li>beyond eyeshot of the village, and so he "looked his last" with a</li>
     <li> broken and satisfied heart. The other pirates were looking their last </li>
     <li> too; and they all looked so long that they came near letting the</li>
	 </ul>

current drift them out of the range of the island. But they discovered the danger in time, and made shift to avert it. About two oclock in the morning the raft grounded on the bar two hundred yards above the head of the island, and they waded back and forth until they had landed their freight.

Part of the little raft belongings consisted of an old sail, and this they spread over a nook in the bushes for a tent to shelter their provisions; but they themselves would sleep in the open air in good weather, as became outlaws.

<ol>
   <li> They built a fire against the side of a great log twenty or thirty</li>
   <li> steps within the sombre depths of the forest, and then cooked some</li>
   <li> bacon in the frying-pan for supper, and used up half of the corn "pone"</li>
   <li>  stock they had brought. It seemed glorious sport to be feasting in that</li>
   <li> wild, free way in the virgin forest of an unexplored and uninhabited</li>
   <li> island, far from the haunts of men, and they said they never would</li>
   <li> return to civilization. The climbing fire lit up their faces and threw</li>
   <li> its ruddy glare upon the pillared tree-trunks of their forest temple,</li>
   <li> and upon the varnished foliage and festooning vines.</li>
 </ol>

When the last crisp slice of bacon was gone, and the last allowance of corn pone devoured, the boys stretched themselves out on the grass, filled with contentment. They could have found a cooler place, but they would not deny themselves such a romantic feature as the roasting camp-fire.',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Blog'),
					"post_tags"		=>	array('Science')
					);
////post end///
////post start 9 ///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/img9.jpg";
$image_array[] = "dummy/img10.jpg";
$image_array[] = "dummy/img11.jpg";
$image_array[] = "dummy/img12.jpg";
$image_array[] = "dummy/img1.jpg";
$image_array[] = "dummy/img2.jpg";
$image_array[] = "dummy/img3.jpg";
$post_meta = array(
				   "video"	=> '',
					"tl_dummy_content"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'The Shape of Things to Come',
					"post_content"	=>	'Presently she stepped into the kitchen, and Sid, happy in his immunity, reached for the sugar-bowl–a sort of glorying over Tom which
was wellnigh unbearable. But Sid fingers slipped and the bowl dropped and broke. Tom was in ecstasies. In such ecstasies that he even controlled his tongue and was silent. He said to himself that he would not speak a word, even when his aunt came in, but would sit perfectly
still till she asked who did the mischief; and then he would tell, and there would be nothing so good in the world as to see that pet model "catch it." He was so brimful of exultation that he could hardly hold himself when the old lady came back and stood above the wreck discharging lightnings of wrath from over her spectacles. He said to himself, "Now it coming!" And the next instant he was sprawling on the floor! The potent palm was uplifted to strike again when Tom cried out',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Blog'),
					"post_tags"		=>	array('Health')
					);
////post end///
////post start 10 ///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/img10.jpg";
$image_array[] = "dummy/img11.jpg";
$image_array[] = "dummy/img12.jpg";
$image_array[] = "dummy/img1.jpg";
$image_array[] = "dummy/img2.jpg";
$image_array[] = "dummy/img3.jpg";
$image_array[] = "dummy/img4.jpg";
$post_meta = array(
				   "video"	=> '',
					"tl_dummy_content"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'The Comeback Country',
					"post_content"	=>	'
					The river was not high, so there was not more than a two or three mile current. Hardly a word was
said during the next three-quarters of an hour. Now the raft was passing before the distant town. Two or three glimmering lights showed where it lay, peacefully sleeping, beyond the vague vast sweep of star-gemmed water, unconscious of the tremendous event that was happening. 

					<blockquote> The river was not high, so there was not more than a two or three mile current. Hardly a word was
said during the next three-quarters of an hour. Now the raft was passing before the distant town. Two or three glimmering lights showed where it lay, peacefully sleeping, beyond the vague vast sweep of star-gemmed water, unconscious of the tremendous event that was happening. </blockquote>
	<ul>
     <li>The Black Avenger stood still with folded arms, "looking his last" upon </li>
    <li>the scene of his former joys and his later sufferings, and wishing</li>
     <li>"she" could see him now, abroad on the wild sea, facing peril and death with dauntless heart, going to his doom with a grim smile on his lips. It was but a small strain on his imagination to remove Jackson Island</li>
     <li>beyond eyeshot of the village, and so he "looked his last" with a</li>
     <li> broken and satisfied heart. The other pirates were looking their last </li>
     <li> too; and they all looked so long that they came near letting the</li>
	 </ul>

current drift them out of the range of the island. But they discovered the danger in time, and made shift to avert it. About two oclock in the morning the raft grounded on the bar two hundred yards above the head of the island, and they waded back and forth until they had landed their freight.
',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Blog'),
					"post_tags"		=>	array('Tag 2')
					);
////post end///
$wp_upload_dir = wp_upload_dir();
$basedir = $wp_upload_dir['basedir'];
$baseurl = $wp_upload_dir['baseurl'];
$folderpath = $basedir."/dummy/";

full_copy( TEMPLATEPATH."/images/dummy/", $folderpath );
function full_copy( $source, $target ) 
{
	$imagepatharr = explode('/',str_replace(TEMPLATEPATH,'',$target));
	for($i=0;$i<count($imagepatharr);$i++)
	{
	  if($imagepatharr[$i])
	  {
		  $year_path = ABSPATH.$imagepatharr[$i]."/";
		  if (!file_exists($year_path) && strstr($year_path,"wp-content")){
			 @mkdir($year_path, 0777);
		  }     
		}
	}
	if ( is_dir( $source ) ) {
		@mkdir( $target );
		$d = dir( $source );
		while ( FALSE !== ( $entry = $d->read() ) ) {
			if ( $entry == '.' || $entry == '..' ) {
				continue;
			}
			$Entry = $source . '/' . $entry; 
			if ( is_dir( $Entry ) ) {
				full_copy( $Entry, $target . '/' . $entry );
				continue;
			}
			copy( $Entry, $target . '/' . $entry );
		}
	
		$d->close();
	}else {
		copy( $source, $target );
	}
}
insert_posts($post_info);
function insert_posts($post_info)
{
	global $wpdb,$current_user;
	for($i=0;$i<count($post_info);$i++)
	{
		$post_title = $post_info[$i]['post_title'];
		$post_count = $wpdb->get_var("SELECT count(ID) FROM $wpdb->posts where post_title like \"$post_title\" and post_type='post' and post_status in ('publish','draft')");
		if(!$post_count)
		{
			$post_info_arr = array();
			$catids_arr = array();
			$my_post = array();
			$post_info_arr = $post_info[$i];
			if($post_info_arr['post_category'])
			{
				for($c=0;$c<count($post_info_arr['post_category']);$c++)
				{
					$catids_arr[] = get_cat_ID($post_info_arr['post_category'][$c]);
				}
			}else
			{
				$catids_arr[] = 1;
			}
			$my_post['post_title'] = $post_info_arr['post_title'];
			$my_post['post_content'] = $post_info_arr['post_content'];
			if($post_info_arr['post_author'])
			{
				$my_post['post_author'] = $post_info_arr['post_author'];
			}else
			{
				$my_post['post_author'] = 1;
			}
			$my_post['post_status'] = 'publish';
			$my_post['post_category'] = $catids_arr;
			$my_post['tags_input'] = $post_info_arr['post_tags'];
			$last_postid = wp_insert_post( $my_post );
			$post_meta = $post_info_arr['post_meta'];
			if($post_meta)
			{
				foreach($post_meta as $mkey=>$mval)
				{
					update_post_meta($last_postid, $mkey, $mval);
				}
			}
			
			$post_image = $post_info_arr['post_image'];
			if($post_image)
			{
				for($m=0;$m<count($post_image);$m++)
				{
					$menu_order = $m+1;
					$image_name_arr = explode('/',$post_image[$m]);
					$img_name = $image_name_arr[count($image_name_arr)-1];
					$img_name_arr = explode('.',$img_name);
					$post_img = array();
					$post_img['post_title'] = $img_name_arr[0];
					$post_img['post_status'] = 'attachment';
					$post_img['post_parent'] = $last_postid;
					$post_img['post_type'] = 'attachment';
					$post_img['post_mime_type'] = 'image/jpeg';
					$post_img['menu_order'] = $menu_order;
					$last_postimage_id = wp_insert_post( $post_img );
					update_post_meta($last_postimage_id, '_wp_attached_file', $post_image[$m]);					
					$post_attach_arr = array(
										"width"	=>	580,
										"height" =>	480,
										"hwstring_small"=> "height='150' width='150'",
										"file"	=> $post_image[$m],
										//"sizes"=> $sizes_info_array,
										);
					//wp_update_attachment_metadata( $last_postimage_id, $post_attach_arr );
					$file = get_attached_file( $last_postimage_id );
					wp_update_attachment_metadata( $last_postimage_id, wp_generate_attachment_metadata( $last_postimage_id, $file ) );
				}
			}
		}
	}
}
//====================================================================================//



//**********************************************************************************************************************************************
////=====================================CUSTOM POST TYPE DATA START=======================================================================================////
//**********************************************************************************************************************************************

$category_array = array('Sports','Living','Entertainment','Health','Music','Local','Others');
insert_taxonomy_category($category_array);
function insert_taxonomy_category($category_array)
{
	for($i=0;$i<count($category_array);$i++)
	{
		$parent_catid = 0;
		if(is_array($category_array[$i]))
		{
			$cat_name_arr = $category_array[$i];
			for($j=0;$j<count($cat_name_arr);$j++)
			{
				$catname = $cat_name_arr[$j];
				$last_catid = wp_insert_term( $catname, 'videoscategory', $args = array('parent'=>$parent_catid) );
				if($j==0)
				{
					$parent_catid = $last_catid;
				}
			}
			
		}else
		{
			$catname = $category_array[$i];
			wp_insert_term( $catname, 'videoscategory', $args = array('parent'=>$parent_catid) );
		}
	}
}

$post_info = array();
////post start 1 ///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/img8.jpg";
$post_meta = array(
				   "video"	=> '<object width="480" height="385"><param name="movie" value="http://www.youtube.com/v/R1U6ZQ_KaHs?fs=1&amp;hl=en_GB"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/R1U6ZQ_KaHs?fs=1&amp;hl=en_GB" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="480" height="385" wmode="transparent"></embed></object>',
				   "time"	=> '2:56',
				   "twitter"	=> 'http://twitter.com/templatic',
				   "facebook"	=> 'http://facebook.com/templatic',
					"tl_dummy_content"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'Nutrition and Your Mental Health ',
					"post_content"	=>	'Nutrition and Your Mental Health

What does nutrition have to do with mental health? You might be surprised to find out the truth behind what happens when a person has a nutritional deficiency.

Nutritional deficiencies can cause all sorts of psychiatric symptoms including apathy, low energy, irritability, insomnia, low energy, agitation, fatigue, concentration problems, aches and pains, weight changes, including weight loss or weight gain. Sound a lot like the symptoms of depression? The truth is the average American diet of fast food is low in vital nutrition that you need for your body to function correctly.

This is to say that all depression is caused by bad nutrition but it certainly a contributing factor in many cases and poor nutrition will always make depression worse. Antidepressant drugs also do not correct nutritional problems. So if your depressed because of nutritional problems an antidepressant will only partially cover up the problem and you body still wo not function correctly.',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Health'),
					"post_tags"		=>	array('Tips')
					);
////post end/// 
////post start 2 ///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/img2.jpg";
$post_meta = array(
				   "video"	=> '<object width="640" height="385"><param name="movie" value="http://www.youtube.com/v/hVjWuHpfTy0?fs=1&amp;hl=en_GB"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/hVjWuHpfTy0?fs=1&amp;hl=en_GB" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="640" height="385" wmode="transparent"></embed></object>',
				     "time"	=> '5:07',
				   "twitter"	=> 'http://twitter.com/templatic',
				   "facebook"	=> 'http://facebook.com/templatic',
					"tl_dummy_content"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'Health And Beauty Tips',
					"post_content"	=>	'This video, I tell personal beauty tips about how to keep skin looking nice and about Teeth fillers...
I mention the benefits to Clinique facial foundation sun lotion
The modern Girls Guide To Life.- Jane bucking ham',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Health','Living'),
					"post_tags"		=>	array('beauty')
					);
////post end/// 
////post start 3 ///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/img3.jpg";
$post_meta = array(
				   "video"	=> '<object width="480" height="385"><param name="movie" value="http://www.youtube.com/v/HuRnJQeVa08?fs=1&amp;hl=en_GB"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/HuRnJQeVa08?fs=1&amp;hl=en_GB" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="480" height="385" wmode="transparent"></embed></object>',
				     "time"	=> '9:10',
				   "twitter"	=> 'http://twitter.com/templatic',
				   "facebook"	=> 'http://facebook.com/templatic',
					"tl_dummy_content"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'Super Food & Health Food, Sprouts, Nutrition by Natalie ',
					"post_content"	=>	'Super Food & Health Food, Sprouts, Nutrition by Natalie
					In this video Natalie talks you around the world to learn about some of the most nutrition foods that exist. Some of these were actually discovered in region where the inhabitants have extended life spans dues to these foods in their diet.

This video includes low calorie all natural foods that can be used instead of sugar.

The foods gone over in this video include Quinoa, Goji Berries, Acai Berries, Wheat Grass, Spirulina, Hemp Protein, Agave Nectar and Stevia.

Any of these foods can be purchased at a local health food store. 
					',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Health'),
					"post_tags"		=>	array('Tags')
					);
////post end/// 
////post start 4 ///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/img4.jpg";
$post_meta = array(
				   "video"	=> '<object width="480" height="385"><param name="movie" value="http://www.youtube.com/v/4shudantHtA?fs=1&amp;hl=en_GB"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/4shudantHtA?fs=1&amp;hl=en_GB" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="480" height="385" wmode="transparent"></embed></object>',
				     "time"	=> '10:40',
				   "twitter"	=> 'http://twitter.com/templatic',
				   "facebook"	=> 'http://facebook.com/templatic',
					"tl_dummy_content"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'Top 10 Best Foods - Nutrition by Natalie ',
					"post_content"	=>	'Top Ten Best Foods

Natalie counts down the top 10 best foods you could eat.

In a fast food nation, eating healthy food becomes difficult to do. Yet a poor diet contributes to low energy, obesity, stress, health problems and high medical bills.

If you eat better, you will feel better and this video discusses some of the foods you should avoid. 
					',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Health'),
					"post_tags"		=>	array('Tags')
					);
////post end/// 
////post start 5///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/img5.jpg";
$post_meta = array(
				   "video"	=> '<object width="640" height="385"><param name="movie" value="http://www.youtube.com/v/cN4juwmANPs?fs=1&amp;hl=en_GB"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/cN4juwmANPs?fs=1&amp;hl=en_GB" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="640" height="385" wmode="transparent"></embed></object>',
				     "time"	=> '1:41',
				   "twitter"	=> 'http://twitter.com/templatic',
				   "facebook"	=> 'http://facebook.com/templatic',
					"tl_dummy_content"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'Change Your Cardio Routine To Lose Weight',
					"post_content"	=>	'Jillian Michaels Yoga Meltdown combines hard-core yoga power moves and poses to get real results quickly. "Yoga Meltdown" DVD features two complete 30-minute workouts both including appropriate warm up and cool down sessions. The two phases include quickly flowing yoga sequences for warm up progressing to twisting and balancing routines for an even greater burn.',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Health','Living'),
					"post_tags"		=>	array('Sample Tag')
					);
////post end/// 
////post start 6///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/img6.jpg";
$post_meta = array(
				   "video"	=> '<object width="640" height="385"><param name="movie" value="http://www.youtube.com/v/qo2hF5S0a8o?fs=1&amp;hl=en_GB"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/qo2hF5S0a8o?fs=1&amp;hl=en_GB" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="640" height="385" wmode="transparent"></embed></object>',
				     "time"	=> '3:42',
				   "twitter"	=> 'http://twitter.com/templatic',
				   "facebook"	=> 'http://facebook.com/templatic',
					"tl_dummy_content"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'Hot 40 Min. Workout - Part 2',
					"post_content"	=>	'This is part 1 of a new 40 minute home workout series. I have stopped going to the gym now completely. First of all it’s expensive, and secondly it eats up a lot of time. It’s not just the time in the gym – it’s getting there and back and the time in the change room etc. I’m also just completely bored with the gym. I don’t feel inspied there at all right now. The good news is that you don’t have to go to the gym to get a really good workout.',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Health'),
					"post_tags"		=>	array('Tag 2')
					);
////post end/// 
////post start 7///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/img7.jpg";
$post_meta = array(
				   "video"	=> '<object width="480" height="385"><param name="movie" value="http://www.youtube.com/v/C9fo3vyf2Rw?fs=1&amp;hl=en_GB"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/C9fo3vyf2Rw?fs=1&amp;hl=en_GB" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="480" height="385" wmode="transparent"></embed></object>',
				     "time"	=> '8:22',
				   "twitter"	=> 'http://twitter.com/templatic',
				   "facebook"	=> 'http://facebook.com/templatic',
					"tl_dummy_content"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'Heathy Eating, The Secret to - Advanced Health Institute ',
					"post_content"	=>	'
Healthy Eating, The Secret to - Advanced Health Institute. What to eat. Best foods to eat. About whole foods. Good nutrition is a secret to life and wellness. Tips for healthy eating.

Radhia is a Certified Clinical Nutritionist, C.C.N. She is also a Certified BioNutritional Analyst. She has a Ph.D. in pastoral counseling and a M.Ed. in nutrition. She is a professional member of the International and American Association of Clinical Nutritionists, (I.A.A.C.N), and the American Naturopathic Medical Association (A.N.M.A.).',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Health'),
					"post_tags"		=>	array('Tag1')
					);
////post end/// 
////post start 8///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/img8.jpg";
$post_meta = array(
				   "video"	=> '<object width="480" height="385"><param name="movie" value="http://www.youtube.com/v/6g6eKaxPU2A?fs=1&amp;hl=en_GB"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/6g6eKaxPU2A?fs=1&amp;hl=en_GB" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="480" height="385" wmode="transparent"></embed></object>',
				     "time"	=> '1:02',
				   "twitter"	=> 'http://twitter.com/templatic',
				   "facebook"	=> 'http://facebook.com/templatic',
					"tl_dummy_content"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	' Health Tips - Benefits of Water ',
					"post_content"	=>	'We have all heard that we should be drinking at least eight glasses of water a day. I always knew I should and did my best to remember, but never realized how important it was until I started doing some research for a weight loss video.

Water actually helps you lose weight, develop muscle tone and keep your skin clear. It’s cheap and with a splash of lemon juice or frozen berries you can add some flavour to your beverage. It is really a refreshing choice for a hot summer’s day.',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Health','Others'),
					"post_tags"		=>	array('Tag1')
					);
////post end///
////post start 9///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/img9.jpg";
$post_meta = array(
				   "video"	=> '<iframe src="http://player.vimeo.com/video/1454267" width="400" height="225" frameborder="0"></iframe>',
				     "time"	=> '1:02',
				   "twitter"	=> 'http://twitter.com/templatic',
				   "facebook"	=> 'http://facebook.com/templatic',
					"tl_dummy_content"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'New Millennium health workout',
					"post_content"	=>	'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero.',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Health','Others'),
					"post_tags"		=>	array('Tag1')
					);
////post end///
////post start 10///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/img10.jpg";
$post_meta = array(
				   "video"	=> '<iframe src="http://player.vimeo.com/video/3858676" width="400" height="220" frameborder="0"></iframe>',
				     "time"	=> '1:58',
				   "twitter"	=> 'http://twitter.com/templatic',
				   "facebook"	=> 'http://facebook.com/templatic',
					"tl_dummy_content"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'Health Station',
					"post_content"	=>	'Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero.',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Health'),
					"post_tags"		=>	array('Tag1')
					);
////post end///
////post start 11///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/img11.jpg";
$post_meta = array(
				   "video"	=> '<iframe src="http://player.vimeo.com/video/12831571" width="400" height="225" frameborder="0"></iframe>',
				     "time"	=> '1:58',
				   "twitter"	=> 'http://twitter.com/templatic',
				   "facebook"	=> 'http://facebook.com/templatic',
					"tl_dummy_content"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'Envision Health',
					"post_content"	=>	'We produced this long form video for Envision Health based in La Jolla CA. We interviewed Kulreet Chaudhary, MD and Architect Robert Nobel about Green Health and Green Buildings. 
					Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero.',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Health','Others'),
					"post_tags"		=>	array('Tag1')
					);
////post end///
////post start 12///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/img10.jpg";
$post_meta = array(
				   "video"	=> '<iframe src="http://player.vimeo.com/video/5400862" width="400" height="220" frameborder="0"></iframe>',
				     "time"	=> '1:58',
				   "twitter"	=> 'http://twitter.com/templatic',
				   "facebook"	=> 'http://facebook.com/templatic',
					"tl_dummy_content"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'Expedition Health',
					"post_content"	=>	'Spot produced by Impossible for the Denver Museum of Nature & Science, promoting their flagship exhibit, Expedition Health. I acted as EP and an art director.
					Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero.',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Health','Living'),
					"post_tags"		=>	array('Tag1')
					);
////post end///
////////////////--------------------------/////////
////post start 1///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/en1.jpg";
$post_meta = array(
				   "video"	=> '<object width="480" height="385"><param name="movie" value="http://www.youtube.com/v/N06aA_vjZPA?fs=1&amp;hl=en_GB"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/N06aA_vjZPA?fs=1&amp;hl=en_GB" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="480" height="385" wmode="transparent"></embed></object>',
				     "time"	=> '3:56',
				   "twitter"	=> 'http://twitter.com/templatic',
				   "facebook"	=> 'http://facebook.com/templatic',
					"tl_dummy_content"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'Piano music composition - The unfinished story ',
					"post_content"	=>	'A new original piano music composition by Isisip released in March 2008. The title of it is "The unfinished story". Just like the music on the album "My music collection", a lot of thoughts were put into it. This time another story is told by the piano.

Two versions are presented in this video, the piano only version was played a little slower, the two different versions have different feelings.',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Music','Others'),
					"post_tags"		=>	array('Tag1')
					);
////post end///
////post start 2///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/en2.jpg";
$post_meta = array(
				   "video"	=> '<object width="480" height="385"><param name="movie" value="http://www.youtube.com/v/g9gXsOByCaE?fs=1&amp;hl=en_GB"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/g9gXsOByCaE?fs=1&amp;hl=en_GB" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="480" height="385" wmode="transparent"></embed></object>',
				     "time"	=> '4:13',
				   "twitter"	=> 'http://twitter.com/templatic',
				   "facebook"	=> 'http://facebook.com/templatic',
					"tl_dummy_content"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'Twilight Piano Music ',
					"post_content"	=>	'Justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero.',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Music','Others'),
					"post_tags"		=>	array('Tag1')
					);
////post end///
////post start 2///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/en3.jpg";
$post_meta = array(
				   "video"	=> '<object width="480" height="385"><param name="movie" value="http://www.youtube.com/v/g9gXsOByCaE?fs=1&amp;hl=en_GB"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/g9gXsOByCaE?fs=1&amp;hl=en_GB" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="480" height="385" wmode="transparent"></embed></object>',
				     "time"	=> '3:25',
				   "twitter"	=> 'http://twitter.com/templatic',
				   "facebook"	=> 'http://facebook.com/templatic',
					"tl_dummy_content"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'Very Sad Piano Music',
					"post_content"	=>	'Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero.',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Music','Others'),
					"post_tags"		=>	array('Tag1')
					);
////post end///
////post start 3///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/en3.jpg";
$post_meta = array(
				   "video"	=> '<object width="480" height="385"><param name="movie" value="http://www.youtube.com/v/zkbdnehABEs?fs=1&amp;hl=en_GB"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/zkbdnehABEs?fs=1&amp;hl=en_GB" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="480" height="385" wmode="transparent"></embed></object>',
				     "time"	=> '2:07',
				   "twitter"	=> 'http://twitter.com/templatic',
				   "facebook"	=> 'http://facebook.com/templatic',
					"tl_dummy_content"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'Nice piano music with romantic pictures ',
					"post_content"	=>	'Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero.',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Music'),
					"post_tags"		=>	array('Tag1')
					);
////post end///
////post start 4///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/en4.jpg";
$post_meta = array(
				   "video"	=> '<object width="480" height="385"><param name="movie" value="http://www.youtube.com/v/9XjlP0znDB0?fs=1&amp;hl=en_GB"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/9XjlP0znDB0?fs=1&amp;hl=en_GB" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="480" height="385" wmode="transparent"></embed></object>',
				     "time"	=> '4:59',
				   "twitter"	=> 'http://twitter.com/templatic',
				   "facebook"	=> 'http://facebook.com/templatic',
					"tl_dummy_content"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'Beautiful Piano Music ',
					"post_content"	=>	'Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero.',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Music','Living'),
					"post_tags"		=>	array('Tag1')
					);
////post end///
////post start 5///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/en5.jpg";
$post_meta = array(
				   "video"	=> '<<object width="480" height="385"><param name="movie" value="http://www.youtube.com/v/g01mOcO_Dw4?fs=1&amp;hl=en_GB"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/g01mOcO_Dw4?fs=1&amp;hl=en_GB" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="480" height="385" wmode="transparent"></embed></object>',
				     "time"	=> '1:08',
				   "twitter"	=> 'http://twitter.com/templatic',
				   "facebook"	=> 'http://facebook.com/templatic',
					"tl_dummy_content"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'Crying in the Rain',
					"post_content"	=>	'Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero.',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Music'),
					"post_tags"		=>	array('Tag1')
					);
////post end///
////post start 6///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/en6.jpg";
$post_meta = array(
				   "video"	=> '<object width="640" height="385"><param name="movie" value="http://www.youtube.com/v/EVBsypHzF3U?fs=1&amp;hl=en_GB"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/EVBsypHzF3U?fs=1&amp;hl=en_GB" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="640" height="385" wmode="transparent"></embed></object>',
				     "time"	=> '9:31',
				   "twitter"	=> 'http://twitter.com/templatic',
				   "facebook"	=> 'http://facebook.com/templatic',
					"tl_dummy_content"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'Lady Gaga - Telephone ft. Beyoncé ',
					"post_content"	=>	'Music video by Lady Gaga performing Telephone (Clean Version). (C) 2010 Interscope Records 
					Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero.',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Music'),
					"post_tags"		=>	array('Tag1')
					);
////post end///
////post start 7///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/en7.jpg";
$post_meta = array(
				   "video"	=> '<object width="480" height="385"><param name="movie" value="http://www.youtube.com/v/Hr0Wv5DJhuk?fs=1&amp;hl=en_GB"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/Hr0Wv5DJhuk?fs=1&amp;hl=en_GB" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="480" height="385" wmode="transparent"></embed></object>',
				     "time"	=> '9:31',
				   "twitter"	=> 'http://twitter.com/templatic',
				   "facebook"	=> 'http://facebook.com/templatic',
					"tl_dummy_content"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'Miley Cyrus - 7 Things',
					"post_content"	=>	'7 Things featured on her brand new album Breakout available in stores and on iTunes July 
					Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero.',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Music'),
					"post_tags"		=>	array('Tag1')
					);
////post end///
////post start 8///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/en8.jpg";
$post_meta = array(
				   "video"	=> '<object width="480" height="385"><param name="movie" value="http://www.youtube.com/v/F5VvvVxuKko?fs=1&amp;hl=en_GB"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/F5VvvVxuKko?fs=1&amp;hl=en_GB" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="480" height="385" wmode="transparent"></embed></object>',
				     "time"	=> '3:40',
				   "twitter"	=> 'http://twitter.com/templatic',
				   "facebook"	=> 'http://facebook.com/templatic',
					"tl_dummy_content"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'Vanessa Hudgens Say Ok',
					"post_content"	=>	'Say Ok is the second single from High School Musical own Vanessa Hudgens. Her debut album V is in stores now and features the hit single "Come Back To Me".
					Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero.',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Music'),
					"post_tags"		=>	array('Tag1')
					);
////post end///
////post start 9///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/en9.jpg";
$post_meta = array(
				   "video"	=> '<object width="480" height="385"><param name="movie" value="http://www.youtube.com/v/F5VvvVxuKko?fs=1&amp;hl=en_GB"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/F5VvvVxuKko?fs=1&amp;hl=en_GB" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="480" height="385" wmode="transparent"></embed></object>',
				     "time"	=> '3:43',
				   "twitter"	=> 'http://twitter.com/templatic',
				   "facebook"	=> 'http://facebook.com/templatic',
					"tl_dummy_content"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'Demi Lovato - La La Land',
					"post_content"	=>	'Official music video for Demi Lovato "La La Land" off of her album Do not Forget. In stores now!
					
					Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero.',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Music'),
					"post_tags"		=>	array('Tag1')
					);
////post end///
////post start 10///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/en10.jpg";
$post_meta = array(
				   "video"	=> '<object width="480" height="385"><param name="movie" value="http://www.youtube.com/v/TDRT-bYRvMI?fs=1&amp;hl=en_GB"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/TDRT-bYRvMI?fs=1&amp;hl=en_GB" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="480" height="385" wmode="transparent"></embed></object>',
				     "time"	=> '3:53',
				   "twitter"	=> 'http://twitter.com/templatic',
				   "facebook"	=> 'http://facebook.com/templatic',
					"tl_dummy_content"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'Avril Lavigne - Innocence Music Video ',
					"post_content"	=>	'Made by myself, a music video with images from others Avril Vids - mostly when you are gonne and happy ending.. Did the best I could and think Turned pretty cool..
Well watch it and enjoy',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Music'),
					"post_tags"		=>	array('Tag1')
					);
////post end///
////post start 11///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/en11.jpg";
$post_meta = array(
				   "video"	=> '<object width="640" height="385"><param name="movie" value="http://www.youtube.com/v/_NLrk8RKWrY?fs=1&amp;hl=en_GB"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/_NLrk8RKWrY?fs=1&amp;hl=en_GB" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="640" height="385" wmode="transparent"></embed></object>',
				     "time"	=> '3:53',
				   "twitter"	=> 'http://twitter.com/templatic',
				   "facebook"	=> 'http://facebook.com/templatic',
					"tl_dummy_content"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'Avril Lavigne - Girlfriend',
					"post_content"	=>	'justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero.',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Music'),
					"post_tags"		=>	array('Tag4')
					);
////post end///
////-----------////
////post start 1///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/img1.jpg";
$post_meta = array(
				   "video"	=> '<object width="640" height="385"><param name="movie" value="http://www.youtube.com/v/TcefXUe2q8g?fs=1&amp;hl=en_GB"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/TcefXUe2q8g?fs=1&amp;hl=en_GB" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="640" height="385" wmode="transparent"></embed></object>',
				     "time"	=> '2:53',
				   "twitter"	=> 'http://twitter.com/templatic',
				   "facebook"	=> 'http://facebook.com/templatic',
					"tl_dummy_content"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'Five News | Naked Charity Calendar ',
					"post_content"	=>	' Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero.',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Local','Living'),
					"post_tags"		=>	array('Tag4')
					);
////post end///
////post start 1///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/img2.jpg";
$post_meta = array(
				   "video"	=> '<object width="480" height="385"><param name="movie" value="http://www.youtube.com/v/D-4jU2wlRkQ?fs=1&amp;hl=en_GB"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/D-4jU2wlRkQ?fs=1&amp;hl=en_GB" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="480" height="385" wmode="transparent"></embed></object>',
				     "time"	=> '3:20',
				   "twitter"	=> 'http://twitter.com/templatic',
				   "facebook"	=> 'http://facebook.com/templatic',
					"tl_dummy_content"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'Race Debate! Auto-Tune the News',
					"post_content"	=>	' Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero.',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Local','Others'),
					"post_tags"		=>	array('Sample Tag')
					);
////post end///
////post start 2///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/img3.jpg";
$post_meta = array(
				   "video"	=> '<object width="480" height="385"><param name="movie" value="http://www.youtube.com/v/2C28AsmJQZg?fs=1&amp;hl=en_GB"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/2C28AsmJQZg?fs=1&amp;hl=en_GB" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="480" height="385" wmode="transparent"></embed></object>',
				     "time"	=> '22.22',
				   "twitter"	=> 'http://twitter.com/templatic',
				   "facebook"	=> 'http://facebook.com/templatic',
					"tl_dummy_content"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'My TV News Makeup Routine',
					"post_content"	=>	'Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero.',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Local'),
					"post_tags"		=>	array('Auto')
					);
////post end///
////post start 3///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/img3.jpg";
$post_meta = array(
				   "video"	=> '<object width="640" height="385"><param name="movie" value="http://www.youtube.com/v/8x-5wI_64x0?fs=1&amp;hl=en_GB"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/8x-5wI_64x0?fs=1&amp;hl=en_GB" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="640" height="385" wmode="transparent"></embed></object>',
				     "time"	=> '07.21',
				   "twitter"	=> 'http://twitter.com/templatic',
				   "facebook"	=> 'http://facebook.com/templatic',
					"tl_dummy_content"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'Fox News Misrepresents Treason? ',
					"post_content"	=>	'Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero.',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Local'),
					"post_tags"		=>	array('Tag')
					);
////post end///
////post start 4///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/img4.jpg";
$post_meta = array(
				   "video"	=> '<object width="640" height="385"><param name="movie" value="http://www.youtube.com/v/8x-5wI_64x0?fs=1&amp;hl=en_GB"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/8x-5wI_64x0?fs=1&amp;hl=en_GB" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="640" height="385" wmode="transparent"></embed></object>',
				     "time"	=> '7:21',
				   "twitter"	=> 'http://twitter.com/templatic',
				   "facebook"	=> 'http://facebook.com/templatic',
					"tl_dummy_content"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'Fox News Misrepresents Treason? ',
					"post_content"	=>	'Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero.',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Local'),
					"post_tags"		=>	array('Treason')
					);
////post end///
////post start 5///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/img5.jpg";
$post_meta = array(
				   "video"	=> '<object width="480" height="385"><param name="movie" value="http://www.youtube.com/v/Q1PVrVJQoU8?fs=1&amp;hl=en_GB"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/Q1PVrVJQoU8?fs=1&amp;hl=en_GB" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="480" height="385" wmode="transparent"></embed></object>',
				     "time"	=> '8:31',
				   "twitter"	=> 'http://twitter.com/templatic',
				   "facebook"	=> 'http://facebook.com/templatic',
					"tl_dummy_content"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'Huey Lewis & the News',
					"post_content"	=>	'
					Huey Lewis & The News came to Germany for a gig at the E-Werk in Cologne in 1991. The blooded musicians from San Francisco did a terrific show playing the highlights of their albums "Picture This", "Sports" "Fore!" and "Hard at Play".

With a mixture of rock  frontman Hugh Anthony Cregg III and his five band members gave an authentic music presentation to the audience.

This is a great version of their song "I want a new drug" which is introduced by a long guitar solo from Chris Hayes.
					Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero.',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Local','Living'),
					"post_tags"		=>	array('Lewis')
					);
////post end///
////post start 6///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/img6.jpg";
$post_meta = array(
				   "video"	=> '<object width="480" height="385"><param name="movie" value="http://www.youtube.com/v/yQbb1f0rWxY?fs=1&amp;hl=en_GB"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/yQbb1f0rWxY?fs=1&amp;hl=en_GB" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="480" height="385" wmode="transparent"></embed></object>',
				     "time"	=> '8:31',
				   "twitter"	=> 'http://twitter.com/templatic',
				   "facebook"	=> 'http://facebook.com/templatic',
					"tl_dummy_content"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'ABC news now Iron Maiden',
					"post_content"	=>	'Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero.',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Local'),
					"post_tags"		=>	array('Sample Tag')
					);
////post end///
////post start 7///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/img7.jpg";
$post_meta = array(
				   "video"	=> '<object width="640" height="385"><param name="movie" value="http://www.youtube.com/v/ovyiQOaXOJk?fs=1&amp;hl=en_GB"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/ovyiQOaXOJk?fs=1&amp;hl=en_GB" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="640" height="385" wmode="transparent"></embed></object>',
				     "time"	=> '2:42',
				   "twitter"	=> 'http://twitter.com/templatic',
				   "facebook"	=> 'http://facebook.com/templatic',
					"tl_dummy_content"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'News Bulletin',
					"post_content"	=>	'Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero.',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Local'),
					"post_tags"		=>	array('Sample')
					);
////post end///
////post start 8///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/img8.jpg";
$post_meta = array(
				   "video"	=> '<object width="640" height="385"><param name="movie" value="http://www.youtube.com/v/DUh3FzWLr7k?fs=1&amp;hl=en_GB"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/DUh3FzWLr7k?fs=1&amp;hl=en_GB" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="640" height="385" wmode="transparent"></embed></object>',
				     "time"	=> '2:28',
				   "twitter"	=> 'http://twitter.com/templatic',
				   "facebook"	=> 'http://facebook.com/templatic',
					"tl_dummy_content"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'Pakistani army aids flood victims ',
					"post_content"	=>	'Many Pakistani flood victims remain angry at the lack of help they have received from the government.
The army, however, has been praised for its relief and rescue efforts, though it has been overwhelmed by the sheer scale of the disaster.
Jonah Hull travelled with the military in flood-ravaged Central Punjab and reports now on the huge task ahead.',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Local','Others'),
					"post_tags"		=>	array('Funny')
					);
////post end///
////post start 9///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/img9.jpg";
$post_meta = array(
				   "video"	=> '<object width="480" height="385"><param name="movie" value="http://www.youtube.com/v/i_f3SkxTWxc?fs=1&amp;hl=en_GB"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/i_f3SkxTWxc?fs=1&amp;hl=en_GB" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="480" height="385" wmode="transparent"></embed></object>',
				     "time"	=> '3:22',
				   "twitter"	=> 'http://twitter.com/templatic',
				   "facebook"	=> 'http://facebook.com/templatic',
					"tl_dummy_content"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'Top 10 quirky science tricks for parties ',
					"post_content"	=>	'Justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero.',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Local'),
					"post_tags"		=>	array('Science')
					);
////post end///
////post start 10///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/img10.jpg";
$post_meta = array(
				   "video"	=> '<object width="640" height="385"><param name="movie" value="http://www.youtube.com/v/jxbIJH4fTYo?fs=1&amp;hl=en_GB"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/jxbIJH4fTYo?fs=1&amp;hl=en_GB" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="640" height="385" wmode="transparent"></embed></object>',
				     "time"	=> '6:38',
				   "twitter"	=> 'http://twitter.com/templatic',
				   "facebook"	=> 'http://facebook.com/templatic',
					"tl_dummy_content"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'Why Earth Science ',
					"post_content"	=>	'The earth sciences are central to all aspects of life - get a quick glimpse in this 6 min video.
					
					Justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero.',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Local'),
					"post_tags"		=>	array('Science')
					);
////post end///
////post start 1 ///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/sport1.jpg";
$post_meta = array(
				   "video"	=> '<object width="480" height="270"><param name="movie" value="http://www.dailymotion.com/swf/video/xdo4tc_limpopo_shortfilms?additionalInfos=0"></param><param name="allowFullScreen" value="true"></param><param name="allowScriptAccess" value="always"></param><embed type="application/x-shockwave-flash" src="http://www.dailymotion.com/swf/video/xdo4tc_limpopo_shortfilms?additionalInfos=0" width="480" height="270" allowfullscreen="true" allowscriptaccess="always" wmode="transparent"></embed></object>',
				   "time"	=> '1:30',
				   "twitter"	=> 'http://twitter.com/templatic',
				   "facebook"	=> 'http://facebook.com/templatic',
					"tl_dummy_content"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'FOOTBALL MADE IN AFRICA',
					"post_content"	=>	'South Africa Coach Carlos Alberto Parreira stood outside the auditorium at Soccer City Stadium on Thursday being interviewed by a television crew when word came that Mexico&acute;s coach, Javier Aguirre, was arriving for his session.',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Sports'),
					"post_tags"		=>	array('africa')
					);
////post end///
////post start 2 ///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/sport2.jpg";
$post_meta = array(
				   "video"	=> '<object width="480" height="270"><param name="movie" value="http://www.dailymotion.com/swf/video/xf3agh_the-future-for-paramotors_sport?additionalInfos=0"></param><param name="allowFullScreen" value="true"></param><param name="allowScriptAccess" value="always"></param><embed type="application/x-shockwave-flash" src="http://www.dailymotion.com/swf/video/xf3agh_the-future-for-paramotors_sport?additionalInfos=0" width="480" height="270" allowfullscreen="true" allowscriptaccess="always" wmode="transparent"></embed></object><br />',
				   "time"	=> '3:31',
				   "twitter"	=> 'http://twitter.com/templatic',
				   "facebook"	=> 'http://facebook.com/templatic',
					"tl_dummy_content"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'The future for Paramotors',
					"post_content"	=>	'Watch more Paramotor videos including the World Championship. Keep on watching. Enjoy. ',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Sports'),
					"post_tags"		=>	array('Paramotors')
					);
////post end///
////post start 3 ///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/sport3.jpg";
$post_meta = array(
				   "video"	=> '<object width="640" height="385"><param name="movie" value="http://www.youtube.com/v/75Q2QT_fxcc?fs=1&amp;hl=en_US"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/75Q2QT_fxcc?fs=1&amp;hl=en_US" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="640" height="385" wmode="transparent"></embed></object>',
				   "time"	=> '4:06',
				   "twitter"	=> 'http://twitter.com/templatic',
				   "facebook"	=> 'http://facebook.com/templatic',
					"tl_dummy_content"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'Best Goals and Tricks Compilation Online ft. Fernando Torres (FIFA 11) Sports ',
					"post_content"	=>	'Best Goals & Tricks Compilation Online ft. Fernando Torres (FIFA 11) Sports

This is my second video on the Machinima network. This video contains all the best goals and tricks that I along with a friend have completed online. Please leave feedback on what you think of the video, theres still room for improvement.',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Sports','Others'),
					"post_tags"		=>	array('goals')
					);
////post end///
////post start 4 ///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/sport4.jpg";
$post_meta = array(
				   "video"	=> '<object width="480" height="385"><param name="movie" value="http://www.youtube.com/v/vt4X7zFfv4k?fs=1&amp;hl=en_US"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/vt4X7zFfv4k?fs=1&amp;hl=en_US" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="480" height="385" wmode="transparent"></embed></object>',
				   "time"	=> '3:38',
				   "twitter"	=> 'http://twitter.com/templatic',
				   "facebook"	=> 'http://facebook.com/templatic',
					"tl_dummy_content"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'Comedy Football',
					"post_content"	=>	'Music: River Kwai march. Best Comedy Scenes. Must watch. ',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Sports'),
					"post_tags"		=>	array('comedy')
					);
////post end///
////post start 5 ///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/sport5.jpg";
$post_meta = array(
				   "video"	=> '<object width="480" height="385"><param name="movie" value="http://www.youtube.com/v/5yzqbqg5gL0?fs=1&amp;hl=en_US"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/5yzqbqg5gL0?fs=1&amp;hl=en_US" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="480" height="385" wmode="transparent"></embed></object>',
				   "time"	=> '3:39',
				   "twitter"	=> 'http://twitter.com/templatic',
				   "facebook"	=> 'http://facebook.com/templatic',
					"tl_dummy_content"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'Best Football Players ',
					"post_content"	=>	'Great Compilation Of The Best Football Players Today ',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Sports','Others'),
					"post_tags"		=>	array('best football')
					);
////post end///
////post start 6 ///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/sport6.jpg";
$post_meta = array(
				   "video"	=> '<object width="480" height="385"><param name="movie" value="http://www.youtube.com/v/H8v-qZFVYnc?fs=1&amp;hl=en_US"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/H8v-qZFVYnc?fs=1&amp;hl=en_US" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="480" height="385" wmode="transparent"></embed></object>',
				   "time"	=> '3:19',
				   "twitter"	=> 'http://twitter.com/templatic',
				   "facebook"	=> 'http://facebook.com/templatic',
					"tl_dummy_content"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'Huge Rugby Hits!',
					"post_content"	=>	'The biggest rugby hits ever ',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Sports'),
					"post_tags"		=>	array('huge rugby')
					);
////post end///
////post start 7 ///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/sport7.jpg";
$post_meta = array(
				   "video"	=> '<object width="480" height="385"><param name="movie" value="http://www.youtube.com/v/EEAbgQBXC50?fs=1&amp;hl=en_US"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/EEAbgQBXC50?fs=1&amp;hl=en_US" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="480" height="385" wmode="transparent"></embed></object>',
				   "time"	=> '1:13',
				   "twitter"	=> 'http://twitter.com/templatic',
				   "facebook"	=> 'http://facebook.com/templatic',
					"tl_dummy_content"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'How to Play Rugby: Advanced : How To Tackle in a Rugby Game ',
					"post_content"	=>	'Learn how to perform a rugby tackle with advanced tips and techniques in this free online sports video.',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Sports'),
					"post_tags"		=>	array('rugby')
					);
////post end///
////post start 8 ///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/sport8.jpg";
$post_meta = array(
				   "video"	=> '<iframe src="http://player.vimeo.com/video/15622360?title=0&amp;byline=0&amp;portrait=0" width="400" height="225" frameborder="0"></iframe>',
				   "time"	=> '0:30',
				   "twitter"	=> 'http://twitter.com/templatic',
				   "facebook"	=> 'http://facebook.com/templatic',
					"tl_dummy_content"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'Shane Warne Commercial',
					"post_content"	=>	'Shane Warne Commercial Advertisement. Watch It !! ',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Sports'),
					"post_tags"		=>	array('shane warne')
					);
////post end///
////post start 9 ///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/sport9.jpg";
$post_meta = array(
				   "video"	=> '<iframe src="http://player.vimeo.com/video/1625029" width="400" height="267" frameborder="0"></iframe>',
				   "time"	=> '41:33',
				   "twitter"	=> 'http://twitter.com/templatic',
				   "facebook"	=> 'http://facebook.com/templatic',
					"tl_dummy_content"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'Singapore National Day Cricket Match ',
					"post_content"	=>	'Singapore National Day Cricket Match - KBR Cricket',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Sports'),
					"post_tags"		=>	array('singapore')
					);
////post end///
////post start 10 ///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/sport10.jpg";
$post_meta = array(
				   "video"	=> '<object width="480" height="385"><param name="movie" value="http://www.youtube.com/v/cTUAax9wuhY?fs=1&amp;hl=en_US"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/cTUAax9wuhY?fs=1&amp;hl=en_US" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="480" height="385" wmode="transparent"></embed></object>',
				   "time"	=> '5:53',
				   "twitter"	=> 'http://twitter.com/templatic',
				   "facebook"	=> 'http://facebook.com/templatic',
					"tl_dummy_content"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'Comedy Football [top goals]  ',
					"post_content"	=>	'comedy goals in football. Some of them are really hillarious.',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Sports','Others'),
					"post_tags"		=>	array('comedy')
					);
////post end///
////post start 11 ///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/sport11.jpg";
$post_meta = array(
				   "video"	=> '<object width="480" height="385"><param name="movie" value="http://www.youtube.com/v/ggDB9xwcgzc?fs=1&amp;hl=en_US"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/ggDB9xwcgzc?fs=1&amp;hl=en_US" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="480" height="385" wmode="transparent"></embed></object>',
				   "time"	=> '2:56',
				   "twitter"	=> 'http://twitter.com/templatic',
				   "facebook"	=> 'http://facebook.com/templatic',
					"tl_dummy_content"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'4th Goal Comedy Brisbane Roar v Perth Glory ',
					"post_content"	=>	'4th Goal Comedy Brisbane Roar v Perth Glory. Take a look at this one.',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Sports'),
					"post_tags"		=>	array('goal')
					);
////post end///
////post start 12 ///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/sport12.jpg";
$post_meta = array(
				   "video"	=> '<object width="480" height="385"><param name="movie" value="http://www.youtube.com/v/fc1JcYQvrZo?fs=1&amp;hl=en_US"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/fc1JcYQvrZo?fs=1&amp;hl=en_US" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="480" height="385" wmode="transparent"></embed></object>',
				   "time"	=> '5:22',
				   "twitter"	=> 'http://twitter.com/templatic',
				   "facebook"	=> 'http://facebook.com/templatic',
					"tl_dummy_content"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'The Best Goal Celebrations Ever (New) ',
					"post_content"	=>	'This video is new and so am i hope all of you enjoy it by the way there is like 2 to 3 minutes of black screen sorry about that',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Sports','Others'),
					"post_tags"		=>	array('goal')
					);
////post end///

////post start 1 ///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/img1.jpg";
$post_meta = array(
				   "video"	=> '<object width="480" height="360"><param name="movie" value="http://www.dailymotion.com/swf/video/xfh0cj_ash-makes-fun-of-akshay-s-wig_shortfilms?additionalInfos=0"></param><param name="allowFullScreen" value="true"></param><param name="allowScriptAccess" value="always"></param><embed type="application/x-shockwave-flash" src="http://www.dailymotion.com/swf/video/xfh0cj_ash-makes-fun-of-akshay-s-wig_shortfilms?additionalInfos=0" width="480" height="360" allowfullscreen="true" allowscriptaccess="always" wmode="transparent"></embed></object><br />',
				   "time"	=> '3:45',
				   "twitter"	=> 'http://twitter.com/templatic',
				   "facebook"	=> 'http://facebook.com/templatic',
					"tl_dummy_content"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'Ash Makes Fun Of Akshays Wig',
					"post_content"	=>	'Akshay Kumar faced lot of problems during the shooting of Vipul Shahs Action Replayy because of his wig and Aishwarya Rai Bachchan made fun of him',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Funny'),
					"post_tags"		=>	array('Aishwarya')
					);
////post end///
////post start 2 ///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/img2.jpg";
$post_meta = array(
				   "video"	=> '<object width="480" height="360"><param name="movie" value="http://www.dailymotion.com/swf/video/xfeema_fun-and-frolic-on-the-sets-of-golmaal-3_news?additionalInfos=0"></param><param name="allowFullScreen" value="true"></param><param name="allowScriptAccess" value="always"></param><embed type="application/x-shockwave-flash" src="http://www.dailymotion.com/swf/video/xfeema_fun-and-frolic-on-the-sets-of-golmaal-3_news?additionalInfos=0" width="480" height="360" allowfullscreen="true" allowscriptaccess="always" wmode="transparent"></embed></object><br />',
				   "time"	=> '3:45',
				   "twitter"	=> 'http://twitter.com/templatic',
				   "facebook"	=> 'http://facebook.com/templatic',
					"tl_dummy_content"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'Fun and frolic on the sets of Golmaal-3',
					"post_content"	=>	'Arshad Warsi talks about celebrating his birthday in two different cities on the sets of Golmaal 3. ',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Funny','Others'),
					"post_tags"		=>	array('golmaal3')
					);
////post end///
////post start 3 ///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/img3.jpg";
$post_meta = array(
				   "video"	=> '<object width="480" height="384"><param name="movie" value="http://www.dailymotion.com/swf/video/xfez3i_mr-bean-teddy-reads-a-book_fun?additionalInfos=0"></param><param name="allowFullScreen" value="true"></param><param name="allowScriptAccess" value="always"></param><embed type="application/x-shockwave-flash" src="http://www.dailymotion.com/swf/video/xfez3i_mr-bean-teddy-reads-a-book_fun?additionalInfos=0" width="480" height="384" allowfullscreen="true" allowscriptaccess="always" wmode="transparent"></embed></object><br />',
				   "time"	=> '0:36',
				   "twitter"	=> 'http://twitter.com/templatic',
				   "facebook"	=> 'http://facebook.com/templatic',
					"tl_dummy_content"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'Mr Bean - Teddy reads a book',
					"post_content"	=>	'Mr Bean reads a book with Teddy in the garden. From animated series The Mole.',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Funny','Others'),
					"post_tags"		=>	array('mrbean')
					);
////post end///
////post start 4 ///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/img4.jpg";
$post_meta = array(
				   "video"	=> '<iframe src="http://player.vimeo.com/video/2809991" width="400" height="225" frameborder="0"></iframe>',
				   "time"	=> '3:43',
				   "twitter"	=> 'http://twitter.com/templatic',
				   "facebook"	=> 'http://facebook.com/templatic',
					"tl_dummy_content"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'Star Wars: Retold (by someone who hasnt seen it)',
					"post_content"	=>	'My friend Amanda had never seen a whole Star Wars film. When I asked her if she wanted to watch the original trilogy she said that she would, but that she already knew what happens. So I took out my voice recorder and asked her to start from the top.',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Funny'),
					"post_tags"		=>	array('star wars')
					);
////post end///
////post start 5 ///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/img5.jpg";
$post_meta = array(
				   "video"	=> '<object width="480" height="385"><param name="movie" value="http://www.youtube.com/v/aemXgP-2xyg?fs=1&amp;hl=en_US"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/aemXgP-2xyg?fs=1&amp;hl=en_US" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="480" height="385" wmode="transparent"></embed></object>',
				   "time"	=> '2:53',
				   "twitter"	=> 'http://twitter.com/templatic',
				   "facebook"	=> 'http://facebook.com/templatic',
					"tl_dummy_content"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'Funny Video ',
					"post_content"	=>	'Music: Carl Douglas - Kung Fu Fighting. Must watch.',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Funny','Others'),
					"post_tags"		=>	array('funny video')
					);
////post end///
////post start 6 ///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/img6.jpg";
$post_meta = array(
				   "video"	=> '<object width="480" height="385"><param name="movie" value="http://www.youtube.com/v/2G9fkvBzzQE?fs=1&amp;hl=en_US"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/2G9fkvBzzQE?fs=1&amp;hl=en_US" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="480" height="385" wmode="transparent"></embed></object>',
				   "time"	=> '3:35',
				   "twitter"	=> 'http://twitter.com/templatic',
				   "facebook"	=> 'http://facebook.com/templatic',
					"tl_dummy_content"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'Funny Bird',
					"post_content"	=>	'',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Funny'),
					"post_tags"		=>	array('bird')
					);
////post end///
////post start 7 ///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/img7.jpg";
$post_meta = array(
				   "video"	=> '<object width="480" height="385"><param name="movie" value="http://www.youtube.com/v/0_fPV13lKm4?fs=1&amp;hl=en_US"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/0_fPV13lKm4?fs=1&amp;hl=en_US" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="480" height="385" wmode="transparent"></embed></object>',
				   "time"	=> '3:27',
				   "twitter"	=> 'http://twitter.com/templatic',
				   "facebook"	=> 'http://facebook.com/templatic',
					"tl_dummy_content"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'Funny Animation ',
					"post_content"	=>	'Really funny animation, take a look at it.',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Funny','Others'),
					"post_tags"		=>	array('animation')
					);
////post end///
////post start 8///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/img8.jpg";
$post_meta = array(
				   "video"	=> '<object width="480" height="385"><param name="movie" value="http://www.youtube.com/v/hNoS2BU6bbQ?fs=1&amp;hl=en_US"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/hNoS2BU6bbQ?fs=1&amp;hl=en_US" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="480" height="385" wmode="transparent"></embed></object>',
				   "time"	=> '3:02',
				   "twitter"	=> 'http://twitter.com/templatic',
				   "facebook"	=> 'http://facebook.com/templatic',
					"tl_dummy_content"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'Funny Hugh Laurie & Stephen Fry comedy sketch! Your name, sir? - BBC comedy',
					"post_content"	=>	'Stephen Fry and Hugh Laurie perform a hilarious short comedy sketch in a police station. A man making a statement has a surname that is pretty hard to pronounce! Watch this classic moment from the ground-breaking comedy sketch show A Bit of Fry and Laurie for free with BBC Worldwide.',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Funny'),
					"post_tags"		=>	array('bbc')
					);
////post end///
////post start 9 ///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/img9.jpg";
$post_meta = array(
				   "video"	=> '<object width="640" height="385"><param name="movie" value="http://www.youtube.com/v/ZGwYrZLvvJU?fs=1&amp;hl=en_US"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/ZGwYrZLvvJU?fs=1&amp;hl=en_US" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="640" height="385" wmode="transparent"></embed></object>',
				   "time"	=> '2:04',
				   "twitter"	=> 'http://twitter.com/templatic',
				   "facebook"	=> 'http://facebook.com/templatic',
					"tl_dummy_content"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'Google Threatens To Kill Users -Comedy',
					"post_content"	=>	'Comedy recently asked Google if they would like to address the public backlash over Google Buzz. They responded with this.',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Funny','Others'),
					"post_tags"		=>	array('Google')
					);
////post end///
////post start 10 ///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/img10.jpg";
$post_meta = array(
				   "video"	=> '<object width="480" height="385"><param name="movie" value="http://www.youtube.com/v/YMfVtfqvP34?fs=1&amp;hl=en_US"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/YMfVtfqvP34?fs=1&amp;hl=en_US" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="480" height="385" wmode="transparent"></embed></object>',
				   "time"	=> '3:45',
				   "twitter"	=> 'http://twitter.com/templatic',
				   "facebook"	=> 'http://facebook.com/templatic',
					"tl_dummy_content"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'COMEDY: Achmed The Dead Terrorist (ventriloquist)',
					"post_content"	=>	'COMEDY: Achkmeth The Dead Terrorist (ventriloquist)',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Funny'),
					"post_tags"		=>	array('comedy')
					);
////post end///
////post start 11 ///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/img11.jpg";
$post_meta = array(
				   "video"	=> '<object width="480" height="385"><param name="movie" value="http://www.youtube.com/v/Z4Y4keqTV6w?fs=1&amp;hl=en_US"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/Z4Y4keqTV6w?fs=1&amp;hl=en_US" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="480" height="385" wmode="transparent"></embed></object>',
				   "time"	=> '9:02',
				   "twitter"	=> 'http://twitter.com/templatic',
				   "facebook"	=> 'http://facebook.com/templatic',
					"tl_dummy_content"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'Dad at Comedy Barn ',
					"post_content"	=>	'This is my father. Yes, that is his real laugh. Enjoy ',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Funny'),
					"post_tags"		=>	array('comedy')
					);
////post end///
////post start 12 ///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/img12.jpg";
$post_meta = array(
				   "video"	=> '<object width="480" height="385"><param name="movie" value="http://www.youtube.com/v/F9bV_v9b8go?fs=1&amp;hl=en_US"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/F9bV_v9b8go?fs=1&amp;hl=en_US" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="480" height="385" wmode="transparent"></embed></object>',
				   "time"	=> '3:15',
				   "twitter"	=> 'http://twitter.com/templatic',
				   "facebook"	=> 'http://facebook.com/templatic',
					"tl_dummy_content"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'Kicked In The Nuts World Record Holder ',
					"post_content"	=>	'WTF TV hits the streets to set a world record for how many times one guy can get women on the street to kick him in the nuts. So painful, so funny.',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Funny'),
					"post_tags"		=>	array('world record')
					);
////post end///
////post start 1 ///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/mu1.jpg";
$post_meta = array(
				   "video"	=> '<object width="640" height="385"><param name="movie" value="http://www.youtube.com/v/NG2zyeVRcbs?fs=1&amp;hl=en_US"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/NG2zyeVRcbs?fs=1&amp;hl=en_US" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="640" height="385" wmode="transparent"></embed></object>',
				   "time"	=> '3:49',
				   "twitter"	=> 'http://twitter.com/templatic',
				   "facebook"	=> 'http://facebook.com/templatic',
					"tl_dummy_content"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'Miley Cyrus - The Climb ',
					"post_content"	=>	'The Climb is the brand new hit single from Miley Cyrus available on Hannah Montana: The Movie Soundtrack in stores March 24! Hannah Montana: The Movie only in Theaters April 10.',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Entertainment'),
					"post_tags"		=>	array('miley cyrus')
					);
////post end///
////post start 2 ///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/mu2.jpg";
$post_meta = array(
				   "video"	=> '<object width="640" height="385"><param name="movie" value="http://www.youtube.com/v/sjSG6z_13-Q?fs=1&amp;hl=en_US"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/sjSG6z_13-Q?fs=1&amp;hl=en_US" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="640" height="385" wmode="transparent"></embed></object>',
				   "time"	=> '3:50',
				   "twitter"	=> 'http://twitter.com/templatic',
				   "facebook"	=> 'http://facebook.com/templatic',
					"tl_dummy_content"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'Miley Cyrus - Cant Be Tamed ',
					"post_content"	=>	'The official music video from Miley Cyrus performing Cant be tamed.',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Entertainment'),
					"post_tags"		=>	array('miley cyrus')
					);
////post end///
////post start 3 ///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/mu3.jpg";
$post_meta = array(
				   "video"	=> '<object width="640" height="385"><param name="movie" value="http://www.youtube.com/v/8wxOVn99FTE?fs=1&amp;hl=en_US"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/8wxOVn99FTE?fs=1&amp;hl=en_US" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="640" height="385" wmode="transparent"></embed></object>',
				   "time"	=> '4:11',
				   "twitter"	=> 'http://twitter.com/templatic',
				   "facebook"	=> 'http://facebook.com/templatic',
					"tl_dummy_content"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'When I Look At You ',
					"post_content"	=>	'Music video by Miley Cyrus performing When I Look At You',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Entertainment'),
					"post_tags"		=>	array('miley')
					);
////post end///
////post start 4 ///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/mu4.jpg";
$post_meta = array(
				   "video"	=> '<object width="640" height="385"><param name="movie" value="http://www.youtube.com/v/UfcvO2t8Ntg?fs=1&amp;hl=en_US"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/UfcvO2t8Ntg?fs=1&amp;hl=en_US" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="640" height="385" wmode="transparent"></embed></object>',
				   "time"	=> '3:15',
				   "twitter"	=> 'http://twitter.com/templatic',
				   "facebook"	=> 'http://facebook.com/templatic',
					"tl_dummy_content"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'Selena Gomez & The Scene - Round & Round  ',
					"post_content"	=>	'Selena Gomezs brand new album A Year Without Rain is available now',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Entertainment'),
					"post_tags"		=>	array('Selena Gomez')
					);
////post end///
////post start 5 ///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/mu5.jpg";
$post_meta = array(
				   "video"	=> '<object width="640" height="385"><param name="movie" value="http://www.youtube.com/v/OhtGnCa8x2k?fs=1&amp;hl=en_US"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/OhtGnCa8x2k?fs=1&amp;hl=en_US" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="640" height="385" wmode="transparent"></embed></object>',
				   "time"	=> '3:04',
				   "twitter"	=> 'http://twitter.com/templatic',
				   "facebook"	=> 'http://facebook.com/templatic',
					"tl_dummy_content"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'Transformers 2 Revenge of the Fallen Official Movie Trailer  ',
					"post_content"	=>	'Transformers 2 Revenge of the Fallen Movie Trailer - Official. Give Michael Bay two hundred million dollars and what do you get? Transformers: Revenge of the Fallen.',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Entertainment'),
					"post_tags"		=>	array('transformers')
					);
////post end///
////post start 6 ///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/mu6.jpg";
$post_meta = array(
				   "video"	=> '<object width="640" height="385"><param name="movie" value="http://www.youtube.com/v/-xxLw7S6EaA?fs=1&amp;hl=en_US"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/-xxLw7S6EaA?fs=1&amp;hl=en_US" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="640" height="385" wmode="transparent"></embed></object>',
				   "time"	=> '2:21',
				   "twitter"	=> 'http://twitter.com/templatic',
				   "facebook"	=> 'http://facebook.com/templatic',
					"tl_dummy_content"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'TRON LEGACY - Trailer 2 - HQ - 1080p ',
					"post_content"	=>	'TRON LEGACY coming to theaters 2010 in Disney Digital 3D.',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Entertainment'),
					"post_tags"		=>	array('Tron Legacy')
					);
////post end///
////post start 7 ///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/mu7.jpg";
$post_meta = array(
				   "video"	=> '<object width="640" height="385"><param name="movie" value="http://www.youtube.com/v/FNQowwwwYa0?fs=1&amp;hl=en_US"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/FNQowwwwYa0?fs=1&amp;hl=en_US" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="640" height="385" wmode="transparent"></embed></object>',
				   "time"	=> '2:33',
				   "twitter"	=> 'http://twitter.com/templatic',
				   "facebook"	=> 'http://facebook.com/templatic',
					"tl_dummy_content"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'Iron Man 2 Trailer 2 (OFFICIAL)  ',
					"post_content"	=>	'You wanted more "Iron Man 2" You got it! Feast your eyes on the second official Iron Man 2 trailer! Watch it now!',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Entertainment'),
					"post_tags"		=>	array('iron man2')
					);
////post end///
////post start 8 ///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/mu8.jpg";
$post_meta = array(
				   "video"	=> '<object width="640" height="385"><param name="movie" value="http://www.youtube.com/v/-Jm-3UYxK4E?fs=1&amp;hl=en_US"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/-Jm-3UYxK4E?fs=1&amp;hl=en_US" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="640" height="385" wmode="transparent"></embed></object>',
				   "time"	=> '5:55',
				   "twitter"	=> 'http://twitter.com/templatic',
				   "facebook"	=> 'http://facebook.com/templatic',
					"tl_dummy_content"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'Star Wars: The Clone Wars ',
					"post_content"	=>	'From Darth Mauls brother to Asajj Ventress origins, we analyze the new revelations.',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Entertainment'),
					"post_tags"		=>	array('Star Wars')
					);
////post end///
////post start 9 ///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/mu9.jpg";
$post_meta = array(
				   "video"	=> '<object width="480" height="385"><param name="movie" value="http://www.youtube.com/v/F9bV_v9b8go?fs=1&amp;hl=en_US"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/F9bV_v9b8go?fs=1&amp;hl=en_US" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="480" height="385" wmode="transparent"></embed></object>',
				   "time"	=> '3:15',
				   "twitter"	=> 'http://twitter.com/templatic',
				   "facebook"	=> 'http://facebook.com/templatic',
					"tl_dummy_content"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'Vanessa Hudgens Say Ok Music Video (Official with Zac Efron)  ',
					"post_content"	=>	'Say Ok is the second single from High School Musicals own Vanessa Hudgens. Her debut album V is in stores now and features the hit single "Come Back To Me".',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Entertainment'),
					"post_tags"		=>	array('Vanessa Hudgens')
					);
////post end///
////post start 10 ///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/mu10.jpg";
$post_meta = array(
				   "video"	=> '<object width="640" height="385"><param name="movie" value="http://www.youtube.com/v/Q1D5goGz0SY?fs=1&amp;hl=en_US"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/Q1D5goGz0SY?fs=1&amp;hl=en_US" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="640" height="385" wmode="transparent"></embed></object>',
				   "time"	=> '1:33',
				   "twitter"	=> 'http://twitter.com/templatic',
				   "facebook"	=> 'http://facebook.com/templatic',
					"tl_dummy_content"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'The Twilight Saga Eclipse Official Full Trailer (HD)',
					"post_content"	=>	'The Twilight Saga: Eclipse Full Trailer is finally online! Check it out and make sure to Subscribe to our channel for all the latest Twilight News.',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Entertainment'),
					"post_tags"		=>	array('twilight')
					);
////post end///
////post start 11 ///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/mu11.jpg";
$post_meta = array(
				   "video"	=> '<object width="640" height="385"><param name="movie" value="http://www.youtube.com/v/2Y2BEhvS-ck?fs=1&amp;hl=en_US"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/2Y2BEhvS-ck?fs=1&amp;hl=en_US" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="640" height="385" wmode="transparent"></embed></object>',
				   "time"	=> '2:24',
				   "twitter"	=> 'http://twitter.com/templatic',
				   "facebook"	=> 'http://facebook.com/templatic',
					"tl_dummy_content"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'Inkheart Movie ',
					"post_content"	=>	'The first trailer of the film inkheart movie in italy.And liguria (Alassio, Iguelia, Balestrino). And Piedmont to Entracque (CN) ',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Entertainment'),
					"post_tags"		=>	array('inkheart')
					);
////post end///
////post start 12 ///
$image_array = array();
$post_meta = array();
$image_array[] = "dummy/mu12.jpg";
$post_meta = array(
				   "video"	=> '<object width="640" height="385"><param name="movie" value="http://www.youtube.com/v/Pki6jbSbXIY?fs=1&amp;hl=en_US"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/Pki6jbSbXIY?fs=1&amp;hl=en_US" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="640" height="385" wmode="transparent"></embed></object>',
				   "time"	=> '2:48',
				   "twitter"	=> 'http://twitter.com/templatic',
				   "facebook"	=> 'http://facebook.com/templatic',
					"tl_dummy_content"	=> '1',
				);
$post_info[] = array(
					"post_title"	=>	'Lord of the Rings: Fellowship of the ring trailer  ',
					"post_content"	=>	'Lord of the Rings: Fellowship of the ring (2001) offical theatrical trailer.',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Entertainment'),
					"post_tags"		=>	array('lord of the ring')
					);
////post end///
////post end///
insert_taxonomy_posts($post_info);
function insert_taxonomy_posts($post_info)
{
	global $wpdb,$current_user;
	for($i=0;$i<count($post_info);$i++)
	{
		$post_title = $post_info[$i]['post_title'];
		$post_count = $wpdb->get_var("SELECT count(ID) FROM $wpdb->posts where post_title like \"$post_title\" and post_type='videos' and post_status in ('publish','draft')");
		if(!$post_count)
		{
			$post_info_arr = array();
			$catids_arr = array();
			$my_post = array();
			$post_info_arr = $post_info[$i];
			$my_post['post_title'] = $post_info_arr['post_title'];
			$my_post['post_content'] = $post_info_arr['post_content'];
			$my_post['post_type'] = 'videos';
			if($post_info_arr['post_author'])
			{
				$my_post['post_author'] = $post_info_arr['post_author'];
			}else
			{
				$my_post['post_author'] = 1;
			}
			$my_post['post_status'] = 'publish';
			$my_post['post_category'] = $post_info_arr['post_category'];
			$my_post['tags_input'] = $post_info_arr['post_tags'];
			$last_postid = wp_insert_post( $my_post );
			wp_set_object_terms($last_postid,$post_info_arr['post_category'], $taxonomy='videoscategory');
			$post_meta = $post_info_arr['post_meta'];
			if($post_meta)
			{
				foreach($post_meta as $mkey=>$mval)
				{
					update_post_meta($last_postid, $mkey, $mval);
				}
			}
			
			$post_image = $post_info_arr['post_image'];
			if($post_image)
			{
				for($m=0;$m<count($post_image);$m++)
				{
					$menu_order = $m+1;
					$image_name_arr = explode('/',$post_image[$m]);
					$img_name = $image_name_arr[count($image_name_arr)-1];
					$img_name_arr = explode('.',$img_name);
					$post_img = array();
					$post_img['post_title'] = $img_name_arr[0];
					$post_img['post_status'] = 'attachment';
					$post_img['post_parent'] = $last_postid;
					$post_img['post_type'] = 'attachment';
					$post_img['post_mime_type'] = 'image/jpeg';
					$post_img['menu_order'] = $menu_order;
					$last_postimage_id = wp_insert_post( $post_img );
					update_post_meta($last_postimage_id, '_wp_attached_file', $post_image[$m]);					
					$post_attach_arr = array(
										"width"	=>	580,
										"height" =>	480,
										"hwstring_small"=> "height='150' width='150'",
										"file"	=> $post_image[$m],
										//"sizes"=> $sizes_info_array,
										);
					//wp_update_attachment_metadata( $last_postimage_id, $post_attach_arr );
					$file = get_attached_file( $last_postimage_id );
					wp_update_attachment_metadata( $last_postimage_id, wp_generate_attachment_metadata( $last_postimage_id, $file ) );

				}
			}
		}
	}
}
insert_posts($post_info);
//====================================================================================//
/////////////////////////////////////////////////

$pages_array = array(array('Wp Themes Club','Sub Page 1','Sub Page 2'),'FAQs','Terms',array('Archive Pages','Sub Page in 1','Sub Page in 2','Site Map'));
$page_info_arr = array();
$page_info_arr['Wp Themes Club'] = '
<p>The Templatic <a href="http://templatic.com/premium-themes-club/">Wordpress Themes Club</a> membership is ideal for any WordPress developer and freelancer that needs access to a wide variety of Wordpress themes. This themes collection saves you hundreds of dollars and also gives you the fantastic deal of allowing you to install any of our themes on unlimited domains.

You can see below just a few of our WordPress themes that are included in the club membership

&nbsp;
<strong>GeoPlaces</strong> - <a href="http://templatic.com/app-themes/geo-places-city-directory-wordpress-theme">Business Directory Theme</a>
The popular business directory theme that lets you have your very own local business listings directory or an international companies pages directory. This elegant and responsive design theme gives you powerful admin features to run a free or paid local business directory or both. GeoPlaces even has its own integrated events section so you not only get a business directory but an events directory too.


<strong>Automotive</strong> - <a href="http://templatic.com/cms-themes/automotive-responsive-vehicle-directory">Car Classifieds Theme</a>
A responsive auto classifieds theme that gives you the ability of allowing vehicles submission on free or paid listing packages which you decide on the price and duration. This sleek auto classifieds and car directory theme is also WooCommerce compatible so you can even use part of your site to run as a car spares online store. Details


<strong>Daily Deal</strong> - <a href="http://templatic.com/app-themes/daily-deal-premium-wordpress-app-theme">Deals Theme</a>
A powerful Deals theme for WordPress which lets your visitors buy or sell deals on your deals website. Daily Deal is by far the easiest and cheapest way to create a deals site where you can earn money by creating different deals submission price packages but you can also allow free deal submissions. Details


<strong>Events V2</strong> - <a href="http://templatic.com/app-themes/events">Events Directory Theme</a>
Launch a successful Events directory portal with this elegant responsive events theme. The theme has many powerful admin features including allowing event organizers to submit events on free or paid payment packages. This theme is simple to setup and you can get your events site up in no time.


<strong>NightLife</strong> - <a href="http://templatic.com/cms-themes/nightlife-events-directory-wordpress-theme">Events Directory Theme</a>
A beautifully designed events management theme which is responsive and allows you to run an events website. Allow event organizers free or paid event listing submissions and offer online event registrations. Nightlife is feature-packed with all the features you can expect from an events directory theme.


<strong>5 Star</strong> - <a href="http://templatic.com/app-themes/5-star-responsive-hotel-theme">Online Hotel Booking and Reservations Theme</a>
A well designed hotel booking theme which is ideal for showcasing and promoting a hotel online in style. This responsive design hotel reservation Wordpress theme will surely impress your guests and is also a theme that gives you a lot of powerful features including an advanced online booking system and a booking calendar.


<strong>Job Board</strong> - <a href="http://templatic.com/app-themes/job-board">Job Classifieds Theme</a>
Start your job classifieds or job board site with this responsive premium jobs board theme. Allow employers to submit job listings for free, paid or both and also allow job seekers to apply for jobs or submit their resumes. Packed with great features you would expect from a premium jobs board theme. Details


<strong>TechNews</strong> - <a href="http://templatic.com/magazine-themes/technews-advanced-blog-theme">Blogging and News Theme</a>
A news theme that is an ideal solution for your a news blog. An elegant theme which is ideal for news blogs, magazine or newspaper sites. This mobile friendly theme is both responsive and WooCommerce compatible. Impress your visitors with the stylish layout and available color schemes. Details


<strong>Real Estate V2</strong> - <a href="http://templatic.com/app-themes/real-estate-wordpress-theme-templatic">Property Classifieds Listings Theme</a>
This powerful IDX/MLS compatible real estate classifieds theme is both unique and powerful in the features it provides. With this real estate listings theme for WordPress, you can allow estate agencies and home sellers an opportunity to submit properties to your site. This real estate theme comes with many features including powerful search filter.


<strong>e-Commerece</strong> - <a href="http://templatic.com/ecommerce-themes/e-commerce">Online Store Theme</a>
A powerful and elegant WooCoomerce compatible e-commerce WordPress theme with many features advanced features. This online store theme offers various modes of product display such as a shopping Cart, digital Shop or catalog mode. This theme for e-commerce offers multiple payment gateways, coupon codes. Details



See the full collection of the <a href="http://templatic.com/premium-themes-club/">WordPress Themes Club Membership</a></p>
';
$page_info_arr['Sub Page 1'] = '
<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero.</p>
<p>Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero.</p>
<p>Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero.</p>
';
$page_info_arr['Sub Page 2'] = '
<pLorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero. </p>

<P>Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero. </p>

<p>Justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero.</p>

<p>Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero. </p>
';
$page_info_arr['Advertise'] = '
<pLorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero. </p>

<P>Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero. </p>

<p>Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero. </p>
';
$page_info_arr['FAQs'] = '
<pLorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero. </p>

<P>Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero. </p>

<p>Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Suspendisse potenti. Fusce  varius urna id quam. Sed neque mi, varius eget, tincidunt nec, suscipit id,  libero. In eget purus. Vestibulum ut nisl. Donec eu mi sed turpis feugiat  feugiat. Integer turpis arcu, pellentesque eget, cursus et, fermentum ut,  sapien. Fusce metus mi, eleifend sollicitudin, molestie id, varius et, nibh.  Donec nec libero. </p>
';
$page_info_arr['Terms'] = '
<blockquote>The raft drew beyond the middle of the river; the boys pointed her head right, and then lay on their oars.</blockquote>

The river was not high, so there was not more <a href="http://skeevisarts.com">than a two or three mile current</a>. Hardly a word was
said<strong> during the next three-quarters of</strong> an hour. Now the raft was passing before the distant town. Two or three glimmering lights showed where it lay, peacefully sleeping, beyond the <em>vague vast sweep</em> of star-gemmed water, unconscious of the <span style="text-decoration: underline;">tremendous</span> event that was happening.
<ul>
	<li>The <strong>Black Avenger</strong> stood still with folded arms, "looking his last" upon</li>
	<li>the scene of his former joys and his later sufferings, and wishing</li>
	<li>"she" <em>could see him now</em>, abroad on the wild sea, facing peril and death with dauntless heart, going to his doom with a grim smile on his lips. It was but a small strain on his imagination to remove Jacksons Island</li>
	<li>beyond eyeshot of the village, and so he "looked his last" with a</li>
	<li>broken and satisfied heart. <span style="text-decoration: underline;">The other pirates</span> were looking their last,</li>
	<li>too; and they all <a href="#">looked</a> so long that they came near letting the</li>
</ul> 

current drift them out of the range of the island. But they discovered the danger in time, and made shift to avert it. About two oclock in the morning the raft grounded on the bar two hundred yards above the head of the island, and they waded back and forth until they had landed their freight.
<p style="text-align: center;">Part of the little rafts belongings consisted of an old sail, and this they spread over a nook in the bushes for a tent to shelter their provisions; but they themselves would sleep in the open air in good weather, as became outlaws.
<ol>
	<li>They built a fire against the side of a great log twenty or thirty</li>
	<li>steps within the sombre depths of the forest, and then cooked some</li>
	<li>bacon in the frying-pan for supper, and used up half of the corn "pone"</li>
	<li>stock they had brought. It seemed glorious sport to be feasting in that</li>
	<li>wild, free way in the virgin forest of an unexplored and uninhabited</li>
	<li>island, far from the haunts of men, and they said they never would</li>
	<li>return to civilization. The climbing fire lit up their faces and threw</li>
	<li>its ruddy glare upon the pillared tree-trunks of their forest temple,</li>
	<li>and upon the varnished foliage and festooning vines.</li>
</ol>
When the last crisp slice of bacon was gone, and the last allowance of corn pone devoured, the boys stretched themselves out on the grass, filled with contentment. They could have found a cooler place, but they would not deny themselves such a romantic feature as the roasting camp-fire.
';
$page_info_arr['Archive Pages'] = '
<blockquote>The raft drew beyond the middle of the river; the boys pointed her head right, and then lay on their oars.</blockquote>

<ul>
	<li>The <strong>Black Avenger</strong> stood still with folded arms, "looking his last" upon</li>
	<li>the scene of his former joys and his later sufferings, and wishing</li>
	<li>"she" <em>could see him now</em>, abroad on the wild sea, facing peril and death with dauntless heart, going to his doom with a grim smile on his lips. It was but a small strain on his imagination to remove Jackson&acute;s Island</li>
	<li>beyond eyeshot of the village, and so he "looked his last" with a</li>
	<li>broken and satisfied heart. <span style="text-decoration: underline;">The other pirates</span> were looking their last,</li>
	<li>too; and they all <a href="#">looked</a> so long that they came near letting the</li>
</ul> 

<ol>
	<li>They built a fire against the side of a great log twenty or thirty</li>
	<li>steps within the sombre depths of the forest, and then cooked some</li>
	<li>bacon in the frying-pan for supper, and used up half of the corn "pone"</li>
	<li>stock they had brought. It seemed glorious sport to be feasting in that</li>
	<li>wild, free way in the virgin forest of an unexplored and uninhabited</li>
	<li>island, far from the haunts of men, and they said they never would</li>
	<li>return to civilization. The climbing fire lit up their faces and threw</li>
	<li>its ruddy glare upon the pillared tree-trunks of their forest temple,</li>
	<li>and upon the varnished foliage and festooning vines.</li>
</ol>
';
$page_info_arr['Sub Page in 1'] = '
<blockquote>The raft drew beyond the middle of the river; the boys pointed her head right, and then lay on their oars.</blockquote>

current drift them out of the range of the island. But they discovered the danger in time, and made shift to avert it. About two o&acute;clock in the morning the raft grounded on the bar two hundred yards above the head of the island, and they waded back and forth until they had landed their freight.
<p style="text-align: center;">Part of the little raft&acute;s belongings consisted of an old sail, and this they spread over a nook in the bushes for a tent to shelter their provisions; but they themselves would sleep in the open air in good weather, as became outlaws.
<ol>
	<li>They built a fire against the side of a great log twenty or thirty</li>
	<li>steps within the sombre depths of the forest, and then cooked some</li>
	<li>bacon in the frying-pan for supper, and used up half of the corn "pone"</li>
	<li>stock they had brought. It seemed glorious sport to be feasting in that</li>
	<li>wild, free way in the virgin forest of an unexplored and uninhabited</li>
	<li>island, far from the haunts of men, and they said they never would</li>
	<li>return to civilization. The climbing fire lit up their faces and threw</li>
	<li>its ruddy glare upon the pillared tree-trunks of their forest temple,</li>
	<li>and upon the varnished foliage and festooning vines.</li>
</ol>
When the last crisp slice of bacon was gone, and the last allowance of corn pone devoured, the boys stretched themselves out on the grass, filled with contentment. They could have found a cooler place, but they would not deny themselves such a romantic feature as the roasting camp-fire.
';
$page_info_arr['Sub Page in 2'] = '
<blockquote>The raft drew beyond the middle of the river; the boys pointed her head right, and then lay on their oars.</blockquote>

The river was not high, so there was not more <a href="http://skeevisarts.com">than a two or three mile current</a>. Hardly a word was
said<strong> during the next three-quarters of</strong> an hour. Now the raft was passing before the distant town. Two or three glimmering lights showed where it lay, peacefully sleeping, beyond the <em>vague vast sweep</em> of star-gemmed water, unconscious of the <span style="text-decoration: underline;">tremendous</span> event that was happening.
<ol>
	<li>They built a fire against the side of a great log twenty or thirty</li>
	<li>steps within the sombre depths of the forest, and then cooked some</li>
	<li>bacon in the frying-pan for supper, and used up half of the corn "pone"</li>
	<li>stock they had brought. It seemed glorious sport to be feasting in that</li>
	<li>wild, free way in the virgin forest of an unexplored and uninhabited</li>
	<li>island, far from the haunts of men, and they said they never would</li>
	<li>return to civilization. The climbing fire lit up their faces and threw</li>
	<li>its ruddy glare upon the pillared tree-trunks of their forest temple,</li>
	<li>and upon the varnished foliage and festooning vines.</li>
</ol>
When the last crisp slice of bacon was gone, and the last allowance of corn pone devoured, the boys stretched themselves out on the grass, filled with contentment. They could have found a cooler place, but they would not deny themselves such a romantic feature as the roasting camp-fire.
';
$page_info_arr['Press'] =  '
<blockquote>The raft drew beyond the middle of the river; the boys pointed her head right, and then lay on their oars.</blockquote>

The river was not high, so there was not more <a href="http://skeevisarts.com">than a two or three mile current</a>. Hardly a word was
said<strong> during the next three-quarters of</strong> an hour. Now the raft was passing before the distant town. Two or three glimmering lights showed where it lay, peacefully sleeping, beyond the <em>vague vast sweep</em> of star-gemmed water, unconscious of the <span style="text-decoration: underline;">tremendous</span> event that was happening.
<ul>
	<li>The <strong>Black Avenger</strong> stood still with folded arms, "looking his last" upon</li>
	<li>the scene of his former joys and his later sufferings, and wishing</li>
	<li>"she" <em>could see him now</em>, abroad on the wild sea, facing peril and death with dauntless heart, going to his doom with a grim smile on his lips. It was but a small strain on his imagination to remove Jackson&acute;s Island</li>
	<li>beyond eyeshot of the village, and so he "looked his last" with a</li>
	<li>broken and satisfied heart. <span style="text-decoration: underline;">The other pirates</span> were looking their last,</li>
	<li>too; and they all <a href="#">looked</a> so long that they came near letting the</li>
</ul> 
When the last crisp slice of bacon was gone, and the last allowance of corn pone devoured, the boys stretched themselves out on the grass, filled with contentment. They could have found a cooler place, but they would not deny themselves such a romantic feature as the roasting camp-fire.
';
$page_info_arr['Site Map'] =  '
<blockquote>The raft drew beyond the middle of the river; the boys pointed her head right, and then lay on their oars.</blockquote>

The river was not high, so there was not more <a href="http://skeevisarts.com">than a two or three mile current</a>. Hardly a word was
said<strong> during the next three-quarters of</strong> an hour. Now the raft was passing before the distant town. Two or three glimmering lights showed where it lay, peacefully sleeping, beyond the <em>vague vast sweep</em> of star-gemmed water, unconscious of the <span style="text-decoration: underline;">tremendous</span> event that was happening.
<ul>
	<li>The <strong>Black Avenger</strong> stood still with folded arms, "looking his last" upon</li>
	<li>the scene of his former joys and his later sufferings, and wishing</li>
	<li>"she" <em>could see him now</em>, abroad on the wild sea, facing peril and death with dauntless heart, going to his doom with a grim smile on his lips. It was but a small strain on his imagination to remove Jackson&acute;s Island</li>
	<li>beyond eyeshot of the village, and so he "looked his last" with a</li>
	<li>broken and satisfied heart. <span style="text-decoration: underline;">The other pirates</span> were looking their last,</li>
	<li>too; and they all <a href="#">looked</a> so long that they came near letting the</li>
</ul> 
When the last crisp slice of bacon was gone, and the last allowance of corn pone devoured, the boys stretched themselves out on the grass, filled with contentment. They could have found a cooler place, but they would not deny themselves such a romantic feature as the roasting camp-fire.
';
$page_info_arr['Privacy Policy'] =  '
<blockquote>The raft drew beyond the middle of the river; the boys pointed her head right, and then lay on their oars.</blockquote>

The river was not high, so there was not more <a href="http://skeevisarts.com">than a two or three mile current</a>. Hardly a word was
said<strong> during the next three-quarters of</strong> an hour. Now the raft was passing before the distant town. Two or three glimmering lights showed where it lay, peacefully sleeping, beyond the <em>vague vast sweep</em> of star-gemmed water, unconscious of the <span style="text-decoration: underline;">tremendous</span> event that was happening.
<ul>
	<li>The <strong>Black Avenger</strong> stood still with folded arms, "looking his last" upon</li>
	<li>the scene of his former joys and his later sufferings, and wishing</li>
	<li>"she" <em>could see him now</em>, abroad on the wild sea, facing peril and death with dauntless heart, going to his doom with a grim smile on his lips. It was but a small strain on his imagination to remove Jackson&acute;s Island</li>
	<li>beyond eyeshot of the village, and so he "looked his last" with a</li>
	<li>broken and satisfied heart. <span style="text-decoration: underline;">The other pirates</span> were looking their last,</li>
	<li>too; and they all <a href="#">looked</a> so long that they came near letting the</li>
</ul> 
When the last crisp slice of bacon was gone, and the last allowance of corn pone devoured, the boys stretched themselves out on the grass, filled with contentment. They could have found a cooler place, but they would not deny themselves such a romantic feature as the roasting camp-fire.
';


set_page_info_autorun($pages_array,$page_info_arr);
function set_page_info_autorun($pages_array,$page_info_arr_arg)
{
	global $post_author,$wpdb;
	$last_tt_id = 1;
	if(count($pages_array)>0)
	{
		$page_info_arr = array();
		for($p=0;$p<count($pages_array);$p++)
		{
			if(is_array($pages_array[$p]))
			{
				for($i=0;$i<count($pages_array[$p]);$i++)
				{
					$page_info_arr1 = array();
					$page_info_arr1['post_title'] = $pages_array[$p][$i];
					$page_info_arr1['post_content'] = $page_info_arr_arg[$pages_array[$p][$i]];
					$page_info_arr1['post_parent'] = $pages_array[$p][0];
					$page_info_arr[] = $page_info_arr1;
				}
			}
			else
			{
				$page_info_arr1 = array();
				$page_info_arr1['post_title'] = $pages_array[$p];
				$page_info_arr1['post_content'] = $page_info_arr_arg[$pages_array[$p]];
				$page_info_arr1['post_parent'] = '';
				$page_info_arr[] = $page_info_arr1;
			}
		}

		if($page_info_arr)
		{
			for($j=0;$j<count($page_info_arr);$j++)
			{
				$post_title = $page_info_arr[$j]['post_title'];
				$post_content = addslashes($page_info_arr[$j]['post_content']);
				$post_parent = $page_info_arr[$j]['post_parent'];
				if($post_parent!='')
				{
					$post_parent_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts where post_title like \"$post_parent\" and post_type='page'");
				}else
				{
					$post_parent_id = 0;
				}
				$post_date = date('Y-m-d H:s:i');
				$post_name = strtolower(str_replace(array("'",'"',"?",".","!","@","#","$","%","^","&","*","(",")","-","+","+"," "),array('-','-','-','-','-','-','-','-','-','-','-','-','-','-','-','-','-','-','-'),$post_title));
				$post_name_count = $wpdb->get_var("SELECT count(ID) FROM $wpdb->posts where post_title like \"$post_title\" and post_type='page'");
				if($post_name_count>0)
				{
					echo '';
				}else
				{
					$post_sql = "insert into $wpdb->posts (post_author,post_date,post_date_gmt,post_title,post_content,post_name,post_parent,post_type) values (\"$post_author\", \"$post_date\", \"$post_date\",  \"$post_title\", \"$post_content\", \"$post_name\",\"$post_parent_id\",'page')";
					$wpdb->query($post_sql);
					$last_post_id = $wpdb->get_var("SELECT max(ID) FROM $wpdb->posts");
					$guid = get_option('siteurl')."/?p=$last_post_id";
					$guid_sql = "update $wpdb->posts set guid=\"$guid\" where ID=\"$last_post_id\"";
					$wpdb->query($guid_sql);
					$ter_relation_sql = "insert into $wpdb->term_relationships (object_id,term_taxonomy_id) values (\"$last_post_id\",\"$last_tt_id\")";
					$wpdb->query($ter_relation_sql);
					update_post_meta( $last_post_id, 'pt_dummy_content', 1 );
				}
			}
		}
	}
}
//**********************************************************************************************************************************************
////=====================================CUSTOM POST TYPE DATA END=======================================================================================////
//**********************************************************************************************************************************************

/*echo "<pre>";
print_r(get_option('sidebars_widgets'));
print_r(get_option('widget_homebanner'));
exit;*/

/////////////// WIDGET SETTINGS START ///////////////
$homebanner = array();
//$cat_id = $wpdb->get_var("SELECT term_id FROM $wpdb->terms where name like 'Sports'");
$homebanner[1] = array(
					"title"			=>	'',
					"category"		=>	$cat_id,
					"desc_count"	=>	'50',
					"post_number"		=>	'5',
					);
$homebanner['_multiwidget'] = '1';
update_option('widget_homebanner',$homebanner);
$homebanner = get_option('widget_homebanner');
krsort($homebanner);
foreach($homebanner as $key1=>$val1)
{
	$homebanner_key = $key1;
	if(is_int($homebanner_key))
	{
		break;
	}
}
$sidebars_widgets["sidebar-1"] = array("homebanner-$homebanner_key");
$advtwidget[1] = array(
					"title"		=>	'',
					"desc1"		=>	'<a href="#" ><img src="'.$dummy_image_path.'advt.png" alt="" /> </a> ',
					);
$advtwidget['_multiwidget'] = '1';
update_option('widget_advtwidget',$advtwidget);
$advtwidget = get_option('widget_advtwidget');
krsort($advtwidget);
foreach($advtwidget as $key1=>$val1)
{
	$advtwidget_key = $key1;
	if(is_int($advtwidget_key))
	{
		break;
	}
}
$sidebars_widgets["sidebar-2"] = array("advtwidget-$advtwidget_key");

$video_allcat[1] = array(
					"title"		=>	'',
					"category"	=>	'',
					"post_number"=>	'',
					"desc_count"=>	'',
					);
$video_allcat['_multiwidget'] = '1';
update_option('widget_widget_video_allcat',$video_allcat);
$video_allcat = get_option('widget_widget_video_allcat');
krsort($video_allcat);
foreach($video_allcat as $key1=>$val1)
{
	$video_allcat_key = $key1;
	if(is_int($video_allcat_key))
	{
		break;
	}
}
$widget_posts1[1] = array(
					"title"		=>	'',
					"category"	=>	'',
					"post_number"=>	'',
					"desc_count"=>	'',
					);
$widget_posts1['_multiwidget'] = '1';
update_option('widget_widget_posts1',$widget_posts1);
$widget_posts1 = get_option('widget_widget_posts1');
krsort($widget_posts1);
foreach($widget_posts1 as $key1=>$val1)
{
	$widget_posts1_key = $key1;
	if(is_int($widget_posts1_key))
	{
		break;
	}
}
$cat_id = $wpdb->get_var("SELECT term_id FROM $wpdb->terms where name like 'Sports'");
$latestvideos[1] = array(
					"title"		=>	'Sports',
					"category"	=>	$cat_id,
					"post_number"=>	'4',
					"desc_count"=>	'',
					);
$latestvideos['_multiwidget'] = '1';
update_option('widget_latestvideos',$latestvideos);
$latestvideos = get_option('widget_latestvideos');
krsort($latestvideos);
foreach($latestvideos as $key1=>$val1)
{
	$latestvideos_key = $key1;
	if(is_int($latestvideos_key))
	{
		break;
	}
}
$sidebars_widgets["sidebar-3"] = array("widget_video_allcat-$video_allcat_key","latestvideos-$latestvideos_key");
$popularposts[1] = array(
					"name"		=>	'Popular Video',
					"number"	=>	'10',
					"desc_count"=>	'50',
					);
$popularposts['_multiwidget'] = '1';
update_option('widget_widget_popularposts',$popularposts);
$popularposts = get_option('widget_widget_popularposts');
krsort($popularposts);
foreach($popularposts as $key1=>$val1)
{
	$popularposts_key = $key1;
	if(is_int($popularposts_key))
	{
		break;
	}
}
$news2columns[1] = array(
					"title"		=>	'Featured Videos',
					"category"	=>	'',
					"post_number"	=>	'4',
					"post_link"	=>	'',
					"desc_count"=>	'50',
					);
$news2columns['_multiwidget'] = '1';
update_option('widget_news2columns',$news2columns);
$news2columns = get_option('widget_news2columns');
krsort($news2columns);
foreach($news2columns as $key1=>$val1)
{
	$news2columns_key = $key1;
	if(is_int($news2columns_key))
	{
		break;
	}
}
$sidebars_widgets["sidebar-4"] = array("widget_popularposts-$popularposts_key","news2columns-$news2columns_key");

$advtwidget = get_option('widget_advtwidget');
$advtwidget[2] = array(
					"title"		=>	'',
					"desc1"		=>	'<a href="#" ><img src="'.$dummy_image_path.'advt2.png" alt="" /> </a> ',
					);
$advtwidget['_multiwidget'] = '1';
update_option('widget_advtwidget',$advtwidget);
$advtwidget = get_option('widget_advtwidget');
krsort($advtwidget);
foreach($advtwidget as $key1=>$val1)
{
	$advtwidget_key = $key1;
	if(is_int($advtwidget_key))
	{
		break;
	}
}

$categories[1] = array(
					"title"		=>	'',
					"count"	=>	'0',
					"hierarchical"	=>	'0',
					"dropdown"	=>	'0',
					);
$categories['_multiwidget'] = '1';
update_option('widget_categories',$categories);
$categories = get_option('widget_categories');
krsort($categories);
foreach($categories as $key1=>$val1)
{
	$categories_key = $key1;
	if(is_int($categories_key))
	{
		break;
	}
}
$sidebars_widgets["sidebar-5"] = array("advtwidget-$advtwidget_key","categories-$categories_key");


$advtwidget = get_option('widget_advtwidget');
$advtwidget[3] = array(
					"title"		=>	'',
					"desc1"		=>	'<a href="#" ><img src="'.$dummy_image_path.'advt2.png" alt="" /> </a> ',
					);
$advtwidget['_multiwidget'] = '1';
update_option('widget_advtwidget',$advtwidget);
$advtwidget = get_option('widget_advtwidget');
krsort($advtwidget);
foreach($advtwidget as $key1=>$val1)
{
	$advtwidget_key = $key1;
	if(is_int($advtwidget_key))
	{
		break;
	}
}

$categories[2] = array(
					"title"		=>	'',
					"count"	=>	'0',
					"hierarchical"	=>	'0',
					"dropdown"	=>	'0',
					);
$categories['_multiwidget'] = '1';
update_option('widget_categories',$categories);
$categories = get_option('widget_categories');
krsort($categories);
foreach($categories as $key1=>$val1)
{
	$categories_key = $key1;
	if(is_int($categories_key))
	{
		break;
	}
}
$sidebars_widgets["sidebar-6"] = array("advtwidget-$advtwidget_key","categories-$categories_key");

$advtwidget = get_option('widget_advtwidget');
$advtwidget[4] = array(
					"title"		=>	'',
					"desc1"		=>	'<a href="#" ><img src="'.$dummy_image_path.'advt2.png" alt="" /> </a> ',
					);
$advtwidget['_multiwidget'] = '1';
update_option('widget_advtwidget',$advtwidget);
$advtwidget = get_option('widget_advtwidget');
krsort($advtwidget);
foreach($advtwidget as $key1=>$val1)
{
	$advtwidget_key = $key1;
	if(is_int($advtwidget_key))
	{
		break;
	}
}
$news2columns = get_option('widget_news2columns');
$news2columns[2] = array(
					"title"		=>	'Featured Videos',
					"category"	=>	'',
					"post_number"	=>	'4',
					"post_link"	=>	'',
					"desc_count"=>	'50',
					);
$news2columns['_multiwidget'] = '1';
update_option('widget_news2columns',$news2columns);
$news2columns = get_option('widget_news2columns');
krsort($news2columns);
foreach($news2columns as $key1=>$val1)
{
	$news2columns_key = $key1;
	if(is_int($news2columns_key))
	{
		break;
	}
}
$sidebars_widgets["sidebar-7"] = array("advtwidget-$advtwidget_key","news2columns-$news2columns_key");
$news2columns = get_option('widget_news2columns');
$news2columns[3] = array(
					"title"		=>	'Featured Videos',
					"category"	=>	'',
					"post_number"	=>	'4',
					"post_link"	=>	'',
					"desc_count"=>	'50',
					);
$news2columns['_multiwidget'] = '1';
update_option('widget_news2columns',$news2columns);
$news2columns = get_option('widget_news2columns');
krsort($news2columns);
foreach($news2columns as $key1=>$val1)
{
	$news2columns_key = $key1;
	if(is_int($news2columns_key))
	{
		break;
	}
}
$sidebars_widgets["sidebar-8"] = array("news2columns-$news2columns_key");

$subscribewidget[1] = array(
					"id"		=>	'templatic/eKPs',
					"title"	=>	'Subscribe',
					"text"	=>	'<p>If you did like to stay updated with all our latest news please enter your e-mail address here </p>',
					);
$subscribewidget['_multiwidget'] = '1';
update_option('widget_widget_subscribewidget',$subscribewidget);
$subscribewidget = get_option('widget_widget_subscribewidget');
krsort($subscribewidget);
foreach($subscribewidget as $key1=>$val1)
{
	$subscribewidget_key = $key1;
	if(is_int($subscribewidget_key))
	{
		break;
	}
}
$textinfo = array();
$textinfo[1] = array(
					"title"			=>	'Wordpress Themes Club',
					"text"			=>	'<p>The Templatic <a href="http://templatic.com/premium-themes-club/">Wordpress Themes Club</a> membership is ideal for any WordPress developer and freelancer that needs access to a wide variety of Wordpress themes. This themes collection saves you hundreds of dollars and also gives you the fantastic deal of allowing you to install any of our themes on unlimited domains. </p>',
					);
$textinfo['_multiwidget'] = '1';
update_option('widget_text',$textinfo);
$textinfo = get_option('widget_text');
krsort($textinfo);
foreach($textinfo as $key1=>$val1)
{
	$textinfo_key = $key1;
	if(is_int($textinfo_key))
	{
		break;
	}
}
$sidebars_widgets["sidebar-9"] = array("text-$textinfo_key");
$sidebars_widgets["sidebar-10"] = array("widget_subscribewidget-$subscribewidget_key");
$links = array();
$links[1] = array(
					"images"	=>	'1',
					"name"	=>	'1',
					"description"	=>	'0',
					"rating"	=>	'0',
					"category"	=>	'0',
					);
$links['_multiwidget'] = '1';
update_option('widget_links',$links);
$links = get_option('widget_links');
krsort($links);
foreach($links as $key1=>$val1)
{
	$links_key = $key1;
	if(is_int($links_key))
	{
		break;
	}
}
$sidebars_widgets["sidebar-11"] = array("links-$links_key");

$exclude_pages = $page_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts where post_title in ('Sub Page 1','Sub Page 2','Sub Page in 1','Sub Page in 2') and post_type='page'");
$pages = array();
$pages[1] = array(
					"title"	=>	'Help page',
					"sortby"	=>	'post_title',
					"exclude"	=>	$exclude_pages,
					);
$pages['_multiwidget'] = '1';
update_option('widget_pages',$pages);
$pages = get_option('widget_pages');
krsort($pages);
foreach($pages as $key1=>$val1)
{
	$pages_key = $key1;
	if(is_int($pages_key))
	{
		break;
	}
}
$sidebars_widgets["sidebar-12"] = array("pages-$pages_key");
$socialmedia = array();
$socialmedia[1] = array(
					"id"	=>	'#',
					"title"	=>	'Follow Us',
					"text"	=>	'',
					"twitter"	=>	'#',
					"facebook"	=>	'#',
					"myspace"	=>	'#',
					);
$socialmedia['_multiwidget'] = '1';
update_option('widget_widget_socialmedia',$socialmedia);
$socialmedia = get_option('widget_widget_socialmedia');
krsort($socialmedia);
foreach($socialmedia as $key1=>$val1)
{
	$socialmedia_key = $key1;
	if(is_int($socialmedia_key))
	{
		break;
	}
}
$sidebars_widgets["sidebar-13"] = array("widget_socialmedia-$socialmedia_key");
$advtwidget = get_option('widget_advtwidget');
$advtwidget[5] = array(
					"title"		=>	'',
					"desc1"		=>	'<a href="#" ><img src="'.$dummy_image_path.'advt_468x60px.png" alt="" /> </a> ',
					);
$advtwidget['_multiwidget'] = '1';
update_option('widget_advtwidget',$advtwidget);
$advtwidget = get_option('widget_advtwidget');
krsort($advtwidget);
foreach($advtwidget as $key1=>$val1)
{
	$advtwidget_key = $key1;
	if(is_int($advtwidget_key))
	{
		break;
	}
}
$sidebars_widgets["sidebar-14"] = array("advtwidget-$advtwidget_key");
//===============================================================================
//////////////////////////////////////////////////////
update_option('sidebars_widgets',$sidebars_widgets);  //save widget iformations
/////////////// WIDGET SETTINGS END ///////////////

//=====================================================================
$photo_page_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts where post_title like 'Archive Pages' and post_type='page'");
update_post_meta( $photo_page_id, '_wp_page_template', 'page-archives.php' );

$photo_page_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts where post_title like 'Site Map' and post_type='page'");
update_post_meta( $photo_page_id, '_wp_page_template', 'page-sitemap.php' );


//=====================================================================
/////////////// Design Settings START ///////////////
update_option("ptthemes_alt_stylesheet",'1-default.css');
update_option("ptthemes_feedburner_url",'http://feeds2.feedburner.com/templatic');
update_option("ptthemes_feedburner_id",'templatic/ekPs');
update_option("ptthemes_tweet_button",'1');
update_option("ptthemes_facebook_button",'1');

$ptthemes_videocategory = array();
$ptthemes_blogcategory = array();
$ptthemes_header_nav = array();
$ptthemes_header_nav = $page_id = $wpdb->get_col("SELECT ID FROM $wpdb->posts where post_title in ('Wp Themes Club') and post_type='page'");
$ptthemes_videocategory = $wpdb->get_col("SELECT term_id FROM $wpdb->terms where name in ('Health','Entertainment','Music','Others','Funny','Sports')");
$ptthemes_blogcategory = $wpdb->get_col("SELECT term_id FROM $wpdb->terms where name in ('Blog')");

update_option("ptthemes_videocategory",$ptthemes_videocategory);

update_option("ptthemes_blogcategory",$ptthemes_blogcategory);

update_option("ptthemes_header_nav",$ptthemes_header_nav);
update_option("ptthemes_breadcrumbs",'1');

update_option("ptthemes_search_name",'Search');
update_option("ptthemes_search_nothing_found",'Nothing found, please search again.');
update_option("ptthemes_general_tags_name",'Tags');
update_option("ptthemes_pages_name",'Pages');
update_option("ptthemes_last_posts",'Last 60 Blog Posts');
update_option("ptthemes_monthly_archives",'Monthly Archives');
update_option("ptthemes_categories_name",'Categories');
update_option("ptthemes_rssfeeds_name",'Available RSS Feeds');
update_option("ptthemes_404error_name",'Error 404 | Nothing found!');
update_option("ptthemes_404solution_name",'Sorry, but you are looking for something that is not here.');
update_option("ptthemes_password_protected_name",'This post is password protected. Enter the password to view comments.');
update_option("ptthemes_comment_responsesa_name",'No Comments');
update_option("ptthemes_comment_responsesb_name",'One Comment');
update_option("ptthemes_comment_responsesc_name",'% Comments');
update_option("ptthemes_comment_trackbacks_name",'Trackbacks For This Post');
update_option("ptthemes_comment_moderation_name",'Your comment is awaiting moderation.');
update_option("ptthemes_comment_conversation_name",'Be the first to start a conversation');
update_option("ptthemes_comment_closed_name",'Comments are closed.');
update_option("ptthemes_comment_off_name",'Comments are off for this post');
update_option("ptthemes_comment_reply_name",'Leave a Reply');
update_option("ptthemes_comment_mustbe_name",'You must be');
update_option("ptthemes_comment_loggedin_name",'logged in');
update_option("ptthemes_comment_postcomment_name",'to post a comment.');
update_option("ptthemes_comment_name_name",'Name');
update_option("ptthemes_comment_mail_name",'Mail');
update_option("ptthemes_comment_website_name",'Website');
update_option("ptthemes_comment_addcomment_name",'Add Comment');
update_option("ptthemes_comment_justreply_name",'Reply');
update_option("ptthemes_comment_edit_name",'Edit');
update_option("ptthemes_comment_delete_name",'Delete');
update_option("ptthemes_comment_spam_name",'Spam');
update_option("ptthemes_pagination_first_name",'First');
update_option("ptthemes_pagination_last_name",'Last');
/////////////// Design Settings END ///////////////
//====================================================================================//

?>