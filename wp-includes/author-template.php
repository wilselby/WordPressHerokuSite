<?php
/**
 * Author Template functions for use in themes.
 *
 * These functions must be used within the WordPress Loop.
 *
<<<<<<< HEAD
 * @link http://codex.wordpress.org/Author_Templates
=======
 * @link https://codex.wordpress.org/Author_Templates
>>>>>>> WPHome/master
 *
 * @package WordPress
 * @subpackage Template
 */

/**
 * Retrieve the author of the current post.
 *
<<<<<<< HEAD
 * @since 1.5
 * @uses $authordata The current author's DB object.
 * @uses apply_filters() Calls 'the_author' hook on the author display name.
=======
 * @since 1.5.0
 *
 * @uses $authordata The current author's DB object.
>>>>>>> WPHome/master
 *
 * @param string $deprecated Deprecated.
 * @return string The author's display name.
 */
function get_the_author($deprecated = '') {
	global $authordata;

	if ( !empty( $deprecated ) )
		_deprecated_argument( __FUNCTION__, '2.1' );

<<<<<<< HEAD
=======
	/**
	 * Filter the display name of the current post's author.
	 *
	 * @since 2.9.0
	 *
	 * @param string $authordata->display_name The author's display name.
	 */
>>>>>>> WPHome/master
	return apply_filters('the_author', is_object($authordata) ? $authordata->display_name : null);
}

/**
 * Display the name of the author of the current post.
 *
 * The behavior of this function is based off of old functionality predating
 * get_the_author(). This function is not deprecated, but is designed to echo
 * the value from get_the_author() and as an result of any old theme that might
 * still use the old behavior will also pass the value from get_the_author().
 *
 * The normal, expected behavior of this function is to echo the author and not
 * return it. However, backwards compatibility has to be maintained.
 *
 * @since 0.71
 * @see get_the_author()
<<<<<<< HEAD
 * @link http://codex.wordpress.org/Template_Tags/the_author
=======
 * @link https://codex.wordpress.org/Template_Tags/the_author
>>>>>>> WPHome/master
 *
 * @param string $deprecated Deprecated.
 * @param string $deprecated_echo Deprecated. Use get_the_author(). Echo the string or return it.
 * @return string The author's display name, from get_the_author().
 */
function the_author( $deprecated = '', $deprecated_echo = true ) {
	if ( !empty( $deprecated ) )
		_deprecated_argument( __FUNCTION__, '2.1' );
	if ( $deprecated_echo !== true )
		_deprecated_argument( __FUNCTION__, '1.5', __('Use <code>get_the_author()</code> instead if you do not want the value echoed.') );
	if ( $deprecated_echo )
		echo get_the_author();
	return get_the_author();
}

/**
 * Retrieve the author who last edited the current post.
 *
<<<<<<< HEAD
 * @since 2.8
 * @uses $post The current post's DB object.
 * @uses get_post_meta() Retrieves the ID of the author who last edited the current post.
 * @uses get_userdata() Retrieves the author's DB object.
 * @uses apply_filters() Calls 'the_modified_author' hook on the author display name.
=======
 * @since 2.8.0
 *
>>>>>>> WPHome/master
 * @return string The author's display name.
 */
function get_the_modified_author() {
	if ( $last_id = get_post_meta( get_post()->ID, '_edit_last', true) ) {
		$last_user = get_userdata($last_id);
<<<<<<< HEAD
=======

		/**
		 * Filter the display name of the author who last edited the current post.
		 *
		 * @since 2.8.0
		 *
		 * @param string $last_user->display_name The author's display name.
		 */
>>>>>>> WPHome/master
		return apply_filters('the_modified_author', $last_user->display_name);
	}
}

/**
 * Display the name of the author who last edited the current post.
 *
<<<<<<< HEAD
 * @since 2.8
=======
 * @since 2.8.0
 *
>>>>>>> WPHome/master
 * @see get_the_author()
 * @return string The author's display name, from get_the_modified_author().
 */
