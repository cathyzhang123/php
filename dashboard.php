<?php 
// remove howdy
add_filter('gettext', 'change_howdy', 10, 3);
function change_howdy($translated, $text, $domain) {
    if (!is_admin() || 'default' != $domain)
        return $translated;
    if (false !== strpos($translated, 'Howdy'))
        return str_replace('Howdy', 'Welcome', $translated);
    return $translated;
}
//remove widgets_init// Main column (left):
function disable_default_dashboard_widgets() {
    global $wp_meta_boxes;
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_browser_nag']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts']);
    // bbpress
    unset($wp_meta_boxes['dashboard']['normal']['core']['bbp-dashboard-right-now']);
    // yoast seo
    unset($wp_meta_boxes['dashboard']['normal']['core']['yoast_db_widget']);
    // gravity forms
    unset($wp_meta_boxes['dashboard']['normal']['core']['rg_forms_dashboard']);
}
add_action('wp_dashboard_setup', 'disable_default_dashboard_widgets', 999);
//remove sidebar widget
function remove_some_widgets(){
    unregister_sidebar( 'first-footer-widget-area' );
    unregister_sidebar( 'second-footer-widget-area' );
    unregister_sidebar( 'third-footer-widget-area' );
    unregister_sidebar( 'fourth-footer-widget-area' );
}
add_action( 'widgets_init', 'remove_some_widgets', 11 );
// remove wordpress logo
function admin_css() {
	echo '';
}
add_action('admin_head','admin_css');
// remove version number 
function wpb_remove_version() {
  return '';
  }
add_filter('the_generator', 'wpb_remove_version');
// remove welcome screen
remove_action( 'welcome_panel', 'wp_welcome_panel' );
// remove footer 
function remove_footer_admin () { 
  echo 'Created by <a href="http://about.cathyzhang.org" target="_blank">Cathy Zhang</a>'; 
  } 
