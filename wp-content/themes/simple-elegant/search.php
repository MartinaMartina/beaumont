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
            
            <header class="page-header">
                
                <h1><?php printf( esc_html__( 'Search results for "%s"', 'simple-elegant' ), get_search_query() ); ?></h1>
                
			</header><!-- .page-header -->

		<?php if ( have_posts() ) : ?>
            
            <div class="wi-blog blog-list blog-search" id="wi-blog">

                <?php
                // Start the loop.
                while ( have_posts() ) : the_post();

                    get_template_part( 'loops/content', 'search' );

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

<?php get_footer();