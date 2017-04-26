<?php
/**
 * The default template for displaying content
 *
 * Used for index/archive.
 *
 * @package Simple & Elegant
 * @since Simple & Elegant 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('wi-article'); ?>>
	
	<header class="entry-header">
        
		<?php
			if ( is_single() ) :
				the_title( '<h1 class="entry-title">', '</h1>' );
			else :
				the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
			endif;
		?>
        
        <?php withemes_entry_meta(); ?>
        
	</header><!-- .entry-header -->
    
    <?php
		// Post thumbnail.
		withemes_post_thumbnail();
	?>

	<div class="entry-content">
		<?php
			/* translators: %s: Name of current post */
			the_content( esc_html__( 'Continue reading', 'simple-elegant' ) );

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
    
    <?php
		$tags_list = get_the_tag_list( '', _x( ', ', 'Used between list items, there is a space after the comma.', 'simple-elegant' ) );
		if ( is_single() && $tags_list ) {
			printf( '<div class="entry-tags"><span class="tag-label">%1$s </span>%2$s</div>',
				_x( 'Tags:', 'Used before tag names.', 'simple-elegant' ),
				$tags_list
			);
		}
	?>

	<?php
		// Author bio.
		if ( is_single() && get_the_author_meta( 'description' ) ) :
			get_template_part( 'loops/author-bio' );
		endif;
	?>

</article><!-- #post-## -->
