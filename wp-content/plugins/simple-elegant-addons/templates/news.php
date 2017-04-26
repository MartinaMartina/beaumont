<?php
if (!function_exists('withemes_shortcode_news')){
function withemes_shortcode_news( $atts, $content = null ) {
    extract( shortcode_atts( array(
        'number' => '2',
        'date' => '',
        'categories' => '',
        'excerpt' => '',
        'excerpt_length' => '',
        'more' => '',
    ), $atts ) );
    //$content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content
    
    $args = array(
        'post_type' => 'post',
        'posts_per_page' => intval($number),
    );
    $latest = new WP_Query($args);
    $latest->query_posts();
    if ( $latest->have_posts() ): 
    
    ob_start();
    ?>

<div class="latest-news">
    
    <?php
    while( $latest->have_posts() ): $latest->the_post();
    ?>
    
<article class="article-news">
    <?php if ( has_post_thumbnail() ) : ?>
    <figure class="news-thumbnail">
        <a href="<?php the_permalink();?>">
            <?php the_post_thumbnail('thumbnail'); ?>
        </a>
    </figure>
    <?php endif; ?>
    <div class="news-text">
        <h4 class="news-title">
            <a href="<?php the_permalink();?>">
                <?php the_title(); ?>
            </a>
        </h4>
        <?php if ( $date== 'true' || $categories=='true') :?>
        <div class="news-meta">
            
            <?php if ( $date == 'true' ): ?>
            <div class="ele ele-time">
                <time datetime="<?php echo get_the_date('c');?>" title="<?php echo esc_attr(get_the_date(get_option('date_format')));?>"><?php echo get_the_date(get_option('date_format'));?></time>
            </div>
            <?php endif; ?>
            
            <?php if ( $categories == 'true' ) : ?>
            <div class="ele ele-categories">
                <?php if (!get_theme_mod('wi_disable_blog_categories')):?>
                    <?php if ( get_the_category_list(__( '<span class="sep">/</span>', 'wi' )) ):?>
                    <span class="grid-cats">
                        <?php echo get_the_category_list(__( '<span class="sep">/</span>', 'wi' )); ?>
                    </span><!-- .grid-cats -->
                    <?php endif; ?>
                <?php endif; ?>
            </div>
            <?php endif; ?>
            
        </div>
        <?php endif; // show meta ?>
        
        <?php if ( $excerpt == 'true' ): ?>
        <?php $excerpt_length = absint($excerpt_length); if ($excerpt_length <= 0 || $excerpt_length >= 100 ) $excerpt_length = 20; ?>
        <div class="news-excerpt">
            <?php if (function_exists('withemes_subword')):?>
            <p><?php echo withemes_subword( get_the_excerpt(), 0, $excerpt_length ); ?> &hellip;
                <?php if ( $more == 'true' ): ?>
                <a href="<?php the_permalink();?>" class="more"><?php _e('More &raquo;','simple-elegant'); ?></a>
                <?php endif; // more ?>
            </p>
            <?php endif; // function exists ?>
        </div>
        <?php endif; // exceprt ?>
    </div>
</article>
    
    <?php
    endwhile; // while have posts
    ?>

</div><?php // end latest news ?>
    <?php
    endif; // have posts
    
    wp_reset_query();
    
    $return = ob_get_clean();
    
    return $return;
}
}
?>