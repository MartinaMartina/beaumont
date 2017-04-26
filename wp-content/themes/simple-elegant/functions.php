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

// add_filter( 'show_admin_bar', '__return_false' );

/* Content Width
-------------------------------------------------------------------------------------- */
if ( ! isset( $content_width ) ) {
	$content_width = 705;
}

/* Backward Compatible
-------------------------------------------------------------------------------------- */
if ( version_compare( $GLOBALS['wp_version'], '4.2-alpha', '<' ) ) {
	require get_template_directory() . '/inc/back-compat.php';
}

/* Theme Setup
-------------------------------------------------------------------------------------- */
if ( ! function_exists( 'withemes_setup' ) ) :
function withemes_setup() {

	/* Translating
    --------------------- */
	load_theme_textdomain( 'simple-elegant', get_template_directory() . '/languages' );

	/* Feed
    --------------------- */
	add_theme_support( 'automatic-feed-links' );

	/* WP 4.1 title tag support
    --------------------- */
	add_theme_support( 'title-tag' );

	/* Post Thumbnail
    --------------------- */
	add_theme_support( 'post-thumbnails' );
	add_image_size( 'wi-medium', 400, 300, true );
    add_image_size( 'wi-square', 400, 400, true );
    add_image_size( 'wi-portrait', 400, 500, true );

	/* Menu
    --------------------- */
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Menu', 'simple-elegant' ),
		'topbar'  => esc_html__( 'Topbar Menu', 'simple-elegant' ),
	) );

	/* HTML 5
    --------------------- */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
	) );

	/* Post Formats
    --------------------- */
	add_theme_support( 'post-formats', array(
		'video', 'gallery', 'audio'
	) );
    
    /* since 1.3 */
    add_theme_support( 'woocommerce' );

	/* Editor Style
    --------------------- */
	add_editor_style( array( 'css/editor-style.css' ) );
    
    
}
endif; // withemes_setup
add_action( 'after_setup_theme', 'withemes_setup' );

// @since 1.1.1
add_action( 'vc_before_init', 'withemes_vc_set_as_theme' );
if ( ! function_exists( 'withemes_vc_set_as_theme' ) ) :
function withemes_vc_set_as_theme() {
    vc_set_as_theme(true);
};
endif;

