<?php
/**
 * Network Setup administration panel.
 *
 * @package WordPress
 * @subpackage Multisite
 * @since 3.1.0
 */

/** Load WordPress Administration Bootstrap */
<<<<<<< HEAD
require_once( './admin.php' );
=======
require_once( dirname( __FILE__ ) . '/admin.php' );
>>>>>>> WPHome/master

if ( ! is_multisite() )
	wp_die( __( 'Multisite support is not enabled.' ) );

<<<<<<< HEAD
require( '../network.php' );
=======
require( ABSPATH . 'wp-admin/network.php' );
>>>>>>> WPHome/master
