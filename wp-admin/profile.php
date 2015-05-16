<?php
/**
 * User Profile Administration Screen.
 *
 * @package WordPress
 * @subpackage Administration
 */

/**
 * This is a profile page.
 *
 * @since 2.5.0
 * @var bool
 */
define('IS_PROFILE_PAGE', true);

/** Load User Editing Page */
<<<<<<< HEAD
require_once('./user-edit.php');
=======
require_once( dirname( __FILE__ ) . '/user-edit.php' );
>>>>>>> WPHome/master
