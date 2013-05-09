<?php
/**
 * Function which creates new Meta Box
 *
 */
function mp_links_create_meta_box(){	
	/**
	 * Array which stores all info about the new metabox
	 *
	 */
	$mp_links_add_meta_box = array(
		'metabox_id' => 'mp_links_metabox', 
		'metabox_title' => __( 'Link Icon', 'mp_sermons'), 
		'metabox_posttype' => 'mp_link', 
		'metabox_context' => 'advanced', 
		'metabox_priority' => 'low' 
	);
	
	/**
	 * Custom filter to allow for themes to change the description of the sermon thumbnail. This allows for custom size description. IE: 200px by 100px
	 */
	$default_links_array = array('mp-links-facebook' => 'Facebook', 'mp-links-twitter' => 'Twitter', 'mp-links-tumblr' => 'Tumblr', 'mp-links-youtube' => 'YouTube', 'mp-links-vimeo' => 'Vimeo', 'mp-links-myspace' => 'MySpace', 'mp-links-linkedin' => 'Linked-In', 'mp-links-dribbble' => 'Dribbble', 'mp-links-pinterest' => 'Pinterest', 'mp-links-email' => 'Email', 'mp-links-rss' => 'RSS');
	 
	$mp_links_array = has_filter('mp_links_array') ? apply_filters( 'mp_links_array', $default_links_array) : $default_links_array;
		
	/**
	 * Array which stores all info about the options within the metabox
	 *
	 */
	$mp_links_items_array = array(
		array(
			'field_id'			=> 'link_url',
			'field_title' 	=> __( 'Link URL', 'mp_core'),
			'field_description' 	=> 'Enter the URL for this link:',
			'field_type' 	=> 'url',
			'field_value' => ''
		),
		array(
			'field_id'			=> 'link_type',
			'field_title' 	=> __( 'Link Type', 'mp_core'),
			'field_description' 	=> 'Select the type of link this is:',
			'field_type' 	=> 'select',
			'field_value' => '',
			'field_select_values' => $mp_links_array
		),
		array(
			'field_id'			=> 'link_target',
			'field_title' 	=> __( 'Link Open Type', 'mp_core'),
			'field_description' 	=> 'Select the way this link will open:',
			'field_type' 	=> 'select',
			'field_value' => '',
			'field_select_values' => array( '_self' => 'In the current window', '_blank' => 'In a new window/tab' )
		),
	);
	
	/**
	 * Custom filter to allow for add-on plugins to hook in their own data for add_meta_box array
	 */
	$mp_links_add_meta_box = has_filter('mp_links_meta_box_array') ? apply_filters( 'mp_links_meta_box_array', $mp_links_add_meta_box) : $mp_links_add_meta_box;
	
	/**
	 * Custom filter to allow for add on plugins to hook in their own extra fields 
	 */
	$mp_links_items_array = has_filter('mp_links_items_array') ? apply_filters( 'mp_links_items_array', $mp_links_items_array) : $mp_links_items_array;
	
	
	/**
	 * Create Metabox class
	 */
	global $mp_links_meta_box;
	$mp_links_meta_box = new MP_CORE_Metabox($mp_links_add_meta_box, $mp_links_items_array);
}
add_action('load_textdomain', 'mp_links_create_meta_box');