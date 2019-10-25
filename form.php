<?php
/*============================
/* Format comment form */
/*===========================*/
  // reverse comment order
add_filter( 'comments_array', 'array_reverse' );
  // remove url
function remove_comment_fields($fields) {
    unset($fields['url']);
    return $fields;
}
add_filter('comment_form_default_fields','remove_comment_fields');
// add new age field
function add_comment_fields($fields) { 
    $fields['age'] = '<p class="comment-form-age"><label for="age">' . __( 'Age' ) . '</label>' .
        '<input id="age" name="age" type="text" size="30"></p>';
    return $fields; 
}
add_filter('comment_form_default_fields','add_comment_fields');
// save new field Datafunction add_comment_meta_values($comment_id) {
function add_comment_meta_values($comment_id) { 
    if(isset($_POST['age'])) {
        $age = wp_filter_nohtml_kses($_POST['age']);
        add_comment_meta($comment_id, 'age', $age, false);
    } 
}
add_action ('comment_post', 'add_comment_meta_values', 1);
// move comment box at the bottom
function wpb_move_comment_field_to_bottom( $fields ) {
$comment_field = $fields['comment'];
unset( $fields['comment'] );
$fields['comment'] = $comment_field;
return $fields;
} 
add_filter( 'comment_form_fields', 'wpb_move_comment_field_to_bottom' );
/* comment form validation on the same page */
function comment_validation_init() {
if(is_singular() && comments_open() ) { ?>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/jquery.validate.js"></script>
<script type="text/javascript">
jQuery.validator.addMethod("emailExt", function(value, element, param) {
    return value.match(/^[a-zA-Z0-9_\.%\+\-]+@[a-zA-Z0-9\.\-]+\.[a-zA-Z]{2,}$/);
},'Your E-mail address is not valid, please enter a valid email address.');	
jQuery(document).ready(function($) {	
 $('#commentform').validate({ 
    // onfocusout: function(element) {
    //   this.element(element);
// },
rules: {
  author: {
    required: true,
    minlength: 1,
    normalizer: function(value) { return $.trim(value); }
  }, 
  email: {
    required: true,
	  email: true        
  }, 
  comment: {
    required: true,
    minlength: 10,
    normalizer: function(value) { return $.trim(value); }
  }
}, 
messages: {
  author: "Name should not be blank, please enter your name.",
  email: {
	 required: "Email should not be blank, please enter an email address.",
	 email: "Email is not valid, please enter a valid email address."
	},
  comment: {
	 required: "Message box should not be blank, please enter your message.", 
	 minlength: "Message should be at least 10 characters long, please re-enter."
	}
}, 
errorElement: "div",
errorPlacement: function(error, element) {
  element.after(error);
} 
});
});	
</script>
<?php
}
}
add_action('wp_footer', 'comment_validation_init');
/* format comment reply */
function pressfore_modify_comment_output( $comment, $args, $depth ) {
  $tag = ( 'div' === $args['style'] ) ? 'div' : 'li';
  ?>
  <<?php echo $tag; ?> id="comment-<?php comment_ID(); ?>" <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent', $comment ); ?>>
  <article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
    <div class="comment-meta w-100 p-5">
      <div class="comment-author text-white vcard">
        <span class="author-image"><?php echo get_avatar( get_the_author_meta('email'),'60'); ?></span>
        <?php
        /* translators: %s: comment author link */
        printf( __( '%s <span class="says">says:</span>' ),
            sprintf( '<b class="fn ml-5 pl-5 text-white">%s</b>', get_comment_author_link( $comment ) )
        );
        ?>
      </div><!-- .comment-author -->
      <div class="comment-metadata ml-5">
        <a href="<?php echo esc_url( get_comment_link( $comment, $args ) ); ?>" class="text-white">
          <time datetime="<?php comment_time( 'c' ); ?>">
            <?php
            printf( _x( '%s ago', '%s = human-readable time difference', 'china' ), human_time_diff( get_comment_time( 'U' ), current_time( 'timestamp' ) ) );
            ?>
          </time>
        </a>
        <?php edit_comment_link( __( 'Edit' ), '<span class="edit-link">', '</span>' ); ?>
        <span class="reply">
        <?php comment_reply_link(); ?>
      </span>
         <?php comment_reply_link(   __( 'Reply to me' ), '<span class="reply">', '</span>' ); ?>
      </div><!-- .comment-metadata -->      
      <?php if ( '0' == $comment->comment_approved ) : ?>
        <p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.' ); ?></p>
      <?php endif; ?>
    </div><!-- .comment-meta -->
    <div class="comment-content">
      <?php comment_text(); ?>
    </div><!-- .comment-content -->
  </article><!-- .comment-body -->
  <?php
}
function mytheme_comment($comment, $args, $depth) {
    if ( 'div' === $args['style'] ) {
        $tag       = 'div';
        $add_below = 'comment';
    } else {
        $tag       = 'li';
        $add_below = 'div-comment';
    }?>
    <<?php echo $tag; ?> <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?> id="comment-<?php comment_ID() ?>"><?php 
    if ( 'div' != $args['style'] ) { ?>
        <div id="div-comment-<?php comment_ID() ?>" class="comment-body"><?php } ?>
              <div class="comment-author vcard d-flex align-items-center justify-content-between">
                 <div class="comment-meta commentmetadata">
                <?php 
                  if ( $args['avatar_size'] != 0 ) { ?>
                   <span class="author-image"><?php echo get_avatar( get_the_author_meta('email'),'60'); ?></span>
                     <?php }; 
                  printf( __( '<cite class="fn">%s</cite> <span class="says">says:</span>' ), get_comment_author_link() ); ?>
                  <?php 
                    if ( $comment->comment_approved == '0' ) { ?>
                        <em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.' ); ?></em><br/><?php 
                    } ?>       
                  <a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ); ?>">
                    <time datetime="<?php comment_time( 'c' ); ?>">
                      <?php
                      printf( _x( '%s ago', '%s = human-readable time difference', 'china' ), human_time_diff( get_comment_time( 'U' ), current_time( 'timestamp' ) ) );
                      ?>
                    </time>
                  </a>
                  <?php 
                  edit_comment_link( __( '(Edit)' ), '  ', '' ); ?>              
              </div><!-- comment-meta -->
              	 <div class="reply btn btn-secondary rounded-pill text-center px-4 text-uppercase comment-btn trans-200"><?php 
                      comment_reply_link( 
                          array_merge( 
                              $args, 
                              array( 
                                  'add_below' => $add_below, 
                                  'depth'     => $depth, 
                                  'max_depth' => $args['max_depth'] 
                              ) 
                          ) 
                      ); ?>
               		</div><!-- reply -->
        			</div><!-- comment author, vcard -->
        <div class="mt-3"><?php comment_text(); ?></div>
          <?php 
         if ( 'div' != $args['style'] ) : ?>
             </div><?php 
         endif;
}

