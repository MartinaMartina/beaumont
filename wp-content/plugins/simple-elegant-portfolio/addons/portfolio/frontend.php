<?php
global $wp_query;
$portfolio_classes = array( 'wi-portfolio' );

    /* number */
$number = (int) trim($number);

    /* get portfolio categories */
$portfolio_categories = get_terms('portfolio_category');
$query_args = array( 
    'post_type' 			=> 	'portfolio',
    'posts_per_page' 		=> 	$number,
    'ignore_sticky_posts'   =>  true,
);

if ( 'true' == $pagination ) {
    $paged = is_front_page() ? get_query_var('page') : get_query_var('paged');
    $query_args[ 'paged' ] = $paged;
} else {
    $query_args[ 'no_found_rows' ] = true;
    $query_args[ 'cache_results' ] = false;
}

// Column
if ( ! $column ) $column = get_option( 'withemes_portfolio_column' );
if ( '2' != $column && '4' != $column ) $column = '3';
$portfolio_classes[] = 'column-' . $column;

// Style
if ( ! $style ) $style = get_option( 'withemes_portfolio_item_style' );
if ( '2' != $style && '3' != $style ) $style = '1';
$portfolio_classes[] = 'portfolio-style-' . $style;

    /* QUERY */
$portfolio_query = new WP_Query( $query_args );

if ( $portfolio_query->have_posts() ):

$portfolio_classes = join(' ',$portfolio_classes);
?>
<div class="wi-portfolio-wrapper">

    <?php if ( $catlist == 'true' ) : 
        $args = array(
            'title_li' => '',
            'echo' => false,
            'depth' => 1,
            'taxonomy' => 'portfolio_category',
            'hierarchical' => false,
        );
        $catlist = '<div class="portfolio-catlist"><ul>' . wp_list_categories($args) . '</ul></div>';
    ?>
    <div class="catlist-wrapper">
        <?php if ( trim( $content )!= '') : ?>
        <div class="row">
            <div class="col col-1-2 content-along">
                <?php echo $content; ?>
            </div>
            <div class="col col-1-2 col-cats">
                <?php echo $catlist; ?>
            </div>
        </div>
        <?php else: ?>
            <?php echo $catlist; ?>
        <?php endif; ?>
    </div>
    <?php endif; ?>

    <div class="<?php echo esc_attr( $portfolio_classes ); ?>">
        
        <?php while ( $portfolio_query->have_posts() ): $portfolio_query->the_post();

            include SIMPLE_ELEGANT_PORTFOLIO_PATH . 'templates/content.php';

        endwhile;?>
        
    </div><!-- .wi-portfolio -->

    <?php if ( $pagination == 'true' && function_exists('withemes_pagination') ) : ?>
    <?php
        withemes_pagination( $portfolio_query );
    ?>
    <?php endif; ?>

</div>
<?php

endif; // have_posts

wp_reset_query();