<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package Simple & Elegant
 * @since Simple & Elegant 1.0
 */

get_header(); ?>

<div id="page-wrapper">
    <div class="container">
    
        <section class="error-404 not-found">
            <header>
                <h1 class="page-title entry-title"><?php esc_html_e( 'Nothing found :(', 'simple-elegant' ); ?></h1>
            </header>

            <div class="page-content entry-content align-center">
                <p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try a search?', 'simple-elegant' ); ?></p>

                <?php get_search_form(); ?>
            </div><!-- .page-content -->
        </section><!-- .error-404 -->
        
    </div><!-- .container -->
</div><!-- #page-wrapper -->

<?php get_footer(); ?>
