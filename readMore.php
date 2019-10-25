<?php 
/*==============================================
/* Update excerpt length instead of 55 words*/
/*==============================================*/
function wpdocs_custom_excerpt_length( $length ) {
      return 12;
}
add_filter( 'excerpt_length', 'wpdocs_custom_excerpt_length', 999 );
/*=================================================
// Replaces the excerpt "Read More" text by a link
/*=================================================*/
function new_excerpt_more($more) {
  global $post;
  return '<a class="moretag text-dark" href="'. get_permalink($post->ID) . '">  &raquo; &raquo; &raquo; &raquo; </a>';
}
add_filter('excerpt_more', 'new_excerpt_more');
/*=====================================
/* Update excerpt different length*/
/*=====================================*/
function excerpt($limit) {
       $excerpt = explode(' ', get_the_content(), $limit);
      if (count($excerpt) >= $limit) {
          array_pop($excerpt);
          $excerpt = implode(" ", $excerpt) . ' <a class="moretag h5 text-dark" href="'. get_permalink() . '">  &raquo; &raquo; &raquo; &raquo; &raquo; &raquo; &raquo; &raquo; </a>';
      } else {
          $excerpt = implode(" ", $excerpt);      }
      $excerpt = preg_replace('`\[[^\]]*\]`', '', $excerpt);
      return $excerpt;
}
function content($limit) {
    $content = explode(' ', get_the_content(), $limit);
    if (count($content) >= $limit) {
        array_pop($content);
        $content = implode(" ", $content) . ' <a class="moretag h5 text-dark" href="'. get_permalink() . '">  &raquo; &raquo; &raquo; &raquo; &raquo; &raquo; &raquo; &raquo; </a>';
    } else {
        $content = implode(" ", $content);
    }
    $content = preg_replace('/\[.+\]/','', $content);
    $content = apply_filters('the_content', $content); 
    $content = str_replace(']]>', ']]&gt;', $content);
    return $content;
}
?>