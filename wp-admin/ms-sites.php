<?php
/**
 * Multisite sites administration panel.
 *
 * @package WordPress
 * @subpackage Multisite
 * @since 3.0.0
 */

<<<<<<< HEAD
require_once( './admin.php' );
=======
require_once( dirname( __FILE__ ) . '/admin.php' );
>>>>>>> WPHome/master

wp_redirect( network_admin_url('sites.php') );
exit;
