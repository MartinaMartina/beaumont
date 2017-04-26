<?php
extract( $args );
extract( wp_parse_args( $instance, array(
    'title' => '',
    'category' => '',
    'format' => '',
    'orderby' => '',
) ) );
echo $before_widget;

$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
if ( !empty( $title ) ) {	
    echo $before_title . $title . $after_title;
}

$number = ( int ) $number;

$query_args = array(
    'post_type' => 'post',
    'posts_per_page' => $number,
    
    'ignore_sticky_posts'   =>  true,
    'cache_results' => false,
);

// category
if ( $category && 'all' !== $category ) {
    $query_args[ 'cat' ] = (int) $category;
}

// Post Format
if ( 'video' == $format || 'gallery' == $format || 'audio' == $format ) {
    $query_args['tax_query' ] = array(
        array(
            'taxonomy' => 'post_format',
            'field'    => 'slug',
            'terms'    => array( 'post-format-' . $format ),
        ),
    );
}
        
// orderby
if ( 'date' == $orderby || 'modified' == $orderby || 'comment_count' == $orderby ) {
    $query_args[ 'order' ] = 'DESC';
} else {
    $query_args[ 'order' ] = 'ASC';
}
$query_args[ 'orderby' ] = $orderby;

// Starts Query
$list = get_posts( $query_args );

if ( count( $list ) > 0 ) :

global $post;

echo '<div class="post-widget-container">';

foreach( $list as $post ) : setup_postdata( $post );

?>
<article <?php post_class( 'post-widget' ); ?>>
    
    <div class="post-inner">

        <?php if ( has_post_thumbnail() ) { ?>

        <figure class="post-widget-thumbnail">
            
            <a href="<?php the_permalink(); ?>">
            
                <?php the_post_thumbnail( 'wi-medium', array( 'class' => 'image-fadein' ) ); ?>
                
            </a>
            
        </figure><!-- .post-widget-thumbnail -->

        <?php } ?>

        <div class="post-widget-section">
            
            <header class="post-widget-header">

                <h3 class="post-widget-title" title="<?php echo esc_attr( get_the_title() ); ?>">

                    <a href="<?php the_permalink(); ?>" rel="bookmark">
                        
                        <?php the_title(); ?>
                    
                    </a>

                </h3><!-- .post-widget-title -->

                <div class="post-widget-meta">
                    
                    <?php echo get_the_date(); ?>
                    
                </div><!-- .post-widget-meta -->
                
            </header>

        </div><!-- .post-widget-section -->
        
    </div><!-- .post-inner -->

</article><!-- .post-grid -->

<?php

endforeach;

echo '</div>'; // .blog-grid

wp_reset_postdata();

endif;

wp_reset_query();

echo $after_widget;