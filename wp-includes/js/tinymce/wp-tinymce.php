<?php
/**
 * Disable error reporting
 *
<<<<<<< HEAD
 * Set this to error_reporting( E_ALL ) or error_reporting( E_ALL | E_STRICT ) for debugging
=======
 * Set this to error_reporting( -1 ) for debugging.
>>>>>>> WPHome/master
 */
error_reporting(0);

$basepath = dirname(__FILE__);

function get_file($path) {

	if ( function_exists('realpath') )
		$path = realpath($path);

	if ( ! $path || ! @is_file($path) )
		return false;

	return @file_get_contents($path);
}

$expires_offset = 31536000; // 1 year

<<<<<<< HEAD
header('Content-Type: application/x-javascript; charset=UTF-8');
=======
header('Content-Type: application/javascript; charset=UTF-8');
>>>>>>> WPHome/master
header('Vary: Accept-Encoding'); // Handle proxies
header('Expires: ' . gmdate( "D, d M Y H:i:s", time() + $expires_offset ) . ' GMT');
header("Cache-Control: public, max-age=$expires_offset");

if ( isset($_GET['c']) && 1 == $_GET['c'] && isset($_SERVER['HTTP_ACCEPT_ENCODING'])
	&& false !== stripos($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip') && ( $file = get_file($basepath . '/wp-tinymce.js.gz') ) ) {

	header('Content-Encoding: gzip');
	echo $file;
} else {
<<<<<<< HEAD
	echo get_file($basepath . '/tiny_mce.js');
	echo get_file($basepath . '/wp-tinymce-schema.js');
=======
	// Back compat. This file shouldn't be used if this condition can occur (as in, if gzip isn't accepted).
	echo get_file( $basepath . '/tinymce.min.js' );
	echo get_file( $basepath . '/plugins/compat3x/plugin.min.js' );
>>>>>>> WPHome/master
}
exit;
