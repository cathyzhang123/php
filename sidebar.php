<?php
/*========================================
  Display posts by category
  ========================================*/
//total number of posts
function wpb_total_posts() { 
$total = wp_count_posts()->publish;
echo  $total;
} 
//=======================================================
// by FOOD
//=========================================================*/
/*5 posts per page */
function wpb_postsbycategory_food() {
// the query
   global $post; 
   $current_id = get_the_ID();
   $the_query = new WP_Query( array( 
		 'category_name' => 'food', /*CHANGE category name here*/
		 'posts_per_page' => 5, 
		 'post__not_in' => array($post->ID)) 
	); 
// The Loop
if ( $the_query->have_posts() ) {
  $string = null;
    $string .= '<ul class="postsbycategory widget_recent_entries pl-0">';
    while ( $the_query->have_posts() ) {
        $the_query->the_post();
            if ( has_post_thumbnail() ) {
						$string .= '<hr class="style-six"';
            $string .= '<li class="my-5">';
            $string .=  '<div class="mb-3 d-flex align-items-center">'.get_the_post_thumbnail( $post->ID, array( 50, 50) ). '<span class="pl-4"><a href="' . get_the_permalink() .'" rel="bookmark">' . get_the_title() . '<br><small>'. get_the_author(). ' •  ' . get_the_time('M j, Y') . ' at ' . get_the_time('g:i a') .'</small></a></span></div></li>';
            } else { 
            // if no featured image is found
						$string .= '<hr class="style-six"';
            $string .= '<li class="my-5"><a href="' . get_the_permalink() .'" rel="bookmark">' . get_the_title() . '<br>';
            $string .= '<small>' . get_the_author() . ' •  ' . get_the_time('M j, Y') . ' at ' . get_the_time('g:i a') . ' </small></a></li>'; 
            }
            }
    } else {
    // no posts found
}
$string .= '</ul>'; 
return $string; 
wp_reset_postdata();
}
add_shortcode('categoryposts_food', 'wpb_postsbycategory_food'); 
/*3 posts per page */
function wpb_postsbycategory_food_3() {
// the query
   global $post; 
   $current_id = get_the_ID();
   $the_query = new WP_Query( array( 
		 'category_name' => 'food',  /*CHANGE category name here*/
		 'posts_per_page' => 3, 
		 'post__not_in' => array($post->ID)) 
	); 
// The Loop
if ( $the_query->have_posts() ) {
  $string = null;
    $string .= '<ul class="postsbycategory widget_recent_entries pl-0">';
    while ( $the_query->have_posts() ) {
        $the_query->the_post();
            if ( has_post_thumbnail() ) {
						$string .= '<hr class="style-six"';
            $string .= '<li class="my-5">';
            $string .=  '<div class="mb-3 d-flex align-items-center">'.get_the_post_thumbnail( $post->ID, array( 50, 50) ). '<span class="pl-4"><a href="' . get_the_permalink() .'" rel="bookmark">' . get_the_title() . '<br><small>'. get_the_author(). ' •  ' . get_the_time('M j, Y') . ' at ' . get_the_time('g:i a') .'</small></a></span></div></li>';
            } else { 
            // if no featured image is found
						$string .= '<hr class="style-six"';
            $string .= '<li class="my-5"><a href="' . get_the_permalink() .'" rel="bookmark">' . get_the_title() . '<br>';
            $string .= '<small>' . get_the_author() . ' •  ' . get_the_time('M j, Y') . ' at ' . get_the_time('g:i a') . ' </small></a></li>'; 
            }
            }
    } else {
    // no posts found
}
$string .= '</ul>'; 
return $string; 
wp_reset_postdata();
}
add_shortcode('categoryposts_food_3', 'wpb_postsbycategory_food_3'); 
//=======================================================
// by COOKING
//=========================================================*/
function wpb_postsbycategory_cooking() {
// the query
   	global $post; 
		$the_query = new WP_Query( array( 
			'category_name' => 'cooking', 
			'posts_per_page' => 5, 
			'post__not_in' => array($post->ID) ) 
		); 
// The Loop
if ( $the_query->have_posts() ) {
  $string = null;
    $string .= '<ul class="postsbycategory widget_recent_entries pl-0">';
    while ( $the_query->have_posts() ) {
        $the_query->the_post();
           	if ( has_post_thumbnail() ) {
						$string .= '<hr class="style-six"';
            $string .= '<li class="my-5">';
           	$string .=  '<div class="mb-3 d-flex align-items-center">'.get_the_post_thumbnail( $post->ID, array( 50, 50) ). '<span class="pl-4"><a href="' . get_the_permalink() .'" rel="bookmark">' . get_the_title() . '<br><small>'. get_the_author(). ' •  ' . get_the_time('M j, Y') . ' at ' . get_the_time('g:i a') .'</small></a></span></div></li>'; 						
            } else { 
            // if no featured image is found
						$string .= '<hr class="style-six"';
            $string .= '<li class="my-5"><a href="' . get_the_permalink() .'" rel="bookmark">' . get_the_title() . '<br>';
            $string .= '<small class="post-meta">' . get_the_author() . ' •  ' . get_the_time('M j, Y') . ' at ' . get_the_time('g:i a') . ' </small></a></li>'; 
            }
            }
    } else {
    // no posts found
}
$string .= '</ul>'; 
return $string; 
wp_reset_postdata();
}
add_shortcode('categoryposts_cooking', 'wpb_postsbycategory_cooking'); 
/* 3 posts per page */
function wpb_postsbycategory_cooking_3() {
// the query
  global $post; 
	$the_query = new WP_Query( array( 
		'category_name' => 'cooking', 
		'posts_per_page' => 3, 
		'post__not_in' => array($post->ID) ) 
	); 
// The Loop
if ( $the_query->have_posts() ) {
  $string = null;
    $string .= '<ul class="postsbycategory widget_recent_entries pl-0">';
    while ( $the_query->have_posts() ) {
        $the_query->the_post();
           	if ( has_post_thumbnail() ) {
						$string .= '<hr class="style-six"';
            $string .= '<li class="my-5">';
            $string .=  '<div class="mb-3 d-flex align-items-center">'.get_the_post_thumbnail( $post->ID, array( 50, 50) ). '<span class="pl-4"><a href="' . get_the_permalink() .'" rel="bookmark">' . get_the_title() . '<br><small>'. get_the_author(). ' •  ' . get_the_time('M j, Y') . ' at ' . get_the_time('g:i a') .'</small></a></span></div></li>';						
            } else { 
            // if no featured image is found
						$string .= '<hr class="style-six"';							
            $string .= '<li class="my-5"><a href="' . get_the_permalink() .'" rel="bookmark">' . get_the_title() . '<br>';
            $string .= '<small class="post-meta">' . get_the_author() . ' •  ' . get_the_time('M j, Y') . ' at ' . get_the_time('g:i a') . ' </small></a></li>'; 
            }
            }
    } else {
    // no posts found
}
$string .= '</ul>'; 
return $string; 
wp_reset_postdata();
}
add_shortcode('categoryposts_cooking_3', 'wpb_postsbycategory_cooking_3'); 

