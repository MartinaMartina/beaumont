<?php
$content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content
$classes = array( 'pricing-column' );

// Button
$buttonClass = new Withemes_Button();
$button_rendered = $buttonClass->shortcode( $atts );

$classes = join( ' ', $classes );
?>

<div class="<?php echo esc_attr( $classes ); ?>">
    
    <div class="pricing-column-inner">
        
        <h3 class="pricing-title"><?php echo $title; ?></h3>
        
        <div class="pricebox">
        
            <div class="wi-price">
                
                <span class="price-unit"><?php echo $price_unit; ?></span>
                <span class="main-price"><?php echo $price; ?></span>
                
            </div><!-- .wi-price -->
            
            <div class="per"><?php echo $per; ?></div>
        
        </div><!-- .pricebox -->
        
        <div class="pricing-features">
        
            <?php echo do_shortcode( $content ); ?>
        
        </div>
        
        <?php if ( $button_rendered ) : ?>
        
        <div class="pricing-cta">
            
            <?php echo $button_rendered; ?>
            
        </div><!-- .pricing-cta -->
        
        <?php endif; ?>
        
    </div><!-- .pricing-content -->
    
</div>