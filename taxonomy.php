<?php
// Force full width layout.
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

// Relocate archive intro text.
remove_action( 'genesis_before_loop', 'genesis_do_taxonomy_title_description', 15 );
add_action( 'genesis_before_content_sidebar_wrap', 'genesis_do_taxonomy_title_description' );

// Remove the standard loop.
remove_action( 'genesis_loop', 'genesis_do_loop' );

add_action( 'genesis_loop', 'tfs_category_loop' );
/**
 * Custom loop for category page.
 */
function tfs_category_loop() {

	if ( have_posts() ) : 
    
			echo '<div class="tfs-related-grid__tile-header">
            			<h3>The best '.strtolower(single_cat_title( '', false )).' newsletters</h3>
                        </div>';
            if ( category_description() ) :
                echo category_description( get_category_by_slug( 'category-slug' )->term_id ) ;
            endif;
					echo '<div class="tfs-related-grid alignwide" role="list">';



            echo '</div><div class="tfs-related-grid alignwide" role="list">';

        while ( have_posts() ) : the_post(); 
			get_template_part( 'template/grid' );
		endwhile; 
			echo '</div><div class="pagination-center">';
			genesis_posts_nav();
			echo '</div>';
	else: printf( '<div class="entry"><p>%s</p></div>', __( 'Sorry, no properties matched your criteria.', 'agentpress' ) );
	endif;
    wp_reset_query();
}
// Run the Genesis loop.
genesis();
