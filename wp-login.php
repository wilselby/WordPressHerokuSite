<?php
/**
 * WordPress User Page
 *
 * Handles authentication, registering, resetting passwords, forgot password,
 * and other user handling.
 *
 * @package WordPress
 */

/** Make sure that the WordPress bootstrap has run before continuing. */
require( dirname(__FILE__) . '/wp-load.php' );

// Redirect to https login if forced to use SSL
if ( force_ssl_admin() && ! is_ssl() ) {
	if ( 0 === strpos($_SERVER['REQUEST_URI'], 'http') ) {
		wp_redirect( set_url_scheme( $_SERVER['REQUEST_URI'], 'https' ) );
		exit();
	} else {
		wp_redirect( 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] );
		exit();
	}
}

/**
<<<<<<< HEAD
 * Outputs the header for the login page.
 *
 * @uses do_action() Calls the 'login_head' for outputting HTML in the Log In
 *		header.
 * @uses apply_filters() Calls 'login_headerurl' for the top login link.
 * @uses apply_filters() Calls 'login_headertitle' for the top login title.
 * @uses apply_filters() Calls 'login_message' on the message to display in the
 *		header.
 * @uses $error The error global, which is checked for displaying errors.
 *
 * @param string $title Optional. WordPress Log In Page title to display in
 *		<title/> element.
 * @param string $message Optional. Message to display in header.
 * @param WP_Error $wp_error Optional. WordPress Error Object
 */
function login_header($title = 'Log In', $message = '', $wp_error = '') {
	global $error, $interim_login, $current_site, $action;
=======
 * Output the login page header.
 *
 * @param string   $title    Optional. WordPress login Page title to display in the `<title>` element.
 *                           Default 'Log In'.
 * @param string   $message  Optional. Message to display in header. Default empty.
 * @param WP_Error $wp_error Optional. The error to pass. Default empty.
 */
function login_header( $title = 'Log In', $message = '', $wp_error = '' ) {
	global $error, $interim_login, $action;
>>>>>>> WPHome/master

	// Don't index any of these forms
	add_action( 'login_head', 'wp_no_robots' );

<<<<<<< HEAD
=======
	if ( wp_is_mobile() )
		add_action( 'login_head', 'wp_login_viewport_meta' );

>>>>>>> WPHome/master
	if ( empty($wp_error) )
		$wp_error = new WP_Error();

	// Shake it!
	$shake_error_codes = array( 'empty_password', 'empty_email', 'invalid_email', 'invalidcombo', 'empty_username', 'invalid_username', 'incorrect_password' );
<<<<<<< HEAD
=======
	/**
	 * Filter the error codes array for shaking the login form.
	 *
	 * @since 3.0.0
	 *
	 * @param array $shake_error_codes Error codes that shake the login form.
	 */
>>>>>>> WPHome/master
	$shake_error_codes = apply_filters( 'shake_error_codes', $shake_error_codes );

	if ( $shake_error_codes && $wp_error->get_error_code() && in_array( $wp_error->get_error_code(), $shake_error_codes ) )
		add_action( 'login_head', 'wp_shake_js', 12 );

	?><!DOCTYPE html>
<<<<<<< HEAD
	<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
=======
	<!--[if IE 8]>
		<html xmlns="http://www.w3.org/1999/xhtml" class="ie8" <?php language_attributes(); ?>>
	<![endif]-->
	<!--[if !(IE 8) ]><!-->
		<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
	<!--<![endif]-->
>>>>>>> WPHome/master
	<head>
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	<title><?php bloginfo('name'); ?> &rsaquo; <?php echo $title; ?></title>
	<?php

<<<<<<< HEAD
	wp_admin_css( 'wp-admin', true );
	wp_admin_css( 'colors-fresh', true );

	if ( wp_is_mobile() ) { ?>
		<meta name="viewport" content="width=320; initial-scale=0.9; maximum-scale=1.0; user-scalable=0;" /><?php
	}

	do_action( 'login_enqueue_scripts' );
=======
	wp_admin_css( 'login', true );

	/*
	 * Remove all stored post data on logging out.
	 * This could be added by add_action('login_head'...) like wp_shake_js(),
	 * but maybe better if it's not removable by plugins
	 */
	if ( 'loggedout' == $wp_error->get_error_code() ) {
		?>
		<script>if("sessionStorage" in window){try{for(var key in sessionStorage){if(key.indexOf("wp-autosave-")!=-1){sessionStorage.removeItem(key)}}}catch(e){}};</script>
		<?php
	}

	/**
	 * Enqueue scripts and styles for the login page.
	 *
	 * @since 3.1.0
	 */
	do_action( 'login_enqueue_scripts' );
	/**
	 * Fires in the login page header after scripts are enqueued.
	 *
	 * @since 2.1.0
	 */
>>>>>>> WPHome/master
	do_action( 'login_head' );

	if ( is_multisite() ) {
		$login_header_url   = network_home_url();
<<<<<<< HEAD
		$login_header_title = $current_site->site_name;
	} else {
		$login_header_url   = __( 'http://wordpress.org/' );
		$login_header_title = __( 'Powered by WordPress' );
	}

	$login_header_url   = apply_filters( 'login_headerurl',   $login_header_url   );
	$login_header_title = apply_filters( 'login_headertitle', $login_header_title );

	// Don't allow interim logins to navigate away from the page.
	if ( $interim_login )
		$login_header_url = '#';

=======
		$login_header_title = get_current_site()->site_name;
	} else {
		$login_header_url   = __( 'https://wordpress.org/' );
		$login_header_title = __( 'Powered by WordPress' );
	}

	/**
	 * Filter link URL of the header logo above login form.
	 *
	 * @since 2.1.0
	 *
	 * @param string $login_header_url Login header logo URL.
	 */
	$login_header_url = apply_filters( 'login_headerurl', $login_header_url );
	/**
	 * Filter the title attribute of the header logo above login form.
	 *
	 * @since 2.1.0
	 *
	 * @param string $login_header_title Login header logo title attribute.
	 */
	$login_header_title = apply_filters( 'login_headertitle', $login_header_title );

>>>>>>> WPHome/master
	$classes = array( 'login-action-' . $action, 'wp-core-ui' );
	if ( wp_is_mobile() )
		$classes[] = 'mobile';
	if ( is_rtl() )
		$classes[] = 'rtl';
<<<<<<< HEAD
	$classes = apply_filters( 'login_body_class', $classes, $action );
=======
	if ( $interim_login ) {
		$classes[] = 'interim-login';
		?>
		<style type="text/css">html{background-color: transparent;}</style>
		<?php

		if ( 'success' ===  $interim_login )
			$classes[] = 'interim-login-success';
	}
	$classes[] =' locale-' . sanitize_html_class( strtolower( str_replace( '_', '-', get_locale() ) ) );

	/**
	 * Filter the login page body classes.
	 *
	 * @since 3.5.0
	 *
	 * @param array  $classes An array of body classes.
	 * @param string $action  The action that brought the visitor to the login page.
	 */
	$classes = apply_filters( 'login_body_class', $classes, $action );

>>>>>>> WPHome/master
	?>
	</head>
	<body class="login <?php echo esc_attr( implode( ' ', $classes ) ); ?>">
	<div id="login">
<<<<<<< HEAD
		<h1><a href="<?php echo esc_url( $login_header_url ); ?>" title="<?php echo esc_attr( $login_header_title ); ?>"><?php bloginfo( 'name' ); ?></a></h1>
=======
		<h1><a href="<?php echo esc_url( $login_header_url ); ?>" title="<?php echo esc_attr( $login_header_title ); ?>" tabindex="-1"><?php bloginfo( 'name' ); ?></a></h1>
>>>>>>> WPHome/master
	<?php

	unset( $login_header_url, $login_header_title );

<<<<<<< HEAD
	$message = apply_filters('login_message', $message);
=======
	/**
	 * Filter the message to display above the login form.
	 *
	 * @since 2.1.0
	 *
	 * @param string $message Login message text.
	 */
	$message = apply_filters( 'login_message', $message );
>>>>>>> WPHome/master
	if ( !empty( $message ) )
		echo $message . "\n";

	// In case a plugin uses $error rather than the $wp_errors object
	if ( !empty( $error ) ) {
		$wp_error->add('error', $error);
		unset($error);
	}

	if ( $wp_error->get_error_code() ) {
		$errors = '';
		$messages = '';
		foreach ( $wp_error->get_error_codes() as $code ) {
<<<<<<< HEAD
			$severity = $wp_error->get_error_data($code);
			foreach ( $wp_error->get_error_messages($code) as $error ) {
				if ( 'message' == $severity )
					$messages .= '	' . $error . "<br />\n";
				else
					$errors .= '	' . $error . "<br />\n";
			}
		}
		if ( !empty($errors) )
			echo '<div id="login_error">' . apply_filters('login_errors', $errors) . "</div>\n";
		if ( !empty($messages) )
			echo '<p class="message">' . apply_filters('login_messages', $messages) . "</p>\n";
=======
			$severity = $wp_error->get_error_data( $code );
			foreach ( $wp_error->get_error_messages( $code ) as $error_message ) {
				if ( 'message' == $severity )
					$messages .= '	' . $error_message . "<br />\n";
				else
					$errors .= '	' . $error_message . "<br />\n";
			}
		}
		if ( ! empty( $errors ) ) {
			/**
			 * Filter the error messages displayed above the login form.
			 *
			 * @since 2.1.0
			 *
			 * @param string $errors Login error message.
			 */
			echo '<div id="login_error">' . apply_filters( 'login_errors', $errors ) . "</div>\n";
		}
		if ( ! empty( $messages ) ) {
			/**
			 * Filter instructional messages displayed above the login form.
			 *
			 * @since 2.5.0
			 *
			 * @param string $messages Login messages.
			 */
			echo '<p class="message">' . apply_filters( 'login_messages', $messages ) . "</p>\n";
		}
>>>>>>> WPHome/master
	}
} // End of login_header()