add_filter('admin_footer_text', 'remove_footer_admin');
/*add support for format specific template for all formats*/
function use_post_format_templates ( $template ) {
    if ( is_single() && has_post_format() ) {
        $post_format_template = locate_template( 'single/single-' . get_post_format() . '.php' );
        if ( $post_format_template ) {
            $template = $post_format_template;
        }
    }
    return $template;
}   
add_filter( 'template_include', 'use_post_format_templates' );
/* Single category post type*/
define('SINGLE_PATH', TEMPLATEPATH . '/single'); 
add_filter('single_template', 'my_single_template'); 
function my_single_template($single) {
	global $wp_query, $post; 
	foreach((array)get_the_category() as $cat) : 
	if(file_exists(SINGLE_PATH . '/single-cat-' . $cat->slug . '.php'))
	return SINGLE_PATH . '/single-cat-' . $cat->slug . '.php'; 
	elseif(file_exists(SINGLE_PATH . '/single-cat-' . $cat->term_id . '.php'))
	return SINGLE_PATH . '/single-cat-' . $cat->term_id . '.php'; 
	endforeach;
}
// wordpress copyright date
function wpb_copyright() {
	global $wpdb;
	$copyright_dates = $wpdb->get_results("
	SELECT
	YEAR(min(post_date_gmt)) AS firstdate,
	YEAR(max(post_date_gmt)) AS lastdate
	FROM
	$wpdb->posts
	WHERE
	post_status = 'publish'
	");
	$output = '';
	if($copyright_dates) {
	$copyright = "© " . $copyright_dates[0]->firstdate;
	if($copyright_dates[0]->firstdate != $copyright_dates[0]->lastdate) {
	$copyright .= '-' . $copyright_dates[0]->lastdate;
	}
	$output = $copyright;
	}
	return $output;
}
//remove jquery migrate
add_action('wp_default_scripts', function ($scripts) {
    if (!empty($scripts->registered['jquery'])) {
        $scripts->registered['jquery']->deps = array_diff($scripts->registered['jquery']->deps, ['jquery-migrate']);
    }
});
// remove help Tab
function oz_remove_help_tabs( $old_help, $screen_id, $screen ){
    $screen->remove_help_tabs();
    return $old_help;
}
add_filter( 'contextual_help', 'oz_remove_help_tabs', 999, 3 );
// remove screen option
add_filter( 'screen_options_show_screen', '__return_false' );
// remove screenoption
function wpse_edit_post_show_excerpt( $user_login, $user ) {
    $unchecked = get_user_meta( $user->ID, 'metaboxhidden_post', true );
    $key = array_search( 'postexcerpt', $unchecked );
    if ( FALSE !== $key ) {
        array_splice( $unchecked, $key, 1 );
        update_user_meta( $user->ID, 'metaboxhidden_post', $unchecked );
    }
}
add_action( 'wp_login', 'wpse_edit_post_show_excerpt', 10, 2 );
//Remove Default Image Links in WordPress
function wpb_imagelink_setup() {
    $image_set = get_option( 'image_default_link_type' );     
    if ($image_set !== 'none') {
        update_option('image_default_link_type', 'none');
    }
}
add_action('admin_init', 'wpb_imagelink_setup', 10);
// enable shortcode execution in text widget
add_filter('widget_text','do_shortcode');
/* Auto link featured image to linked post content*/
function wcs_auto_link_post_thumbnails( $html, $post_id, $post_image_id ) {
  $html = '<a href="' . get_permalink( $post_id ) . '" title="' . esc_attr( get_the_title( $post_id ) ) . '">' . $html . '</a>';
  return $html;
 }
add_filter( 'post_thumbnail_html', 'wcs_auto_link_post_thumbnails', 10, 3 );
//remove jquery migrate message
add_action('wp_default_scripts', function ($scripts) {
    if (!empty($scripts->registered['jquery'])) {
        $scripts->registered['jquery']->deps = array_diff($scripts->registered['jquery']->deps, ['jquery-migrate']);
    }
});
//get first and second paragraph
function get_first_paragraph(){
    global $post;
    $str = wpautop( get_the_content() );
    $str = substr( $str, 0, strpos( $str, '</p>' ) + 4 );
    $str = strip_tags($str, '<a><strong><em>');
    return '<p>' . $str . '</p>';
}
function get_the_post(){
    global $post;
    $str = wpautop( get_the_content() );
    $str = substr( $str, (strpos( $str, '</p>')));
    return $str;
}
//add content after third paragraph of single post, change number after $content_block 
add_filter('the_content', 'mte_add_incontent_ad');
function mte_add_incontent_ad($content)
{	if(is_single()){
		$content_block = explode('<p>',$content);
		if(!empty($content_block[2]))
		{	$content_block[2] .= '<h1 class="font-weight-bold">This is testing message, please make change. </h1>';
		}
		for($i=1;$i<count($content_block);$i++)
		{	$content_block[$i] = '<p>'.$content_block[$i];
		}
		$content = implode('',$content_block);
	}
	return $content;	
}
// allow dupliate comments
function enable_duplicate_comments_preprocess_comment($comment_data) {
  //add some random content to comment to keep dupe checker from finding it
  $random = md5(time());  
  $comment_data['comment_content'] .= "disabledupes{" . $random . "}disabledupes";   
  return $comment_data;
}
add_filter('preprocess_comment', 'enable_duplicate_comments_preprocess_comment');
function enable_duplicate_comments_comment_post($comment_id) {
  global $wpdb;  
  //remove the random content
  $comment_content = $wpdb->get_var("SELECT comment_content FROM $wpdb->comments WHERE comment_ID = '$comment_id' LIMIT 1");  
  $comment_content = preg_replace("/disabledupes{.*}disabledupes/", "", $comment_content);
  $wpdb->query("UPDATE $wpdb->comments SET comment_content = '" . $wpdb->escape($comment_content) . "' WHERE comment_ID = '$comment_id' LIMIT 1");   
  /*    add your own dupe checker here if you want  */
}
add_action('comment_post', 'enable_duplicate_comments_comment_post'); 
// add custom logo on dashboard
function wpb_custom_logo() {
echo '<style type="text/css">
      #wpadminbar #wp-admin-bar-wp-logo > .ab-item .ab-icon:before {
      background-image: url(' . get_bloginfo('stylesheet_directory') . '/images/core-image/icon.png) !important;
      background-position: center center;
      background-size: cover;
      backgroun-repeat: no-repeat;
      color:rgba(0, 0, 0, 0);
      }
      #wpadminbar #wp-admin-bar-wp-logo.hover > .ab-item .ab-icon {
      background-position: 0 0;
      }
      </style>
';
}
add_action('wp_before_admin_bar_render', 'wpb_custom_logo');
// change default gravatar
function wpb_new_gravatar ($avatar_defaults) {
$myavatar = 'http://china.cathyzhang.org/wp-content/themes/framework/images/core-image/logo.png';
$avatar_defaults[$myavatar] = "Default Gravatar";
return $avatar_defaults;
}
add_filter( 'avatar_defaults', 'wpb_new_gravatar' );
?>