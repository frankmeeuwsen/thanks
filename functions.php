<?php
/**
 * AgentPress Pro.
 *
 * This file adds the functions to the AgentPress Pro Theme.
 *
 * @package AgentPress
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/agencypress/
 */

// Start the engine.
include_once( get_template_directory() . '/lib/init.php' );

// Setup Theme.
include_once( get_stylesheet_directory() . '/lib/theme-defaults.php' );

// Set Localization (do not remove).
load_child_theme_textdomain( 'agentpress', apply_filters( 'child_theme_textdomain', get_stylesheet_directory() . '/languages', 'agentpress' ) );

// Add Image upload to WordPress Theme Customizer.
require_once( get_stylesheet_directory() . '/lib/customize.php' );

// Child theme (do not remove).
define( 'CHILD_THEME_NAME', __( 'AgentPress Pro', 'agentpress' ) );
define( 'CHILD_THEME_URL', 'http://my.studiopress.com/themes/agentpress/' );
define( 'CHILD_THEME_VERSION', '3.1.22' );

// Add HTML5 markup structure.
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );

// Add viewport meta tag for mobile browsers.
add_theme_support( 'genesis-responsive-viewport' );

// Enqueue Google fonts.
add_action( 'wp_enqueue_scripts', 'agentpress_google_fonts' );
function agentpress_google_fonts() {

	// wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css2?family=Lato&family=Roboto&family=Signika', array(), CHILD_THEME_VERSION );
	wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Lato:300,600,700|Roboto:700,300,400|Signika:700', array(), CHILD_THEME_VERSION );


}

// Enqueue Scripts.
add_action( 'wp_enqueue_scripts', 'agentpress_scripts' );
function agentpress_scripts() {

	wp_enqueue_style( 'dashicons' );
	wp_enqueue_script( 'agentpress-responsive-menu', get_stylesheet_directory_uri() . '/js/responsive-menu.js', array( 'jquery' ), '1.0.1' );

}

// Add new image sizes.
// add_image_size( 'properties', 500, 300, TRUE );
add_image_size( 'tfs-header', 600, 400, TRUE );

// Add support for custom header.
add_theme_support( 'custom-header', array(
	'header-selector' => '.site-title a',
	'header-text'     => false,
	'height'          => 80,
	'width'           => 320,
) );

// Add support for structural wraps.
add_theme_support( 'genesis-structural-wraps', array(
	'header',
	'nav',
	'subnav',
	'site-inner',
	'footer-widgets',
	'footer',
) );

// Add support for additional color style options.
// add_theme_support( 'genesis-style-selector', array(
// 	'agentpress-pro-blue'  => __( 'AgentPress Pro Blue', 'agentpress' ),
// 	'agentpress-pro-gold'  => __( 'AgentPress Pro Gold', 'agentpress' ),
// 	'agentpress-pro-green' => __( 'AgentPress Pro Green', 'agentpress' ),
// ) );

// Filter the property details array.
// add_filter( 'agentpress_property_details', 'agentpress_property_details_filter' );
function agentpress_property_details_filter( $details ) {

	$details['col1'] = array( 
		__( 'Price:', 'agentpress' )   => '_listing_price', 
		__( 'Address:', 'agentpress' ) => '_listing_address', 
		__( 'City:', 'agentpress' )    => '_listing_city', 
		__( 'State:', 'agentpress' )   => '_listing_state', 
		__( 'ZIP:', 'agentpress' )     => '_listing_zip',
	);

	$details['col2'] = array( 
		__( 'MLS #:', 'agentpress' )       => '_listing_mls', 
		__( 'Square Feet:', 'agentpress' ) => '_listing_sqft', 
		__( 'Bedrooms:', 'agentpress' )    => '_listing_bedrooms', 
		__( 'Bathrooms:', 'agentpress' )   => '_listing_bathrooms', 
		__( 'Basement:', 'agentpress' )    => '_listing_basement',
	);

	return $details;

}

// Rename primary and secondary navigation menus.
add_theme_support( 'genesis-menus' , array( 
	'primary' => __( 'Before Header Menu', 'agentpress' ), 
	'secondary' => __( 'Footer Menu', 'agentpress' ) 
	)
 );

// Reposition the primary navigation.
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_before_header', 'genesis_do_nav' );

// Reposition the secondary navigation menu.
remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'genesis_footer', 'genesis_do_subnav', 7 );

// Reduce the secondary navigation menu to one level depth.
add_filter( 'wp_nav_menu_args', 'agentpress_secondary_menu_args' );
function agentpress_secondary_menu_args( $args ) {

	if ( 'secondary' != $args['theme_location'] ) {
		return $args;
	}

	$args['depth'] = 1;

	return $args;

}

// Reposition the breadcrumbs.
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );
add_action( 'genesis_before_content_sidebar_wrap', 'genesis_do_breadcrumbs' );

// Add Discliamer to Footer.
add_action( 'genesis_footer', 'agentpress_disclaimer' );
	function agentpress_disclaimer() {
		genesis_widget_area( 'disclaimer', array(
			'before' => '<div class="disclaimer widget-area">',
			'after'  => '</div>',
		) );
}

