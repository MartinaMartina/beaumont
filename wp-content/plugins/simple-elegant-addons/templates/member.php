<?php
if (!function_exists('withemes_shortcode_member')){
function withemes_shortcode_member( $atts, $content = null ) {
    extract( shortcode_atts( array(
        'image' => '',
        'crop' => 'circle',
        'name' => 'John Doe',
        'name_tag' => 'h3',
        'social'   => 'twitter|https://twitter.com/YOUR_USERNAME,facebook | https://facebook.com/YOUR_USERNAME,instagram | http://instagarm.com/YOUR_USERNAME',
    ), $atts ) );
    $content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content
    
    // class
    $member_class = array( 'wi-member', 'wpb_content_element', 'vc_clearfix' );
    
    // crop mode
    if ( ! in_array( $crop, array( 'circle', 'square', 'landscape', 'portrait', 'full' ) ) ) $crop = 'circle';
    if ( 'circle' == $crop || 'square' == $crop ) $size = 'wi-square';
    elseif ( 'landscape' == $crop ) $size = 'wi-medium';
    elseif ( 'portrait' == $crop ) $size = 'wi-portrait';
    else $size = 'full';
    
    $member_class[] = 'image-crop-' . $crop;
    
    // image
    if ($image) {
        $image = wp_get_attachment_image( $image, $size );
    }
    
    // start rendering
    $member_class = join(' ',$member_class);
    $return = '<div class="'.esc_attr($member_class).'">';
    
    // social
    $social_urls = explode(',',$social);
    $social_html = '';
    foreach ($social_urls as $social_url){
        $a = explode('|',$social_url);
        $a = array_map('trim',$a);
        if (count($a) < 2) continue;
        $title = str_replace('-',' ',$a[0]);
        $title = ucfirst($title);
        $social_html .= '<li><a href="'.esc_url($a[1]).'" target="_blank" title="'.esc_attr($title).'"><i class="fa fa-'.esc_attr($a[0]).'"></i></a></li>';
    }
    if ($social_html) {
        $social_html = '<div class="member-social"><ul>' . $social_html . '</ul></div>';
    }
    
    // image
    if ($image) {
        
        $return .= '<figure class="member-image">' ;
        
        $return .= $image;
        
        $return .= $social_html;
        
        $return .= '</figure>';
    }
    
    // header
    $return .= '<div class="member-text">';
    if ($name) {
        if ( 'h4' != $name_tag && 'h2' != $name_tag ) $name_tag = 'h3';
        $return .= '<' . $name_tag . ' class="member-name">' . $name . '</' . $name_tag . '>';
    }
    
    // content
    $content = trim($content);
    if ($content) $return .= '<div class="member-desc">' . do_shortcode($content). '</div>';
    $return .= '</div>'; // member text
    $return .= '</div>'; // .wi-member
    return $return;
}
}
?>