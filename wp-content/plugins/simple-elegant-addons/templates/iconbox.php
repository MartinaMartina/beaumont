<?php
if (!function_exists('withemes_shortcode_iconbox')){
function withemes_shortcode_iconbox( $atts, $content = null ) {
    extract( shortcode_atts( array(
        'layout' => 'top',
        'icon_type' => '',
        'image' => '',
        'icon' => 'fa fa-flag',
        'icon_budicon' => 'bi_com-email',
        'icon_link' => '',
        
        'title' => 'Iconbox title',
        'title_tag' => 'h4',
        
        'animation' => '',
        'delay' => '',
        
        // ICON DESIGN
        'icon_size' => '',
        'icon_font_size' => '',
        'icon_normal_color' => '',
        'icon_normal_background' => '',
        'icon_color' => '',
        'icon_background' => '',
        
        // TITLE DESIGN
        
        
    ), $atts ) );
    $content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content
    
    global $iconbox_id;
    if (!isset($iconbox_id) || !$iconbox_id) $iconbox_id = 1;
    else $iconbox_id = intval($iconbox_id) + 1;
    
    /* Vars
    ------------------------ */
    $icon_html = '';
    $iconbox_class = array( 'wi-iconbox' , 'iconbox-id-'.$iconbox_id, 'wpb_content_element', 'vc_clearfix' );
    $iconbox_css = array();
    
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
    
    /* CSS
    ------------------------ */
    /* normal state */
    $iconbox_css = '#iconbox-'.$iconbox_id.'.type-icon .icon-inner {';
    if ( $icon_normal_color ) {
        $iconbox_css .= 'color:' . $icon_normal_color . ';';
    }
    if ( $icon_normal_background ) {
        $iconbox_css .= 'background:' . $icon_normal_background . ';';
    }
    $iconbox_css .= '}';
    
    /* hover state */
    $iconbox_css .= '#iconbox-'.$iconbox_id.'.type-icon:hover .icon-inner {';
    if ( $icon_color ) {
        $iconbox_css .= 'color:' . $icon_color  . ';';
    }
    if ( $icon_background ) {
        $iconbox_css .= 'background:' . $icon_background . ';';
    }
    $iconbox_css .= '}';
    
    /* size & font size */
    $iconbox_css .= '#iconbox-'.$iconbox_id.' .icon, #iconbox-'.$iconbox_id.' .image {';
    
    $icon_size = absint( $icon_size );
    if ( $icon_size > 10 ) {
        if ( 'image' != $icon_type ) {
            $iconbox_css .= 'width:' . $icon_size . 'px;'; 
            $iconbox_css .= 'height:' . $icon_size . 'px;';
            $iconbox_css .= 'line-height:' . $icon_size . 'px;';
        } else {
            $iconbox_css .= 'width:' . $icon_size . 'px;'; 
        }
    }
    
    $icon_font_size = absint( $icon_font_size );
    if ( $icon_font_size > 10 && 'image' != $icon_type ) {
        $iconbox_css .= 'font-size:' . $icon_font_size . 'px';
    }
    
    $iconbox_css .= '}';
    
    /* Animation
    ------------------------ */
    $delay = absint( $delay );
    if ( 'true' == $animation ) $iconbox_class[] = 'animation_element';
    
    /* Title
    ------------------------ */
    
    /* Render
    ------------------------ */
    $iconbox_style = '<style>';
    $iconbox_style .= $iconbox_css;
    $iconbox_style .= '</style>';
    
    $iconbox_class = join(' ',$iconbox_class);
    $return = '<div class="' .esc_attr( $iconbox_class ). '" id="iconbox-'.esc_attr($iconbox_id).'" data-delay="' . $delay . '">';

    $return .= $iconbox_style;
    
    $return .= $icon_html . '<div class="iconbox-text"><' . $title_tag . ' class="iconbox-title">' . trim( $title ) . '</' . $title_tag . '>' ;

    $return .= '<div class="iconbox-desc">'.do_shortcode($content) . '</div></div>';
    $return .= '</div>';

    return $return;
}
}
?>