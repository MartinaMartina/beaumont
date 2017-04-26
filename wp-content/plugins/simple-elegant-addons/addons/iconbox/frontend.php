<?php
$content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content
$icon_html = '';
$iconbox_class = array( 'wi-iconbox' );

/* Layout
------------------------ */
if ( 'left' != $layout && 'right' != $layout ) $layout = 'top';
$iconbox_class[] = 'iconbox-' . $layout;
if ( 'left' == $layout || 'right' == $layout ) $iconbox_class[] = 'iconbox-side';

/* Icon type
------------------------ */
if ($icon_type!='image' && $icon_type != 'thin_icon' ) $icon_type = 'icon';
$iconbox_class[] = 'type-'. str_replace( 'thin_', '', $icon_type );

/* Icon link
------------------------ */
$icon_link = vc_build_link( $icon_link );
if ( $icon_link[ 'url' ] ) {
    $open = '<a href="' . esc_url( $icon_link[ 'url' ] ) . '" title="' . esc_attr( $icon_link[ 'title' ] ) . '" target="' . esc_attr( $icon_link[ 'target' ] ) . '">';
    $close = '</a>';                                                              
} else {
    $open = $close = '';
}

/* Icon html
------------------------ */
if ($icon_type=='icon' ) {
    if ( ! $icon ) $icon = 'fa fa-flag';
    $icon_html = '<i class="'.esc_attr($icon).'"></i>';
    $icon_html = '<div class="icon"><div class="icon-inner">' . $open . $icon_html . $close . '</div></div>';
} elseif ( $icon_type == 'thin_icon' ) {
    if ( ! $icon_budicon ) $icon_budicon = 'bi_com-email';
    $icon_html = '<i class="'.esc_attr($icon_budicon).'"></i>';
    $icon_html = '<div class="icon"><div class="icon-inner">' . $open . $icon_html . $close . '</div></div>';
} else {
    $img = wp_get_attachment_image_src($image,'full');
    if ($img){
        $icon_html = '<img src="'.esc_url($img[0]).'" width="'.esc_attr($img[1]/2).'" height="'.esc_attr($img[2]/2).'" alt="'.esc_attr(get_post_meta($image,'_wp_attachment_image_alt',true)).'" />';
        $icon_html = '<div class="image">' . $open . $icon_html . $close . '</div>';
    }
}

/* Title Tag
------------------------ */
if ( 'h3' != $title_tag && 'h2' != $title_tag ) $title_tag = 'h4';

/* Animation
------------------------ */
$delay = absint( $delay );
if ( 'true' == $animation ) $iconbox_class[] = 'animation_element';

/**
 * Render
 */
$iconbox_class = join(' ',$iconbox_class);
?>

<div class="<?php echo esc_attr( $iconbox_class ); ?>" data-delay="'<?php echo absint( $delay ); ?>'">
    
    <?php echo $icon_html; ?>

    <div class="iconbox-text">

        <?php echo "<{$title_tag} class=\"iconbox-title\">{$title}</{$title_tag}>"; ?>

        <div class="iconbox-desc">

            <?php echo do_shortcode( $content ); ?>

        </div>

    </div><!-- .iconbox-text -->
    
</div><!-- .wi-iconbox -->