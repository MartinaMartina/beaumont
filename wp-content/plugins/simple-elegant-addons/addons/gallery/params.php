<?php
$params[] = array(
    'type' => 'dropdown',
    'heading' => 'Image Source',
    'value' => array(
        'Media Library' => 'media',
        'Instagram' => 'instagram',
    ),
    'std'  => 'media',
    'param_name' => 'source',
    'admin_label' => true,
);

$params[] = array(
    'type' => 'attach_images',
    'heading' => 'Upload images',
    'param_name' => 'images',
    
    'dependency' => array(
        'element' => 'source',
        'value' => 'media',
    ),
);

$params[] = array(
    'type' => 'textfield',
    'heading' => 'Image Size',
    'param_name' => 'thumb',
    'value' => 'wi-square',
    'description' => 'Enter image size. Example: "wi-square" (400x400), "wi-medium" (400x300), "wi-portrait" (400x500), "full" (original size). Alternatively enter size in pixels (Example: 1000x400 (Width x Height)).',
    
    'dependency' => array(
        'element' => 'source',
        'value' => 'media',
    ),
);

// Instagram
$params[] = array(
    'type' => 'textfield',
    'heading' => 'accessToken',
    'param_name' => 'access_token',
    'description' => 'You can get your accessToken <a href="https://www.instagram.com/oauth/authorize/?client_id=1677ed07ddd54db0a70f14f9b1435579&redirect_uri=http://instagram.pixelunion.net&response_type=token" target="_blank">here &raquo;</a>',
    
    'dependency' => array(
        'element' => 'source',
        'value' => 'instagram',
    ),
);

$params[] = array(
    'type' => 'textfield',
    'heading' => 'Number of photos',
    'param_name' => 'number',
    'value'     => '9',
    'description' => 'Please enter a number.',
    
    'dependency' => array(
        'element' => 'source',
        'value' => 'instagram',
    ),
);

$params[] = array(
    'type' => 'dropdown',
    'heading' => 'Cache Time',
    'param_name' => 'cache_time',
    'value' => array(
        esc_html__( 'Half Hours', 'simple-elegant' ) => (string) ( HOUR_IN_SECONDS/ 2 ),
        esc_html__( 'An Hour', 'simple-elegant' ) => (string) ( HOUR_IN_SECONDS ),
        esc_html__( 'Two Hours', 'simple-elegant' ) => (string) ( HOUR_IN_SECONDS * 2 ),
        esc_html__( 'Four Hours', 'simple-elegant' ) => (string) ( HOUR_IN_SECONDS * 4 ),
        esc_html__( 'A Day', 'simple-elegant' ) => (string) ( DAY_IN_SECONDS ),
        esc_html__( 'A Week', 'simple-elegant' ) => (string) ( WEEK_IN_SECONDS ),
    ),
    'std' => (string) ( HOUR_IN_SECONDS * 2 ),
    
    'dependency' => array(
        'element' => 'source',
        'value' => 'instagram',
    ),
);

$params[] = array (
    'type' => 'checkbox',
    'heading' => 'Open Lightbox?',
    'param_name' => 'lightbox',
    'value' => array( 'Yes Please' => 'true' ),
    'std' => '',
);

$params[] = array(
    'type' => 'dropdown',
    'heading' => 'Column?',
    'param_name' => 'column',
    'value' => array(
        '1-Column' => '1',
        '2-Column' => '2',
        '3-Column' => '3',
        '4-Column' => '4',
        '5-Column' => '5',
        '6-Column' => '6',
        '7-Column' => '7',
        '8-Column' => '8',
        '9-Column' => '9',
        '10-Column' => '10',
    ),
    'std' => '3',
    
    'group' => 'Design',
);

$params[] = array(
    'type' => 'dropdown',
    'heading' => 'Instagram Image Size',
    'param_name' => 'instagram_size',
    'value' => array(
        'Thumbnail' => 'thumbnail',
        'Medium' => 'medium',
        'Large' => 'large',
    ),
    'std'       => 'medium',
    
    'dependency' => array(
        'element' => 'source',
        'value' => 'instagram',
    ),
    
    'group' => 'Design',
);

$params[] = array(
    'type' => 'textfield',
    'heading' => 'Space between Items',
    'description' => 'Default is 24px. You can enter other number, eg 50, 20 or 1...',
    'param_name' => 'item_spacing',
    'group' => 'Design',
);