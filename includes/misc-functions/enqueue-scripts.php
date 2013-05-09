<?php

/**
 * Enqueue font face for links
 */
 function mp_links_enqueue_scripts(){
	 
	 //Filter or set default skin for links 
	$mp_links_font_location = has_filter('mp_links_font_style_location') ? apply_filters( 'mp_links_font_style_location', $first_output) : plugins_url('/css/mp-links-icon-font.css', dirname(__FILE__));
	
	//Icon font for links
	if ( !empty( $mp_links_font_location ) ) {
		wp_enqueue_style('mp_links_social_icons', $mp_links_font_location);
	}
	
 }
 add_action( 'wp_enqueue_scripts', 'mp_links_enqueue_scripts' );