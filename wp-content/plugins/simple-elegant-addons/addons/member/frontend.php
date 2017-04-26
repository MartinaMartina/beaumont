<?php
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

?>
<div class="<?php echo esc_attr( $member_class ); ?>">

    <?php
    // social
    $social_urls = explode(',',$social);
    $social_html = '';
    foreach ($social_urls as $social_url){
        $a = explode('|',$social_url);
        $a = array_map('trim',$a);
        if (count($a) < 2) continue;
        $title = str_replace('-',' ',$a[0]);
        $title = ucfirst($title);
        
        $a[0] = strtolower($a[0]);
        $a[0] = str_replace( 'email', 'envelope', $a[0] );
        $a[0] = str_replace( 'youtube', 'youtube-play', $a[0] );
        
        $social_html .= '<li><a href="'.esc_url($a[1]).'" target="_blank" class="has-tip" title="'.esc_attr($title).'"><i class="fa fa-'.esc_attr($a[0]).'"></i></a></li>';
    }
if ( $social_html ) {
    $social_html = '<div class="member-social"><ul>' . $social_html . '</ul></div>';
}
if ( 'description' != $social_position ) $social_position = 'rollover';

// image
if ($image) {?>

    <figure class="member-image">

    <?php echo $image;

    if ($social_html && 'rollover' == $social_position ) {
        echo $social_html;
    } ?>

    </figure><!-- .member-image -->

    <?php } ?>

<div class="member-text">
    <?php
    if ($name) {
        if ( 'h4' != $name_tag && 'h2' != $name_tag ) $name_tag = 'h3';
        echo '<' . $name_tag . ' class="member-name">' . $name . '</' . $name_tag . '>';
    }

    // content
    $content = trim($content);
    if ($content) echo '<div class="member-desc">' . do_shortcode($content). '</div>';

if ($social_html && 'description' == $social_position ) {
    echo $social_html;
} ?>

</div>
</div>