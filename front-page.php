<?php
/**
 * AgentPress Pro.
 *
 * This file adds the front page to the AgentPress Pro Theme.
 *
 * @package AgentPress
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/agencypress/
 */

// Enqueue scripts.
add_action( 'wp_enqueue_scripts', 'agentpress_front_page_enqueue_scripts' );
function agentpress_front_page_enqueue_scripts() {
	// Add agentpress-pro-home body class.
	add_filter( 'body_class', 'agentpress_body_class' );

}

add_action( 'genesis_meta', 'agentpress_home_genesis_meta' );
/**
 * Add widget support for homepage. If no widgets active, display the default loop.
 *
 */
function agentpress_home_genesis_meta() {

if ( is_active_sidebar( 'home-featured' ) || is_active_sidebar( 'home-top' ) || is_active_sidebar( 'home-middle-1' ) || is_active_sidebar( 'home-middle-2' ) || is_active_sidebar( 'home-middle-3' ) || is_active_sidebar( 'home-bottom' ) ) {

	// Force full-width-content layout setting.
	add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

	// Remove breadcrumbs.
	remove_action( 'genesis_before_content_sidebar_wrap', 'genesis_do_breadcrumbs' );

	// Add home featured area.
	add_action( 'genesis_after_header', 'agentpress_home_featured_widget' );
	add_action( 'genesis_after_header', 'tfs_category_listing',2 );
	add_action( 'genesis_after_header', 'tfs_subheader',1 );
	// Add home widget area.
	add_action( 'genesis_before_footer', 'agentpress_home_widgets', 1 );

}
}

function tfs_subheader(){?>
	<div class="tfs_hero_section">
		<div class="tfs_hero_wrapper">		
			<div class="tfs_hero_heading">	Make your inbox happy again! ❤️
			</div>
			<div class="tfs_hero_subheading">Find the best newsletters for your taste. Never have a dull moment again!				
			</div>
		</div>
	</div>
<?php
}

function agentpress_body_class( $classes ) {

	$classes[] = 'agentpress-pro-home';
	return $classes;

}

function tfs_category_listing(){
$category_loop='';
$category_names = get_terms("newsletter_categories");
//  var_dump($category_names);
// die;
if( $category_names):
		foreach($category_names as $category_name):
			$category_loop .= sprintf( '<div class="category_listing"><a href="%s" class="category_button">%s</a></div>', get_term_link($category_name), strtolower(trim( $category_name->name) ) );
		endforeach;
endif; 
printf( '<div class="category-list-wrapper-frontpage full-width"><div class="wrap"><div class="category-listing-wrap">%s</div></div></div>', $category_loop );
}

function agentpress_home_featured_widget() {

genesis_widget_area( 'home-featured', array(
	'before' => '<div class="home-featured full-width widget-area"><div class="wrap">',
	'after' => '</div></div>',
) );

}

function agentpress_home_widgets() {

genesis_widget_area( 'home-top', array(
	'before' => '<div class="home-top full-width widget-area"><div class="wrap">',
	'after'  => '</div></div>',
) );

if ( is_active_sidebar( 'home-middle-1' ) || is_active_sidebar( 'home-middle-2' ) || is_active_sidebar( 'home-middle-3' ) ) {

	echo '<div class="home-middle"><div class="wrap">';

		genesis_widget_area( 'home-middle-1', array(
			'before' => '<div class="home-middle-1 full-width widget-area">',
			'after'  => '</div>',
		) );

		genesis_widget_area( 'home-middle-2', array(
			'before' => '<div class="home-middle-2 widget-area">',
			'after'  => '</div>',
		) );

		genesis_widget_area( 'home-middle-3', array(
			'before' => '<div class="home-middle-3 widget-area">',
			'after'  => '</div>',
		) );

	echo '</div></div>';
	
}

genesis_widget_area( 'home-bottom', array(
	'before' => '<div class="home-bottom full-width widget-area"><div class="wrap">',
	'after'  => '</div></div>',
) );

}
// Remove the default Genesis loop.
remove_action( 'genesis_loop', 'genesis_do_loop' );
add_action( 'genesis_loop', 'tfs_homepage_loop' );


// Custom loop for frontpage.
function tfs_homepage_loop() {		

		$args =  array(
			'post_type' => 'newsletter',
			'posts_per_page' => 12,
			'post_status'=>'publish',
			'orderby'=> 'date',
			'order' => 'ASC',
			'paged' => get_query_var('page')
		);
		global $wp_query;
		$wp_query = new WP_Query( $args );

			if ( have_posts() ) : 
					echo '<h3>Take a look at some of the latest newsletters in our directory</h3>';
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
