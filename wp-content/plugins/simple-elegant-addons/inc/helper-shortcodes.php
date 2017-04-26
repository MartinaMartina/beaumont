<?php
add_shortcode( 'dropcap', 'dropcap' );
if ( ! function_exists( 'withemes_dropcap' ) ) :
/**
 * Dropcap Shortcode
 *
 * @since 2.0
 */
function withemes_dropcap( $atts, $content = null ) {
    
    return '<span class="withemes-dropcap">' . trim($content) . '</span>';
    
}
endif;

add_shortcode( 'highlight', 'withemes_highlight' );
if ( ! function_exists( 'withemes_highlight' ) ) :
/**
 * Highlight Shortcode
 *
 * @since 2.0
 */
function withemes_highlight( $atts, $content = null ) {
    
    return '<span class="withemes-highlight">' . trim($content) . '</span>';
    
}
endif;



add_shortcode( 'tooltip', 'withemes_tooltip' );
if ( ! function_exists( 'withemes_tooltip' ) ) :
/**
 * Tooltip Shortcode
 *
 * @since 2.0
 */
function withemes_tooltip( $atts, $content = null ) {
    
    $title_attr = '';
    $title = isset( $atts[ 'title' ] ) ? $atts[ 'title' ] : '';
    $title = trim( $title );
    if ( $title != '' ) {
        $title_attr = ' title="' . esc_attr( $title ) . '"';
    }
    
    return '<span class="withemes-tooltip has-tip"' . $title_attr . '>' . trim($content) . '</span>';
    
}
endif;