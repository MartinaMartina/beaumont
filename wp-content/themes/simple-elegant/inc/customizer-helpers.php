<?php
if ( ! function_exists( 'withemes_text_transform_options' ) ) :
/**
 * Text Transform
 *
 * @since 2.0
 */
function withemes_text_transform_options() {

    return array(
        '' => esc_html__( 'Default', 'simple-elegant' ),
        'uppercase' => esc_html__( 'UPPERCASE', 'simple-elegant' ),
        'lowercase' => esc_html__( 'lowercase', 'simple-elegant' ),
        'capitalize' => esc_html__( 'Capitalize', 'simple-elegant' ),
        'none' => esc_html__( 'None', 'simple-elegant' ),
    );

}

endif;

if ( ! function_exists( 'withemes_font_style_options' ) ) :
/**
 * Font Style
 *
 * @since 2.0
 */
function withemes_font_style_options() {

    return array(
        'normal' => esc_html__( 'Normal', 'simple-elegant' ),
        'italic' => esc_html__( 'Italic', 'simple-elegant' ),
    );

}

endif;

if ( ! function_exists( 'withemes_font_weight_options' ) ) :
/**
 * Font Weight
 *
 * @since 2.0
 */
function withemes_font_weight_options() {

    return array(
        '' => esc_html__( 'Default', 'simple-elegant' ),
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

if ( ! function_exists( 'withemes_enable_options' ) ) :
/**
 * Enable/Disable some option
 *
 * @since 2.0
 */
function withemes_enable_options() {

    return array(
        'true' => esc_html__( 'Enable', 'simple-elegant' ),
        'false' => esc_html__( 'Disable', 'simple-elegant' ),
    );

}

endif;

if ( ! function_exists( 'withemes_font_options' ) ) :
/**
 * Choose between heading font or body font
 *
 * @since 2.0
 */
function withemes_font_options() {

    return array(
        'heading' => esc_html__( 'Heading Font', 'simple-elegant' ),
        'body' => esc_html__( 'Body Font', 'simple-elegant' ),
    );

}

endif;