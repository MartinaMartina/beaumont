<?php
$classes = array( 'wi-callout' );

$classes = join( ' ', $classes );

// Button
$buttonClass = new Withemes_Button();
$button_rendered = $buttonClass->shortcode( $atts );
?>

<div class="<?php echo esc_attr( $classes ); ?>">

    <div class="callout-message">

        <h2 class="callout-title"><?php echo $title; ?></h2>

        <?php if ( $content ) : ?>

        <div class="callout-content">

            <?php echo do_shortcode( $content ); ?> 

        </div><!-- .callout-content -->

        <?php endif; ?>

    </div><!-- .callout-message -->

    <?php if ( $button_rendered ) : ?>
    <div class="callout-button">

        <?php echo $button_rendered; ?>

    </div><!-- .callout-button -->
    <?php endif; ?>
    
</div>