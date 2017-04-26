<?php
/**
 * The template for displaying all single posts and attachments
 *
 * @package Simple & Elegant
 * @since Simple & Elegant 1.0
 */

get_header(); ?>

<div id="page-wrapper">
    <div class="container">

	   <div id="primary">
           
           <?php
            // Start the loop.
            while ( have_posts() ) : the_post();

                /*
                 * Include the post format-specific template for the content. If you want to
                 * use this in a child theme, then include a file called called content-___.php
                 * (where ___ is the post format) and that will be used instead.
                 */
                get_template_part( 'loops/content', get_post_format() );

                // If comments are open or we have at least one comment, load up the comment template.
                if ( comments_open() || get_comments_number() ) :
                    comments_template();
                endif;

                // Previous/next post navigation.
                the_post_navigation( array(
                    'next_text' => '<span class="meta-nav" aria-hidden="true">' . esc_html__( 'Next', 'simple-elegant' ) . '</span> ' .
                        '<span class="screen-reader-text">' . esc_html__( 'Next post:', 'simple-elegant' ) . '</span> ' .
                        '<span class="post-title">%title</span>',
                    'prev_text' => '<span class="meta-nav" aria-hidden="true">' . esc_html__( 'Previous', 'simple-elegant' ) . '</span> ' .
                        '<span class="screen-reader-text">' . esc_html__( 'Previous post:', 'simple-elegant' ) . '</span> ' .
                        '<span class="post-title">%title</span>',
                ) );

            // End the loop.
            endwhile;
            ?>

		</div><!-- #primary -->
        
        <?php get_sidebar( 'single' ); ?>
        
	</div><!-- .container -->
</div><!-- #page-wrapper -->

<?php get_footer(); ?>