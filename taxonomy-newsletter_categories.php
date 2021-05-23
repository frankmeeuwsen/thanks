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
            echo '<h3>The best '.strtolower(single_cat_title( '', false )).' newsletters</h3>';
            echo '<div class="tfs-related-grid alignwide" role="list">';

        while ( have_posts() ) : the_post(); ?>

            <div class="tfs-related-grid__tile" role="list-item">
                    <a href="<?php the_permalink(); ?>" class="newsletter-wrapper">
                        <div class="tfs-related-grid__image">
                            <img src="<?php  echo get_the_post_thumbnail_url(get_the_id(),'tfs-header') ?: 'https://source.unsplash.com/random/300x200/?'.$this_category[0]->name.''; ?>" width="300" height="200" class="tfs-imageblock" alt="<?php echo get_the_content(); ?>" title="<?php echo get_the_content(); ?>">
                        </div>
                        <div class="tfs-related-grid__avatar"><img src="<?php  echo get_field('logo'); ?>" width="32" height="32" class="tfs-related-grid__logo"></div>
                        <div class="tfs-related-grid__tile-content"><h4><a href="<?php echo get_permalink() ?>"><?php echo the_title() ?></a></h4>
                        <div class="tfs-related__content"><?php  echo get_the_content(); ?></div>
                    </a>             
                    </div>
            </div>

<?php
	endwhile; 

	genesis_posts_nav();

	else: printf( '<div class="entry"><p>%s</p></div>', __( 'Sorry, no properties matched your criteria.', 'agentpress' ) );

	endif;

}

// Run the Genesis loop.
genesis();
