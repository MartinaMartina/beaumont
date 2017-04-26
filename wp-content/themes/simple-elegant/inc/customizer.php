<?php
// CUSTOMIZER
if (!class_exists('Wi_Customize')):
/**
 * Wi_Customize class
 *
 * @since 1.0
 * @modified since 2.0
 */
class Wi_Customize {
    
    private static $prefix = 'withemes_';
    
    /**
	 * Construct
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
	 *
	 * @return class
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
        
        // Registers Settings here
        add_action( 'customize_register', array( $this , 'register' ), 1000 );
        
        // Javascript for Customizer, for iframe
        add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue' ) );
        
        // Migrate get_theme_mod to get_option
        add_action( 'init', array( $this, 'migrate' ) );
        
    }
    
    /**
     * Migrate Old Options
     *
     * @since 2.0.1
     */
    function migrate() {
        
        if ( get_option( 'withemes_migrated' ) ) return;
        
        // Same Options
        $options = array(
            'container_width', 'sidebar_position', 'logo', 'logo_width', 'logo_padding_top', 'logo_padding_bottom', 'footer_logo', 'footer_logo_width', 'copyright', 'body_font', 'heading_font', 'nav_font', 'body_custom_font', 'heading_custom_font', 'nav_custom_font', 'head_code', 
        );
        
        $social_arr = withemes_social_array();
        foreach ( $social_arr as $s => $c ):
        
        $options[] = 'social_' . $s;
        
        endforeach;
        
        $options[] = 'custom_css';
        
        foreach ( $options as $option ) {
            $mod = get_theme_mod( 'withemes_' . $option );
            if ( $mod ) update_option( 'withemes_' . $option, $mod );
        }
        
        // Difference in prefix
        $options = array(
            'link_color', 'selection_color', 
        );
        
        foreach ( $options as $option ) {
            $mod = get_theme_mod( $option );
            if ( $mod ) update_option( 'withemes_' . $option, $mod );
        }
        
        // Difference in name
        $options = array(
            'withemes_text_color'    => 'withemes_site_text_color',
            'withemes_accent_color' => 'withemes_accent',
        );
        
        foreach ( $options as $old => $new ) {
            $mod = get_theme_mod( $old );
            if ( $mod ) update_option( $new, $mod );
        }
    
        update_option( 'withemes_migrated', true );
        
    }
    
    /**
     * Returns an array of all panels
     *
     * @since 2.0
     */
    public function panels() {
        
        $panel_arr = array();
        
        /* PANELS
        --------------------------------------------------------------- */
        $panel_arr[ 'style' ] = array(
            'title' => esc_html__( 'Style','simple-elegant' ),
            'priority' => 220,
        );
        $panel_arr[ 'typography' ] = array(
            'title' => esc_html__( 'Typography','simple-elegant' ),
            'priority' => 240,
        );
        
        return apply_filters( 'withemes_panels', $panel_arr );
        
    }
    
    /**
     * Returns an array of all sections
     *
     * @since 2.0
     */
    public function sections() {
        
        $section_arr = array();
        
        /* SECTIONS
        --------------------------------------------------------------- */
        $section_arr['concept'] = array(
            'title' => esc_html__('Select Concept','simple-elegant'),
            'priority' => 140,
        );
        $section_arr['general'] = array(
            'title' => esc_html__('General','simple-elegant'),
            'priority' => 150,
        );
        $section_arr['header'] = array(
            'title' => esc_html__('Header','simple-elegant'),
            'priority' => 160,
        );
        $section_arr['footer'] = array(
            'title' => esc_html__('Footer','simple-elegant'),
            'priority' => 170,
        );
        $section_arr['layout'] = array(
            'title' => esc_html__('Layout','simple-elegant'),
            'priority' => 180,
        );
        $section_arr['blog'] = array(
            'title' => esc_html__('Blog','simple-elegant'),
            'priority' => 200,
        );
        $section_arr['social'] = array(
            'title' => esc_html__('Social','simple-elegant'),
            'priority' => 300,
        );
        
        // STYLE
        //
        $section_arr['general_style'] = array(
            'title' => esc_html__('General','simple-elegant'),
            'panel' => 'style',
        );
        $section_arr['body_style'] = array(
            'title' => esc_html__('Body Text','simple-elegant'),
            'panel' => 'style',
        );
        $section_arr['topbar_style'] = array(
            'title' => esc_html__('Topbar','simple-elegant'),
            'panel' => 'style',
        );
        $section_arr['header_style'] = array(
            'title' => esc_html__('Header','simple-elegant'),
            'panel' => 'style',
        );
        $section_arr['nav_style'] = array(
            'title' => esc_html__('Main Menu','simple-elegant'),
            'panel' => 'style',
        );
        $section_arr['footer_style'] = array(
            'title' => esc_html__('Footer','simple-elegant'),
            'panel' => 'style',
        );
        
        // TYPOGRAPHY
        //
        $section_arr['typography'] = array(
            'panel' => 'typography', 
            'title' => esc_html__('Typography','simple-elegant'),
        );
        $section_arr['site_typography'] = array(
            'panel' => 'typography', 
            'title' => esc_html__('Body Text','simple-elegant'),
        );
        $section_arr['header_typography'] = array(
            'panel' => 'typography', 
            'title' => esc_html__('Header','simple-elegant'),
        );
        $section_arr['nav_typography'] = array(
            'panel' => 'typography', 
            'title' => esc_html__('Main Menu','simple-elegant'),
        );
        $section_arr['footer_typography'] = array(
            'panel' => 'typography', 
            'title' => esc_html__('Footer','simple-elegant'),
        );
        $section_arr['page_title_typography'] = array(
            'panel' => 'typography', 
            'title' => esc_html__('Page Title','simple-elegant'),
        );
        
        $section_arr['custom_css'] = array(
            'title' => esc_html__('Custom CSS','simple-elegant'),
            'priority' => 400,
        );
        
        return apply_filters( 'withemes_sections', $section_arr );
        
    }
    
