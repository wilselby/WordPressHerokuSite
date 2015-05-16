<?php
/**
<<<<<<< HEAD
 * Customize Setting Class.
=======
 * WordPress Customize Setting classes
>>>>>>> WPHome/master
 *
 * @package WordPress
 * @subpackage Customize
 * @since 3.4.0
 */
<<<<<<< HEAD
class WP_Customize_Setting {
	public $manager;
	public $id;

	public $type            = 'theme_mod';
	public $capability      = 'edit_theme_options';
=======

/**
 * Customize Setting class.
 *
 * Handles saving and sanitizing of settings.
 *
 * @since 3.4.0
 *
 * @see WP_Customize_Manager
 */
class WP_Customize_Setting {
	/**
	 * @access public
	 * @var WP_Customize_Manager
	 */
	public $manager;

	/**
	 * @access public
	 * @var string
	 */
	public $id;

	/**
	 * @access public
	 * @var string
	 */
	public $type = 'theme_mod';

	/**
	 * Capability required to edit this setting.
	 *
	 * @var string
	 */
	public $capability = 'edit_theme_options';

	/**
	 * Feature a theme is required to support to enable this setting.
	 *
	 * @access public
	 * @var string
	 */
>>>>>>> WPHome/master
	public $theme_supports  = '';
	public $default         = '';
	public $transport       = 'refresh';

<<<<<<< HEAD
	public $sanitize_callback    = '';
	public $sanitize_js_callback = '';

	protected $id_data = array();
	private $_post_value; // Cached, sanitized $_POST value.
=======
	/**
	 * Server-side sanitization callback for the setting's value.
	 *
	 * @var callback
	 */
	public $sanitize_callback    = '';
	public $sanitize_js_callback = '';

	/**
	 * Whether or not the setting is initially dirty when created.
	 *
	 * This is used to ensure that a setting will be sent from the pane to the
	 * preview when loading the Customizer. Normally a setting only is synced to
	 * the preview if it has been changed. This allows the setting to be sent
	 * from the start.
	 *
	 * @since 4.2.0
	 * @access public
	 * @var bool
	 */
	public $dirty = false;

	protected $id_data = array();
>>>>>>> WPHome/master

