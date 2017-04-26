<?php
add_action( 'wp_enqueue_scripts', 'withemes_css', 200 );
if (!function_exists('withemes_css')) :
/**
 * Inline CSS
 *
 * @since 2.0
 */
function withemes_css(){
    
    $prefix = 'withemes_';
    $all_css = array();
    $return = '';
    
    // Preparation
    $unit_arr = withemes_unit_array();
    
    // withemes_css_options function at the end of file
    $options = withemes_css_options();
    $defaults = array(
        'selector'  => '',
        'property'  => '',
        'unit'      => '',
    );
    
    $google_fonts = withemes_google_fonts();
    
    // Font Options
    $positions = array( 'body' => 'Open Sans', 'heading' => 'PT Serif', 'nav' => 'PT Serif' );
    
    foreach ( $positions as $position => $std ) {
        
        $custom_font = trim( get_option( 'withemes_' . $position . '_custom_font' ) );
    
        if ( $custom_font ) {
            $font = $custom_font;
        } else {
            $font = trim( get_option( 'withemes_' . $position . '_font', $std ) );
            $font_data = isset( $google_fonts[ $font ] ) ? $google_fonts[ $font ] : array();
            if ( ! isset( $font_data[ 'category' ] ) ) $font_data[ 'category' ] = '';
            if ( 'display' == $font_data[ 'category' ] ) {
                $fallback = 'cursive';
            } elseif ( 'sans-serif' == $font_data[ 'category' ] || 'serif' == $font_data[ 'category' ] ) {
                $fallback = $font_data[ 'category' ];
            } else {
                $fallback = '';
            }

            $font = '"' . $font . '"';
            if ( $fallback ) $font .= ', ' . $fallback;

        }
        
        ${"{$position}_font"} = $font;
        
    }
    
    /* Complicated Options
    ------------------------------------------------------------------------------------ */
    // Topbar Submenu Caret
    $mainnav_submenu_border_color = trim( get_option( 'withemes_mainnav_submenu_border_color' ) );
    if ( $mainnav_submenu_border_color ) {
        $return .= "#wi-mainnav .menu > ul > li > ul:before {border-bottom-color:{$mainnav_submenu_border_color};}";
    }
    
    // Main Nav Submenu Caret
    $topbarnav_dropdown_border_color = trim( get_option( 'withemes_topbarnav_dropdown_border_color' ) );
    if ( $topbarnav_dropdown_border_color ) {
        $return .= "#topbarnav .menu ul ul:before {border-bottom-color:{$topbarnav_dropdown_border_color};}";
    }
    
    // Footer Social Icon Size
    $footer_social_size = absint( get_option( 'withemes_footer_social_size' ) );
    if ( $footer_social_size > 0 ) {
        $return .= '#footer-bottom .social-list ul li a{width:' . $footer_social_size . 'px;height:' . $footer_social_size . 'px;}';
    }
    
    // Iconbox Size
    $iconbox_icon_size = absint( get_option( 'withemes_iconbox_icon_size' ) );
    if ( $iconbox_icon_size > 0 ) {
        $return .= '.wi-iconbox .icon{width:' . $iconbox_icon_size . 'px;';
        $return .= 'height:' . $iconbox_icon_size . 'px;';
        $return .= 'line-height:' . $iconbox_icon_size . 'px;}';
    }
    
    // Accent Color
    $accent = trim( get_option( 'withemes_accent' ) );
    if ( $accent ) {
        $return .= "a, blockquote cite, blockquote em, #wi-mainnav .menu > ul > li > a:hover, #wi-mainnav .menu > ul ul li > a:hover, .entry-meta a:hover, .entry-title a:hover, .grid-title a:hover, .list-title a:hover, .widget_archive ul li a:hover, .widget_categories ul li a:hover, .widget_nav_menu ul li a:hover, .widget_meta ul li a:hover, .widget_pages ul li a:hover, .widget_recent_entries ul li a:hover, .widget_recent_comments ul li a:hover, #header-cart a:hover, .woocommerce .star-rating span:before, .wi-testimonial .rating span, .portfolio-catlist ul li a:hover, .portfolio-catlist ul li.current-cat a {color:{$accent}}";
        
        $return .= 'button, input[type="submit"], #footer-bottom .social-list ul li a:hover, .more-link, #respond input[type="submit"]:hover, .tagcloud a:hover, .wpcf7 input[type="submit"], .woocommerce .widget_price_filter .ui-slider .ui-slider-range, .woocommerce .widget_price_filter .ui-slider .ui-slider-handle, .woocommerce span.onsale, .woocommerce ul.products li.product .onsale, .woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt, .woocommerce #respond input#submit.alt:hover, .woocommerce a.button.alt:hover, .woocommerce button.button.alt:hover, .woocommerce input.button.alt:hover, .woocommerce a.add_to_cart_button:hover, a.wi-btn, button.wi-btn, .wi-btn.btn-alt:hover, .wi-btn.btn-fill:hover, .vc_progress_bar .vc_single_bar .vc_bar, .wi-iconbox:hover .icon-inner, .member-image .member-social ul li a:hover i, .vc_btn3.vc_btn3-color-grey.vc_btn3-style-modern:focus, .vc_btn3.vc_btn3-color-grey.vc_btn3-style-modern:hover, .vc_btn3.vc_btn3-color-peacoc.vc_btn3-style-modern, .vc_tta.vc_general .vc_tta-tab.vc_active > a, .testimonial-slider .flex-control-paging li a.flex-active, .testimonial-slider .flex-direction-nav a:hover, .rollover-overlay  {background-color:' . $accent . '}';
        
        $return .= 'blockquote, #footer-bottom .social-list ul li a:hover, .vc_btn3.vc_btn3-color-grey.vc_btn3-style-modern:focus, .vc_btn3.vc_btn3-color-grey.vc_btn3-style-modern:hover, .vc_btn3.vc_btn3-color-peacoc.vc_btn3-style-modern, .testimonial-slider .flex-direction-nav a:hover, .entry-title:after, .page-title:after {border-color:' . $accent . '}';
    }
    
    // Accent Darker
    $accent_darker = trim( get_option( 'withemes_accent_darker' ) );
    if ( $accent_darker ) {
    
        $return .= 'button:hover, input[type="submit"]:hover, a.wi-btn:hover, button.wi-btn:hover {background-color:' . $accent_darker . ';}';
    
    }
    
    // Font Face
    $positions = array(
        'body' => 'body, input, textarea, button',
        'heading' => '.mfp-title, h1, h2, h3, h4, h5, h6, blockquote, th, .wp-caption-text, button, input[type="submit"], .slicknav_menu, #wi-copyright, .more-link, .navigation .post-title, article.comment-body .fn, .reply, .comment-notes, .logged-in-as, #respond p label, .widget_archive ul li, .widget_categories ul li, .widget_nav_menu ul li, .widget_meta ul li, .widget_pages ul li, .widget_recent_comments ul li, .widget_recent_entries ul li a, .tagcloud a, #wp-calendar caption, .null-instagram-feed .clear a, body .mc4wp-form label, body .mc4wp-alert, .wpcf7 input[type="submit"], .woocommerce a.added_to_cart, .woocommerce div.product p.price, .woocommerce div.product span.price, .woocommerce div.product .woocommerce-tabs ul.tabs li a, a.wi-btn, button.wi-btn, .vc_progress_bar .vc_single_bar .vc_label, .vc_general.vc_btn3, .vc_tta.vc_general .vc_tta-tab > a, .testimonial-content, .portfolio-catlist ul',
        'nav' => '#wi-mainnav, #topbarnav, #mobilenav, #mobile-topbarnav',
    );
    
    foreach ( $positions as $position => $selector ) {
        
        $return .= "{$selector} {font-family:{${"{$position}_font"}}}";
        
    }
    
    /* Simple Options
    ------------------------------------------------------------------------------------ */
    foreach ( $options as $id => $css_arr ) : 
    
    if ( is_numeric( $id ) ) continue;
    
    extract( wp_parse_args( $css_arr, $defaults ) );
    
    $value = trim( get_option( $prefix . $id ) );
    if ( '' === $value ) continue;
    if ( ! $selector || ! $property ) continue;
    if ( in_array( $property, $unit_arr ) && '' == $unit )
        $unit = 'px';
    
    if ( is_numeric( $value ) && $unit ) $value .= $unit;
    
    if ( 'background-image' == $property ) {
        $value = esc_url($value);
        $value = "url({$value})";
    }
    if ( 'content' == $property ) {
        $value = str_replace( '"', '', $value );
        $value = str_replace( "'", '', $value );
        $value = '"' . $value . '"';
    }
    
    // font face
    if ( 'font-family' == $property ) {
        if ( 'body' == $value ) {
            $value = $body_font;
        } elseif ( 'heading' == $value ) {
            $value = $heading_font;
        }
    }
    
    // css3
    $properties = array( $property );
    switch( $property ) {
        case 'transition':
            $properties = array( '-webkit-transition', 'transition' );
        break;
        case 'transform':
            $properties = array( '-webkit-transform', 'transform' );
        break;
        default:
        break;
    }
    
    foreach ( $properties as $prop ) {
        if ( ! isset( $all_css[ $selector ]  ) ) $all_css[ $selector ] = array();
        $all_css[ $selector ][] = "{$prop}:{$value}";
    }
    
    endforeach; // foreach options
    
    foreach ( $all_css as $selector => $css_str ) {
        $css_str = join( ';', $css_str );
        $return .= "{$selector}{{$css_str}}";
    }
    
    
    
    /* Container Width
    ----------------------- */
    $container_w = absint( get_option('withemes_container_width') );
    if ( $container_w ) {
        $return .= '@media only screen and (min-width: 1081px ) {';
        $return .= '.container {';
        $return .= 'width:' . $container_w . 'px;';
        $return .= '}';
        $return .= '}';
    }
    
    /* Selection Color
    ----------------------- */
    $selection_color = trim ( get_option( 'withemes_selection_color' ) );
    if ( $selection_color ) {
        
        $selection_text_color = trim( get_option('withemes_selection_text_color') );
        if ( ! $selection_text_color ) $selection_text_color = '#fff';
        
        $return .= '::-moz-selection {'; /* Code for Firefox */
        $return .= "background:{$selection_color};";
        $return .= "color:{$selection_text_color};";
        $return .= '}';
        
        $return .= '::selection {'; /* Code for Firefox */
        $return .= "background:{$selection_color};";
        $return .= "color:{$selection_text_color};";
        $return .= '}';
    }
    
    /* Custom CSS
    ------------------------------------------------------------------------------------ */
    $custom_css = trim( get_option( 'withemes_custom_css' ) );
    if ( !empty( $custom_css ) ) {
        $return .= $custom_css;
    }
    
    // Hook for developers
    $return = apply_filters( 'withemes_css', $return );
    
    // attach it to <head />
    if ( class_exists( 'Withemes_Addons' ) && defined( 'WPB_VC_VERSION' ) ) {
        wp_add_inline_style( 'wi-shortcodes', $return );
    } else {
        wp_add_inline_style( 'wi-style', $return );
    }
}
endif;

