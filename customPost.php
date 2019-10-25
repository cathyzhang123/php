<?php 
/*========================================
  Custom Portfolio Post Type
  ========================================*/
function awesome_custom_post_type(){
  $labels = array(
    'name' => 'Portfolios',
    'singular_name' => 'Portfolio',
    'add_new' => 'Add New Portfolio',
    'all_items' => 'All Portfolio',
    'add_new_item' => 'Add New Portfolio',
    'edit_item' => 'Edit Portfolio',
    'new_item' => 'New Portfolio',
    'view_item' => 'View Portfolio',
    'search_item' => 'Search Portfolio',
    'not_found' => "No portfolio found",
    'not_found_in_trash' > 'No portfolio found in trash',
    'parent_item_colon' => 'Parent Portfolio'
    );
  $args = array(
    'hierarchical' => true,
    'labels' => $labels,
    'public' => true,
    'has_archive' => true,
    'publicly_queryable' => true,
    'query_var' => true,
    'rewrite' => true,
    'capability_type' => 'post',
    'supports' => array(
      'title', 'editor','excerpt', 'category', 'format', 'author', 'thumbnail', 'comments', 'revisions',
    ),
		'show_ui' => true,
    'show_in_menu' => true,
    'show_in_nav_menus' => true,
    'show_in_admin_bar' => true, 
    'taxonomies' => array('category', 'post_tag'),
    'menu_position' => 5,
		'menu_icon' => 'dashicons-images-alt2',
		'can_export' => true,
    'exclude_from_search' => false
  );
  register_post_type('portfolio', $args);
}
add_action('init', 'awesome_custom_Post_type');
/*========================================
  Custom Recipe Post Type
  ========================================*/
function register_recipes_post_type() {
  $labels = array(
    'name' => 'Recipes',
    'singular_name' => 'Recipe',
    'add_new' => 'Add New Recipe',
    'all_items' => 'All Recipe',
    'add_new_item' => 'Add New Recipe',
    'edit_item' => 'Edit Recipe',
    'new_item' => 'New Recipe',
    'view_item' => 'View Recipe',
    'search_item' => 'Search Recipe',
    'not_found' => "No recipe found",
    'not_found_in_trash' > 'No recipe found in trash',
    'parent_item_colon' => 'Parent Recipe'
    );
  $args = array(
    'hierarchical' => true,
    'labels' => $labels,
    'public' => true,
    'has_archive' => true,
    'publicly_queryable' => true,
    'query_var' => true,
    'rewrite' => true,
    'capability_type' => 'post',
    'supports' => array(
      'title', 'editor','excerpt', 'category', 'format', 'author', 'thumbnail', 'comments', 'revisions',
    ),
		'show_ui' => true,
    'show_in_menu' => true,
    'show_in_nav_menus' => true,
    'show_in_admin_bar' => true, 
    'taxonomies' => array('category', 'post_tag'),
    'menu_position' => 6,
		'menu_icon' => 'dashicons-buddicons-community',
		'can_export' => true,
    'exclude_from_search' => false
  );
    register_post_type( 'recipe', $args );
}
add_action( 'init', 'register_recipes_post_type' );
?>