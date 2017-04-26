<?php
/**
 * Team Member Addon for Visual Composer
 *
 * @since 1.0
 * @modified 2.0
 */
if ( ! class_exists( 'Withemes_Member' ) ) :

class Withemes_Member extends Withemes_Shortcode
{
    
    public function __construct() {
        
        $this->path = SIMPLE_ELEGANT_ADDONS_PATH . 'addons/member/';
        $this->args = array(
            'base'      => 'member',
            'name'      => esc_html__( 'Team Member', 'simple-elegant' ),
            'desc'      => esc_html__( 'Displays team member', 'simple-elegant' ),
            'weight'    => 190,
            'icon'      => 'withemes-vc-icon bi_medicine-lab',
        );
        
    }
    
    function param_list() {
        
        return 'image, crop, name, name_tag, social, social_position';
        
    }
    
}

$instance = new Withemes_Member();
$instance->init();

endif;