	/**
	 * Constructor.
	 *
<<<<<<< HEAD
	 * @since 3.4.0
	 *
	 * @param WP_Customize_Manager $manager
	 * @param string $id An specific ID of the setting. Can be a
	 *                   theme mod or option name.
	 * @param array $args Setting arguments.
	 * @return WP_Customize_Setting
	 */
	function __construct( $manager, $id, $args = array() ) {
		$keys = array_keys( get_class_vars( __CLASS__ ) );
=======
	 * Any supplied $args override class property defaults.
	 *
	 * @since 3.4.0
	 *
	 * @param WP_Customize_Manager $manager
	 * @param string               $id      An specific ID of the setting. Can be a
	 *                                      theme mod or option name.
	 * @param array                $args    Setting arguments.
	 */
	public function __construct( $manager, $id, $args = array() ) {
		$keys = array_keys( get_object_vars( $this ) );
>>>>>>> WPHome/master
		foreach ( $keys as $key ) {
			if ( isset( $args[ $key ] ) )
				$this->$key = $args[ $key ];
		}

		$this->manager = $manager;
		$this->id = $id;

		// Parse the ID for array keys.
		$this->id_data[ 'keys' ] = preg_split( '/\[/', str_replace( ']', '', $this->id ) );
		$this->id_data[ 'base' ] = array_shift( $this->id_data[ 'keys' ] );

		// Rebuild the ID.
		$this->id = $this->id_data[ 'base' ];
		if ( ! empty( $this->id_data[ 'keys' ] ) )
			$this->id .= '[' . implode( '][', $this->id_data[ 'keys' ] ) . ']';

		if ( $this->sanitize_callback )
			add_filter( "customize_sanitize_{$this->id}", $this->sanitize_callback, 10, 2 );

		if ( $this->sanitize_js_callback )
			add_filter( "customize_sanitize_js_{$this->id}", $this->sanitize_js_callback, 10, 2 );
<<<<<<< HEAD

		return $this;
	}

	/**
=======
	}

	/**
	 * The ID for the current blog when the preview() method was called.
	 *
	 * @since 4.2.0
	 * @access protected
	 * @var int
	 */
	protected $_previewed_blog_id;

	/**
	 * Return true if the current blog is not the same as the previewed blog.
	 *
	 * @since 4.2.0
	 * @access public
	 *
	 * @return bool|null Returns null if preview() has not been called yet.
	 */
	public function is_current_blog_previewed() {
		if ( ! isset( $this->_previewed_blog_id ) ) {
			return null;
		}
		return ( get_current_blog_id() === $this->_previewed_blog_id );
	}

	/**
	 * Original non-previewed value stored by the preview method.
	 *
	 * @see WP_Customize_Setting::preview()
	 * @since 4.1.1
	 * @var mixed
	 */
	protected $_original_value;

	/**
>>>>>>> WPHome/master
	 * Handle previewing the setting.
	 *
	 * @since 3.4.0
	 */
	public function preview() {
<<<<<<< HEAD
=======
		if ( ! isset( $this->_original_value ) ) {
			$this->_original_value = $this->value();
		}
		if ( ! isset( $this->_previewed_blog_id ) ) {
			$this->_previewed_blog_id = get_current_blog_id();
		}

>>>>>>> WPHome/master
		switch( $this->type ) {
			case 'theme_mod' :
				add_filter( 'theme_mod_' . $this->id_data[ 'base' ], array( $this, '_preview_filter' ) );
				break;
			case 'option' :
				if ( empty( $this->id_data[ 'keys' ] ) )
					add_filter( 'pre_option_' . $this->id_data[ 'base' ], array( $this, '_preview_filter' ) );
				else {
					add_filter( 'option_' . $this->id_data[ 'base' ], array( $this, '_preview_filter' ) );
					add_filter( 'default_option_' . $this->id_data[ 'base' ], array( $this, '_preview_filter' ) );
				}
				break;
			default :
<<<<<<< HEAD
				do_action( 'customize_preview_' . $this->id );
=======

				/**
				 * Fires when the {@see WP_Customize_Setting::preview()} method is called for settings
				 * not handled as theme_mods or options.
				 *
				 * The dynamic portion of the hook name, `$this->id`, refers to the setting ID.
				 *
				 * @since 3.4.0
				 *
				 * @param WP_Customize_Setting $this {@see WP_Customize_Setting} instance.
				 */
				do_action( "customize_preview_{$this->id}", $this );

				/**
				 * Fires when the {@see WP_Customize_Setting::preview()} method is called for settings
				 * not handled as theme_mods or options.
				 *
				 * The dynamic portion of the hook name, `$this->type`, refers to the setting type.
				 *
				 * @since 4.1.0
				 *
				 * @param WP_Customize_Setting $this {@see WP_Customize_Setting} instance.
				 */
				do_action( "customize_preview_{$this->type}", $this );
>>>>>>> WPHome/master
		}
	}

	/**
	 * Callback function to filter the theme mods and options.
	 *
<<<<<<< HEAD
=======
	 * If switch_to_blog() was called after the preview() method, and the current
	 * blog is now not the same blog, then this method does a no-op and returns
	 * the original value.
	 *
>>>>>>> WPHome/master
	 * @since 3.4.0
	 * @uses WP_Customize_Setting::multidimensional_replace()
	 *
	 * @param mixed $original Old value.
	 * @return mixed New or old value.
	 */
	public function _preview_filter( $original ) {
<<<<<<< HEAD
		return $this->multidimensional_replace( $original, $this->id_data[ 'keys' ], $this->post_value() );
	}

	/**
	 * Set the value of the parameter for a specific theme.
	 *
	 * @since 3.4.0
	 *
	 * @return bool False if cap check fails or value isn't set.
	 */
	public final function save() {
=======
		if ( ! $this->is_current_blog_previewed() ) {
			return $original;
		}

		$undefined = new stdClass(); // symbol hack
		$post_value = $this->post_value( $undefined );
		if ( $undefined === $post_value ) {
			$value = $this->_original_value;
		} else {
			$value = $post_value;
		}

		return $this->multidimensional_replace( $original, $this->id_data['keys'], $value );
	}

	/**
	 * Check user capabilities and theme supports, and then save
	 * the value of the setting.
	 *
	 * @since 3.4.0
	 *
	 * @return false|null False if cap check fails or value isn't set.
	 */
	final public function save() {
>>>>>>> WPHome/master
		$value = $this->post_value();

		if ( ! $this->check_capabilities() || ! isset( $value ) )
			return false;

<<<<<<< HEAD
		do_action( 'customize_save_' . $this->id_data[ 'base' ] );
=======
		/**
		 * Fires when the WP_Customize_Setting::save() method is called.
		 *
		 * The dynamic portion of the hook name, `$this->id_data['base']` refers to
		 * the base slug of the setting name.
		 *
		 * @since 3.4.0
		 *
		 * @param WP_Customize_Setting $this {@see WP_Customize_Setting} instance.
		 */
		do_action( 'customize_save_' . $this->id_data[ 'base' ], $this );
>>>>>>> WPHome/master

		$this->update( $value );
	}

	/**
<<<<<<< HEAD
	 * Fetches, validates, and sanitizes the $_POST value.
=======
	 * Fetch and sanitize the $_POST value for the setting.
>>>>>>> WPHome/master
	 *
	 * @since 3.4.0
	 *
	 * @param mixed $default A default value which is used as a fallback. Default is null.
	 * @return mixed The default value on failure, otherwise the sanitized value.
	 */
<<<<<<< HEAD
	public final function post_value( $default = null ) {
		if ( isset( $this->_post_value ) )
			return $this->_post_value;

		$result = $this->manager->post_value( $this );

		if ( isset( $result ) )
			return $this->_post_value = $result;
		else
			return $default;
=======
	final public function post_value( $default = null ) {
		return $this->manager->post_value( $this, $default );
>>>>>>> WPHome/master
	}

	/**
	 * Sanitize an input.
	 *
	 * @since 3.4.0
	 *
	 * @param mixed $value The value to sanitize.
	 * @return mixed Null if an input isn't valid, otherwise the sanitized value.
	 */
	public function sanitize( $value ) {
<<<<<<< HEAD
		$value = stripslashes_deep( $value );
=======
		$value = wp_unslash( $value );

		/**
		 * Filter a Customize setting value in un-slashed form.
		 *
		 * @since 3.4.0
		 *
		 * @param mixed                $value Value of the setting.
		 * @param WP_Customize_Setting $this  WP_Customize_Setting instance.
		 */
>>>>>>> WPHome/master
		return apply_filters( "customize_sanitize_{$this->id}", $value, $this );
	}

	/**
<<<<<<< HEAD
	 * Set the value of the parameter for a specific theme.
=======
	 * Save the value of the setting, using the related API.
>>>>>>> WPHome/master
	 *
	 * @since 3.4.0
	 *
	 * @param mixed $value The value to update.
	 * @return mixed The result of saving the value.
	 */
	protected function update( $value ) {
		switch( $this->type ) {
			case 'theme_mod' :
				return $this->_update_theme_mod( $value );
<<<<<<< HEAD
				break;
			case 'option' :
				return $this->_update_option( $value );
				break;
			default :
				return do_action( 'customize_update_' . $this->type, $value );
=======

			case 'option' :
				return $this->_update_option( $value );

			default :

				/**
				 * Fires when the {@see WP_Customize_Setting::update()} method is called for settings
				 * not handled as theme_mods or options.
				 *
				 * The dynamic portion of the hook name, `$this->type`, refers to the type of setting.
				 *
				 * @since 3.4.0
				 *
				 * @param mixed                $value Value of the setting.
				 * @param WP_Customize_Setting $this  WP_Customize_Setting instance.
				 */
				return do_action( 'customize_update_' . $this->type, $value, $this );
>>>>>>> WPHome/master
		}
	}

	/**
	 * Update the theme mod from the value of the parameter.
	 *
	 * @since 3.4.0
	 *
	 * @param mixed $value The value to update.
	 * @return mixed The result of saving the value.
	 */
	protected function _update_theme_mod( $value ) {
		// Handle non-array theme mod.
		if ( empty( $this->id_data[ 'keys' ] ) )
			return set_theme_mod( $this->id_data[ 'base' ], $value );

		// Handle array-based theme mod.
		$mods = get_theme_mod( $this->id_data[ 'base' ] );
		$mods = $this->multidimensional_replace( $mods, $this->id_data[ 'keys' ], $value );
		if ( isset( $mods ) )
			return set_theme_mod( $this->id_data[ 'base' ], $mods );
	}

	/**
<<<<<<< HEAD
	 * Update the theme mod from the value of the parameter.
=======
	 * Update the option from the value of the setting.
>>>>>>> WPHome/master
	 *
	 * @since 3.4.0
	 *
	 * @param mixed $value The value to update.
<<<<<<< HEAD
	 * @return mixed The result of saving the value.
=======
	 * @return bool|null The result of saving the value.
>>>>>>> WPHome/master
	 */
	protected function _update_option( $value ) {
		// Handle non-array option.
		if ( empty( $this->id_data[ 'keys' ] ) )
			return update_option( $this->id_data[ 'base' ], $value );

		// Handle array-based options.
		$options = get_option( $this->id_data[ 'base' ] );
		$options = $this->multidimensional_replace( $options, $this->id_data[ 'keys' ], $value );
		if ( isset( $options ) )
			return update_option( $this->id_data[ 'base' ], $options );
	}

	/**
<<<<<<< HEAD
	 * Fetch the value of the parameter for a specific theme.
	 *
	 * @since 3.4.0
	 *
	 * @return mixed The requested value.
	 */
	public function value() {
=======
	 * Fetch the value of the setting.
	 *
	 * @since 3.4.0
	 *
	 * @return mixed The value.
	 */
	public function value() {
		// Get the callback that corresponds to the setting type.
>>>>>>> WPHome/master
		switch( $this->type ) {
			case 'theme_mod' :
				$function = 'get_theme_mod';
				break;
			case 'option' :
				$function = 'get_option';
				break;
			default :
<<<<<<< HEAD
=======

				/**
				 * Filter a Customize setting value not handled as a theme_mod or option.
				 *
				 * The dynamic portion of the hook name, `$this->id_date['base']`, refers to
				 * the base slug of the setting name.
				 *
				 * For settings handled as theme_mods or options, see those corresponding
				 * functions for available hooks.
				 *
				 * @since 3.4.0
				 *
				 * @param mixed $default The setting default value. Default empty.
				 */
>>>>>>> WPHome/master
				return apply_filters( 'customize_value_' . $this->id_data[ 'base' ], $this->default );
		}

		// Handle non-array value
		if ( empty( $this->id_data[ 'keys' ] ) )
			return $function( $this->id_data[ 'base' ], $this->default );

		// Handle array-based value
		$values = $function( $this->id_data[ 'base' ] );
		return $this->multidimensional_get( $values, $this->id_data[ 'keys' ], $this->default );
	}

	/**
<<<<<<< HEAD
	 * Escape the parameter's value for use in JavaScript.
=======
	 * Sanitize the setting's value for use in JavaScript.
>>>>>>> WPHome/master
	 *
	 * @since 3.4.0
	 *
	 * @return mixed The requested escaped value.
	 */
	public function js_value() {
<<<<<<< HEAD
=======

		/**
		 * Filter a Customize setting value for use in JavaScript.
		 *
		 * The dynamic portion of the hook name, `$this->id`, refers to the setting ID.
		 *
		 * @since 3.4.0
		 *
		 * @param mixed                $value The setting value.
		 * @param WP_Customize_Setting $this  {@see WP_Customize_Setting} instance.
		 */
>>>>>>> WPHome/master
		$value = apply_filters( "customize_sanitize_js_{$this->id}", $this->value(), $this );

		if ( is_string( $value ) )
			return html_entity_decode( $value, ENT_QUOTES, 'UTF-8');

		return $value;
	}

	/**
<<<<<<< HEAD
	 * Check if the theme supports the setting and check user capabilities.
=======
	 * Validate user capabilities whether the theme supports the setting.
>>>>>>> WPHome/master
	 *
	 * @since 3.4.0
	 *
	 * @return bool False if theme doesn't support the setting or user can't change setting, otherwise true.
	 */
<<<<<<< HEAD
	public final function check_capabilities() {
=======
	final public function check_capabilities() {
>>>>>>> WPHome/master
		if ( $this->capability && ! call_user_func_array( 'current_user_can', (array) $this->capability ) )
			return false;

		if ( $this->theme_supports && ! call_user_func_array( 'current_theme_supports', (array) $this->theme_supports ) )
			return false;

		return true;
	}

	/**
	 * Multidimensional helper function.
	 *
	 * @since 3.4.0
	 *
	 * @param $root
	 * @param $keys
	 * @param bool $create Default is false.
	 * @return null|array Keys are 'root', 'node', and 'key'.
	 */
	final protected function multidimensional( &$root, $keys, $create = false ) {
		if ( $create && empty( $root ) )
			$root = array();

		if ( ! isset( $root ) || empty( $keys ) )
			return;

		$last = array_pop( $keys );
		$node = &$root;

		foreach ( $keys as $key ) {
			if ( $create && ! isset( $node[ $key ] ) )
				$node[ $key ] = array();

			if ( ! is_array( $node ) || ! isset( $node[ $key ] ) )
				return;

			$node = &$node[ $key ];
		}

<<<<<<< HEAD
		if ( $create && ! isset( $node[ $last ] ) )
			$node[ $last ] = array();
=======
		if ( $create ) {
			if ( ! is_array( $node ) ) {
				// account for an array overriding a string or object value
				$node = array();
			}
			if ( ! isset( $node[ $last ] ) ) {
				$node[ $last ] = array();
			}
		}
>>>>>>> WPHome/master

		if ( ! isset( $node[ $last ] ) )
			return;

		return array(
			'root' => &$root,
			'node' => &$node,
			'key'  => $last,
		);
	}

	/**
	 * Will attempt to replace a specific value in a multidimensional array.
	 *
	 * @since 3.4.0
	 *
	 * @param $root
	 * @param $keys
	 * @param mixed $value The value to update.
	 * @return
	 */
	final protected function multidimensional_replace( $root, $keys, $value ) {
		if ( ! isset( $value ) )
			return $root;
		elseif ( empty( $keys ) ) // If there are no keys, we're replacing the root.
			return $value;

		$result = $this->multidimensional( $root, $keys, true );

		if ( isset( $result ) )
			$result['node'][ $result['key'] ] = $value;

		return $root;
	}

	/**
	 * Will attempt to fetch a specific value from a multidimensional array.
	 *
	 * @since 3.4.0
	 *
	 * @param $root
	 * @param $keys
<<<<<<< HEAD
	 * @param $default A default value which is used as a fallback. Default is null.
=======
	 * @param mixed $default A default value which is used as a fallback. Default is null.
>>>>>>> WPHome/master
	 * @return mixed The requested value or the default value.
	 */
	final protected function multidimensional_get( $root, $keys, $default = null ) {
		if ( empty( $keys ) ) // If there are no keys, test the root.
			return isset( $root ) ? $root : $default;

		$result = $this->multidimensional( $root, $keys );
		return isset( $result ) ? $result['node'][ $result['key'] ] : $default;
	}

	/**
	 * Will attempt to check if a specific value in a multidimensional array is set.
	 *
	 * @since 3.4.0
	 *
	 * @param $root
	 * @param $keys
	 * @return bool True if value is set, false if not.
	 */
	final protected function multidimensional_isset( $root, $keys ) {
		$result = $this->multidimensional_get( $root, $keys );
		return isset( $result );
	}
}

/**
 * A setting that is used to filter a value, but will not save the results.
 *
 * Results should be properly handled using another setting or callback.
 *
<<<<<<< HEAD
 * @package WordPress
 * @subpackage Customize
 * @since 3.4.0
=======
 * @since 3.4.0
 *
 * @see WP_Customize_Setting
>>>>>>> WPHome/master
 */
class WP_Customize_Filter_Setting extends WP_Customize_Setting {

	/**
	 * @since 3.4.0
	 */
	public function update( $value ) {}
}

/**
 * A setting that is used to filter a value, but will not save the results.
 *
 * Results should be properly handled using another setting or callback.
 *
<<<<<<< HEAD
 * @package WordPress
 * @subpackage Customize
 * @since 3.4.0
=======
 * @since 3.4.0
 *
 * @see WP_Customize_Setting
>>>>>>> WPHome/master
 */
final class WP_Customize_Header_Image_Setting extends WP_Customize_Setting {
	public $id = 'header_image_data';

	/**
	 * @since 3.4.0
	 *
	 * @param $value
	 */
	public function update( $value ) {
		global $custom_image_header;

		// If the value doesn't exist (removed or random),
		// use the header_image value.
		if ( ! $value )
			$value = $this->manager->get_setting('header_image')->post_value();

		if ( is_array( $value ) && isset( $value['choice'] ) )
			$custom_image_header->set_header_image( $value['choice'] );
		else
			$custom_image_header->set_header_image( $value );
	}
}

/**
<<<<<<< HEAD
 * @package WordPress
 * @subpackage Customize
 * @since 3.4.0
=======
 * Customizer Background Image Setting class.
 *
 * @since 3.4.0
 *
 * @see WP_Customize_Setting
>>>>>>> WPHome/master
 */
final class WP_Customize_Background_Image_Setting extends WP_Customize_Setting {
	public $id = 'background_image_thumb';

	/**
	 * @since 3.4.0
<<<<<<< HEAD
	 * @uses remove_theme_mod()
=======
>>>>>>> WPHome/master
	 *
	 * @param $value
	 */
	public function update( $value ) {
		remove_theme_mod( 'background_image_thumb' );
	}
}