function the_modified_author() {
	echo get_the_modified_author();
}

/**
 * Retrieve the requested data of the author of the current post.
<<<<<<< HEAD
 * @link http://codex.wordpress.org/Template_Tags/the_author_meta
 * @since 2.8.0
 * @uses $authordata The current author's DB object (if $user_id not specified).
=======
 * @link https://codex.wordpress.org/Template_Tags/the_author_meta
 * @since 2.8.0
>>>>>>> WPHome/master
 * @param string $field selects the field of the users record.
 * @param int $user_id Optional. User ID.
 * @return string The author's field from the current author's DB object.
 */
function get_the_author_meta( $field = '', $user_id = false ) {
	if ( ! $user_id ) {
		global $authordata;
		$user_id = isset( $authordata->ID ) ? $authordata->ID : 0;
	} else {
		$authordata = get_userdata( $user_id );
	}

	if ( in_array( $field, array( 'login', 'pass', 'nicename', 'email', 'url', 'registered', 'activation_key', 'status' ) ) )
		$field = 'user_' . $field;

	$value = isset( $authordata->$field ) ? $authordata->$field : '';

<<<<<<< HEAD
=======
	/**
	 * Filter the value of the requested user metadata.
	 *
	 * The filter name is dynamic and depends on the $field parameter of the function.
	 *
	 * @since 2.8.0
	 *
	 * @param string $value   The value of the metadata.
	 * @param int    $user_id The user ID.
	 */
>>>>>>> WPHome/master
	return apply_filters( 'get_the_author_' . $field, $value, $user_id );
}

/**
 * Retrieve the requested data of the author of the current post.
<<<<<<< HEAD
 * @link http://codex.wordpress.org/Template_Tags/the_author_meta
=======
 * @link https://codex.wordpress.org/Template_Tags/the_author_meta
>>>>>>> WPHome/master
 * @since 2.8.0
 * @param string $field selects the field of the users record.
 * @param int $user_id Optional. User ID.
 * @echo string The author's field from the current author's DB object.
 */
