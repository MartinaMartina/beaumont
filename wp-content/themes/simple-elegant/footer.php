<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the "site-content" div and all content after.
 *
 * @package Simple & Elegant
 * @since 1.0
 */
?>

	</main><!-- #wi-main -->

    <?php 

$footer_class = array( 'wi-footer' );
$footer_theme = get_option( 'withemes_footer_theme' );
if ( 'dark' != $footer_theme ) $footer_theme = 'light';
$footer_class[] = 'footer-' . $footer_theme;
$footer_class = join( ' ', $footer_class );
?>
	<footer id="wi-footer" class="<?php echo esc_attr( $footer_class ); ?>">
        
        <?php 
        $column = 0;
        for ( $i = 1; $i <=3; $i++ ) {
            if ( is_active_sidebar( 'footer-' . $i ) ) $column++;
        }
        ?>
        
        <?php if ( $column > 0 ) : ?>
        
        <div id="footer-widgets" class="footer-widgets column-<?php echo absint( $column ); ?>">
            <div class="container">
                <div class="footer-widgets-container column-<?php echo absint( $column ); ?>">
                    
                    <?php for ( $i = 1; $i <=3 ; $i++ ) : ?>
                    
                    <?php if ( is_active_sidebar( 'footer-' . $i ) ) : ?>
                    <div class="footer-col">
                        <?php dynamic_sidebar( 'footer-' . $i ); ?>
                    </div><!-- .footer-col -->
                    <?php endif; ?>
                    
                    <?php endfor; ?>
                    
                </div><!-- .footer-widgets-container -->
            </div><!-- .container -->
        </div><!-- #footer-widgets -->
        <?php endif; ?>
        
        <?php $footer_bottom_layout = get_option( 'withemes_footer_bottom_layout' );
        if ( 'sides' != $footer_bottom_layout ) $footer_bottom_layout = 'center'; ?>
		<div id="footer-bottom" class="<?php echo esc_attr( 'footer-' . $footer_bottom_layout ); ?>">
			<div class="container">
                
                <div class="footer-left">
            
                    <?php /* -------------------- Footer Logo -------------------- */?>
                    <?php if (get_option('withemes_footer_logo')): ?>
                    <div id="footer-logo">
                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                            <img src="<?php echo esc_url(get_option('withemes_footer_logo'));?>" alt="<?php esc_html_e('Footer Logo','simple-elegant');?>" />
                        </a>
                    </div><!-- #footer-logo -->
                    <?php endif; ?>
                
                    <?php /* -------------------- Copyright -------------------- */?>
                    <?php
                    if ( 'false' != get_option( 'withemes_enable_copyright' ) ) :
                        $copyright = trim( get_option( 'withemes_copyright' ) );
                        if ( $copyright ): ?>
                        <p id="wi-copyright">
                            <?php echo wp_kses( do_shortcode( $copyright ), withemes_allowed_html() );?>
                        </p>
                        <?php else: ?>
                        <p id="wi-copyright"><?php printf( esc_html__('All rights reserved. Designed by %s', 'simple-elegant'), '<a href="http://withemes.com" target="_blank">WiThemes</a>'); ?></p>
                        <?php endif; 
                    endif; // enable copyright
                    ?>
                    
                </div><!-- .footer-left -->
                
                <div class="footer-right">
                
                    <?php /* -------------------- Social -------------------- */?>
                    <?php if ( 'false' != get_option('withemes_footer_social') ): ?>
                    <?php echo withemes_display_social(); ?>
                    <?php endif; ?>
                    
                </div><!-- .footer-right -->
                
            </div><!-- .container -->
		</div><!-- #footer-bottom -->
	</footer><!-- #wi-footer -->

</div><!-- #wi-wrapper -->

<?php wp_footer(); ?>

</body>
</html>