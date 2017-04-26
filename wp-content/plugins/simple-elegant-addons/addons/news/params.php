<?php
$params = array(
    
    /* Number of posts
    ------------------------ */
    array(
        'type' => 'textfield',
        'heading' => 'Number of posts',
        'param_name' => 'number',
        'value' => '2',
    ),
    
    array(
        'type' => 'checkbox',
        'heading' => 'Show date/time?',
        'param_name' => 'date',
        'value' => array( 'Enable' => 'true' ),
        'std' => 'true',
    ),
    
    array(
        'type' => 'checkbox',
        'heading' => 'Show categories?',
        'param_name' => 'categories',
        'value' => array( 'Enable' => 'true' ),
        'std' => 'true',
    ),
    
    array(
        'type' => 'checkbox',
        'heading' => 'Show excerpt?',
        'param_name' => 'excerpt',
        'value' => array( 'Enable' => 'true' ),
        'std' => '',
    ),
    
    array(
        'type' => 'textfield',
        'heading' => 'Excerpt length?',
        'param_name' => 'excerpt_length',
        'value' => 10,
        'description' => 'Excerpt length in word count',
        'dependency' => array(
            'element'   => 'excerpt',
            'value' => 'true',
        ),
    ),
    
    array(
        'type' => 'checkbox',
        'heading' => '"Read more" link?',
        'param_name' => 'more',
        'value' => array( 'Yes' => 'true' ),
        'std' => 'true',
        'dependency' => array(
            'element'   => 'excerpt',
            'value' => 'true',
        ),
    ),
    
);