<?php
// button text is mandatory
if ( ! $text ) return;
$class = array( 'wi-btn' );
$attrs = array();

// link
$link = vc_build_link( $link );
if ( $link[ 'url' ] ) {
    $attrs[] = 'href="' . esc_url( $link[ 'url' ] ) . '"';
    $attrs[] = 'title="' . esc_attr( $link[ 'title' ] ) . '"';
    $attrs[] = 'target="' . esc_attr( $link[ 'target' ] ) . '"';
} elseif ( isset( $atts[ 'url' ] ) && $atts[ 'url' ] ) {
    $attrs[] = 'href="' . esc_url( $atts[ 'url' ] ) . '"';
    if ( isset( $atts[ 'target' ] ) && $atts[ 'target' ] ) {
        $attrs[] = 'target="' . esc_attr( $atts[ 'target' ] ) . '"';
    }
}

// size
if ( 'small' != $size && 'large' != $size ) $size = 'normal';
$class[] = 'btn-' . $size;

// style
$predefined_styles = array(
    'primary', 'black', 'white', 'gray', 'alt', 'outline', 'fill', 'custom'
);
if ( ! in_array( $style, $predefined_styles ) ) $style = 'primary';
$class[] = 'btn-' . $style;

// shape
if ( 'rounded' != $shape ) {
    $shape = 'square';
}
$class[] = 'btn-' . $shape;

// icon
$icon_html = $icon_class = '';
if ( 'withemes_budicon' == $icon_set ) {
    $icon_class = $icon_budicon;
    if ( ! $icon_class ) $icon_class = 'bi_com-email';
} elseif ( 'fontawesome' == $icon_set ) {
    $icon_class = $icon;
    if ( ! $icon_class ) $icon_class = 'fa fa-gift';
}
if ( $icon_class ) {
    $icon_html = '<i class="' . esc_attr( $icon_class ) . '"></i>';
}

// onclick
if ( $onclick ) {
    $attrs[] = 'onclick="' . esc_attr( $onclick ) . '"';
}

$class = join( ' ', $class );

$attrs[] = 'class="' . esc_attr( $class ). '"';
$attrs = join( ' ', $attrs );
?>
<a <?php echo $attrs; ?>><?php echo $text; ?><?php echo $icon_html; ?></a>