    /**
     * Returns an array of all options
     *
     * @since 2.0
     */
    public function options() {
        
        $option_arr = array();
        
        /* Concept
        --------------------------------------------------------------------------------------------------*/
        $option_arr[ 'concept' ] = array(
            'name'=> esc_html__('Select Concept','simple-elegant'),
            'type' => 'radio',
            'section'=>'concept',
            'options' => array(
                'standard'      => esc_html__( 'Standard','simple-elegant'),
                'diy'           => esc_html__( 'Do It Yourself','simple-elegant'),
                'photography'   => esc_html__( 'Photography','simple-elegant'),
            ),
            'std' => 'standard',
            'transport' => 'postMessage',
            'desc' => esc_html__('Note that selecting concept may changes some options.','simple-elegant'),
        );
        
        $option_arr[] = array(
            'type' => 'html',
            'section'=>'concept',
            'std' => '<button class="button loadconcept">Load Concept</button>',
        );
        
        /* General
        --------------------------------------------------------------------------------------------------*/
        $option_arr[ 'container_width' ] = array(
            'name'=> esc_html__('Container width (px)','simple-elegant'),
            'type' => 'text',
            'placeholder' => '1020px',
            'section'=>'general',
            'desc' => esc_html__('Enter a number, the width of both content area + sidebar area. Default is 1020.','simple-elegant'),
        );
        
        $option_arr[ 'sidebar_position' ] = array(
            'name'=> esc_html__('Sidebar Default Position','simple-elegant'),
            'section'=>'general',
            'type' =>'select',
            'options' => array(
                'left' => esc_html__('Left','simple-elegant'),
                'right' => esc_html__('Right','simple-elegant'),
            ),
            'std' => 'right',
        );
        
        /* Header
        --------------------------------------------------------------------------------------------------*/
        $option_arr[] = array(
            'name'=> esc_html__('Topbar','simple-elegant'),
            'type' => 'heading',
            'section'=>'header',
        );
        
        $option_arr[ 'enable_topbar' ] = array(
            'name'=> esc_html__( 'Show Topbar','simple-elegant'),
            'type' => 'radio',
            'options' => withemes_enable_options(),
            'std' => 'true',
            'section'=>'header',
        );    
        
        $option_arr[ 'topbar_search' ] = array(
            'name'=> esc_html__('Topbar Searchbox?','simple-elegant'),
            'type' => 'radio',
            'options' => withemes_enable_options(),
            'std' => 'true',
            'section'=>'header',
        );
        
        $option_arr[ 'topbar_social' ] = array(
            'name'=> esc_html__('Topbar Social Icons?','simple-elegant'),
            'type' => 'radio',
            'options' => withemes_enable_options(),
            'std' => 'true',
            'section'=>'header',
        );
        
        $option_arr[] = array(
            'name'=> esc_html__('Main Header','simple-elegant'),
            'type' => 'heading',
            'section'=>'header',
        );
        
        $option_arr[ 'header_layout' ] = array(
            'name'=> esc_html__('Header Layout','simple-elegant'),
            'type' => 'radio',
            'options' => array(
                '1' => esc_html__( 'Center Logo', 'simple-elegant' ),
                '2' => esc_html__( 'Left Logo - Right Text', 'simple-elegant' ),
            ),
            'std' => '1',
            'section'=>'header',
        );
        
        $option_arr[ 'header_text' ] = array(
            'name'=> esc_html__('Header Text','simple-elegant'),
            'type' => 'textarea',
            'section'=>'header',
            'desc'=> esc_html__( 'Note that header text is only available for header layout 2.','simple-elegant' ),
        );
        
        $option_arr[ 'header_social' ] = array(
            'name'=> esc_html__('Show Header Social Icons','simple-elegant'),
            'type' => 'radio',
            'options' => withemes_enable_options(),
            'std' => 'false',
            'section'=>'header',
            'desc'=> esc_html__( 'Note that this option is only available for header layout 2.','simple-elegant' ),
        );
        
        $option_arr[] = array(
            'name'=> esc_html__('Logo','simple-elegant'),
            'type' => 'heading',
            'section'=>'header',
        );
        
        $option_arr[ 'logo' ] = array(
            'name'=> esc_html__('Upload your logo','simple-elegant'),
            'type' => 'image',
            'section'=>'header',
            'desc'=> esc_html__( 'If you want your logo looks sharp on Retina devices, please upload a bigger-size image. Sample logo size is 880px wide (real logo size is 440px).','simple-elegant')
        );
        
        $option_arr[ 'logo_width' ] = array(
            'name'=> esc_html__('Logo width','simple-elegant'),
            'type' => 'text',
            'section'=>'header',
            'desc'=> esc_html__('Enter a number. Default logo width is 440px.','simple-elegant'),
            
            'selector' => '#wi-logo img',
            'property' => 'width',
        );
        
        $option_arr[ 'logo_padding_top' ] = array(
            'name'=> esc_html__('Logo padding top','simple-elegant'),
            'type' => 'text',
            'section'=>'header',
            'desc'=> esc_html__('Enter a number, eg 10. Default logo padding top is 40px.','simple-elegant'),
            
            'selector' => '#logo-area',
            'property' => 'padding-top',
            'unit'  => 'px',
        );
        
        $option_arr[ 'logo_padding_bottom' ] = array(
            'name'=> esc_html__('Logo padding bottom','simple-elegant'),
            'type' => 'text',
            'section'=>'header',
            'desc'=> esc_html__('Enter a number, eg 50. Default logo padding bottom is 40px.','simple-elegant'),
            
            'selector' => '#logo-area',
            'property' => 'padding-bottom',
            'unit'  => 'px',
        );
        
        $option_arr[ 'header_tagline' ] = array(
            'name'=> esc_html__('Show tagline below logo?','simple-elegant'),
            'type' => 'radio',
            'options' => withemes_enable_options(),
            'std' => 'true',
            'section'=>'header',
        );
        
        /* Footer
        --------------------------------------------------------------------------------------------------*/
        $option_arr[ 'footer_bottom_layout' ] = array(
            'name'=> esc_html__('Footer bottom layout','simple-elegant'),
            'section'=>'footer',
            'type' =>'radio',
            
            'options' => array(
                'center' => esc_html__('Center','simple-elegant'),
                'sides' => esc_html__('Left &mdash; Right','simple-elegant'),
            ),
            'std' => 'center',
        );
        
        $option_arr[ 'footer_logo' ] = array(
            'name'=> esc_html__('Footer logo','simple-elegant'),
            'section'=>'footer',
            'type' =>'image',
        );
        
        $option_arr[ 'footer_logo_width' ] = array(
            'name'=> esc_html__('Footer logo width (px)','simple-elegant'),
            'section'=>'footer',
            'type' =>'text',
            
            'selector' => '#footer-logo img',
            'property' => 'width',
        );
        
        $option_arr[ 'enable_copyright' ] = array(
            'name'=> esc_html__('Show Copyright Text','simple-elegant'),
            'section'=>'footer',
            'type' =>'radio',
            'options' => withemes_enable_options(),
            'std' => 'true',
        );
        
        $option_arr[ 'copyright' ] = array(
            'name'=> esc_html__('Copyright text','simple-elegant'),
            'desc'=> esc_html__('You can use HTML & shortcodes. Use &gt;br /&lt; to enter a new line.','simple-elegant'),
            'section'=>'footer',
            'type' =>'textarea',
            'std' => '&copy; 2015 '.get_bloginfo('name').'. All rights reserved. Designed by <a href="http://withemes.com" target="_blank">Withemes</a>' 
        );
        
        $option_arr[ 'footer_social' ] = array(
            'name'=> esc_html__('Show footer social icons','simple-elegant'),
            'section'=>'footer',
            'type' =>'radio',
            'options' => withemes_enable_options(),
            'std' => 'true',
        );
        
        /* Layout
        --------------------------------------------------------------------------------------------------*/
        $option_arr[ 'layout' ] = array(
            'name'=> esc_html__('Site Layout','simple-elegant'),
            'section'=>'layout',
            'type' =>'radio',
            'options' => array(
                'wide' => esc_html__( 'Wide','simple-elegant' ),
                'boxed' => esc_html__( 'Boxed','simple-elegant' ),
            ),
            'std' => 'wide',
        );
        
        // BOXED BACKGROUND OPTIONS
        //
        $option_arr[] = array(
            'name'=> esc_html__('Boxed Background Options','simple-elegant'),
            'section'=>'layout',
            'type' =>'heading',
        );
        
        $option_arr[ 'body_background_color' ] = array(
            'name'=> esc_html__('Body Background Color','simple-elegant'),
            'section'=>'layout',
            'type' =>'color',
            
            'selector' => 'body.layout-boxed',
            'property' => 'background-color',
        );
        
        $option_arr[ 'body_background_image' ] = array(
            'name'=> esc_html__('Body Background Image','simple-elegant'),
            'section'=>'layout',
            'type' =>'image',
            
            'selector' => 'body.layout-boxed',
            'property' => 'background-image',
        );
        
        $option_arr[ 'body_background_repeat' ] = array(
            'name'=> esc_html__('Body Background Repeat','simple-elegant'),
            'section'=>'layout',
            'type' =>'radio',
            'options' => array(
                'no-repeat' => esc_html__( 'No Repeat','simple-elegant'),
                'repeat' => esc_html__( 'Repeat','simple-elegant'),
            ),
            'std' => 'no-repeat',
            
            'selector' => 'body.layout-boxed',
            'property' => 'background-repeat',
        );
        
        $option_arr[ 'body_background_size' ] = array(
            'name'=> esc_html__('Body Background Size','simple-elegant'),
            'section'=>'layout',
            'type' =>'radio',
            'options' => array(
                'cover' => esc_html__( 'Cover','simple-elegant'),
                'contain' => esc_html__( 'Contain','simple-elegant'),
                'auto' => esc_html__( 'Auto','simple-elegant'),
                '100% auto' => esc_html__( '100% Width','simple-elegant'),
            ),
            'std' => 'cover',
            
            'selector' => 'body.layout-boxed',
            'property' => 'background-size',
        );
        
        /* Panel Style
        --------------------------------------------------------------------------------------------------*/
        
        /* General Style
        --------------------- */
        $option_arr[ 'accent' ] = array(
            'name'=> esc_html__('Accent Color','simple-elegant'),
            'section'=>'general_style',
            'type' =>'color',
        );
        
        $option_arr[ 'accent_darker' ] = array(
            'name'=> esc_html__('Accent Darker Color','simple-elegant'),
            'desc'=> esc_html__( 'Accent darker color will be used for instance, button hover state.','simple-elegant'),
            'section'=>'general_style',
            'type' =>'color',
        );
        
        /* Body Style
        --------------------- */
        $option_arr[ 'site_text_color' ] = array(
            'name'=> esc_html__('Body Text Color','simple-elegant'),
            'section'=>'body_style',
            'type' =>'color',
            
            'selector' => 'body, input, textarea, button',
            'property' => 'color',
        );
        
        $option_arr[ 'link_color' ] = array(
            'name'=> esc_html__('Link Color','simple-elegant'),
            'section'=>'body_style',
            'type' =>'color',
            
            'selector' => 'a',
            'property' => 'color',
        );
        
        $option_arr[ 'link_hover_color' ] = array(
            'name'=> esc_html__('Link Hover Color','simple-elegant'),
            'section'=>'body_style',
            'type' =>'color',
            
            'selector' => 'a:hover',
            'property' => 'color',
        );
        
        $option_arr[ 'heading_color' ] = array(
            'name'=> esc_html__('Heading Text Color','simple-elegant'),
            'section'=>'body_style',
            'type' =>'color',
            
            'selector' => 'h1, h2, h3, h4, h5, h6',
            'property' => 'color',
        );
        
        /* Topbar
        --------------------- */
        $option_arr[ 'topbar_background' ] = array(
            'name'=> esc_html__('Topbar Background Color','simple-elegant'),
            'section'=>'topbar_style',
            'type' =>'color',
            
            'selector' => '#wi-topbar',
            'property' => 'background-color',
        );
        
        $option_arr[ 'topbar_border_bottom_color' ] = array(
            'name'=> esc_html__('Topbar Border Color','simple-elegant'),
            'section'=>'topbar_style',
            'type' =>'color',
            
            'selector' => '#wi-topbar',
            'property' => 'border-color',
        );
        
        $option_arr[] = array(
            'name'=> esc_html__('Topbar Menu','simple-elegant'),
            'section'=>'topbar_style',
            'type' =>'heading',
        );
        
        $option_arr[ 'topbarnav_color' ] = array(
            'name'=> esc_html__('Topbar Menu Item Color','simple-elegant'),
            'section'=>'topbar_style',
            'type' =>'color',
            
            'selector' => '#topbarnav .menu > ul > li > a',
            'property' => 'color',
        );
        
        $option_arr[ 'topbarnav_hover_color' ] = array(
            'name'=> esc_html__('Topbar Menu Item Hover Color','simple-elegant'),
            'section'=>'topbar_style',
            'type' =>'color',
            
            'selector' => '#topbarnav .menu > ul > li:hover > a',
            'property' => 'color',
        );
        
        $option_arr[ 'topbarnav_active_color' ] = array(
            'name'=> esc_html__( 'Topbar Menu Item Active Color','simple-elegant' ),
            'section'=>'topbar_style',
            'type' =>'color',
            
            'selector' => '#topbarnav .menu > ul > li.current-menu-item > a, #topbarnav .menu > ul > li.current-menu-ancestor > a',
            'property' => 'color',
        );
        
        $option_arr[ 'topbarnav_dropdown_background' ] = array(
            'name'=> esc_html__( 'Dropdown Background','simple-elegant' ),
            'section'=>'topbar_style',
            'type' =>'color',
            
            'selector' => '#topbarnav .menu ul ul',
            'property' => 'background-color',
        );
        
        $option_arr[ 'topbarnav_dropdown_border_color' ] = array(
            'name'=> esc_html__( 'Dropdown Border Color','simple-elegant' ),
            'section'=>'topbar_style',
            'type' =>'color',
            
            'selector' => '#topbarnav .menu ul ul',
            'property' => 'border-color',
        );
        
        $option_arr[ 'topbarnav_dropdown_border_width' ] = array(
            'name'=> esc_html__( 'Dropdown Border Width','simple-elegant' ),
            'section'=>'topbar_style',
            'type' =>'select',
            'options' => array(
                '' => esc_html__( 'Default', 'simple-elegant' ),
                '0' => esc_html__( 'None', 'simple-elegant' ),
                '1px' => '1px',
                '2px' => '2px',
                '3px' => '3px',
            ),
            'std' => '',
            
            'selector' => '#topbarnav .menu ul ul',
            'property' => 'border-width',
        );
        
        $option_arr[ 'topbarnav_dropdown_padding' ] = array(
            'name'=> esc_html__( 'Topbar Dropdown Padding','simple-elegant' ),
            'section'=>'topbar_style',
            'type' =>'text',
            'std' => '',
            
            'selector' => '#topbarnav .menu ul ul',
            'property' => 'padding',
        );
        
        $option_arr[ 'topbarnav_dropdown_color' ] = array(
            'name'=> esc_html__( 'Topbar Dropdown Item Color','simple-elegant' ),
            'section'=>'topbar_style',
            'type' =>'color',
            
            'selector' => '#topbarnav .menu ul ul a',
            'property' => 'color',
        );
        
        $option_arr[ 'topbarnav_dropdown_hover_color' ] = array(
            'name'=> esc_html__( 'Topbar Dropdown Item Hover Color','simple-elegant' ),
            'section'=>'topbar_style',
            'type' =>'color',
            
            'selector' => '#topbarnav .menu ul ul li:hover > a',
            'property' => 'color',
        );
        
        $option_arr[ 'topbarnav_dropdown_active_color' ] = array(
            'name'=> esc_html__( 'Topbar Dropdown Item Active Color','simple-elegant' ),
            'section'=>'topbar_style',
            'type' =>'color',
            
            'selector' => '#topbarnav .menu ul ul li.current-menu-item a',
            'property' => 'color',
        );
        
        // Social Icons
        $option_arr[] = array(
            'name'=> esc_html__( 'Topbar Social Icons','simple-elegant'),
            'section'=>'topbar_style',
            'type' =>'heading',
        );
        
        $option_arr[ 'topbar_social_color' ] = array(
            'name'=> esc_html__( 'Topbar Social Icon Color','simple-elegant' ),
            'section'=>'topbar_style',
            'type' =>'color',
            
            'selector' => '#wi-topbar .social-list ul a',
            'property' => 'color',
        );
        
        $option_arr[ 'topbar_social_hover_color' ] = array(
            'name'=> esc_html__( 'Topbar Social Icon Hover Color','simple-elegant' ),
            'section'=>'topbar_style',
            'type' =>'color',
            
            'selector' => '#wi-topbar .social-list ul a:hover',
            'property' => 'color',
        );
        
        /* Header
        --------------------- */
        $option_arr[ 'header_background' ] = array(
            'name'=> esc_html__( 'Header Background','simple-elegant'),
            'section'=>'header_style',
            'type' =>'color',
            
            'selector' => '#logo-area',
            'property' => 'background-color',
        );
        
        $option_arr[ 'header_background_image' ] = array(
            'name'=> esc_html__( 'Header Background Image','simple-elegant'),
            'desc'=> esc_html__( 'You should provide a 1920px wide image. Keep it\'s size smaller than 200KB to speed up site loading time.','simple-elegant'),
            'section'=>'header_style',
            'type' =>'image',
            
            'selector' => '#logo-area',
            'property' => 'background-image',
        );
        
        $option_arr[] = array(
            'name'=> esc_html__( 'Tagline','simple-elegant'),
            'section'=>'header_style',
            'type' =>'heading',
        );
        
        $option_arr[ 'tagline_color' ] = array(
            'name'=> esc_html__( 'Tagline Text Color','simple-elegant' ),
            'section'=>'header_style',
            'type' =>'color',
            
            'selector' => '#wi-tagline',
            'property' => 'color',
        );
        
        $option_arr[] = array(
            'name'=> esc_html__( 'Header Text','simple-elegant'),
            'section'=>'header_style',
            'type' =>'heading',
        );
        
        $option_arr[ 'header_text_color' ] = array(
            'name'=> esc_html__( 'Header Text Color','simple-elegant' ),
            'section'=>'header_style',
            'type' =>'color',
            
            'selector' => '.header-text',
            'property' => 'color',
        );
        
        $option_arr[] = array(
            'name'=> esc_html__( 'Header Social Icons','simple-elegant'),
            'section'=>'header_style',
            'type' =>'heading',
        );
        
        $option_arr[ 'header_social_icon_background' ] = array(
            'name'=> esc_html__( 'Header Social Icon Background','simple-elegant' ),
            'section'=>'header_style',
            'type' =>'color',
            
            'selector' => '.header-2 #logo-area .social-list a',
            'property' => 'background-color',
        );
        
        $option_arr[ 'header_social_icon_color' ] = array(
            'name'=> esc_html__( 'Header Social Icon Color','simple-elegant' ),
            'section'=>'header_style',
            'type' =>'color',
            
            'selector' => '.header-2 #logo-area .social-list a',
            'property' => 'color',
        );
        
        $option_arr[ 'header_social_icon_hover_background' ] = array(
            'name'=> esc_html__( 'Header Social Icon Hover Background','simple-elegant' ),
            'section'=>'header_style',
            'type' =>'color',
            
            'selector' => '.header-2 #logo-area .social-list a:hover',
            'property' => 'background-color',
        );
        
        $option_arr[ 'header_social_icon_hover_color' ] = array(
            'name'=> esc_html__( 'Header Social Icon Hover Color','simple-elegant' ),
            'section'=>'header_style',
            'type' =>'color',
            
            'selector' => '.header-2 #logo-area .social-list a:hover',
            'property' => 'color',
        );
        
        /* Main Navigation
        --------------------- */
        $option_arr[ 'mainnav_border' ] = array(
            'name'=> esc_html__( 'Main Navigation Border','simple-elegant' ),
            'section'   =>'nav_style',
            'type'      =>'radio',
            'options'   => array(
                '1px 0' => esc_html__( 'Top & Bottom','simple-elegant' ),
                '1px 0 0' => esc_html__( 'Only Top','simple-elegant' ),
                '0 0 1px' => esc_html__( 'Only Bottom','simple-elegant' ),
                '0' => esc_html__( 'None','simple-elegant' ),
            ),
            'std'       => '1px 0',
            
            'selector' => '#wi-mainnav.mainnav-border-fullwidth, #wi-mainnav.mainnav-border-container .container',
            'property' => 'border-width',
        );
        
        $option_arr[ 'mainnav_border_length' ] = array(
            'name'=> esc_html__( 'Main Navigation Border Width','simple-elegant' ),
            'section'   =>'nav_style',
            'type'      =>'radio',
            'options'   => array(
                'container' => esc_html__( 'Content Width','simple-elegant' ),
                'fullwidth' => esc_html__( 'Screen Width','simple-elegant' ),
            ),
            'std'       => 'container',
        );
        
        $option_arr[ 'mainnav_border_color' ] = array(
            'name'=> esc_html__( 'Main Navigation Border Color','simple-elegant' ),
            'section'   =>'nav_style',
            'type'      =>'color',
            
            'selector'  => '#wi-mainnav, #wi-mainnav .container',
            'property'  => 'border-color',
        );
        
        $option_arr[ 'mainnav_background' ] = array(
            'name'=> esc_html__( 'Main Navigation Background','simple-elegant' ),
            'section'   =>'nav_style',
            'type'      =>'color',
            
            'selector'  => '#wi-mainnav, #wi-mainnav.before-sticky',
            'property'  => 'background-color',
        );
        
        $option_arr[ 'mainnav_color' ] = array(
            'name'=> esc_html__( 'Menu Item Color','simple-elegant' ),
            'section'=>'nav_style',
            'type' =>'color',
            
            'selector' => '#wi-mainnav .menu > ul > li > a, .header-cart a',
            'property' => 'color',
        );
        
        $option_arr[ 'mainnav_hover_color' ] = array(
            'name'=> esc_html__( 'Menu Item Hover Color','simple-elegant' ),
            'section'=>'nav_style',
            'type' =>'color',
            
            'selector' => '#wi-mainnav .menu > ul > li:hover > a, .header-cart a:hover',
            'property' => 'color',
        );
        
        $option_arr[ 'mainnav_active_color' ] = array(
            'name'=> esc_html__( 'Menu Item Active Color','simple-elegant' ),
            'section'=>'nav_style',
            'type' =>'color',
            
            'selector' => '#wi-mainnav .menu > ul > li.current-menu-item > a, #wi-mainnav .menu > ul > li.current-menu-ancestor > a',
            'property' => 'color',
        );
        
        $option_arr[ 'mainnav_submenu_caret_color' ] = array(
            'name'=> esc_html__( 'Menu Item Submenu Caret Color','simple-elegant' ),
            'section'=>'nav_style',
            'type' =>'color',
            
            'selector' => '#wi-mainnav .menu > ul > li.menu-item-has-children > a:after',
            'property' => 'color',
        );
        
        // DROPDOWN
        //
        $option_arr[] = array(
            'name'=> esc_html__( 'Dropdown','simple-elegant' ),
            'section'=>'nav_style',
            'type' =>'heading',
        );
        
        $option_arr[ 'mainnav_dropdown_background' ] = array(
            'name'=> esc_html__( 'Dropdown Background Color','simple-elegant' ),
            'section'=>'nav_style',
            'type' =>'color',
            
            'selector' => '#wi-mainnav .menu > ul ul',
            'property' => 'background-color',
        );
        
        $option_arr[ 'mainnav_dropdown_padding' ] = array(
            'name'=> esc_html__( 'Dropdown Padding','simple-elegant' ),
            'section'=>'nav_style',
            'type' =>'text',
            
            'selector' => '#wi-mainnav .menu > ul ul',
            'property' => 'padding',
        );
        
        $option_arr[ 'mainnav_dropdown_border_width' ] = array(
            'name'=> esc_html__( 'Dropdown Border','simple-elegant' ),
            'section'=>'nav_style',
            'type' =>'select',
            'options' => array(
                '' => esc_html__( 'Default', 'simple-elegant' ),
                '0' => esc_html__( 'None', 'simple-elegant' ),
                '1px' => '1px',
                '2px' => '2px',
                '3px' => '3px',
            ),
            'std' => '',
            
            'selector' => '#wi-mainnav .menu > ul ul',
            'property' => 'border-width',
        );
        
        $option_arr[ 'mainnav_submenu_border_color' ] = array(
            'name'=> esc_html__( 'Dropdown Border Color','simple-elegant' ),
            'section'=>'nav_style',
            'type' =>'color',
            
            'selector' => '#wi-mainnav .menu > ul ul',
            'property' => 'border-color',
        );
        
        $option_arr[ 'mainnav_submenu_item_color' ] = array(
            'name'=> esc_html__( 'Submenu Item Color','simple-elegant' ),
            'section'=>'nav_style',
            'type' =>'color',
            
            'selector' => '#wi-mainnav .menu > ul ul > li > a',
            'property' => 'color',
        );
        
        $option_arr[ 'mainnav_submenu_item_hover_color' ] = array(
            'name'=> esc_html__( 'Submenu Item Hover Color','simple-elegant' ),
            'section'=>'nav_style',
            'type' =>'color',
            
            'selector' => '#wi-mainnav .menu > ul ul > li > a:hover',
            'property' => 'color',
        );
        
        $option_arr[ 'mainnav_submenu_item_active_color' ] = array(
            'name'=> esc_html__( 'Submenu Item Active Color','simple-elegant' ),
            'section'=>'nav_style',
            'type' =>'color',
            
            'selector' => '#wi-mainnav .menu > ul ul > li.current-menu-item > a, #wi-mainnav .menu > ul ul > li.current-menu-ancestor > a',
            'property' => 'color',
        );
        
        $option_arr[ 'mainnav_submenu_mega_item_leading' ] = array(
            'name'=> esc_html__( 'Submenu Mega Leading Item Color','simple-elegant' ),
            'section'=>'nav_style',
            'type' =>'color',
            
            'selector' => '#wi-mainnav .menu > ul > li.mega > ul > li > a',
            'property' => 'color',
        );
        
        /* Footer
        --------------------- */
        $option_arr[ 'footer_theme' ] = array(
            'name'=> esc_html__( 'Footer Theme','simple-elegant' ),
            'section'=>'footer_style',
            'type' =>'radio',
            'options' => array(
                'light' => esc_html__( 'Light','simple-elegant' ),
                'dark' => esc_html__( 'Dark','simple-elegant' ),
            ),
            'std' => 'light',
        );
        
        $option_arr[] = array(
            'name'=> esc_html__( 'Footer Widgets Area','simple-elegant' ),
            'section'=>'footer_style',
            'type' =>'heading',
        );
        
        $option_arr[ 'footer_widgets_padding_top' ] = array(
            'name'=> esc_html__( 'Footer Widgets Area Padding Top','simple-elegant' ),
            'section'=>'footer_style',
            'type' =>'text',
            
            'selector' => '#footer-widgets',
            'property' => 'padding-top',
            'unit' => 'px',
        );
        
        $option_arr[ 'footer_widgets_padding_bottom' ] = array(
            'name'=> esc_html__( 'Footer Widgets Area Padding Bottom','simple-elegant' ),
            'section'=>'footer_style',
            'type' =>'text',
            
            'selector' => '#footer-widgets',
            'property' => 'padding-bottom',
            'unit' => 'px',
        );
        
        $option_arr[ 'footer_widgets_border' ] = array(
            'name'=> esc_html__( 'Footer Widgets Area Border Color','simple-elegant' ),
            'desc' => esc_html__( 'This option is only applied for footer light','simple-elegant' ),
            'section'=>'footer_style',
            'type' =>'color',
            
            'selector' => '#footer-widgets',
            'property' => 'border-color',
        );
        
        $option_arr[ 'footer_widgets_background' ] = array(
            'name'=> esc_html__( 'Footer Widgets Area Background','simple-elegant' ),
            'section'=>'footer_style',
            'type' =>'color',
            
            'selector' => '#wi-footer #footer-widgets',
            'property' => 'background-color',
        );
        
        $option_arr[ 'footer_widgets_text_color' ] = array(
            'name'=> esc_html__( 'Footer Widgets Text Color','simple-elegant' ),
            'section'=>'footer_style',
            'type' =>'color',
            
            'selector' => '#wi-footer #footer-widgets',
            'property' => 'color',
        );
        
        $option_arr[] = array(
            'name'=> esc_html__( 'Footer Copyright Area','simple-elegant' ),
            'section'=>'footer_style',
            'type' =>'heading',
        );
        
        $option_arr[ 'footer_bottom_padding_top' ] = array(
            'name'=> esc_html__( 'Footer Bottom Padding Top','simple-elegant' ),
            'section'=>'footer_style',
            'type' =>'text',
            
            'selector' => '#footer-bottom',
            'property' => 'padding-top',
            'unit' => 'px',
        );
        
        $option_arr[ 'footer_bottom_padding_bottom' ] = array(
            'name'=> esc_html__( 'Footer Bottom Padding Bottom','simple-elegant' ),
            'section'=>'footer_style',
            'type' =>'text',
            
            'selector' => '#footer-bottom',
            'property' => 'padding-bottom',
            'unit' => 'px',
        );
        
        $option_arr[ 'footer_bottom_border' ] = array(
            'name'=> esc_html__( 'Footer Bottom Border','simple-elegant' ),
            'desc' => esc_html__( 'This option is only applied for footer light','simple-elegant' ),
            'section'=>'footer_style',
            'type' =>'color',
            
            'selector' => '#footer-bottom',
            'property' => 'border-color',
        );
        
        $option_arr[ 'footer_bottom_background' ] = array(
            'name'=> esc_html__( 'Footer Bottom Background','simple-elegant' ),
            'section'=>'footer_style',
            'type' =>'color',
            
            'selector' => '#wi-footer #footer-bottom',
            'property' => 'background-color',
        );
        
        // Widget Title
        //
        $option_arr[] = array(
            'name'=> esc_html__( 'Footer Widget Title','simple-elegant' ),
            'section'=>'footer_style',
            'type' =>'heading',
        );
        
        $option_arr[ 'footer_widget_title_color' ] = array(
            'name'=> esc_html__( 'Footer Widget Title Color','simple-elegant' ),
            'section'=>'footer_style',
            'type' =>'color',
            
            'selector' => '#footer-widgets .widget-title',
            'property' => 'color',
        );
        
        // Copyright Text
        //
        $option_arr[] = array(
            'name'=> esc_html__( 'Copyright Text','simple-elegant' ),
            'section'=>'footer_style',
            'type' =>'heading',
        );
        
        $option_arr[ 'copyright_color' ] = array(
            'name'=> esc_html__( 'Copyright Text Color','simple-elegant' ),
            'section'=>'footer_style',
            'type' =>'color',
            
            'selector' => '#wi-copyright',
            'property' => 'color',
        );
        
        $option_arr[ 'copyright_link_color' ] = array(
            'name'=> esc_html__( 'Copyright Link Color','simple-elegant' ),
            'section'=>'footer_style',
            'type' =>'color',
            
            'selector' => '#wi-copyright a',
            'property' => 'color',
        );
        
        // Social Icons
        //
        $option_arr[] = array(
            'name'=> esc_html__( 'Footer Social Icons','simple-elegant' ),
            'section'=>'footer_style',
            'type' =>'heading',
        );
        
        $option_arr[ 'footer_social_size' ] = array(
            'name'=> esc_html__( 'Icon Size','simple-elegant' ),
            'section'=>'footer_style',
            'type' =>'text',
            'placeholder' => '32px',
        );
        
        $option_arr[ 'footer_social_font_size' ] = array(
            'name'=> esc_html__( 'Icon Font Size','simple-elegant' ),
            'section'=>'footer_style',
            'type' =>'text',
            
            'selector' => '#footer-bottom .social-list ul li a',
            'property' => 'font-size',
            'placeholder' => '14px',
        );
        
        $option_arr[ 'footer_social_color' ] = array(
            'name'=> esc_html__( 'Icon Color','simple-elegant' ),
            'section'=>'footer_style',
            'type' =>'color',
            
            'selector' => '#footer-bottom .social-list ul li a',
            'property' => 'color',
        );
        
        $option_arr[ 'footer_social_background' ] = array(
            'name'=> esc_html__( 'Icon Background','simple-elegant' ),
            'section'=>'footer_style',
            'type' =>'color',
            
            'selector' => '#footer-bottom .social-list ul li a',
            'property' => 'background-color',
        );
        
        $option_arr[ 'footer_social_border' ] = array(
            'name'=> esc_html__( 'Icon Border','simple-elegant' ),
            'section'=>'footer_style',
            'type' =>'color',
            
            'selector' => '#footer-bottom .social-list ul li a',
            'property' => 'border-color',
        );
        
        $option_arr[ 'footer_social_hover_color' ] = array(
            'name'=> esc_html__( 'Icon Hover Color','simple-elegant' ),
            'section'=>'footer_style',
            'type' =>'color',
            
            'selector' => '#footer-bottom .social-list ul li a:hover',
            'property' => 'color',
        );
        
        $option_arr[ 'footer_social_hover_background' ] = array(
            'name'=> esc_html__( 'Icon Hover Background','simple-elegant' ),
            'section'=>'footer_style',
            'type' =>'color',
            
            'selector' => '#footer-bottom .social-list ul li a:hover',
            'property' => 'background-color',
        );
        
        $option_arr[ 'footer_social_hover_border' ] = array(
            'name'=> esc_html__( 'Icon Hover Border','simple-elegant' ),
            'section'=>'footer_style',
            'type' =>'color',
            
            'selector' => '#footer-bottom .social-list ul li a:hover',
            'property' => 'border-color',
        );
        
        /* Blog Panel
        --------------------------------------------------------------------------------------------------*/
        $option_arr[ 'blog_layout' ] = array(
            'name'=> esc_html__( 'Blog Layout','simple-elegant' ),
            'section'=>'blog',
            'type' =>'radio',
            'options' => array(
                'standard' => esc_html__( 'Standard','simple-elegant' ),
                'grid' => esc_html__( 'Grid','simple-elegant' ),
                'list' => esc_html__( 'List','simple-elegant' ),
            ),
            'std' => 'standard',
        );
        
        $option_arr[ 'archive_layout' ] = array(
            'name'=> esc_html__( 'Archive Layout','simple-elegant' ),
            'section'=>'blog',
            'type' =>'radio',
            'options' => array(
                '' => esc_html__( 'Inherit','simple-elegant' ),
                'standard' => esc_html__( 'Standard','simple-elegant' ),
                'grid' => esc_html__( 'Grid','simple-elegant' ),
                'list' => esc_html__( 'List','simple-elegant' ),
            ),
            'std' => '',
        );
        
        $option_arr[ 'excerpt_length' ] = array(
            'name'=> esc_html__( 'Excerpt Length','simple-elegant' ),
            'desc'=> esc_html__( 'Please enter a number. Excerpt length will be used in blog grid & list layout.','simple-elegant' ),
            'section'=>'blog',
            'type' =>'text',
            'placeholder' => '24',
        );
        
        /* Typography
        --------------------------------------------------------------------------------------------------*/
        $types = array(
            'body'=> esc_html__('Body text','simple-elegant'),
            'heading' => esc_html__('Heading text','simple-elegant'),
            'nav' => esc_html__('Menu','simple-elegant'),
        );
        $default_fonts = array(
            'body'          =>  'Open Sans',
            'heading'       =>  'PT Serif',
            'nav'           =>  'PT Serif',
        );
        
        $google_fonts = withemes_google_fonts();
        $google_fonts = array_keys($google_fonts);
        $font_array = array('' => esc_html__('Select Font', 'simple-elegant') );
        foreach ($google_fonts as $font) {
            $font_array[$font] = $font;
        }
        
        foreach ($types as $type => $element ) {
            
            // Google Font
            $option_arr[ $type . '_font' ] = array(
                'name'=> sprintf( esc_html__('Select Google Font for %s','simple-elegant') , $element ),
                'section'=> 'typography',
                'type' =>'select',
                'options' => $font_array,
                'std' => $default_fonts[$type],
            );
            
            // Font Name
            $option_arr[ $type . '_custom_font' ] = array(
                'name'=> sprintf( esc_html__('Enter custom font name for %s', 'simple-elegant') , $element ),
                'section'=> 'typography',
                'type' =>'text',
                'desc' => esc_html__('If you enter your custom font name, Google Font will be ignored','simple-elegant'),
            );
            
        } // foreach
        
        $option_arr[ 'head_code' ] = array(
            'name'=> esc_html__('Head Code','simple-elegant'),
            'section'=>'typography',
            'type' =>'textarea',
            'std' => '',
            'desc' => esc_html__('Use this section to enqueue Font Scripts (or any script inside &lt;head&gt; tag) if you don\'t use Google Fonts','simple-elegant'),
        );
        
        /* Site Text
        ------------------------------ */
        $option_arr[ 'body_font_size' ] = array(
            'name'=> esc_html__( 'Body Text Font Size','simple-elegant'),
            'type' =>'text',
            'placeholder' => '13px',
            'section' => 'site_typography',
            
            'selector' => 'body, input, textarea, button',
            'property' => 'font-size',
        );
        
        $option_arr[ 'body_line_height' ] = array(
            'name'=> esc_html__( 'Body Text Line Height','simple-elegant'),
            'type' =>'text',
            'placeholder' => '1.84615385',
            'section' => 'site_typography',
            
            'selector' => 'body, input, textarea, button',
            'property' => 'line-height',
        );
        
        // Heading
        //
        $option_arr[] = array(
            'name'=> esc_html__( 'Heading','simple-elegant'),
            'type' =>'heading',
            'section' => 'site_typography',
        );
        
        $option_arr[ 'heading_font_weight' ] = array(
            'name'=> esc_html__( 'Heading Font Weight','simple-elegant'),
            'type' =>'select',
            'options' => withemes_font_weight_options(),
            'std' => '',
            'section' => 'site_typography',
            
            'selector' => 'h1, h2, h3, h4, h5, h6',
            'property' => 'font-weight',
        );
        
        $option_arr[ 'heading_font_style' ] = array(
            'name'=> esc_html__( 'Heading Font Style','simple-elegant'),
            'type' =>'radio',
            'options' => withemes_font_style_options(),
            'std' => 'normal',
            'section' => 'site_typography',
            
            'selector' => 'h1, h2, h3, h4, h5, h6',
            'property' => 'font-style',
        );
        
        $option_arr[ 'heading_text_transform' ] = array(
            'name'=> esc_html__( 'Heading Text Transform','simple-elegant'),
            'type' =>'select',
            'options' => withemes_text_transform_options(),
            'std' => '',
            'section' => 'site_typography',
            
            'selector' => 'h1, h2, h3, h4, h5, h6',
            'property' => 'text-transform',
        );
        
        $option_arr[ 'heading_letter_spacing' ] = array(
            'name'=> esc_html__( 'Heading Letter Spacing','simple-elegant'),
            'type' =>'text',
            'placeholder' => 'Eg. 1px',
            'section' => 'site_typography',
            
            'selector' => 'h1, h2, h3, h4, h5, h6',
            'property' => 'letter-spacing',
        );
        
        $headings = array( 32, 28, 22, 18, 16, 16 );
        
        for ( $i = 1; $i <=6; $i++ ) :
        
        $option_arr[ 'h' . $i . '_font_size' ] = array(
            'name'=> sprintf( esc_html__( '%s font size','simple-elegant'), "H{$i}" ),
            'type' =>'text',
            'placeholder' => $headings[ $i - 1 ] . 'px',
            'section' => 'site_typography',
            
            'selector' => 'h' . $i,
            'property' => 'font-size',
        );
        
        endfor;
        
        /* Header
        ------------------------------ */
        $option_arr[] = array(
            'name'=> esc_html__( 'Tagline','simple-elegant'),
            'type' =>'heading',
            'section' => 'header_typography',
        );
        
        $option_arr[ 'tagline_font' ] = array(
            'name'=> esc_html__( 'Tagline Font','simple-elegant'),
            'type' =>'radio',
            'options' => withemes_font_options(),
            'std' => 'heading',
            'section' => 'header_typography',
            
            'selector' => '#wi-tagline',
            'property' => 'font-family',
        );
        
        $option_arr[ 'tagline_font_size' ] = array(
            'name'=> esc_html__( 'Tagline Font Size','simple-elegant'),
            'type' =>'text',
            'placeholder' => '12px',
            'section' => 'header_typography',
            
            'selector' => '#wi-tagline',
            'property' => 'font-size',
        );
        
        $option_arr[ 'tagline_font_style' ] = array(
            'name'=> esc_html__( 'Tagline Font Style','simple-elegant'),
            'type' =>'radio',
            'options' => withemes_font_style_options(),
            'std' => 'normal',
            'section' => 'header_typography',
            
            'selector' => '#wi-tagline',
            'property' => 'font-style',
        );
        
        $option_arr[ 'tagline_font_weight' ] = array(
            'name'=> esc_html__( 'Tagline Font Weight','simple-elegant'),
            'type' =>'select',
            'options' => withemes_font_weight_options(),
            'std' => '',
            'section' => 'header_typography',
            
            'selector' => '#wi-tagline',
            'property' => 'font-weight',
        );
        
        $option_arr[ 'tagline_text_transform' ] = array(
            'name'=> esc_html__( 'Tagline Text Transform','simple-elegant'),
            'type' =>'select',
            'options' => withemes_text_transform_options(),
            'std' => '',
            'section' => 'header_typography',
            
            'selector' => '#wi-tagline',
            'property' => 'text-transform',
        );
        
        $option_arr[ 'tagline_letter_spacing' ] = array(
            'name'=> esc_html__( 'Tagline Letter Spacing','simple-elegant'),
            'type' =>'text',
            'placeholder' => '2px',
            'section' => 'header_typography',
            
            'selector' => '#wi-tagline',
            'property' => 'letter-spacing',
        );
        
        // Header Text
        //
        $option_arr[] = array(
            'name'=> esc_html__( 'Header Text','simple-elegant'),
            'type' =>'heading',
            'section' => 'header_typography',
        );
        
        $option_arr[ 'header_text_font_size' ] = array(
            'name'=> esc_html__( 'Header Text Font Size','simple-elegant'),
            'desc'=> esc_html__( 'Header text is only available in header layout 2.','simple-elegant'),
            'type' =>'text',
            'placeholder' => 'Eg. 12px',
            'section' => 'header_typography',
            
            'selector' => '.header-text',
            'property' => 'font-size',
        );
        
        /* Navigation
        ------------------------------ */
        $option_arr[ 'nav_font_size' ] = array(
            'name'=> esc_html__( 'Navigation Item Font Size','simple-elegant'),
            'type' =>'text',
            'placeholder' => '12px',
            'section' => 'nav_typography',
            
            'selector' => '#wi-mainnav .menu > ul > li > a',
            'property' => 'font-size',
        );
        
        $option_arr[ 'nav_font_style' ] = array(
            'name'=> esc_html__( 'Navigation Item Font Style','simple-elegant'),
            'type' =>'radio',
            'options' => withemes_font_style_options(),
            'std' => 'normal',
            'section' => 'nav_typography',
            
            'selector' => '#wi-mainnav .menu > ul > li > a',
            'property' => 'font-style',
        );
        
        $option_arr[ 'nav_font_weight' ] = array(
            'name'=> esc_html__( 'Navigation Item Font Weight','simple-elegant'),
            'type' =>'select',
            'options' => withemes_font_weight_options(),
            'std' => '',
            'section' => 'nav_typography',
            
            'selector' => '#wi-mainnav .menu > ul > li > a',
            'property' => 'font-weight',
        );
        
        $option_arr[ 'nav_text_transform' ] = array(
            'name'=> esc_html__( 'Navigation Text Transform','simple-elegant'),
            'type' =>'select',
            'options' => withemes_text_transform_options(),
            'std' => '',
            'section' => 'nav_typography',
            
            'selector' => '#wi-mainnav .menu > ul > li > a',
            'property' => 'text-transform',
        );
        
        $option_arr[ 'nav_letter_spacing' ] = array(
            'name'=> esc_html__( 'Navigation Letter Spacing','simple-elegant'),
            'type' =>'text',
            'placeholder' => '2px',
            'section' => 'nav_typography',
            
            'selector' => '#wi-mainnav .menu > ul > li > a',
            'property' => 'letter-spacing',
        );
        
        // Submenu
        //
        $option_arr[] = array(
            'name'=> esc_html__( 'Navigation Dropdown','simple-elegant'),
            'type' =>'heading',
            'section' => 'nav_typography',
        );
        
        $option_arr[ 'nav_dropdown_font_size' ] = array(
            'name'=> esc_html__( 'Dropdown Font Size','simple-elegant'),
            'type' =>'text',
            'placeholer' => '14px',
            'section' => 'nav_typography',
            
            'selector' => '#wi-mainnav .menu > ul ul li > a',
            'property' => 'font-size',
        );
        
        $option_arr[ 'nav_dropdown_font_weight' ] = array(
            'name'=> esc_html__( 'Dropdown Font Weight','simple-elegant'),
            'type' =>'select',
            'options' => withemes_font_weight_options(),
            'std' => '',
            'section' => 'nav_typography',
            
            'selector' => '#wi-mainnav .menu > ul ul li > a',
            'property' => 'font-weight',
        );
        
        $option_arr[ 'nav_dropdown_font_style' ] = array(
            'name'=> esc_html__( 'Dropdown Font Style','simple-elegant'),
            'type' =>'select',
            'options' => withemes_font_style_options(),
            'std' => 'normal',
            'section' => 'nav_typography',
            
            'selector' => '#wi-mainnav .menu > ul ul li > a',
            'property' => 'font-style',
        );
        
        $option_arr[ 'nav_dropdown_text_transform' ] = array(
            'name'=> esc_html__( 'Dropdown Text Transform','simple-elegant'),
            'type' =>'select',
            'options' => withemes_text_transform_options(),
            'std' => '',
            'section' => 'nav_typography',
            
            'selector' => '#wi-mainnav .menu > ul ul li > a',
            'property' => 'text-transform',
        );
        
        $option_arr[ 'nav_dropdown_letter_spacing' ] = array(
            'name'=> esc_html__( 'Dropdown Letter Spacing','simple-elegant'),
            'type' =>'text',
            'section' => 'nav_typography',
            
            'selector' => '#wi-mainnav .menu > ul ul li > a',
            'property' => 'letter-spacing',
        );
        
        /* Footer
        ------------------------------ */
        // Footer Widgets
        $option_arr[] = array(
            'name'=> esc_html__( 'Footer Widget','simple-elegant'),
            'type' =>'heading',
            'section' => 'footer_typography',
        );
        
        $option_arr[ 'footer_widget_font_size' ] = array(
            'name'=> esc_html__( 'Footer Widget Font Size','simple-elegant'),
            'type' =>'text',
            'section' => 'footer_typography',
            
            'selector' => '#footer-widgets',
            'property' => 'font-size',
        );
        
        // Copyright Text
        $option_arr[] = array(
            'name'=> esc_html__( 'Copyright Text','simple-elegant'),
            'type' =>'heading',
            'section' => 'footer_typography',
        );
        
        $option_arr[ 'copyright_font' ] = array(
            'name'=> esc_html__( 'Copyright Font','simple-elegant'),
            'type' =>'radio',
            'options' => withemes_font_options(),
            'std' => 'body',
            'section' => 'footer_typography',
            
            'selector' => '#wi-copyright',
            'property' => 'font-family',
        );
        
        $option_arr[ 'copyright_font_size' ] = array(
            'name'=> esc_html__( 'Copyright Font Size','simple-elegant'),
            'type' =>'text',
            'placeholder' => 'Eg. 12px',
            'section' => 'footer_typography',
            
            'selector' => '#wi-copyright',
            'property' => 'font-size',
        );
        
        $option_arr[ 'copyright_font_weight' ] = array(
            'name'=> esc_html__( 'Copyright Font Weight','simple-elegant'),
            'type' =>'select',
            'options' => withemes_font_weight_options(),
            'section' => 'footer_typography',
            
            'selector' => '#wi-copyright',
            'property' => 'font-weight',
        );
        
        $option_arr[ 'copyright_font_style' ] = array(
            'name'=> esc_html__( 'Copyright Font Style','simple-elegant'),
            'type' =>'radio',
            'options' => withemes_font_style_options(),
            'std' => 'normal',
            'section' => 'footer_typography',
            
            'selector' => '#wi-copyright',
            'property' => 'font-style',
        );
        
        $option_arr[ 'copyright_text_transform' ] = array(
            'name'=> esc_html__( 'Copyright Text Transform','simple-elegant'),
            'type' =>'select',
            'options' => withemes_text_transform_options(),
            'std' => '',
            'section' => 'footer_typography',
            
            'selector' => '#wi-copyright',
            'property' => 'text-transform',
        );
        
        $option_arr[ 'copyright_letter_spacing' ] = array(
            'name'=> esc_html__( 'Copyright Letter Spacing','simple-elegant'),
            'type' =>'text',
            'placeholder' => 'Eg. 1px',
            'section' => 'footer_typography',
            
            'selector' => '#wi-copyright',
            'property' => 'letter-spacing',
        );
        
        /* Page Title Typography
        ------------------------------ */
        $option_arr[ 'page_title_font' ] = array(
            'name'=> esc_html__( 'Page Title Font','simple-elegant'),
            'type' =>'radio',
            'options' => withemes_font_options(),
            'std' => 'heading',
            'section' => 'page_title_typography',
            
            'selector' => '.entry-title, .page-title',
            'property' => 'font-family',
        );
        
        $option_arr[ 'page_title_font_size' ] = array(
            'name'=> esc_html__( 'Page Title Font Size','simple-elegant'),
            'type' =>'text',
            'section' => 'page_title_typography',
            
            'selector' => '.page-title',
            'property' => 'font-size',
        );
        
        $option_arr[ 'page_title_font_weight' ] = array(
            'name'=> esc_html__( 'Page Title Font Weight','simple-elegant'),
            'type' =>'select',
            'options' => withemes_font_weight_options(),
            'section' => 'page_title_typography',
            
            'selector' => '.page-title',
            'property' => 'font-weight',
        );
        
        $option_arr[ 'page_title_font_style' ] = array(
            'name'=> esc_html__( 'Page Title Font Style','simple-elegant'),
            'type' =>'radio',
            'options' => withemes_font_style_options(),
            'std' => 'normal',
            'section' => 'page_title_typography',
            
            'selector' => '.page-title',
            'property' => 'font-style',
        );
        
        $option_arr[ 'page_title_text_transform' ] = array(
            'name'=> esc_html__( 'Page Title Text Transform','simple-elegant'),
            'type' =>'select',
            'options' => withemes_text_transform_options(),
            'std' => '',
            'section' => 'page_title_typography',
            
            'selector' => '.page-title',
            'property' => 'text-transform',
        );
        
        $option_arr[ 'page_title_letter_spacing' ] = array(
            'name'=> esc_html__( 'Page Title Letter Spacing','simple-elegant'),
            'type' =>'text',
            'std' => '',
            'section' => 'page_title_typography',
            
            'selector' => '.page-title',
            'property' => 'letter-spacing',
        );
        
        /* Social
        --------------------------------------------------------------------------------------------------*/
        $social_arr = withemes_social_array();
        foreach ($social_arr as $s => $c):
            $option_arr[ 'social_' . $s ] = array(
                'name'=> sprintf( esc_html__('%s URL','simple-elegant'), $c),
                'section'=>'social',
                'type' =>'text',
            );
        endforeach;
        
        /* Custom CSS
        --------------------------------------------------------------------------------------------------*/
        $option_arr[ 'custom_css' ] = array(
            'name'=> esc_html__('Custom CSS','simple-elegant'),
            'section'=>'custom_css',
            'type' =>'textarea',
        );
        
        return apply_filters( 'withemes_options', $option_arr );
        
    }
    
