<?php
$params = array(
    
    /* Number of posts
    ------------------------ */
    array(
        'type' => 'textfield',
        'heading' => 'Number of posts',
        'param_name' => 'number',
        'value' => '3',
    ),
    
    array (
        'type' => 'dropdown',
        'heading' => 'Column',
        'param_name' => 'column',
        'value' => array( 
            '2 Columns' => '2',
            '3 Columns' => '3',
            '4 Columns' => '4',
        ),
        'std' => '3',
        'admin_label' => true,
    ),
    
);