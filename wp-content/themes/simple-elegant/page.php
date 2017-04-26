<?php
/**
 * The template for displaying pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other "pages" on your WordPress site will use a different template.
 *
 * @package Simple & Elegant
 * @since Simple & Elegant 1.0
 * @modified since 2.0
 * @added side navigation
 */

get_header(); ?>

<div id="page-wrapper">
    <div class="container">
    
        <div id="primary">
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
        </div><!-- #primary -->

        <?php $nav = get_post_meta( get_the_ID(), '_withemes_side_nav', true );

        if ( $nav ) {
            
            echo '<div id="secondary">';

                wp_nav_menu( array( 
                    'menu' => $nav, 
                    'link_before' => '<span>', 
                    'link_after' => '</span>', 
                    'depth' => 2,
                    'container_id' => 'sidenav',
                ) );
            
            echo '</div>';
        
        } else {
        
            get_sidebar( 'page' );
        
        } ?>
        
    </div><!-- .container -->
</div><!-- #page-wrapper -->
    
<?php get_footer(); ?>
