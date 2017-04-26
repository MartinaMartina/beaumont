<?php
if ( ! class_exists( 'Withemes_Shortcode' ) ) :
/**
 * Generic class so that other shortcodes could be registered easier
 *
 * @since 2.0
 */
class Withemes_Shortcode
{
    
    /**
	 * construct
	 */
	public function __construct() {
	}
    
    /**
     * Args to register this shortcode
     */
    public $args;
    
    public $path;
    
    // prefix
    private static $prefix = 'wi_';
    
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
        
        $args = $this->args;
        $prefix = self::$prefix;
        
        extract( wp_parse_args( $args, array( 'base' => '' ) ) );
        
        if ( ! $base ) return;
        
        // Register lately so that everything has been registered
        add_action( 'vc_before_init', array( $this, 'register' ) );
        
        add_shortcode( $base, array( $this, 'shortcode' ) );
        add_shortcode( $prefix . $base, array( $this, 'shortcode' ) ); // backup
        
    }
    
    /**
     * Frontend params used for frontend
     *
     * @since 2.0
     */
    public function css_params() {
    
        $params = array();
        include $this->path . 'params.css.php';
        return $params;
    
    }
    
    /**
     * Params to register to frontend
     *
     * @since 2.0
     */
    public function params() {
        
        $params = array();
        include $this->path . 'params.php';
        return $params;
    
    }
    
    /**
     * Register the addon
     *
     * @since 2.0
     * @modified 2.0
     */
    function register() {
        
        $args = $this->args;
        
        $base = isset( $args[ 'base' ] ) ? $args[ 'base' ] : '';
        
        $defaults = array(
            'name'  => '',
            'desc'  => '',
            'category'=> array( esc_html__( 'Content', 'js_composer' ), esc_html__( 'S&E', 'simple-elegant' ) ),
            'weight'=> 190,
        );
        extract( wp_parse_args( $args, $defaults ) );
        
        $params = $this->params();
        
        if ( $base && $params ) {
            
            vc_map( array(
                'name'      => $name,
                'base'      => $base,
                'weight'    => $weight,
                'icon'      => SIMPLE_ELEGANT_ADDONS_URL . 'icons/' . $base . '.png',
                'category'  => $category,
                'description' => $desc,
                'params'    => $params,
            ) );
        }
        
    }
    
    public function extra_atts( $atts ) {
    
        return array();
        
    }
    
    public function param_list() {
    
        return '';
        
    }
    
    /**
     * Renders to frontend
     *
     * @since 2.0
     */
    public function shortcode( $atts, $content = null ) {
        
        $return = '';
        
        // get the base (shortcode name, eg. iconbox, button..)
        $args = $this->args;
        $base = isset( $args[ 'base' ] ) ? $args[ 'base' ] : '';
        
        // Extra atts that can be used for shortcode but not added to Visual Composer
        $extra_atts = $this->extra_atts( $atts );
        if ( function_exists( 'vc_map_get_attributes' ) )
        $atts = vc_map_get_attributes( $base, $atts );
        $atts = array_merge( $atts, $extra_atts );
        
        // set default array to extract
        $defaults = array();
        $param_list = $this->param_list();
        $param_list = explode( ',', $param_list );
        $param_list = array_map( 'trim', $param_list );
        foreach ( $param_list as $param_name ) {
            $defaults[ $param_name ] = '';
        }
        
        extract( shortcode_atts( $defaults, $atts ) );
        
        // get element id
        $element_id = $this->shortcode_id( $base );
        
        $element_class = array( 'withemes-element', 'wpb_content_element', 'withemes-element-' . $base );
        
        // css class
        // for element having atts
        if ( isset( $css ) ) {
            $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), $base, $atts );
            $element_class[] = $css_class;
        }
        
        // animation
        $data_animation_delay = '';
        if ( isset( $animation ) && 'true' == $animation ) {
            $element_class[] = 'withemes-animation-element';
            if ( isset( $animation_delay ) && $animation_delay ) {
                $data_animation_delay = ' data-delay="' . absint( $animation_delay ) . '"';
            }
        }
        
        // register a filter
        $element_class = apply_filters( 'withemes_element_class', $element_class, $base, $atts );
        
        $element_class = join( ' ', $element_class );
        
        // get inner html
        ob_start();
        
        include $this->path . 'frontend.php';
        
        $inner_html = ob_get_clean();
        
        if ( ! $inner_html ) return;
        
        // inline css
        $return .= '<style>' . $this->css( $atts, $element_id ) . '</style>';
        
        $return .= '<div class="' . esc_attr( $element_class ) . '" id="' . esc_attr( $element_id ) . '"' . $data_animation_delay . '>';
        
        $return .= $inner_html;
        
        $return .= '</div>'; // element class
        
        return $return;
        
    }
    
    /**
     * Returns shortcode ID for an element
     * 
     * @param $base the name of element, eg. iconbox
     *
     * @since 2.0
     */
    function shortcode_id( $base ) {
    
        global $withemes_ids;
        
        if ( ! isset( $withemes_ids ) )
            $withemes_ids = array();
        
        if ( ! isset( $withemes_ids[ $base ] ) )
            $withemes_ids[ $base ] = array();
        
        $count = sizeof( $withemes_ids[ $base ] ) + 1;
        $withemes_ids[ $base ][] = "{$base}-{$count}";
        
        return "{$base}-{$count}";
        
    }
    
    /**
     * Returns CSS for shortcode element
     *
     * @since 2.0
     */
    function css( $atts, $element_id ) {
        
        $params = $this->css_params();
        
        $unit_arr = function_exists( 'withemes_unit_array' ) ?  withemes_unit_array() : array();
        
        $media_query_arr = array();
        
        foreach ( $params as $param_name => $param_css ) {
            
            // Check dependency
            $dependency = isset( $param_css[ 'dependency' ] ) ? $param_css[ 'dependency' ]: null;
            if ( $dependency ) {
                
                $element = $dependency[ 'element' ];
                $element_dependent_value = $dependency[ 'value' ];
                $element_proper_value = isset( $atts[ $element ] ) ? $atts[ $element ] : '';
                
                // continue if proper value differs from dependent value
                if ( is_string( $element_dependent_value ) && $element_proper_value != $element_dependent_value ) continue;
                elseif ( is_array( $element_dependent_value ) && ! in_array( $element_proper_value, $element_dependent_value )  ) continue;
            }
            
            $previews = array();
            
            $value_func = isset( $param_css[ 'value_func' ] ) ? $param_css[ 'value_func' ] : '';
            $default = isset( $param_css[ 'default' ] ) ? $param_css[ 'default' ] : '';
            
            // setup previews common for both cases
            if ( isset( $param_css[ 'selector' ] ) ) {
                $previews = array( $param_css );
            } else {
                $previews = $param_css;
            }
            
            foreach ( $previews as $preview ) {
                
                $selector = isset( $preview[ 'selector' ] ) ? $preview[ 'selector' ] : '';
                $property = isset( $preview[ 'property' ] ) ? $preview[ 'property' ] : '';
                $unit = isset( $preview[ 'unit' ] ) ? $preview[ 'unit' ] : '';
                
                if ( ! $property || ! $selector ) continue;

                // default $unit
                if ( in_array( $property, $unit_arr ) && ! $unit ) $unit = 'px';
                
                // get value
                $value = isset( $atts[ $param_name ] ) ? $atts[ $param_name ] : '';
                
                // value function called to modify value
                if ( is_callable( $value_func ) ) $value = call_user_func( $value_func, $value );

                // try to get default value
                if ( $value === '' ) {
                    $value = $default;
                }

                if ( $value === '' ) continue;
                
                // font family
                if ( 'font-family' == $property ) {
                 
                    if ( ! isset( $font_assigns ) ) {
                        $font_assignment = withemes_font_assignment();
                        $font_assigns = $font_assignment[ 'assigns' ];
                    }
                    
                    if ( 'primary' == $value ) $value = $font_assigns[ 'primary' ];
                    elseif ( 'secondary' == $value ) $value = $font_assigns[ 'secondary' ];
                    elseif ( 'tertiary' == $value ) $value = $font_assigns[ 'tertiary' ];
                    
                }

                if ( is_numeric ( $value ) && $unit ) {
                    $value .= $unit;
                }
                
                // media query
                $screen = isset( $preview[ 'screen' ] ) ? $preview[ 'screen' ] : '';
                $max_screen = isset( $preview[ 'max_screen' ] ) ? $preview[ 'max_screen' ] : '';
                
                $query = 'all';
                if ( $screen && $max_screen ) {
                    $query = "@media only screen and (min-width: {$screen}) and (max-width: {$max_screen})";
                } elseif ( $screen ) {
                    $query = "@media only screen and (min-width: {$screen})";
                } elseif ( $max_screen ) {
                    $query = "@media only screen and (max-width: {$max_screen})";
                }
                
                if ( ! isset( $media_query_arr[ $query ] ) ) {
                    $media_query_arr[ $query ] = array();
                }

                if ( ! isset( $media_query_arr[ $query ][ $selector ] ) )
                    $media_query_arr[ $query ][ $selector ] = array();

                $media_query_arr[ $query ][ $selector ][] = "{$property}:{$value}";
                
            }
        
        }
        
        $css = '';
        foreach ( $media_query_arr as $query => $style_arr ) {
            
            if ( 'all' === $query ) {
                $open = $close = '';
            } else {
                $open = "{$query} {";
                $close = "}";
            }

            $css .= $open;
            
            foreach ( $style_arr as $selector => $insides ) {

                if ( ! $insides ) continue;
                $insides = join( ';', $insides );

                $outer = array();
                $selectors = explode( ',', $selector );
                foreach ( $selectors as $selector ) {
                    $outer[] = "#{$element_id} {$selector}";
                }
                $outer = join( ',', $outer );

                $css .= "{$outer}{{$insides}}";

            }
            
            $css .= $close;
            
        }
        
        $css .= $this->extra_css( $atts, $element_id );
        
        return $css;
    
    }
    
    /**
     * Adds extra css out of normal css rules
     *
     * Should be used in extend classes
     */
    function extra_css( $atts, $element_id ) {
        return;
    }
    
}

endif;