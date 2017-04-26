<?php
$categories = array( '' => esc_html__( 'All', 'simple-elegant' ) );

$cats = get_categories( array(
    'fields' => 'id=>name',
    'taxonomy'=>'portfolio_category',
    'orderby'=> 'slug',
    'hide_empty' => false,
    'update_term_meta_cache' => false,
));

$categories = $categories + $cats;

$fields = array(
    array(
        'id' => 'title',
        'type' => 'text',
        'name' => esc_html__( 'Title', 'simple-elegant' ),
        'std' => '',
    ),
    
    array(
        'id' => 'number',
        'type' => 'text',
        'name' => esc_html__( 'Number of projects', 'simple-elegant' ),
        'std' => '6',
    ),
    
    array (
        'id' => 'category',
        'type' => 'select',
        'options' => $categories,
        'std' => '',
        'name' => esc_html__( 'Category', 'simple-elegant' ),
    ),
    
    array(
        'id' => 'column',
        'type' => 'select',
        'name' => esc_html__( 'Column?', 'simple-elegant' ),
        'options' => array(
            '2' => esc_html__( '2 Columns', 'simple-elegant' ),
            '3' => esc_html__( '3 Columns', 'simple-elegant' ),
            '4' => esc_html__( '4 Columns', 'simple-elegant' ),
        ),
        'std' => '3',
    ),
    
);