<?php
/**
 * WordPress Options Header.
 *
<<<<<<< HEAD
 * Resets variables: 'action', 'standalone', and 'option_group_id'. Displays
 * updated message, if updated variable is part of the URL query.
=======
 * Displays updated message, if updated variable is part of the URL query.
>>>>>>> WPHome/master
 *
 * @package WordPress
 * @subpackage Administration
 */

<<<<<<< HEAD
wp_reset_vars(array('action', 'standalone', 'option_group_id'));
=======
wp_reset_vars( array( 'action' ) );
>>>>>>> WPHome/master

if ( isset( $_GET['updated'] ) && isset( $_GET['page'] ) ) {
	// For backwards compat with plugins that don't use the Settings API and just set updated=1 in the redirect
	add_settings_error('general', 'settings_updated', __('Settings saved.'), 'updated');
}

settings_errors();
