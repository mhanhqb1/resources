<?php
/*
Template Name: Sitemap Page
*/
?>
<?php get_header(); ?>
<?php $is_page = true; ?>
 
		  <div id="content" class="content_index clearfix">			 
 				 <?php if ( get_option( 'ptthemes_breadcrumbs' )) { yoast_breadcrumb('<div class="breadcrumb">','</div>'); } ?>

               <h1 class="cat_head" >
				  <?php 
				  if(have_posts()) 
				  {
						while(have_posts())
						{ 
							the_post();
							the_title();
						}
					}
				   ?> 
				 </h1>
                
                  
                 
     	
		<div id="post-<?php the_ID(); ?>" class="post archive-spot<?php post_class(); ?>">
      <div class="arclist clearfix">
        <h3>Pages :</h3>
        <ul >
          <?php wp_list_pages('title_li='); ?>
        </ul>
      </div>
      <!--/arclist -->
      <div class="arclist clearfix">
        <h3>Latest Posts: </h3>
        <ul>
          <?php $archive_query = new WP_Query('showposts=60');
		                        
								while ($archive_query->have_posts()) : $archive_query->the_post(); ?>
          <li><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>">
            <?php the_title(); ?>
            </a> <strong>
            <?php comments_number('0', '1', '%'); ?>
            </strong></li>
          <?php endwhile; ?>
        </ul>
      </div>
      <!--/arclist -->
     <div class="arclist clearfix">
        <h3>Monthly Archives:</h3>
        <ul>
          <?php wp_get_archives('type=monthly'); ?>
        </ul>
      </div>
      <!--/arclist -->
      <div class="arclist clearfix">
        <h3>Categories:</h3>
        <ul>
          <?php wp_list_categories('title_li=&hierarchical=0&show_count=1') ?>
        </ul>
      </div>
      <!--/arclist -->
      <div class="arclist clearfix">
        <h3>RSS Feed:</h3>
        <ul>
          <li><a href="<?php bloginfo('rdf_url'); ?>" title="RDF/RSS 1.0 feed">RDF / RSS 1.0 feed</a></li>
          <li><a href="<?php bloginfo('rss_url'); ?>" title="RSS 0.92 feed">RSS 0.92 feed</a></li>
          <li><a href="<?php bloginfo('rss2_url'); ?>" title="RSS 2.0 feed">RSS 2.0 feed</a></li>
          <li><a href="<?php bloginfo('atom_url'); ?>" title="Atom feed">Atom feed</a></li>
        </ul>
      </div>
      <!--/arclist -->
    </div>
        
	   
      </div> <!-- content  #end -->
        
        
		  <?php get_sidebar(); ?>
	
<?php get_footer(); ?>