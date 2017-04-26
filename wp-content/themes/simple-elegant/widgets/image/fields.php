<?php

$fields = array(
    array(
        'id' => 'title',
        'type' => 'text',
        'name' => esc_html__( 'Title', 'simple-elegant' ),
        'std' => '',
    ),
    
    array(
        'id' => 'image',
        'type' => 'image',
        'name' => esc_html__( 'Upload your image', 'simple-elegant' ),
    ),
    
    array (
        'id' => 'url',
        'type' => 'text',
        'name' => esc_html__( 'URL', 'simple-elegant' ),
    ),
    
    array(
        'id' => 'url_target',
        'type' => 'select',
        'name' => esc_html__( 'Target?', 'simple-elegant' ),
        'options' => array(
            '_self' => esc_html__( 'Same tab', 'simple-elegant' ),
            '_blank' => esc_html__( 'New tab', 'simple-elegant' ),
        ),
        'std' => '_self',
    ),
    
    array(
        'id' => 'desc',
        'type' => 'textarea',
        'name' => esc_html__( 'Text', 'simple-elegant' ),
        'desc' => esc_html__( 'Some custom text below image. You can use HTML here.', 'simple-elegant' ),
    ),
    
    array (
        'id' => 'align',
        'type' => 'select',
        'options'   => array(
            ''      => esc_html__( 'Default', 'simple-elegant' ),
            'center'    => esc_html__( 'Center', 'simple-elegant' ),
            'justify'   => esc_html__( 'Justify', 'simple-elegant' ),
        ),
        'std'   => '',
        'name' => esc_html__( 'Text Align', 'simple-elegant' ),
    ),
    
);