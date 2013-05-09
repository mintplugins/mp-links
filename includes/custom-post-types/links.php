<?php
/**
 * Custom Post Types
 *
 * @package mp_links
 * @since mp_links 1.0
 */

/**
 * Sermon Custom Post Type
 */
function mp_links_post_type() {
	
		$sermon_labels =  apply_filters( 'mp_links_labels', array(
			'name' 				=> 'Links',
			'singular_name' 	=> 'Link',
			'add_new' 			=> __('Add New', 'mp_links'),
			'add_new_item' 		=> __('Add New Link', 'mp_links'),
			'edit_item' 		=> __('Edit Link', 'mp_links'),
			'new_item' 			=> __('New Link', 'mp_links'),
			'all_items' 		=> __('All Links', 'mp_links'),
			'view_item' 		=> NULL,
			'search_items' 		=> __('Search Links', 'mp_links'),
			'not_found' 		=>  __('No Links found', 'mp_links'),
			'not_found_in_trash'=> __('No Links found in Trash', 'mp_links'), 
			'parent_item_colon' => '',
			'menu_name' 		=> __('Links', 'mp_links')
		) );
		
			
		$sermon_args = array(
			'labels' 			=> $sermon_labels,
			'public' 			=> true,
			'publicly_queryable'=> false,
			'show_ui' 			=> true, 
			'show_in_nav_menus' => false,
			'show_in_menu' 		=> true, 
			'menu_position'		=> 5,
			'query_var' 		=> true,
			'rewrite' 			=> array( 'slug' => 'links' ),
			'capability_type' 	=> 'post',
			'has_archive' 		=> false, 
			'hierarchical' 		=> false,
			'supports' 			=> apply_filters('mp_links_people_supports', array( 'title' ) ),
		); 
		register_post_type( 'mp_link', apply_filters( 'mp_links_people_post_type_args', $sermon_args ) );
}
add_action( 'init', 'mp_links_post_type', 0 );

/**
 * Change default title
 */
function mp_links_change_default_title( $title ){
     $screen = get_current_screen();
 
     if  ( 'mp_links' == $screen->post_type ) {
          $title = __('Enter the name of the Link', 'mp_links');
     }
 
     return $title;
}
add_filter( 'enter_title_here', 'mp_links_change_default_title' );

/**
 * Disable permalink display
 */
function mp_links_hide_permlink($return, $id, $new_title, $new_slug){
	global $post;
	if (isset($post->post_type)){
		if($post->post_type == 'mp_link'){
			return NULL;
		}
	}
	return $return;
}
add_filter('get_sample_permalink_html', 'mp_links_hide_permlink', '',4);

/**
 * Disable built-in wordpress links
 */
function mp_links_remove_wp_links() {
	remove_menu_page('link-manager.php');
}
add_action( 'admin_menu', 'mp_links_remove_wp_links' );

/**
 * Link Groups Taxonomy
 */
function mp_links_groups_taxonomy() {  
		
		// Add new taxonomy, make it hierarchical (like categories)
		$labels = array(
			'name'                => __( 'Link Groups', 'mp_links' ),
			'singular_name'       => __( 'Link Group', 'mp_links' ),
			'search_items'        => __( 'Search Link Groups', 'mp_links' ),
			'all_items'           => __( 'All Link Groups', 'mp_links' ),
			'parent_item'         => __( 'Parent Link Group', 'mp_links' ),
			'parent_item_colon'   => __( 'Parent Link Group:', 'mp_links' ),
			'edit_item'           => __( 'Edit Link Group', 'mp_links' ), 
			'update_item'         => __( 'Update Link Group', 'mp_links' ),
			'add_new_item'        => __( 'Add New Link Group', 'mp_links' ),
			'new_item_name'       => __( 'New Link Group Name', 'mp_links' ),
			'menu_name'           => __( 'Link Groups', 'mp_links' ),
		); 	
  
		register_taxonomy(  
			'mp_link_groups',  
			'mp_link',  
			array(  
				'hierarchical' => true,  
				'label' => 'Link Groups',  
				'labels' => $labels,  
				'query_var' => true,  
				'with_front' => false, 
				'rewrite' => array('slug' => 'link_groups')  
			)  
		);  
}  
add_action( 'init', 'mp_links_groups_taxonomy', 10 ); 
