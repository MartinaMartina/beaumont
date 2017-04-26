<?php
extract( $args );
extract( wp_parse_args( $instance, array(
    'title' => '',
    'number' => '6',
    'category' => '',
    'column' => '',
) ) );
echo $before_widget;

$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
if ( !empty( $title ) ) {

    echo $before_title . esc_html( $title ) . $after_title;

}

$args = array(
    'post_type'				=>	'portfolio',
    'ignore_sticky_posts'	=>	true,
    'posts_per_page'		=>	$number,
);
if ( $category && is_numeric( $category ) ) {
    $args['tax_query'] = array(array(
        'taxonomy'	=>	'portfolio_category',
        'field'		=>	'id',
        'terms'		=>	array( $category ),
    ),
    );
}

// Column
if ( '2' != $column && '4' != $column ) $column = '3';

$latest = new WP_Query($args);?>
<?php if ( $latest->have_posts() ): ?>

    <div class="wi-latest-project-widget column-<?php echo absint( $column) ; ?>">

    <?php while( $latest->have_posts() ) : $latest->the_post();?>		

        <div class="project-item">
            <div class="post-thumb">
                <a href="<?php the_permalink();?>" title="<?php the_title();?>">
                    <?php if(has_post_thumbnail()):?>
                        <?php the_post_thumbnail('thumbnail');?>
                    <?php else: ?>
                        <img src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" />
                    <?php endif; ?>	
                </a>
            </div><!-- .thumb -->
        </div><!-- .post-item -->

    <?php endwhile; ?>

        <div class="clearfix"></div>

    </div><!-- .wi-latest-portfolio-widget -->

<?php endif; // have posts ?>

<?php wp_reset_query();?>

<?php echo $after_widget;