/**
 * Outputs the footer for the login page.
 *
 * @param string $input_id Which input to auto-focus
 */
function login_footer($input_id = '') {
	global $interim_login;

	// Don't allow interim logins to navigate away from the page.
	if ( ! $interim_login ): ?>
	<p id="backtoblog"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php esc_attr_e( 'Are you lost?' ); ?>"><?php printf( __( '&larr; Back to %s' ), get_bloginfo( 'title', 'display' ) ); ?></a></p>
	<?php endif; ?>

	</div>

	<?php if ( !empty($input_id) ) : ?>
	<script type="text/javascript">
	try{document.getElementById('<?php echo $input_id; ?>').focus();}catch(e){}
	if(typeof wpOnload=='function')wpOnload();
	</script>
	<?php endif; ?>

<<<<<<< HEAD
	<?php do_action('login_footer'); ?>
=======
	<?php
	/**
	 * Fires in the login page footer.
	 *
	 * @since 3.1.0
	 */
	do_action( 'login_footer' ); ?>
>>>>>>> WPHome/master
	<div class="clear"></div>
	</body>
	</html>
	<?php
}

function wp_shake_js() {
	if ( wp_is_mobile() )
		return;
?>
<script type="text/javascript">
addLoadEvent = function(func){if(typeof jQuery!="undefined")jQuery(document).ready(func);else if(typeof wpOnload!='function'){wpOnload=func;}else{var oldonload=wpOnload;wpOnload=function(){oldonload();func();}}};
function s(id,pos){g(id).left=pos+'px';}
function g(id){return document.getElementById(id).style;}
function shake(id,a,d){c=a.shift();s(id,c);if(a.length>0){setTimeout(function(){shake(id,a,d);},d);}else{try{g(id).position='static';wp_attempt_focus();}catch(e){}}}
addLoadEvent(function(){ var p=new Array(15,30,15,0,-15,-30,-15,0);p=p.concat(p.concat(p));var i=document.forms[0].id;g(i).position='relative';shake(i,p,20);});
</script>
<?php
}

<<<<<<< HEAD
/**
 * Handles sending password retrieval email to user.
 *
 * @uses $wpdb WordPress Database object
=======
function wp_login_viewport_meta() {
	?>
	<meta name="viewport" content="width=device-width" />
	<?php
}

/**
 * Handles sending password retrieval email to user.
 *
 * @global wpdb         $wpdb      WordPress database abstraction object.
 * @global PasswordHash $wp_hasher Portable PHP password hashing framework.
>>>>>>> WPHome/master
 *
 * @return bool|WP_Error True: when finish. WP_Error on error
 */
