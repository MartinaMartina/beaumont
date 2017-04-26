<?php
/**
 * The default template for displaying blog grid content
 *
 * Used for index/archive.
 *
 * @package Simple & Elegant
 * @since Simple & Elegant 2.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-grid' ); ?>>
    
    <?php if ( has_post_thumbnail() ) : ?>
    
    <figure class="post-grid-thumbnail">
    
        <a href="<?php the_permalink(); ?>">
            
            <?php the_post_thumbnail( 'wi-medium' ); ?>
            
        </a>
    
    </figure><!-- .post-grid-thumbnail -->
    
    <?php endif; ?>
	
	<header class="grid-header">
        
		<?php the_title( sprintf( '<h2 class="grid-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
        
        <?php withemes_grid_meta(); ?>
        
	</header><!-- .grid-header -->
    
    <div class="grid-content">
        
		<?php the_excerpt(); ?>
        
	</div><!-- .grid-content -->

</article><!-- #post-## -->
