<?php
if ( !class_exists( 'Withemes_Admin' ) ) :
/**
 * Admin Class
 *
 * @since 2.0
 */
class Withemes_Admin
{   
    
    /**
	 *
	 */
	public function __construct() {
	}
    
    /**
	 * The one instance of Withemes_Admin
	 *
	 * @since 2.0
	 */
	private static $instance;

	/**
	 * Instantiate or return the one Withemes_Admin instance
	 *
	 * @since 2.0
	 *
	 * @return Withemes_Admin
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
        
        // metabox
        require_once get_template_directory() . '/inc/admin/framework/metabox/metabox.php';
        
        // widget framework
        require_once get_template_directory() . '/inc/admin/framework/widget/widget.php';
        
        // TGM
        require_once get_template_directory() . '/inc/admin/framework/tgm.php';
        
        // Post Format UI
        require_once 'framework/formatui/vp-post-formats-ui.php'; // This plugin has a high compatible ability so we don't need to check if it exists or not
        // correct the post format-ui url
        add_filter( 'vp_pfui_base_url', array( $this, 'vp_pfui_base_url' ) );
        
        // Nav
        require_once get_template_directory() . '/inc/admin/framework/nav/nav-custom-fields.php'; // fields
        add_action( 'wp_loaded', array( $this, 'include_menu_walker' ) );
        
        // register plugins needed for theme
        add_action( 'tgmpa_register', array ( $this, 'register_required_plugins' ) );
        
        // Include media upload to sidebar area
        // This will be used when we need to upload something
        add_action( 'sidebar_admin_setup', function() {
            wp_enqueue_media();
        });
        
        // enqueue scripts
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue' ) );
        
        // localization
        add_action( 'withemesadminjs', array( $this, 'l10n' ) );
        
        // metabox
        add_filter( 'withemes_metaboxes', array( $this, 'metaboxes' ) );
        
        /**
         * Add a thumbnail column in edit.php
         *
         * Thank to: http://wordpress.org/support/topic/adding-custum-post-type-thumbnail-to-the-edit-screen
         *
         * @since 2.0
         */
        add_action( 'manage_posts_custom_column', array( $this, 'add_thumbnail_value_editscreen' ), 10, 2 );
        add_action( 'manage_portfolios_custom_column', array( $this, 'add_thumbnail_value_editscreen' ), 10, 2 );
        add_filter( 'manage_edit-post_columns', array( $this, 'columns_filter' ) , 10, 1 );
        add_filter( 'manage_edit-portfolio_columns', array( $this, 'columns_filter' ) , 10, 1 );
        
        /**
         * Demo Import
         *
         * @since 2.0
         */
        add_filter( 'pt-ocdi/import_files', array( $this, 'import_files' ) );
        
