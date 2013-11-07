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
		'metabox_title' => __( 'Link Icon', 'mp_links'), 
		'metabox_posttype' => 'mp_link', 
		'metabox_context' => 'advanced', 
		'metabox_priority' => 'low' 
	);
	
	/**
	 * Custom filter to allow for custom link types
	 */
	$default_links_array = array(
		'mp-links-facebook' => 'Facebook', 
		'mp-links-instagram' => 'Instagram', 
		'mp-links-twitter' => 'Twitter', 
		'mp-links-tumblr' => 'Tumblr', 
		'mp-links-youtube' => 'YouTube', 
		'mp-links-vimeo' => 'Vimeo', 
		'mp-links-soundcloud' => 'Soundcloud', 
		'mp-links-soundcloud' => 'Dropbox',
		'mp-links-googleplus' => 'Google+', 
		'mp-links-picasa' => 'Picasa', 
		'mp-links-stumbleupon' => 'Stumble Upon',
		'mp-links-spotify' => 'Spotify', 
		'mp-links-paypal' => 'Paypal', 
		'mp-links-skype' => 'Skype', 
		'mp-links-linkedin' => 'Linked-In', 
		'mp-links-dribbble' => 'Dribbble', 
		'mp-links-pinterest' => 'Pinterest', 
		'mp-links-email' => 'Email', 
		'mp-links-rss' => 'RSS',
		'mp-links-customicon' => 'Use Custom Icon'
	);
	 
	$mp_links_array = has_filter('mp_links_array') ? apply_filters( 'mp_links_array', $default_links_array) : $default_links_array;
		
	/**
	 * Array which stores all info about the options within the metabox
	 *
	 */
	$mp_links_items_array = array(
		array(
			'field_id'			=> 'link_url',
			'field_title' 	=> __( 'Link URL', 'mp_links'),
			'field_description' 	=> 'Enter the URL for this link:',
			'field_type' 	=> 'url',
			'field_value' => ''
		),
		array(
			'field_id'			=> 'link_type',
			'field_title' 	=> __( 'Link Icon', 'mp_links'),
			'field_description' 	=> 'Select the icon to use for this link:',
			'field_type' 	=> 'select',
			'field_value' => '',
			'field_select_values' => $mp_links_array
		),
		array(
			'field_id'			=> 'link_custom_icon',
			'field_title' 	=> __( 'Custom Icon', 'mp_links'),
			'field_description' 	=> 'Upload your custom icon here.',
			'field_type' 	=> 'mediaupload',
			'field_value' => '',
		),
		array(
			'field_id'			=> 'link_target',
			'field_title' 	=> __( 'Link Open Type', 'mp_links'),
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