    /**
     * CSS & Javascript for customizer
     *
     * @since 2.0
     */
    public static function enqueue() {
        
        wp_enqueue_style( 'withemes-customizer', get_template_directory_uri() . '/css/admin/customizer.css' );
        
        wp_enqueue_script( 'withemes-customizer', 
            get_template_directory_uri() . '/js/admin/customizer.js', 
            array(
              'customize-controls', 
              'iris',
              'underscore',
              'wp-util',
            ), 
            null, 
            true );
        
        $customizer_js = array(
            'concepts' => self::instance()->concepts()
        );
        
        wp_localize_script( 'withemes-customizer' , 'WITHEMES_CUSTOMIZER', $customizer_js );
    
    }
    
    function concepts() {
        
        $prefix = self::$prefix;
        
        $concepts = array(
            'standard' => array(
                
                // Color
                'accent' => '#5EA7B1',
                'accent_darker' => '#3B8893',
                'site_text_color' => '#606060',
                'tagline_color' => '',
                'mainnav_border' => '1px 0',
                'mainnav_border_length' => 'container',
                'mainnav_border_color' => '#eaeaea',
                'footer_bottom_background' => '',
                'footer_social_size' => '',
                'footer_social_font_size' => '',
                'footer_social_color' => '',
                'footer_social_background' => '',
                
                // Font
                'body_font' => 'Lato',
                'heading_font' => 'Lato',
                'nav_font' => 'Lato',
                
                'body_font_size' => '',
                'body_line_height' => '',
                'h1_font_size' => '',
                'h2_font_size' => '',
                'h3_font_size' => '',
                'h4_font_size' => '',
                'h5_font_size' => '',
                'h6_font_size' => '',
                
                'tagline_font_size' => '',
                'tagline_letter_spacing' => '',
                
                'nav_font_size' => '',
                'nav_font_weight' => '',
                'nav_text_transform' => '',
                'nav_letter_spacing' => '',
                
                'portfolio_item_style' => '1',
                'testimonial_font_size' => '',
                'testimonial_line_height' => '',
                'testimonial_color' => '',
                
            ),
            'diy' => array(
                
                // Color
                'accent' => '#4fbbd6',
                'accent_darker' => '#2ea8c4',
                'site_text_color' => '#333333',
                'tagline_color' => '#888888',
                'mainnav_border' => '1px 0',
                'mainnav_border_length' => 'container',
                'mainnav_border_color' => '#eaeaea',
                'footer_bottom_background' => '#f0f0f0',
                'footer_social_size' => '28',
                'footer_social_font_size' => '16',
                'footer_social_color' => '#ffffff',
                'footer_social_background' => '#aaaaaa',
                
                // Font
                'body_font' => 'Karla',
                'heading_font' => 'Arvo',
                'nav_font' => 'Arvo',
                
                'body_font_size' => '14',
                'body_line_height' => '1.71428571',
                'h1_font_size' => '28',
                'h2_font_size' => '24',
                'h3_font_size' => '20',
                'h4_font_size' => '16',
                'h5_font_size' => '24',
                'h6_font_size' => '13',
                
                'tagline_font_size' => '14',
                'tagline_letter_spacing' => '2.6',
                
                'nav_font_size' => '13',
                'nav_font_weight' => '400',
                'nav_text_transform' => 'lowercase',
                'nav_letter_spacing' => '0',
                
                'portfolio_item_style' => '2',
                'testimonial_font_size' => '1.1em',
                'testimonial_line_height' => '1.7',
                'testimonial_color' => '#777777',
                
            ),
            'photography' => array(
                
                // Color
                'accent' => '#cca984',
                'accent_darker' => '#ab8358',
                'site_text_color' => '#333333',
                'tagline_color' => '#cccccc',
                'mainnav_border' => '0',
                'mainnav_border_length' => 'container',
                'mainnav_border_color' => '',
                'mainnav_color' => '#999999',
                'mainnav_hover_color' => '#222222',
                'mainnav_active_color' => '#222222',
                'mainnav_dropdown_border_width' => '3px',
                'mainnav_submenu_item_color' => '#000000',
                'footer_bottom_border' => '#ffffff',
                'copyright_color' => '#a5a5a5',
                
                'footer_bottom_background' => '',
                'footer_social_size' => '28',
                'footer_social_font_size' => '16',
                'footer_social_color' => '#ffffff',
                'footer_social_background' => '#bababa',
                'footer_social_border' => '#bababa',
                
                'footer_social_hover_color' => '#ffffff',
                'footer_social_hover_background' => '#cca984',
                'footer_social_hover_border' => '#cca984',
                
                // Font
                'body_font' => 'Open Sans',
                'heading_font' => 'Raleway',
                'nav_font' => 'Raleway',
                
                'body_font_size' => '',
                'body_line_height' => '',
                'h1_font_size' => '',
                'h2_font_size' => '',
                'h3_font_size' => '',
                'h4_font_size' => '',
                'h5_font_size' => '',
                'h6_font_size' => '',
                
                'tagline_font_size' => '11',
                'tagline_letter_spacing' => '8',
                
                'nav_font_size' => '12',
                'nav_font_weight' => '',
                'nav_text_transform' => '',
                'nav_letter_spacing' => '1',
                'nav_dropdown_font_size' => '12',
                'nav_dropdown_text_transform' => 'uppercase',
                'nav_dropdown_letter_spacing' => '1',
                
                'copyright_font' => 'heading',
                'copyright_font_size' => '10',
                'copyright_text_transform' => 'uppercase',
                'copyright_letter_spacing' => '3',
                
                'page_title_font_weight' => '300',
                'page_title_text_transform' => 'uppercase',
                'page_title_letter_spacing' => '2',
                
            ),
        );
        
        $all_keys = $concepts[ 'standard' ] + $concepts[ 'diy' ] + $concepts[ 'photography' ];
        $all_keys = array_keys( $all_keys );
        $all_keys = array_unique($all_keys);
        $all_keys = array_flip( $all_keys );
        
        foreach ( $concepts as $concept => $options ) {
            
            $dummy_keys = array_keys( array_diff_key( $all_keys, $options ) );
            
            foreach ( $options as $key => $val ) {
                $options[ $prefix . $key ] = $val;
                unset( $options[ $key ] );
            }
            foreach ( $dummy_keys as $key ) {
                $options[ $prefix . $key ] = '';
            }
            
            $concepts[ $concept ] = $options;
        }
        
        return $concepts;
        
    }