add_filter( 'withemes_css', 'withemes_page_css' );
if ( ! function_exists( 'withemes_page_css' ) ) : 
/**
 * Single Page CSS
 *
 * @since 2.0
 */
function withemes_page_css( $css ) {

    if ( ! is_page() ) return $css;
    global $post;
    $padding_top = trim( get_post_meta( $post->ID, '_withemes_padding_top', true ) );
    $padding_bottom = trim( get_post_meta( $post->ID, '_withemes_padding_bottom', true ) );
    
    if ( is_numeric( $padding_top ) ) $padding_top .= 'px';
    if ( is_numeric( $padding_bottom ) ) $padding_bottom .= 'px';
    
    if ( '' != $padding_top ) $css .= "#page-wrapper {padding-top:{$padding_top} !important}";
    if ( '' != $padding_bottom ) $css .= "#page-wrapper {padding-bottom:{$padding_bottom} !important}";
    
    return $css;
    
}
endif;

if ( ! function_exists( 'withemes_unit_array' ) ) :
/**
 * Returns array of css properties having px as default unit
 *
 * @since 2.0
 */
function withemes_unit_array() {
    
    return array( 'font-size', 'background-size', 'border-width', 'border-radius', 'border-top-right-radius', 'border-top-left-radius', 'border-bottom-right-radius', 'border-bottom-left-radius', 'margin', 'margin-top', 'margin-right','margin-bottom', 'margin-left', 'padding', 'padding-top', 'padding-right', 'padding-bottom', 'padding-left', 'width', 'height', 'letter-spacing' );
    
}
endif;

