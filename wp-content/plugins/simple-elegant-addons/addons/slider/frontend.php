<?php
$images = explode ( ',', $images );
$images = array_map( 'trim', $images );
if ( empty( $images ) ) return;

$controls = explode( ',', $controls );
$controls = array_map( 'trim', $controls );

$options = array(
    'animation' => 'fade',
    'controlNav' => in_array( 'pager', $controls ),
    'directionNav' => in_array( 'navi', $controls ),
    'slideshow' =>  in_array( 'auto', $controls ),
    'smoothHeight' => false,
);
?>

<?php 
        $attachments = get_posts( array(
            'posts_per_page' => -1,
            'orderby' => 'post__in',
            'post_type' => 'attachment',
            'post_status' => 'inherit',
            'post__in' => $images,
        ) );

if ( ! $attachments ) return; ?>

<div class="wi-flexslider" data-options='<?php echo json_encode( $options ); ?>'>
    
    <div class="flexslider">
        
        <ul class="slides">

        <?php foreach ( $attachments as $attachment ) : $caption = trim( $attachment->post_excerpt ); ?>
            
            <li>
                <?php
                if ( ! $thumb ) {
                    $thumb = 'wi-square';
                }

                if ( function_exists( 'wpb_getImageBySize' ) ) {

                    $img = wpb_getImageBySize( array(
                        'attach_id' => $attachment->ID,
                        'thumb_size' => $thumb,
                    ) );
                    
                    $img = $img[ 'thumbnail' ];
                    
                } else {
                 
                    $img = wp_get_attachment_image( $attachment->ID, $thumb );
                    
                }
                ?>

                <?php echo $img; ?>
                
                <?php if ( $caption ) : ?>
                <span class="slide-caption">
                    <?php echo wp_kses_post( $caption ); ?>
                </span>
                <?php endif; ?>

            </li>

        <?php endforeach; ?>
            
        </ul>
        
    </div>
    
</div>