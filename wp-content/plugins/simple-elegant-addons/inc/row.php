<?php
if ( ! class_exists( 'Withemes_VC_Row' ) ) :
/**
 * We need to modify some options from VC Row
 *
 * @since 2.0
 */
class Withemes_VC_Row
{
    
    /**
	 * construct
	 */
	public function __construct() {
	}
    
    /**
	 * The one instance of class
	 *
	 * @since 2.0
	 */
	private static $instance;

	/**
	 * Instantiate or return the one class instance
	 *
	 * @since 2.0
	 * @return $instance
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}
    
    /**
     * Initiate the class
     * contains action & filters
     *
     * @since 2.0
     */
    public function init() {
        
        add_action( 'vc_after_init', array( $this, 'row_params' ) );
             
    }
    
    function row_params() {
        
        // Remove Params
        vc_remove_param( 'vc_row', 'parallax' );
        vc_remove_param( 'vc_row', 'parallax_image' );
        
        vc_remove_param( 'vc_row', 'video_bg' );
        vc_remove_param( 'vc_row', 'video_bg_url' );
        vc_remove_param( 'vc_row', 'video_bg_parallax' );
        vc_remove_param( 'vc_row', 'parallax_speed_bg' );
        vc_remove_param( 'vc_row', 'parallax_speed_video' );
    
        $params = array();
        $params[] = array(
            'type' => 'checkbox',
            'param_name' => 'parallax',
            'value' => array(
                'Enable' => 'true',
            ),
            'std' => '',
            'heading' => 'Parallax',
        );
        
        $speeds = array();
        for ( $i = 0; $i <= 10; $i++ ) {
            $speeds[ strval( $i/10 ) ] = strval( $i/10 );
        }
        
        $params[] = array(
            'type' => 'dropdown',
            'value'=> $speeds,
            'std'   => '0.5',
            'param_name' => 'parallax_speed',
            'dependency' => array(
                'element' => 'parallax',
                'value' => 'true',
            ),
            'heading' => 'Parallax Speed',
        );
        
        // Video Type
        $params[] = array(
            'type' => 'dropdown',
            'value'=> array(
                'None' => 'none',
                'YouTube' => 'youtube',
                'Vimeo' => 'vimeo',
                'Local HTML5' => 'local',
            ),
            'std'   => 'none',
            'param_name' => 'video_type',
            'heading' => 'Video Background',
        );
        
        $params[] = array(
            'type' => 'textfield',
            'param_name' => 'video_url',
            'heading' => 'Video URL',
            
            'dependency' => array(
                'element' => 'video_type',
                'value' => array( 'youtube', 'vimeo' ),
            ),
        );
        
        $params[] = array(
            'type' => 'textfield',
            'param_name' => 'webm',
            'heading' => 'Webm Video URL',
            
            'dependency' => array(
                'element' => 'video_type',
                'value' => 'local',
            ),
        );
        
        $params[] = array(
            'type' => 'textfield',
            'param_name' => 'mp4',
            'heading' => 'MP4 Video URL',
            
            'dependency' => array(
                'element' => 'video_type',
                'value' => 'local',
            ),
        );
        
        $params[] = array(
            'type' => 'colorpicker',
            'param_name' => 'overlay',
            'heading' => 'Background Overlay',
            'description' => 'Note that you can use opacity for overlay color.',
            
            'group' => 'Design Options',
        );
        
        vc_add_params( 'vc_row', $params );
        
    }
    
}

Withemes_VC_Row::instance()->init();

endif;