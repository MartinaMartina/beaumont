<?php
if ( 'false' == get_option( 'withemes_related_projects' ) ) return;

global $post;
$current_ID = $post->ID;
$tags = wp_get_post_terms( $current_ID, 'portfolio_category', array( 'fields' => 'ids' ) );
$args = array(
    
    'post_type' => 'portfolio',
    'posts_per_page' => 4,
    
    'ignore_sticky_posts'   =>  true,
    'no_found_rows' => true,
    'cache_results' => false,
    'post__not_in' => array( $current_ID ),
);
if ( !empty( $tags ) ) {
    $args[ 'tax_query'] = array(
		array(
			'taxonomy' => 'portfolio_category',
			'field'    => 'id',
			'terms'    => $tags,
		),
	);
} else {
    return;
}

$query = new WP_Query( $args );

$class = array( 'wi-portfolio', 'column-4' );

$class = join( ' ', $class );

if ( $query->have_posts() ) :
?>

<div class="related-content related-projects">

    <h3 class="related-heading">
        <?php echo esc_html__( 'Related Projects', 'simple-elegant' ); ?>
    </h3>
    
    <div class="<?php echo esc_attr( $class ); ?>">

        <?php while ( $query->have_posts() ) : $query->the_post(); ?>

            <?php include SIMPLE_ELEGANT_PORTFOLIO_PATH . 'templates/content.php'; ?>

        <?php endwhile; // have_posts ?>
        
    </div><!-- .wi-portfolio -->
    
</div><!-- .related-content -->

<?php endif; // have_posts

wp_reset_query();