function retrieve_password() {
<<<<<<< HEAD
	global $wpdb, $current_site;
=======
	global $wpdb, $wp_hasher;
>>>>>>> WPHome/master

	$errors = new WP_Error();

	if ( empty( $_POST['user_login'] ) ) {
		$errors->add('empty_username', __('<strong>ERROR</strong>: Enter a username or e-mail address.'));
<<<<<<< HEAD
	} else if ( strpos( $_POST['user_login'], '@' ) ) {
=======
	} elseif ( strpos( $_POST['user_login'], '@' ) ) {
>>>>>>> WPHome/master
		$user_data = get_user_by( 'email', trim( $_POST['user_login'] ) );
		if ( empty( $user_data ) )
			$errors->add('invalid_email', __('<strong>ERROR</strong>: There is no user registered with that email address.'));
	} else {
		$login = trim($_POST['user_login']);
		$user_data = get_user_by('login', $login);
	}

<<<<<<< HEAD
	do_action('lostpassword_post');
=======
	/**
	 * Fires before errors are returned from a password reset request.
	 *
	 * @since 2.1.0
	 */
	do_action( 'lostpassword_post' );
>>>>>>> WPHome/master

	if ( $errors->get_error_code() )
		return $errors;

	if ( !$user_data ) {
		$errors->add('invalidcombo', __('<strong>ERROR</strong>: Invalid username or e-mail.'));
		return $errors;
	}

<<<<<<< HEAD
	// redefining user_login ensures we return the right case in the email
	$user_login = $user_data->user_login;
	$user_email = $user_data->user_email;

	do_action('retreive_password', $user_login);  // Misspelled and deprecated
	do_action('retrieve_password', $user_login);

	$allow = apply_filters('allow_password_reset', true, $user_data->ID);

	if ( ! $allow )
		return new WP_Error('no_password_reset', __('Password reset is not allowed for this user'));
	else if ( is_wp_error($allow) )
		return $allow;

	$key = $wpdb->get_var($wpdb->prepare("SELECT user_activation_key FROM $wpdb->users WHERE user_login = %s", $user_login));
	if ( empty($key) ) {
		// Generate something random for a key...
		$key = wp_generate_password(20, false);
		do_action('retrieve_password_key', $user_login, $key);
		// Now insert the new md5 key into the db
		$wpdb->update($wpdb->users, array('user_activation_key' => $key), array('user_login' => $user_login));
	}
=======
	// Redefining user_login ensures we return the right case in the email.
	$user_login = $user_data->user_login;
	$user_email = $user_data->user_email;

	/**
	 * Fires before a new password is retrieved.
	 *
	 * @since 1.5.0
	 * @deprecated 1.5.1 Misspelled. Use 'retrieve_password' hook instead.
	 *
	 * @param string $user_login The user login name.
	 */
	do_action( 'retreive_password', $user_login );

	/**
	 * Fires before a new password is retrieved.
	 *
	 * @since 1.5.1
	 *
	 * @param string $user_login The user login name.
	 */
	do_action( 'retrieve_password', $user_login );

	/**
	 * Filter whether to allow a password to be reset.
	 *
	 * @since 2.7.0
	 *
	 * @param bool true           Whether to allow the password to be reset. Default true.
	 * @param int  $user_data->ID The ID of the user attempting to reset a password.
	 */
	$allow = apply_filters( 'allow_password_reset', true, $user_data->ID );

	if ( ! $allow ) {
		return new WP_Error( 'no_password_reset', __('Password reset is not allowed for this user') );
	} elseif ( is_wp_error( $allow ) ) {
		return $allow;
	}

	// Generate something random for a password reset key.
	$key = wp_generate_password( 20, false );

	/**
	 * Fires when a password reset key is generated.
	 *
	 * @since 2.5.0
	 *
	 * @param string $user_login The username for the user.
	 * @param string $key        The generated password reset key.
	 */
	do_action( 'retrieve_password_key', $user_login, $key );

	// Now insert the key, hashed, into the DB.
	if ( empty( $wp_hasher ) ) {
		require_once ABSPATH . WPINC . '/class-phpass.php';
		$wp_hasher = new PasswordHash( 8, true );
	}
	$hashed = $wp_hasher->HashPassword( $key );
	$wpdb->update( $wpdb->users, array( 'user_activation_key' => $hashed ), array( 'user_login' => $user_login ) );

>>>>>>> WPHome/master
	$message = __('Someone requested that the password be reset for the following account:') . "\r\n\r\n";
	$message .= network_home_url( '/' ) . "\r\n\r\n";
	$message .= sprintf(__('Username: %s'), $user_login) . "\r\n\r\n";
	$message .= __('If this was a mistake, just ignore this email and nothing will happen.') . "\r\n\r\n";
	$message .= __('To reset your password, visit the following address:') . "\r\n\r\n";
	$message .= '<' . network_site_url("wp-login.php?action=rp&key=$key&login=" . rawurlencode($user_login), 'login') . ">\r\n";

	if ( is_multisite() )
		$blogname = $GLOBALS['current_site']->site_name;
	else
<<<<<<< HEAD
		// The blogname option is escaped with esc_html on the way into the database in sanitize_option
		// we want to reverse this for the plain text arena of emails.
=======
		/*
		 * The blogname option is escaped with esc_html on the way into the database
		 * in sanitize_option we want to reverse this for the plain text arena of emails.
		 */
>>>>>>> WPHome/master
		$blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);

	$title = sprintf( __('[%s] Password Reset'), $blogname );

<<<<<<< HEAD
	$title = apply_filters('retrieve_password_title', $title);
	$message = apply_filters('retrieve_password_message', $message, $key);

	if ( $message && !wp_mail($user_email, $title, $message) )
		wp_die( __('The e-mail could not be sent.') . "<br />\n" . __('Possible reason: your host may have disabled the mail() function...') );
=======
	/**
	 * Filter the subject of the password reset email.
	 *
	 * @since 2.8.0
	 *
	 * @param string $title Default email title.
	 */
	$title = apply_filters( 'retrieve_password_title', $title );

	/**
	 * Filter the message body of the password reset mail.
	 *
	 * @since 2.8.0
	 * @since 4.1.0 Added `$user_login` and `$user_data` parameters.
	 *
	 * @param string  $message    Default mail message.
	 * @param string  $key        The activation key.
	 * @param string  $user_login The username for the user.
	 * @param WP_User $user_data  WP_User object.
	 */
	$message = apply_filters( 'retrieve_password_message', $message, $key, $user_login, $user_data );

	if ( $message && !wp_mail( $user_email, wp_specialchars_decode( $title ), $message ) )
		wp_die( __('The e-mail could not be sent.') . "<br />\n" . __('Possible reason: your host may have disabled the mail() function.') );
>>>>>>> WPHome/master

	return true;
}

<<<<<<< HEAD
/**
 * Retrieves a user row based on password reset key and login
 *
 * @uses $wpdb WordPress Database object
 *
 * @param string $key Hash to validate sending user's password
 * @param string $login The user login
 * @return object|WP_Error User's database row on success, error object for invalid keys
 */
function check_password_reset_key($key, $login) {
	global $wpdb;

	$key = preg_replace('/[^a-z0-9]/i', '', $key);

	if ( empty( $key ) || !is_string( $key ) )
		return new WP_Error('invalid_key', __('Invalid key'));

	if ( empty($login) || !is_string($login) )
		return new WP_Error('invalid_key', __('Invalid key'));

	$user = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->users WHERE user_activation_key = %s AND user_login = %s", $key, $login));

	if ( empty( $user ) )
		return new WP_Error('invalid_key', __('Invalid key'));

	return $user;
}

/**
 * Handles resetting the user's password.
 *
 * @param object $user The user
 * @param string $new_pass New password for the user in plaintext
 */
function reset_password($user, $new_pass) {
	do_action('password_reset', $user, $new_pass);

	wp_set_password($new_pass, $user->ID);

	wp_password_change_notification($user);
}

/**
 * Handles registering a new user.
 *
 * @param string $user_login User's username for logging in
 * @param string $user_email User's email address to send password and add
 * @return int|WP_Error Either user's ID or error on failure.
 */
function register_new_user( $user_login, $user_email ) {
	$errors = new WP_Error();

	$sanitized_user_login = sanitize_user( $user_login );
	$user_email = apply_filters( 'user_registration_email', $user_email );

	// Check the username
	if ( $sanitized_user_login == '' ) {
		$errors->add( 'empty_username', __( '<strong>ERROR</strong>: Please enter a username.' ) );
	} elseif ( ! validate_username( $user_login ) ) {
		$errors->add( 'invalid_username', __( '<strong>ERROR</strong>: This username is invalid because it uses illegal characters. Please enter a valid username.' ) );
		$sanitized_user_login = '';
	} elseif ( username_exists( $sanitized_user_login ) ) {
		$errors->add( 'username_exists', __( '<strong>ERROR</strong>: This username is already registered. Please choose another one.' ) );
	}

	// Check the e-mail address
	if ( $user_email == '' ) {
		$errors->add( 'empty_email', __( '<strong>ERROR</strong>: Please type your e-mail address.' ) );
	} elseif ( ! is_email( $user_email ) ) {
		$errors->add( 'invalid_email', __( '<strong>ERROR</strong>: The email address isn&#8217;t correct.' ) );
		$user_email = '';
	} elseif ( email_exists( $user_email ) ) {
		$errors->add( 'email_exists', __( '<strong>ERROR</strong>: This email is already registered, please choose another one.' ) );
	}

	do_action( 'register_post', $sanitized_user_login, $user_email, $errors );

	$errors = apply_filters( 'registration_errors', $errors, $sanitized_user_login, $user_email );

	if ( $errors->get_error_code() )
		return $errors;

	$user_pass = wp_generate_password( 12, false);
	$user_id = wp_create_user( $sanitized_user_login, $user_pass, $user_email );
	if ( ! $user_id ) {
		$errors->add( 'registerfail', sprintf( __( '<strong>ERROR</strong>: Couldn&#8217;t register you... please contact the <a href="mailto:%s">webmaster</a> !' ), get_option( 'admin_email' ) ) );
		return $errors;
	}

	update_user_option( $user_id, 'default_password_nag', true, true ); //Set up the Password change nag.

	wp_new_user_notification( $user_id, $user_pass );

	return $user_id;
}

