<?php
/**
 * Network Credits administration panel.
 *
 * @package WordPress
 * @subpackage Multisite
 * @since 3.4.0
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
require( '../credits.php' );
=======
require( ABSPATH . 'wp-admin/credits.php' );
>>>>>>> WPHome/master
