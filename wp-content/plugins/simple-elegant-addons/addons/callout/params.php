<?php
$params[] = array(
    'type' => 'textfield',
    'heading' => 'Title',
    'param_name' => 'title',
    'value' => 'Buy Simple & Elegant Today!',
    'admin_label' => true,
);

$params[] = array(
    'type' => 'textfield',
    'heading' => 'Title Font Size',
    'param_name' => 'title_font_size',
    
    'preview' => array(
        'selector' => '.callout-title',
        'property' => 'font-size',
    ),
);

$params[] = array(
    'type' => 'dropdown',
    'heading' => 'Title Font Weight',
    'value' => withemes_font_weight(),
    'std'    => '',
    'param_name' => 'title_font_weight',
    
    'preview' => array(
        'selector' => '.callout-title',
        'property' => 'font-weight',
    ),
);

$params[] = array(
    'type' => 'dropdown',
    'heading' => 'Title Text Transform',
    'param_name' => 'title_text_transform',
    'value' => withemes_text_transform(),
    'std' => '',
    
    'preview' => array(
        'selector' => '.callout-title',
        'property' => 'text-transform',
    ),
);

$params[] = array(
    'type' => 'textfield',
    'heading' => 'Title Letter Spacing',
    'param_name' => 'title_letter_spacing',
    
    'preview' => array(
        'selector' => '.callout-title',
        'property' => 'letter-spacing',
    ),
);

$params[] = array(
    'type' => 'textarea_html',
    'heading' => 'Content',
    'param_name' => 'content',
    'admin_label' => true,
);

// BUTTON
//
$params = array_merge( $params, withemes_button_params( 'Button' ) );

// DESIGN OPTIONS
//
$params[] = array(
    'type' => 'css_editor',
    'heading' => esc_html__( 'Css', 'simple-elegant' ),
    'param_name' => 'css',
    'group' => esc_html__( 'Design Options', 'simple-elegant' ),
);