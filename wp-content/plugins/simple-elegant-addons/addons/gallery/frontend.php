<?php

// IMAGE SOURCE
if ( 'instagram' != $source ) $source = 'media';

$class = array( 'wi-gallery' );

$column = absint( $column );
if ( $column < 1 || $column > 8 ) $column = 3;
$class[] = 'column-' . $column;

$images = explode ( ',', $images );
$images = array_map( 'trim', $images );
if ( empty( $images ) ) return;

// Lightbox
if ( 'true' == $lightbox ) $class[] = 'wi-lightbox-gallery';

// CSS
$wrapper_style = $item_style = '';
if ( is_numeric( $item_spacing ) && $item_spacing >= 0 ) {
    $pad = $item_spacing/2;
    $wrapper_style = ' style="margin:-' . $pad . 'px;"';
    $item_style = ' style="padding:' . $pad . 'px;"';
}

// Render
$class = join( ' ', $class );
?>

<div class="<?php echo esc_attr( $class );?>"<?php echo $wrapper_style; ?>>

    <?php 
// MEDIA LIBRARY
// ====================
if ( 'media' === $source ) :

$attachments = get_posts( array(
    'posts_per_page' => -1,
    'orderby' => 'post__in',
    'post_type' => 'attachment',
    'post_status' => 'inherit',
    'post__in' => $images,
) );

foreach ( $attachments as $attachment ) :

if ( 'true' == $lightbox ) {
    
    $title = trim( $attachment->post_title );
    $caption = trim( $attachment->post_excerpt );
    
    // attr array
    $attr = array();
    
    $fullsize = wp_get_attachment_image_src( $attachment->ID, 'full' );
    
    if ( $caption ) {
        $attr[] = 'title="' . esc_attr( $caption ) . '"';
    }
    
    $attr = join( ' ', $attr );
    
    $open = '<a href="' . esc_url( $fullsize[0] ) . '" ' . $attr . ' class="lightbox-link">';
    
    $close = '</a>';
    
} else {
    $open = $close = '';
}

    ?>

    <div class="gal-item"<?php echo $item_style; ?>>
        
        <div class="gal-item-wrapper">
        
            <figure class="gal-item-inner">

                <?php echo $open; ?>
                
                <?php
                if ( ! $thumb ) {
                    $thumb = 'wi-square';
                }

                if ( function_exists( 'wpb_getImageBySize' ) ) {

                    $img = wpb_getImageBySize( array(
                        'attach_id' => $attachment->ID,
                        'thumb_size' => $thumb,
                        'class' => 'image-fadein',
                    ) );
                    
                    $img = $img[ 'thumbnail' ];
                    
                } else {
                 
                    $img = wp_get_attachment_image( $attachment->ID, $thumb, false, array( 'class' => 'image-fadein' ) );
                    
                }
                ?>
                
                <?php echo $img; ?>
                
                <?php echo $close; ?>

            </figure>
            
        </div>

    </div><!-- .gal-item -->

<?php endforeach; // attachments ?>
    
<?php    
// INSTAGRAM
// ====================
elseif ( function_exists( 'withemes_get_instagram_photos' ) ) : $photos = withemes_get_instagram_photos( $access_token, $number, $cache_time );
if ( $photos && is_array( $photos ) ) :

foreach ( $photos as $photo )  :

if ( 'true' == $lightbox ) {
    
    $title = $photo[ 'description' ];
    
    // attr array
    $attr = array();
    
    $full_src = '';
    if ( $photo[ 'large' ] ) $full_src = $photo[ 'large' ];
    elseif ( $photo[ 'medium' ] ) $full_src = $photo[ 'medium' ];
    elseif ( $photo[ 'thumbnail' ] ) $full_src = $photo[ 'thumbnail' ];
    
    if ( $title ) {
        $attr[] = 'title="' . esc_attr( $title ) . '"';
    }
    
    $attr = join( ' ', $attr );
    
    $open = '<a href="' . esc_url( $full_src ) . '" ' . $attr . ' class="lightbox-link">';
    $close = '</a>';
    
} else {
    
    if ( isset( $photo[ 'link' ] ) ) {
        $open = '<a href="' . esc_url( $photo[ 'link' ] ) . '" target="_blank" title="' . esc_attr( $photo[ 'description' ] ). '">';
        $close = '</a>';
    } else {
        $open = $close = '';
    }
}

// SRC
$src = '';
if ( 'large' != $instagram_size && 'thumbnail' != $instagram_size ) $instagram_size = 'medium';
if ( 'large' == $instagram_size ) {
    $src = $photo[ 'large' ];
}
if ( 'medium' == $instagram_size || ( 'large' == $instagram_size && ! $src ) ) {
    $src = $photo[ 'medium' ];
}
if ( 'thumbnail' == $instagram_size || ( 'medium' == $instagram_size && ! $src ) || ( 'large' == $instagram_size && ! $src ) ) {
    $src = $photo[ 'thumbnail' ];
}
if ( ! $src ) $src = $photo[ 'thumbnail' ];
if ( ! $src ) continue;

    ?>

    <div class="gal-item"<?php echo $item_style; ?>>
        
        <div class="gal-item-wrapper">
        
            <figure class="gal-item-inner">

                <?php echo $open . '<img src="' . esc_url( $src ). '" alt="' . esc_attr( $photo[ 'description' ] ) . '" />' . $close ; ?>

            </figure>
            
        </div>

    </div><!-- .gal-item -->

<?php endforeach; // photos
    
endif;
endif;

// END IF IMAGE SOURCE
// ====================
?>
    
</div>