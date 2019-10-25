<?php
function my_login_logo_url() {
    return home_url();
}
add_filter( 'login_headerurl', 'my_login_logo_url' );
function my_login_logo_url_title() {
    return 'Blog';
}
add_filter( 'login_headertext', 'my_login_logo_url_title' );
function custom_login_error_message() {
	return 'Please enter valid login credentials including email address.';
}
add_filter('login_errors', 'custom_login_error_message');
//cutomer footer
add_action( 'login_footer', 'your_custom_footer' );
function your_custom_footer() {
    // Add your content here
//    echo "<div class='text-white font-weight-bold text-center'><p>Reset Password.</p></div>";
}
//add lost password form in login form
add_action( 'login_form_middle', 'add_lost_password_link' );
function add_lost_password_link() {
	return '<div class="text-center"><a href="'. wp_lostpassword_url() .'">Lost Password?</a></div>';
}
//add sign up form in login form
add_action( 'login_form_bottom', 'add_user_signup_link' );
function add_user_signup_link() {
	return '<div class="pb-2 text-center text-white">Need an new account?<a href="'. wp_registration_url() . '" class="h3 pl-5"> Sign Up </a></div>';
}
//go to home page after login
function admin_login_redirect( $redirect_to, $request, $user ) {
   global $user;   
   if( isset( $user->roles ) && is_array( $user->roles ) ) {
      if( in_array( "administrator", $user->roles ) ) {
      return home_url();
      } 
      else {
      return home_url();
      }
   }
   else {
   return home_url();
   }
}
add_filter("login_redirect", "admin_login_redirect", 10, 3);
//fully customized login redirect - direct to login after entering wp-login
function redirect_login_page() {
  $login_page  = home_url( '/login/' );
  $page_viewed = basename($_SERVER['REQUEST_URI']); 
  if( $page_viewed == "wp-login.php" && $_SERVER['REQUEST_METHOD'] == 'GET') {
    wp_redirect($login_page);
    exit;
  }
}
add_action('init','redirect_login_page');
//if failed, redirct to login page
function login_failed() {
  $login_page  = home_url( '/login/' );
  wp_redirect( $login_page . '?login=failed' );
  exit;
}
add_action( 'wp_login_failed', 'login_failed' );
//if information are wrong, redirect to login page
function verify_username_password( $user, $username, $password ) {
  $login_page  = home_url( '/login/' );
    if( $username == "" || $password == "" ) {
        wp_redirect( $login_page . "?login=empty" );
        exit;
    }
}
add_filter( 'authenticate', 'verify_username_password', 1, 3);
//go to home page after log out
function logout_page() {
  $login_page  = home_url( '/login/' );
	$logout_page = home_url(); 
  wp_redirect( $logout_page . "?login=false" );
  exit;
}
add_action('wp_logout','logout_page');
// modify links in nav menu
function my_log_in_out_menu_link( $items, $args ) {
   // only do this if it's the "secondary" navigation
   if ( $args->theme_location == 'secondary' ) {
      // if the user is logged in, add a log out link
      if ( is_user_logged_in() ) {
         // use the official WP code to get the logout URL.
         // passed-in argument will cause it redirect to home page
         $items .= '<span class="log-out"><a href="'. wp_logout_url( get_permalink() ) .'"><i class="mr-2 fas fa-user-times"></i>'. __("Log Out", "blog" ) .'</a></span>';
      } else {
      // if the user is NOT logged in, add a log in link
         $items .= '<div class="d-flex flex-column flex-md-row"><span class="log-in pr-md-3 border-0 border-md-right"><a href="'. wp_login_url( ) .'"><i class="mr-2 fas fa-user"></i>'. __( "Log In", "blog" ) .'</a></span>';
				 $items .= '<span class="pl-md-3"><a href="'. wp_registration_url( ) . '"><i class="mr-2 fas fa-user-plus"></i>'.__("Sign Up", "blog" ) .'</a></span></div>';
      }
   }
   return $items;
}
add_filter( 'wp_nav_menu_items', 'my_log_in_out_menu_link', 199, 2 );
// Redirect Registration Page
function my_registration_page_redirect() {
	global $pagenow;
	if ( ( strtolower($pagenow) == 'wp-login.php') && ( strtolower( $_GET['action']) == 'register' ) ) {
		$register_page = home_url( '/register/' );
		wp_redirect( $register_page );
	}
}
add_filter( 'init', 'my_registration_page_redirect' );
//login redirect
function login_redirect( $redirect_to, $request, $user ){
    return home_url();
}
add_filter( 'login_redirect', 'login_redirect', 10, 3 );
//send email to website owner on new user registration
function so174837_registration_email_alert( $user_id ) {
    $user    = get_userdata( $user_id );
    $email   = $user->user_email;
    $message = $email . ' has registered to your website  '. home_url(). '.';
    wp_mail( 'catzhang1@hotmail.ca', 'New User registration on Website', $message );
}
add_action('user_register', 'so174837_registration_email_alert');
// change login page logo and submit button color and hover behaviour
function my_login_logo() { ?>
    <style type="text/css">
        .login {
          background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/images/login/login-background.jpg);
          background-size: cover;
          background-repeat: no-repeat;
          background-position: center;  
					background-color: #777;
        }
				div#login {
					padding-top: 6px;
				}
        #login h1 a, .login h1 a {
          background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/images/login/login-image.jpg);
          height:98px;
          width:80px;
          background-size: 80px 98px;
					background-color: #777;
          background-repeat: no-repeat;
					background-position: center;
          padding-bottom: 6px;
          border-radius: 10px;  
					box-shadow: 5px 5px blue, 10px 10px red, 15px 15px green; 
        }
        div#login p#nav a,
        div#login p#backtoblog a {
          font-weight: bold; 
          font-size: 18px;
					color: rgba(0, 0, 0, 0.5); 
        }
				div#login p#nav a:hover,
        div#login p#backtoblog a:hover {
         	color: rgba(0, 0, 0, 1); 
        }
       	div#login form#lostpasswordform, 
				#login_error,
				.message {
          border-radius: 38px;
        }
				div#login form#lostpasswordform {
					background-color: rgba(0, 0, 0, 0.2)
				}
				div#login form#lostpasswordform > p {
					color: #efed40;
				}
				input#user_login {
					border: none;
					background-color: transparent;
					outline: none;
					height: 40px;
					color: #fff!important;
					font-size: 16px;
				}
				form#lostpasswordform input[type="submit"] {
					margin-top: 18px;
					border: none;
					outline: none;
					height: 40px;
					text-shadow: none;
					color: #fff;
					font-size: 16px;
					background-color: #ff267e;
					cursor: pointer;
					border-radius: 20px ;
					display: block;
					width: 100%;
				}
				form#lostpasswordform input[type="submit"]:hover {
					background-color: #efed40;
					color: #262626;
					-webkit-transition: all 200ms ease;
					-moz-transition: all 200ms ease;
					-ms-transition: all 200ms ease;
					-o-transition: all 200ms ease;
					transition: all 200ms ease;
				}       
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'my_login_logo' );

