<?php
/*
Plugin Name: (Simple & Elegant) Addons
Plugin URI: https://themeforest.net/item/simple-elegant-multipurpose-theme/13730411
Description: Addons for Visual Composer in Simple & Elegant theme
Version: 2.1
Author: WiThemes
Author URI: https://themeforest.net/user/withemes
*/

/* Don't load directly
--------------------------------------------------------------- */
if (!defined('ABSPATH')) die('-1');

// @since 2.0
define( 'SIMPLE_ELEGANT_ADDONS_VERSION', '2.0' );
define ( 'SIMPLE_ELEGANT_ADDONS_FILE', __FILE__ );
define ( 'SIMPLE_ELEGANT_ADDONS_PATH', plugin_dir_path( SIMPLE_ELEGANT_ADDONS_FILE ) );
define ( 'SIMPLE_ELEGANT_ADDONS_URL', plugins_url ( '/', SIMPLE_ELEGANT_ADDONS_FILE ) );

/**
 * Libs
 */
// @since 2.0
require_once SIMPLE_ELEGANT_ADDONS_PATH . 'inc/icons.php';
require_once SIMPLE_ELEGANT_ADDONS_PATH . 'inc/iconpicker.php';
require_once SIMPLE_ELEGANT_ADDONS_PATH . 'inc/shortcode.php';

// helpers
require_once SIMPLE_ELEGANT_ADDONS_PATH . 'inc/helpers.php';
require_once SIMPLE_ELEGANT_ADDONS_PATH . 'inc/helper-shortcodes.php';

// Shortcodes
require_once SIMPLE_ELEGANT_ADDONS_PATH . 'addons/button/register.php';
require_once SIMPLE_ELEGANT_ADDONS_PATH . 'addons/callout/register.php';
require_once SIMPLE_ELEGANT_ADDONS_PATH . 'addons/gallery/register.php';
require_once SIMPLE_ELEGANT_ADDONS_PATH . 'addons/iconbox/register.php';
require_once SIMPLE_ELEGANT_ADDONS_PATH . 'addons/news/register.php';
require_once SIMPLE_ELEGANT_ADDONS_PATH . 'addons/member/register.php';
require_once SIMPLE_ELEGANT_ADDONS_PATH . 'addons/testimonial_slider/register.php';
require_once SIMPLE_ELEGANT_ADDONS_PATH . 'addons/slider/register.php';
require_once SIMPLE_ELEGANT_ADDONS_PATH . 'addons/post_grid/register.php';
require_once SIMPLE_ELEGANT_ADDONS_PATH . 'addons/pricing_column/register.php';

// Row modifications
// since 2.0
require_once SIMPLE_ELEGANT_ADDONS_PATH . 'inc/row.php';

if ( ! class_exists ( 'Withemes_Addons ' )  ) :
/*
 * Main class
 *
 * @since 2.0
 */
class Withemes_Addons 
{
    /**
	 * construct
	 */
	public function __construct() {
	}
    
    /**
	 * The one instance of class
	 *
	 * @since 2.0
	 */
	private static $instance;

	/**
	 * Instantiate or return the one class instance
	 *
	 * @since 2.0
	 * @return $instance
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}
    
    /**
     * Initiate the class
     * contains action & filters
     *
     * @since 2.0
     */
    public function init() {
        
        // Register lately so that everything has been registered
        add_action( 'init', array( $this, 'plugin_init' ), 100 );
        
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue' ), 100 );
        
        // Register More Panels, Sections, Options...
        add_filter( 'withemes_panels', array( $this, 'panels' ) );
        add_filter( 'withemes_sections', array( $this, 'sections' ) );
        add_filter( 'withemes_options', array( $this, 'options' ) );
        
    }
    
    /**
     * Plugin Init
     *
     * @since 1.0
     */
    function plugin_init() {
        
        // Check if Visual Composer is installed
        if ( ! defined( 'WPB_VC_VERSION' ) ) {
            // Display notice that Visual Compser is required
            add_action('admin_notices', 'withemes_show_no_vc_error');
            return;
        }

        load_plugin_textdomain( 'simple-elegant', false, dirname( plugin_basename(__FILE__) ) . '/languages' );

        add_shortcode('testimonial','withemes_shortcode_testimonial');

        // Change directory template
        if (function_exists('vc_set_shortcodes_templates_dir')) {
            vc_set_shortcodes_templates_dir( SIMPLE_ELEGANT_ADDONS_PATH . 'templates' );
        }
    
    }
    