    /**
     * Register Options
     *
     * @since 1.0
     * @added since 2.0
     */
	public static function register( $wp_customize ) {
        
        $prefix = self::$prefix;
        
        require get_template_directory() . '/inc/custom-controls.php';
        
        $panel_arr = self::instance()->panels();
        $section_arr = self::instance()->sections();
        $option_arr = self::instance()->options();
        
        /* Register Panels
        --------------------------------------------------------------------------------------------------*/
        foreach ($panel_arr as $k=>$v){
            if ( ! is_array( $v ) ) {
                $v = array( 'title' => $v );
            }
            $wp_customize->add_panel(
                 $prefix . $k , $v
            );
        }
        
        /* Register Sections
        --------------------------------------------------------------------------------------------------*/
        foreach ($section_arr as $k=>$v){
            $reg = array();
            if (!is_array($v)) {
                $reg['title'] = $v;
            } else {
                $reg = $v;
                if ( isset( $v['panel'] ) ) $reg['panel'] = $prefix . $v['panel'];
            }
            $wp_customize->add_section(
                 $prefix . $k , $reg
            );
        }
        
        /* Register Settings
        --------------------------------------------------------------------------------------------------*/
        
        foreach ($option_arr as $id => $opt) {
            
            $type = isset($opt['type']) ? $opt['type'] : 'text';
            $section = isset($opt['section']) ? $opt['section'] : 'general';
            $name = isset($opt['name']) ? $opt['name'] : '';
            $desc = isset($opt['desc']) ? $opt['desc'] : '';
            $choices = isset($opt['options']) ? $opt['options'] : array();
            $std = isset($opt['std']) ? $opt['std'] : false;
            
            $placeholder = isset($opt['placeholder']) ? $opt['placeholder'] : '';
            $input_attrs = array();
            if ( $placeholder ) $input_attrs[ 'placeholder' ] = $placeholder;
            
            if ( $type == 'checkbox' ) {
                $callback = 'withemes_sanitize_checkbox';
            } else if ( $type == 'number' ) {
                $callback = 'withemes_sanitize_number';
            } else {
                $callback = 'withemes_no_filter';
            }
            
            $setting_arr = array(
                'sanitize_callback' => $callback,
                'type'      => 'option',
            );
            
            if ( $std ) {
                $setting_arr[ 'default' ] = $std;
            }
            if ( isset( $opt[ 'transport' ] ) ) {
                $setting_arr[ 'transport' ] = $opt[ 'transport' ];
            }
            
            $wp_customize->add_setting( $prefix . $id, $setting_arr );
            
            $control_args = array(
                'label'          =>  $name,
                'section'        =>  $prefix . $section,
                'settings'       =>  $prefix . $id,
                'description'    =>  $desc,
                'type'          => $type,
                'description'   =>$desc,
                'choices'       => $choices,
            );
            if ( ! empty( $input_attrs ) ) {
                $control_args[ 'input_attrs' ] = $input_attrs;
            }
            
            $custom_controls = array (
                
                // built in
                'image'         => 'WP_Customize_Image_Control',
                'color'         => 'WP_Customize_Color_Control',
                'upload'        => 'WP_Customize_Upload_Control',
                
                // Added by Withemes
                'heading'       => 'Withemes_Heading_Control',
                'html'          => 'Withemes_HTML_Control',
                
            );
            
            if ( isset( $custom_controls[ $type ] ) ) {
                
                $control_class = $custom_controls[ $type ];
                $wp_customize->add_control ( new $control_class ( $wp_customize , $prefix . $id, $control_args ) );
                
            } else {
                
                $wp_customize->add_control ( $id, $control_args );
            
            }
            
        } // foreach option array
        
        /* Color Options
        --------------------------------------------------------------------------------------------------*
        $color_arr = array();
        $color_arr[] = array(
            'id' => 'accent_color',
            'name'=> esc_html__('Accent color','simple-elegant'),
            'std' => '#5EA7B1',
        );
        
        $color_arr[] = array(
            'id' => 'text_color',
            'name'=> esc_html__('Text color','simple-elegant'),
            'std' => '#333',
        );
        
        $color_arr[] = array(
            'id' => 'link_color',
            'name'=> esc_html__('Link color','simple-elegant'),
            'std' => '#5EA7B1',
        );
        
        $color_arr[] = array(
            'id' => 'selection_color',
            'name'=> esc_html__('Selection color','simple-elegant'),
        );
        
        $color_arr[] = array(
            'id' => 'selection_text_color',
            'name'=> esc_html__('Selection text color','simple-elegant'),
        );
        
        foreach ( $color_arr as $opt ) {
            
            $name = isset($opt['name']) ? $opt['name'] : '';
            $desc = isset($opt['desc']) ? $opt['desc'] : '';
            $id = isset($opt['id']) ? $opt['id'] : '';
            if (!$id) continue;
            $std = isset($opt['std']) ? $opt['std'] : false;
            
            $wp_customize->add_setting(
                $prefix . $id, 
                array(
                    'default' => $std,
                    'sanitize_callback' => 'sanitize_hex_color'
                )
            );
            $wp_customize->add_control(
               new WP_Customize_Color_Control(
                   $wp_customize,
                   $prefix . $id,
                   array(
                       'label'      => $name,
                       'section'    => 'colors',
                       'settings'   => $prefix . $id,
                       'description'=>$desc,
                   )
               )
            );
        }
        
        // Make Color Options as a section of style panel
        $colors_section = $wp_customize->get_section( 'colors' );
        $colors_section->panel = 'withemes_style';
        
        */
        
	}

}

