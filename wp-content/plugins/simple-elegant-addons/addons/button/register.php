<?php
/**
 * Button Addon for Visual Composer
 *
 * @since 2.0
 */
if ( ! class_exists( 'Withemes_Button' ) ) :

class Withemes_Button extends Withemes_Shortcode
{
    
    public function __construct() {
        
        $this->path = SIMPLE_ELEGANT_ADDONS_PATH . 'addons/button/';
        $this->args = array(
            'base'      => 'button',
            'name'      => esc_html__( 'Button', 'simple-elegant' ),
            'desc'      => esc_html__( 'Displays Button', 'simple-elegant' ),
            'weight'    => 190,
            'icon'      => 'withemes-vc-icon bi_interface-box-plus',
        );
        
        add_filter ( 'withemes_element_class', array( $this, 'button_class' ), 10, 3 );
        
    }
    
    function param_list() {
    
        return 'text, icon_set, icon, icon_budicon, link, style, size, width, shape, align, onclick, padding_left, padding_top, border_radius, font_size, font_weight, text_transform, letter_spacing, border_width, color, background, border_color, hover_color, hover_background, hover_border';
        
    }
    
    /**
     * Customize the class for button element
     *
     * @since 2.0
     */
    function button_class( $element_class, $base, $atts ) {
        
        if ( 'button' == $base ) {
            $outer_class = array( 'wi-button' );

            $align = isset( $atts[ 'align' ] ) ? $atts[ 'align' ] : 'inline';
            $width = isset( $atts[ 'width' ] ) ? $atts[ 'width' ] : 'auto';

            // align
            if ( 'full' == $width || 'half' == $width || 'third' == $width ) {
                
                $outer_class[] = 'button-' . $width;
                $outer_class[] = 'button-block';
                
            } elseif ( 'center' == $align || 'left' == $align || 'right' == $align ) {
                
                $outer_class[] = 'button-' . $align;
                
            }
            
            if ( ! in_array( 'button-block', $outer_class ) ) {
                $outer_class[] = 'button-inline';
            }

            return $outer_class;
        }
        
        return $element_class;
    
    }
    
    /**
     * Extra atts
     */
    function extra_atts( $atts ) {
        return array(
            'url' => isset( $atts[ 'url' ] ) ? $atts[ 'url' ] : '',
            'target' => isset( $atts[ 'target' ] ) ? $atts[ 'target' ] : '',
        );
    }
    
}

$instance = new Withemes_Button();
$instance->init();

endif;