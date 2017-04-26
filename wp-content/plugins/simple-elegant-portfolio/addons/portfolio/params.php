<?php
$params[] = array(
    'type' => 'textfield',
    'heading' => 'Number of projects',
    'value' => '6',
    'param_name' => 'number',
    'description' => 'Number of projects to display',
);

$params[] = array(
    'type' => 'dropdown',
    'heading' => 'Column',
    'value' => array( 
        'Default' => '',
        '2 Columns' => '2',
        '3 Columns' => '3',
        '4 Columns' => '4',
    ),
    'std' => '',
    'param_name' => 'column',
);

$params[] = array(
    'type' => 'dropdown',
    'heading' => 'Project Item Style',
    'value' => array( 
        'Default' => '',
        'Style 1' => '1',
        'Style 2' => '2',
        'Style 3' => '3',
    ),
    'std' => '',
    'param_name' => 'style',
);

$params[] = array(
    'type' => 'textfield',
    'heading' => 'Project Thumbnail Ratio',
    'param_name' => 'ratio',
    'description' => 'Example: 4:3, 1:1, 3:5 so on. Default is 5:4',
);

$params[] = array(
    'type' => 'checkbox',
    'heading' => 'Display Pagination?',
    'param_name' => 'pagination',
    'value' => array( 'Yes' => 'true' ),
    'std' => '',
);
    
$params[] = array (
    'type' => 'checkbox',
    'heading' => 'Display category list?',
    'param_name' => 'catlist',
    'value' => array( 'Yes' => 'true' ),
);

$params[] = array (
    "type" => "textarea_html",
    "holder" => "div",
    "heading" => 'Content along filter',
    "param_name" => "content",
    "description" => '',
    'dependency' => array(
        'element'   => 'catlist',
        'value'     => 'true',
    ),
);