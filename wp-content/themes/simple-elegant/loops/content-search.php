<?php
/**
 * The template part for displaying results in search pages
 *
 * Learn more: {@link https://codex.wordpress.org/Template_Hierarchy}
 *
 * @package Simple & Elegant
 * @since Simple & Elegant 1.0
 * @modified 2.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('post-list post-search'); ?>>
    
    <?php if ( has_post_thumbnail() ) : ?>
    
    <figure class="post-list-thumbnail">
    
        <a href="<?php the_permalink(); ?>">
            
            <?php the_post_thumbnail( 'thumbnail' ); ?>
            
        </a>
    
    </figure><!-- .post-list-thumbnail -->
    
    <?php endif; ?>
    
    <div class="list-section">
	
        <header class="list-header">

            <?php the_title( sprintf( '<h2 class="list-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

            <?php if ( 'post' == get_post_type() ) : ?>
            <?php withemes_grid_meta(); ?>
            <?php endif; ?>

        </header><!-- .list-header -->

        <div class="list-content">
            <?php the_excerpt(); ?>
        </div><!-- .list-content -->
        
    </div><!-- .list-section -->

</article><!-- #post-## -->
