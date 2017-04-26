<?php
/**
 * The template for displaying Author bios
 *
 * @package Simple & Elegant
 * @since Simple & Elegant 1.0
 */
?>

<div class="author-info">
    <div class="author-inner">
        <h2 class="author-heading"><?php esc_html_e( 'Published by', 'simple-elegant' ); ?></h2>
        <div class="author-avatar">
            <a class="author-link" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
                <?php
                /**
                 * Filter the author bio avatar size.
                 *
                 * @since Simple & Elegant 1.0
                 *
                 * @param int $size The avatar height and width size in pixels.
                 */
                $author_bio_avatar_size = apply_filters( 'withemes_author_bio_avatar_size', 150 );

                echo get_avatar( get_the_author_meta( 'user_email' ), $author_bio_avatar_size );
                ?>
            </a>
        </div><!-- .author-avatar -->

        <div class="author-description">
            <h3 class="author-title">
                <a class="author-link" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
                    <?php echo get_the_author(); ?>
                </a>
            </h3>

            <p class="author-bio">
                <?php the_author_meta( 'description' ); ?>
            </p><!-- .author-bio -->
            
            <?php withemes_author_social(); ?>

        </div><!-- .author-description -->
    </div><!-- .author-inner -->
</div><!-- .author-info -->
