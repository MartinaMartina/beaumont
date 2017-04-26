<?php
/**
 * The template for displaying archive pages
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * If you'd like to further customize these archive views, you may create a
 * new template file for each one. For example, tag.php (Tag archives),
 * category.php (Category archives), author.php (Author archives), etc.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Simple & Elegant
 * @since Simple & Elegant 1.0
 */

get_header(); ?>

<div id="page-wrapper">
    <div class="container">
        
        <div id="primary">

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<?php
					the_archive_title( '<h1 class="archive-title">', '</h1>' );
					the_archive_description( '<div class="taxonomy-description">', '</div>' );
				?>
			</header><!-- .page-header -->
            
            <?php 
            $layout = get_option( 'withemes_archive_layout' );
            if ( ! $layout ) $layout = get_option( 'withemes_blog_layout' );
            if ( 'grid' != $layout && 'list' != $layout ) $layout = 'standard';
            ?>
            
            <div class="wi-blog column-2 blog-<?php echo esc_attr( $layout ); ?>" id="wi-blog">

                <?php
                // Start the Loop.
                while ( have_posts() ) : the_post();

                    /*
                     * Include the Post-Format-specific template for the content.
                     * If you want to override this in a child theme, then include a file
                     * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                     */
                    if ( is_search() ):

                    get_template_part( 'loops/content', 'search' );

                    else:

                    get_template_part( 'loops/content', $layout );

                    endif;

                // End the loop.
                endwhile;
                ?>
                
            </div><!-- .wi-blog -->

            <?php
			// Previous/next page navigation.
			the_posts_pagination( array(
				'prev_text'          => esc_html__( '&larr; Previous', 'simple-elegant' ),
				'next_text'          => esc_html__( 'Next &rarr;', 'simple-elegant' ),
				'before_page_number' => '<span class="meta-nav screen-reader-text">' . esc_html__( 'Page', 'simple-elegant' ) . ' </span>',
			) );

		// If no content, include the "No posts found" template.
		else :

			get_template_part( 'loops/content', 'none' );

		endif;
		?>

		</div><!-- #primary -->

        <?php get_sidebar(); ?>
        
    </div><!-- .container -->
</div><!-- #page-wrapper -->

<?php get_footer();