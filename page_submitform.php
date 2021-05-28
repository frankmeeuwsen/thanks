<?php
/**
 * AgentPress Pro.
 *
 * This file adds the newsletter subscription page template to the AgentPress Pro Theme.
 *
 * Template Name: Submit form
 *
 * @package AgentPress
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/agencypress/
 */

function tfs_do_acf_form_head() {
	acf_form_head();
}
function tfs_submit_loop(){

	$fields = array(
					'field_60ae9bf638e4b', //title
					'field_60ae9c0e38e4c', //content
					'field_60ae181c64849' //category
					// 'field_5ff612dbad80d',	// subscribe
					// 'field_5ff6130aad80e',	// example
					// 'field_5ff61e9c9c7ce',	// Twitter
					// 'field_5ff61eb398311'	// email
				);
				acf_register_form(array(
					'id' => 'new_newsletter', 
					'post_id' => 'new_post', 
					'new_post' => array(
						'post_type' => 'newsletter', 
						'post_status' => 'draft'), 
					// 'post_title' => true, 
					// 'post_content' => true, 
						// 'uploader' => 'basic', 
						// 'return' => home_url('thank-your-for-submitting-your-recipe'), 
						'fields' => $fields, 
						// 'field_groups' => array('group_5ff612d182095'),
						'updated_message' => 'Thanks',
						'submit_value' => 'Submit a new newsletter'),
					);
	
		acf_form('new_newsletter');
}


function tsm_do_pre_save_post( $post_id ) {

	print_r($_POST);
	// check if this is to be a new post
	// if( $post_id != 'new_post' ) {
	// 	return $post_id;
	// }
	// Create a new post
	$post = array(
		'post_type'     => 'newsletter', // Your post type ( post, page, custom post type )
		'post_status'   => 'draft', // (publish, draft, private, etc.)
		'post_title'    => wp_strip_all_tags($_POST['acf']['field_60ae9bf638e4b']), // Post Title ACF field key
		'post_content'  => $_POST['acf']['field_60ae9c0e38e4c'], // Post Content ACF field key
	);

	// insert the post
	$post_id = wp_insert_post( $post );

	// ACF image field key
	// $image = $_POST['acf']['field_5815bedd2197e'];

	// Bail if image field is empty
	// if ( empty($image) ) {
	// 	return;
	// }

	// Add the value which is the image ID to the _thumbnail_id meta data for the current post
	// add_post_meta( $post_id, '_thumbnail_id', $image );

	return $post_id;

}


do_action('acf/save_post' , 'tsm_do_pre_save_post');
add_action( 'get_header', 'tfs_do_acf_form_head', 1 );

// remove_action( 'genesis_loop', 'genesis_do_loop' );
add_action( 'genesis_entry_content', 'tfs_submit_loop' );

genesis();