=======
>>>>>>> WPHome/master
//
// Main
//

$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'login';
$errors = new WP_Error();

if ( isset($_GET['key']) )
	$action = 'resetpass';

// validate action so as to default to the login screen
if ( !in_array( $action, array( 'postpass', 'logout', 'lostpassword', 'retrievepassword', 'resetpass', 'rp', 'register', 'login' ), true ) && false === has_filter( 'login_form_' . $action ) )
	$action = 'login';

nocache_headers();

header('Content-Type: '.get_bloginfo('html_type').'; charset='.get_bloginfo('charset'));

if ( defined( 'RELOCATE' ) && RELOCATE ) { // Move flag is set
	if ( isset( $_SERVER['PATH_INFO'] ) && ($_SERVER['PATH_INFO'] != $_SERVER['PHP_SELF']) )
		$_SERVER['PHP_SELF'] = str_replace( $_SERVER['PATH_INFO'], '', $_SERVER['PHP_SELF'] );

	$url = dirname( set_url_scheme( 'http://' .  $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] ) );
	if ( $url != get_option( 'siteurl' ) )
		update_option( 'siteurl', $url );
}

//Set a cookie now to see if they are supported by the browser.
<<<<<<< HEAD
setcookie(TEST_COOKIE, 'WP Cookie check', 0, COOKIEPATH, COOKIE_DOMAIN);
if ( SITECOOKIEPATH != COOKIEPATH )
	setcookie(TEST_COOKIE, 'WP Cookie check', 0, SITECOOKIEPATH, COOKIE_DOMAIN);

// allow plugins to override the default actions, and to add extra actions if they want
do_action( 'login_init' );
do_action( 'login_form_' . $action );

