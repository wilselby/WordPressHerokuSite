<?php
/**
 * Bookmark Template Functions for usage in Themes
 *
 * @package WordPress
 * @subpackage Template
 */

/**
 * The formatted output of a list of bookmarks.
 *
 * The $bookmarks array must contain bookmark objects and will be iterated over
 * to retrieve the bookmark to be used in the output.
 *
 * The output is formatted as HTML with no way to change that format. However,
 * what is between, before, and after can be changed. The link itself will be
 * HTML.
 *
 * This function is used internally by wp_list_bookmarks() and should not be
 * used by themes.
 *
<<<<<<< HEAD
 * The defaults for overwriting are:
 * 'show_updated' - Default is 0 (integer). Will show the time of when the
 *		bookmark was last updated.
 * 'show_description' - Default is 0 (integer). Whether to show the description
 *		of the bookmark.
 * 'show_images' - Default is 1 (integer). Whether to show link image if
 *		available.
 * 'show_name' - Default is 0 (integer). Whether to show link name if
 *		available.
 * 'before' - Default is '<li>' (string). The html or text to prepend to each
 *		bookmarks.
 * 'after' - Default is '</li>' (string). The html or text to append to each
 *		bookmarks.
 * 'link_before' - Default is '' (string). The html or text to prepend to each
 *		bookmarks inside the <a> tag.
 * 'link_after' - Default is '' (string). The html or text to append to each
 *		bookmarks inside the <a> tag.
 * 'between' - Default is '\n' (string). The string for use in between the link,
 *		description, and image.
 * 'show_rating' - Default is 0 (integer). Whether to show the link rating.
 *
 * @since 2.1.0
 * @access private
 *
 * @param array $bookmarks List of bookmarks to traverse
 * @param string|array $args Optional. Overwrite the defaults.
 * @return string Formatted output in HTML
 */
