<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * e.g., it puts together the home page when no home.php file exists.
 *
 * Learn more: {@link https://codex.wordpress.org/Template_Hierarchy}
 *
 * @package Simple & Elegant
 * @since Simple & Elegant 1.0
 */

get_header(); ?>

<div id="page-wrapper">
    
    <div class="container">
        
        <div id="primary">

		  <?php if ( have_posts() ) : ?>
            
            <?php $layout = get_option( 'withemes_blog_layout' ); 
            if ( 'grid' != $layout && 'list' != $layout ) $layout = 'standard';
            ?>
            
            <div class="wi-blog column-2 blog-<?php echo esc_attr( $layout ); ?>" id="wi-blog">

                <?php
                // Start the loop.
                while ( have_posts() ) : the_post();

                    get_template_part( 'loops/content', $layout );

                // End the loop.
                endwhile;
                ?>
                
            </div><!-- .wi-blog -->

            <?php
                // Previous/next page navigation.
                the_posts_pagination( array(
                    'prev_text'          => esc_html__( '&laquo; Previous', 'simple-elegant' ),
                    'next_text'          => esc_html__( 'Next &raquo;', 'simple-elegant' ),
                ) );

            // If no content, include the "No posts found" template.
            else :

                get_template_part( 'loops/content', 'none' );

            endif; // have posts
            ?>

		</div><!-- #primary -->

        <?php get_sidebar(); ?>
        
    </div><!-- .container -->
    
</div><!-- #page-wrapper -->

<?php get_footer(); ?>
