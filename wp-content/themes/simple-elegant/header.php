<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @package Simple & Elegant
 * @since 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    
    <div id="wi-wrapper">
        <header id="wi-header" class="<?php echo esc_attr( withemes_header_class() ); ?>">
            
            <?php if (  'false' != get_option('withemes_enable_topbar' ) ): ?>
            
            <div id="wi-topbar" class="wi-topbar">
                <div class="container">
                    <div class="topbar-left">
                        
                        <?php /* -------------------- Topbar Menu -------------------- */ ?>
                        <?php if ( has_nav_menu('topbar') ) : ?>
                            
                        <nav id="topbarnav">
                            <?php wp_nav_menu(array(
                                'theme_location'	=>	'topbar',
                                'depth'				=>	2,
                                'container_class'	=>	'menu',
                            ));?>
                        </nav><!-- #topbarnav -->
                        
                        <?php endif; ?>
                    </div><!-- .topbar-left -->
                    <div class="topbar-right">
                        
                        <?php /* -------------------- Social -------------------- */?>
                        <?php if ( 'false' != get_option('withemes_topbar_social') ): ?>
                        <?php echo withemes_display_social(); ?>
                        <?php endif; ?>
                        
                        <?php /* -------------------- Search -------------------- */?>
                        <?php if ( 'false' != get_option('withemes_topbar_search') ): ?>
                        <?php get_search_form(); ?>
                        <?php endif; ?>
                        
                    </div><!-- .topbar-right -->
                    
                </div><!-- .container -->
            </div><!-- #wi-topbar -->
            
            <?php endif; // ! disable topbar ?>
            
            <div id="logo-area">
                <div class="container">
                    
                    <a id="hamburger">
                        <span></span>
                        <span></span>
                        <span></span>
                    </a>
                    
                    <?php /* -------------------- Logo -------------------- */?>
                    <?php $heading = 'h2'; if ( is_front_page() && is_home() ) $heading = 'h1'; ?>
                    <div id="wi-logo">
                        <?php echo '<' . $heading . '>'; ?>
                            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                                <?php if (!get_option('withemes_logo')):?>
                                    <img src="<?php echo get_template_directory_uri(); ?>/images/logo.png" alt="<?php esc_html_e('Logo','simple-elegant');?>" />
                                <?php else: ?>
                                    <img src="<?php echo esc_url(get_option('withemes_logo'));?>" alt="<?php esc_html_e('Logo','simple-elegant');?>" />
                                <?php endif; // logo ?>
                            </a>
                        <?php echo '</' . $heading . '>'; ?>
                        
                        <?php /* -------------------- Tagline -------------------- */?>
                        <?php if ( 'false' != get_option('withemes_header_tagline')) : ?>
                        <h3 id="wi-tagline"><?php echo get_bloginfo( 'description', 'display' );?></h3>
                        <?php endif; // disable tagline ?>
                        
                    </div><!-- #wi-logo -->
                    
                    <?php $layout = get_option( 'withemes_header_layout' );
                        if ( '2' == $layout ) { ?>
                    
                    <div class="header-right">
                        
                        <?php $header_text = trim( get_option( 'withemes_header_text' ) );
                            if ( $header_text ) {
                                echo '<div class="header-text">' . wp_kses( $header_text, withemes_allowed_html() ) . '</div>';
                            }
                        ?>
                        <?php /* -------------------- Social -------------------- */?>
                        <?php if ( 'true' == get_option('withemes_header_social') ): ?>
                        <?php echo withemes_display_social(); ?>
                        <?php endif; ?>
                        
                        </div><!-- .header-right -->
                    
                    <?php } // layout 2 ?>
                    
                    <?php if ( class_exists( 'WooCommerce' ) && 'false' != get_option( 'withemes_header_cart' ) ) : ?>
                    
                    <div class="header-cart">
                        
                        <a href="<?php echo WC()->cart->get_cart_url(); ?>" title="<?php esc_html_e( 'View your shopping cart', 'simple-elegant' ); ?>">
                            
                            <i class="bi_ecommerce-shopcart"></i>
                            
                            <?php $count = WC()->cart->get_cart_contents_count(); if ( $count > 0 ) : ?>
                            
                            <span class="items-number"><?php echo $count; ?></span>
                            
                            <?php endif; ?>
                        
                        </a>
                        
                    </div><!-- .header-cart -->
                    
                    <?php endif; ?>
                    
                </div><!-- .container -->
            </div><!-- #logo-area -->
            
            <?php /* -------------------- Primary Menu -------------------- */?>
            <?php if ( has_nav_menu('primary') ) : ?>
            
            <?php
                $nav_class = array( 'wi-mainnav' );
                $mainnav_border_length = get_option( 'withemes_mainnav_border_length', 'container' );
                if ( 'fullwidth' != $mainnav_border_length ) $mainnav_border_length = 'container';
                $nav_class[] = 'mainnav-border-' . $mainnav_border_length;
                $nav_class = join( ' ', $nav_class );
            ?>
            
            <nav id="wi-mainnav" class="<?php echo esc_html__( $nav_class ); ?>">
                
                <div class="container">
                    
                    <?php wp_nav_menu(array(
                        'theme_location'	=>	'primary',
                        'depth'				=>	3,
                        'container_class'	=>	'menu',
                    ));?>
                    
                    <?php if ( class_exists( 'WooCommerce' ) && 'false' != get_option( 'withemes_header_cart' ) ) : ?>
                    
                    <div id="header-cart" class="header-cart">
                        
                        <a href="<?php echo WC()->cart->get_cart_url(); ?>" title="<?php esc_html_e( 'View your shopping cart', 'simple-elegant' ); ?>">
                            
                            <i class="bi_ecommerce-shopcart"></i>
                            
                            <?php $count = WC()->cart->get_cart_contents_count(); if ( $count > 0 ) : ?>
                            
                            <span class="items-number"><?php echo $count; ?></span>
                            
                            <?php endif; ?>
                        
                        </a>
                        
                    </div><!-- #header-cart -->
                    
                    <?php endif; ?>
                    
                </div><!-- .container -->
                
            </nav><!-- #wi-mainnav -->
            <div id="mainnav-height"></div>
            <?php endif; ?>
            
        </header><!-- #wi-header -->
        
        <main id="wi-main">