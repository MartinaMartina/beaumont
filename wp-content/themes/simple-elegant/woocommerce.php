<?php
/**
 * The template for displaying WooCommerce pages according to their documentation
 * https://docs.woothemes.com/document/third-party-custom-theme-compatibility/
 *
 * @package Simple & Elegant
 *
 * @since Simple & Elegant 1.3
 */

get_header(); ?>

<div id="page-wrapper">
    
    <div class="container">
        
        <?php
        // Start the loop.
        if ( have_posts() ) :

            woocommerce_content();

        // End the loop.
        endif;
        ?>

    </div><!-- .container -->
    
</div><!-- #page-wrapper -->
    
<?php get_footer();