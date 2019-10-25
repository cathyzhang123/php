<?php 
/*====================================
/* Add thumnail in post list page*/
/*====================================*/
add_filter('manage_pages_columns', 'posts_columns', 5);
add_action('manage_pages_custom_column', 'posts_custom_columns', 5, 2);
add_filter('manage_posts_columns', 'posts_columns', 5);
add_action('manage_posts_custom_column', 'posts_custom_columns', 5, 2);
add_filter('manage_post-type_posts_columns', 'posts_columns', 5);
add_action('manage_post-type_posts_custom_column', 'posts_custom_columns', 5, 2);
function posts_columns($defaults){
    $defaults['riv_post_thumbs'] = __('Thumbs');
    return $defaults;
}
function posts_custom_columns($column_name, $id){
    if($column_name === 'riv_post_thumbs'){
    if( has_post_thumbnail() ) {
        echo the_post_thumbnail('Thumbnail');
    } else {
        _e('No Thumbnail For Post');
        }        
  echo "  
<style> .column-riv_post_thumbs img{ max-height: 100px; max-width: 100px;     } </style>
"; } }
/*===============================================
// remove tag or category item from dashboard
=================================================*/
function my_manage_columns( $columns ) {
    unset($columns['date'], $columns['tags']);
    return $columns;
}
function my_column_init() {
    add_filter( 'manage_posts_columns' , 'my_manage_columns' );
}
add_action( 'admin_init' , 'my_column_init' );
/*================================================
// add post id and format in admin page
/*================================================*/
add_filter('manage_posts_columns', 'posts_columns_id', 5);
add_action('manage_posts_custom_column', 'posts_custom_id_columns', 5, 2);
add_filter('manage_pages_columns', 'posts_columns_id', 5);
add_action('manage_pages_custom_column', 'posts_custom_id_columns', 5, 2); 
function posts_columns_id($defaults){
    $defaults['wps_post_id'] = __('ID');
    $defaults['get_post_format()'] = __('Formats');
    return $defaults;
}
function posts_custom_id_columns($column_name, $id){
    if($column_name === 'wps_post_id'){
            echo $id;
    }
    if($column_name === 'get_post_format()'){
            echo get_post_format();
    }
}
/*==========================================================================================
/* Prevent users from forgetting featured image when adding new post or new custom post */
/*==========================================================================================*/
 add_action('save_post', 'pu_validate_thumbnail');
 function pu_validate_thumbnail($post_id) {
  if((get_post_type($post_id) != 'post')  && (get_post_type($post_id) != 'recipe') && (get_post_type($post_id) != 'portfolio'))
 return;
  if ( !has_post_thumbnail( $post_id ) ) {
  set_transient( "pu_validate_thumbnail_failed", "true" );
  remove_action('save_post', 'pu_validate_thumbnail');
 	wp_update_post(array('ID' => $post_id, 'post_status' => 'draft'));
 	add_action('save_post', 'pu_validate_thumbnail');
 } else {
 delete_transient( "pu_validate_thumbnail_failed" );
 }
 }
/*==========================================================
/*Display error message if users forget to upload image */
/*==========================================================*/
 add_action('admin_notices', 'pu_validate_thumbnail_error');
 function pu_validate_thumbnail_error() {
 if ( get_transient( "pu_validate_thumbnail_failed" ) == "true" ) {
 echo "<div id='message' class='error'><p><strong>A post thumbnail must be uploaded before a post can be saved.  Post status will be Draft if a featured image is not set.</strong></p></div>";
 delete_transient( "pu_validate_thumbnail_failed" ); }
 }
/*======================================================
/* Change set featured image text to something else */
/*======================================================*/
function change_featured_image_text( $content ) {
    return $content = str_replace( __( 'Set featured image' ), __( 'Click here to upload your image' ), $content);
}
add_filter( 'admin_post_thumbnail_html', 'change_featured_image_text' );
/*===================================
//add export button to post screen
/*===================================*/
add_action( 'restrict_manage_posts', 'add_export_button' );
function add_export_button() {
    $screen = get_current_screen(); 
    if (isset($screen->parent_file) && ('edit.php' == $screen->parent_file)) {
        ?>
        <input type="submit" name="export_all_posts" id="export_all_posts" class="button button-primary" value="Export All Posts">
        <script type="text/javascript">
            jQuery(function($) {
                $('#export_all_posts').insertAfter('#post-query-submit');
            });
        </script>
        <?php
    }
}
add_action( 'init', 'func_export_all_posts' );
function func_export_all_posts() {
    if(isset($_GET['export_all_posts'])) {
        $arg = array(
                'post_type' => 'post',
                'post_status' => 'publish',
                'posts_per_page' => -1,
//								'category_name' => 'breakfast',
            ); 
        global $post;
        $arr_post = get_posts($arg);
        if ($arr_post) {
						header('Content-Encoding: UTF-8');
            header('Content-Type: text/csv; charset=utf-8');
            header(sprintf( 'Content-Disposition: attachment; filename=my-csv-%s.csv', date( 'dmY-His' ) ) );
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
						header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
						header('Pragma: public');
 
           	$file = fopen('php://output', 'w');
					 	fputs( $file, "\xEF\xBB\xBF" ); 

						fputcsv($file, array('Post Title', 'URL', 'Post Content', 'Post Category', 'Post Date')); 
					
            foreach ($arr_post as $post) {
                setup_postdata($post);
								fputcsv( $file, array( get_the_title(), get_the_permalink() , get_the_content(), get_the_category($post->ID), get_the_date() ) );
            } 
            exit();
        }
    }
}
/*====================================
//add export button to page screen
/*====================================*/
add_action( 'restrict_manage_posts', 'add_page_export_button' );
function add_page_export_button() {
    $screen = get_current_screen(); 
    if (isset($screen->parent_file) && ('edit.php?post_type=page' == $screen->parent_file)) {
        ?>
        <input type="submit" name="export_all_pages" id="export_all_pages" class="button button-primary" value="Export All Pages">
        <script type="text/javascript">
            jQuery(function($) {
                $('#export_all_pages').insertAfter('#post-query-submit');
            });
        </script>
        <?php
    }
}
add_action( 'init', 'func_export_all_pages' );
function func_export_all_pages() {
    if(isset($_GET['export_all_pages'])) {
        $arg = array(
                'post_type' => 'page',
                'post_status' => 'publish',
                'posts_per_page' => -1,
            ); 
        global $post;
        $arr_post = get_posts($arg);
        if ($arr_post) { 
						header('Content-Encoding: UTF-8');
            header('Content-Type: text/csv; charset=utf-8');
            header(sprintf( 'Content-Disposition: attachment; filename=my-csv-%s.csv', date( 'dmY-His' ) ) );
						header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
						header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
						header('Pragma: public');
 
            $file = fopen('php://output', 'w');
						fputs( $file, "\xEF\xBB\xBF" ); 
 
            fputcsv($file, array('Page Title', 'URL', 'Content', 'Page Date'));
 
            foreach ($arr_post as $post) {
                setup_postdata($post);
                fputcsv($file, array(get_the_title(), get_the_permalink(), get_the_content(), get_the_date()));
            } 
            exit();
        }
    }
}
/*================================================
//add export button to recipe custom post screen
/*================================================*/
add_action( 'restrict_manage_posts', 'add_recipe_export_button' );
function add_recipe_export_button() {
    $screen = get_current_screen(); 
    if (isset($screen->parent_file) && ('edit.php?post_type=recipe' == $screen->parent_file)) {
        ?>
        <input type="submit" name="export_all_recipes" id="export_all_recipes" class="button button-primary" value="Export All Recipes">
        <script type="text/javascript">
            jQuery(function($) {
                $('#export_all_recipes').insertAfter('#post-query-submit');
            });
        </script>
        <?php
    }
}
add_action( 'init', 'func_export_all_recipes' );
function func_export_all_recipes() {
    if(isset($_GET['export_all_recipes'])) {
        $arg = array(
                'post_type' => 'recipe',
                'post_status' => 'publish',
                'posts_per_page' => -1,
            ); 
        global $post;
        $arr_post = get_posts($arg);
        if ($arr_post) { 
						header('Content-Encoding: UTF-8');
            header('Content-Type: text/csv; charset=utf-8');
            header(sprintf( 'Content-Disposition: attachment; filename=my-csv-%s.csv', date( 'dmY-His' ) ) );
						header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
						header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
						header('Pragma: public');
 
            $file = fopen('php://output', 'w');
						fputs( $file, "\xEF\xBB\xBF" ); 
 
            fputcsv($file, array('Recipe Title', 'URL', 'Content', 'Post Thumbnail URL', 'Recipe Date'));
 
            foreach ($arr_post as $post) {
                setup_postdata($post);
                fputcsv($file, array(get_the_title(), get_the_permalink(), get_the_content(), get_the_post_thumbnail_url(), get_the_date()));
            } 
            exit();
        }
    }
}
/*==================================================
//add export button to porfolio custom post screen
/*==================================================*/
add_action( 'restrict_manage_posts', 'add_portfolio_export_button' );
function add_portfolio_export_button() {
    $screen = get_current_screen(); 
    if (isset($screen->parent_file) && ('edit.php?post_type=portfolio' == $screen->parent_file)) {
        ?>
        <input type="submit" name="export_all_portfolios" id="export_all_portfolios" class="button button-primary" value="Export All Portfolios">
        <script type="text/javascript">
            jQuery(function($) {
                $('#export_all_portfolios').insertAfter('#post-query-submit');
            });
        </script>
        <?php
    }
}
add_action( 'init', 'func_export_all_portfolios' );
function func_export_all_portfolios() {
    if(isset($_GET['export_all_portfolios'])) {
        $arg = array(
                'post_type' => 'portfolio',
                'post_status' => 'publish',
                'posts_per_page' => -1,
            ); 
        global $post;
        $arr_post = get_posts($arg);
        if ($arr_post) { 
						header('Content-Encoding: UTF-8');
            header('Content-Type: text/csv; charset=utf-8');
            header(sprintf( 'Content-Disposition: attachment; filename=my-csv-%s.csv', date( 'dmY-His' ) ) );
						header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
						header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
						header('Pragma: public');
 
            $file = fopen('php://output', 'w');
						fputs( $file, "\xEF\xBB\xBF" ); 
 
            fputcsv($file, array('Portfolio Title', 'URL', 'Content', 'Post Thumbnail URL', 'Portfolio Date'));
 
            foreach ($arr_post as $post) {
                setup_postdata($post);
                fputcsv($file, array(get_the_title(), get_the_permalink(), get_the_content(), get_the_post_thumbnail_url(), get_the_date()));
            } 
            exit();
        }
    }
}
?>