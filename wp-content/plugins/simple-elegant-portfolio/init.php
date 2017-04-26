<?php
/*
Plugin Name: (Simple & Elegant) Portfolio
Plugin URI: http://withemes.com
Description: Portfolio component for Simple & Elegant theme.
Version: 2.1
Author: WiThemes
Author URI: http://withemes.com
*/

/* Don't load directly
--------------------------------------------------------------- */
if (!defined('ABSPATH')) die('-1');

// @since 2.0
define( 'SIMPLE_ELEGANT_PORTFOLIO_VERSION', '2.0' );
define ( 'SIMPLE_ELEGANT_PORTFOLIO_FILE', __FILE__ );
define ( 'SIMPLE_ELEGANT_PORTFOLIO_PATH', plugin_dir_path( SIMPLE_ELEGANT_PORTFOLIO_FILE ) );
define ( 'SIMPLE_ELEGANT_PORTFOLIO_URL', plugins_url ( '/', SIMPLE_ELEGANT_PORTFOLIO_FILE ) );

// Shortcode
if ( class_exists( 'Withemes_Shortcode' ) ) require_once SIMPLE_ELEGANT_PORTFOLIO_PATH . 'addons/portfolio/register.php';

if ( !class_exists('WI_Portfolio') ) :
/**
 * Main Portfolio Class
 *
 * @since 1.0
 */
class WI_Portfolio {
	
	function __construct() {
	
		require_once( plugin_dir_path( __FILE__ ) . 'portfolio.php' );

		add_filter( 'single_template', array(&$this,'withemes_single_portfolio') ) ;
		
		add_filter('template_include',array(&$this,'withemes_portfoli_category_template') ) ;
		
		add_image_size( 'wi-medium', 400, 300, true );

		load_plugin_textdomain( 'simple-elegant', false, dirname( plugin_basename(__FILE__) ) . '/languages' );
		
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue' ) );
        
        // Register More Panels, Sections, Options...
        add_filter( 'withemes_panels', array( $this, 'panels' ) );
        add_filter( 'withemes_sections', array( $this, 'sections' ) );
        add_filter( 'withemes_options', array( $this, 'options' ) );
        
        // Metaboxes
        add_filter( 'withemes_metaboxes', array( $this, 'metaboxes' ) );
        
        // Projects per page
        add_action( 'pre_get_posts', array( $this, 'projects_per_page' ) );
        
        // right time to register this widget
        add_action( 'after_setup_theme', function() {
            require_once SIMPLE_ELEGANT_PORTFOLIO_PATH . 'widgets/latest-projects/register.php';
        });
		
    }
    
    /**
     * Projects per page
     *
     * @since 2.0
     */
    function projects_per_page( $query ) {
    
        $ppp = intval( get_option( 'withemes_projects_per_page', 6 ) );
        if ( $ppp < -1 ) $ppp = 6;
        if ( !is_admin() && $query->is_main_query() ) {
            if(is_tax('portfolio_category')){
              $query->set('posts_per_page', $ppp );
            }
        }
        
    }
    
    /**
     * Metaboxes
     *
     * @return $metaboxes
     *
     * @since 2.0
     */
    function metaboxes( $metaboxes ) {
        
        $all_navs = array( '' => esc_html__( 'None', 'oslo' ) );
        $all_navs = $all_navs + get_terms( 'nav_menu', array( 'hide_empty' => true, 'fields' =>  'id=>name' ) );
        
        // PORTFOLIO SETTINGS
        //
        $metaboxes[] = array (
            
            'id' => 'portfolio-settings',
            'screen' => array( 'portfolio' ),
            'title' => esc_html__( 'Portfolio Settings', 'simple-elegant' ),
            
            'tabs' => array(
                'single'    => esc_html__( 'Single Project', 'simple-elegant' ),
                'gallery'   => esc_html__( 'Gallery Options', 'simple-elegant' ),
            ),
            
            'fields' => array (
                
                // LAYOUT
                array (
                    'id' => 'project_layout',
                    'name' => esc_html__( 'Project Layout', 'simple-elegant' ),
                    'type' => 'select',
                    'options' => array(
                        '' => esc_html__( 'Inherit', 'simple-elegant' ),
                        'full' => esc_html__( 'Fullwidth', 'simple-elegant' ),
                        'half' => esc_html__( 'Halfwidth', 'simple-elegant' ),
                    ),
                    'std' => '',
                    'tab' => 'single',
                ),
                
                // GALLERY DISPLAY
                array (
                    'id' => 'gallery_display',
                    'name' => esc_html__( 'Gallery Display as:', 'simple-elegant' ),
                    'type' => 'select',
                    'options' => array(
                        'slider' => esc_html__( 'Slideshow', 'simple-elegant' ),
                        'stack' => esc_html__( 'Image Stack', 'simple-elegant' ),
                    ),
                    'std' => 'slider',
                    'tab' => 'gallery',
                ),
                
            ),
            
        );
        
        return $metaboxes;
        
    } 
    
    /**
     * Enqueue CSS & Javascript
     *
     * @since 2.0
     */
    function enqueue() {
        
        /* Front-End scripts & Styles
		-------------------------------------------- */
        wp_enqueue_style( 'wi-portfolio', SIMPLE_ELEGANT_PORTFOLIO_URL . 'assets/portfolio.css' );
    
    }
	
	function withemes_portfoli_category_template($template){
		if ( is_tax('portfolio_category') || is_post_type_archive('portfolio') ) {
			$template = plugin_dir_path( __FILE__ ) . '/taxonomy-portfolio_category.php';
		}
		return $template;
	
    }
	