//filter by post type
function filter_cars_by_taxonomies( $post_type, $which ) {
	// Apply this only on a specific post type
	if ( 'car' !== $post_type )
		return;
	// A list of taxonomy slugs to filter by
	$taxonomies = array( 'manufacturer', 'model', 'transmission', 'doors', 'color' );
	foreach ( $taxonomies as $taxonomy_slug ) {
		// Retrieve taxonomy data
		$taxonomy_obj = get_taxonomy( $taxonomy_slug );
		$taxonomy_name = $taxonomy_obj->labels->name;
		// Retrieve taxonomy terms
		$terms = get_terms( $taxonomy_slug );
		// Display filter HTML
		echo "<select name='{$taxonomy_slug}' id='{$taxonomy_slug}' class='postform'>";
		echo '<option value="">' . sprintf( esc_html__( 'Show All %s', 'text_domain' ), $taxonomy_name ) . '</option>';
		foreach ( $terms as $term ) {
			printf(
				'<option value="%1$s" %2$s>%3$s (%4$s)</option>',
				$term->slug,
				( ( isset( $_GET[$taxonomy_slug] ) && ( $_GET[$taxonomy_slug] == $term->slug ) ) ? ' selected="selected"' : '' ),
				$term->name,
				$term->count
			);
		}
		echo '</select>';
	}
}
add_action( 'restrict_manage_posts', 'filter_cars_by_taxonomies' , 10, 2);

//validate contact form
add_filter( 'wpcf7_validate_email*', 'custom_email_confirmation_validation_filter', 20, 2 ); 
function custom_email_confirmation_validation_filter( $result, $tag ) {
    if ( 'your-email-confirm' == $tag->name ) {
        $your_email = isset( $_POST['your-email'] ) ? trim( $_POST['your-email'] ) : '';
        $your_email_confirm = isset( $_POST['your-email-confirm'] ) ? trim( $_POST['your-email-confirm'] ) : ''; 
				if ( $tag->is_required() && empty($your_email_confirm) ) {
        $result->invalidate( $tag, "Confirm email could not be blank. " );
				}
        if ( $your_email != $your_email_confirm ) {
            $result->invalidate( $tag, "Are you sure this is the correct address?" );
        }
    } 
    return $result;
}

add_filter( 'wpcf7_validate_text', 'custom_text_confirmation_validation_filter', 20, 2 ); 
function custom_text_confirmation_validation_filter( $result, $tag ) {
    if ( 'yourContactName' == $tag->name ) {
        $myname = isset( $_POST['yourContactName'] ) ? trim( $_POST['yourContactName'] ) : '';
       if (empty($myname)){
            $result->invalidate( $tag, "Name should not be blank, please enter your name. " );
        }
    } 
    return $result;
}

