<?php
/**
 * Template Name: Press
 *
 * @package Simple & Elegant
 * @since Simple & Elegant 1.0
 */

get_header(); ?>

<div id="page-wrapper">
    <div class="container">
    
            <?php
            // Start the loop.
            while ( have_posts() ) : the_post();

                // Include the page content template.
                get_template_part( 'loops/content', 'page' );

                // If comments are open or we have at least one comment, load up the comment template.
                if ( comments_open() || get_comments_number() ) :
                    comments_template();
                endif;

            // End the loop.
            endwhile;
            ?>
        
		<section id="press-items">
			<?php query_posts('posts_per_page=100&post_type=press_piece'); ?>
			<?php while ( have_posts() ) : the_post(); 
				$press_title = get_field('press_title');
				$press_outlet = get_field('press_outlet');
				$press_link = get_field('press_link');
				$press_logo = get_field('press_logo');
				$size = "full";
				$press_video = get_field('press_video');
			?>
			

			
		
			

		<div class="press-item-container">	
			<div class="single-press-item">		
				<?php if($press_logo) { ?>	
					<a href="<?php echo $press_link; ?>" target="_blank"><h3 class="single-press-item-outlet"><?php echo $press_outlet; ?></h3></a>
				
				
					<?php echo wp_get_attachment_image( $press_logo, $size );  ?>
				<?php } ?>
						
					
				<?php if($press_video) { ?>
						<?php echo $press_video; ?>
				<?php } ?>	
						
			</div>
			
			
			
		
				<h4 class="single-press-item-title"><?php echo $press_title; ?></h4>
			

			
		</div>
			<?php endwhile; ?>
			<?php wp_reset_query(); ?>
		</section>
    </div><!-- .container -->
</div><!-- #page-wrapper -->
    
<?php get_footer(); ?>
