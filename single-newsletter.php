<?php
remove_action( 'genesis_loop', 'genesis_do_loop' );
add_action( 'genesis_loop', 'tfs_custom_loop' );
// add_action( 'genesis_after_content', 'tfs_related_posts' );

function tfs_custom_loop() { ?>
<article itemtype="http://schema.org/CreativeWork" itemscope="itemscope" class="post-<?php print get_the_id(); ?> page type-page status-publish entry h-entry">
<div class="entry-content" itemprop="text">

<div class="tfs-detail__wrapper">
    <?php if(have_posts()) :
        while(have_posts()) : the_post(); ?>
        <?php 
            $category_terms = get_the_terms ($post->id, 'newsletter_categories');
            $category_links = wp_list_pluck($category_terms, 'name'); 
            $category_name = implode(" / ", $category_links);
            $frequency_terms = get_the_terms ($post->id, 'frequency');
            $frequency_links = wp_list_pluck($frequency_terms, 'name'); 
            $frequency_name = implode(" / ", $frequency_links);
            
            ?>
        <div class="tfs-detail__image-wrapper">
            <img src="<?php  echo get_the_post_thumbnail_url(get_the_id(), 'tfs-header') ?: 'https://picsum.photos/600/400?nocache='.microtime(); ?>" width="600" height="400" class="tfs-imageblock" alt="<?php echo the_content(); ?>" title="<?php echo the_title(); ?>">
        </div><?php 
        if(get_field('logo_lokaal')){
       echo '<div class="tfs-detail__avatar"><img src="'.get_field('logo_lokaal').'" width="32" height="32" class="tfs-detail__logo"></div>';
        }
     ?>
        <div class="tfs-detail__content-wrapper">
            <div class="tfs-detail__category-block"><?php echo $category_name; ?></div>
            <h2><?php  echo the_title(); ?> </h2>
                        <?php 
                if(get_field('twitter')){
                    echo '<a class="tfs_twitter" href="https://twitter.com/'.get_field('twitter').'"><span class="dashicons dashicons-twitter"></span></a>';
                }  
            ?>

            <p><?php  echo the_content(); ?></p>
            <div class="tfs-button-wrapper">
            <a class="tfs-detail__subscribe-button button-subscribe w-button" href="<?php  echo get_field('subscribe'); ?>">Subscribe to this newsletter</a>
            <a class="tfs-detail__example-button w-button" href="<?php  echo get_field('example'); ?>">See an example first</a>
            <?php if($frequency_name)
            { echo 
            '<a class="tfs-detail__frequency-button w-button" href="/frequency/'.  $frequency_name.'">'.  $frequency_name .'</a>'
            ;}?>
            
            </div>
        </div>
</div>
</div>
</article>
<?php

        $this_category = get_the_terms($post->ID, 'newsletter_categories');
        $related_newsletters = new WP_Query( array(
			'post_type' => 'newsletter',
			'posts_per_page' => -1,
			'orderby'=> 'date',
			'order' => 'DESC',
			'tax_query' => array(
				array(
					'taxonomy' => 'newsletter_categories', // name of custom field
					'field' => 'term_id',
					'terms' => $this_category[0]->term_id
				)
			)
		));

if ($related_newsletters) {
        echo '<div class="tfs-related-grid__tile-header"><h3>Related '.$this_category[0]->name.' newsletters</h3></div>';
            echo '<div class="tfs-related-grid alignwide" role="list">';

        while ($related_newsletters->have_posts()):$related_newsletters->the_post();
        get_template_part('template/grid');
        endwhile;
    echo '</div>';
    }
    endwhile;
endif;	 
?>
<?php
 }
wp_reset_postdata();

// This file handles single entries, but only exists for the sake of child theme forward compatibility.
genesis();
