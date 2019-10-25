<?php 
/*====================
// add theme support, 
/*====================*/
add_theme_support('post-thumbnails');
add_image_size( 'sidebar-thumb', 120, 120, true ); // Hard Crop Mode
add_image_size( 'product-thumb', 200, 200, array( 'center', 'center' ) );
add_image_size( 'custom-thumb', 250, 300, array( 'center', 'center' ) );
add_image_size( 'square-thumb', 400, 400, array( 'center', 'center' ) );
add_image_size( 'homepage-thumb', 1204, 400, array( 'top', 'left' ));
add_image_size( 'singlepost-thumb', 590, 9999 ); // Unlimited Height Mode, soft crop mode
// there are 9 different post formats, preset wordpress format
add_theme_support('post-formats');
add_theme_support( 'post-formats', array( 'aside', 'chat', 'quote', 'gallery', 'image', 'status', 'link', 'video') );
add_theme_support('html5', array('search-form'));
/*====================
// add menu support
/*====================*/
function awesome_menu_support(){
	add_theme_support('menus');
	register_nav_menus(
	array(
      'primary' => __( 'Primary Menu' ),
      'secondary' => __( 'Secondary Menu'),
      'footer' => __( 'Footer Menu'),
      'extra' => __( 'Extra Menu'),
      'extra2' => __( 'Extra Menu 2')
  	)
  );
}
add_action('init', 'awesome_menu_support');
/*================
// Add sidebar
/*================*/
function awesome_widget_setup(){
  register_sidebar(
    array(
      'name' => 'Sidebar',
      'id' => 'sidebar-1',
      'class' => 'custom',
      'description' => 'this is the first custom sidebar',
      'before_widget' => '<aside id="%1$s" class="widget %2$s">',
      'after_widget' => '</aside>',
      'before_title' => '<h3 class="widget-title">',
      'after_title' => '</h3>'
    )
  );
  register_sidebar(
    array(
      'name' => 'Sidebar2',
      'id' => 'sidebar-2',
      'class' => 'custom',
      'description' => 'this is the second custom sidebar',
      'before_widget' => '<aside id="%1$s" class="widget %2$s">',
      'after_widget' => '</aside>',
      'before_title' => '<h1 class="widget-title">',
      'after_title' => '</h1>'
    )
  );
	 register_sidebar(
    array(
      'name' => 'Sidebar3',
      'id' => 'sidebar-3',
      'class' => 'custom',
      'description' => 'this is the third custom sidebar',
      'before_widget' => '<aside id="%1$s" class="widget %2$s">',
      'after_widget' => '</aside>',
      'before_title' => '<h1 class="widget-title">',
      'after_title' => '</h1>'
    )
  );
}
add_action('widgets_init','awesome_widget_setup');
/*=======================================
//define different post number for pages
/*=======================================*/
add_action('pre_get_posts', 'ci_paging_request');
function ci_paging_request($wp) {
	//We don't want to mess with the admin panel.
	if(is_admin()) return;
	$num = get_option('posts_per_page', 15);
	if( is_home() )
		$num = 12;
	if( is_archive() )
		$num = 10;
	if( is_category() or is_tag() )
		$num = 6;
	if( is_category('exotic-flowers') )
		$num = -1; // -1 means No limit
	if( ! isset( $wp->query_vars['posts_per_page'] ) and is_main_query() ) {
		$wp->query_vars['posts_per_page'] = $num;
	}
}
?>