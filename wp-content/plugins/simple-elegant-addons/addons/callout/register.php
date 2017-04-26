<?php
/**
 * Callout Addon for Visual Composer
 *
 * @since 2.0
 */
if ( ! class_exists( 'Withemes_Callout' ) ) :

class Withemes_Callout extends Withemes_Shortcode
{
    
    public function __construct() {
        
        $this->path = SIMPLE_ELEGANT_ADDONS_PATH . 'addons/callout/';
        $this->args = array (
            'base'      => 'callout',
            'name'      => esc_html__( 'Callout', 'simple-elegant' ),
            'desc'      => esc_html__( 'Displays CTA', 'simple-elegant' ),
            'weight'    => 190,
        );
        
    }
    
    public function param_list() {
        
        return 'title, title_font_size, title_font_weight, title_text_transform, title_letter_spacing, text, icon_set, icon, icon_budicon, link, style, size, align, width, shape, onclick, padding_left, padding_top, border_radius, font_size, font_weight, text_transform, letter_spacing, border_width, color, background, border_color, hover_color, hover_background, hover_border, css';

    }
    
}

$instance = new Withemes_Callout();
$instance->init();

endif;