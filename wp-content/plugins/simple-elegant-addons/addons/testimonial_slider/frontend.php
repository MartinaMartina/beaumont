<?php
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

$slider_args = array(
    'animation' => 'fade',
    'slideshow' => (bool) ( 'true' == $auto ),
    'directionNav' => false,
    'controlNav' => (bool) ( 'true' == $pager ),
    
    'smoothHeight' => false,
);

?>
<div class="testimonial-slider wi-flexslider align-<?php echo esc_attr( $align ); ?>" data-options='<?php echo json_encode( $slider_args ); ?>'>
    
    <div class="flexslider">
        
        <ul class="slides">
            
            <?php echo $html; ?>

        </ul>
    
    </div><!-- .flexslider -->

</div><!-- .testimonial-slider -->