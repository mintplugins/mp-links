<?php

/**
 * Show "Insert Shortcode" above posts
 */
function mp_links_show_insert_shortcode(){
	
	$post_id = isset($_GET['post']) ? $_GET['post'] : NULL;
	
	$args = array(
		'shortcode_id' => 'mp_links',
		'shortcode_title' => __('Links', 'mp_core'),
		'shortcode_description' => __( 'Use the form below to insert the shortcode for a Link Group ', 'mp_core' ),
		'shortcode_options' => array(
			array(
				'option_id' => 'source',
				'option_title' => 'Link Groups',
				'option_description' => 'Choose a Link Group',
				'option_type' => 'select',
				'option_value' => mp_core_get_all_terms_by_tax('mp_link_groups'),
			),
		)
	); 
	
	
	//Shortcode args filter
	$args = has_filter('mp_links_insert_shortcode_args') ? apply_filters('mp_links_insert_shortcode_args', $args) : $args;
	
	new MP_CORE_Shortcode_Insert($args);	
}
add_action('init', 'mp_links_show_insert_shortcode');

/**
 * Shortcode which is used to display the HTML content on a post
 */
function mp_links_display_links( $atts ) {
	
	//shortcode vars passed-in
	$vars =  shortcode_atts( array('source' => NULL), $atts );
	
	//Post id 
	$post_id = get_the_id();
	
	//Check if this post has slider meta
	$slider_meta_check = get_post_meta( $post_id, 'mp_links', true);
				
	//Show list of links
	return mp_links($vars['source']);
	
}
add_shortcode( 'mp_links', 'mp_links_display_links' );