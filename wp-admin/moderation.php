<?php
/**
 * Comment Moderation Administration Screen.
 *
 * Redirects to edit-comments.php?comment_status=moderated.
 *
 * @package WordPress
 * @subpackage Administration
 */
<<<<<<< HEAD
require_once('../wp-load.php');
=======
require_once( dirname( dirname( __FILE__ ) ) . '/wp-load.php' );
>>>>>>> WPHome/master
wp_redirect( admin_url('edit-comments.php?comment_status=moderated') );
exit;