if ( ! function_exists( 'withemes_css_options' ) ) :
/**
 * Lists of css properties
 *
 * We'll render this function by tool 
 * so plz do not edit this function in your child theme
 *
 * @since 2.0
 */
function withemes_css_options() {

    include get_template_directory() . '/inc/css-options.php';
    include get_template_directory() . '/inc/toggles.php';
    
    // list of elements will be ignored by toggle conditional
    $ignores = array();
    
    $options = array();
    
    foreach ( $toggles as $id => $option ) {
        
        $toggle = $option[ 'toggle' ];
        $choices = $option[ 'options' ];
        
        $real_value = get_option( $id );
        if ( '' === $real_value && isset( $option[ 'std' ] ) ) $real_value = $option[ 'std' ];

        $not_exclude = array();
        if ( isset( $toggle[ $real_value ] ) ) {
            $not_exclude = $toggle[ $real_value ];
            if ( is_string( $not_exclude ) ) $not_exclude = array( $not_exclude );
        }

        foreach ( $toggle as $val => $dependent_elements ) {

            // don't care about real value
            if ( $val === $real_value ) continue;

            if ( is_string( $dependent_elements ) ) $dependent_elements = array( $dependent_elements );
            foreach ( $dependent_elements as $dependent_element ) {

                // not intersect with the real value
                if ( ! in_array( $dependent_element, $not_exclude ) ) {
                    $ignores[] = $dependent_element;
                }

            }
        }
    
    }
    
    foreach ( $reg_options as $id => $option ) {
        
        if ( in_array( $id, $ignores ) ) continue;
        
        $options[ $id ] = $option;
    }
    
    return $options;
    
}
endif;
?>