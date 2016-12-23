<?php get_header(); ?>
<?php
$views_count = get_post_meta($post->ID, 'views_count', true);
update_post_meta($post->ID, 'views_count', $views_count + 1);
?>

<?php //if ( get_option( 'ptthemes_breadcrumbs' )) { yoast_breadcrumb('<div class="breadcrumb">','</div>'); } ?>
<h1 class="single_head"><?php the_title(); ?></h1>


<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/library/js/mootools.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/library/js/slimbox.js"></script>


<div class="likethis">

    <?php if (get_option('ptthemes_tweet_button')) { ?>
        <a href="http://twitter.com/share" class="twitter-share-button">Tweet</a>
        <script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script> 

    <?php } ?>

    <?php if (get_option('ptthemes_facebook_button')) { ?>

        <iframe class="facebook" src="http://www.facebook.com/plugins/like.php?href=<?php echo urlencode(get_permalink($post->ID)); ?>&amp;layout=standard&amp;show_faces=false&amp;width=290&amp;action=like&amp;colorscheme=light" scrolling="no" frameborder="0"  style="border:none; overflow:hidden; width:290px; height:24px"></iframe> 
    <?php } ?>
</div>


<div id="content" class="col-sm-9 col-xs-12 clearfix" >
    <div class="single_post">
        <?php if (have_posts()) : ?>
            <?php $post_images = bdw_get_images($post->ID, 'large'); ?>
            <?php while (have_posts()) : the_post() ?>

                <div id="post-<?php the_ID(); ?>" class="posts post_spacer" <?php post_class(); ?>>




                    <?php if (get_post_meta($post->ID, 'video', true)) { ?>
                        <div class="video_main">
                            <?php echo get_post_meta($post->ID, 'video', true); ?>
                        </div>

                    <?php } ?> 


                    <div class="bookmark_links">
                        <?php if (function_exists('the_ratings')) {
                            the_ratings();
                        } ?> 


        <?php if (get_post_meta($post->ID, 'views_count', true)) { ?>
                            <span class="post-views" >
                                Total Views : <?php echo get_post_meta($post->ID, 'views_count', true); ?>
                            </span> 
                        <?php } ?> 


                        <?php if (get_post_meta($post->ID, 'twitter', true)) { ?>
                            <a href="<?php echo get_post_meta($post->ID, 'twitter', true); ?>" target="_blank" class="i_twitter"> <?php _e('Twitter', 'templatic'); ?> </a> 
                        <?php } ?> 

                        <?php if (get_post_meta($post->ID, 'facebook', true)) { ?>
                            <a href=" <?php echo get_post_meta($post->ID, 'facebook', true); ?>" target="_blank" class="i_facebook"> <?php _e('Facebook', 'templatic'); ?> </a> 
        <?php } ?>  

                        <div class="share"> 
                            <div class="addthis_toolbox addthis_default_style">
                                <a href="http://www.addthis.com/bookmark.php?v=250&amp;username=xa-4c873bb26489d97f" class="addthis_button_compact sharethis"><?php _e('Share Video', 'templatic'); ?></a>
                            </div>
                            <script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#username=xa-4c873bb26489d97f"></script>
                        </div>


                    </div>
                    <div class="single_video_detail">
                        <h4>  <?php _e('About Video', 'templatic'); ?></h4>
                        <p class="uploaded_date"><?php _e('Uploaded on', 'templatic'); ?> <?php the_time('j F') ?>, <?php the_time('Y') ?> </p>

                        <?php the_content(); ?>


                        <?php if (get_post_meta($post->ID, 'time', true)) { ?>
                            <p class="common_text"><span> Length :</span> <?php echo get_post_meta($post->ID, 'time', true); ?> </p>
                        <?php } ?> 


        <?php the_taxonomies(array('before' => '<p class="common_text">', 'sep' => '<p></p><p class="common_text">', 'after' => '</p> ')); ?>
                    </div>
                </div> <!-- post #end -->

                <div class="pos_navigation clearfix">
                    <div class="post_left fl"><?php previous_post_link('%link', '&laquo; ' . __('Previous', 'templatic')) ?></div>
                    <div class="post_right fr"><?php next_post_link('%link', __('Next') . ' &raquo;', 'templatic') ?></div>
                </div>
            </div> <!-- single post content #end -->
            <?php get_related_posts($post); ?>		
    <?php endwhile; ?>
<?php endif; ?>

    <div id="comments" class="clearfix"> <?php comments_template(); ?></div>


</div> <!-- content #end -->



<div id="sidebar" class="sidebar_bnone col-sm-3 col-xs-12 ">

    <div class="single_sidebar">
<?php dynamic_sidebar(8); ?>
    </div>

</div> <!-- sidebar right--> 

<?php get_footer(); ?>