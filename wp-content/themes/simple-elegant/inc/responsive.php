<?php
/**
 * Responsive Functionalities
 *
 * @package Simple & Elegant
 * @since 2.0
 */
if ( !class_exists( 'Withemes_Responsive' ) ) :
/**
 * responsive Class
 *
 * @since 2.0
 */
class Withemes_Responsive
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
        
        add_action( 'wp_footer', array( $this, 'mobile_nav' ), 0 );
        
    }
    
    /**
     * Mobile Navigation
     *
     * @since 2.0
     */
    function mobile_nav() {
        ?>

<div id="offcanvas">

    <?php if ( has_nav_menu('primary') ) : ?>
            
        <nav id="mobilenav">

            <?php wp_nav_menu(array(
                'theme_location'	=>	'primary',
                'depth'				=>	3,
                'container_class'	=>	'menu',
            
                'after' => '<span class="indicator"></span>',
            ));?>

        </nav><!-- #wi-mainnav -->
    
    <?php endif; // primary menu ?>
    
    <?php /* -------------------- Topbar Menu -------------------- */ ?>
    <?php if ( has_nav_menu('topbar') ) : ?>

    <nav id="mobile-topbarnav">
        <?php wp_nav_menu(array(
            'theme_location'	=>	'topbar',
            'depth'				=>	2,
            'container_class'	=>	'menu',
            'after' => '<span class="indicator"></span>',
        ));?>
    </nav><!-- #mobile-topbarnav -->

    <?php endif; ?>
    
    <?php /* -------------------- Social -------------------- */?>
    <?php if ( 'false' != get_option('withemes_topbar_social') || 'true' == get_option( 'withemes_header_social' ) ): ?>
    <?php echo withemes_display_social(); ?>
    <?php endif; ?>

    <?php /* -------------------- Search -------------------- */?>
    <?php if ( 'false' != get_option('withemes_topbar_search') ): ?>
    <?php get_search_form(); ?>
    <?php endif; ?>
    
    <?php /* -------------------- Header Text -------------------- */?>
    <?php if ( '2' == get_option( 'withemes_header_layout' ) ) : ?>
    
    <?php $header_text = trim( get_option( 'withemes_header_text' ) );
        if ( $header_text ) {
            echo '<div class="header-text">' . wp_kses( $header_text, withemes_allowed_html() ) . '</div>';
        }
    ?>
    <?php endif; ?>
    
</div><!-- #offcanvas -->

<div id="offcanvas-overlay"></div>
        
        <?php
    }
    
}

Withemes_Responsive::instance()->init();

endif;