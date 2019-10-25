<?php
/*==============================
Include walker and customizer
================================*/
// Include custom navwalker for navigation menu
require get_template_directory().'/includes/class-wp-bootstrap-navwalker.php';
// inclusde customerizer file
require get_template_directory(). '/includes/customizer.php';
/*===============================
Hook stylesheet and js files
=================================*/
// Hook js
function awesome_script_enqueue(){
  // js jquery
  wp_enqueue_script('jquery', '', array(), '', true); 
} 
add_action('wp_enqueue_scripts', 'awesome_script_enqueue');
// link different stylesheet
function wpdocs_theme_name_scripts() {
    wp_enqueue_style( 'global', get_stylesheet_uri() );
    if ( is_page(2655) ) {
      wp_enqueue_style( 'page-login', get_template_directory_uri() . '/css/page-login.css' );
    }
		if ( is_page(2659) ) {
      wp_enqueue_style( 'page-register', get_template_directory_uri() . '/css/page-register.css' );
    }
}
add_action( 'wp_enqueue_scripts', 'wpdocs_theme_name_scripts' );
?>