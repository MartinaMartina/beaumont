<?php
/**
 * Post Grid for Visual Composer
 *
 * @since 2.0
 */
if ( ! class_exists( 'Withemes_Post_Grid' ) ) :

class Withemes_Post_Grid extends Withemes_Shortcode
{
    
    public function __construct() {
        
        $this->path = SIMPLE_ELEGANT_ADDONS_PATH . 'addons/post_grid/';
        $this->args = array(
            'base'      => 'post_grid',
            'name'      => esc_html__( 'Post Grid', 'simple-elegant' ),
            'desc'      => esc_html__( 'Displays post grid', 'simple-elegant' ),
            'weight'    => 190,
        );
        
    }
    
    function param_list() {
        
        return 'number, column';
        
    }
    
}

$instance = new Withemes_Post_Grid();
$instance->init();

endif;