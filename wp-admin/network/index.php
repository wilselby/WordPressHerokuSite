<?php
/**
 * Multisite administration panel.
 *
 * @package WordPress
 * @subpackage Multisite
 * @since 3.0.0
 */

/** Load WordPress Administration Bootstrap */
<<<<<<< HEAD
require_once( './admin.php' );
=======
require_once( dirname( __FILE__ ) . '/admin.php' );
>>>>>>> WPHome/master

/** Load WordPress dashboard API */
require_once( ABSPATH . 'wp-admin/includes/dashboard.php' );

if ( !is_multisite() )
	wp_die( __( 'Multisite support is not enabled.' ) );

if ( ! current_user_can( 'manage_network' ) )
<<<<<<< HEAD
	wp_die( __( 'You do not have permission to access this page.' ) );
=======
	wp_die( __( 'You do not have permission to access this page.' ), 403 );
>>>>>>> WPHome/master

$title = __( 'Dashboard' );
$parent_file = 'index.php';

<<<<<<< HEAD
	get_current_screen()->add_help_tab( array(
		'id'      => 'overview',
		'title'   => __('Overview'),
		'content' =>
			'<p>' . __('Until WordPress 3.0, running multiple sites required using WordPress MU instead of regular WordPress. In version 3.0, these applications have merged. If you are a former MU user, you should be aware of the following changes:') . '</p>' .
			'<ul><li>' . __('Site Admin is now Super Admin (we highly encourage you to get yourself a cape!).') . '</li>' .
			'<li>' . __('Blogs are now called Sites; Site is now called Network.') . '</li></ul>' .
			'<p>' . __('The Right Now box provides the network administrator with links to the screens to either create a new site or user, or to search existing users and sites. Screens for Sites and Users are also accessible through the left-hand navigation in the Network Admin section.') . '</p>'
=======
$overview = '<p>' . __( 'Welcome to your Network Admin. This area of the Administration Screens is used for managing all aspects of your Multisite Network.' ) . '</p>';
$overview .= '<p>' . __( 'From here you can:' ) . '</p>';
$overview .= '<ul><li>' . __( 'Add and manage sites or users' ) . '</li>';
$overview .= '<li>' . __( 'Install and activate themes or plugins' ) . '</li>';
$overview .= '<li>' . __( 'Update your network' ) . '</li>';
$overview .= '<li>' . __( 'Modify global network settings' ) . '</li></ul>';

get_current_screen()->add_help_tab( array(
	'id'      => 'overview',
	'title'   => __( 'Overview' ),
	'content' => $overview
) );

$quick_tasks = '<p>' . __( 'The Right Now widget on this screen provides current user and site counts on your network.' ) . '</p>';
$quick_tasks .= '<ul><li>' . __( 'To add a new user, <strong>click Create a New User</strong>.' ) . '</li>';
$quick_tasks .= '<li>' . __( 'To add a new site, <strong>click Create a New Site</strong>.' ) . '</li></ul>';
$quick_tasks .= '<p>' . __( 'To search for a user or site, use the search boxes.' ) . '</p>';
$quick_tasks .= '<ul><li>' . __( 'To search for a user, <strong>enter an email address or username</strong>. Use a wildcard to search for a partial username, such as user&#42;.' ) . '</li>';
$quick_tasks .= '<li>' . __( 'To search for a site, <strong>enter the path or domain</strong>.' ) . '</li></ul>';

get_current_screen()->add_help_tab( array(
	'id'      => 'quick-tasks',
	'title'   => __( 'Quick Tasks' ),
	'content' => $quick_tasks
>>>>>>> WPHome/master
) );

get_current_screen()->set_help_sidebar(
	'<p><strong>' . __('For more information:') . '</strong></p>' .
<<<<<<< HEAD
	'<p>' . __('<a href="http://codex.wordpress.org/Network_Admin" target="_blank">Documentation on the Network Admin</a>') . '</p>' .
	'<p>' . __('<a href="http://wordpress.org/support/forum/multisite/" target="_blank">Support Forums</a>') . '</p>'
=======
	'<p>' . __('<a href="https://codex.wordpress.org/Network_Admin" target="_blank">Documentation on the Network Admin</a>') . '</p>' .
	'<p>' . __('<a href="https://wordpress.org/support/forum/multisite/" target="_blank">Support Forums</a>') . '</p>'
>>>>>>> WPHome/master
);

wp_dashboard_setup();

wp_enqueue_script( 'dashboard' );
wp_enqueue_script( 'plugin-install' );
add_thickbox();

<<<<<<< HEAD
add_screen_option('layout_columns', array('max' => 4, 'default' => 2) );

require_once( '../admin-header.php' );
=======
require_once( ABSPATH . 'wp-admin/admin-header.php' );
>>>>>>> WPHome/master

?>

<div class="wrap">
<<<<<<< HEAD
<?php screen_icon(); ?>
=======
>>>>>>> WPHome/master
<h2><?php echo esc_html( $title ); ?></h2>

<div id="dashboard-widgets-wrap">

<?php wp_dashboard(); ?>

<div class="clear"></div>
</div><!-- dashboard-widgets-wrap -->

</div><!-- wrap -->

<<<<<<< HEAD
<?php include( '../admin-footer.php' ); ?>
=======
<?php include( ABSPATH . 'wp-admin/admin-footer.php' ); ?>
>>>>>>> WPHome/master
