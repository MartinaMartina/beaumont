<?php
$params = array(
    
    array(
        'type' => 'attach_image',
        'heading' => 'Member image',
        'param_name' => 'image',
        'description' => 'Select image from media library',
    ),

    array(
        'type' => 'dropdown',
        'heading' => 'Crop',
        'param_name' => 'crop',
        'value' => array(
            'Circle' => 'circle',
            'Square' => 'square',
            'Landscape' => 'landscape',
            'Portrait' => 'portrait',
            'Orginal Size' => 'full',
        ),
        'std' => 'circle',
    ),

    array(
        'type' => 'textfield',
        'heading' => 'Name',
        'param_name' => 'name',
        'value' => 'John Doe',
        'admin_label' => true,
        'description' => 'Enter the member name',
    ),

    array(
        'type' => 'dropdown',
        'heading' => 'Name Heading Tag',
        'param_name' => 'name_tag',
        'value' => array(
            'h2' => 'h2',
            'h3' => 'h3',
            'h4' => 'h4',
        ),
        'std' => 'h3',
    ),

    array(
        'type' => 'exploded_textarea',
        'heading' => 'Social profile',
        'param_name' => 'social',
        'value' => 'twitter|https://twitter.com/YOUR_USERNAME,facebook | https://facebook.com/YOUR_USERNAME,instagram | http://instagarm.com/YOUR_USERNAME',
        'description' => 'Write your social links in that syntax. Divide value sets with linebreak "Enter"',
    ),
    
    array(
        'type' => 'dropdown',
        'heading' => 'Social Icons Position',
        'param_name' => 'social_position',
        'value' => array(
            'Rollover Photo' => 'rollover',
            'Below Description' => 'description',
        ),
        'std' => 'rollover',
    ),

    array(
        'type' => 'textarea_html',
        'heading' => 'Content',
        'param_name' => 'content',
        'value' => 'Hi. I\'m John. I\'m passionate about success. Lorem ipsum dolor sit amet, mei et fabellas molestiae, integre officiis lobortis ex sea. Eu duo meis quando consul',
        'description' => 'Enter member content',
        'admin_label' => true,
    ),
    
);