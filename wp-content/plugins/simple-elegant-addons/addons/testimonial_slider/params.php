<?php
$params = array(
    
    array(
        'type' => 'checkbox',
        'param_name' => 'auto',
        'heading' => __('Autoplay?','simple-elegant'),
        'value' => array( 'Enable' => 'true' ),
        'std' => 'true',
    ),

    array(
        'type' => 'checkbox',
        'param_name' => 'pager',
        'heading' => __('Pager?','simple-elegant'),
        'value' => array( 'Enable' => 'true' ),
        'std' => 'true',
    ),

    array(
        'type' => 'dropdown',
        'param_name' => 'align',
        'heading' => __( 'Align','simple-elegant'),
        'value' => array(
            'Left' => 'left',
            'Center' => 'center',
        ),
        'std' => 'left',
    ),

    array(
        'type' => 'param_group',
        'heading' => __( 'Testimonials', 'simple-elegant' ),
        'param_name' => 'testimonials',
        'description' => __( 'Enter value for each single testimonial', 'js_composer' ),
        'params' => array(

            array(
                'type' => 'attach_image',
                'heading' => __('Avatar','simple-elegant'),
                'param_name' => 'image',
                'holder' => 'img',
            ),
            array(
                'type' => 'textfield',
                'heading' => __('Rating','simple-elegant'),
                'param_name' => 'rating',
                'description' => __('Should be a number between 0 and 5. Eg. 4.8','simple-elegant'),
            ),
            array(
                'type' => 'textfield',
                'heading' => __('Name','simple-elegant'),
                'param_name' => 'name',
                'admin_label' => true,
            ),
            array(
                'type' => 'textfield',
                'heading' => __('From','simple-elegant'),
                'param_name' => 'from',
                'admin_label' => true,
            ),
            array(
                'type' => 'textarea',
                'heading' => __('Content','simple-elegant'),
                'param_name' => 'content',
            ),

        ),
    ),
    
);