<?php
/**
 * Latest News Addon for Visual Composer
 *
 * @since 1.0
 * @modified 2.0
 */
if ( ! class_exists( 'Withemes_News' ) ) :

class Withemes_News extends Withemes_Shortcode
{
    
    public function __construct() {
        
        $this->path = SIMPLE_ELEGANT_ADDONS_PATH . 'addons/news/';
        $this->args = array(
            'base'      => 'news',
            'name'      => esc_html__( 'Latest News', 'simple-elegant' ),
            'desc'      => esc_html__( 'Displays latest blog posts', 'simple-elegant' ),
            'weight'    => 190,
            'icon'      => 'withemes-vc-icon bi_medicine-lab',
        );
        
    }
    
    function param_list() {
        
        return 'number, date, categories, excerpt, excerpt_length, more';
        
    }
    
}

$instance = new Withemes_News();
$instance->init();

endif;