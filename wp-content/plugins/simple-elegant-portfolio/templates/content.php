<?php
global $post;
$item_classes = array( 'portfolio-item' );

$categories = get_the_term_list ( $post->ID, 'portfolio_category', '', '<span class="sep">&middot;</span>' ) ;

// Thumbnail Ratio
if ( ! isset( $ratio ) || ! $ratio ) $ratio = trim( get_option( 'withemes_portfolio_item_ratio' ) );
$ratio = (string) $ratio;
$explode = explode( ':', $ratio );
$w = isset( $explode[0] ) ? $explode[0] : 0;
$h = isset( $explode[1] ) ? $explode[1] : 0;
$w = absint( $w );
$h = absint( $h );
if ( $h > 0 && $w > 0 ) {
    $ratio_css = ' style="padding-bottom:' . ( $h/$w * 100 ) . '%;"';
} else {
    $ratio_css = '';
}

// Item Style
if ( ! isset( $style ) ) $style = get_option( 'withemes_portfolio_style' );
if ( '2' != $style && '3' != $style ) $style = '1';
$item_classes[] = 'portfolio-item-' . $style;

// Join
$item_classes = join(' ',$item_classes);
?>
<article <?php post_class($item_classes);?>>
	<div class="article-inner">
        
        <?php if ( has_post_thumbnail() ) {
            $thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large' );
            $bg_css = ' style="background-image:url('.esc_url( $thumbnail_src[0] ).');"';
        } else {
            $bg_css = '';
        } ?>
        <div class="bg_thumb">
            <div class="height_element"<?php echo $ratio_css;?>></div>
            <div class="bg_element"<?php echo $bg_css;?>></div>
            
            <a href="<?php the_permalink();?>" rel="bookmark" class="wrap-link"></a>
            
        </div><!-- .bg_thumb -->
        
        <?php /* ------------------------ ITEM STYLE 1 ------------------------ */ ?>
        <?php if ( '1' == $style ) : ?>
        
        <div class="wi-rollover">
            <div class="wi-table">
                <div class="wi-cell">
                    <div class="rollover-content">
                    
                        <h2 class="rollover-title"><a href="<?php the_permalink();?>" rel="bookmark"><?php the_title();?></a></h2>
                        
                        <?php if( !empty($categories) ) : ?>
                        <div class="rollover-meta">
                            <?php echo $categories;?>
                        </div>
                        <?php endif; // categories ?>
                        
                    </div>
                </div>
            </div>
            <div class="rollover-overlay"></div>
        </div><!-- .wi-rollover -->
        
        <?php /* ------------------------ ITEM STYLE 2 ------------------------ */ ?>
        <?php elseif ( '2' == $style ) : ?>
        
        <div class="project-text">
        
            <h2 class="portfolio-item-title">
                
                <?php the_title();?>
                
            </h2><!-- .portfolio-item-title -->
        
        </div><!-- .project-text -->
        
        <a href="<?php the_permalink();?>" rel="bookmark" class="wrap-link"></a>
        
        <?php /* ------------------------ ITEM STYLE 3 ------------------------ */ ?>
        <?php else : ?>
        
        <div class="project-text">
        
            <h2 class="portfolio-item-title">
                
                <a href="<?php the_permalink();?>" rel="bookmark">
                    <?php the_title();?>
                </a>
                
            </h2><!-- .portfolio-item-title -->
            
            <div class="portfolio-item-meta">
            
                <?php echo get_the_date(); ?>
                
            </div><!-- .portfolio-item-meta -->
        
        </div><!-- .project-text -->
        
        <?php endif; // Item Style ?>
		
	</div><!-- .article-inner -->
</article>