add_filter( 'wpcf7_validate_textarea', 'cf7wl_textarea_validation_filter', 10, 2 );
function cf7wl_textarea_validation_filter( $result, $tag ) {
    if ( 'yourContactMessage' == $tag->name ) {
        $mymessage = isset( $_POST['yourContactMessage'] ) ? trim( $_POST['yourContactMessage'] ) : '';
       if (empty($mymessage)){
            $result->invalidate( $tag, "Message should not be blank, please enter your message. " );
        }
    } 
    return $result;
}

add_filter( 'wpcf7_validate_email', 'cf7wl_email_validation_filter', 10, 2 );
function cf7wl_email_validation_filter( $result, $tag ) {
    if ( 'yourContactEmail' == $tag->name ) {
        $myemail = isset( $_POST['yourContactEmail'] ) ? trim( $_POST['yourContactEmail'] ) : '';
       if (empty($myemail)){
            $result->invalidate( $tag, "Email should not be blank, please enter your email. " );
        }
    } 
    return $result;
}

add_filter( 'wpcf7_validate_text', 'custom_text_validation_filter', 20, 2 );
function custom_text_validation_filter( $result, $tag ) {
    if ( 'yourContactName' == $tag->name ) {
        // matches any utf words with the first not starting with a number
        $re = '/^[^\p{N}][\p{L}]*/i';
        if (!preg_match($re, $_POST['yourContactName'], $matches)) {
            $result->invalidate($tag, "Name should not begin with a number, please enter a valid name!" );
        }
    }
		return $result;
}

add_filter( 'wpcf7_validate_text*', 'cf7_custom_username_required_validation_message', 1, 2 );
function cf7_custom_username_required_validation_message( $result, $tag ) {
    $name = $tag->name;
    $value = isset( $_POST[$name] ) ? trim( wp_unslash( (string) $_POST[$name] ) ) : '';
    if ( $tag->is_required() && empty( $value ) ) {
        if ( preg_match( "/^\*\s(.+)/i", $tag->labels[0], $label_text ) ) {
            $result['valid'] = false;
            $result['reason'] = array( $name => sprintf( __( "%s is defintley required!", 'text-domain' ), $label_text[1] ) );
        }
    }
    return $result;
}

function cf7_add_custom_class($error) {
$error=str_replace("class=\"","class=\"error ", $error);
return $error;
}
add_filter('wpcf7_validation_error', 'cf7_add_custom_class');

/* comment form validation on the same page */
function registration_validation_init() {
?>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/jquery.validate.js"></script>
<script type="text/javascript">
jQuery.validator.addMethod("usernameExt", function(value, element, param) {
    return value.match(/^[a-zA-Z][0-9a-zA-Z]+$/);
},'Username should not begin with a number, please re-enter.');	
jQuery.validator.addMethod("noSpace", function(value, element) { 
  return value.indexOf(" ") < 0 && value != ""; 
}, "Username should not have space, please re-enter.");
jQuery(document).ready(function($) {	
 $('#registration').validate({ 
    // onfocusout: function(element) {
    //   this.element(element);
// },
rules: {
  username: {
    required: true,
    minlength: 1,
		noSpace: true,
		usernameExt: true,		
    normalizer: function(value) { return $.trim(value); }
  }, 
  txtEmail: {
    required: true,
	  email: true        
  }, 
  txtPassword: {
    required: true,
    minlength: 10,
    normalizer: function(value) { return $.trim(value); }
  },
	txtConfPassword: {
    required: true,
    minlength: 10,
		equalTo: "#txtPassword",
    normalizer: function(value) { return $.trim(value); }
  }
}, 
messages: {
  username: {
		required: "Name should not be blank, please enter your name.",
		usernameExt: "Username should be at least 2 characters and should not begin with a number, please re-enter.",
		noSpace: "Username should not have space, please re-enter."
	},
  txtEmail: {
	 required: "Email should not be blank, please enter an email address.", 
	 email: "Email is not valid, please enter a valid email address."
	},
  txtPassword: {
	 required: "Password should not be blank, please enter your password.", 
	 minlength: "Password should be at least 10 characters long."
	},
	txtConfPassword: {
	 required: "Confirm Password should not be blank, please enter your confirm password.", 
	 minlength: "Confirm Password should be at least 10 characters long.",
	 equalTo: "Passwords do not match, please enter the same password. "
	}
}, 
errorElement: "div",
errorPlacement: function(error, element) {
  element.after(error);
} 
});
})
</script>
<?php
}
add_action('wp_footer', 'registration_validation_init');


?>