// Customize Listings.
// add_action( 'genesis_before', 'agentpress_listing_styles' );
function agentpress_listing_styles() {
	if ( is_singular( 'listing' ) || is_post_type_archive( 'listing' ) ) {
		remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
		remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_open', 5 );
		remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
		remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_close', 15 );
	}
}

// Add Default Image for Listings.
add_filter( 'genesis_get_image', 'agentpress_default_image', 10, 2 );
function agentpress_default_image( $output, $args ) {
	global $post;

	if ( 'listing' == get_post_type() && ! $output && $args['size'] == 'properties' && $args['format'] == 'html' ) {

		$output = sprintf( '<img class="attachment-properties" src="%s" alt="%s" />', get_stylesheet_directory_uri() .'/images/default-listing.png', get_the_title( $post->ID ) );

	}
	return $output;
}

// Add support for 3-column footer widgets.
add_theme_support( 'genesis-footer-widgets', 3 );

// Add support for after entry widget.
add_theme_support( 'genesis-after-entry-widget-area' );

// Relocate after entry widget.
remove_action( 'genesis_after_entry', 'genesis_after_entry_widget_area' );
add_action( 'genesis_after_entry', 'genesis_after_entry_widget_area', 5 );

// Register widget areas.
genesis_register_sidebar( array(
	'id'          => 'home-featured',
	'name'        => __( 'Home - Featured', 'agentpress' ),
	'description' => __( 'This is the featured section at the top of the homepage.', 'agentpress' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-top',
	'name'        => __( 'Home - Top', 'agentpress' ),
	'description' => __( 'This is the top section of the content area on the homepage.', 'agentpress' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-middle-1',
	'name'        => __( 'Home - Middle 1', 'agentpress' ),
	'description' => __( 'This is first widget-area in the middle section of the content area on the homepage.', 'agentpress' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-middle-2',
	'name'        => __( 'Home - Middle 2', 'agentpress' ),
	'description' => __( 'This is second widget-area in the middle section of the content area on the homepage.', 'agentpress' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-middle-3',
	'name'        => __( 'Home - Middle 3', 'agentpress' ),
	'description' => __( 'This is third widget-area in the middle section of the content area on the homepage.', 'agentpress' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-bottom',
	'name'        => __( 'Home - Bottom', 'agentpress' ),
	'description' => __( 'This is the bottom section of the content area on the homepage.', 'agentpress' ),
) );
genesis_register_sidebar( array(
	'id'          => 'listings-archive',
	'name'        => __( 'Listings Archive', 'agentpress' ),
	'description' => __( 'This is the widget-area at the top of the listings archive.', 'agentpress' ),
) );
genesis_register_sidebar( array(
	'id'          => 'disclaimer',
	'name'        => __( 'Disclaimer', 'agentpress' ),
	'description' => __( 'This is the disclaimer section of the footer.', 'agentpress' ),
) );

// add_filter( 'gform_post_data', 'replace_tags_with_custom_taxonomy', 10, 2 );
function replace_tags_with_custom_taxonomy( $post_data, $form ) {
   
    //only change post type on form id 5
    if ( $form['id'] != 1 ) {
       return $post_data;
    }
   
    //------------------------------------------------------------------------------------
    // Replace my_taxonomy with your custom taxonomy name as defined in your register_taxonomy() function call
    $custom_taxonomy = 'newsletter_categories';
    //------------------------------------------------------------------------------------
    // Getting tags
    $tags = implode( ',', $post_data['tags_input'] );
    // Array of taxonomy terms keyed by their taxonomy name.
    $post_data['tax_input'] = array( $custom_taxonomy => $tags );
    // Set default tags to empty.
    $post_data['tags_input'] = null;
    // Return modified post data with the custom taxonomy terms added.
    return $post_data;
}

// add a link to the WP Toolbar
function custom_toolbar_link($wp_admin_bar) {
    $args = array(
        'id' => 'tfsdraft',
        'title' => 'Drafts', 
        'href' => 'edit.php?post_status=draft&post_type=newsletter', 
        'meta' => array(
            'class' => 'wpbeginner', 
            'title' => 'Admin drafts of newsletters'
            )
    );
    $wp_admin_bar->add_node($args);
}
add_action('admin_bar_menu', 'custom_toolbar_link', 999);

function custom_search_button_text( $text ) {
	return ( 'Search...');
	}
	add_filter( 'genesis_search_text', 'custom_search_button_text' );
// Enable the option show in rest
add_filter( 'acf/rest_api/field_settings/show_in_rest', '__return_true' );

// Enable the option edit in rest
add_filter( 'acf/rest_api/field_settings/edit_in_rest', '__return_true' );

// Send an email when a submitted newsletter is published
function send_emails_on_new_event(  $new_status, $old_status, $post ) {

	
	$tfs_email = get_field('email_adres',$post->ID);
	$tfs_title = get_the_title( $post->ID );
	$tfs_link = get_permalink($post->ID);
    $headers = 'From: Frank Meeuwsen <frank@thanksforsubscribing.app>';
    // $title   = wp_strip_all_tags( get_the_title( $post->ID ) );
    $message = 'Hi!

I added your newsletter "'. $tfs_title . '" to the website Thanks for Subscribing at '. $tfs_link.'

If you\'d like to have anything changed, feel free to reply to this mail. If you want another header or avatar, no problem, just send me new images. The avatar is 100 x 100 px and the header is 600 x 400 px. 

Have a fine day and good luck with your newsletter,

Frank Meeuwsen

Thanks for Subscribing
';

    if ( ( 'publish' === $new_status && 'publish' !== $old_status ) && 'newsletter' === $post->post_type) {
        wp_mail( $tfs_email, 'Your newsletter is added to Thanks for Subscribing', $message, $headers );
    }
};

function send_integromat_webhook($post){


		// global $post;
		// $tfs_id = get_the_ID( $post->ID );
		// BugFu::log($post->ID);
		$response = wp_remote_post( 'https://hook.integromat.com/nzfo0mdwgiercpnmlq89gbovfz5ce442', array(
			'method'      => 'POST',
			'timeout'     => 45,
			'redirection' => 5,
			'httpversion' => '1.0',
			'blocking'    => true,
			'headers'     => array(),
			'body'        => array(
				'id' => $post->ID
		
			),
			'cookies'     => array()
			)
		);
};
if ( 'production' == wp_get_environment_type() ) {
	add_action( 'transition_post_status', 'send_emails_on_new_event', 10, 3 );
	add_action( 'draft_to_publish', 'send_integromat_webhook', 10,1);
}

add_action('init','random_add_rewrite');
function random_add_rewrite() {
   global $wp;
   $wp->add_query_var('really-random');
   add_rewrite_rule('really-random', 'index.php?really-random=1', 'top');
}

add_action('template_redirect','random_template');
function random_template() {
   if (get_query_var('really-random') == 1) {
           $posts = get_posts('post_type=newsletter&orderby=rand');
           foreach($posts as $post) {
                   $link = get_permalink($post);
           }
           wp_redirect($link,307);
           exit;
   }
}

add_filter( 'nav_menu_link_attributes', function ( $atts, $item, $args ) {
    if ( 'tfs-highlight-button' === $item->classes[0] ) {
        $atts['data-track-content']='1' ;
		$atts['data-content-name']='Random click';
		$atts['data-content-piece']='Random newsletter';
		$atts['class'] .= 'matomoTrackContent';
    }

    return $atts;
}, 10, 3 );

add_filter('walker_nav_menu_start_el', function($item_output, $item) {
  if (in_array('tfs-highlight-button', $item->classes)) {
    $item_output = str_replace('data-track-content="1"', 'data-track-content', $item_output);
  }

  return $item_output;
}, 10, 2);

//  Gravity Forms fix. After upload, move image to library
add_action( 'gform_after_submission', 'tfs_gf_after_submission', 10, 2 );

function tfs_gf_after_submission($entry, $form){
	    //getting post
    $parent_post_id = get_post( $entry['post_id'] )->ID;
	
	$form_fileurl = $entry[15];
			// Check the type of file. We'll use this as the 'post_mime_type'.
			$filetype = wp_check_filetype(basename($form_fileurl), null);

			// Get the path to the upload directory.
			$wp_upload_dir = wp_upload_dir();

			//Gravity forms often uses its own upload folder, so we're going to grab whatever location that is
			$parts = explode('uploads/', $form_fileurl);
			$filepath = $wp_upload_dir['basedir'].
			'/'.$parts[1];
			$fileurl = $wp_upload_dir['baseurl'].
			'/'.$parts[1];


			// Prepare an array of post data for the attachment.
			$attachment = array(
				'guid' => $fileurl,
				'post_mime_type' => $filetype['type'],
				'post_title' => preg_replace('/\.[^.]+$/', '', basename($fileurl)),
				'post_content' => '',
				'post_status' => 'inherit'
			);


			// Insert the attachment.
			$attach_id = wp_insert_attachment($attachment, $filepath, $parent_post_id);

			//Image manipulations are usually an admin side function. Since Gravity Forms is a front of house solution, we need to include the image manipulations here.
			require_once(ABSPATH.'wp-admin/includes/image.php');

			// Generate the metadata for the attachment, and update the database record.
			if ($attach_data = wp_generate_attachment_metadata($attach_id, $filepath)) {
				wp_update_attachment_metadata($attach_id, $attach_data);
			} else {
				echo ' <
					div id = "message"
				class = "error" >
					<
					h1 > Failed to create Meta - Data < /h1> <
					/div>
				';
			}

	
			wp_update_attachment_metadata($attach_id, $attach_data);
			update_field('logo_lokaal', $attach_id, $parent_post_id);
			// do_action( 'qm/debug', $parent_post_id );
			// error_log(var_export($parent_post_id,1));
			// error_log(var_export($parts ,1));
			// error_log(var_export($form_fileurl ,1));
			// error_log(var_export($attachment ,1));
			// error_log(var_export($attach_id ,1));
			// error_log(var_export($attach_data ,1));


}