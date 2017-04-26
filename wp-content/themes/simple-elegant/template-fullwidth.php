<?php
/**
 * Template Name: Fullwidth
 *
 * @package Simple & Elegant
 * @since Simple & Elegant 1.0
 */

get_header(); ?>

<div id="page-wrapper">
    <div class="container">
    
            <?php
            // Start the loop.
            while ( have_posts() ) : the_post();

                // Include the page content template.
                get_template_part( 'loops/content', 'page' );

                // If comments are open or we have at least one comment, load up the comment template.
                if ( comments_open() || get_comments_number() ) :
                    comments_template();
                endif;

            // End the loop.
            endwhile;
            ?>
        
    </div><!-- .container -->
</div><!-- #page-wrapper -->
    
<?php get_footer(); ?>
