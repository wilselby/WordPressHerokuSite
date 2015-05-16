<?php
/**
<<<<<<< HEAD
 * Implements an optional custom header for Twenty Twelve.
 * See http://codex.wordpress.org/Custom_Headers
=======
 * Implement an optional custom header for Twenty Twelve
 *
 * See https://codex.wordpress.org/Custom_Headers
>>>>>>> WPHome/master
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

/**
<<<<<<< HEAD
 * Sets up the WordPress core custom header arguments and settings.
=======
 * Set up the WordPress core custom header arguments and settings.
>>>>>>> WPHome/master
 *
 * @uses add_theme_support() to register support for 3.4 and up.
 * @uses twentytwelve_header_style() to style front-end.
 * @uses twentytwelve_admin_header_style() to style wp-admin form.
 * @uses twentytwelve_admin_header_image() to add custom markup to wp-admin form.
 *
 * @since Twenty Twelve 1.0
 */
function twentytwelve_custom_header_setup() {
	$args = array(
		// Text color and image (empty to use none).
<<<<<<< HEAD
		'default-text-color'     => '444',
=======
		'default-text-color'     => '515151',
>>>>>>> WPHome/master
		'default-image'          => '',

		// Set height and width, with a maximum value for the width.
		'height'                 => 250,
		'width'                  => 960,
		'max-width'              => 2000,

		// Support flexible height and width.
		'flex-height'            => true,
		'flex-width'             => true,

		// Random image rotation off by default.
		'random-default'         => false,

		// Callbacks for styling the header and the admin preview.
		'wp-head-callback'       => 'twentytwelve_header_style',
		'admin-head-callback'    => 'twentytwelve_admin_header_style',
		'admin-preview-callback' => 'twentytwelve_admin_header_image',
	);

	add_theme_support( 'custom-header', $args );
}
add_action( 'after_setup_theme', 'twentytwelve_custom_header_setup' );

/**
<<<<<<< HEAD
 * Styles the header text displayed on the blog.
 *
 * get_header_textcolor() options: 444 is default, hide text (returns 'blank'), or any hex value.
=======
 * Load our special font CSS file.
 *
 * @since Twenty Twelve 1.2
 */
function twentytwelve_custom_header_fonts() {
	$font_url = twentytwelve_get_font_url();
	if ( ! empty( $font_url ) )
		wp_enqueue_style( 'twentytwelve-fonts', esc_url_raw( $font_url ), array(), null );
}
add_action( 'admin_print_styles-appearance_page_custom-header', 'twentytwelve_custom_header_fonts' );

/**
 * Style the header text displayed on the blog.
 *
 * get_header_textcolor() options: 515151 is default, hide text (returns 'blank'), or any hex value.
>>>>>>> WPHome/master
 *
 * @since Twenty Twelve 1.0
 */
function twentytwelve_header_style() {
	$text_color = get_header_textcolor();

	// If no custom options for text are set, let's bail
	if ( $text_color == get_theme_support( 'custom-header', 'default-text-color' ) )
		return;

	// If we get this far, we have custom styles.
	?>
<<<<<<< HEAD
	<style type="text/css">
=======
	<style type="text/css" id="twentytwelve-header-css">
>>>>>>> WPHome/master
	<?php
		// Has the text been hidden?
		if ( ! display_header_text() ) :
	?>
		.site-title,
		.site-description {
<<<<<<< HEAD
			position: absolute !important;
=======
			position: absolute;
>>>>>>> WPHome/master
			clip: rect(1px 1px 1px 1px); /* IE7 */
			clip: rect(1px, 1px, 1px, 1px);
		}
	<?php
		// If the user has set a custom color for the text, use that.
		else :
	?>
<<<<<<< HEAD
		.site-title a,
		.site-description {
			color: #<?php echo $text_color; ?> !important;
=======
		.site-header h1 a,
		.site-header h2 {
			color: #<?php echo $text_color; ?>;
>>>>>>> WPHome/master
		}
	<?php endif; ?>
	</style>
	<?php
}

/**
<<<<<<< HEAD
 * Styles the header image displayed on the Appearance > Header admin panel.
=======
 * Style the header image displayed on the Appearance > Header admin panel.
>>>>>>> WPHome/master
 *
 * @since Twenty Twelve 1.0
 */
function twentytwelve_admin_header_style() {
?>
<<<<<<< HEAD
	<style type="text/css">
	.appearance_page_custom-header #headimg {
		border: none;
	}
	#headimg h1,
	#headimg h2 {
		line-height: 1.6;
=======
	<style type="text/css" id="twentytwelve-admin-header-css">
	.appearance_page_custom-header #headimg {
		border: none;
		font-family: "Open Sans", Helvetica, Arial, sans-serif;
	}
	#headimg h1,
	#headimg h2 {
		line-height: 1.84615;