/* Widget Area
-------------------------------------------------------------------------------------- */
if ( ! function_exists( 'withemes_widgets_init' ) ) :
function withemes_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Blog Sidebar', 'simple-elegant' ),
		'id'            => 'main',
		'description'   => esc_html__( 'Plays Sidebar role for blog & archive pages', 'simple-elegant' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );
    
    register_sidebar( array(
		'name'          => esc_html__( 'Post Sidebar', 'simple-elegant' ),
		'id'            => 'single',
		'description'   => esc_html__( 'Plays Sidebar role for single post', 'simple-elegant' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );
    
    register_sidebar( array(
		'name'          => esc_html__( 'Page Sidebar', 'simple-elegant' ),
		'id'            => 'page',
		'description'   => esc_html__( 'Plays Sidebar role for pages', 'simple-elegant' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );
    
    register_sidebar( array(
		'name'          => esc_html__( 'Footer 1', 'simple-elegant' ),
		'id'            => 'footer-1',
		'description'   => esc_html__( 'Footer widgets position 1', 'simple-elegant' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );
    
    register_sidebar( array(
		'name'          => esc_html__( 'Footer 2', 'simple-elegant' ),
		'id'            => 'footer-2',
		'description'   => esc_html__( 'Footer widgets position 2', 'simple-elegant' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );
    
    register_sidebar( array(
		'name'          => esc_html__( 'Footer 3', 'simple-elegant' ),
		'id'            => 'footer-3',
		'description'   => esc_html__( 'Footer widgets position 3', 'simple-elegant' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );
    
}
endif;
add_action( 'widgets_init', 'withemes_widgets_init' );

/* JavaScript Detection
 * Adds a `js` class to the root `<html>` element when JavaScript is detected.
-------------------------------------------------------------------------------------- */
if ( !function_exists('withemes_javascript_detection') ):
function withemes_javascript_detection() {
	echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}
endif;
add_action( 'wp_head', 'withemes_javascript_detection', 0 );

/* Enqueue Scripts
-------------------------------------------------------------------------------------- */
if ( !function_exists('withemes_scripts') ):
function withemes_scripts() {
    
    /* Load Google Fonts
     * Use Google Font Array
     */
    $fonts_url = withemes_fonts_url();
    if ( $fonts_url ) {
        wp_enqueue_style( 'withemes-fonts', $fonts_url );
    }
	
    // Load our main stylesheet.
	wp_enqueue_style( 'wi-style', get_template_directory_uri() . '/style.min.css' );
    
    // Concept CSS
    $concept = withemes_concept();
    if ( $concept && 'standard' != $concept ) {
        wp_enqueue_style( 'wi-concept', get_template_directory_uri() . '/css/concepts/' . $concept . '.css', array( 'wi-style' ) );
    }

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
    
    if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'wi-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20151116' );
	}
    
    // Load the html5 shiv.
	wp_enqueue_script( 'wi-html5', get_template_directory_uri() . '/js/html5.js', array(), '3.7.0' );
	wp_script_add_data( 'wi-html5', 'conditional', 'lt IE 9' );
    
    // final script
	wp_enqueue_script( 'wi-script', get_template_directory_uri() . '/js/theme.min.js', array( 'jquery' ), '20161028', true );
    
    // remove redundant flexslider
    wp_deregister_script( 'flexslider' );
    wp_deregister_style( 'flexslider' );
}
endif;
add_action( 'wp_enqueue_scripts', 'withemes_scripts' );

/**
 * Returns site concept. This function can not be overridden in your child theme
 *
 * @since 2.0
 */
function withemes_concept(){
    
    $concept = get_option( 'withemes_concept' );
    if ( ! in_array( $concept, array( 'diy', 'photography' ) ) ) $concept = 'standard';
    
    return $concept;
    
}

/* Body Class
-------------------------------------------------------------------------------------- */
add_action('body_class','withemes_body_class');
if (!function_exists('withemes_body_class')){
function withemes_body_class($classes){
    
    /* Concept
     * @since 2.0
    --------------------------- */
    $classes[] = 'wi-' . withemes_concept();
    
    /* Boxed Layout
     * @since 2.0
    --------------------------- */
    $layout = get_option( 'withemes_layout' );
    if ( 'boxed' != $layout ) $layout = 'wide';
    $classes[] = 'layout-' . $layout;
    
    /* Sidebar Position
    --------------------------- */
    // add page sidebar class option @since 2.0
    if ( is_page() ) {
        $sidebar_position = get_post_meta( get_the_ID() , '_withemes_sidebar_position', true );
        if ( 'left' == $sidebar_position || 'right' == $sidebar_position ) {
            $classes[] = 'sidebar-' . $sidebar_position;
        }
    } 
    
    if ( ! in_array( 'sidebar-left', $classes ) && ! in_array( 'sidebar-right', $classes ) ) {
    
        $sidebar_pos = get_option('withemes_sidebar_position');
            if ( $sidebar_pos!='left' ) $sidebar_pos = 'right';
            $classes[] = 'sidebar-' .$sidebar_pos;
    }
    
    return $classes;
}
}

/* Head Code
-------------------------------------------------------------------------------------- */
add_action( 'wp_head' , 'withemes_head_code' );
if ( !function_exists('withemes_head_code') ) :
function withemes_head_code(){
    echo get_option('withemes_head_code');
}
endif;

/* Basic allowed HTML
-------------------------------------------------------------------------------------- */
if ( !function_exists('withemes_allowed_html') ) :
function withemes_allowed_html(){
    return array(
        'a' => array(
            'href' => array(),
            'title' => array(),
            'class' => array(),
            'target' => array(),
            'rel' => array(),
        ),
        'br' => array(),
        'em' => array(
            'class' => array(),
        ),
        'strong' => array(
            'class' => array(),
        ),
        'i' => array(
            'class' => array(),
        ),
        'b' => array(),
        'img' => array(
            'class' => array(),
            'width' => array(),
            'height' => array(),
            'src' => array(),
        ),
    );   
}
endif;

/* Image Quality
-------------------------------------------------------------------------------------- */
add_filter('jpeg_quality', 'withemes_image_full_quality');
add_filter('wp_editor_set_quality', 'withemes_image_full_quality');
if (!function_exists('withemes_image_full_quality')) :
function withemes_image_full_quality($quality) {
    return 100;
}
endif;

add_filter( 'excerpt_length', 'withemes_excerpt_length', 999 );
if ( ! function_exists( 'withemes_excerpt_length' ) ) :
/**
 * Change Excerpt length 
 *
 * @since 2.0
 */ 
function withemes_excerpt_length( $length ) { 
    
    $excerpt_length = absint( get_option( 'withemes_excerpt_length' ) );
    if ( $excerpt_length > 0 ) return $excerpt_length;
    
    return 24;
}
endif;

/* Exclude Pages from Search
-------------------------------------------------------------------------------------- */
if (!function_exists('withemes_search_filter')) {
function withemes_search_filter($query) {
    if ( $query->is_main_query() && ! is_admin() ) {
        if ($query->is_search) {
            $query->set('post_type', 'post');
        }
    }
    return $query;
    }
}
add_filter('pre_get_posts','withemes_search_filter');

/* Replace default ajax loader image
-------------------------------------------------------------------------------------- */
add_filter( 'wpcf7_ajax_loader', 'withemes_wpcf7_ajax_loader' );
if ( ! function_exists( 'withemes_wpcf7_ajax_loader' ) ):
/**
 * Replace default ajax loader image
 *
 * @since 2.0
 */
function withemes_wpcf7_ajax_loader( $url ) {
    
    return get_template_directory_uri() . '/images/loading-dark.svg';

}
endif;

if ( ! function_exists( 'withemes_get_instagram_photos' ) ) :
/**
 * retrieve instagram photos
 *
 * @since 2.0
 */
function withemes_get_instagram_photos( $access_token, $number, $cache_time ) {

    /**
     * Get Instagram Photos
     */
    $access_token = trim( $access_token );
    $number = absint( $number );
    $cache_time = absint( $cache_time );

    if ( ! $access_token ) return;

    if ( $number < 1 || $number > 100 ) $number = 9;

    if ( false === ( $instagram = get_transient( 'withemes-instagram-' . sanitize_title_with_dashes( $access_token . '-' . $number ) ) ) ) {

        $url = "https://api.instagram.com/v1/users/self/media/recent/?access_token={$access_token}&count={$number}";

        $remote = wp_remote_get( $url, array(
            'decompress' => false,
        ) );

        if ( is_wp_error( $remote ) )
            return new WP_Error( 'site_down', esc_html__( 'Unable to communicate with Instagram.', 'simple-elegant' ) );

        if ( 200 != wp_remote_retrieve_response_code( $remote ) )
            return new WP_Error( 'invalid_response', esc_html__( 'Instagram did not return a 200.', 'simple-elegant' ) );

        $insta_array = json_decode( $remote['body'], true );

        if ( ! $insta_array )
            return new WP_Error( 'bad_json', esc_html__( 'Instagram has returned invalid data.', 'simple-elegant' ) );

        if ( isset( $insta_array['data'] ) ) {
            $images = $insta_array['data'];
        } else {
            return new WP_Error( 'bad_json_2', esc_html__( 'Instagram has returned invalid data.', 'simple-elegant' ) );
        }

        $instagram = array();

        foreach ( $images as $image ) {

             $return = array(
                'description'   => isset( $image[ 'caption'][ 'text' ] ) ? $image[ 'caption'][ 'text' ] : esc_html__( 'Instagram Photo', 'simple-elegant' ),
                'link'		  	=> isset( $image[ 'link' ] ) ? $image[ 'link' ] : '',
                'time'		  	=> isset( $image[ 'created_time' ] ) ? $image[ 'created_time' ] : '',
                'comments'	  	=> isset( $image[ 'comments' ]['count'] ) ? $image[ 'comments' ]['count'] : '',
                'likes'		 	=> isset( $image[ 'likes' ]['count'] ) ? $image[ 'likes' ]['count'] : '',
                'thumbnail'	 	=> isset( $image[ 'images' ]['thumbnail']['url'] ) ? $image[ 'images' ]['thumbnail']['url'] : '',
                'type'		  	=> isset( $image[ 'type' ] ) ? $image[ 'type' ] : 'image',
            );

            if ( isset( $image[ 'images' ][ 'low_resolution' ][ 'url' ] ) )
                $return[ 'medium' ] = str_replace( '150x150', '320x320', $return[ 'thumbnail' ] );
            else $return[ 'medium' ] = $return[ 'thumbnail' ];

            if ( isset( $image[ 'images' ][ 'standard_resolution' ][ 'url' ] ) )
                $return[ 'large' ] = str_replace( '150x150', '640x640', $return[ 'thumbnail' ] );
            else $return[ 'large' ] = $return[ 'thumbnail' ];

            $instagram[] = $return;

        }

        // do not set an empty transient - should help catch private or empty accounts
        if ( ! empty( $instagram ) ) {
            set_transient( 'withemes-instagram-'.sanitize_title_with_dashes( $access_token . '-' . $number ), $instagram, $cache_time );
        }
    }

    if ( ! empty( $instagram ) ) {

        return array_slice( $instagram, 0, $number );

    } else {

        return new WP_Error( 'no_images', esc_html__( 'Instagram did not return any images.', 'simple-elegant' ) );

    }

}
endif;

/* Google Fonts
-------------------------------------------------------------------------------------- */
require get_template_directory() . '/inc/fonts.php';

/* Automatically Featured Image from Videos
-------------------------------------------------------------------------------------- */
require get_template_directory() . '/inc/automatic-featured-images-from-videos.php';

/* Theme Components
-------------------------------------------------------------------------------------- */
require get_template_directory() . '/inc/template-tags.php';
require get_template_directory() . '/inc/nav.php';
require get_template_directory() . '/inc/header.php';
require get_template_directory() . '/inc/responsive.php';

/* Customizer
-------------------------------------------------------------------------------------- */
require get_template_directory() . '/inc/customizer-helpers.php';
require get_template_directory() . '/inc/customizer.php';

/* Theme Customization
-------------------------------------------------------------------------------------- */
require get_template_directory() . '/inc/css.php';

/* WooCommerce
 * @since 1.3
-------------------------------------------------------------------------------------- */
require get_template_directory() . '/woo/hooks.php';

/* Admin Area
 * @since 2.0
-------------------------------------------------------------------------------------- */
require get_template_directory() . '/inc/admin/admin.php';

/* Single-click Install
 * @since 2.0
-------------------------------------------------------------------------------------- */
require_once get_template_directory() . '/inc/demo-import/one-click-demo-import.php';

/* Theme Builtin Widgets
-------------------------------------------------------------------------------------- */
require get_template_directory() . '/widgets/image/register.php';
require get_template_directory() . '/widgets/post-list/register.php';