$http_post = ('POST' == $_SERVER['REQUEST_METHOD']);
switch ($action) {

case 'postpass' :
	if ( empty( $wp_hasher ) ) {
		require_once( ABSPATH . 'wp-includes/class-phpass.php' );
		// By default, use the portable hash from phpass
		$wp_hasher = new PasswordHash(8, true);
	}

	// 10 days
	setcookie( 'wp-postpass_' . COOKIEHASH, $wp_hasher->HashPassword( stripslashes( $_POST['post_password'] ) ), time() + 10 * DAY_IN_SECONDS, COOKIEPATH );
=======
$secure = ( 'https' === parse_url( site_url(), PHP_URL_SCHEME ) && 'https' === parse_url( home_url(), PHP_URL_SCHEME ) );
setcookie( TEST_COOKIE, 'WP Cookie check', 0, COOKIEPATH, COOKIE_DOMAIN, $secure );
if ( SITECOOKIEPATH != COOKIEPATH )
	setcookie( TEST_COOKIE, 'WP Cookie check', 0, SITECOOKIEPATH, COOKIE_DOMAIN, $secure );

/**
 * Fires when the login form is initialized.
 *
 * @since 3.2.0
 */
do_action( 'login_init' );
/**
 * Fires before a specified login form action.
 *
 * The dynamic portion of the hook name, `$action`, refers to the action
 * that brought the visitor to the login form. Actions include 'postpass',
 * 'logout', 'lostpassword', etc.
 *
 * @since 2.8.0
 */
do_action( 'login_form_' . $action );

$http_post = ('POST' == $_SERVER['REQUEST_METHOD']);
$interim_login = isset($_REQUEST['interim-login']);

switch ($action) {

case 'postpass' :
	require_once ABSPATH . WPINC . '/class-phpass.php';
	$hasher = new PasswordHash( 8, true );

	/**
	 * Filter the life span of the post password cookie.
	 *
	 * By default, the cookie expires 10 days from creation. To turn this
	 * into a session cookie, return 0.
	 *
	 * @since 3.7.0
	 *
	 * @param int $expires The expiry time, as passed to setcookie().
	 */
	$expire = apply_filters( 'post_password_expires', time() + 10 * DAY_IN_SECONDS );
	$secure = ( 'https' === parse_url( home_url(), PHP_URL_SCHEME ) );
	setcookie( 'wp-postpass_' . COOKIEHASH, $hasher->HashPassword( wp_unslash( $_POST['post_password'] ) ), $expire, COOKIEPATH, COOKIE_DOMAIN, $secure );
>>>>>>> WPHome/master

	wp_safe_redirect( wp_get_referer() );
	exit();

<<<<<<< HEAD
break;

case 'logout' :
	check_admin_referer('log-out');
	wp_logout();

	$redirect_to = !empty( $_REQUEST['redirect_to'] ) ? $_REQUEST['redirect_to'] : 'wp-login.php?loggedout=true';
	wp_safe_redirect( $redirect_to );
	exit();

break;

=======
case 'logout' :
	check_admin_referer('log-out');

	$user = wp_get_current_user();

	wp_logout();

	if ( ! empty( $_REQUEST['redirect_to'] ) ) {
		$redirect_to = $requested_redirect_to = $_REQUEST['redirect_to'];
	} else {
		$redirect_to = 'wp-login.php?loggedout=true';
		$requested_redirect_to = '';
	}

	/**
	 * Filter the log out redirect URL.
	 *
	 * @since 4.2.0
	 *
	 * @param string  $redirect_to           The redirect destination URL.
	 * @param string  $requested_redirect_to The requested redirect destination URL passed as a parameter.
	 * @param WP_User $user                  The WP_User object for the user that's logging out.
	 */
	$redirect_to = apply_filters( 'logout_redirect', $redirect_to, $requested_redirect_to, $user );
	wp_safe_redirect( $redirect_to );
	exit();

>>>>>>> WPHome/master
case 'lostpassword' :
case 'retrievepassword' :

	if ( $http_post ) {
		$errors = retrieve_password();
		if ( !is_wp_error($errors) ) {
			$redirect_to = !empty( $_REQUEST['redirect_to'] ) ? $_REQUEST['redirect_to'] : 'wp-login.php?checkemail=confirm';
			wp_safe_redirect( $redirect_to );
			exit();
		}
	}

<<<<<<< HEAD
	if ( isset($_GET['error']) && 'invalidkey' == $_GET['error'] ) $errors->add('invalidkey', __('Sorry, that key does not appear to be valid.'));
	$redirect_to = apply_filters( 'lostpassword_redirect', !empty( $_REQUEST['redirect_to'] ) ? $_REQUEST['redirect_to'] : '' );

	do_action('lost_password');
	login_header(__('Lost Password'), '<p class="message">' . __('Please enter your username or email address. You will receive a link to create a new password via email.') . '</p>', $errors);

	$user_login = isset($_POST['user_login']) ? stripslashes($_POST['user_login']) : '';

?>

<form name="lostpasswordform" id="lostpasswordform" action="<?php echo esc_url( site_url( 'wp-login.php?action=lostpassword', 'login_post' ) ); ?>" method="post">
=======
	if ( isset( $_GET['error'] ) ) {
		if ( 'invalidkey' == $_GET['error'] )
			$errors->add( 'invalidkey', __( 'Sorry, that key does not appear to be valid.' ) );
		elseif ( 'expiredkey' == $_GET['error'] )
			$errors->add( 'expiredkey', __( 'Sorry, that key has expired. Please try again.' ) );
	}

	$lostpassword_redirect = ! empty( $_REQUEST['redirect_to'] ) ? $_REQUEST['redirect_to'] : '';
	/**
	 * Filter the URL redirected to after submitting the lostpassword/retrievepassword form.
	 *
	 * @since 3.0.0
	 *
	 * @param string $lostpassword_redirect The redirect destination URL.
	 */
	$redirect_to = apply_filters( 'lostpassword_redirect', $lostpassword_redirect );

	/**
	 * Fires before the lost password form.
	 *
	 * @since 1.5.1
	 */
	do_action( 'lost_password' );

	login_header(__('Lost Password'), '<p class="message">' . __('Please enter your username or email address. You will receive a link to create a new password via email.') . '</p>', $errors);

	$user_login = isset($_POST['user_login']) ? wp_unslash($_POST['user_login']) : '';

?>

<form name="lostpasswordform" id="lostpasswordform" action="<?php echo esc_url( network_site_url( 'wp-login.php?action=lostpassword', 'login_post' ) ); ?>" method="post">
>>>>>>> WPHome/master
	<p>
		<label for="user_login" ><?php _e('Username or E-mail:') ?><br />
		<input type="text" name="user_login" id="user_login" class="input" value="<?php echo esc_attr($user_login); ?>" size="20" /></label>
	</p>
<<<<<<< HEAD
<?php do_action('lostpassword_form'); ?>
=======
	<?php
	/**
	 * Fires inside the lostpassword form tags, before the hidden fields.
	 *
	 * @since 2.1.0
	 */
	do_action( 'lostpassword_form' ); ?>
>>>>>>> WPHome/master
	<input type="hidden" name="redirect_to" value="<?php echo esc_attr( $redirect_to ); ?>" />
	<p class="submit"><input type="submit" name="wp-submit" id="wp-submit" class="button button-primary button-large" value="<?php esc_attr_e('Get New Password'); ?>" /></p>
</form>

<p id="nav">
<a href="<?php echo esc_url( wp_login_url() ); ?>"><?php _e('Log in') ?></a>
<<<<<<< HEAD
<?php if ( get_option( 'users_can_register' ) ) : ?>
 | <a href="<?php echo esc_url( site_url( 'wp-login.php?action=register', 'login' ) ); ?>"><?php _e( 'Register' ); ?></a>
<?php endif; ?>
=======
<?php
if ( get_option( 'users_can_register' ) ) :
	$registration_url = sprintf( '<a href="%s">%s</a>', esc_url( wp_registration_url() ), __( 'Register' ) );

	/** This filter is documented in wp-includes/general-template.php */
	echo ' | ' . apply_filters( 'register', $registration_url );
endif;
?>
>>>>>>> WPHome/master
</p>

<?php
login_footer('user_login');
break;

case 'resetpass' :
case 'rp' :
<<<<<<< HEAD
	$user = check_password_reset_key($_GET['key'], $_GET['login']);

	if ( is_wp_error($user) ) {
		wp_redirect( site_url('wp-login.php?action=lostpassword&error=invalidkey') );
=======
	list( $rp_path ) = explode( '?', wp_unslash( $_SERVER['REQUEST_URI'] ) );
	$rp_cookie = 'wp-resetpass-' . COOKIEHASH;
	if ( isset( $_GET['key'] ) ) {
		$value = sprintf( '%s:%s', wp_unslash( $_GET['login'] ), wp_unslash( $_GET['key'] ) );
		setcookie( $rp_cookie, $value, 0, $rp_path, COOKIE_DOMAIN, is_ssl(), true );
		wp_safe_redirect( remove_query_arg( array( 'key', 'login' ) ) );
		exit;
	}

	if ( isset( $_COOKIE[ $rp_cookie ] ) && 0 < strpos( $_COOKIE[ $rp_cookie ], ':' ) ) {
		list( $rp_login, $rp_key ) = explode( ':', wp_unslash( $_COOKIE[ $rp_cookie ] ), 2 );
		$user = check_password_reset_key( $rp_key, $rp_login );
		if ( isset( $_POST['pass1'] ) && ! hash_equals( $rp_key, $_POST['rp_key'] ) ) {
			$user = false;
		}
	} else {
		$user = false;
	}

	if ( ! $user || is_wp_error( $user ) ) {
		setcookie( $rp_cookie, ' ', time() - YEAR_IN_SECONDS, $rp_path, COOKIE_DOMAIN, is_ssl(), true );
		if ( $user && $user->get_error_code() === 'expired_key' )
			wp_redirect( site_url( 'wp-login.php?action=lostpassword&error=expiredkey' ) );
		else
			wp_redirect( site_url( 'wp-login.php?action=lostpassword&error=invalidkey' ) );
>>>>>>> WPHome/master
		exit;
	}

	$errors = new WP_Error();

	if ( isset($_POST['pass1']) && $_POST['pass1'] != $_POST['pass2'] )
		$errors->add( 'password_reset_mismatch', __( 'The passwords do not match.' ) );

<<<<<<< HEAD
=======
	/**
	 * Fires before the password reset procedure is validated.
	 *
	 * @since 3.5.0
	 *
	 * @param object           $errors WP Error object.
	 * @param WP_User|WP_Error $user   WP_User object if the login and reset key match. WP_Error object otherwise.
	 */
>>>>>>> WPHome/master
	do_action( 'validate_password_reset', $errors, $user );

	if ( ( ! $errors->get_error_code() ) && isset( $_POST['pass1'] ) && !empty( $_POST['pass1'] ) ) {
		reset_password($user, $_POST['pass1']);
<<<<<<< HEAD
=======
		setcookie( $rp_cookie, ' ', time() - YEAR_IN_SECONDS, $rp_path, COOKIE_DOMAIN, is_ssl(), true );
>>>>>>> WPHome/master
		login_header( __( 'Password Reset' ), '<p class="message reset-pass">' . __( 'Your password has been reset.' ) . ' <a href="' . esc_url( wp_login_url() ) . '">' . __( 'Log in' ) . '</a></p>' );
		login_footer();
		exit;
	}

	wp_enqueue_script('utils');
	wp_enqueue_script('user-profile');

	login_header(__('Reset Password'), '<p class="message reset-pass">' . __('Enter your new password below.') . '</p>', $errors );

?>
<<<<<<< HEAD
<form name="resetpassform" id="resetpassform" action="<?php echo esc_url( site_url( 'wp-login.php?action=resetpass&key=' . urlencode( $_GET['key'] ) . '&login=' . urlencode( $_GET['login'] ), 'login_post' ) ); ?>" method="post">
	<input type="hidden" id="user_login" value="<?php echo esc_attr( $_GET['login'] ); ?>" autocomplete="off" />
=======
<form name="resetpassform" id="resetpassform" action="<?php echo esc_url( network_site_url( 'wp-login.php?action=resetpass', 'login_post' ) ); ?>" method="post" autocomplete="off">
	<input type="hidden" id="user_login" value="<?php echo esc_attr( $rp_login ); ?>" autocomplete="off" />
>>>>>>> WPHome/master

	<p>
		<label for="pass1"><?php _e('New password') ?><br />
		<input type="password" name="pass1" id="pass1" class="input" size="20" value="" autocomplete="off" /></label>
	</p>
	<p>
		<label for="pass2"><?php _e('Confirm new password') ?><br />
		<input type="password" name="pass2" id="pass2" class="input" size="20" value="" autocomplete="off" /></label>
	</p>

	<div id="pass-strength-result" class="hide-if-no-js"><?php _e('Strength indicator'); ?></div>
<<<<<<< HEAD
	<p class="description indicator-hint"><?php _e('Hint: The password should be at least seven characters long. To make it stronger, use upper and lower case letters, numbers and symbols like ! " ? $ % ^ &amp; ).'); ?></p>

	<br class="clear" />
=======
	<p class="description indicator-hint"><?php echo wp_get_password_hint(); ?></p>
	<br class="clear" />

	<?php
	/**
	 * Fires following the 'Strength indicator' meter in the user password reset form.
	 *
	 * @since 3.9.0
	 *
	 * @param WP_User $user User object of the user whose password is being reset.
	 */
	do_action( 'resetpass_form', $user );
	?>
	<input type="hidden" name="rp_key" value="<?php echo esc_attr( $rp_key ); ?>" />
>>>>>>> WPHome/master
	<p class="submit"><input type="submit" name="wp-submit" id="wp-submit" class="button button-primary button-large" value="<?php esc_attr_e('Reset Password'); ?>" /></p>
</form>

<p id="nav">
<a href="<?php echo esc_url( wp_login_url() ); ?>"><?php _e( 'Log in' ); ?></a>
<<<<<<< HEAD
<?php if ( get_option( 'users_can_register' ) ) : ?>
 | <a href="<?php echo esc_url( site_url( 'wp-login.php?action=register', 'login' ) ); ?>"><?php _e( 'Register' ); ?></a>
<?php endif; ?>
=======
<?php
if ( get_option( 'users_can_register' ) ) :
	$registration_url = sprintf( '<a href="%s">%s</a>', esc_url( wp_registration_url() ), __( 'Register' ) );

	/** This filter is documented in wp-includes/general-template.php */
	echo ' | ' . apply_filters( 'register', $registration_url );
endif;
?>
>>>>>>> WPHome/master
</p>

<?php
login_footer('user_pass');
break;

case 'register' :
	if ( is_multisite() ) {
<<<<<<< HEAD
		// Multisite uses wp-signup.php
		wp_redirect( apply_filters( 'wp_signup_location', network_site_url('wp-signup.php') ) );
=======
		/**
		 * Filter the Multisite sign up URL.
		 *
		 * @since 3.0.0
		 *
		 * @param string $sign_up_url The sign up URL.
		 */
		wp_redirect( apply_filters( 'wp_signup_location', network_site_url( 'wp-signup.php' ) ) );
>>>>>>> WPHome/master
		exit;
	}

	if ( !get_option('users_can_register') ) {
		wp_redirect( site_url('wp-login.php?registration=disabled') );
		exit();
	}

	$user_login = '';
	$user_email = '';
	if ( $http_post ) {
		$user_login = $_POST['user_login'];
		$user_email = $_POST['user_email'];
		$errors = register_new_user($user_login, $user_email);
		if ( !is_wp_error($errors) ) {
			$redirect_to = !empty( $_POST['redirect_to'] ) ? $_POST['redirect_to'] : 'wp-login.php?checkemail=registered';
			wp_safe_redirect( $redirect_to );
			exit();
		}
	}

<<<<<<< HEAD
	$redirect_to = apply_filters( 'registration_redirect', !empty( $_REQUEST['redirect_to'] ) ? $_REQUEST['redirect_to'] : '' );
	login_header(__('Registration Form'), '<p class="message register">' . __('Register For This Site') . '</p>', $errors);
?>

<form name="registerform" id="registerform" action="<?php echo esc_url( site_url('wp-login.php?action=register', 'login_post') ); ?>" method="post">
	<p>
		<label for="user_login"><?php _e('Username') ?><br />
		<input type="text" name="user_login" id="user_login" class="input" value="<?php echo esc_attr(stripslashes($user_login)); ?>" size="20" /></label>
	</p>
	<p>
		<label for="user_email"><?php _e('E-mail') ?><br />
		<input type="text" name="user_email" id="user_email" class="input" value="<?php echo esc_attr(stripslashes($user_email)); ?>" size="25" /></label>
	</p>
<?php do_action('register_form'); ?>
=======
	$registration_redirect = ! empty( $_REQUEST['redirect_to'] ) ? $_REQUEST['redirect_to'] : '';
	/**
	 * Filter the registration redirect URL.
	 *
	 * @since 3.0.0
	 *
	 * @param string $registration_redirect The redirect destination URL.
	 */
	$redirect_to = apply_filters( 'registration_redirect', $registration_redirect );
	login_header(__('Registration Form'), '<p class="message register">' . __('Register For This Site') . '</p>', $errors);
?>

<form name="registerform" id="registerform" action="<?php echo esc_url( site_url('wp-login.php?action=register', 'login_post') ); ?>" method="post" novalidate="novalidate">
	<p>
		<label for="user_login"><?php _e('Username') ?><br />
		<input type="text" name="user_login" id="user_login" class="input" value="<?php echo esc_attr(wp_unslash($user_login)); ?>" size="20" /></label>
	</p>
	<p>
		<label for="user_email"><?php _e('E-mail') ?><br />
		<input type="email" name="user_email" id="user_email" class="input" value="<?php echo esc_attr( wp_unslash( $user_email ) ); ?>" size="25" /></label>
	</p>
	<?php
	/**
	 * Fires following the 'E-mail' field in the user registration form.
	 *
	 * @since 2.1.0
	 */
	do_action( 'register_form' );
	?>
>>>>>>> WPHome/master
	<p id="reg_passmail"><?php _e('A password will be e-mailed to you.') ?></p>
	<br class="clear" />
	<input type="hidden" name="redirect_to" value="<?php echo esc_attr( $redirect_to ); ?>" />
	<p class="submit"><input type="submit" name="wp-submit" id="wp-submit" class="button button-primary button-large" value="<?php esc_attr_e('Register'); ?>" /></p>
</form>

<p id="nav">
<a href="<?php echo esc_url( wp_login_url() ); ?>"><?php _e( 'Log in' ); ?></a> |
<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>" title="<?php esc_attr_e( 'Password Lost and Found' ) ?>"><?php _e( 'Lost your password?' ); ?></a>
</p>

<?php
login_footer('user_login');
break;

case 'login' :
default:
	$secure_cookie = '';
<<<<<<< HEAD
	$interim_login = isset($_REQUEST['interim-login']);
=======
>>>>>>> WPHome/master
	$customize_login = isset( $_REQUEST['customize-login'] );
	if ( $customize_login )
		wp_enqueue_script( 'customize-base' );

	// If the user wants ssl but the session is not ssl, force a secure cookie.
	if ( !empty($_POST['log']) && !force_ssl_admin() ) {
		$user_name = sanitize_user($_POST['log']);
		if ( $user = get_user_by('login', $user_name) ) {
			if ( get_user_option('use_ssl', $user->ID) ) {
				$secure_cookie = true;
				force_ssl_admin(true);
			}
		}
	}

	if ( isset( $_REQUEST['redirect_to'] ) ) {
		$redirect_to = $_REQUEST['redirect_to'];
		// Redirect to https if user wants ssl
		if ( $secure_cookie && false !== strpos($redirect_to, 'wp-admin') )
			$redirect_to = preg_replace('|^http://|', 'https://', $redirect_to);
	} else {
		$redirect_to = admin_url();
	}

	$reauth = empty($_REQUEST['reauth']) ? false : true;

<<<<<<< HEAD
	// If the user was redirected to a secure login form from a non-secure admin page, and secure login is required but secure admin is not, then don't use a secure
	// cookie and redirect back to the referring non-secure admin page. This allows logins to always be POSTed over SSL while allowing the user to choose visiting
	// the admin via http or https.
	if ( !$secure_cookie && is_ssl() && force_ssl_login() && !force_ssl_admin() && ( 0 !== strpos($redirect_to, 'https') ) && ( 0 === strpos($redirect_to, 'http') ) )
		$secure_cookie = false;

	$user = wp_signon('', $secure_cookie);

	$redirect_to = apply_filters('login_redirect', $redirect_to, isset( $_REQUEST['redirect_to'] ) ? $_REQUEST['redirect_to'] : '', $user);
=======
	$user = wp_signon( '', $secure_cookie );

	if ( empty( $_COOKIE[ LOGGED_IN_COOKIE ] ) ) {
		if ( headers_sent() ) {
			$user = new WP_Error( 'test_cookie', sprintf( __( '<strong>ERROR</strong>: Cookies are blocked due to unexpected output. For help, please see <a href="%1$s">this documentation</a> or try the <a href="%2$s">support forums</a>.' ),
				__( 'https://codex.wordpress.org/Cookies' ), __( 'https://wordpress.org/support/' ) ) );
		} elseif ( isset( $_POST['testcookie'] ) && empty( $_COOKIE[ TEST_COOKIE ] ) ) {
			// If cookies are disabled we can't log in even with a valid user+pass
			$user = new WP_Error( 'test_cookie', sprintf( __( '<strong>ERROR</strong>: Cookies are blocked or not supported by your browser. You must <a href="%s">enable cookies</a> to use WordPress.' ),
				__( 'https://codex.wordpress.org/Cookies' ) ) );
		}
	}

	$requested_redirect_to = isset( $_REQUEST['redirect_to'] ) ? $_REQUEST['redirect_to'] : '';
	/**
	 * Filter the login redirect URL.
	 *
	 * @since 3.0.0
	 *
	 * @param string           $redirect_to           The redirect destination URL.
	 * @param string           $requested_redirect_to The requested redirect destination URL passed as a parameter.
	 * @param WP_User|WP_Error $user                  WP_User object if login was successful, WP_Error object otherwise.
	 */
	$redirect_to = apply_filters( 'login_redirect', $redirect_to, $requested_redirect_to, $user );
>>>>>>> WPHome/master

	if ( !is_wp_error($user) && !$reauth ) {
		if ( $interim_login ) {
			$message = '<p class="message">' . __('You have logged in successfully.') . '</p>';
<<<<<<< HEAD
			login_header( '', $message ); ?>

			<?php if ( ! $customize_login ) : ?>
			<script type="text/javascript">setTimeout( function(){window.close()}, 8000);</script>
			<p class="alignright">
			<input type="button" class="button-primary" value="<?php esc_attr_e('Close'); ?>" onclick="window.close()" /></p>
			<?php endif; ?>
			</div>
			<?php do_action( 'login_footer' ); ?>
=======
			$interim_login = 'success';
			login_header( '', $message ); ?>
			</div>
			<?php
			/** This action is documented in wp-login.php */
			do_action( 'login_footer' ); ?>
>>>>>>> WPHome/master
			<?php if ( $customize_login ) : ?>
				<script type="text/javascript">setTimeout( function(){ new wp.customize.Messenger({ url: '<?php echo wp_customize_url(); ?>', channel: 'login' }).send('login') }, 1000 );</script>
			<?php endif; ?>
			</body></html>
<?php		exit;
		}

		if ( ( empty( $redirect_to ) || $redirect_to == 'wp-admin/' || $redirect_to == admin_url() ) ) {
			// If the user doesn't belong to a blog, send them to user admin. If the user can't edit posts, send them to their profile.
			if ( is_multisite() && !get_active_blog_for_user($user->ID) && !is_super_admin( $user->ID ) )
				$redirect_to = user_admin_url();
			elseif ( is_multisite() && !$user->has_cap('read') )
				$redirect_to = get_dashboard_url( $user->ID );
			elseif ( !$user->has_cap('edit_posts') )
				$redirect_to = admin_url('profile.php');
		}
		wp_safe_redirect($redirect_to);
		exit();
	}

	$errors = $user;
	// Clear errors if loggedout is set.
	if ( !empty($_GET['loggedout']) || $reauth )
		$errors = new WP_Error();

<<<<<<< HEAD
	// If cookies are disabled we can't log in even with a valid user+pass
	if ( isset($_POST['testcookie']) && empty($_COOKIE[TEST_COOKIE]) )
		$errors->add('test_cookie', __("<strong>ERROR</strong>: Cookies are blocked or not supported by your browser. You must <a href='http://www.google.com/cookies.html'>enable cookies</a> to use WordPress."));

	// Some parts of this script use the main login form to display a message
	if		( isset($_GET['loggedout']) && true == $_GET['loggedout'] )
		$errors->add('loggedout', __('You are now logged out.'), 'message');
	elseif	( isset($_GET['registration']) && 'disabled' == $_GET['registration'] )
		$errors->add('registerdisabled', __('User registration is currently not allowed.'));
	elseif	( isset($_GET['checkemail']) && 'confirm' == $_GET['checkemail'] )
		$errors->add('confirm', __('Check your e-mail for the confirmation link.'), 'message');
	elseif	( isset($_GET['checkemail']) && 'newpass' == $_GET['checkemail'] )
		$errors->add('newpass', __('Check your e-mail for your new password.'), 'message');
	elseif	( isset($_GET['checkemail']) && 'registered' == $_GET['checkemail'] )
		$errors->add('registered', __('Registration complete. Please check your e-mail.'), 'message');
	elseif	( $interim_login )
		$errors->add('expired', __('Your session has expired. Please log-in again.'), 'message');
	elseif ( strpos( $redirect_to, 'about.php?updated' ) )
		$errors->add('updated', __( '<strong>You have successfully updated WordPress!</strong> Please log back in to experience the awesomeness.' ), 'message' );
=======
	if ( $interim_login ) {
		if ( ! $errors->get_error_code() )
			$errors->add('expired', __('Session expired. Please log in again. You will not move away from this page.'), 'message');
	} else {
		// Some parts of this script use the main login form to display a message
		if		( isset($_GET['loggedout']) && true == $_GET['loggedout'] )
			$errors->add('loggedout', __('You are now logged out.'), 'message');
		elseif	( isset($_GET['registration']) && 'disabled' == $_GET['registration'] )
			$errors->add('registerdisabled', __('User registration is currently not allowed.'));
		elseif	( isset($_GET['checkemail']) && 'confirm' == $_GET['checkemail'] )
			$errors->add('confirm', __('Check your e-mail for the confirmation link.'), 'message');
		elseif	( isset($_GET['checkemail']) && 'newpass' == $_GET['checkemail'] )
			$errors->add('newpass', __('Check your e-mail for your new password.'), 'message');
		elseif	( isset($_GET['checkemail']) && 'registered' == $_GET['checkemail'] )
			$errors->add('registered', __('Registration complete. Please check your e-mail.'), 'message');
		elseif ( strpos( $redirect_to, 'about.php?updated' ) )
			$errors->add('updated', __( '<strong>You have successfully updated WordPress!</strong> Please log back in to see what&#8217;s new.' ), 'message' );
	}

	/**
	 * Filter the login page errors.
	 *
	 * @since 3.6.0
	 *
	 * @param object $errors      WP Error object.
	 * @param string $redirect_to Redirect destination URL.
	 */
	$errors = apply_filters( 'wp_login_errors', $errors, $redirect_to );
>>>>>>> WPHome/master

	// Clear any stale cookies.
	if ( $reauth )
		wp_clear_auth_cookie();

	login_header(__('Log In'), '', $errors);

	if ( isset($_POST['log']) )
<<<<<<< HEAD
		$user_login = ( 'incorrect_password' == $errors->get_error_code() || 'empty_password' == $errors->get_error_code() ) ? esc_attr(stripslashes($_POST['log'])) : '';
	$rememberme = ! empty( $_POST['rememberme'] );
=======
		$user_login = ( 'incorrect_password' == $errors->get_error_code() || 'empty_password' == $errors->get_error_code() ) ? esc_attr(wp_unslash($_POST['log'])) : '';
	$rememberme = ! empty( $_POST['rememberme'] );

	if ( ! empty( $errors->errors ) ) {
		$aria_describedby_error = ' aria-describedby="login_error"';
	} else {
		$aria_describedby_error = '';
	}
>>>>>>> WPHome/master
?>

<form name="loginform" id="loginform" action="<?php echo esc_url( site_url( 'wp-login.php', 'login_post' ) ); ?>" method="post">
	<p>
		<label for="user_login"><?php _e('Username') ?><br />
<<<<<<< HEAD
		<input type="text" name="log" id="user_login" class="input" value="<?php echo esc_attr($user_login); ?>" size="20" /></label>
	</p>
	<p>
		<label for="user_pass"><?php _e('Password') ?><br />
		<input type="password" name="pwd" id="user_pass" class="input" value="" size="20" /></label>
	</p>
<?php do_action('login_form'); ?>
=======
		<input type="text" name="log" id="user_login"<?php echo $aria_describedby_error; ?> class="input" value="<?php echo esc_attr( $user_login ); ?>" size="20" /></label>
	</p>
	<p>
		<label for="user_pass"><?php _e('Password') ?><br />
		<input type="password" name="pwd" id="user_pass"<?php echo $aria_describedby_error; ?> class="input" value="" size="20" /></label>
	</p>
	<?php
	/**
	 * Fires following the 'Password' field in the login form.
	 *
	 * @since 2.1.0
	 */
	do_action( 'login_form' );
	?>
>>>>>>> WPHome/master
	<p class="forgetmenot"><label for="rememberme"><input name="rememberme" type="checkbox" id="rememberme" value="forever" <?php checked( $rememberme ); ?> /> <?php esc_attr_e('Remember Me'); ?></label></p>
	<p class="submit">
		<input type="submit" name="wp-submit" id="wp-submit" class="button button-primary button-large" value="<?php esc_attr_e('Log In'); ?>" />
<?php	if ( $interim_login ) { ?>
		<input type="hidden" name="interim-login" value="1" />
<?php	} else { ?>
		<input type="hidden" name="redirect_to" value="<?php echo esc_attr($redirect_to); ?>" />
<?php 	} ?>
<?php   if ( $customize_login ) : ?>
		<input type="hidden" name="customize-login" value="1" />
<?php   endif; ?>
		<input type="hidden" name="testcookie" value="1" />
	</p>
</form>

<<<<<<< HEAD
<?php if ( !$interim_login ) { ?>
<p id="nav">
<?php if ( isset($_GET['checkemail']) && in_array( $_GET['checkemail'], array('confirm', 'newpass') ) ) : ?>
<?php elseif ( get_option('users_can_register') ) : ?>
<a href="<?php echo esc_url( site_url( 'wp-login.php?action=register', 'login' ) ); ?>"><?php _e( 'Register' ); ?></a> |
<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>" title="<?php esc_attr_e( 'Password Lost and Found' ); ?>"><?php _e( 'Lost your password?' ); ?></a>
<?php else : ?>
<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>" title="<?php esc_attr_e( 'Password Lost and Found' ); ?>"><?php _e( 'Lost your password?' ); ?></a>
=======
<?php if ( ! $interim_login ) { ?>
<p id="nav">
<?php if ( ! isset( $_GET['checkemail'] ) || ! in_array( $_GET['checkemail'], array( 'confirm', 'newpass' ) ) ) :
	if ( get_option( 'users_can_register' ) ) :
		$registration_url = sprintf( '<a href="%s">%s</a>', esc_url( wp_registration_url() ), __( 'Register' ) );

		/** This filter is documented in wp-includes/general-template.php */
		echo apply_filters( 'register', $registration_url ) . ' | ';
	endif;
	?>
	<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>" title="<?php esc_attr_e( 'Password Lost and Found' ); ?>"><?php _e( 'Lost your password?' ); ?></a>
>>>>>>> WPHome/master
<?php endif; ?>
</p>
<?php } ?>

<script type="text/javascript">
function wp_attempt_focus(){
setTimeout( function(){ try{
<<<<<<< HEAD
<?php if ( $user_login || $interim_login ) { ?>
=======
<?php if ( $user_login ) { ?>
>>>>>>> WPHome/master
d = document.getElementById('user_pass');
d.value = '';
<?php } else { ?>
d = document.getElementById('user_login');
<?php if ( 'invalid_username' == $errors->get_error_code() ) { ?>
if( d.value != '' )
d.value = '';
<?php
}
}?>
d.focus();
d.select();
} catch(e){}
}, 200);
}

<?php if ( !$error ) { ?>
wp_attempt_focus();
<?php } ?>
if(typeof wpOnload=='function')wpOnload();
<<<<<<< HEAD
=======
<?php if ( $interim_login ) { ?>
(function(){
try {
	var i, links = document.getElementsByTagName('a');
	for ( i in links ) {
		if ( links[i].href )
			links[i].target = '_blank';
	}
} catch(e){}
}());
<?php } ?>
>>>>>>> WPHome/master
</script>

<?php
login_footer();
break;
} // end action switch