>>>>>>> WPHome/master
		margin: 0;
		padding: 0;
	}
	#headimg h1 {
<<<<<<< HEAD
		font-size: 30px;
=======
		font-size: 26px;
>>>>>>> WPHome/master
	}
	#headimg h1 a {
		color: #515151;
		text-decoration: none;
	}
	#headimg h1 a:hover {
<<<<<<< HEAD
		color: #21759b;
	}
	#headimg h2 {
		color: #757575;
		font: normal 13px/1.8 "HelveticaNeue-Light", "Helvetica Neue Light", "Helvetica Neue", sans-serif;
=======
		color: #21759b !important; /* Has to override custom inline style. */
	}
	#headimg h2 {
		color: #757575;
		font-size: 13px;
>>>>>>> WPHome/master
		margin-bottom: 24px;
	}
	#headimg img {
		max-width: <?php echo get_theme_support( 'custom-header', 'max-width' ); ?>px;
	}
	</style>
<?php
}

/**
<<<<<<< HEAD
 * Outputs markup to be displayed on the Appearance > Header admin panel.
=======
 * Output markup to be displayed on the Appearance > Header admin panel.
 *
>>>>>>> WPHome/master
 * This callback overrides the default markup displayed there.
 *
 * @since Twenty Twelve 1.0
 */
function twentytwelve_admin_header_image() {
<<<<<<< HEAD
	?>
	<div id="headimg">
		<?php
		if ( ! display_header_text() )
			$style = ' style="display:none;"';
		else
			$style = ' style="color:#' . get_header_textcolor() . ';"';
		?>
		<h1><a id="name"<?php echo $style; ?> onclick="return false;" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a></h1>
		<h2 id="desc"<?php echo $style; ?>><?php bloginfo( 'description' ); ?></h2>
		<?php $header_image = get_header_image();
		if ( ! empty( $header_image ) ) : ?>
			<img src="<?php echo esc_url( $header_image ); ?>" class="header-image" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="" />
		<?php endif; ?>
	</div>
<?php }
=======
	$style = 'color: #' . get_header_textcolor() . ';';
	if ( ! display_header_text() ) {
		$style = 'display: none;';
	}
	?>
	<div id="headimg">
		<h1 class="displaying-header-text"><a id="name" style="<?php echo esc_attr( $style ); ?>" onclick="return false;" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a></h1>
		<h2 id="desc" class="displaying-header-text" style="<?php echo esc_attr( $style ); ?>"><?php bloginfo( 'description' ); ?></h2>
		<?php $header_image = get_header_image();
		if ( ! empty( $header_image ) ) : ?>
			<img src="<?php echo esc_url( $header_image ); ?>" class="header-image" width="<?php echo esc_attr( get_custom_header()->width ); ?>" height="<?php echo esc_attr( get_custom_header()->height ); ?>" alt="" />
		<?php endif; ?>
	</div>
<?php }
>>>>>>> WPHome/master
