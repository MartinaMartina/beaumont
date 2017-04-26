<?php
/**
 * Post List
 *
 * @package Simple & Elegant
 * @since 2.0
 */

if ( !class_exists( 'Withemes_Widget_Post_List' ) ) :

add_action( 'widgets_init', function() {

    register_widget( 'Withemes_Widget_Post_List' );

} );

class Withemes_Widget_Post_List extends Withemes_Widget {
	
    // initialize the widget
	function __construct() {
		$widget_ops = array(
            'classname' => 'widget_post_list', 
            'description' => esc_html__( 'Displays Post List','simple-elegant' )
        );
		$control_ops = array('width' => 250, 'height' => 350);
		parent::__construct( 'withemes-post-list', esc_html__( '(S&E) Post List' , 'simple-elegant' ), $widget_ops, $control_ops );
	}
    
    // register fields
    // Withemes_Widget class does the rest
    function fields() {
        
        include get_template_directory() . '/widgets/post-list/fields.php';
        
        return $fields;
    }
	
    // render it to frontend
	function widget( $args, $instance) {
        
        include get_template_directory() . '/widgets/post-list/widget.php';
        
	}
	
}

endif;