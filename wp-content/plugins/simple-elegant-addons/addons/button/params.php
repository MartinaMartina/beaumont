<?php
$params[] = array(
    'type' => 'textfield',
    'heading' => 'Button Text',
    'value' => 'Click Me!',
    'param_name' => 'text',
    'admin_label' => true,
);

$params[] = array (
    'type' => 'dropdown',
    'value' => array(
        'No Thanks!' => '',
        'Thin Icon' => 'withemes_budicon',
        'FontAwesome' => 'fontawesome',
    ),
    'std' => '',
    'heading' => 'Use Icon?',
    'param_name' => 'icon_set',
);
    
$params[] = array (
    'type' => 'iconpicker',
    'heading' => 'Select Icon',
    'param_name' => 'icon',
    'description' => 'Select icon',
    'value' => 'fa fa-gift', // default value to backend editor admin_label
    'settings' => array(
        'emptyIcon' => false, // default true, display an "EMPTY" icon?
        'type' => 'fontawesome',
    ),
    'dependency' => array(
        'element'   => 'icon_set',
        'value'     => 'fontawesome',
    ),
);

$params[] = array (
    'type' => 'iconpicker',
    'heading' => 'Select Icon',
    'param_name' => 'icon_budicon',
    'value' => 'bi_com-email',
    'settings' => array(
        'emptyIcon' => false, // default true, display an "EMPTY" icon?
        'type' => 'withemes_budicon',
        'source' => withemes_budicon(),
    ),
    'dependency' => array(
        'element'   => 'icon_set',
        'value'     => 'withemes_budicon',
    ),
);

$params[] = array(
    'type' => 'vc_link',
    'heading' => 'Button Link',
    'param_name' => 'link',
);

$params[] = array (
    'type' => 'dropdown',
    'heading' => 'Button Style',
    'param_name' => 'style',
    'value' => array(
        'Primary' => 'primary',
        'Black' => 'black',
        'White' => 'white',
        'Gray' => 'gray',
        'Alt' => 'alt',
        'Outline' => 'outline',
        'Fill' => 'fill',
        'Custom' => 'custom',
    ),
    'std' => 'primary',
    'admin_label' => true,
);

$params[] = array (
    'type' => 'dropdown',
    'heading' => 'Button Size',
    'param_name' => 'size',
    'value' => array(
        'Large' => 'large',
        'Normal' => 'normal',
        'Small' => 'small',
    ),
    'std' => 'normal',
);

$params[] = array (
    'type' => 'dropdown',
    'heading' => 'Button Align',
    'param_name' => 'align',
    'value' => array(
        'Inline'=> 'inline',
        'Left' => 'left',
        'Center' => 'center',
        'Right' => 'right',
    ),
);

$params[] = array (
    'type' => 'dropdown',
    'heading' => 'Button Width',
    'description' => 'This option doesn\'t apply for inline button.',
    'param_name' => 'width',
    'value' => array (
        'Auto' => 'auto',
        'Full'=> 'full',
        'Half' => 'half',
        'One Third' => 'third',
    ),
    'std' => 'auto',
);

$params[] = array (
    'type' => 'dropdown',
    'heading' => 'Button Shape',
    'param_name' => 'shape',
    'value' => array (
        'Square' => 'square',
        'Rounded'=> 'rounded',
    ),
    'std' => 'square',
);

$params[] = array (
    'type' => 'textarea',
    'heading' => 'Onclick Attribute',
    'description' => 'Use this option if you have a custom code for your click event.',
    'param_name' => 'onclick',
);

// CUSTOM BUTTON
//
$params[] = array (
    'type' => 'textfield',
    'heading' => 'Padding Left/Right',
    'param_name' => 'padding_left',
    
    'previews' => array (
        array(
            'selector' => '.wi-btn',
            'property' => 'padding-left',
            'unit' => 'px',
        ),
        array(
            'selector' => '.wi-btn',
            'property' => 'padding-right',
            'unit' => 'px',
        ),
    ),
    'group' => 'Button Design',
);

$params[] = array (
    'type' => 'textfield',
    'heading' => 'Padding Top/Bottom',
    'param_name' => 'padding_top',
    
    'previews' => array (
        array(
            'selector' => '.wi-btn',
            'property' => 'padding-top',
            'unit' => 'px',
        ),
        array(
            'selector' => '.wi-btn',
            'property' => 'padding-bottom',
            'unit' => 'px',
        ),
    ),
    'group' => 'Button Design',
);

