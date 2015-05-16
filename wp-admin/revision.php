<?php
/**
<<<<<<< HEAD
 * Revisions administration panel.
 *
 * @package WordPress
 * @subpackage Administration
 */

/** WordPress Administration Bootstrap */
require_once('./admin.php');

wp_enqueue_script('list-revisions');

wp_reset_vars(array('revision', 'left', 'right', 'action'));

$revision_id = absint($revision);
$left        = absint($left);
$right       = absint($right);

$redirect = 'edit.php';

switch ( $action ) :
case 'restore' :
	if ( !$revision = wp_get_post_revision( $revision_id ) )
		break;
	if ( !current_user_can( 'edit_post', $revision->post_parent ) )
		break;
	if ( !$post = get_post( $revision->post_parent ) )
		break;

	// Revisions disabled and we're not looking at an autosave
	if ( ( ! WP_POST_REVISIONS || !post_type_supports($post->post_type, 'revisions') ) && !wp_is_post_autosave( $revision ) ) {
		$redirect = 'edit.php?post_type=' . $post->post_type;
		break;
	}

	check_admin_referer( "restore-post_$post->ID|$revision->ID" );

	wp_restore_post_revision( $revision->ID );
	$redirect = add_query_arg( array( 'message' => 5, 'revision' => $revision->ID ), get_edit_post_link( $post->ID, 'url' ) );
	break;
case 'diff' :
	if ( !$left_revision  = get_post( $left ) )
		break;
	if ( !$right_revision = get_post( $right ) )
		break;

	if ( !current_user_can( 'read_post', $left_revision->ID ) || !current_user_can( 'read_post', $right_revision->ID ) )
		break;

	// If we're comparing a revision to itself, redirect to the 'view' page for that revision or the edit page for that post
	if ( $left_revision->ID == $right_revision->ID ) {
		$redirect = get_edit_post_link( $left_revision->ID );
		include( './js/revisions-js.php' );
		break;
	}

	// Don't allow reverse diffs?
	if ( strtotime($right_revision->post_modified_gmt) < strtotime($left_revision->post_modified_gmt) ) {
		$redirect = add_query_arg( array( 'left' => $right, 'right' => $left ) );
		break;
	}

	if ( $left_revision->ID == $right_revision->post_parent ) // right is a revision of left
		$post =& $left_revision;
	elseif ( $left_revision->post_parent == $right_revision->ID ) // left is a revision of right
		$post =& $right_revision;
	elseif ( $left_revision->post_parent == $right_revision->post_parent ) // both are revisions of common parent
		$post = get_post( $left_revision->post_parent );
	else
		break; // Don't diff two unrelated revisions

	if ( ! WP_POST_REVISIONS || !post_type_supports($post->post_type, 'revisions') ) { // Revisions disabled
		if (
			// we're not looking at an autosave
			( !wp_is_post_autosave( $left_revision ) && !wp_is_post_autosave( $right_revision ) )
		||
			// we're not comparing an autosave to the current post
			( $post->ID !== $left_revision->ID && $post->ID !== $right_revision->ID )
		) {
			$redirect = 'edit.php?post_type=' . $post->post_type;
			break;
		}
	}

	if (
		// They're the same
		$left_revision->ID == $right_revision->ID
	||
		// Neither is a revision
		( !wp_get_post_revision( $left_revision->ID ) && !wp_get_post_revision( $right_revision->ID ) )
	)
		break;

	$post_title = '<a href="' . get_edit_post_link() . '">' . get_the_title() . '</a>';
	$h2 = sprintf( __( 'Compare Revisions of &#8220;%1$s&#8221;' ), $post_title );
	$title = __( 'Revisions' );

	$left  = $left_revision->ID;
	$right = $right_revision->ID;

	$redirect = false;
	break;
