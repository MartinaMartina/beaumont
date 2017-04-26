<?php
/**
 * Image Widget
 *
 * @package Simple & Elegant
 * @since 2.0
 */

if ( !class_exists( 'Withemes_Widget_Image' ) ) :

add_action( 'widgets_init', function() {

    register_widget( 'Withemes_Widget_Image' );

} );

class Withemes_Widget_Image extends Withemes_Widget {
	
    // initialize the widget
	function __construct() {
		$widget_ops = array(
            'classname' => 'widget_image', 
            'description' => esc_html__( 'Can use to display banner or about profile.','simple-elegant' )
        );
		$control_ops = array('width' => 250, 'height' => 350);
		parent::__construct( 'withemes-image', esc_html__( '(S&E) Image' , 'simple-elegant' ), $widget_ops, $control_ops );
	}
    
    // register fields
    // Withemes_Widget class does the rest
    function fields() {
        
        include get_template_directory() . '/widgets/image/fields.php';
        
        return $fields;
    }
	
    // render it to frontend
	function widget( $args, $instance) {
        
        include get_template_directory() . '/widgets/image/widget.php';
        
	}
	
}

endif;