    /**
     * CSS & JS Scripts
     *
     * @since 2.0
     */
    function enqueue() {
        
        wp_enqueue_style( 'wi-shortcodes', plugins_url('css/shortcodes.css',__FILE__), array('js_composer_front'), SIMPLE_ELEGANT_ADDONS_VERSION, 'all');
    
    }
    
    /**
     * Addon Panel
     *
     * @since 2.0
     */
    function panels( $panels ) {
    
        $panels[ 'shortcodes' ] = array(
            'title' => esc_html__( 'Shortcodes', 'simple-elegant' ),
            'priority' => 280,
        );
        return $panels;
        
    }
    
    /**
     * Portfolio Sections
     *
     * @since 2.0
     */
    function sections( $sections ) {
    
        $sections[ 'button' ] = array(
            'panel' => 'shortcodes',
            'title' => esc_html__( 'Button', 'simple-elegant' ),
        );
        
        $sections[ 'iconbox' ] = array(
            'panel' => 'shortcodes',
            'title' => esc_html__( 'Iconbox', 'simple-elegant' ),
        );
        
        $sections[ 'testimonial' ] = array(
            'panel' => 'shortcodes',
            'title' => esc_html__( 'Testimonial', 'simple-elegant' ),
        );
        
        return $sections;
        
    }
    
