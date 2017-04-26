<?php
$params[] = array(
    'type' => 'attach_images',
    'heading' => 'Upload Images',
    'param_name' => 'images',
);

$params[] = array(
    'type' => 'textfield',
    'heading' => 'Image Thumbnail',
    'param_name' => 'thumb',
    'value' => 'wi-square',
    'description' => 'Enter image size. Example: "wi-square" (400x400), "wi-medium" (400x300), "wi-portrait" (400x500), "full" (original size). Alternatively enter size in pixels (Example: 1000x400 (Width x Height)).
 ',
);

$params[] = array(
    'type' => 'checkbox',
    'heading' => 'Controls',
    'param_name' => 'controls',
    'value' => array(
        'Autoplay' => 'auto',
        'Navigation Arrows' => 'navi',
        'Pager' => 'pager',
    ),
    'std' => 'auto,navi',
);