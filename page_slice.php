<?php
/**
 * AgentPress Pro.
 *
 * This file adds the landing page template to the AgentPress Pro Theme.
 *
 * Template Name: Slice Landing
 *
 * @package AgentPress
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/agencypress/
 */

// Add custom body class to the head.
add_filter( 'body_class', 'agentpress_add_body_class' );
function agentpress_add_body_class( $classes ) {

	$classes[] = 'agentpress-pro-home';

	return $classes;

}

// Force full width content layout.
// add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );
	add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

// Remove site header elements.
// remove_action( 'genesis_header', 'genesis_header_markup_open', 5 );
// remove_action( 'genesis_header', 'genesis_do_header' );
// remove_action( 'genesis_header', 'genesis_header_markup_close', 15 );

// Remove navigation.
// remove_action( 'genesis_before_header', 'genesis_do_nav' );

// Remove breadcrumbs.
// remove_action( 'genesis_before_content_sidebar_wrap', 'genesis_do_breadcrumbs' );

// Remove site footer widgets.
// remove_action( 'genesis_before_footer', 'genesis_footer_widget_areas' );

// Remove site footer elements.
// remove_action( 'genesis_footer', 'genesis_footer_markup_open', 5 );
// remove_action( 'genesis_footer', 'genesis_do_subnav', 7 );
// remove_action( 'genesis_footer', 'genesis_do_footer' );
// remove_action( 'genesis_footer', 'agentpress_disclaimer' );
// remove_action( 'genesis_footer', 'genesis_footer_markup_close', 15 );


// remove_action( 'genesis_loop', 'genesis_do_loop' );
add_action( 'genesis_after_entry_content', 'tfs_homepage_loop' );


// Custom loop for frontpage.
function tfs_homepage_loop() {		

		$args =  array(
			'post_type' => 'newsletter',
			'posts_per_page' => 12,
			'post_status'=>'publish',
			'orderby'=> 'date',
			'order' => 'DESC',
			'meta_query' => array(
				array(
					'key' => 'slice_landingpage', // name of custom field
					'value' => '1'
					)
			),

			'paged' => get_query_var('page')
		);
		global $wp_query;
		$wp_query = new WP_Query( $args );
// slice_landingpage
			if ( have_posts() ) : 
			// echo '<div class="tfs-related-grid__tile-header">
            //                     <h3>Take a look at some of the latest newsletters in our directory</h3>
            //             </div>';
					echo '<div class="tfs-related-grid alignwide" role="list">';
				while ( have_posts() ) : the_post();
				get_template_part('template/grid');
				endwhile; 
				echo '</div><div class="pagination-center">';
				genesis_posts_nav();
				echo '</div>';
			endif;
				wp_reset_query();
		}





// Run the Genesis loop.



genesis();
