<?php
/**
 * The template for displaying press pieces
 *
 *
 * @package Simple & Elegant
 * @since Simple & Elegant 1.0
 * @modified since 2.0
 * @added side navigation
 */

get_header(); ?>

<div id="page-wrapper">
    <div class="container">
    
        <div id="primary">
            <?php
            // Start the loop.
            while ( have_posts() ) : the_post();

                // Include the page content template.
                get_template_part( 'loops/content', 'page' );
				$press_title = get_field('press_title');
				$press_outlet = get_field('press_outlet');
				$press_link = get_field('press_link');
				$press_logo = get_field('press_logo');
				$size = "full";
				$press_video = get_field('press_video');


            // End the loop.
            endwhile;
            ?>
        </div><!-- #primary -->

        <?php $nav = get_post_meta( get_the_ID(), '_withemes_side_nav', true );

        if ( $nav ) {
            
            echo '<div id="secondary">';

                wp_nav_menu( array( 
                    'menu' => $nav, 
                    'link_before' => '<span>', 
                    'link_after' => '</span>', 
                    'depth' => 2,
                    'container_id' => 'sidenav',
                ) );
            
            echo '</div>';
        
        } else {
        
            get_sidebar( 'page' );
        
        } ?>
		
		<?php if($press_title) { ?>
		<h2><?php echo $press_title; ?></h2>
		<?php } ?>
		
		<?php if($press_link) { ?>
		<?php echo $press_link; ?>
		<?php } ?>
		
		<?php if($press_logo) { ?>
			<?php echo wp_get_attachment_image( $press_logo, $size );  ?>
		<?php } ?>
		
		<?php if($press_video) { ?>
			<?php echo $press_video; ?>" />
		<?php } ?>
		
		

    </div><!-- .container -->
</div><!-- #page-wrapper -->
    
<?php get_footer(); ?>
