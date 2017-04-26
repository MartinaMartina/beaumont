<?php
/**
 * The template used for displaying page content
 *
 * @package Simple & Elegant
 * @since Simple & Elegant 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    
    <?php withemes_page_title(); ?>
	
    <?php if ( has_post_thumbnail() && !is_front_page() ) : ?>
    <figure id="page-thumbnail">
        <?php the_post_thumbnail(); ?>
    </figure>
    <?php endif; ?>

	<div class="entry-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'simple-elegant' ) . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
				'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'simple-elegant' ) . ' </span>%',
				'separator'   => '<span class="screen-reader-text">, </span>',
			) );
		?>
	</div><!-- .entry-content -->

    <div class="clearfix"></div>
</article><!-- #post-## -->
