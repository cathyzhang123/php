<?php
/*========================================
  Display related author posts
  ========================================*/
function get_related_author_posts() {
    global $authordata, $post; 
    $authors_posts = get_posts( array( 'author' => $authordata->ID, 'post__not_in' => array( $post->ID ), 'posts_per_page' => 3, 'category__in' => array(3, 4, 5), 'category__not_in' => array(251, 242, 252, 1, 253) ) );
    $output = '<div class="row">';
    foreach ( $authors_posts as $authors_post ) {
        $output .= '<div class="col-md-3"><a href="' . get_permalink( $authors_post->ID ) . '">' . apply_filters( 'the_title', $authors_post->post_title, $authors_post->ID ) ;
        $output .=  apply_filters( 'the_time', $authors_post->post_time, $authors_post->ID ) .  '</a></div>';  
    }
    $output .= '</div>'; 
    return $output;
}
/*========================================================================
/* Display total number of post for specific category.   two methods*/
/*=========================================================================*/
function wp_get_cat_postcount($id) {
    $cat = get_category($id);
    $count = (int) $cat->count;
    $taxonomy = 'category';
    $args = array(
      'child_of' => $id,
    );
    $tax_terms = get_terms($taxonomy,$args);
    foreach ($tax_terms as $tax_term) {
        $count +=$tax_term->count;
    }
    return $count;
}
function count_cat_post($category) {
if(is_string($category)) {
    $catID = get_cat_ID($category);
}
elseif(is_numeric($category)) {
    $catID = $category;
} else {
    return 0;
}
$cat = get_category($catID);
return $cat->count;
}
/*==================================
// Exclude page from search result
/*==================================*/
function search_filter($query) {
  if ( !is_admin() && $query->is_main_query() ) {
    if ($query->is_search) {
      $query->set('post_type', 'post');
    }
  }
}
add_action('pre_get_posts','search_filter');
/*===================================================
//Hide categories from WordPress category widget
/*===================================================*/
function exclude_widget_categories($args){
    $exclude = "999, 100";
    $args["exclude"] = $exclude;
    return $args;
}
add_filter("widget_categories_args","exclude_widget_categories");
/*============================================================
// Exclude specific categories in the post index, home.php
/*============================================================*/
function exclude_category( $query ) {
  if ( $query->is_home() && $query->is_main_query() ) {
        $query->set( 'cat', '-999, -1000');
      }
  }
add_action( 'pre_get_posts', 'exclude_category' );
?>