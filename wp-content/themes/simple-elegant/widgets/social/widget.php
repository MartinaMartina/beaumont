<?php
extract( $args );
extract($instance);
echo $before_widget;

$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
if ( !empty( $title ) ) {	
    echo $before_title . esc_html( $title ) . $after_title;
}
?>
<div class="widget-social align-<?php echo esc_attr( $align ); ?>">

    <div class="social-list">
    
        <ul>
        
            <?php $services = array( 'facebook', 'twitter', 'instagram', 'pinterest', 'google_plus', 'youtube', 'soundcloud' );
            
            foreach ( $services as $service ) {
                
                if ( ${"$service"} ) {
                    
                    if ( 'google_plus' == $service ) {
                        $icon = 'google-plus';
                    } else {
                        $icon = $service;
                    }
                
                    echo '<li class="li-' . $icon . '"><a href="'. esc_url( ${"$service"} ).'"><i class="fa fa-' . $icon . '"></i></a></li>';
                    
                }
            
            }
            
            ?>
        
        </ul>
    
    </div>

</div><!-- .widget-social -->

<?php echo $after_widget;