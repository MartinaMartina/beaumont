<?php
/**
 * Simple Slider Addon for Visual Composer
 *
 * @since 2.0
 */
if ( ! class_exists( 'Withemes_Slider' ) ) :

class Withemes_Slider extends Withemes_Shortcode
{
    
    public function __construct() {
        
        $this->path = SIMPLE_ELEGANT_ADDONS_PATH . 'addons/slider/';
        $this->args = array(
            'base'      => 'slider',
            'name'      => esc_html__( 'Slider', 'simple-elegant' ),
            'desc'      => esc_html__( 'Image Slider', 'simple-elegant' ),
            'weight'    => 190,
        );
        
    }
    
    public function param_list() {
        return 'images, thumb, controls';
    }
    
}

$instance = new Withemes_Slider();
$instance->init();

endif;