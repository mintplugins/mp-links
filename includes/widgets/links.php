<?php
/**
 * Extends MP_CORE_Widget to create custom widget class.
 */
class MP_LINKS_Widget extends MP_CORE_Widget {

	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		parent::__construct(
	 		'mp_links_widget', // Base ID
			'MP Links', // Name
			array( 'description' => __( 'Display links', 'mp_links' ), ) // Args
		);
		
		//enqueue scripts defined in MP_CORE_Widget
		add_action( 'admin_enqueue_scripts', array( $this, 'mp_widget_enqueue_scripts' ) );
		
		$this->_form = array (
			"field1" => array(
				'field_id' 			=> 'title',
				'field_title' 	=> __('Title:', 'mp_links'),
				'field_description' 	=> NULL,
				'field_type' 	=> 'textbox',
			),
			"field2" => array(
				'field_id' 			=> 'link_cat',
				'field_title' 	=> __('Select the link group:', 'mp_links'),
				'field_description' 	=> NULL,
				'field_type' 	=> 'select',
				'field_select_values' => mp_core_get_all_terms_by_tax('mp_link_groups'),
			),
		);
	
	}
	
	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters( 'mp_links_widget_title', isset($instance['title']) ? $instance['title'] : '' );
				
		/**
		 * Widget Start and Title
		 */
		echo $before_widget;
		if ( ! empty( $title ) )
			echo $before_title . $title . $after_title;
			
		/**
		 * Links Before Hook
		 */
		 do_action('mp_links_before_widget');
			
		/**
		 * Widget Body
		 */
						
		//Show list of links
		echo mp_links($instance['link_cat']);
				
		/**
		 * Links After Hook
		 */
		 do_action('mp_links_after_widget');
		
		/**
		 * Widget End
		 */
		echo $after_widget;
		
	}
}

add_action( 'register_sidebar', create_function( '', 'register_widget( "MP_LINKS_Widget" );' ) );

/**
 * Remove the default link widget that comes with wordpress
 */
function mp_links_remove_default_links_widget(){ 
	unregister_widget('WP_Widget_Links');
}
add_action( 'register_sidebar', 'mp_links_remove_default_links_widget' );