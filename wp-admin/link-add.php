<?php
/**
 * Add Link Administration Screen.
 *
 * @package WordPress
 * @subpackage Administration
 */

/** Load WordPress Administration Bootstrap */
<<<<<<< HEAD
require_once('./admin.php');
=======
require_once( dirname( __FILE__ ) . '/admin.php' );
>>>>>>> WPHome/master

if ( ! current_user_can('manage_links') )
	wp_die(__('You do not have sufficient permissions to add links to this site.'));

$title = __('Add New Link');
$parent_file = 'link-manager.php';

<<<<<<< HEAD
wp_reset_vars(array('action', 'cat_id', 'linkurl', 'name', 'image',
	'description', 'visible', 'target', 'category', 'link_id',
	'submit', 'order_by', 'links_show_cat_id', 'rating', 'rel',
	'notes', 'linkcheck[]'));
=======
wp_reset_vars( array('action', 'cat_id', 'link_id' ) );
>>>>>>> WPHome/master

wp_enqueue_script('link');
wp_enqueue_script('xfn');

if ( wp_is_mobile() )
	wp_enqueue_script( 'jquery-touch-punch' );

$link = get_default_link_to_edit();
<<<<<<< HEAD
include('./edit-link-form.php');

require('./admin-footer.php');
=======
include( ABSPATH . 'wp-admin/edit-link-form.php' );

require( ABSPATH . 'wp-admin/admin-footer.php' );
>>>>>>> WPHome/master
