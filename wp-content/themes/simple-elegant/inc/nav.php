<?php
/**
 * Everthing concerning nav bar
 *
 * @package Simple & Elegant
 * @since 2.0
 */
if ( !class_exists( 'Withemes_Nav' ) ) :
/**
 * Navigation Class
 *
 * @since 2.0
 */
class Withemes_Nav
{   
    
    /**
	 *
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
        
        add_filter( 'nav_menu_css_class', array( $this, 'nav_menu_css_class' ), 10, 4 );
        
    }
    
    /**
     * Classes for mega menu
     *
     * @since 2.0
     */
    function nav_menu_css_class( $classes, $item, $args, $depth ) {
    
        if ( ! $depth && get_post_meta( $item->ID, 'menu-item-mega', true ) ) {
            
            $classes[] = 'mega';
            
        }
        
        return $classes;
        
    }
    
}

Withemes_Nav::instance()->init();

endif;