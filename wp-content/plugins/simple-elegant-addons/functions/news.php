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
        'value' => 'true',
    ),
    
    array(
        'type' => 'checkbox',
        'heading' => 'Show categories?',
        'param_name' => 'categories',
        'value' => 'true',
    ),
    
    array(
        'type' => 'checkbox',
        'heading' => 'Show excerpt?',
        'param_name' => 'excerpt',
        'value' => array( 'Enable' => 'true' ),
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
        'dependency' => array(
            'element'   => 'excerpt',
            'value' => 'true',
        ),
    ),
    
);

vc_map( array(
	'name' => 'Latest News',
	'base' => 'news',
	'weight'	=>	190,
    'icon' => plugins_url('../assets/icons/news.png', __FILE__), // or css class name which you can reffer in your css file later. Example: "vc_extend_my_class"
	'category' => array(
		esc_html__( 'Content', 'js_composer' ),
	),
	'description' => 'Display latest blog posts',
    'params' => $params,
) );
?>