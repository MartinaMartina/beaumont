<?php
if ( ! function_exists( 'withemes_header_class' ) ):
/**
 * Header CSS Class
 *
 * @since 2.0
 */
function withemes_header_class() {
    
    $classes = array( 'wi-header' );
    
    $layout = get_option( 'withemes_header_layout', '1' );
    if ( '2' != $layout ) $layout = '1';
    
    $classes[] = 'header-' . $layout;
    
    $classes = apply_filters( 'withemes_header_class', $classes );
    
    return join( ' ', $classes );

}
endif;