<?php
/**
 * Latest Projects
 *
 * @package Simple & Elegant
 * @since 1.0
 * @rewritten in 2.0
 */

if ( !class_exists( 'Withemes_Widget_Latest_Projects' ) && class_exists( 'Withemes_Widget' ) ) :

add_action( 'widgets_init', function() {

    register_widget( 'Withemes_Widget_Latest_Projects' );

} );

class Withemes_Widget_Latest_Projects extends Withemes_Widget {
	
    // initialize the widget
	function __construct() {
		$widget_ops = array(
            'classname' => 'widget_latest_projects', 
            'description' => esc_html__( 'Display latest projects','simple-elegant' )
        );
		$control_ops = array('width' => 250, 'height' => 350);
		parent::__construct( 'latest-projects', esc_html__( '(S&E) Latest Projects' , 'simple-elegant' ), $widget_ops, $control_ops );
	}
    
    // register fields
    // Withemes_Widget class does the rest
    function fields() {
        
        include SIMPLE_ELEGANT_PORTFOLIO_PATH . 'widgets/latest-projects/fields.php';
        
        return $fields;
    }
	
    // render it to frontend
	function widget( $args, $instance) {
        
        include SIMPLE_ELEGANT_PORTFOLIO_PATH . 'widgets/latest-projects/widget.php';
        
	}
	
}

endif;