    /**
     * Portfolio Opptions
     *
     * @since 2.0
     */
    function options( $options ) {
        
        /* Button Options
        ------------------------------------------ */
        $options[ 'button_font' ] = array(
            'type' => 'radio',
            'options' => withemes_font_options(),
            'std' => 'heading',
            
            'section' => 'button',
            'name' => esc_html__( 'Button Font', 'simple-elegant' ),
            
            'selector' => 'a.wi-btn, button.wi-btn',
            'property' => 'font-family',
        );
        
        $options[ 'button_font_size' ] = array(
            'type' => 'text',
            'placeholder' => '12px',
            
            'section' => 'button',
            'name' => esc_html__( 'Button Font Size', 'simple-elegant' ),
            
            'selector' => 'a.wi-btn, button.wi-btn',
            'property' => 'font-size',
        );
        
        $options[ 'button_font_weight' ] = array(
            'type' => 'select',
            'options' => withemes_font_weight_options(),
            'std' => '',
            
            'section' => 'button',
            'name' => esc_html__( 'Button Font Weight', 'simple-elegant' ),
            
            'selector' => 'a.wi-btn, button.wi-btn',
            'property' => 'font-weight',
        );
        
        $options[ 'button_text_transform' ] = array(
            'type' => 'select',
            'options' => withemes_text_transform_options(),
            'std' => '',
            
            'section' => 'button',
            'name' => esc_html__( 'Button Text Transform', 'simple-elegant' ),
            
            'selector' => 'a.wi-btn, button.wi-btn',
            'property' => 'text-transform',
        );
        
        $options[ 'button_letter_spacing' ] = array(
            'type' => 'text',
            'placeholder' => 'Eg. 2px',
            
            'section' => 'button',
            'name' => esc_html__( 'Button Letter Spacing', 'simple-elegant' ),
            
            'selector' => 'a.wi-btn, button.wi-btn',
            'property' => 'letter-spacing',
        );
        
        $options[ 'button_border_radius' ] = array(
            'type' => 'text',
            'placeholder' => 'Eg. 10px',
            
            'section' => 'button',
            'name' => esc_html__( 'Button default border radius', 'simple-elegant' ),
            
            'selector' => 'a.wi-btn, button.wi-btn',
            'property' => 'border-radius',
        );
        
        /* Iconbox Options
        ------------------------------------------ */
        $options[] = array(
            'type' => 'heading',
            'section' => 'iconbox',
            'name' => esc_html__( 'Icon', 'simple-elegant' ),
        );
        
        $options[ 'iconbox_icon_size' ] = array(
            'type' => 'text',
            'placeholder' => '80px',
            
            'section' => 'iconbox',
            'name' => esc_html__( 'Icon Size (Width/Height)', 'simple-elegant' ),
        );
        
        $options[ 'iconbox_icon_font_size' ] = array(
            'type' => 'text',
            'placeholder' => '28px',
            
            'section' => 'iconbox',
            'name' => esc_html__( 'Icon Font Size', 'simple-elegant' ),
            
            'selector' => '.wi-iconbox .icon',
            'property' => 'font-size',
        );
        
        $options[ 'iconbox_icon_border_radius' ] = array(
            'type' => 'select',
            'options' => array(
                '50%' => esc_html__( 'Round', 'simple-elegant' ),
                '0' => esc_html__( 'None', 'simple-elegant' ),
                '1px' => '1px',
                '2px' => '2px',
                '3px' => '3px',
                '4px' => '4px',
                '5px' => '5px',
                '6px' => '6px',
                '10px' => '10px',
                '15px' => '15px',
                '20px' => '20px',
                '30px' => '30px',
            ),
            'std' => '50%',
            
            'section' => 'iconbox',
            'name' => esc_html__( 'Icon Border Radius', 'simple-elegant' ),
            
            'selector' => '.wi-iconbox .icon-inner',
            'property' => 'border-radius',
        );
        
        $options[ 'iconbox_icon_color' ] = array(
            'type' => 'color',
            
            'section' => 'iconbox',
            'name' => esc_html__( 'Icon Color', 'simple-elegant' ),
            
            'selector' => '.wi-iconbox .icon-inner',
            'property' => 'color',
        );
        
        $options[ 'iconbox_icon_background' ] = array(
            'type' => 'color',
            
            'section' => 'iconbox',
            'name' => esc_html__( 'Icon Background', 'simple-elegant' ),
            
            'selector' => '.wi-iconbox .icon-inner',
            'property' => 'background',
        );
        
        $options[ 'iconbox_icon_hover_color' ] = array(
            'type' => 'color',
            
            'section' => 'iconbox',
            'name' => esc_html__( 'Icon Hover Color', 'simple-elegant' ),
            
            'selector' => '.wi-iconbox:hover .icon-inner',
            'property' => 'color',
        );
        
        $options[ 'iconbox_icon_hover_background' ] = array(
            'type' => 'color',
            
            'section' => 'iconbox',
            'name' => esc_html__( 'Icon Hover Background', 'simple-elegant' ),
            
            'selector' => '.wi-iconbox:hover .icon-inner',
            'property' => 'background',
        );
        
        // TITLE OPTIONS
        //
        $options[] = array(
            'type' => 'heading',
            'section' => 'iconbox',
            'name' => esc_html__( 'Title', 'simple-elegant' ),
        );
        
        $options[ 'iconbox_title_color' ] = array(
            'type' => 'color',
            
            'section' => 'iconbox',
            'name' => esc_html__( 'Iconbox Title Color', 'simple-elegant' ),
            
            'selector' => '.iconbox-title',
            'property' => 'color',
        );
        
        $options[ 'iconbox_title_font_size' ] = array(
            'type' => 'text',
            
            'section' => 'iconbox',
            'name' => esc_html__( 'Iconbox Title Font Size', 'simple-elegant' ),
            
            'selector' => '.iconbox-title',
            'property' => 'font-size',
        );
        
        $options[ 'iconbox_title_font_weight' ] = array(
            'type' => 'select',
            'options' => withemes_font_weight_options(),
            'std' => '',
            
            'section' => 'iconbox',
            'name' => esc_html__( 'Title Font Weight', 'simple-elegant' ),
            
            'selector' => '.iconbox-title',
            'property' => 'font-weight',
        );
        
        $options[ 'iconbox_title_font_style' ] = array(
            'type' => 'radio',
            'options' => withemes_font_style_options(),
            'std' => 'normal',
            
            'section' => 'iconbox',
            'name' => esc_html__( 'Title Font Style', 'simple-elegant' ),
            
            'selector' => '.iconbox-title',
            'property' => 'font-style',
        );
        
        $options[ 'iconbox_title_text_transform' ] = array(
            'type' => 'select',
            'options' => withemes_text_transform_options(),
            'std' => '',
            
            'section' => 'iconbox',
            'name' => esc_html__( 'Title Text Transform', 'simple-elegant' ),
            
            'selector' => '.iconbox-title',
            'property' => 'text-transform',
        );
        
        $options[ 'iconbox_title_letter_spacing' ] = array(
            'type' => 'text',
            'placeholder' => 'Eg. 2px',
            
            'section' => 'iconbox',
            'name' => esc_html__( 'Title Letter Spacing', 'simple-elegant' ),
            
            'selector' => '.iconbox-title',
            'property' => 'letter-spacing',
        );
        
        // ICONBOX TEXt
        //
        $options[] = array(
            'type' => 'heading',
            'section' => 'iconbox',
            'name' => esc_html__( 'Iconbox Text', 'simple-elegant' ),
        );
        
        $options[ 'iconbox_text_font_size' ] = array(
            'type' => 'text',
            'placeholder' => 'Eg. 14px',
            
            'section' => 'iconbox',
            'name' => esc_html__( 'Iconbox Content Font Size', 'simple-elegant' ),
            
            'selector' => '.wi-iconbox .iconbox-desc',
            'property' => 'font-size',
        );
        
        $options[ 'iconbox_text_color' ] = array(
            'type' => 'color',
            
            'section' => 'iconbox',
            'name' => esc_html__( 'Iconbox Content Text Color', 'simple-elegant' ),
            
            'selector' => '.wi-iconbox .iconbox-desc',
            'property' => 'color',
        );
        
        /* Testimonial
        ------------------------------------------ */
        $options[ 'testimonial_font' ] = array(
            'type' => 'radio',
            'options' => withemes_font_options(),
            'std' => 'heading',
            
            'section' => 'testimonial',
            'name' => esc_html__( 'Testimonial Font', 'simple-elegant' ),
            
            'selector' => '.testimonial-content',
            'property' => 'font-family',
        );
        
        $options[ 'testimonial_font_size' ] = array(
            'type' => 'text',
            'placeholder' => '1.4em',
            
            'section' => 'testimonial',
            'name' => esc_html__( 'Testimonial Font Size', 'simple-elegant' ),
            
            'selector' => '.testimonial-content',
            'property' => 'font-size',
        );
        
        $options[ 'testimonial_line_height' ] = array(
            'type' => 'text',
            'placeholder' => 'Eg. 1.5',
            
            'section' => 'testimonial',
            'name' => esc_html__( 'Testimonial Line Height', 'simple-elegant' ),
            
            'selector' => '.testimonial-content',
            'property' => 'line-height',
        );
        
        $options[ 'testimonial_font_style' ] = array(
            'type' => 'select',
            'options' => withemes_font_style_options(),
            'std' => 'normal',
            
            'section' => 'testimonial',
            'name' => esc_html__( 'Testimonial Font Style', 'simple-elegant' ),
            
            'selector' => '.testimonial-content',
            'property' => 'font-style',
        );
        
        $options[ 'testimonial_color' ] = array(
            'type' => 'color',
            
            'section' => 'testimonial',
            'name' => esc_html__( 'Testimonial Color', 'simple-elegant' ),
            
            'selector' => '.testimonial-content',
            'property' => 'color',
        );
        
        return $options;
        
    }
    
}

Withemes_Addons::instance()->init();

endif;

/* Show error when VC is not installed
--------------------------------------------------------------- */
if (!function_exists('withemes_show_no_vc_error')) {
function withemes_show_no_vc_error(){
    $plugin_data = get_plugin_data(__FILE__);
    echo '
    <div class="error">
      <p>'.sprintf(__('<strong>%s</strong> requires <strong><a href="'.get_admin_url('','themes.php?page=tgmpa-install-plugins').'">Visual Composer</a></strong> plugin to be installed and activated on your site.', 'simple-elegant'), $plugin_data['Name']).'</p>
    </div>';
}
}

/* Disable frontend editor
--------------------------------------------------------------- */
if (function_exists('vc_disable_frontend')) vc_disable_frontend();
if (function_exists('vc_set_default_editor_post_types')) vc_set_default_editor_post_types( array('page') );

/* Disable activation notice
--------------------------------------------------------------- */
add_action('admin_init', 'wi_disable_activation_vc');
if (!function_exists('wi_disable_activation_vc')):
function wi_disable_activation_vc() {
    setcookie('vchideactivationmsg', '1', strtotime('+3 years'), '/');
}
endif;
?>