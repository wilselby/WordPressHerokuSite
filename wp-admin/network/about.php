<?php
/**
 * Network About administration panel.
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
require( '../about.php' );
=======
require( ABSPATH . 'wp-admin/about.php' );
>>>>>>> WPHome/master