        add_action( 'pt-ocdi/after_import', array( $this, 'after_import_setup' ) );
    }
    
    /**
     * Registers import files
     *
     * @since 2.0
     */
    function import_files( $files ) {
        
        define( 'DEMO_PATH', get_template_directory() . '/inc/demos/' );
        define( 'DEMO_URL', get_template_directory_uri() . '/inc/demos/' );
        
        $files = array();
        
        $files[] = array(
            'import_file_name'              => 'Main Demo',
            'local_import_file'             => DEMO_PATH . "main/content.xml",
            'local_import_widget_file'      => DEMO_PATH . "main/widgets.wie",
            'local_import_customizer_file'  => DEMO_PATH . "main/customizer.dat",
            'import_preview_image_url'      => DEMO_URL . "main/preview.jpg",
            // 'import_notice'                 => esc_html__( 'You have to import "Slider Revolution" manually.', 'simple-elegant' ),
        );
        
        $files[] = array(
            'import_file_name'              => 'Photography',
            'local_import_file'             => DEMO_PATH . "photography/content.xml",
            'local_import_widget_file'      => DEMO_PATH . "photography/widgets.wie",
            'local_import_customizer_file'  => DEMO_PATH . "photography/customizer.dat",
            'import_preview_image_url'      => DEMO_URL . "photography/preview.jpg",
            // 'import_notice'                 => esc_html__( 'You have to import "Slider Revolution" manually.', 'simple-elegant' ),
        );
        
        $files[] = array(
            'import_file_name'              => 'DIY',
            'local_import_file'             => DEMO_PATH . "diy/content.xml",
            'local_import_widget_file'      => DEMO_PATH . "diy/widgets.wie",
            'local_import_customizer_file'  => DEMO_PATH . "diy/customizer.dat",
            'import_preview_image_url'      => DEMO_URL . "diy/preview.jpg",
            // 'import_notice'                 => esc_html__( 'You have to import "Slider Revolution" manually.', 'simple-elegant' ),
        );
        
        return $files;
    
    }
    
    /**
     * Import Revslider
     *
     * @since 1.0
     */
    function import_revslider() {
    
    } 
    
    /**
     * Setup after importing process
     *
     * @since 2.0
     */
    function after_import_setup( $selected_import ) {
        
        $demos = array(
            'Main Demo' => array(
                'slug' => 'main',
                'home' => 'Home',
                'blog' => 'Blog',
                'primary' => 'Primary',
                'topbar' => 'Topbar',
                'sliders' => array( 'slider1', 'slider2', 'slider3' ),
            ),
            'Photography' => array(
                'slug' => 'photography',
                'home' => 'Home',
                'blog' => 'Journal',
                'primary' => 'Menu 1',
                'sliders' => array( 'slider1' ),
            ),
            'DIY' => array(
                'slug' => 'diy',
                'home' => 'Home',
                'blog' => 'Journal',
                'primary' => 'Menu 1',
                'topbar' => 'Topbar',
                'sliders' => array( 'slider1' ),
            ),
        );
        
        foreach ( $demos as $name => $data ) {
         
            if ( $name === $selected_import['import_file_name'] ) {
                
                // Assign menus to their locations.
                if ( isset( $data[ 'primary' ] ) ) {
                    $nav = get_term_by( 'name', $data[ 'primary' ], 'nav_menu' );
                    if ( $nav ) {
                        set_theme_mod( 'nav_menu_locations', array(
                                'primary' => $nav->term_id,
                            )
                        );
                    }
                }
                
                // Assign menus to their locations.
                if ( isset( $data[ 'topbar' ] ) ) {
                    $nav = get_term_by( 'name', $data[ 'topbar' ], 'nav_menu' );
                    if ( $nav ) {
                        set_theme_mod( 'nav_menu_locations', array(
                                'topbar' => $nav->term_id,
                            )
                        );
                    }
                }
                
                update_option( 'show_on_front', 'page' );
                
                // Assign front page and posts page (blog page).
                if ( isset( $data[ 'home' ] ) ) {
                    $front_page_id = get_page_by_title( $data[ 'home' ] );
                    update_option( 'page_on_front', $front_page_id->ID );
                    
                }
                
                // Assign front page and posts page (blog page).
                if ( isset( $data[ 'blog' ] ) ) {
                    $blog_page_id  = get_page_by_title( $data[ 'blog' ] );
                    update_option( 'page_for_posts', $blog_page_id->ID );
                }
                
                
            }
            
        } // foreach
        
        // https://www.themepunch.com/faq/theme-authors-auto-import-slider-demos/
        $slider_array = isset( $data[ 'sliders' ] ) ? (array) $data[ 'sliders' ] : array();
        if ( class_exists( 'RevSlider' ) && !empty( $slider_array ) ) {
            
            $absolute_path = __FILE__;
            $path_to_file = explode( 'wp-content', $absolute_path );
            $path_to_wp = $path_to_file[0];

            require_once( $path_to_wp.'/wp-load.php' );
            require_once( $path_to_wp.'/wp-includes/functions.php');
            require_once( $path_to_wp.'/wp-admin/includes/file.php');
            
            $slider = new RevSlider();

            foreach($slider_array as $filename ){
                $filepath = get_template_directory() . '/inc/demos/' . $data[ 'slug' ] . '/' . $filename . '.zip';
                $slider->importSliderFromPost(true,true,$filepath);  
            }
            
        }
        
        // Load Default Settings
        $concepts = Wi_Customize::concepts();
        $key_of_concept = $data[ 'slug' ] == 'main' ? 'standard' : $data[ 'slug' ];
        $concept_data = $concepts[ $key_of_concept ];
    
        foreach ( $concept_data as $option_name => $option_std ) {
            $update = update_option( $option_name, $option_std );
            if ( ! $update ) {
                set_option( $option_name, $option_std );
            }
        }
        
    }
    
    /**
     * Includes menu walker
     *
     * @since 2.0
     */
    function include_menu_walker() {
    
        add_filter( 'wp_edit_nav_menu_walker', array( $this, 'load_menu_walker' ), 99 );
        
    }
    
    /**
     * Loads menu walker
     *
     * @since 2.0
     */
    function load_menu_walker( $walker ) {
    
        $walker = 'Withemes_Menu_Item_Custom_Fields_Walker';
        if ( ! class_exists( $walker ) ) {
            require_once get_template_directory() . '/inc/admin/framework/nav/walker-nav-menu-edit.php'; // custom walker to add fields
        }

        return $walker;
        
    }
    
    /**
     * Returns Format UI plugin base url
     *
     * @since 2.0
     */
    function vp_pfui_base_url() {
        return get_template_directory_uri() . '/inc/admin/framework/formatui/';
    }
    
    /**
     * Register Plugins
     *
     * Remove Instagram Widget & Post Format UI since 2.0
     * Instagram Widget & Post Format UI is now a part of Theme package
     *
     * @since 2.0
     */
    function register_required_plugins (){
        
        $plugins = array (
            
            array(
                'name'     				=> 'Visual Composer', // The plugin name
                'slug'     				=> 'js_composer', // The plugin slug (typically the folder name)
                'required' 				=> true, // If false, the plugin is only 'recommended' instead of required
                'source'   				=> get_template_directory() . '/inc/admin/plugins/js_composer.zip', // The plugin source
                'version'               => '5.1',
                'force_activation'      => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
                'force_deactivation'    => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
            ),
            
            array (
                'name'     				=> esc_html__( '(Simple & Elegagant) Addons', 'simple-elegant' ), // The plugin name
                'slug'     				=> 'simple-elegant-addons', // The plugin slug (typically the folder name)
                'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
                'source'   				=> get_template_directory() . '/inc/admin/plugins/simple-elegant-addons.zip', // The plugin source
                'version'               => '2.1',
            ),
            
            array (
                'name'     				=> esc_html__( '(Simple & Elegagant) Portfolio', 'simple-elegant' ), // The plugin name
                'slug'     				=> 'simple-elegant-portfolio', // The plugin slug (typically the folder name)
                'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
                'source'   				=> get_template_directory() . '/inc/admin/plugins/simple-elegant-portfolio.zip', // The plugin source
                'version'               => '2.1',
            ),
            
            array(
                'name'     				=> 'Revolution Slider', // The plugin name
                'slug'     				=> 'revslider', // The plugin slug (typically the folder name)
                'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
                'source'   				=> get_template_directory() . '/inc/admin/plugins/revslider.zip', // The plugin source
                'version'               =>'5.4',
            ),
            
            array(
                'name'     				=> 'Envato Market', // The plugin name
                'slug'     				=> 'envato-market', // The plugin slug (typically the folder name)
                'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
                'source'   				=> get_template_directory() . '/inc/admin/plugins/envato-market.zip', // The plugin source
                'version'               =>'1.0.0-RC2',
            ),
            
            array(
                'name'     				=> esc_html__( 'Contact Form 7', 'simple-elegant' ), // The plugin name
                'slug'     				=> 'contact-form-7', // The plugin slug (typically the folder name)
                'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
            ),
            
            array(
                'name'     				=> esc_html__( 'Mailchimp for Wordpress', 'simple-elegant' ), // The plugin name
                'slug'     				=> 'mailchimp-for-wp', // The plugin slug (typically the folder name)
                'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
            ),
            
            array(
                'name'     				=> esc_html__( 'Instagram Widget', 'simple-elegant' ), // The plugin name
                'slug'     				=> 'wp-instagram-widget', // The plugin slug (typically the folder name)
                'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
            ),
            
        );

        $config = array(
            'id'           => 'tgmpa',
            'default_path' => '',
            'menu'         => 'tgma-install-plugins',
            'parent_slug'  => 'themes.php',
            'capability'   => 'edit_theme_options',
            'has_notices'  => true,
            'dismissable'  => true,
            'dismiss_msg'  => '',
            'is_automatic' => true,
            'message'      => '',
        );

        tgmpa( $plugins, $config );
    }
    
    /**
     * Enqueue javascript & style for admin
     *
     * @since 2.0
     */
    function enqueue(){
        
        // We need to upload image/media constantly
        wp_enqueue_media();
        
        wp_enqueue_style( 'simple-elegant-admin', get_template_directory_uri() . '/css/admin/admin.css', array( 'wp-mediaelement' ) );
        
        wp_enqueue_script( 'simple-elegant-admin', get_template_directory_uri() . '/js/admin/admin.js', array( 'wp-mediaelement' ), null , true );
        
        // localize javascript
        $jsdata = apply_filters( 'withemesadminjs', array() );
        wp_localize_script( 'simple-elegant-admin', 'WITHEMES_ADMIN' , $jsdata );
        
    }
    
    /**
     * Localize some text
     *
     * @since 2.0
     */
    function l10n( $jsdata ) {
        
        if ( ! isset ( $jsdata[ 'l10n' ] ) ) $jsdata[ 'l10n' ] = array();
    
        $jsdata[ 'l10n' ] += array(
        
            'choose_image' => esc_html__( 'Choose Image', 'simple-elegant' ),
            'change_image' => esc_html__( 'Change Image', 'simple-elegant' ),
            'upload_image' => esc_html__( 'Upload Image', 'simple-elegant' ),
            
            'choose_images' => esc_html__( 'Choose Images', 'simple-elegant' ),
            'change_images' => esc_html__( 'Change Images', 'simple-elegant' ),
            'upload_images' => esc_html__( 'Upload Images', 'simple-elegant' ),
            
            'choose_file' => esc_html__( 'Choose File', 'simple-elegant' ),
            'change_file' => esc_html__( 'Change File', 'simple-elegant' ),
            'upload_file' => esc_html__( 'Upload File', 'simple-elegant' ),
        
        );
        
        return $jsdata;
    
    }

    /**
     * Add Thumbnail Column to edit screen
     *
     * @since 2.0
     */
    function columns_filter( $columns ) {
        $column_thumbnail = array( 'thumbnail' => esc_html__('Thumbnail','simple-elegant') );
        $columns = array_slice( $columns, 0, 1, true ) + $column_thumbnail + array_slice( $columns, 1, NULL, true );
        return $columns;
    }
    
    /**
     * Render Thumbnail for posts
     *
     * @since 2.0
     */
    function add_thumbnail_value_editscreen( $column_name, $post_id ) {

        $width = (int) 50;
        $height = (int) 50;

        if ( 'thumbnail' == $column_name ) {
            // thumbnail of WP 2.9
            $thumbnail_id = get_post_meta( $post_id, '_thumbnail_id', true );
            // image from gallery
            $attachments = get_children( array('post_parent' => $post_id, 'post_type' => 'attachment', 'post_mime_type' => 'image') );
            if ($thumbnail_id)
                $thumb = wp_get_attachment_image( $thumbnail_id, array($width, $height), true );
            elseif ($attachments) {
                foreach ( $attachments as $attachment_id => $attachment ) {
                    $thumb = wp_get_attachment_image( $attachment_id, array($width, $height), true );
                }
            }
            if ( isset($thumb) && $thumb ) {
                echo wp_kses($thumb, withemes_allowed_html() );
            } else {
                echo '<em>' . esc_html__( 'None','simple-elegant' ) . '</em>';
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
        
        $all_navs = array( '' => esc_html__( 'None', 'simple-elegant' ) );
        $all_navs = $all_navs + get_terms( 'nav_menu', array( 'hide_empty' => true, 'fields' =>  'id=>name' ) );
        
        // PAGE SETTINGS
        //
        $metaboxes[] = array (
            
            'id' => 'page-settings',
            'screen' => array( 'page' ),
            'title' => esc_html__( 'Page Settings', 'simple-elegant' ),
            
            'tabs' => array(
                'layout'    => esc_html__( 'Layout', 'simple-elegant' ),
                'sidenav'    => esc_html__( 'Side Navigation', 'simple-elegant' ),
            ),
            
            'fields' => array (
                
                // LAYOUT
                array (
                    'id' => 'sidebar_position',
                    'name' => esc_html__( 'Sidebar Position', 'simple-elegant' ),
                    'desc' => esc_html__( 'This option doesn\'t affect fullwidth pages.', 'simple-elegant' ),
                    'type' => 'select',
                    'options' => array(
                        '' => esc_html__( 'Inherit', 'simple-elegant' ),
                        'right' => esc_html__( 'Sidebar Right', 'simple-elegant' ),
                        'left' => esc_html__( 'Sidebar Left', 'simple-elegant' ),
                    ),
                    'std' => '',
                    'tab' => 'layout',
                ),
                
                array (
                    'id' => 'padding_top',
                    'name' => esc_html__( 'Page Padding Top', 'simple-elegant' ),
                    'type' => 'text',
                    'placeholder' => '40px',
                    'tab' => 'layout',
                ),
                
                array (
                    'id' => 'padding_bottom',
                    'name' => esc_html__( 'Page Padding Bottom', 'simple-elegant' ),
                    'type' => 'text',
                    'placeholder' => '40px',
                    'tab' => 'layout',
                ),
                
                array (
                    'id' => 'disable_title',
                    'name' => esc_html__( 'Hide page title?', 'simple-elegant' ),
                    'type' => 'checkbox',
                    'std' => '',
                    'tab' => 'layout',
                ),
                
                
                // SIDE NAVIGATION
                array(
                    'id' => 'side_nav',
                    'name' => esc_html__( 'Side Navigation Menu', 'simple-elegant' ),
                    'desc' => esc_html__( 'By selecting a menu, you will automatically enable "Side Navigation" layout. To make side menu left, please click to tab "Layout" and select "Sidebar Left" layout.', 'simple-elegant' ),
                    'type' => 'select',
                    'options' => $all_navs,
                    'std' => '',
                    
                    'tab'   => 'sidenav',
                ),
                
            ),
            
        );
        
        return $metaboxes;
        
    }
}

Withemes_Admin::instance()->init();

endif; // class exists