<?php
/**
 * Simple & Elegant functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @link https://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * {@link https://codex.wordpress.org/Plugin_API}
 *
 * @package Simple & Elegant
 * @since 1.0
 */

add_action( 'wp_enqueue_scripts', 'wi_child_enqueue_styles');
function wi_child_enqueue_styles() {
	
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
	wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', array('parent-style'));
}



// Custom post types function
function create_custom_post_types() {
// create a press page custom post type
	register_post_type( 'press_piece',
		array(
			'labels' => array(
				'name' => __( 'Press Pieces' ),
				'singular_name' => __( 'Press Piece' )
				),
				'public' => true,
				'has_archive' => true,
				'rewrite' => array( 'slug' => 'press' ),
				)
	
);
}

// Hook this custom post type fuction into the theme
add_action( 'init', 'create_custom_post_types' );



?>