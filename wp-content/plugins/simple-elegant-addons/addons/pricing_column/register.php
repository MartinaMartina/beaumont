<?php
/**
 * Pricing Column Addon for Visual Composer
 *
 * @since 2.0
 */
if ( ! class_exists( 'Withemes_Pricing_Column' ) ) :

class Withemes_Pricing_Column extends Withemes_Shortcode
{
    
    public function __construct() {
        
        $this->path = SIMPLE_ELEGANT_ADDONS_PATH . 'addons/pricing_column/';
        $this->args = array(
            'base'      => 'pricing_column',
            'name'      => esc_html__( 'Pricing Column', 'simple-elegant' ),
            'desc'      => esc_html__( 'Displays Pricing Column', 'simple-elegant' ),
            'weight'    => 190,
        );
        
    }
    
    function param_list() {
    
        return 'title, price, price_unit, per, text, icon_set, icon, icon_budicon, link, style, size, align, width, shape, onclick, padding_left, padding_top, border_radius, font_size, font_weight, text_transform, letter_spacing, border_width, color, background, border_color, hover_color, hover_background, hover_border';
        
    }
    
}

$instance = new Withemes_Pricing_Column();
$instance->init();

endif;