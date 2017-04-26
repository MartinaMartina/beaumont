<?php
/**
 * Social Profile
 *
 * @package Editorial
 *
 * @since 1.0
 */

if ( !class_exists( 'Editorial_Widget_Social' ) ) :

add_action( 'widgets_init', function() {

    register_widget( 'Editorial_Widget_Social' );

} );

class Editorial_Widget_Social extends Editorial_Widget {
	
    // initialize the widget
	function __construct() {
		$widget_ops = array(
            'classname' => 'widget_social', 
            'description' => esc_html__( 'Displays social profile','editorial' )
        );
		$control_ops = array('width' => 250, 'height' => 350);
		parent::__construct( 'editorial-social', esc_html__( '(Editorial) Social' , 'editorial' ), $widget_ops, $control_ops );
	}
    
    // register fields
    // Editorial_Widget class does the rest
    function fields() {
        include get_template_directory() . '/widgets/social/fields.php';
        return $fields;
    }
	
    // render it to frontend
	function widget( $args, $instance) {
        
        include get_template_directory() . '/widgets/social/widget.php';
        
	}
	
}

endif;