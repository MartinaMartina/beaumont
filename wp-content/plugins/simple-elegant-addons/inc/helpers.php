<?php
/* Subword
 * @since 1.0
--------------------------------------------------------------- */
if ( !function_exists('withemes_subword') ):
function withemes_subword($str = '',$int = 0, $length = NULL){
	if (!$str) return;
	$words = explode(" ",$str); if (!is_array($words)) return;
	$return = array_slice($words,$int,$length); if (!is_array($return)) return;
	return implode(" ",$return);
}
endif;

if ( ! function_exists( 'withemes_font_weight' ) ) :
/**
 * Lists all font weights possible
 *
 * @since 2.0
 */
function withemes_font_weight() {
    
    return array(
        'Default' => '',
        '100' => '100',
        '200' => '200',
        '300' => '300',
        '400' => '400',
        '500' => '500',
        '600' => '600',
        '700' => '700',
        '800' => '800',
        '900' => '900',
    );
    
}
endif;

if ( ! function_exists( 'withemes_font_style' ) ) :
/**
 * Lists all font styles possible
 *
 * @since 2.0
 */
function withemes_font_style() {
    
    return array(
        'Default' => '',
        'Normal' => 'normal',
        'Italic' => 'italic',
    );
    
}
endif;

if ( ! function_exists( 'withemes_text_transform' ) ) :
/**
 * Text transform states
 *
 * @since 2.0
 */
function withemes_text_transform() {
    
    return array(
        'Default' => '',
        'None' => 'none',
        'UPPERCASE' => 'uppercase',
        'lowercase' => 'lowercase',
        'Capitalize' => 'capitalize',
    );
    
}
endif;

if ( ! function_exists( 'withemes_border_style' ) ):
/**
 * Border Style
 *
 * @since 2.0
 */
function withemes_border_style() {
    return array(
        'none' => esc_html__( 'None', 'simple-elegant' ),
        'solid' => esc_html__( 'Solid', 'simple-elegant' ),
        'dotted' => esc_html__( 'Dotted', 'simple-elegant' ),
        'dashed' => esc_html__( 'Dashed', 'simple-elegant' ),
        'double' => esc_html__( 'Double', 'simple-elegant' ),
    );
}
endif;

if ( ! function_exists( 'withemes_button_params' ) ):
/**
 * Button Params
 *
 * @since 2.0
 */
function withemes_button_params( $group = '', $exclude = array() ) {
    
    $params = array();
    include SIMPLE_ELEGANT_ADDONS_PATH . 'addons/button/params.php';
    
    if ( $group ) {
        foreach ( $params as $i => $param ) {
        
            if ( ! isset( $param[ 'group' ] ) ) {
                $param[ 'group' ] = $group;
            }
            $params[ $i ] = $param;
        
        }
    }
    
    return $params;
    
}
endif;