add_action( 'tml_new_user_registered', 'tml_new_user_registered' );
function tml_new_user_registered( $user_id ) {
    wp_set_auth_cookie( $user_id, false, is_ssl() );
//    wp_redirect( 'http://food.cathyzhang.org' );
//    wp_redirect( admin_url( 'profile.php' ) );
    exit;
}

function create_user_from_registration($cfdata) {
    if (!isset($cfdata->posted_data) && class_exists('wpcf7-form')) {
        // Contact Form 7 version 3.9 removed $cfdata->posted_data and now
        // we have to retrieve it from an API
        $submission = wpcf7-form::get_instance();
        if ($submission) {
            $formdata = $submission->get_posted_data();
        }
    } elseif (isset($cfdata->posted_data)) {
        // For pre-3.9 versions of Contact Form 7
        $formdata = $cfdata->posted_data;
    } else {
        // We can't retrieve the form data
        return $cfdata;
    }
    // Check this is the user registration form
    if ( $cfdata->title() == 'Register') {
        $password = wp_generate_password( 12, false );
        $email = $formdata['form-email-field'];
        $name = $formdata['form-name-field'];
        // Construct a username from the user's name
        $username = strtolower(str_replace(' ', '', $name));
        $name_parts = explode(' ',$name);
        if ( !email_exists( $email ) ) {
            // Find an unused username
            $username_tocheck = $username;
            $i = 1;
            while ( username_exists( $username_tocheck ) ) {
                $username_tocheck = $username . $i++;
            }
            $username = $username_tocheck;
            // Create the user
            $userdata = array(
                'user_login' => $username,
                'user_pass' => $password,
                'user_email' => $email,
                'nickname' => reset($name_parts),
                'display_name' => $name,
                'first_name' => reset($name_parts),
                'last_name' => end($name_parts),
                'role' => 'subscriber'
            );
            $user_id = wp_insert_user( $userdata );
            if ( !is_wp_error($user_id) ) {
                // Email login details to user
                $blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
                $message = "Welcome! Your login details are as follows:" . "\r\n";
                $message .= sprintf(__('Username: %s'), $username) . "\r\n";
                $message .= sprintf(__('Password: %s'), $password) . "\r\n";
                $message .= wp_login_url() . "\r\n";
                wp_mail($email, sprintf(__('[%s] Your username and password'), $blogname), $message);
            }
        }
    }
    return $cfdata;
}
add_action('wpcf7_before_send_mail', 'create_user_from_registration', 1);
?>