$params[] = array (
    'type' => 'dropdown',
    'heading' => 'Border Radius',
    'param_name' => 'border_radius',
    'value' => array(
        'Default' => '',
        'None' => '0',
        '1px' => '1px',
        '2px' => '2px',
        '3px' => '3px',
        '4px' => '4px',
        '5px' => '5px',
        '6px' => '6px',
        '10px' => '10px',
        '14px' => '14px',
        '20px' => '20px',
        '24px' => '24px',
    ),
    'std' => '',
    
    'preview' => array(
        'selector' => '.wi-btn',
        'property' => 'border-radius',
        'unit' => 'px',
    ),
    'group' => 'Button Design',
);

$params[] = array (
    'type' => 'textfield',
    'heading' => 'Font Size',
    'param_name' => 'font_size',
    
    'preview' => array(
        'selector' => '.wi-btn',
        'property' => 'font-size',
        'unit' => 'px',
    ),
    'group' => 'Button Design',
);

$params[] = array (
    'type' => 'dropdown',
    'heading' => 'Font Weight',
    'param_name' => 'font_weight',
    
    'value' => withemes_font_weight(),
    'std' => '',
    
    'preview' => array(
        'selector' => '.wi-btn',
        'property' => 'font-weight',
    ),
    'group' => 'Button Design',
);

$params[] = array (
    'type' => 'dropdown',
    'heading' => 'Text Transform',
    'param_name' => 'text_transform',
    
    'value' => withemes_text_transform(),
    'std' => '',
    
    'preview' => array(
        'selector' => '.wi-btn',
        'property' => 'text-transform',
    ),
    'group' => 'Button Design',
);

$params[] = array (
    'type' => 'textfield',
    'heading' => 'Letter Spacing',
    'param_name' => 'letter_spacing',
    
    'preview' => array(
        'selector' => '.wi-btn',
        'property' => 'letter-spacing',
    ),
    'group' => 'Button Design',
);

$params[] = array (
    'type' => 'dropdown',
    'value' => array(
        'Default' => '',
        '1px' => '1px',
        '2px' => '2px',
        '3px' => '3px',
        '4px' => '4px',
        '5px' => '5px',
        '6px' => '6px',
    ),
    'std' => '',
    'heading' => 'Border Thickness',
    'param_name' => 'border_width',
    
    'preview' => array(
        'selector' => '.wi-btn',
        'property' => 'border-width',
    ),
    
    'dependency' => array (
        'element' => 'style',
        'value' => array( 'outline', 'fill', 'custom' ),
    ),
    
    'group' => 'Button Design',
);

$params[] = array (
    'type' => 'colorpicker',
    'heading' => 'Button Text Color',
    'param_name' => 'color',
    
    'preview' => array(
        'selector' => '.wi-btn',
        'property' => 'color',
    ),
    
    'dependency' => array(
        'element' => 'style',
        'value' => array( 'custom', 'outline', 'fill' ),
    ),
    'group' => 'Button Design',
);

$params[] = array (
    'type' => 'colorpicker',
    'heading' => 'Button Background',
    'param_name' => 'background',
    
    'preview' => array(
        'selector' => '.wi-btn',
        'property' => 'background-color',
    ),
    
    'dependency' => array(
        'element' => 'style',
        'value' => 'custom',
    ),
    
    'group' => 'Button Design',
);

$params[] = array (
    'type' => 'colorpicker',
    'heading' => 'Border Color',
    'param_name' => 'border_color',
    
    'preview' => array(
        'selector' => '.wi-btn',
        'property' => 'border-color',
    ),
    
    'dependency' => array(
        'element' => 'style',
        'value' => array( 'outline', 'fill' ),
    ),
    'group' => 'Button Design',
);

$params[] = array (
    'type' => 'colorpicker',
    'heading' => 'Hover Color',
    'param_name' => 'hover_color',
    
    'preview' => array(
        'selector' => '.wi-btn:hover',
        'property' => 'color',
    ),
    
    'dependency' => array(
        'element' => 'style',
        'value' => array( 'custom', 'outline', 'fill' ),
    ),
    
    'group' => 'Button Design',
);

$params[] = array (
    'type' => 'colorpicker',
    'heading' => 'Hover Background',
    'param_name' => 'hover_background',
    
    'preview' => array(
        'selector' => '.wi-btn:hover',
        'property' => 'background-color',
    ),
    
    'dependency' => array(
        'element' => 'style',
        'value' => array( 'custom', 'fill' ),
    ),
    
    'group' => 'Button Design',
);

$params[] = array (
    'type' => 'colorpicker',
    'heading' => 'Hover Border',
    'param_name' => 'hover_border',
    
    'preview' => array(
        'selector' => '.wi-btn:hover',
        'property' => 'border-color',
    ),
    
    'dependency' => array(
        'element' => 'style',
        'value' => array( 'outline', 'custom' ),
    ),
    
    'group' => 'Button Design',
);