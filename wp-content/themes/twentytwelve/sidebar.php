<?php
/**
<<<<<<< HEAD
 * The sidebar containing the main widget area.
 *
 * If no active widgets in sidebar, let's hide it completely.
=======
 * The sidebar containing the main widget area
 *
 * If no active widgets are in the sidebar, hide it completely.
>>>>>>> WPHome/master
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?>

	<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
		<div id="secondary" class="widget-area" role="complementary">
			<?php dynamic_sidebar( 'sidebar-1' ); ?>
		</div><!-- #secondary -->
	<?php endif; ?>