function _walk_bookmarks($bookmarks, $args = '' ) {
=======
 * @since 2.1.0
 * @access private
 *
 * @param array $bookmarks List of bookmarks to traverse.
 * @param string|array $args {
 *     Optional. Bookmarks arguments.
 *
 *     @type int|bool $show_updated     Whether to show the time the bookmark was last updated.
 *                                      Accepts 1|true or 0|false. Default 0|false.
 *     @type int|bool $show_description Whether to show the bookmakr description. Accepts 1|true,
 *                                      Accepts 1|true or 0|false. Default 0|false.
 *     @type int|bool $show_images      Whether to show the link image if available. Accepts 1|true
 *                                      or 0|false. Default 1|true.
 *     @type int|bool $show_name        Whether to show link name if available. Accepts 1|true or
 *                                      0|false. Default 0|false.
 *     @type string   $before           The HTML or text to prepend to each bookmark. Default `<li>`.
 *     @type string   $after            The HTML or text to append to each bookmark. Default `</li>`.
 *     @type string   $link_before      The HTML or text to prepend to each bookmark inside the anchor
 *                                      tags. Default empty.
 *     @type string   $link_after       The HTML or text to append to each bookmark inside the anchor
 *                                      tags. Default empty.
 *     @type string   $between          The string for use in between the link, description, and image.
 *                                      Default "\n".
 *     @type int|bool $show_rating      Whether to show the link rating. Accepts 1|true or 0|false.
 *                                      Default 0|false.
 *
 * }
 * @return string Formatted output in HTML
 */
function _walk_bookmarks( $bookmarks, $args = '' ) {
>>>>>>> WPHome/master
	$defaults = array(
		'show_updated' => 0, 'show_description' => 0,
		'show_images' => 1, 'show_name' => 0,
		'before' => '<li>', 'after' => '</li>', 'between' => "\n",
		'show_rating' => 0, 'link_before' => '', 'link_after' => ''
	);

	$r = wp_parse_args( $args, $defaults );
<<<<<<< HEAD
	extract( $r, EXTR_SKIP );
=======
>>>>>>> WPHome/master

	$output = ''; // Blank string to start with.

	foreach ( (array) $bookmarks as $bookmark ) {
<<<<<<< HEAD
		if ( !isset($bookmark->recently_updated) )
			$bookmark->recently_updated = false;
		$output .= $before;
		if ( $show_updated && $bookmark->recently_updated )
			$output .= get_option('links_recently_updated_prepend');

		$the_link = '#';
		if ( !empty($bookmark->link_url) )
			$the_link = esc_url($bookmark->link_url);

		$desc = esc_attr(sanitize_bookmark_field('link_description', $bookmark->link_description, $bookmark->link_id, 'display'));
		$name = esc_attr(sanitize_bookmark_field('link_name', $bookmark->link_name, $bookmark->link_id, 'display'));
 		$title = $desc;

		if ( $show_updated )
			if ( '00' != substr($bookmark->link_updated_f, 0, 2) ) {
				$title .= ' (';
				$title .= sprintf(__('Last updated: %s'), date(get_option('links_updated_date_format'), $bookmark->link_updated_f + (get_option('gmt_offset') * HOUR_IN_SECONDS)));
				$title .= ')';
			}

		$alt = ' alt="' . $name . ( $show_description ? ' ' . $title : '' ) . '"';

		if ( '' != $title )
			$title = ' title="' . $title . '"';

		$rel = $bookmark->link_rel;
		if ( '' != $rel )
			$rel = ' rel="' . esc_attr($rel) . '"';

		$target = $bookmark->link_target;
		if ( '' != $target )
			$target = ' target="' . $target . '"';

		$output .= '<a href="' . $the_link . '"' . $rel . $title . $target . '>';

		$output .= $link_before;

		if ( $bookmark->link_image != null && $show_images ) {
			if ( strpos($bookmark->link_image, 'http') === 0 )
				$output .= "<img src=\"$bookmark->link_image\" $alt $title />";
			else // If it's a relative path
				$output .= "<img src=\"" . get_option('siteurl') . "$bookmark->link_image\" $alt $title />";

			if ( $show_name )
				$output .= " $name";
=======
		if ( ! isset( $bookmark->recently_updated ) ) {
			$bookmark->recently_updated = false;
		}
		$output .= $r['before'];
		if ( $r['show_updated'] && $bookmark->recently_updated ) {
			$output .= '<em>';
		}
		$the_link = '#';
		if ( ! empty( $bookmark->link_url ) ) {
			$the_link = esc_url( $bookmark->link_url );
		}
		$desc = esc_attr( sanitize_bookmark_field( 'link_description', $bookmark->link_description, $bookmark->link_id, 'display' ) );
		$name = esc_attr( sanitize_bookmark_field( 'link_name', $bookmark->link_name, $bookmark->link_id, 'display' ) );
 		$title = $desc;

		if ( $r['show_updated'] ) {
			if ( '00' != substr( $bookmark->link_updated_f, 0, 2 ) ) {
				$title .= ' (';
				$title .= sprintf(
					__('Last updated: %s'),
					date(
						get_option( 'links_updated_date_format' ),
						$bookmark->link_updated_f + ( get_option( 'gmt_offset' ) * HOUR_IN_SECONDS )
					)
				);
				$title .= ')';
			}
		}
		$alt = ' alt="' . $name . ( $r['show_description'] ? ' ' . $title : '' ) . '"';

		if ( '' != $title ) {
			$title = ' title="' . $title . '"';
		}
		$rel = $bookmark->link_rel;
		if ( '' != $rel ) {
			$rel = ' rel="' . esc_attr($rel) . '"';
		}
		$target = $bookmark->link_target;
		if ( '' != $target ) {
			$target = ' target="' . $target . '"';
		}
		$output .= '<a href="' . $the_link . '"' . $rel . $title . $target . '>';

		$output .= $r['link_before'];

		if ( $bookmark->link_image != null && $r['show_images'] ) {
			if ( strpos( $bookmark->link_image, 'http' ) === 0 ) {
				$output .= "<img src=\"$bookmark->link_image\" $alt $title />";
			} else { // If it's a relative path
				$output .= "<img src=\"" . get_option('siteurl') . "$bookmark->link_image\" $alt $title />";
			}
			if ( $r['show_name'] ) {
				$output .= " $name";
			}
>>>>>>> WPHome/master
		} else {
			$output .= $name;
		}

<<<<<<< HEAD
		$output .= $link_after;

		$output .= '</a>';

		if ( $show_updated && $bookmark->recently_updated )
			$output .= get_option('links_recently_updated_append');

		if ( $show_description && '' != $desc )
			$output .= $between . $desc;

		if ( $show_rating )
			$output .= $between . sanitize_bookmark_field('link_rating', $bookmark->link_rating, $bookmark->link_id, 'display');

		$output .= "$after\n";
=======
		$output .= $r['link_after'];

		$output .= '</a>';

		if ( $r['show_updated'] && $bookmark->recently_updated ) {
			$output .= '</em>';
		}

		if ( $r['show_description'] && '' != $desc ) {
			$output .= $r['between'] . $desc;
		}

		if ( $r['show_rating'] ) {
			$output .= $r['between'] . sanitize_bookmark_field(
				'link_rating',
				$bookmark->link_rating,
				$bookmark->link_id,
				'display'
			);
		}
		$output .= $r['after'] . "\n";
>>>>>>> WPHome/master
	} // end while

	return $output;
}

/**
 * Retrieve or echo all of the bookmarks.
 *
 * List of default arguments are as follows:
<<<<<<< HEAD
 * 'orderby' - Default is 'name' (string). How to order the links by. String is
 *		based off of the bookmark scheme.
 * 'order' - Default is 'ASC' (string). Either 'ASC' or 'DESC'. Orders in either
 *		ascending or descending order.
 * 'limit' - Default is -1 (integer) or show all. The amount of bookmarks to
 *		display.
 * 'category' - Default is empty string (string). Include the links in what
 *		category ID(s).
 * 'category_name' - Default is empty string (string). Get links by category
 *		name.
 * 'hide_invisible' - Default is 1 (integer). Whether to show (default) or hide
 *		links marked as 'invisible'.
 * 'show_updated' - Default is 0 (integer). Will show the time of when the
 *		bookmark was last updated.
 * 'echo' - Default is 1 (integer). Whether to echo (default) or return the
 *		formatted bookmarks.
 * 'categorize' - Default is 1 (integer). Whether to show links listed by
 *		category (default) or show links in one column.
 * 'show_description' - Default is 0 (integer). Whether to show the description
 *		of the bookmark.
=======
>>>>>>> WPHome/master
 *
 * These options define how the Category name will appear before the category
 * links are displayed, if 'categorize' is 1. If 'categorize' is 0, then it will
 * display for only the 'title_li' string and only if 'title_li' is not empty.
<<<<<<< HEAD
 * 'title_li' - Default is 'Bookmarks' (translatable string). What to show
 *		before the links appear.
 * 'title_before' - Default is '<h2>' (string). The HTML or text to show before
 *		the 'title_li' string.
 * 'title_after' - Default is '</h2>' (string). The HTML or text to show after
 *		the 'title_li' string.
 * 'class' - Default is 'linkcat' (string). The CSS class to use for the
 *		'title_li'.
 *
 * 'category_before' - Default is '<li id="%id" class="%class">'. String must
 *		contain '%id' and '%class' to get
 * the id of the category and the 'class' argument. These are used for
 *		formatting in themes.
 * Argument will be displayed before the 'title_before' argument.
 * 'category_after' - Default is '</li>' (string). The HTML or text that will
 *		appear after the list of links.
 *
 * These are only used if 'categorize' is set to 1 or true.
 * 'category_orderby' - Default is 'name'. How to order the bookmark category
 *		based on term scheme.
 * 'category_order' - Default is 'ASC'. Set the order by either ASC (ascending)
 *		or DESC (descending).
 *
 * @see _walk_bookmarks() For other arguments that can be set in this function
 *		and passed to _walk_bookmarks().
 * @see get_bookmarks() For other arguments that can be set in this function and
 *		passed to get_bookmarks().
 * @link http://codex.wordpress.org/Template_Tags/wp_list_bookmarks
 *
 * @since 2.1.0
 * @uses _walk_bookmarks() Used to iterate over all of the bookmarks and return
 *		the html
 * @uses get_terms() Gets all of the categories that are for links.
 *
 * @param string|array $args Optional. Overwrite the defaults of the function
 * @return string|null Will only return if echo option is set to not echo.
 *		Default is not return anything.
 */
function wp_list_bookmarks($args = '') {
=======
 *
 * @since 2.1.0
 *
 * @see _walk_bookmarks()
 *
 * @param string|array $args {
 *     Optional. String or array of arguments to list bookmarks.
 *
 *     @type string   $orderby          How to order the links by. Accepts post fields. Default 'name'.
 *     @type string   $order            Whether to order bookmarks in ascending or descending order.
 *                                      Accepts 'ASC' (ascending) or 'DESC' (descending). Default 'ASC'.
 *     @type int      $limit            Amount of bookmarks to display. Accepts 1+ or -1 for all.
 *                                      Default -1.
 *     @type string   $category         Comma-separated list of category ids to include links from.
 *                                      Default empty.
 *     @type string   $category_name    Category to retrieve links for by name. Default empty.
 *     @type int|bool $hide_invisible   Whether to show or hide links marked as 'invisible'. Accepts
 *                                      1|true or 0|false. Default 1|true.
 *     @type int|bool $show_updated     Whether to display the time the bookmark was last updated.
 *                                      Accepts 1|true or 0|false. Default 0|false.
 *     @type int|bool $echo             Whether to echo or return the formatted bookmarks. Accepts
 *                                      1|true (echo) or 0|false (return). Default 1|true.
 *     @type int|bool $categorize       Whether to show links listed by category or in a single column.
 *                                      Accepts 1|true (by category) or 0|false (one column). Default 1|true.
 *     @type int|bool $show_description Whether to show the bookmark descriptions. Accepts 1|true or 0|false.
 *                                      Default 0|false.
 *     @type string   $title_li         What to show before the links appear. Default 'Bookmarks'.
 *     @type string   $title_before     The HTML or text to prepend to the $title_li string. Default '<h2>'.
 *     @type string   $title_after      The HTML or text to append to the $title_li string. Default '</h2>'.
 *     @type string   $class            The CSS class to use for the $title_li. Default 'linkcat'.
 *     @type string   $category_before  The HTML or text to prepend to $title_before if $categorize is true.
 *                                      String must contain '%id' and '%class' to inherit the category ID and
 *                                      the $class argument used for formatting in themes.
 *                                      Default '<li id="%id" class="%class">'.
 *     @type string   $category_after   The HTML or text to append to $title_after if $categorize is true.
 *                                      Default '</li>'.
 *     @type string   $category_orderby How to order the bookmark category based on term scheme if $categorize
 *                                      is true. Default 'name'.
 *     @type string   $category_order   Whether to order categories in ascending or descending order if
 *                                      $categorize is true. Accepts 'ASC' (ascending) or 'DESC' (descending).
 *                                      Default 'ASC'.
 * }
 * @return string|null Will only return if echo option is set to not echo. Default is not return anything.
 */
function wp_list_bookmarks( $args = '' ) {
>>>>>>> WPHome/master
	$defaults = array(
		'orderby' => 'name', 'order' => 'ASC',
		'limit' => -1, 'category' => '', 'exclude_category' => '',
		'category_name' => '', 'hide_invisible' => 1,
		'show_updated' => 0, 'echo' => 1,
		'categorize' => 1, 'title_li' => __('Bookmarks'),
		'title_before' => '<h2>', 'title_after' => '</h2>',
		'category_orderby' => 'name', 'category_order' => 'ASC',
		'class' => 'linkcat', 'category_before' => '<li id="%id" class="%class">',
		'category_after' => '</li>'
	);

	$r = wp_parse_args( $args, $defaults );
<<<<<<< HEAD
	extract( $r, EXTR_SKIP );

	$output = '';

	if ( $categorize ) {
		$cats = get_terms( 'link_category', array( 'name__like' => $category_name, 'include' => $category, 'exclude' => $exclude_category, 'orderby' => $category_orderby, 'order' => $category_order, 'hierarchical' => 0 ) );
		if ( empty( $cats ) )
			$categorize = false;
	}

	if ( $categorize ) {
		// Split the bookmarks into ul's for each category
		foreach ( (array) $cats as $cat ) {
			$params = array_merge($r, array('category'=>$cat->term_id));
			$bookmarks = get_bookmarks($params);
			if ( empty($bookmarks) )
				continue;
			$output .= str_replace(array('%id', '%class'), array("linkcat-$cat->term_id", $class), $category_before);
			$catname = apply_filters( "link_category", $cat->name );
			$output .= "$title_before$catname$title_after\n\t<ul class='xoxo blogroll'>\n";
			$output .= _walk_bookmarks($bookmarks, $r);
			$output .= "\n\t</ul>\n$category_after\n";
		}
	} else {
		//output one single list using title_li for the title
		$bookmarks = get_bookmarks($r);

		if ( !empty($bookmarks) ) {
			if ( !empty( $title_li ) ){
				$output .= str_replace(array('%id', '%class'), array("linkcat-$category", $class), $category_before);
				$output .= "$title_before$title_li$title_after\n\t<ul class='xoxo blogroll'>\n";
				$output .= _walk_bookmarks($bookmarks, $r);
				$output .= "\n\t</ul>\n$category_after\n";
			} else {
				$output .= _walk_bookmarks($bookmarks, $r);
=======

	$output = '';

	if ( $r['categorize'] ) {
		$cats = get_terms( 'link_category', array(
			'name__like' => $r['category_name'],
			'include' => $r['category'],
			'exclude' => $r['exclude_category'],
			'orderby' => $r['category_orderby'],
			'order' => $r['category_order'],
			'hierarchical' => 0
		) );
		if ( empty( $cats ) ) {
			$r['categorize'] = false;
		}
	}

	if ( $r['categorize'] ) {
		// Split the bookmarks into ul's for each category
		foreach ( (array) $cats as $cat ) {
			$params = array_merge( $r, array( 'category' => $cat->term_id ) );
			$bookmarks = get_bookmarks( $params );
			if ( empty( $bookmarks ) ) {
				continue;
			}
			$output .= str_replace(
				array( '%id', '%class' ),
				array( "linkcat-$cat->term_id", $r['class'] ),
				$r['category_before']
			);
			/**
			 * Filter the bookmarks category name.
			 *
			 * @since 2.2.0
			 *
			 * @param string $cat_name The category name of bookmarks.
			 */
			$catname = apply_filters( 'link_category', $cat->name );

			$output .= $r['title_before'];
			$output .= $catname;
			$output .= $r['title_after'];
			$output .= "\n\t<ul class='xoxo blogroll'>\n";
			$output .= _walk_bookmarks( $bookmarks, $r );
			$output .= "\n\t</ul>\n";
			$output .= $r['category_after'] . "\n";
		}
	} else {
		//output one single list using title_li for the title
		$bookmarks = get_bookmarks( $r );

		if ( ! empty( $bookmarks ) ) {
			if ( ! empty( $r['title_li'] ) ) {
				$output .= str_replace(
					array( '%id', '%class' ),
					array( "linkcat-" . $r['category'], $r['class'] ),
					$r['category_before']
				);
				$output .= $r['title_before'];
				$output .= $r['title_li'];
				$output .= $r['title_after'];
				$output .= "\n\t<ul class='xoxo blogroll'>\n";
				$output .= _walk_bookmarks( $bookmarks, $r );
				$output .= "\n\t</ul>\n";
				$output .= $r['category_after'] . "\n";
			} else {
				$output .= _walk_bookmarks( $bookmarks, $r );
>>>>>>> WPHome/master
			}
		}
	}

<<<<<<< HEAD
	$output = apply_filters( 'wp_list_bookmarks', $output );

	if ( !$echo )
		return $output;
	echo $output;
=======
	/**
	 * Filter the bookmarks list before it is echoed or returned.
	 *
	 * @since 2.5.0
	 *
	 * @param string $html The HTML list of bookmarks.
	 */
	$html = apply_filters( 'wp_list_bookmarks', $output );

	if ( ! $r['echo'] ) {
		return $html;
	}
	echo $html;
>>>>>>> WPHome/master
}
