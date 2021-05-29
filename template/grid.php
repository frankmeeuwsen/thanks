<?php
/**
 * Grid template
 *
 * @package      TFSGEnesis
 * @author       Frank Meeuwsen
 * @since        1.0.0
 * @license      GPL-2.0+
**/          
        echo '<div class="tfs-related-grid__tile" role="list-item">';
        echo '<a href="'.get_permalink().'" class="newsletter-wrapper">';
        echo '<div class="tfs-related-grid__image">';
        // echo '<img src="'.get_the_post_thumbnail_url(get_the_id(),'tfs-header').'" width="300" height="200" class="tfs-imageblock">';
        ?>
        <img src="<?php echo get_the_post_thumbnail_url(get_the_id(),'tfs-header') ?: 'https://picsum.photos/300/200?nocache='.microtime();?>" width="300" height="200" class="tfs-imageblock">
        <?php
        echo '</div>';
        echo '<div class="tfs-related-grid__avatar"><img src="'.get_field('logo_lokaal').'" width="32" height="32" class="tfs-related-grid__logo"></div>';
        echo '<div class="tfs-related-grid__tile-content"><h4><a href="'.get_permalink().'">'.get_the_title().'</a></h4></div>';
        echo '<div class="tfs-related__content">'.get_the_content().'</div>';
        echo'</a>';
        echo'</div>';
