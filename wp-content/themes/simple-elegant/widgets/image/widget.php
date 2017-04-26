<?php
extract( $args );
extract( wp_parse_args( $instance, array(
    'title' => '',
    'image' => '',
    'url' => '',
    'url_target' => '',
    'desc' => '',
    'align' => '',
) ) );
echo $before_widget;

$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
if ( !empty( $title ) ) {

    echo $before_title . esc_html( $title ) . $after_title;

}

/* Render Image
-------------------------------------------------------------------------------------- */
?>
<div class="wi-widget-image">
    
    <?php if ( $image ) {
    
    $attrs = array( 'class' => 'image-fadein' ); ?>
    
    <figure class="image-figure">
        
        <?php if ( !empty($url) ) { if ( $url_target != '_blank' ) { $url_target = '_self'; } ?>
        
        <a href="<?php echo esc_url( $url ); ?>" target="<?php echo esc_attr( $url_target ); ?>" class="image-link">
                <?php echo wp_get_attachment_image ( $image, 'full', false, $attrs ); ?>
        </a>
        
        <?php } else { ?>
        
        <?php echo wp_get_attachment_image ( $image, 'full', false, $attrs ); ?>
        
        <?php } ?>
        
    </figure>
    
    <?php } ?>
    
    <?php $align_class = "align-{$align}"; ?>
    
    <?php if ( !empty( $desc ) ) { ?>

    <div class="image-desc <?php echo esc_attr( $align_class ); ?>">

        <?php echo wpautop( do_shortcode( $desc ) ); ?>

    </div><!-- .image-desc -->

    <?php } ?>
    
</div><!-- .wi-widget-image -->

<?php echo $after_widget;