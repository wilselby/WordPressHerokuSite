<?php
/**
 * WordPress Taxonomy Administration API.
 *
 * @package WordPress
 * @subpackage Administration
 */

//
// Category
//

/**
<<<<<<< HEAD
 * {@internal Missing Short Description}}
 *
 * @since 2.0.0
 *
 * @param unknown_type $cat_name
 * @return unknown
 */
function category_exists($cat_name, $parent = 0) {
=======
 * Check whether a category exists.
 *
 * @since 2.0.0
 *
 * @see term_exists()
 *
 * @param int|string $cat_name Category name.
 * @param int        $parent   Optional. ID of parent term.
 * @return mixed
 */
function category_exists( $cat_name, $parent = null ) {
>>>>>>> WPHome/master
	$id = term_exists($cat_name, 'category', $parent);
	if ( is_array($id) )
		$id = $id['term_id'];
	return $id;
}

/**
<<<<<<< HEAD
 * {@internal Missing Short Description}}
 *
 * @since 2.0.0
 *
 * @param unknown_type $id
 * @return unknown
 */
function get_category_to_edit( $id ) {
	$category = get_category( $id, OBJECT, 'edit' );
=======
 * Get category object for given ID and 'edit' filter context.
 *
 * @since 2.0.0
 *
 * @param int $id
 * @return object
 */
function get_category_to_edit( $id ) {
	$category = get_term( $id, 'category', OBJECT, 'edit' );
	_make_cat_compat( $category );
>>>>>>> WPHome/master
	return $category;
}

/**
<<<<<<< HEAD
 * {@internal Missing Short Description}}
 *
 * @since 2.0.0
 *
 * @param unknown_type $cat_name
 * @param unknown_type $parent
 * @return unknown
=======
 * Add a new category to the database if it does not already exist.
 *
 * @since 2.0.0
 *
 * @param int|string $cat_name
 * @param int        $parent
 * @return int|WP_Error
>>>>>>> WPHome/master
 */
function wp_create_category( $cat_name, $parent = 0 ) {
	if ( $id = category_exists($cat_name, $parent) )
		return $id;

	return wp_insert_category( array('cat_name' => $cat_name, 'category_parent' => $parent) );
}

/**
<<<<<<< HEAD
 * {@internal Missing Short Description}}
 *
 * @since 2.0.0
 *
 * @param unknown_type $categories
 * @param unknown_type $post_id
 * @return unknown
 */
function wp_create_categories($categories, $post_id = '') {
	$cat_ids = array ();
	foreach ($categories as $category) {
		if ($id = category_exists($category))
			$cat_ids[] = $id;
		else
			if ($id = wp_create_category($category))
				$cat_ids[] = $id;
=======
 * Create categories for the given post.
 *
 * @since 2.0.0
 *
 * @param array $categories List of categories to create.
 * @param int   $post_id    Optional. The post ID. Default empty.
 * @return List of categories to create for the given post.
 */
function wp_create_categories( $categories, $post_id = '' ) {
	$cat_ids = array ();
	foreach ( $categories as $category ) {
		if ( $id = category_exists( $category ) ) {
			$cat_ids[] = $id;
		} elseif ( $id = wp_create_category( $category ) ) {
			$cat_ids[] = $id;
		}
>>>>>>> WPHome/master
	}

	if ( $post_id )
		wp_set_post_categories($post_id, $cat_ids);

	return $cat_ids;
}

/**
 * Updates an existing Category or creates a new Category.
 *
 * @since 2.0.0
<<<<<<< HEAD
 *
 * @param mixed $catarr See defaults below. Set 'cat_ID' to a non-zero value to update an existing category. The 'taxonomy' key was added in 3.0.0.
 * @param bool $wp_error Optional, since 2.5.0. Set this to true if the caller handles WP_Error return values.
 * @return int|object The ID number of the new or updated Category on success. Zero or a WP_Error on failure, depending on param $wp_error.
 */
function wp_insert_category($catarr, $wp_error = false) {
	$cat_defaults = array('cat_ID' => 0, 'taxonomy' => 'category', 'cat_name' => '', 'category_description' => '', 'category_nicename' => '', 'category_parent' => '');
	$catarr = wp_parse_args($catarr, $cat_defaults);
	extract($catarr, EXTR_SKIP);

	if ( trim( $cat_name ) == '' ) {
		if ( ! $wp_error )
			return 0;
		else
			return new WP_Error( 'cat_name', __('You did not enter a category name.') );
	}

	$cat_ID = (int) $cat_ID;

	// Are we updating or creating?
	if ( !empty ($cat_ID) )
		$update = true;
	else
		$update = false;

	$name = $cat_name;
	$description = $category_description;
	$slug = $category_nicename;
	$parent = $category_parent;

	$parent = (int) $parent;
	if ( $parent < 0 )
		$parent = 0;

	if ( empty( $parent ) || ! term_exists( $parent, $taxonomy ) || ( $cat_ID && term_is_ancestor_of( $cat_ID, $parent, $taxonomy ) ) )
		$parent = 0;

	$args = compact('name', 'slug', 'parent', 'description');

	if ( $update )
		$cat_ID = wp_update_term($cat_ID, $taxonomy, $args);
	else
		$cat_ID = wp_insert_term($cat_name, $taxonomy, $args);

	if ( is_wp_error($cat_ID) ) {
		if ( $wp_error )
			return $cat_ID;
		else
			return 0;
	}

	return $cat_ID['term_id'];
=======
 * @since 2.5.0 $wp_error parameter was added.
 * @since 3.0.0 The 'taxonomy' argument was added.
 *
 * @param array $catarr {
 *     Array of arguments for inserting a new category.
 *
 *     @type int        $cat_ID               Categoriy ID. A non-zero value updates an existing category.
 *                                            Default 0.
 *     @type string     $taxonomy             Taxonomy slug. Defualt 'category'.
 *     @type string     $cat_nam              Category name. Default empty.
 *     @type string     $category_description Category description. Default empty.
 *     @type string     $category_nicename    Category nice (display) name. Default empty.
 *     @type int|string $category_parent      Category parent ID. Default empty.
 * }
 * @param bool  $wp_error Optional. Default false.
 * @return int|object The ID number of the new or updated Category on success. Zero or a WP_Error on failure,
 *                    depending on param $wp_error.
 */
function wp_insert_category( $catarr, $wp_error = false ) {
	$cat_defaults = array( 'cat_ID' => 0, 'taxonomy' => 'category', 'cat_name' => '', 'category_description' => '', 'category_nicename' => '', 'category_parent' => '' );
	$catarr = wp_parse_args( $catarr, $cat_defaults );

	if ( trim( $catarr['cat_name'] ) == '' ) {
		if ( ! $wp_error ) {
			return 0;
		} else {
			return new WP_Error( 'cat_name', __( 'You did not enter a category name.' ) );
		}
	}

	$catarr['cat_ID'] = (int) $catarr['cat_ID'];

	// Are we updating or creating?
	$update = ! empty ( $catarr['cat_ID'] );

	$name = $catarr['cat_name'];
	$description = $catarr['category_description'];
	$slug = $catarr['category_nicename'];
	$parent = (int) $catarr['category_parent'];
	if ( $parent < 0 ) {
		$parent = 0;
	}

	if ( empty( $parent )
		|| ! term_exists( $parent, $catarr['taxonomy'] )
		|| ( $catarr['cat_ID'] && term_is_ancestor_of( $catarr['cat_ID'], $parent, $catarr['taxonomy'] ) ) ) {
		$parent = 0;
	}

	$args = compact('name', 'slug', 'parent', 'description');

	if ( $update ) {
		$catarr['cat_ID'] = wp_update_term( $catarr['cat_ID'], $catarr['taxonomy'], $args );
	} else {
		$catarr['cat_ID'] = wp_insert_term( $catarr['cat_name'], $catarr['taxonomy'], $args );
	}

	if ( is_wp_error( $catarr['cat_ID'] ) ) {
		if ( $wp_error ) {
			return $catarr['cat_ID'];
		} else {
			return 0;
		}
	}
	return $catarr['cat_ID']['term_id'];
>>>>>>> WPHome/master
}

/**
 * Aliases wp_insert_category() with minimal args.
 *
 * If you want to update only some fields of an existing category, call this
 * function with only the new values set inside $catarr.
 *
 * @since 2.0.0
 *
 * @param array $catarr The 'cat_ID' value is required. All other keys are optional.
 * @return int|bool The ID number of the new or updated Category on success. Zero or FALSE on failure.
 */
function wp_update_category($catarr) {
	$cat_ID = (int) $catarr['cat_ID'];

	if ( isset($catarr['category_parent']) && ($cat_ID == $catarr['category_parent']) )
		return false;

	// First, get all of the original fields
<<<<<<< HEAD
	$category = get_category($cat_ID, ARRAY_A);

	// Escape data pulled from DB.
	$category = add_magic_quotes($category);
=======
	$category = get_term( $cat_ID, 'category', ARRAY_A );
	_make_cat_compat( $category );

	// Escape data pulled from DB.
	$category = wp_slash($category);
>>>>>>> WPHome/master

	// Merge old and new fields with new fields overwriting old ones.
	$catarr = array_merge($category, $catarr);

	return wp_insert_category($catarr);
}

//
// Tags
//

/**
<<<<<<< HEAD
 * {@internal Missing Short Description}}
 *
 * @since 2.3.0
 *
 * @param unknown_type $tag_name
 * @return unknown
=======
 * Check whether a post tag with a given name exists.
 *
 * @since 2.3.0
 *
 * @param int|string $tag_name
 * @return mixed
>>>>>>> WPHome/master
 */
function tag_exists($tag_name) {
	return term_exists($tag_name, 'post_tag');
}

/**
<<<<<<< HEAD
 * {@internal Missing Short Description}}
 *
 * @since 2.3.0
 *
 * @param unknown_type $tag_name
 * @return unknown
=======
 * Add a new tag to the database if it does not already exist.
 *
 * @since 2.3.0
 *
 * @param int|string $tag_name
 * @return array|WP_Error
>>>>>>> WPHome/master
 */
function wp_create_tag($tag_name) {
	return wp_create_term( $tag_name, 'post_tag');
}

/**
<<<<<<< HEAD
 * {@internal Missing Short Description}}
 *
 * @since 2.3.0
 *
 * @param unknown_type $post_id
 * @return unknown
=======
 * Get comma-separated list of tags available to edit.
 *
 * @since 2.3.0
 *
 * @param int    $post_id
 * @param string $taxonomy Optional. The taxonomy for which to retrieve terms. Default 'post_tag'.
 * @return string|bool|WP_Error
>>>>>>> WPHome/master
 */
function get_tags_to_edit( $post_id, $taxonomy = 'post_tag' ) {
	return get_terms_to_edit( $post_id, $taxonomy);
}

/**
<<<<<<< HEAD
 * {@internal Missing Short Description}}
 *
 * @since 2.8.0
 *
 * @param unknown_type $post_id
 * @return unknown
=======
 * Get comma-separated list of terms available to edit for the given post ID.
 *
 * @since 2.8.0
 *
 * @param int    $post_id
 * @param string $taxonomy Optional. The taxonomy for which to retrieve terms. Default 'post_tag'.
 * @return string|bool|WP_Error
>>>>>>> WPHome/master
 */
function get_terms_to_edit( $post_id, $taxonomy = 'post_tag' ) {
	$post_id = (int) $post_id;
	if ( !$post_id )
		return false;

<<<<<<< HEAD
	$tags = wp_get_post_terms($post_id, $taxonomy, array());

	if ( !$tags )
		return false;

	if ( is_wp_error($tags) )
		return $tags;

	foreach ( $tags as $tag )
		$tag_names[] = $tag->name;
	$tags_to_edit = join( ',', $tag_names );
	$tags_to_edit = esc_attr( $tags_to_edit );
	$tags_to_edit = apply_filters( 'terms_to_edit', $tags_to_edit, $taxonomy );

	return $tags_to_edit;
}

/**
 * {@internal Missing Short Description}}
 *
 * @since 2.8.0
 *
 * @param unknown_type $tag_name
 * @return unknown
=======
	$terms = get_object_term_cache( $post_id, $taxonomy );
	if ( false === $terms ) {
		$terms = wp_get_object_terms( $post_id, $taxonomy );
		wp_cache_add( $post_id, $terms, $taxonomy . '_relationships' );
	}

	if ( ! $terms ) {
		return false;
	}
	if ( is_wp_error( $terms ) ) {
		return $terms;
	}
	$term_names = array();
	foreach ( $terms as $term ) {
		$term_names[] = $term->name;
	}

	$terms_to_edit = esc_attr( join( ',', $term_names ) );

	/**
	 * Filter the comma-separated list of terms available to edit.
	 *
	 * @since 2.8.0
	 *
	 * @see get_terms_to_edit()
	 *
	 * @param array  $terms_to_edit An array of terms.
	 * @param string $taxonomy     The taxonomy for which to retrieve terms. Default 'post_tag'.
	 */
	$terms_to_edit = apply_filters( 'terms_to_edit', $terms_to_edit, $taxonomy );

	return $terms_to_edit;
}

/**
 * Add a new term to the database if it does not already exist.
 *
 * @since 2.8.0
 *
 * @param int|string $tag_name
 * @param string $taxonomy Optional. The taxonomy for which to retrieve terms. Default 'post_tag'.
 * @return array|WP_Error
>>>>>>> WPHome/master
 */
function wp_create_term($tag_name, $taxonomy = 'post_tag') {
	if ( $id = term_exists($tag_name, $taxonomy) )
		return $id;

	return wp_insert_term($tag_name, $taxonomy);
}