case 'view' :
default :
	if ( !$revision = wp_get_post_revision( $revision_id ) )
		break;
	if ( !$post = get_post( $revision->post_parent ) )
		break;

	if ( !current_user_can( 'read_post', $revision->ID ) || !current_user_can( 'read_post', $post->ID ) )
		break;

	// Revisions disabled and we're not looking at an autosave
	if ( ( ! WP_POST_REVISIONS || !post_type_supports($post->post_type, 'revisions') ) && !wp_is_post_autosave( $revision ) ) {
=======
 * Revisions administration panel
 *
 * Requires wp-admin/includes/revision.php.
 *
 * @package WordPress
 * @subpackage Administration
 * @since 2.6.0
 *
 * @param int    revision Optional. The revision ID.
 * @param string action   The action to take.
 *                        Accepts 'restore', 'view' or 'edit'.
 * @param int    from     The revision to compare from.
 * @param int    to       Optional, required if revision missing. The revision to compare to.
 */

/** WordPress Administration Bootstrap */
require_once( dirname( __FILE__ ) . '/admin.php' );

require ABSPATH . 'wp-admin/includes/revision.php';

wp_reset_vars( array( 'revision', 'action', 'from', 'to' ) );

$revision_id = absint( $revision );

$from = is_numeric( $from ) ? absint( $from ) : null;
if ( ! $revision_id )
	$revision_id = absint( $to );
$redirect = 'edit.php';

switch ( $action ) {
case 'restore' :
	if ( ! $revision = wp_get_post_revision( $revision_id ) )
		break;

	if ( ! current_user_can( 'edit_post', $revision->post_parent ) )
		break;

	if ( ! $post = get_post( $revision->post_parent ) )
		break;

	// Revisions disabled (previously checked autosaves && ! wp_is_post_autosave( $revision ))
	if ( ! wp_revisions_enabled( $post ) ) {
		$redirect = 'edit.php?post_type=' . $post->post_type;
		break;
	}

	// Don't allow revision restore when post is locked
	if ( wp_check_post_lock( $post->ID ) )
		break;

	check_admin_referer( "restore-post_{$revision->ID}" );

	wp_restore_post_revision( $revision->ID );
	$redirect = add_query_arg( array( 'message' => 5, 'revision' => $revision->ID ), get_edit_post_link( $post->ID, 'url' ) );
	break;
case 'view' :
case 'edit' :
default :
	if ( ! $revision = wp_get_post_revision( $revision_id ) )
		break;
	if ( ! $post = get_post( $revision->post_parent ) )
		break;

	if ( ! current_user_can( 'read_post', $revision->ID ) || ! current_user_can( 'read_post', $post->ID ) )
		break;

	// Revisions disabled and we're not looking at an autosave
	if ( ! wp_revisions_enabled( $post ) && ! wp_is_post_autosave( $revision ) ) {
>>>>>>> WPHome/master
		$redirect = 'edit.php?post_type=' . $post->post_type;
		break;
	}

<<<<<<< HEAD
	$post_title = '<a href="' . get_edit_post_link() . '">' . get_the_title() . '</a>';
	$revision_title = wp_post_revision_title( $revision, false );
	$h2 = sprintf( __( 'Revision for &#8220;%1$s&#8221; created on %2$s' ), $post_title, $revision_title );
	$title = __( 'Revisions' );

	// Sets up the diff radio buttons
	$left  = $revision->ID;
	$right = $post->ID;

	$redirect = false;
	break;
endswitch;

// Empty post_type means either malformed object found, or no valid parent was found.
if ( !$redirect && empty($post->post_type) )
	$redirect = 'edit.php';

if ( !empty($redirect) ) {
=======
	$post_edit_link = get_edit_post_link();
	$post_title     = '<a href="' . $post_edit_link . '">' . _draft_or_post_title() . '</a>';
	$h2             = sprintf( __( 'Compare Revisions of &#8220;%1$s&#8221;' ), $post_title );
	$return_to_post = '<a href="' . $post_edit_link . '">' . __( '&larr; Return to post editor' ) . '</a>';
	$title          = __( 'Revisions' );

	$redirect = false;
	break;
}

// Empty post_type means either malformed object found, or no valid parent was found.
if ( ! $redirect && empty( $post->post_type ) )
	$redirect = 'edit.php';

if ( ! empty( $redirect ) ) {
>>>>>>> WPHome/master
	wp_redirect( $redirect );
	exit;
}

// This is so that the correct "Edit" menu item is selected.
<<<<<<< HEAD
if ( !empty($post->post_type) && 'post' != $post->post_type )
=======
if ( ! empty( $post->post_type ) && 'post' != $post->post_type )
>>>>>>> WPHome/master
	$parent_file = $submenu_file = 'edit.php?post_type=' . $post->post_type;
else
	$parent_file = $submenu_file = 'edit.php';

<<<<<<< HEAD
require_once( './admin-header.php' );

?>

<div class="wrap">

<h2 class="long-header"><?php echo $h2; ?></h2>

<table class="form-table ie-fixed">
	<col class="th" />
<?php if ( 'diff' == $action ) : ?>
<tr id="revision">
	<th scope="row"></th>
	<th scope="col" class="th-full">
		<span class="alignleft"><?php printf( __('Older: %s'), wp_post_revision_title( $left_revision ) ); ?></span>
		<span class="alignright"><?php printf( __('Newer: %s'), wp_post_revision_title( $right_revision ) ); ?></span>
	</th>
</tr>
<?php endif;

// use get_post_to_edit filters?
$identical = true;
foreach ( _wp_post_revision_fields() as $field => $field_title ) :
	if ( 'diff' == $action ) {
		$left_content = apply_filters( "_wp_post_revision_field_$field", $left_revision->$field, $field );
		$right_content = apply_filters( "_wp_post_revision_field_$field", $right_revision->$field, $field );
		if ( !$content = wp_text_diff( $left_content, $right_content ) )
			continue; // There is no difference between left and right
		$identical = false;
	} else {
		add_filter( "_wp_post_revision_field_$field", 'htmlspecialchars' );
		$content = apply_filters( "_wp_post_revision_field_$field", $revision->$field, $field );
	}
	?>

	<tr id="revision-field-<?php echo $field; ?>">
		<th scope="row"><?php echo esc_html( $field_title ); ?></th>
		<td><div class="pre"><?php echo $content; ?></div></td>
	</tr>

	<?php

endforeach;

if ( 'diff' == $action && $identical ) :

	?>

	<tr><td colspan="2"><div class="updated"><p><?php _e( 'These revisions are identical.' ); ?></p></div></td></tr>

	<?php

endif;

?>

</table>

<br class="clear" />

<h3><?php echo $title; ?></h3>

<?php

$args = array( 'format' => 'form-table', 'parent' => true, 'right' => $right, 'left' => $left );
if ( ! WP_POST_REVISIONS || !post_type_supports($post->post_type, 'revisions') )
	$args['type'] = 'autosave';

wp_list_post_revisions( $post, $args );

?>

</div>

<?php
require_once( './admin-footer.php' );
=======
wp_enqueue_script( 'revisions' );
wp_localize_script( 'revisions', '_wpRevisionsSettings', wp_prepare_revisions_for_js( $post, $revision_id, $from ) );

/* Revisions Help Tab */

$revisions_overview  = '<p>' . __( 'This screen is used for managing your content revisions.' ) . '</p>';
$revisions_overview .= '<p>' . __( 'Revisions are saved copies of your post or page, which are periodically created as you update your content. The red text on the left shows the content that was removed. The green text on the right shows the content that was added.' ) . '</p>';
$revisions_overview .= '<p>' . __( 'From this screen you can review, compare, and restore revisions:' ) . '</p>';
$revisions_overview .= '<ul><li>' . __( 'To navigate between revisions, <strong>drag the slider handle left or right</strong> or <strong>use the Previous or Next buttons</strong>.' ) . '</li>';
$revisions_overview .= '<li>' . __( 'Compare two different revisions by <strong>selecting the &#8220;Compare any two revisions&#8221; box</strong> to the side.' ) . '</li>';
$revisions_overview .= '<li>' . __( 'To restore a revision, <strong>click Restore This Revision</strong>.' ) . '</li></ul>';

get_current_screen()->add_help_tab( array(
	'id'      => 'revisions-overview',
	'title'   => __( 'Overview' ),
	'content' => $revisions_overview
) );

$revisions_sidebar  = '<p><strong>' . __( 'For more information:' ) . '</strong></p>';
$revisions_sidebar .= '<p>' . __( '<a href="https://codex.wordpress.org/Revision_Management" target="_blank">Revisions Management</a>' ) . '</p>';
$revisions_sidebar .= '<p>' . __( '<a href="https://wordpress.org/support/" target="_blank">Support Forums</a>' ) . '</p>';

get_current_screen()->set_help_sidebar( $revisions_sidebar );

require_once( ABSPATH . 'wp-admin/admin-header.php' );

?>

<div class="wrap">
	<h2 class="long-header"><?php echo $h2; ?></h2>
	<?php echo $return_to_post; ?>
</div>
<?php
wp_print_revision_templates();

require_once( ABSPATH . 'wp-admin/admin-footer.php' );
>>>>>>> WPHome/master