Wi_Customize::instance()->init();

endif; // class_exists

/**
 * Callback function for sanitizing checkbox settings.
 *
 * Used by Wi_Customize
 *
 * @param $checked
 *
 * @return int|string
 */
if (!function_exists('withemes_sanitize_checkbox')) {
function withemes_sanitize_checkbox( $checked ) {
	return ( ( isset( $checked ) && ( true == $checked || 'on' == $checked ) ) ? true : false );
}
}

/**
 * Callback function for sanitizing number settings.
 *
 * Used by Wi_Customize
 *
 * @param $value
 *
 * @return int|string
 */
if (!function_exists('withemes_sanitize_number')) {
function withemes_sanitize_number( $value ) {
	return ( is_numeric( $value ) ) ? $value : intval( $value );
}
}

/**
 * Callback function for sanitizing color
 *
 * Used by Wi_Customize
 */
if (!function_exists('sanitize_hex_color') ) {
function sanitize_hex_color( $color ) {
    if ( '' === $color )
        return '';
 
    // 3 or 6 hex digits, or the empty string.
    if ( preg_match('|^#([A-Fa-f0-9]{3}){1,2}$|', $color ) )
        return $color;
}
}

/**
 * Callback function for sanitizing nothing
 *
 * Used by Wi_Customize
 *
 * @param $value
 *
 * @return $value
 */
if (!function_exists('withemes_no_filter')) {
function withemes_no_filter( $value ) {
	return $value;
}
}