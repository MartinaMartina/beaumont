<?php
$fields = array(
    
    array(
        'id' => 'title',
        'type' => 'text',
        'name' => esc_html__( 'Title', 'editorial' ),
        'std' => '',
    ),
    
    array(
        'id' => 'align',
        'type' => 'select',
        'options'   => array(
            'left'      => esc_html__( 'Left', 'editorial' ),
            'center'    => esc_html__( 'Center', 'editorial' ),
            'right'     => esc_html__( 'Right', 'editorial' ),
        ),
        'std'   => 'left',
        'name' => esc_html__( 'Align', 'editorial' ),
    ),
    
    array(
        'id' => 'facebook',
        'type' => 'text',
        'name' => esc_html__( 'Facebook URL', 'editorial' ),
        'placeholder' => 'http://',
    ),
    
    array(
        'id' => 'twitter',
        'type' => 'text',
        'name' => esc_html__( 'Twitter URL', 'editorial' ),
        'placeholder' => 'http://',
    ),
    
    array(
        'id' => 'instagram',
        'type' => 'text',
        'name' => esc_html__( 'Instagram URL', 'editorial' ),
        'placeholder' => 'http://',
    ),
    
    array(
        'id' => 'pinterest',
        'type' => 'text',
        'name' => esc_html__( 'Pinterest URL', 'editorial' ),
        'placeholder' => 'http://',
    ),
    
    array(
        'id' => 'google_plus',
        'type' => 'text',
        'name' => esc_html__( 'Google+ URL', 'editorial' ),
        'placeholder' => 'http://',
    ),
    
    array(
        'id' => 'youtube',
        'type' => 'text',
        'name' => esc_html__( 'YouTube URL', 'editorial' ),
        'placeholder' => 'http://',
    ),
    
    array(
        'id' => 'soundcloud',
        'type' => 'text',
        'name' => esc_html__( 'Soundcloud URL', 'editorial' ),
        'placeholder' => 'http://',
    ),
    
);