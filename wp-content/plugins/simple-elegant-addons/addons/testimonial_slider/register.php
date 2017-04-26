<?php
/**
 * Testimonial Slider Addon for Visual Composer
 *
 * @since 1.0
 * @modified 2.0
 */
if ( ! class_exists( 'Withemes_Testimonial_Slider' ) ) :

class Withemes_Testimonial_Slider extends Withemes_Shortcode
{
    
    public function __construct() {
        
        $this->path = SIMPLE_ELEGANT_ADDONS_PATH . 'addons/testimonial_slider/';
        $this->args = array(
            'base'      => 'testimonial_slider',
            'name'      => esc_html__( 'Testimonial Slider', 'simple-elegant' ),
            'desc'      => esc_html__( 'Displays testimonial slider', 'simple-elegant' ),
            'weight'    => 190,
        );
        
    }
    
    function param_list() {
        
        return 'auto, pager, align, testimonials';
        
    }
    
}

$instance = new Withemes_Testimonial_Slider();
$instance->init();

endif;

/* Testimonial
-------------------------------------------------------------------------------------- */
if (!function_exists('withemes_shortcode_testimonial')){
function withemes_shortcode_testimonial( $atts, $content = null ) {
    extract( shortcode_atts( array(
        'image' => '',
        'name' => '',
        'from' => '',
        'rating' => '',
        'align' => '',
    ), $atts ) );
    $content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content
    
    $return = $meta = $rating_html = $footer = '';
    
    $rating = floatval($rating);
    if ($rating > 5 || $rating <= 0) $rating = false;
    
    // rating
    if ( $rating ) {
        $rating_html = '<div class="rating" title="' . sprintf (__('Rated %d out of 5','simple-elegant'), $rating ) . '">';
        $rating_html .= '<span style="width:' . ($rating *20) . '%">' . sprintf( __('<strong class="">%d</strong> out of 5', 'simple-elegant'), $rating ) . '</span>';
        $rating_html .= '</div>';
    }
    
    // meta
    if ( $name || $rating_html ) {
        $meta = '<div class="testimonial-meta">';
        $meta .= '<h5 class="testimonial-name">' . $name . '</h5>';
        if ( $from ) {
            $meta .= '<div class="testimonial-from">' . esc_html ($from) . '</div>';
        }
        $meta .= '</div>';
    }
    
    $testimonial_img = '';
    if ( $image ) {
        $img = wp_get_attachment_image($image,'thumbnail');
        if ($img) {
            $testimonial_img = '<figure class="testimonial-avatar">' . $img . '</figure>';
        }
    }
    
    if ( $meta || $rating_html || ( 'left' == $align && $testimonial_img ) ) {
        if ( 'left' == $align ) $footer .= $testimonial_img;
        $footer .= '<div class="testimonial-footer-text">' . $rating_html . $meta . '</div>';
    }
    
    if ( $footer ) {
        $footer = '<div class="testimonial-footer">' . $footer . '</div>';
    }
    
    $return = '<li><div class="wi-testimonial align-' . esc_attr( $align ) . '">' . ( 'center' == $align ? $testimonial_img : '' ) . '<div class="testimonial-content">' . do_shortcode( $content )  . '</div>' . $footer . '</div></li>';
    return $return;
}
}