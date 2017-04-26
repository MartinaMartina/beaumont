<?php
/**
 * Portfolio Addon for Visual Composer
 *
 * @since 1.0
 * @rewritten in 2.0
 */
if ( ! class_exists( 'Withemes_Portfolio_Shortcode' ) ) :

class Withemes_Portfolio_Shortcode extends Withemes_Shortcode
{
    
    public function __construct() {
        
        $this->path = SIMPLE_ELEGANT_PORTFOLIO_PATH . 'addons/portfolio/';
        $this->args = array(
            'base'      => 'portfolio',
            'name'      => esc_html__( 'Portfolio', 'simple-elegant' ),
            'desc'      => esc_html__( 'Displays Recent Projects', 'simple-elegant' ),
            'weight'    => 190,
        );
        
    }
    
    function param_list() {
    
        return 'number, column, style, ratio, pagination, catlist';
        
    }
    
}

$instance = new Withemes_Portfolio_Shortcode();
$instance->init();

endif;