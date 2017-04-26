<?php
if ( ! class_exists( 'Withemes_Gallery' ) ) :
/**
 * Gallery Addon for Visual Composer
 *
 * @since 2.0
 */
class Withemes_Gallery extends Withemes_Shortcode
{
    
    public function __construct() {
        
        $this->path = SIMPLE_ELEGANT_ADDONS_PATH . 'addons/gallery/';
        $this->args = array(
            'base'      => 'withemes_gallery',
            'name'      => esc_html__( 'Gallery', 'simple-elegant' ),
            'desc'      => esc_html__( 'Displays Image Gallery', 'simple-elegant' ),
            'weight'    => 190,
        );
        
    }
    
    function param_list() {
    
        return 'source, images, thumb, access_token, number, cache_time, lightbox, column, instagram_size, item_spacing';
    
    }
    
}

$instance = new Withemes_Gallery();
$instance->init();

endif;