<?php
/* Slider
-------------------------------------------------------------------------------------- */
if (!function_exists('withemes_shortcode_testimonial_slider')){
function withemes_shortcode_testimonial_slider( $atts, $content = null ) {
    extract( shortcode_atts( array(
        'auto' => 'true',
        'pager' => 'true',
        'navi' => '',
        'align' => '',
        
        'testimonials' => '',
        
    ), $atts ) );
    //$content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content
    
    $data_attr = array();
    $data_attr[] = 'data-auto="' . esc_attr($auto) .'"';
    $data_attr[] = 'data-pager="' . esc_attr($pager) . '"';
    $data_attr[] = 'data-navi="' . esc_attr($navi) . '"';
    $data_attr = join(' ',$data_attr);
    
    if ( 'center' != $align ) $align = 'left';
    
    // supports old version
    $content = trim( $content );
    $html = '';
    if ( $content ) {
        $html = do_shortcode( $content );
    } else {
        $testimonials = vc_param_group_parse_atts( $testimonials );
        if ( $testimonials && is_array( $testimonials ) ) {
            foreach ( $testimonials as $testimonial ) {

                if ( ! isset( $testimonial[ 'content' ] ) ) $testimonial[ 'content' ] = '';
                $testimonial[ 'align' ] = $align;

                $html .= withemes_shortcode_testimonial( $testimonial, $testimonial[ 'content' ] );

            }
        }
    }
    
    $return = '<div class="testimonial-slider align-' . esc_attr( $align ) . '" '.$data_attr.'><div class="flexslider"><ul class="slides">';
    $return .= $html;
    $return .= '</ul></div></div>'; // testimonial slider
    
    return $return;
}
}

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
?>