<?php
/**
 * Simple & Elegant back compat functionality
 *
 * Prevents Simple & Elegant from running on WordPress versions prior to 4.2,
 * since this theme is not meant to be backward compatible beyond that and
 * relies on many newer functions and markup changes introduced in 4.2.
 *
 * @package Simple & Elegant
 * @since 1.0
 */

/**
 * Prevent switching to Simple & Elegant on old versions of WordPress.
 *
 * Switches to the default theme.
 *
 * @since Simple & Elegant 1.0
 */
if ( !function_exists('withemes_switch_theme') ) :
function withemes_switch_theme() {
	switch_theme( WP_DEFAULT_THEME, WP_DEFAULT_THEME );
	unset( $_GET['activated'] );
	add_action( 'admin_notices', 'withemes_upgrade_notice' );
}
endif;
add_action( 'after_switch_theme', 'withemes_switch_theme' );

/**
 * Add message for unsuccessful theme switch.
 *
 * Prints an update nag after an unsuccessful attempt to switch to
 * Simple & Elegant on WordPress versions prior to 4.2.
 *
 * @since Simple & Elegant 1.0
 */
if ( !function_exists('withemes_upgrade_notice') ) :
function withemes_upgrade_notice() {
	$message = sprintf( esc_html__( 'Simple & Elegant requires at least WordPress version 4.2. You are running version %s. Please upgrade and try again.', 'simple-elegant' ), $GLOBALS['wp_version'] );
	printf( '<div class="error"><p>%s</p></div>', $message );
}
endif;

/**
 * Prevent the Customizer from being loaded on WordPress versions prior to 4.2.
 *
 * @since Simple & Elegant 1.0
 */
if ( !function_exists('withemes_customize') ) :
function withemes_customize() {
	wp_die( sprintf( esc_html__( 'Simple & Elegant requires at least WordPress version 4.2. You are running version %s. Please upgrade and try again.', 'simple-elegant' ), $GLOBALS['wp_version'] ), '', array(
		'back_link' => true,
	) );
}
endif;
add_action( 'load-customize.php', 'withemes_customize' );

/**
 * Prevent the Theme Preview from being loaded on WordPress versions prior to 4.2.
 *
 * @since Simple & Elegant 1.0
 */
if ( !function_exists('withemes_preview') ) :
function withemes_preview() {
	if ( isset( $_GET['preview'] ) ) {
		wp_die( sprintf( esc_html__( 'Simple & Elegant requires at least WordPress version 4.2. You are running version %s. Please upgrade and try again.', 'simple-elegant' ), $GLOBALS['wp_version'] ) );
	}
}
endif;
add_action( 'template_redirect', 'withemes_preview' );