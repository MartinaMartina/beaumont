<?php
$args = array(
    'post_type' => 'post',
    'posts_per_page' => intval($number),
    'ignore_sticky_posts' => true,
);
$latest = new WP_Query( $args );

if ( $latest->have_posts() ) :

$class = array( 'wi-blog', 'blog-grid' );
if ( '2' != $column && '3' != $column ) $column = '4';
$class[] = 'column-' . $column;

$class = join( ' ', $class );
?>

<div class="<?php echo esc_attr( $class ); ?>">

<?php
while( $latest->have_posts() ): $latest->the_post();

    get_template_part( 'loops/content', 'grid' );

endwhile; // while have posts
?>

</div><?php // end .blog-grid ?>
<?php
endif; // have posts

wp_reset_query();