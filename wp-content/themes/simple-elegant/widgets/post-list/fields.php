<?php
$categories = array( 'all' => esc_html__( 'All', 'simple-elegant' ) );

$cats = get_categories( array(
    'fields' => 'id=>name',
    'orderby'=> 'slug',
    'hide_empty' => false,
    'update_term_meta_cache' => false,
));

$categories = $categories + $cats;
    
$fields = array (
    
    array(
        'id' => 'title',
        'type' => 'text',
        'name' => esc_html__( 'Title', 'simple-elegant' ),
        'std' => '',
    ),
    
    array(
        'id' => 'number',
        'type' => 'text',
        'std' => '3',
        'placeholder' => esc_html__( 'Eg. 3', 'simple-elegant' ),
        'name' => esc_html__( 'Number of posts to display', 'simple-elegant' ),
    ),
    
    array (
        'id' => 'category',
        'type' => 'select',
        'options'   => $categories,
        'std'   => 'all',
        'name' => esc_html__( 'Only posts from categories:', 'simple-elegant' ),
    ),
    
    array (
        'id' => 'format',
        'type' => 'select',
        'options'   => array(
            '' => esc_html__( 'All', 'simple-elegant' ),
            'video' => esc_html__( 'Video', 'simple-elegant' ),
            'gallery' => esc_html__( 'Gallery', 'simple-elegant' ),
            'audio' => esc_html__( 'Audio', 'simple-elegant' ),
        ),
        'std'   => '',
        'name' => esc_html__( 'Only Post Format:', 'simple-elegant' ),
    ),
    
    array (
        'id' => 'orderby',
        'type' => 'select',
        'options'   => array (
            'date' => esc_html__( 'Date', 'simple-elegant' ),
            'title' => esc_html__( 'Title', 'simple-elegant' ),
            'name' => esc_html__( 'Slug', 'simple-elegant' ),
            'modified' => esc_html__( 'Modified Date', 'simple-elegant' ),
            'rand' => esc_html__( 'Random', 'simple-elegant' ),
            'comment_count' => esc_html__( 'Comment Count', 'simple-elegant' ),
        ),
        'std'   => 'date',
        'name' => esc_html__( 'Order By:', 'simple-elegant' ),
    ),
    
);