<<<<<<< HEAD
function the_author_meta($field = '', $user_id = false) {
	echo apply_filters('the_author_' . $field, get_the_author_meta($field, $user_id), $user_id);
=======
function the_author_meta( $field = '', $user_id = false ) {
	$author_meta = get_the_author_meta( $field, $user_id );

	/**
	 * The value of the requested user metadata.
	 *
	 * The filter name is dynamic and depends on the $field parameter of the function.
	 *
	 * @since 2.8.0
	 *
	 * @param string $author_meta The value of the metadata.
	 * @param int    $user_id     The user ID.
	 */
	echo apply_filters( 'the_author_' . $field, $author_meta, $user_id );
>>>>>>> WPHome/master
}

/**
 * Retrieve either author's link or author's name.
 *
 * If the author has a home page set, return an HTML link, otherwise just return the
 * author's name.
<<<<<<< HEAD
 *
 * @uses get_the_author_meta()
 * @uses get_the_author()
 */
function get_the_author_link() {
	if ( get_the_author_meta('url') ) {
		return '<a href="' . get_the_author_meta('url') . '" title="' . esc_attr( sprintf(__("Visit %s&#8217;s website"), get_the_author()) ) . '" rel="author external">' . get_the_author() . '</a>';
=======
 */
function get_the_author_link() {
	if ( get_the_author_meta('url') ) {
		return '<a href="' . esc_url( get_the_author_meta('url') ) . '" title="' . esc_attr( sprintf(__("Visit %s&#8217;s website"), get_the_author()) ) . '" rel="author external">' . get_the_author() . '</a>';
>>>>>>> WPHome/master
	} else {
		return get_the_author();
	}
}

/**
 * Display either author's link or author's name.
 *
 * If the author has a home page set, echo an HTML link, otherwise just echo the
 * author's name.
 *
<<<<<<< HEAD
 * @link http://codex.wordpress.org/Template_Tags/the_author_link
 * @since 2.1
 * @uses get_the_author_link()
=======
 * @link https://codex.wordpress.org/Template_Tags/the_author_link
 *
 * @since 2.1.0
>>>>>>> WPHome/master
 */
function the_author_link() {
	echo get_the_author_link();
}

/**
 * Retrieve the number of posts by the author of the current post.
 *
<<<<<<< HEAD
 * @since 1.5
 * @uses $post The current post in the Loop's DB object.
 * @uses count_user_posts()
 * @return int The number of posts by the author.
 */
function get_the_author_posts() {
	return count_user_posts( get_post()->post_author );
=======
 * @since 1.5.0
 *
 * @return int The number of posts by the author.
 */
function get_the_author_posts() {
	$post = get_post();
	if ( ! $post ) {
		return 0;
	}
	return count_user_posts( $post->post_author, $post->post_type );
>>>>>>> WPHome/master
}

/**
 * Display the number of posts by the author of the current post.
 *
<<<<<<< HEAD
 * @link http://codex.wordpress.org/Template_Tags/the_author_posts
 * @since 0.71
 * @uses get_the_author_posts() Echoes returned value from function.
=======
 * @link https://codex.wordpress.org/Template_Tags/the_author_posts
 * @since 0.71
>>>>>>> WPHome/master
 */
function the_author_posts() {
	echo get_the_author_posts();
}

/**
 * Display an HTML link to the author page of the author of the current post.
 *
 * Does just echo get_author_posts_url() function, like the others do. The
 * reason for this, is that another function is used to help in printing the
 * link to the author's posts.
 *
<<<<<<< HEAD
 * @link http://codex.wordpress.org/Template_Tags/the_author_posts_link
 * @since 1.2.0
 * @uses $authordata The current author's DB object.
 * @uses get_author_posts_url()
 * @uses get_the_author()
=======
 * @link https://codex.wordpress.org/Template_Tags/the_author_posts_link
 * @since 1.2.0
>>>>>>> WPHome/master
 * @param string $deprecated Deprecated.
 */
function the_author_posts_link($deprecated = '') {
	if ( !empty( $deprecated ) )
		_deprecated_argument( __FUNCTION__, '2.1' );

	global $authordata;
	if ( !is_object( $authordata ) )
		return false;
	$link = sprintf(
		'<a href="%1$s" title="%2$s" rel="author">%3$s</a>',
<<<<<<< HEAD
		get_author_posts_url( $authordata->ID, $authordata->user_nicename ),
		esc_attr( sprintf( __( 'Posts by %s' ), get_the_author() ) ),
		get_the_author()
	);
=======
		esc_url( get_author_posts_url( $authordata->ID, $authordata->user_nicename ) ),
		esc_attr( sprintf( __( 'Posts by %s' ), get_the_author() ) ),
		get_the_author()
	);

	/**
	 * Filter the link to the author page of the author of the current post.
	 *
	 * @since 2.9.0
	 *
	 * @param string $link HTML link.
	 */
>>>>>>> WPHome/master
	echo apply_filters( 'the_author_posts_link', $link );
}

/**
 * Retrieve the URL to the author page for the user with the ID provided.
 *
 * @since 2.1.0
 * @uses $wp_rewrite WP_Rewrite
 * @return string The URL to the author's page.
 */
function get_author_posts_url($author_id, $author_nicename = '') {
	global $wp_rewrite;
	$auth_ID = (int) $author_id;
	$link = $wp_rewrite->get_author_permastruct();

	if ( empty($link) ) {
		$file = home_url( '/' );
		$link = $file . '?author=' . $auth_ID;
	} else {
		if ( '' == $author_nicename ) {
			$user = get_userdata($author_id);
			if ( !empty($user->user_nicename) )
				$author_nicename = $user->user_nicename;
		}
		$link = str_replace('%author%', $author_nicename, $link);
		$link = home_url( user_trailingslashit( $link ) );
	}

<<<<<<< HEAD
	$link = apply_filters('author_link', $link, $author_id, $author_nicename);
=======
	/**
	 * Filter the URL to the author's page.
	 *
	 * @since 2.1.0
	 *
	 * @param string $link            The URL to the author's page.
	 * @param int    $author_id       The author's id.
	 * @param string $author_nicename The author's nice name.
	 */
	$link = apply_filters( 'author_link', $link, $author_id, $author_nicename );
>>>>>>> WPHome/master

	return $link;
}

/**
 * List all the authors of the blog, with several options available.
 *
<<<<<<< HEAD
 * <ul>
 * <li>optioncount (boolean) (false): Show the count in parenthesis next to the
 * author's name.</li>
 * <li>exclude_admin (boolean) (true): Exclude the 'admin' user that is
 * installed bydefault.</li>
 * <li>show_fullname (boolean) (false): Show their full names.</li>
 * <li>hide_empty (boolean) (true): Don't show authors without any posts.</li>
 * <li>feed (string) (''): If isn't empty, show links to author's feeds.</li>
 * <li>feed_image (string) (''): If isn't empty, use this image to link to
 * feeds.</li>
 * <li>echo (boolean) (true): Set to false to return the output, instead of
 * echoing.</li>
 * <li>style (string) ('list'): Whether to display list of authors in list form
 * or as a string.</li>
 * <li>html (bool) (true): Whether to list the items in html form or plaintext.
 * </li>
 * </ul>
 *
 * @link http://codex.wordpress.org/Template_Tags/wp_list_authors
 * @since 1.2.0
 * @param array $args The argument array.
 * @return null|string The output, if echo is set to false.
 */
function wp_list_authors($args = '') {
=======
 * @link https://codex.wordpress.org/Template_Tags/wp_list_authors
 *
 * @since 1.2.0
 *
 * @param string|array $args {
 *     Optional. Array or string of default arguments.
 *
 *     @type string $orderby       How to sort the authors. Accepts 'nicename', 'email', 'url', 'registered',
 *                                 'user_nicename', 'user_email', 'user_url', 'user_registered', 'name',
 *                                 'display_name', 'post_count', 'ID', 'meta_value', 'user_login'. Default 'name'.
 *     @type string $order         Sorting direction for $orderby. Accepts 'ASC', 'DESC'. Default 'ASC'.
 *     @type int    $number        Maximum authors to return or display. Default empty (all authors).
 *     @type bool   $optioncount   Show the count in parenthesis next to the author's name. Default false.
 *     @type bool   $exclude_admin Whether to exclude the 'admin' account, if it exists. Default false.
 *     @type bool   $show_fullname Whether to show the author's full name. Default false.
 *     @type bool   $hide_empty    Whether to hide any authors with no posts. Default true.
 *     @type string $feed          If not empty, show a link to the author's feed and use this text as the alt
 *                                 parameter of the link. Default empty.
 *     @type string $feed_image    If not empty, show a link to the author's feed and use this image URL as
 *                                 clickable anchor. Default empty.
 *     @type string $feed_type     The feed type to link to, such as 'rss2'. Defaults to default feed type.
 *     @type bool   $echo          Whether to output the result or instead return it. Default true.
 *     @type string $style         If 'list', each author is wrapped in an `<li>` element, otherwise the authors
 *                                 will be separated by commas.
 *     @type bool   $html          Whether to list the items in HTML form or plaintext. Default true.
 *     @type string $exclude       An array, comma-, or space-separated list of author IDs to exclude. Default empty.
 *     @type string $exclude       An array, comma-, or space-separated list of author IDs to include. Default empty.
 * }
 * @return null|string The output, if echo is set to false. Otherwise null.
 */
function wp_list_authors( $args = '' ) {
>>>>>>> WPHome/master
	global $wpdb;

	$defaults = array(
		'orderby' => 'name', 'order' => 'ASC', 'number' => '',
		'optioncount' => false, 'exclude_admin' => true,
		'show_fullname' => false, 'hide_empty' => true,
		'feed' => '', 'feed_image' => '', 'feed_type' => '', 'echo' => true,
<<<<<<< HEAD
		'style' => 'list', 'html' => true
	);

	$args = wp_parse_args( $args, $defaults );
	extract( $args, EXTR_SKIP );

	$return = '';

	$query_args = wp_array_slice_assoc( $args, array( 'orderby', 'order', 'number' ) );
=======
		'style' => 'list', 'html' => true, 'exclude' => '', 'include' => ''
	);

	$args = wp_parse_args( $args, $defaults );

	$return = '';

	$query_args = wp_array_slice_assoc( $args, array( 'orderby', 'order', 'number', 'exclude', 'include' ) );
>>>>>>> WPHome/master
	$query_args['fields'] = 'ids';
	$authors = get_users( $query_args );

	$author_count = array();
<<<<<<< HEAD
	foreach ( (array) $wpdb->get_results("SELECT DISTINCT post_author, COUNT(ID) AS count FROM $wpdb->posts WHERE post_type = 'post' AND " . get_private_posts_cap_sql( 'post' ) . " GROUP BY post_author") as $row )
		$author_count[$row->post_author] = $row->count;

	foreach ( $authors as $author_id ) {
		$author = get_userdata( $author_id );

		if ( $exclude_admin && 'admin' == $author->display_name )
			continue;

		$posts = isset( $author_count[$author->ID] ) ? $author_count[$author->ID] : 0;

		if ( !$posts && $hide_empty )
			continue;

		$link = '';

		if ( $show_fullname && $author->first_name && $author->last_name )
			$name = "$author->first_name $author->last_name";
		else
			$name = $author->display_name;

		if ( !$html ) {
=======
	foreach ( (array) $wpdb->get_results( "SELECT DISTINCT post_author, COUNT(ID) AS count FROM $wpdb->posts WHERE " . get_private_posts_cap_sql( 'post' ) . " GROUP BY post_author" ) as $row ) {
		$author_count[$row->post_author] = $row->count;
	}
	foreach ( $authors as $author_id ) {
		$author = get_userdata( $author_id );

		if ( $args['exclude_admin'] && 'admin' == $author->display_name ) {
			continue;
		}

		$posts = isset( $author_count[$author->ID] ) ? $author_count[$author->ID] : 0;

		if ( ! $posts && $args['hide_empty'] ) {
			continue;
		}

		if ( $args['show_fullname'] && $author->first_name && $author->last_name ) {
			$name = "$author->first_name $author->last_name";
		} else {
			$name = $author->display_name;
		}

		if ( ! $args['html'] ) {
>>>>>>> WPHome/master
			$return .= $name . ', ';

			continue; // No need to go further to process HTML.
		}

<<<<<<< HEAD
		if ( 'list' == $style ) {
=======
		if ( 'list' == $args['style'] ) {
>>>>>>> WPHome/master
			$return .= '<li>';
		}

		$link = '<a href="' . get_author_posts_url( $author->ID, $author->user_nicename ) . '" title="' . esc_attr( sprintf(__("Posts by %s"), $author->display_name) ) . '">' . $name . '</a>';

<<<<<<< HEAD
		if ( !empty( $feed_image ) || !empty( $feed ) ) {
			$link .= ' ';
			if ( empty( $feed_image ) ) {
				$link .= '(';
			}

			$link .= '<a href="' . get_author_feed_link( $author->ID ) . '"';

			$alt = $title = '';
			if ( !empty( $feed ) ) {
				$title = ' title="' . esc_attr( $feed ) . '"';
				$alt = ' alt="' . esc_attr( $feed ) . '"';
				$name = $feed;
				$link .= $title;
=======
		if ( ! empty( $args['feed_image'] ) || ! empty( $args['feed'] ) ) {
			$link .= ' ';
			if ( empty( $args['feed_image'] ) ) {
				$link .= '(';
			}

			$link .= '<a href="' . get_author_feed_link( $author->ID, $args['feed_type'] ) . '"';

			$alt = '';
			if ( ! empty( $args['feed'] ) ) {
				$alt = ' alt="' . esc_attr( $args['feed'] ) . '"';
				$name = $args['feed'];
>>>>>>> WPHome/master
			}

			$link .= '>';

<<<<<<< HEAD
			if ( !empty( $feed_image ) )
				$link .= '<img src="' . esc_url( $feed_image ) . '" style="border: none;"' . $alt . $title . ' />';
			else
				$link .= $name;

			$link .= '</a>';

			if ( empty( $feed_image ) )
				$link .= ')';
		}

		if ( $optioncount )
			$link .= ' ('. $posts . ')';

		$return .= $link;
		$return .= ( 'list' == $style ) ? '</li>' : ', ';
	}

	$return = rtrim($return, ', ');

	if ( !$echo )
		return $return;

=======
			if ( ! empty( $args['feed_image'] ) ) {
				$link .= '<img src="' . esc_url( $args['feed_image'] ) . '" style="border: none;"' . $alt . ' />';
			} else {
				$link .= $name;
			}

			$link .= '</a>';

			if ( empty( $args['feed_image'] ) ) {
				$link .= ')';
			}
		}

		if ( $args['optioncount'] ) {
			$link .= ' ('. $posts . ')';
		}

		$return .= $link;
		$return .= ( 'list' == $args['style'] ) ? '</li>' : ', ';
	}

	$return = rtrim( $return, ', ' );

	if ( ! $args['echo'] ) {
		return $return;
	}
>>>>>>> WPHome/master
	echo $return;
}

/**
 * Does this site have more than one author
 *
 * Checks to see if more than one author has published posts.
 *
 * @since 3.2.0
 * @return bool Whether or not we have more than one author
 */
function is_multi_author() {
	global $wpdb;

<<<<<<< HEAD
	if ( false === ( $is_multi_author = wp_cache_get('is_multi_author', 'posts') ) ) {
		$rows = (array) $wpdb->get_col("SELECT DISTINCT post_author FROM $wpdb->posts WHERE post_type = 'post' AND post_status = 'publish' LIMIT 2");
		$is_multi_author = 1 < count( $rows ) ? 1 : 0;
		wp_cache_set('is_multi_author', $is_multi_author, 'posts');
	}

=======
	if ( false === ( $is_multi_author = get_transient( 'is_multi_author' ) ) ) {
		$rows = (array) $wpdb->get_col("SELECT DISTINCT post_author FROM $wpdb->posts WHERE post_type = 'post' AND post_status = 'publish' LIMIT 2");
		$is_multi_author = 1 < count( $rows ) ? 1 : 0;
		set_transient( 'is_multi_author', $is_multi_author );
	}

	/**
	 * Filter whether the site has more than one author with published posts.
	 *
	 * @since 3.2.0
	 *
	 * @param bool $is_multi_author Whether $is_multi_author should evaluate as true.
	 */
>>>>>>> WPHome/master
	return apply_filters( 'is_multi_author', (bool) $is_multi_author );
}

/**
 * Helper function to clear the cache for number of authors.
 *
 * @private
 */
function __clear_multi_author_cache() {
<<<<<<< HEAD
	wp_cache_delete('is_multi_author', 'posts');
}
add_action('transition_post_status', '__clear_multi_author_cache');
=======
	delete_transient( 'is_multi_author' );
}
>>>>>>> WPHome/master
