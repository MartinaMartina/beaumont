<?php
/* --------------------------------------------------- */
/* Register Portfolio
/* --------------------------------------------------- */
add_action( 'init', 'withemes_register_portfolio_custom_post_type' );
if ( !function_exists('withemes_register_portfolio_custom_post_type') ) {
function withemes_register_portfolio_custom_post_type() {
	
    $portfolio_slug = trim( get_option( 'withemes_portfolio_slug', 'portfolio_item' ) );
    $portfolio_slug = sanitize_title_with_dashes( $portfolio_slug );
    if ( ! $portfolio_slug ) $portfolio_slug = 'portfolio_item';
	
	$labels = array(
		'name' 				=> _x('Projects','post type general name','simple-elegant'),
		'singular_name' 	=> _x('Project','post type singular name','simple-elegant'),
		'add_new' 			=> esc_html__('Add New','simple-elegant'),
		'add_new_item' 		=> esc_html__('Add New Project','simple-elegant'),
		'edit_item' 		=> esc_html__('Edit Project','simple-elegant'),
		'new_item' 			=> esc_html__('New Project','simple-elegant'),
		'all_items' 		=> esc_html__('All Projects','simple-elegant'),
		'view_item'			=> esc_html__('View Project','simple-elegant'),
		'search_items' 		=> esc_html__('Search Projects','simple-elegant'),
		'not_found'			=> esc_html__('No projects found','simple-elegant'),
		'not_found_in_trash'=> esc_html__('No projects found in Trash','simple-elegant'),
		'parent_item_colon' => '',
		'menu_name' 		=> _x('Portfolio','post type general name','simple-elegant'),
	);
	
	$args = array(
		'labels' 			=> $labels,
		'public' 			=> true,
		'publicly_queryable'=> true,
		'show_ui'			=> true, 
		'show_in_menu' 		=> true, 
		'query_var' 		=> true,
		'rewrite' 			=> array( 'slug' => $portfolio_slug ),
		'capability_type' 	=> 'post',
//		'has_archive' 		=> true,
		'hierarchical' 		=> false,
		'menu_position' 	=> null,
		'supports' 			=> array( 'title', 'editor', 'author', 'thumbnail', 'custom-fields', 'comments', 'post-formats' )
	); 
	
	register_post_type( 'portfolio', $args );
	
	flush_rewrite_rules();
}
}
/* --------------------------------------------------- */
/* Register Portfolio Category
/* --------------------------------------------------- */
add_action( 'init', 'withemes_register_portfolio_category', 0 );

if ( !function_exists('withemes_register_portfolio_category') ) {
function withemes_register_portfolio_category(){

	$cat_slug = 'portfolio_category';
    
    $cat_slug = trim( get_option( 'withemes_portfolio_category_slug', 'portfolio_category' ) );
    $cat_slug = sanitize_title_with_dashes( $cat_slug );
    if ( ! $cat_slug ) $cat_slug = 'portfolio_category';

	$labels = array(
		'name'                => _x( 'Portfolio Categories', 'taxonomy general name','simple-elegant'),
		'singular_name'       => _x( 'Portfolio Category', 'taxonomy singular name','simple-elegant'),
		'search_items'        => esc_html__( 'Search Portfolio Categories','simple-elegant'),
		'all_items'           => esc_html__( 'All Portfolio Categories','simple-elegant'),
		'parent_item'         => esc_html__( 'Parent Portfolio Category','simple-elegant'),
		'parent_item_colon'   => esc_html__( 'Parent Portfolio Category:','simple-elegant'),
		'edit_item'           => esc_html__( 'Edit Portfolio Category','simple-elegant'), 
		'update_item'         => esc_html__( 'Update Portfolio Category','simple-elegant'),
		'add_new_item'        => esc_html__( 'Add New Portfolio Category','simple-elegant'),
		'new_item_name'       => esc_html__( 'New Portfolio Category Name','simple-elegant'),
		'menu_name'           => esc_html__( 'Portfolio Category','simple-elegant')
	); 	
	
	$args = array(
		'public'			  => true,
		'hierarchical'        => true,
		'labels'              => $labels,
		'show_ui'             => true,
		'show_admin_column'   => true,
		'query_var'           => true,
		'rewrite'			  => array( 'slug' => $cat_slug ),
	);
	
	register_taxonomy( 'portfolio_category', array( 'portfolio'), $args );
}

}

/* --------------------------------------------------- */
/* Filter Portfolios by Categories in Edit Screen (edit.php)
/* Source: http://wordpress.org/support/topic/add-taxonomy-filter-to-admin-list-for-my-custom-post-type
/* --------------------------------------------------- */
add_action('restrict_manage_posts', 'withemes_restrict_portfolios_by_category');
if ( !function_exists('withemes_restrict_portfolios_by_category') ){
function withemes_restrict_portfolios_by_category() {
		global $typenow;
		$post_type = 'portfolio'; // change HERE
		$taxonomy = 'portfolio_category'; // change HERE
		if ($typenow == $post_type) {
			$selected = isset($_GET[$taxonomy]) ? $_GET[$taxonomy] : '';
			$info_taxonomy = get_taxonomy($taxonomy);
			wp_dropdown_categories(array(
				'show_option_all' => sprintf(esc_html__('All %s','simple-elegant') , $info_taxonomy->label ),
				'taxonomy' => $taxonomy,
				'name' => $taxonomy,
				'orderby' => 'name',
				'selected' => $selected,
				'show_count' => true,
				'hide_empty' => true,
			));
		}
}
}	
add_filter('parse_query', 'withemes_convert_id_to_term_in_query');
if ( !function_exists('withemes_convert_id_to_term_in_query') ) {
function withemes_convert_id_to_term_in_query($query) {
		global $pagenow;
		$post_type = 'portfolio'; // change HERE
		$taxonomy = 'portfolio_category'; // change HERE
		$q_vars = &$query->query_vars;
		if ($pagenow == 'edit.php' && isset($q_vars['post_type']) && $q_vars['post_type'] == $post_type && isset($q_vars[$taxonomy]) && is_numeric($q_vars[$taxonomy]) && $q_vars[$taxonomy] != 0) {
			$term = get_term_by('id', $q_vars[$taxonomy], $taxonomy);
			$q_vars[$taxonomy] = $term->slug;
		}
}
}