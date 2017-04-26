<?php
/**
 * Iconbox Addon for Visual Composer
 *
 * @since 1.0
 * @modified 2.0
 */
if ( ! class_exists( 'Withemes_Iconbox' ) ) :

class Withemes_Iconbox extends Withemes_Shortcode
{
    
    public function __construct() {
        
        $this->path = SIMPLE_ELEGANT_ADDONS_PATH . 'addons/iconbox/';
        $this->args = array(
            'base'      => 'iconbox',
            'name'      => esc_html__( 'Iconbox', 'simple-elegant' ),
            'desc'      => esc_html__( 'Displays Iconbox', 'simple-elegant' ),
            'weight'    => 190,
            'icon'      => 'withemes-vc-icon bi_medicine-lab',
        );
        
    }
    
    function param_list() {
        
        return 'layout, icon_type, icon, icon_budicon, image, icon_link, title, title_tag, animation, delay, el_class, icon_size, icon_font_size, icon_normal_color, icon_normal_background, icon_color, icon_background, title_color, title_font_size, title_text_transform, title_letter_spacing, title_font_weight, title_font_style, content_font_size, content_color';
        
    }
    
}

$instance = new Withemes_Iconbox();
$instance->init();

endif;