	function withemes_single_portfolio($single_template) {
		global $post;
		if ($post->post_type == 'portfolio') {
			$single_template = plugin_dir_path( __FILE__ ) . 'templates/single-portfolio.php';
		}
		return $single_template;
	}
    
    /**
     * Portfolio Panel
     *
     * @since 2.0
     */
    function panels( $panels ) {
    
        $panels[ 'portfolio' ] = array(
            'title' => esc_html__( 'Portfolio', 'simple-elegant' ),
            'priority' => 270,
        );
        return $panels;
        
    }
    
    /**
     * Portfolio Sections
     *
     * @since 2.0
     */
    function sections( $sections ) {
    
        $sections[ 'portfolio' ] = array(
            'panel' => 'portfolio',
            'title' => esc_html__( 'Portfolio', 'simple-elegant' )
        );
        
        $sections[ 'project' ] = array(
            'panel' => 'portfolio',
            'title' => esc_html__( 'Single Project', 'simple-elegant' )
        );
        
        $sections[ 'portfolio_style' ] = array(
            'panel' => 'style',
            'title' => esc_html__( 'Portfolio', 'simple-elegant' )
        );
        
        return $sections;
        
    }
    
    /**
     * Portfolio Opptions
     *
     * @since 2.0
     */
    function options( $options ) {
        
        /* Portfolio Options
        ------------------------------------------ */
        $options[ 'portfolio_slug' ] = array(
            'type' => 'text',
            'placeholder' => 'portfolio_item',
            'section' => 'portfolio',
            'name' => esc_html__( 'Portfolio Slug', 'simple-elegant' ),
            'desc' => esc_html__( 'This is the text that appears before project name on the address bar. If you wish to set custom slug, please save then go to "Settings > Permalinks".', 'simple-elegant' ),
        );
        
        $options[ 'portfolio_category_slug' ] = array(
            'type' => 'text',
            'placeholder' => 'portfolio_category',
            'section' => 'portfolio',
            'name' => esc_html__( 'Portfolio Category Slug', 'simple-elegant' ),
            'desc' => esc_html__( 'This is the text that appears before project category name on the address bar. If you wish to set custom slug, please save then go to "Settings > Permalinks".', 'simple-elegant' ),
        );
        
        $options[ 'projects_per_page' ] = array(
            'type' => 'text',
            'placeholder' => '6',
            'section' => 'portfolio',
            'name' => esc_html__( 'Number of projects per page.', 'simple-elegant' ),
        );
        
        $options[ 'portfolio_column' ] = array(
            'type' => 'radio',
            'options' => array(
                '2' => esc_html__( '2 columns', 'simple-elegant' ),
                '3' => esc_html__( '3 columns', 'simple-elegant' ),
                '4' => esc_html__( '4 columns', 'simple-elegant' ),
            ),
            'std' => '3',
            'section' => 'portfolio',
            'name' => esc_html__( 'Column', 'simple-elegant' ),
        );
        
        $options[ 'portfolio_item_style' ] = array(
            'type' => 'radio',
            'options' => array(
                '1' => esc_html__( 'Style 1', 'simple-elegant' ),
                '2' => esc_html__( 'Style 2', 'simple-elegant' ),
                '3' => esc_html__( 'Style 3', 'simple-elegant' ),
            ),
            'std' => '1',
            'section' => 'portfolio',
            'name' => esc_html__( 'Portfolio Item Style', 'simple-elegant' ),
        );
        
        $options[ 'portfolio_item_ratio' ] = array(
            'type' => 'text',
            'placeholder' => '4:3',
            'section' => 'portfolio',
            'name' => esc_html__( 'Project Thumbnail Ratio', 'simple-elegant' ),
            'desc' => esc_html__( 'Example: 4:3, 1:1, 3:5 so on.', 'simple-elegant' ),
        );
        
        /* Single Project Options
        ------------------------------------------ */
        $options[ 'project_layout' ] = array(
            'type' => 'radio',
            'options' => array(
                'full' => esc_html__( 'Fullwidth', 'simple-elegant' ),
                'half' => esc_html__( 'Halfwidth', 'simple-elegant' ),
            ),
            'std' => 'full',
            'section' => 'project',
            'name' => esc_html__( 'Single project default layout', 'simple-elegant' ),
            'desc' => esc_html__( 'You can change project layout for individual project in its own backend options.', 'simple-elegant' )
        );
        
        $options[ 'related_projects' ] = array(
            'type' => 'radio',
            'options' => withemes_enable_options(),
            'std' => 'true',
            'section' => 'project',
            'name' => esc_html__( 'Show related projects', 'simple-elegant' ),
        );
        
        /* Portfolio Style
        ------------------------------------------ */
        $options[ 'project_rollover_background' ] = array(
            'type' => 'color',
            'section' => 'portfolio_style',
            'name' => esc_html__( 'Portfolio Item Rollover Background', 'simple-elegant' ),
            
            'selector' => '.rollover-overlay',
            'property' => 'background-color',
        );
        
        $options[ 'project_rollover_opacity' ] = array(
            'type' => 'text',
            'section' => 'portfolio_style',
            'placeholder' => '0.9',
            'name' => esc_html__( 'Portfolio Item Rollover Opacity', 'simple-elegant' ),
            
            'selector' => '.rollover-overlay',
            'property' => 'opacity',
        );
        
        $options[ 'project_rollover_color' ] = array(
            'type' => 'color',
            'section' => 'portfolio_style',
            'name' => esc_html__( 'Portfolio Item Rollover Text Color', 'simple-elegant' ),
            
            'selector' => '.wi-rollover .wi-cell',
            'property' => 'color',
        );
        
        return $options;
        
    }
    
}	// class
endif;	// class exists

$WI_Portfolio = new WI_Portfolio;