//=======================================================
// by lifestyle
//=========================================================*/
function wpb_postsbycategory_lifestyle() {
// the query
  global $post; 
  $current_id = get_the_ID();
$the_query = new WP_Query( array( 'category_name' => 'lifestyle', 'posts_per_page' => 5, 'post__not_in' => array($post->ID))  ); 
 
// The Loop
if ( $the_query->have_posts() ) {
  $string = null;
    $string .= '<ul class="postsbycategory widget_recent_entries pl-0">';
    while ( $the_query->have_posts() ) {
        $the_query->the_post();
           	if ( has_post_thumbnail() ) {
						$string .= '<hr class="style-six"';
            $string .= '<li class="my-5">';
            $string .=  '<div class="mb-3 d-flex align-items-center">'.get_the_post_thumbnail( $post->ID, array( 50, 50) ). '<span class="pl-4"><a href="' . get_the_permalink() .'" rel="bookmark">' . get_the_title() . '<br><small>'. get_the_author(). ' •  ' . get_the_time('M j, Y') . ' at ' . get_the_time('g:i a') .'</small></a></span></div></li>';  
            } else { 
            // if no featured image is found
						$string .= '<hr class="style-six"';
            $string .= '<li class="my-5"><a href="' . get_the_permalink() .'" rel="bookmark">' . get_the_title() . '<br>';
            $string .= '<small class="post-meta">' . get_the_author() . ' •  ' . get_the_time('M j, Y') . ' at ' . get_the_time('g:i a') . ' </small></a></li>'; 
            }
            }
    } else {
    // no posts found
}
$string .= '</ul>'; 
return $string; 
wp_reset_postdata();
}
add_shortcode('categoryposts_lifestyle', 'wpb_postsbycategory_lifestyle'); 


function wpb_postsbycategory_lifestyle_3() {
// the query
  global $post; 
  $current_id = get_the_ID();
$the_query = new WP_Query( array( 'category_name' => 'lifestyle', 'posts_per_page' => 3, 'post__not_in' => array($post->ID))  ); 
 
// The Loop
if ( $the_query->have_posts() ) {
  $string = null;
    $string .= '<ul class="postsbycategory widget_recent_entries pl-0">';
    while ( $the_query->have_posts() ) {
        $the_query->the_post();
           	if ( has_post_thumbnail() ) {
						$string .= '<hr class="style-six"';
            $string .= '<li class="my-5">';
            $string .=  '<div class="mb-3 d-flex align-items-center">'.get_the_post_thumbnail( $post->ID, array( 50, 50) ). '<span class="pl-4"><a href="' . get_the_permalink() .'" rel="bookmark">' . get_the_title() . '<br><small>'. get_the_author(). ' •  ' . get_the_time('M j, Y') . ' at ' . get_the_time('g:i a') .'</small></a></span></div></li>';  
            } else { 
            // if no featured image is found
            $string .= '<li class="my-5"><a href="' . get_the_permalink() .'" rel="bookmark">' . get_the_title() . '<br>';
            $string .= '<small class="post-meta">' . get_the_author() . ' •  ' . get_the_time('M j, Y') . ' at ' . get_the_time('g:i a') . ' </small></a></li>'; 
            }
            }
    } else {
    // no posts found
}
$string .= '</ul>'; 
return $string; 
wp_reset_postdata();
}
add_shortcode('categoryposts_lifestyle_3', 'wpb_postsbycategory_lifestyle_3'); 
?>