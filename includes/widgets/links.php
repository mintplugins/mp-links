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
			'Links Widget', // Name
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
				'field_select_values' => mp_core_get_all_posts_by_tax('mp_link_groups'),
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
		//echo $instance['link_cat'];
		
		//Set the args for the new query
		$link_args = array(
			'post_type' => "mp_link",
			'posts_per_page' => 0,
			'tax_query' => array(
				'relation' => 'AND',
				array(
					'taxonomy' => 'mp_link_groups',
					'field'    => 'id',
					'terms'    => array( $instance['link_cat'] ),
					'operator' => 'IN'
				)
			)
		);	
		
		//Filter for the icon font css location. Check if it's emtpy or not and display the Title of the post, or not, accordingly.
		$icon_font = has_filter('mp_links_font_style_location') ? apply_filters( 'mp_links_font_style_location', $first_output) : 'There is an icon font being used';
	
		//Create new query for stacks
		$link_group = new WP_Query( apply_filters( 'mp_links_link_args', $link_args ) );
			
		//Loop through the stack group		
		if ( $link_group->have_posts() ) : 
			echo '<ul class="mp-links">';
			while( $link_group->have_posts() ) : $link_group->the_post(); 
			
				//If there isn't an icon font, show the title
				if ( empty( $icon_font ) ){
					echo '<li class="' . get_post_meta(get_the_id(), 'link_type', true)  . '-li"><a target="' . get_post_meta(get_the_id(), 'link_target', true) . '" class="' . get_post_meta(get_the_id(), 'link_type', true) . '" href="' . get_post_meta(get_the_id(), 'link_url', true) . '">' . get_the_title() . '</a></li>';
				}
				//If there IS an icon font, don't show the title
				else{
					echo '<li class="' . get_post_meta(get_the_id(), 'link_type', true)  . '-li"><a target="' . get_post_meta(get_the_id(), 'link_target', true) . '" class="' . get_post_meta(get_the_id(), 'link_type', true) . '" href="' . get_post_meta(get_the_id(), 'link_url', true) . '">' . '</a></li>';	
				}
			endwhile;
			echo '</ul>';
		endif;
		
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