<?php
/**
 * Genesis Framework.
 *
 * WARNING: This file is part of the core Genesis Framework. DO NOT edit this file under any circumstances.
 * Please do all modifications in the form of a child theme.
 *
 * @package Genesis\Templates
 * @author  StudioPress
 * @license GPL-2.0-or-later
 * @link    https://my.studiopress.com/themes/genesis/
 */

add_action( 'genesis_before_loop', 'genesis_do_search_title' );
/**
 * Echo the title with the search term.
 *
 * @since 1.9.0
 */
function genesis_do_search_title() {

    global $wp_query;

	$title = sprintf( '<div class="archive-description"><h1 class="archive-title">%s %s %s</h1></div>', $wp_query->found_posts, apply_filters( 'genesis_search_title_text', __( 'Search Results for:', 'genesis' ) ), get_search_query() );

	echo apply_filters( 'genesis_search_title_output', $title ) . "\n"; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

}

genesis();