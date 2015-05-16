<?php
/**
 * WordPress Roles and Capabilities.
 *
 * @package WordPress
 * @subpackage User
 */

/**
 * WordPress User Roles.
 *
 * The role option is simple, the structure is organized by role name that store
 * the name in value of the 'name' key. The capabilities are stored as an array
 * in the value of the 'capability' key.
 *
<<<<<<< HEAD
 * <code>
 * array (
 *		'rolename' => array (
 *			'name' => 'rolename',
 *			'capabilities' => array()
 *		)
 * )
 * </code>
=======
 *     array (
 *    		'rolename' => array (
 *    			'name' => 'rolename',
 *    			'capabilities' => array()
 *    		)
 *     )
>>>>>>> WPHome/master
 *
 * @since 2.0.0
 * @package WordPress
 * @subpackage User
 */
class WP_Roles {
	/**
	 * List of roles and capabilities.
	 *
	 * @since 2.0.0
	 * @access public
	 * @var array
	 */
<<<<<<< HEAD
	var $roles;
=======
	public $roles;
>>>>>>> WPHome/master

	/**
	 * List of the role objects.
	 *
	 * @since 2.0.0
	 * @access public
	 * @var array
	 */
<<<<<<< HEAD
	var $role_objects = array();
=======
	public $role_objects = array();
>>>>>>> WPHome/master

	/**
	 * List of role names.
	 *
	 * @since 2.0.0
	 * @access public
	 * @var array
	 */
<<<<<<< HEAD
	var $role_names = array();
=======
	public $role_names = array();
>>>>>>> WPHome/master

	/**
	 * Option name for storing role list.
	 *
	 * @since 2.0.0
	 * @access public
	 * @var string
	 */
<<<<<<< HEAD
	var $role_key;
=======
	public $role_key;
>>>>>>> WPHome/master

	/**
	 * Whether to use the database for retrieval and storage.
	 *
	 * @since 2.1.0
	 * @access public
	 * @var bool
	 */
<<<<<<< HEAD
	var $use_db = true;
=======
	public $use_db = true;
>>>>>>> WPHome/master

	/**
	 * Constructor
	 *
	 * @since 2.0.0
	 */
<<<<<<< HEAD
	function __construct() {
=======
	public function __construct() {
>>>>>>> WPHome/master
		$this->_init();
	}

	/**
<<<<<<< HEAD
=======
	 * Make private/protected methods readable for backwards compatibility.
	 *
	 * @since 4.0.0
	 * @access public
	 *
	 * @param callable $name      Method to call.
	 * @param array    $arguments Arguments to pass when calling.
	 * @return mixed|bool Return value of the callback, false otherwise.
	 */
	public function __call( $name, $arguments ) {
		if ( '_init' === $name ) {
			return call_user_func_array( array( $this, $name ), $arguments );
		}
		return false;
	}

	/**
>>>>>>> WPHome/master
	 * Set up the object properties.
	 *
	 * The role key is set to the current prefix for the $wpdb object with
	 * 'user_roles' appended. If the $wp_user_roles global is set, then it will
	 * be used and the role option will not be updated or used.
	 *
	 * @since 2.1.0
	 * @access protected
<<<<<<< HEAD
	 * @uses $wpdb Used to get the database prefix.
	 * @global array $wp_user_roles Used to set the 'roles' property value.
	 */
	function _init () {
		global $wpdb, $wp_user_roles;
		$this->role_key = $wpdb->prefix . 'user_roles';
=======
	 *
	 * @global wpdb  $wpdb          WordPress database abstraction object.
	 * @global array $wp_user_roles Used to set the 'roles' property value.
	 */
	protected function _init() {
		global $wpdb, $wp_user_roles;
		$this->role_key = $wpdb->get_blog_prefix() . 'user_roles';
>>>>>>> WPHome/master
		if ( ! empty( $wp_user_roles ) ) {
			$this->roles = $wp_user_roles;
			$this->use_db = false;
		} else {
			$this->roles = get_option( $this->role_key );
		}

		if ( empty( $this->roles ) )
			return;

		$this->role_objects = array();
		$this->role_names =  array();
		foreach ( array_keys( $this->roles ) as $role ) {
			$this->role_objects[$role] = new WP_Role( $role, $this->roles[$role]['capabilities'] );
			$this->role_names[$role] = $this->roles[$role]['name'];
		}
	}

	/**
	 * Reinitialize the object
	 *
	 * Recreates the role objects. This is typically called only by switch_to_blog()
	 * after switching wpdb to a new blog ID.
	 *
	 * @since 3.5.0
	 * @access public
	 */
<<<<<<< HEAD
	function reinit() {
=======
	public function reinit() {
>>>>>>> WPHome/master
		// There is no need to reinit if using the wp_user_roles global.
		if ( ! $this->use_db )
			return;

<<<<<<< HEAD
		global $wpdb, $wp_user_roles;

		// Duplicated from _init() to avoid an extra function call.
		$this->role_key = $wpdb->prefix . 'user_roles';
=======
		global $wpdb;

		// Duplicated from _init() to avoid an extra function call.
		$this->role_key = $wpdb->get_blog_prefix() . 'user_roles';
>>>>>>> WPHome/master
		$this->roles = get_option( $this->role_key );
		if ( empty( $this->roles ) )
			return;

		$this->role_objects = array();
		$this->role_names =  array();
		foreach ( array_keys( $this->roles ) as $role ) {
			$this->role_objects[$role] = new WP_Role( $role, $this->roles[$role]['capabilities'] );
			$this->role_names[$role] = $this->roles[$role]['name'];
		}
	}

	/**
	 * Add role name with capabilities to list.
	 *
	 * Updates the list of roles, if the role doesn't already exist.
	 *
	 * The capabilities are defined in the following format `array( 'read' => true );`
	 * To explicitly deny a role a capability you set the value for that capability to false.
	 *
	 * @since 2.0.0
	 * @access public
	 *
	 * @param string $role Role name.
	 * @param string $display_name Role display name.
	 * @param array $capabilities List of role capabilities in the above format.
<<<<<<< HEAD
	 * @return null|WP_Role WP_Role object if role is added, null if already exists.
	 */
	function add_role( $role, $display_name, $capabilities = array() ) {
=======
	 * @return WP_Role|null WP_Role object if role is added, null if already exists.
	 */
	public function add_role( $role, $display_name, $capabilities = array() ) {
>>>>>>> WPHome/master
		if ( isset( $this->roles[$role] ) )
			return;

		$this->roles[$role] = array(
			'name' => $display_name,
			'capabilities' => $capabilities
			);
		if ( $this->use_db )
			update_option( $this->role_key, $this->roles );
		$this->role_objects[$role] = new WP_Role( $role, $capabilities );
		$this->role_names[$role] = $display_name;
		return $this->role_objects[$role];
	}

	/**
	 * Remove role by name.
	 *
	 * @since 2.0.0
	 * @access public
	 *
	 * @param string $role Role name.
	 */
<<<<<<< HEAD
	function remove_role( $role ) {
=======
	public function remove_role( $role ) {
>>>>>>> WPHome/master
		if ( ! isset( $this->role_objects[$role] ) )
			return;

		unset( $this->role_objects[$role] );
		unset( $this->role_names[$role] );
		unset( $this->roles[$role] );

		if ( $this->use_db )
			update_option( $this->role_key, $this->roles );
<<<<<<< HEAD
=======

		if ( get_option( 'default_role' ) == $role )
			update_option( 'default_role', 'subscriber' );
>>>>>>> WPHome/master
	}

	/**
	 * Add capability to role.
	 *
	 * @since 2.0.0
	 * @access public
	 *
	 * @param string $role Role name.
	 * @param string $cap Capability name.
	 * @param bool $grant Optional, default is true. Whether role is capable of performing capability.
	 */
<<<<<<< HEAD
	function add_cap( $role, $cap, $grant = true ) {
=======
	public function add_cap( $role, $cap, $grant = true ) {
>>>>>>> WPHome/master
		if ( ! isset( $this->roles[$role] ) )
			return;

		$this->roles[$role]['capabilities'][$cap] = $grant;
		if ( $this->use_db )
			update_option( $this->role_key, $this->roles );
	}

	/**
	 * Remove capability from role.
	 *
	 * @since 2.0.0
	 * @access public
	 *
	 * @param string $role Role name.
	 * @param string $cap Capability name.
	 */
<<<<<<< HEAD
	function remove_cap( $role, $cap ) {
=======
	public function remove_cap( $role, $cap ) {
>>>>>>> WPHome/master
		if ( ! isset( $this->roles[$role] ) )
			return;

		unset( $this->roles[$role]['capabilities'][$cap] );
		if ( $this->use_db )
			update_option( $this->role_key, $this->roles );
	}

	/**
	 * Retrieve role object by name.
	 *
	 * @since 2.0.0
	 * @access public
	 *
	 * @param string $role Role name.
<<<<<<< HEAD
	 * @return object|null Null, if role does not exist. WP_Role object, if found.
	 */
	function get_role( $role ) {
=======
	 * @return WP_Role|null WP_Role object if found, null if the role does not exist.
	 */
	public function get_role( $role ) {
>>>>>>> WPHome/master
		if ( isset( $this->role_objects[$role] ) )
			return $this->role_objects[$role];
		else
			return null;
	}

	/**
	 * Retrieve list of role names.
	 *
	 * @since 2.0.0
	 * @access public
	 *
	 * @return array List of role names.
	 */
<<<<<<< HEAD
	function get_names() {
=======
	public function get_names() {
>>>>>>> WPHome/master
		return $this->role_names;
	}

	/**
	 * Whether role name is currently in the list of available roles.
	 *
	 * @since 2.0.0
	 * @access public
	 *
	 * @param string $role Role name to look up.
	 * @return bool
	 */
<<<<<<< HEAD
	function is_role( $role ) {
=======
	public function is_role( $role ) {
>>>>>>> WPHome/master
		return isset( $this->role_names[$role] );
	}
}

/**
 * WordPress Role class.
 *
 * @since 2.0.0
 * @package WordPress
 * @subpackage User
 */
class WP_Role {
	/**
	 * Role name.
	 *
	 * @since 2.0.0
	 * @access public
	 * @var string
	 */
<<<<<<< HEAD
	var $name;
=======
	public $name;
>>>>>>> WPHome/master

	/**
	 * List of capabilities the role contains.
	 *
	 * @since 2.0.0
	 * @access public
	 * @var array
	 */
<<<<<<< HEAD
	var $capabilities;
=======
	public $capabilities;
>>>>>>> WPHome/master

	/**
	 * Constructor - Set up object properties.
	 *
	 * The list of capabilities, must have the key as the name of the capability
	 * and the value a boolean of whether it is granted to the role.
	 *
	 * @since 2.0.0
	 * @access public
	 *
	 * @param string $role Role name.
	 * @param array $capabilities List of capabilities.
	 */
<<<<<<< HEAD
	function __construct( $role, $capabilities ) {
=======
	public function __construct( $role, $capabilities ) {
>>>>>>> WPHome/master
		$this->name = $role;
		$this->capabilities = $capabilities;
	}

	/**
	 * Assign role a capability.
	 *
	 * @see WP_Roles::add_cap() Method uses implementation for role.
	 * @since 2.0.0
	 * @access public
	 *
	 * @param string $cap Capability name.
	 * @param bool $grant Whether role has capability privilege.
	 */
<<<<<<< HEAD
	function add_cap( $cap, $grant = true ) {
=======
	public function add_cap( $cap, $grant = true ) {
>>>>>>> WPHome/master
		global $wp_roles;

		if ( ! isset( $wp_roles ) )
			$wp_roles = new WP_Roles();

		$this->capabilities[$cap] = $grant;
		$wp_roles->add_cap( $this->name, $cap, $grant );
	}

	/**
	 * Remove capability from role.
	 *
	 * This is a container for {@link WP_Roles::remove_cap()} to remove the
	 * capability from the role. That is to say, that {@link
	 * WP_Roles::remove_cap()} implements the functionality, but it also makes
	 * sense to use this class, because you don't need to enter the role name.
	 *
	 * @since 2.0.0
	 * @access public
	 *
	 * @param string $cap Capability name.
	 */
<<<<<<< HEAD
	function remove_cap( $cap ) {
=======
	public function remove_cap( $cap ) {
>>>>>>> WPHome/master
		global $wp_roles;

		if ( ! isset( $wp_roles ) )
			$wp_roles = new WP_Roles();

		unset( $this->capabilities[$cap] );
		$wp_roles->remove_cap( $this->name, $cap );
	}

	/**
	 * Whether role has capability.
	 *
	 * The capabilities is passed through the 'role_has_cap' filter. The first
	 * parameter for the hook is the list of capabilities the class has
	 * assigned. The second parameter is the capability name to look for. The
	 * third and final parameter for the hook is the role name.
	 *
	 * @since 2.0.0
	 * @access public
	 *
	 * @param string $cap Capability name.
	 * @return bool True, if user has capability. False, if doesn't have capability.
	 */
<<<<<<< HEAD
	function has_cap( $cap ) {
=======
	public function has_cap( $cap ) {
		/**
		 * Filter which capabilities a role has.
		 *
		 * @since 2.0.0
		 *
		 * @param array  $capabilities Array of role capabilities.
		 * @param string $cap          Capability name.
		 * @param string $name         Role name.
		 */
>>>>>>> WPHome/master
		$capabilities = apply_filters( 'role_has_cap', $this->capabilities, $cap, $this->name );
		if ( !empty( $capabilities[$cap] ) )
			return $capabilities[$cap];
		else
			return false;
	}

}

/**
 * WordPress User class.
 *
 * @since 2.0.0
 * @package WordPress
 * @subpackage User
<<<<<<< HEAD
=======
 *
 * @property string $nickname
 * @property string $user_description
 * @property string $user_firstname
 * @property string $user_lastname
 * @property string $user_login
 * @property string $user_pass
 * @property string $user_nicename
 * @property string $user_email
 * @property string $user_url
 * @property string $user_registered
 * @property string $user_activation_key
 * @property string $user_status
 * @property string $display_name
 * @property string $spam
 * @property string $deleted
>>>>>>> WPHome/master
 */
class WP_User {
	/**
	 * User data container.
	 *
	 * @since 2.0.0
<<<<<<< HEAD
	 * @access private
	 * @var array
	 */
	var $data;
=======
	 * @var object
	 */
	public $data;
>>>>>>> WPHome/master

	/**
	 * The user's ID.
	 *
	 * @since 2.1.0
	 * @access public
	 * @var int
	 */
<<<<<<< HEAD
	var $ID = 0;
=======
	public $ID = 0;
>>>>>>> WPHome/master

	/**
	 * The individual capabilities the user has been given.
	 *
	 * @since 2.0.0
	 * @access public
	 * @var array
	 */
<<<<<<< HEAD
	var $caps = array();
=======
	public $caps = array();
>>>>>>> WPHome/master

	/**
	 * User metadata option name.
	 *
	 * @since 2.0.0
	 * @access public
	 * @var string
	 */
<<<<<<< HEAD
	var $cap_key;
=======
	public $cap_key;
>>>>>>> WPHome/master

	/**
	 * The roles the user is part of.
	 *
	 * @since 2.0.0
	 * @access public
	 * @var array
	 */
<<<<<<< HEAD
	var $roles = array();
=======
	public $roles = array();
>>>>>>> WPHome/master

	/**
	 * All capabilities the user has, including individual and role based.
	 *
	 * @since 2.0.0
	 * @access public
	 * @var array
	 */
<<<<<<< HEAD
	var $allcaps = array();
=======
	public $allcaps = array();
>>>>>>> WPHome/master

	/**
	 * The filter context applied to user data fields.
	 *
	 * @since 2.9.0
	 * @access private
	 * @var string
	 */
	var $filter = null;

	private static $back_compat_keys;

	/**
	 * Constructor
	 *
	 * Retrieves the userdata and passes it to {@link WP_User::init()}.
	 *
	 * @since 2.0.0
	 * @access public
	 *
	 * @param int|string|stdClass|WP_User $id User's ID, a WP_User object, or a user object from the DB.
	 * @param string $name Optional. User's username
	 * @param int $blog_id Optional Blog ID, defaults to current blog.
<<<<<<< HEAD
	 * @return WP_User
	 */
	function __construct( $id = 0, $name = '', $blog_id = '' ) {
=======
	 */
	public function __construct( $id = 0, $name = '', $blog_id = '' ) {
>>>>>>> WPHome/master
		if ( ! isset( self::$back_compat_keys ) ) {
			$prefix = $GLOBALS['wpdb']->prefix;
			self::$back_compat_keys = array(
				'user_firstname' => 'first_name',
				'user_lastname' => 'last_name',
				'user_description' => 'description',
				'user_level' => $prefix . 'user_level',
				$prefix . 'usersettings' => $prefix . 'user-settings',
				$prefix . 'usersettingstime' => $prefix . 'user-settings-time',
			);
		}

<<<<<<< HEAD
		if ( is_a( $id, 'WP_User' ) ) {
=======
		if ( $id instanceof WP_User ) {
>>>>>>> WPHome/master
			$this->init( $id->data, $blog_id );
			return;
		} elseif ( is_object( $id ) ) {
			$this->init( $id, $blog_id );
			return;
		}

		if ( ! empty( $id ) && ! is_numeric( $id ) ) {
			$name = $id;
			$id = 0;
		}

<<<<<<< HEAD
		if ( $id )
			$data = self::get_data_by( 'id', $id );
		else
			$data = self::get_data_by( 'login', $name );

		if ( $data )
			$this->init( $data, $blog_id );
=======
		if ( $id ) {
			$data = self::get_data_by( 'id', $id );
		} else {
			$data = self::get_data_by( 'login', $name );
		}

		if ( $data ) {
			$this->init( $data, $blog_id );
		} else {
			$this->data = new stdClass;
		}
>>>>>>> WPHome/master
	}

	/**
	 * Sets up object properties, including capabilities.
	 *
	 * @param object $data User DB row object
	 * @param int $blog_id Optional. The blog id to initialize for
	 */
<<<<<<< HEAD
	function init( $data, $blog_id = '' ) {
=======
	public function init( $data, $blog_id = '' ) {
>>>>>>> WPHome/master
		$this->data = $data;
		$this->ID = (int) $data->ID;

		$this->for_blog( $blog_id );
	}

	/**
	 * Return only the main user fields
	 *
	 * @since 3.3.0
	 *
	 * @param string $field The field to query against: 'id', 'slug', 'email' or 'login'
	 * @param string|int $value The field value
<<<<<<< HEAD
	 * @return object Raw user object
	 */
	static function get_data_by( $field, $value ) {
=======
	 * @return object|false Raw user object
	 */
	public static function get_data_by( $field, $value ) {
>>>>>>> WPHome/master
		global $wpdb;

		if ( 'id' == $field ) {
			// Make sure the value is numeric to avoid casting objects, for example,
			// to int 1.
			if ( ! is_numeric( $value ) )
				return false;
<<<<<<< HEAD
			$value = absint( $value );
=======
			$value = intval( $value );
			if ( $value < 1 )
				return false;
>>>>>>> WPHome/master
		} else {
			$value = trim( $value );
		}

		if ( !$value )
			return false;

		switch ( $field ) {
			case 'id':
				$user_id = $value;
				$db_field = 'ID';
				break;
			case 'slug':
				$user_id = wp_cache_get($value, 'userslugs');
				$db_field = 'user_nicename';
				break;
			case 'email':
				$user_id = wp_cache_get($value, 'useremail');
				$db_field = 'user_email';
				break;
			case 'login':
				$value = sanitize_user( $value );
				$user_id = wp_cache_get($value, 'userlogins');
				$db_field = 'user_login';
				break;
			default:
				return false;
		}

		if ( false !== $user_id ) {
			if ( $user = wp_cache_get( $user_id, 'users' ) )
				return $user;
		}

		if ( !$user = $wpdb->get_row( $wpdb->prepare(
			"SELECT * FROM $wpdb->users WHERE $db_field = %s", $value
		) ) )
			return false;

		update_user_caches( $user );

		return $user;
	}

	/**
	 * Magic method for checking the existence of a certain custom field
	 *
	 * @since 3.3.0
<<<<<<< HEAD
	 */
	function __isset( $key ) {
=======
	 * @param string $key
	 * @return bool
	 */
	public function __isset( $key ) {
>>>>>>> WPHome/master
		if ( 'id' == $key ) {
			_deprecated_argument( 'WP_User->id', '2.1', __( 'Use <code>WP_User->ID</code> instead.' ) );
			$key = 'ID';
		}

		if ( isset( $this->data->$key ) )
			return true;

		if ( isset( self::$back_compat_keys[ $key ] ) )
			$key = self::$back_compat_keys[ $key ];

		return metadata_exists( 'user', $this->ID, $key );
	}

	/**
	 * Magic method for accessing custom fields
	 *
	 * @since 3.3.0
<<<<<<< HEAD
	 */
	function __get( $key ) {
=======
	 * @param string $key
	 * @return mixed
	 */
	public function __get( $key ) {
>>>>>>> WPHome/master
		if ( 'id' == $key ) {
			_deprecated_argument( 'WP_User->id', '2.1', __( 'Use <code>WP_User->ID</code> instead.' ) );
			return $this->ID;
		}

		if ( isset( $this->data->$key ) ) {
			$value = $this->data->$key;
		} else {
			if ( isset( self::$back_compat_keys[ $key ] ) )
				$key = self::$back_compat_keys[ $key ];
			$value = get_user_meta( $this->ID, $key, true );
		}

		if ( $this->filter ) {
			$value = sanitize_user_field( $key, $value, $this->ID, $this->filter );
		}

		return $value;
	}

	/**
	 * Magic method for setting custom fields
	 *
	 * @since 3.3.0
	 */
<<<<<<< HEAD
	function __set( $key, $value ) {
=======
	public function __set( $key, $value ) {
>>>>>>> WPHome/master
		if ( 'id' == $key ) {
			_deprecated_argument( 'WP_User->id', '2.1', __( 'Use <code>WP_User->ID</code> instead.' ) );
			$this->ID = $value;
			return;
		}

		$this->data->$key = $value;
	}

	/**
	 * Determine whether the user exists in the database.
	 *
	 * @since 3.4.0
	 * @access public
	 *
	 * @return bool True if user exists in the database, false if not.
	 */
<<<<<<< HEAD
	function exists() {
=======
	public function exists() {
>>>>>>> WPHome/master
		return ! empty( $this->ID );
	}

	/**
	 * Retrieve the value of a property or meta key.
	 *
	 * Retrieves from the users and usermeta table.
	 *
	 * @since 3.3.0
	 *
	 * @param string $key Property
	 */
<<<<<<< HEAD
	function get( $key ) {
=======
	public function get( $key ) {
>>>>>>> WPHome/master
		return $this->__get( $key );
	}

	/**
	 * Determine whether a property or meta key is set
	 *
	 * Consults the users and usermeta tables.
	 *
	 * @since 3.3.0
	 *
	 * @param string $key Property
	 */
<<<<<<< HEAD
	function has_prop( $key ) {
		return $this->__isset( $key );
	}

	/*
=======
	public function has_prop( $key ) {
		return $this->__isset( $key );
	}

	/**
>>>>>>> WPHome/master
	 * Return an array representation.
	 *
	 * @since 3.5.0
	 *
	 * @return array Array representation.
	 */
<<<<<<< HEAD
	function to_array() {
=======
	public function to_array() {
>>>>>>> WPHome/master
		return get_object_vars( $this->data );
	}

	/**
	 * Set up capability object properties.
	 *
	 * Will set the value for the 'cap_key' property to current database table
	 * prefix, followed by 'capabilities'. Will then check to see if the
	 * property matching the 'cap_key' exists and is an array. If so, it will be
	 * used.
	 *
	 * @access protected
	 * @since 2.1.0
	 *
	 * @param string $cap_key Optional capability key
	 */
	function _init_caps( $cap_key = '' ) {
		global $wpdb;

		if ( empty($cap_key) )
<<<<<<< HEAD
			$this->cap_key = $wpdb->prefix . 'capabilities';
=======
			$this->cap_key = $wpdb->get_blog_prefix() . 'capabilities';
>>>>>>> WPHome/master
		else
			$this->cap_key = $cap_key;

		$this->caps = get_user_meta( $this->ID, $this->cap_key, true );

		if ( ! is_array( $this->caps ) )
			$this->caps = array();

		$this->get_role_caps();
	}

	/**
	 * Retrieve all of the role capabilities and merge with individual capabilities.
	 *
	 * All of the capabilities of the roles the user belongs to are merged with
	 * the users individual roles. This also means that the user can be denied
	 * specific roles that their role might have, but the specific user isn't
	 * granted permission to.
	 *
	 * @since 2.0.0
	 * @uses $wp_roles
	 * @access public
<<<<<<< HEAD
	 */
	function get_role_caps() {
=======
	 *
	 * @return array List of all capabilities for the user.
	 */
	public function get_role_caps() {
>>>>>>> WPHome/master
		global $wp_roles;

		if ( ! isset( $wp_roles ) )
			$wp_roles = new WP_Roles();

		//Filter out caps that are not role names and assign to $this->roles
		if ( is_array( $this->caps ) )
			$this->roles = array_filter( array_keys( $this->caps ), array( $wp_roles, 'is_role' ) );

		//Build $allcaps from role caps, overlay user's $caps
		$this->allcaps = array();
		foreach ( (array) $this->roles as $role ) {
			$the_role = $wp_roles->get_role( $role );
			$this->allcaps = array_merge( (array) $this->allcaps, (array) $the_role->capabilities );
		}
		$this->allcaps = array_merge( (array) $this->allcaps, (array) $this->caps );
<<<<<<< HEAD
=======

		return $this->allcaps;
>>>>>>> WPHome/master
	}

	/**
	 * Add role to user.
	 *
	 * Updates the user's meta data option with capabilities and roles.
	 *
	 * @since 2.0.0
	 * @access public
	 *
	 * @param string $role Role name.
	 */
<<<<<<< HEAD
	function add_role( $role ) {
=======
	public function add_role( $role ) {
>>>>>>> WPHome/master
		$this->caps[$role] = true;
		update_user_meta( $this->ID, $this->cap_key, $this->caps );
		$this->get_role_caps();
		$this->update_user_level_from_caps();
	}

	/**
	 * Remove role from user.
	 *
	 * @since 2.0.0
	 * @access public
	 *
	 * @param string $role Role name.
	 */
<<<<<<< HEAD
	function remove_role( $role ) {
=======
	public function remove_role( $role ) {
>>>>>>> WPHome/master
		if ( !in_array($role, $this->roles) )
			return;
		unset( $this->caps[$role] );
		update_user_meta( $this->ID, $this->cap_key, $this->caps );
		$this->get_role_caps();
		$this->update_user_level_from_caps();
	}

	/**
	 * Set the role of the user.
	 *
	 * This will remove the previous roles of the user and assign the user the
	 * new one. You can set the role to an empty string and it will remove all
	 * of the roles from the user.
	 *
	 * @since 2.0.0
	 * @access public
	 *
	 * @param string $role Role name.
	 */
<<<<<<< HEAD
	function set_role( $role ) {
=======
	public function set_role( $role ) {
>>>>>>> WPHome/master
		if ( 1 == count( $this->roles ) && $role == current( $this->roles ) )
			return;

		foreach ( (array) $this->roles as $oldrole )
			unset( $this->caps[$oldrole] );

<<<<<<< HEAD
=======
		$old_roles = $this->roles;
>>>>>>> WPHome/master
		if ( !empty( $role ) ) {
			$this->caps[$role] = true;
			$this->roles = array( $role => true );
		} else {
			$this->roles = false;
		}
		update_user_meta( $this->ID, $this->cap_key, $this->caps );
		$this->get_role_caps();
		$this->update_user_level_from_caps();
<<<<<<< HEAD
		do_action( 'set_user_role', $this->ID, $role );
=======

		/**
		 * Fires after the user's role has changed.
		 *
		 * @since 2.9.0
		 * @since 3.6.0 Added $old_roles to include an array of the user's previous roles.
		 *
		 * @param int    $user_id   The user ID.
		 * @param string $role      The new role.
		 * @param array  $old_roles An array of the user's previous roles.
		 */
		do_action( 'set_user_role', $this->ID, $role, $old_roles );
>>>>>>> WPHome/master
	}

	/**
	 * Choose the maximum level the user has.
	 *
	 * Will compare the level from the $item parameter against the $max
	 * parameter. If the item is incorrect, then just the $max parameter value
	 * will be returned.
	 *
	 * Used to get the max level based on the capabilities the user has. This
	 * is also based on roles, so if the user is assigned the Administrator role
	 * then the capability 'level_10' will exist and the user will get that
	 * value.
	 *
	 * @since 2.0.0
	 * @access public
	 *
	 * @param int $max Max level of user.
	 * @param string $item Level capability name.
	 * @return int Max Level.
	 */
<<<<<<< HEAD
	function level_reduction( $max, $item ) {
=======
	public function level_reduction( $max, $item ) {
>>>>>>> WPHome/master
		if ( preg_match( '/^level_(10|[0-9])$/i', $item, $matches ) ) {
			$level = intval( $matches[1] );
			return max( $max, $level );
		} else {
			return $max;
		}
	}

	/**
	 * Update the maximum user level for the user.
	 *
	 * Updates the 'user_level' user metadata (includes prefix that is the
	 * database table prefix) with the maximum user level. Gets the value from
	 * the all of the capabilities that the user has.
	 *
	 * @since 2.0.0
	 * @access public
	 */
<<<<<<< HEAD
	function update_user_level_from_caps() {
		global $wpdb;
		$this->user_level = array_reduce( array_keys( $this->allcaps ), array( $this, 'level_reduction' ), 0 );
		update_user_meta( $this->ID, $wpdb->prefix . 'user_level', $this->user_level );
=======
	public function update_user_level_from_caps() {
		global $wpdb;
		$this->user_level = array_reduce( array_keys( $this->allcaps ), array( $this, 'level_reduction' ), 0 );
		update_user_meta( $this->ID, $wpdb->get_blog_prefix() . 'user_level', $this->user_level );
>>>>>>> WPHome/master
	}

	/**
	 * Add capability and grant or deny access to capability.
	 *
	 * @since 2.0.0
	 * @access public
	 *
	 * @param string $cap Capability name.
	 * @param bool $grant Whether to grant capability to user.
	 */
<<<<<<< HEAD
	function add_cap( $cap, $grant = true ) {
		$this->caps[$cap] = $grant;
		update_user_meta( $this->ID, $this->cap_key, $this->caps );
=======
	public function add_cap( $cap, $grant = true ) {
		$this->caps[$cap] = $grant;
		update_user_meta( $this->ID, $this->cap_key, $this->caps );
		$this->get_role_caps();
		$this->update_user_level_from_caps();
>>>>>>> WPHome/master
	}

	/**
	 * Remove capability from user.
	 *
	 * @since 2.0.0
	 * @access public
	 *
	 * @param string $cap Capability name.
	 */
<<<<<<< HEAD
	function remove_cap( $cap ) {
		if ( ! isset( $this->caps[$cap] ) )
			return;
		unset( $this->caps[$cap] );
		update_user_meta( $this->ID, $this->cap_key, $this->caps );
=======
	public function remove_cap( $cap ) {
		if ( ! isset( $this->caps[ $cap ] ) ) {
			return;
		}
		unset( $this->caps[ $cap ] );
		update_user_meta( $this->ID, $this->cap_key, $this->caps );
		$this->get_role_caps();
		$this->update_user_level_from_caps();
>>>>>>> WPHome/master
	}

	/**
	 * Remove all of the capabilities of the user.
	 *
	 * @since 2.1.0
	 * @access public
	 */
<<<<<<< HEAD
	function remove_all_caps() {
		global $wpdb;
		$this->caps = array();
		delete_user_meta( $this->ID, $this->cap_key );
		delete_user_meta( $this->ID, $wpdb->prefix . 'user_level' );
=======
	public function remove_all_caps() {
		global $wpdb;
		$this->caps = array();
		delete_user_meta( $this->ID, $this->cap_key );
		delete_user_meta( $this->ID, $wpdb->get_blog_prefix() . 'user_level' );
>>>>>>> WPHome/master
		$this->get_role_caps();
	}

	/**
	 * Whether user has capability or role name.
	 *
	 * This is useful for looking up whether the user has a specific role
	 * assigned to the user. The second optional parameter can also be used to
	 * check for capabilities against a specific object, such as a post or user.
	 *
	 * @since 2.0.0
	 * @access public
	 *
	 * @param string|int $cap Capability or role name to search.
	 * @return bool True, if user has capability; false, if user does not have capability.
	 */
<<<<<<< HEAD
	function has_cap( $cap ) {
=======
	public function has_cap( $cap ) {
>>>>>>> WPHome/master
		if ( is_numeric( $cap ) ) {
			_deprecated_argument( __FUNCTION__, '2.0', __('Usage of user levels by plugins and themes is deprecated. Use roles and capabilities instead.') );
			$cap = $this->translate_level_to_cap( $cap );
		}

		$args = array_slice( func_get_args(), 1 );
		$args = array_merge( array( $cap, $this->ID ), $args );
		$caps = call_user_func_array( 'map_meta_cap', $args );

		// Multisite super admin has all caps by definition, Unless specifically denied.
		if ( is_multisite() && is_super_admin( $this->ID ) ) {
			if ( in_array('do_not_allow', $caps) )
				return false;
			return true;
		}

<<<<<<< HEAD
		// Must have ALL requested caps
		$capabilities = apply_filters( 'user_has_cap', $this->allcaps, $caps, $args );
=======
		/**
		 * Dynamically filter a user's capabilities.
		 *
		 * @since 2.0.0
		 * @since 3.7.0 Added the user object.
		 *
		 * @param array   $allcaps An array of all the user's capabilities.
		 * @param array   $caps    Actual capabilities for meta capability.
		 * @param array   $args    Optional parameters passed to has_cap(), typically object ID.
		 * @param WP_User $user    The user object.
		 */
		// Must have ALL requested caps
		$capabilities = apply_filters( 'user_has_cap', $this->allcaps, $caps, $args, $this );
>>>>>>> WPHome/master
		$capabilities['exist'] = true; // Everyone is allowed to exist
		foreach ( (array) $caps as $cap ) {
			if ( empty( $capabilities[ $cap ] ) )
				return false;
		}

		return true;
	}

	/**
	 * Convert numeric level to level capability name.
	 *
	 * Prepends 'level_' to level number.
	 *
	 * @since 2.0.0
	 * @access public
	 *
	 * @param int $level Level number, 1 to 10.
	 * @return string
	 */
<<<<<<< HEAD
	function translate_level_to_cap( $level ) {
=======
	public function translate_level_to_cap( $level ) {
>>>>>>> WPHome/master
		return 'level_' . $level;
	}

	/**
	 * Set the blog to operate on. Defaults to the current blog.
	 *
	 * @since 3.0.0
	 *
	 * @param int $blog_id Optional Blog ID, defaults to current blog.
	 */
<<<<<<< HEAD
	function for_blog( $blog_id = '' ) {
=======
	public function for_blog( $blog_id = '' ) {
>>>>>>> WPHome/master
		global $wpdb;
		if ( ! empty( $blog_id ) )
			$cap_key = $wpdb->get_blog_prefix( $blog_id ) . 'capabilities';
		else
			$cap_key = '';
		$this->_init_caps( $cap_key );
	}
}

/**
 * Map meta capabilities to primitive capabilities.
 *
 * This does not actually compare whether the user ID has the actual capability,
 * just what the capability or capabilities are. Meta capability list value can
 * be 'delete_user', 'edit_user', 'remove_user', 'promote_user', 'delete_post',
 * 'delete_page', 'edit_post', 'edit_page', 'read_post', or 'read_page'.
 *
 * @since 2.0.0
 *
 * @param string $cap Capability name.
 * @param int $user_id User ID.
 * @return array Actual capabilities for meta capability.
 */
function map_meta_cap( $cap, $user_id ) {
	$args = array_slice( func_get_args(), 2 );
	$caps = array();

	switch ( $cap ) {
	case 'remove_user':
		$caps[] = 'remove_users';
		break;
	case 'promote_user':
		$caps[] = 'promote_users';
		break;
	case 'edit_user':
	case 'edit_users':
		// Allow user to edit itself
		if ( 'edit_user' == $cap && isset( $args[0] ) && $user_id == $args[0] )
			break;

		// If multisite these caps are allowed only for super admins.
		if ( is_multisite() && !is_super_admin( $user_id ) )
			$caps[] = 'do_not_allow';
		else
			$caps[] = 'edit_users'; // edit_user maps to edit_users.
		break;
	case 'delete_post':
	case 'delete_page':
		$post = get_post( $args[0] );

		if ( 'revision' == $post->post_type ) {
			$post = get_post( $post->post_parent );
		}

		$post_type = get_post_type_object( $post->post_type );

		if ( ! $post_type->map_meta_cap ) {
			$caps[] = $post_type->cap->$cap;
			// Prior to 3.1 we would re-call map_meta_cap here.
			if ( 'delete_post' == $cap )
				$cap = $post_type->cap->$cap;
			break;
		}

<<<<<<< HEAD
		$post_author_id = $post->post_author;

		// If no author set yet, default to current user for cap checks.
		if ( ! $post_author_id )
			$post_author_id = $user_id;

		$post_author_data = $post_author_id == get_current_user_id() ? wp_get_current_user() : get_userdata( $post_author_id );

		// If the user is the author...
		if ( is_object( $post_author_data ) && $user_id == $post_author_data->ID ) {
=======
		// If the post author is set and the user is the author...
		if ( $post->post_author && $user_id == $post->post_author ) {
>>>>>>> WPHome/master
			// If the post is published...
			if ( 'publish' == $post->post_status ) {
				$caps[] = $post_type->cap->delete_published_posts;
			} elseif ( 'trash' == $post->post_status ) {
<<<<<<< HEAD
				if ('publish' == get_post_meta($post->ID, '_wp_trash_meta_status', true) )
					$caps[] = $post_type->cap->delete_published_posts;
=======
				if ( 'publish' == get_post_meta( $post->ID, '_wp_trash_meta_status', true ) ) {
					$caps[] = $post_type->cap->delete_published_posts;
				}
>>>>>>> WPHome/master
			} else {
				// If the post is draft...
				$caps[] = $post_type->cap->delete_posts;
			}
		} else {
			// The user is trying to edit someone else's post.
			$caps[] = $post_type->cap->delete_others_posts;
			// The post is published, extra cap required.
<<<<<<< HEAD
			if ( 'publish' == $post->post_status )
				$caps[] = $post_type->cap->delete_published_posts;
			elseif ( 'private' == $post->post_status )
				$caps[] = $post_type->cap->delete_private_posts;
=======
			if ( 'publish' == $post->post_status ) {
				$caps[] = $post_type->cap->delete_published_posts;
			} elseif ( 'private' == $post->post_status ) {
				$caps[] = $post_type->cap->delete_private_posts;
			}
>>>>>>> WPHome/master
		}
		break;
		// edit_post breaks down to edit_posts, edit_published_posts, or
		// edit_others_posts
	case 'edit_post':
	case 'edit_page':
		$post = get_post( $args[0] );
<<<<<<< HEAD
=======
		if ( empty( $post ) )
			break;
>>>>>>> WPHome/master

		if ( 'revision' == $post->post_type ) {
			$post = get_post( $post->post_parent );
		}

		$post_type = get_post_type_object( $post->post_type );

		if ( ! $post_type->map_meta_cap ) {
			$caps[] = $post_type->cap->$cap;
			// Prior to 3.1 we would re-call map_meta_cap here.
			if ( 'edit_post' == $cap )
				$cap = $post_type->cap->$cap;
			break;
		}

<<<<<<< HEAD
		$post_author_id = $post->post_author;

		// If no author set yet, default to current user for cap checks.
		if ( ! $post_author_id )
			$post_author_id = $user_id;

		$post_author_data = $post_author_id == get_current_user_id() ? wp_get_current_user() : get_userdata( $post_author_id );

		// If the user is the author...
		if ( is_object( $post_author_data ) && $user_id == $post_author_data->ID ) {
=======
		// If the post author is set and the user is the author...
		if ( $post->post_author && $user_id == $post->post_author ) {
>>>>>>> WPHome/master
			// If the post is published...
			if ( 'publish' == $post->post_status ) {
				$caps[] = $post_type->cap->edit_published_posts;
			} elseif ( 'trash' == $post->post_status ) {
<<<<<<< HEAD
				if ('publish' == get_post_meta($post->ID, '_wp_trash_meta_status', true) )
					$caps[] = $post_type->cap->edit_published_posts;
=======
				if ( 'publish' == get_post_meta( $post->ID, '_wp_trash_meta_status', true ) ) {
					$caps[] = $post_type->cap->edit_published_posts;
				}
>>>>>>> WPHome/master
			} else {
				// If the post is draft...
				$caps[] = $post_type->cap->edit_posts;
			}
		} else {
			// The user is trying to edit someone else's post.
			$caps[] = $post_type->cap->edit_others_posts;
			// The post is published, extra cap required.
<<<<<<< HEAD
			if ( 'publish' == $post->post_status )
				$caps[] = $post_type->cap->edit_published_posts;
			elseif ( 'private' == $post->post_status )
				$caps[] = $post_type->cap->edit_private_posts;
=======
			if ( 'publish' == $post->post_status ) {
				$caps[] = $post_type->cap->edit_published_posts;
			} elseif ( 'private' == $post->post_status ) {
				$caps[] = $post_type->cap->edit_private_posts;
			}
>>>>>>> WPHome/master
		}
		break;
	case 'read_post':
	case 'read_page':
		$post = get_post( $args[0] );

		if ( 'revision' == $post->post_type ) {
			$post = get_post( $post->post_parent );
		}

		$post_type = get_post_type_object( $post->post_type );

		if ( ! $post_type->map_meta_cap ) {
			$caps[] = $post_type->cap->$cap;
			// Prior to 3.1 we would re-call map_meta_cap here.
			if ( 'read_post' == $cap )
				$cap = $post_type->cap->$cap;
			break;
		}

		$status_obj = get_post_status_object( $post->post_status );
		if ( $status_obj->public ) {
			$caps[] = $post_type->cap->read;
			break;
		}

<<<<<<< HEAD
		$post_author_id = $post->post_author;

		// If no author set yet, default to current user for cap checks.
		if ( ! $post_author_id )
			$post_author_id = $user_id;

		$post_author_data = $post_author_id == get_current_user_id() ? wp_get_current_user() : get_userdata( $post_author_id );

		if ( is_object( $post_author_data ) && $user_id == $post_author_data->ID )
			$caps[] = $post_type->cap->read;
		elseif ( $status_obj->private )
			$caps[] = $post_type->cap->read_private_posts;
		else
			$caps = map_meta_cap( 'edit_post', $user_id, $post->ID );
=======
		if ( $post->post_author && $user_id == $post->post_author ) {
			$caps[] = $post_type->cap->read;
		} elseif ( $status_obj->private ) {
			$caps[] = $post_type->cap->read_private_posts;
		} else {
			$caps = map_meta_cap( 'edit_post', $user_id, $post->ID );
		}
>>>>>>> WPHome/master
		break;
	case 'publish_post':
		$post = get_post( $args[0] );
		$post_type = get_post_type_object( $post->post_type );

		$caps[] = $post_type->cap->publish_posts;
		break;
	case 'edit_post_meta':
	case 'delete_post_meta':
	case 'add_post_meta':
		$post = get_post( $args[0] );
<<<<<<< HEAD
		$post_type_object = get_post_type_object( $post->post_type );
		$caps = map_meta_cap( $post_type_object->cap->edit_post, $user_id, $post->ID );
=======
		$caps = map_meta_cap( 'edit_post', $user_id, $post->ID );
>>>>>>> WPHome/master

		$meta_key = isset( $args[ 1 ] ) ? $args[ 1 ] : false;

		if ( $meta_key && has_filter( "auth_post_meta_{$meta_key}" ) ) {
<<<<<<< HEAD
=======
			/**
			 * Filter whether the user is allowed to add post meta to a post.
			 *
			 * The dynamic portion of the hook name, `$meta_key`, refers to the
			 * meta key passed to {@see map_meta_cap()}.
			 *
			 * @since 3.3.0
			 *
			 * @param bool   $allowed  Whether the user can add the post meta. Default false.
			 * @param string $meta_key The meta key.
			 * @param int    $post_id  Post ID.
			 * @param int    $user_id  User ID.
			 * @param string $cap      Capability name.
			 * @param array  $caps     User capabilities.
			 */
>>>>>>> WPHome/master
			$allowed = apply_filters( "auth_post_meta_{$meta_key}", false, $meta_key, $post->ID, $user_id, $cap, $caps );
			if ( ! $allowed )
				$caps[] = $cap;
		} elseif ( $meta_key && is_protected_meta( $meta_key, 'post' ) ) {
			$caps[] = $cap;
		}
		break;
	case 'edit_comment':
		$comment = get_comment( $args[0] );
<<<<<<< HEAD
		$post = get_post( $comment->comment_post_ID );
		$post_type_object = get_post_type_object( $post->post_type );

		$caps = map_meta_cap( $post_type_object->cap->edit_post, $user_id, $post->ID );
=======
		if ( empty( $comment ) )
			break;
		$post = get_post( $comment->comment_post_ID );
		$caps = map_meta_cap( 'edit_post', $user_id, $post->ID );
>>>>>>> WPHome/master
		break;
	case 'unfiltered_upload':
		if ( defined('ALLOW_UNFILTERED_UPLOADS') && ALLOW_UNFILTERED_UPLOADS && ( !is_multisite() || is_super_admin( $user_id ) )  )
			$caps[] = $cap;
		else
			$caps[] = 'do_not_allow';
		break;
	case 'unfiltered_html' :
		// Disallow unfiltered_html for all users, even admins and super admins.
		if ( defined( 'DISALLOW_UNFILTERED_HTML' ) && DISALLOW_UNFILTERED_HTML )
			$caps[] = 'do_not_allow';
		elseif ( is_multisite() && ! is_super_admin( $user_id ) )
			$caps[] = 'do_not_allow';
		else
			$caps[] = $cap;
		break;
	case 'edit_files':
	case 'edit_plugins':
	case 'edit_themes':
		// Disallow the file editors.
		if ( defined( 'DISALLOW_FILE_EDIT' ) && DISALLOW_FILE_EDIT )
			$caps[] = 'do_not_allow';
		elseif ( defined( 'DISALLOW_FILE_MODS' ) && DISALLOW_FILE_MODS )
			$caps[] = 'do_not_allow';
		elseif ( is_multisite() && ! is_super_admin( $user_id ) )
			$caps[] = 'do_not_allow';
		else
			$caps[] = $cap;
		break;
	case 'update_plugins':
	case 'delete_plugins':
	case 'install_plugins':
<<<<<<< HEAD
	case 'update_themes':
	case 'delete_themes':
	case 'install_themes':
	case 'update_core':
		// Disallow anything that creates, deletes, or updates core, plugin, or theme files.
		// Files in uploads are excepted.
		if ( defined( 'DISALLOW_FILE_MODS' ) && DISALLOW_FILE_MODS )
			$caps[] = 'do_not_allow';
		elseif ( is_multisite() && ! is_super_admin( $user_id ) )
			$caps[] = 'do_not_allow';
		else
			$caps[] = $cap;
=======
	case 'upload_plugins':
	case 'update_themes':
	case 'delete_themes':
	case 'install_themes':
	case 'upload_themes':
	case 'update_core':
		// Disallow anything that creates, deletes, or updates core, plugin, or theme files.
		// Files in uploads are excepted.
		if ( defined( 'DISALLOW_FILE_MODS' ) && DISALLOW_FILE_MODS ) {
			$caps[] = 'do_not_allow';
		} elseif ( is_multisite() && ! is_super_admin( $user_id ) ) {
			$caps[] = 'do_not_allow';
		} elseif ( 'upload_themes' === $cap ) {
			$caps[] = 'install_themes';
		} elseif ( 'upload_plugins' === $cap ) {
			$caps[] = 'install_plugins';
		} else {
			$caps[] = $cap;
		}
>>>>>>> WPHome/master
		break;
	case 'activate_plugins':
		$caps[] = $cap;
		if ( is_multisite() ) {
			// update_, install_, and delete_ are handled above with is_super_admin().
			$menu_perms = get_site_option( 'menu_items', array() );
			if ( empty( $menu_perms['plugins'] ) )
				$caps[] = 'manage_network_plugins';
		}
		break;
	case 'delete_user':
	case 'delete_users':
		// If multisite only super admins can delete users.
		if ( is_multisite() && ! is_super_admin( $user_id ) )
			$caps[] = 'do_not_allow';
		else
			$caps[] = 'delete_users'; // delete_user maps to delete_users.
		break;
	case 'create_users':
		if ( !is_multisite() )
			$caps[] = $cap;
		elseif ( is_super_admin() || get_site_option( 'add_new_users' ) )
			$caps[] = $cap;
		else
			$caps[] = 'do_not_allow';
		break;
	case 'manage_links' :
		if ( get_option( 'link_manager_enabled' ) )
			$caps[] = $cap;
		else
			$caps[] = 'do_not_allow';
		break;
<<<<<<< HEAD
=======
	case 'customize' :
		$caps[] = 'edit_theme_options';
		break;
	case 'delete_site':
		$caps[] = 'manage_options';
		break;
>>>>>>> WPHome/master
	default:
		// Handle meta capabilities for custom post types.
		$post_type_meta_caps = _post_type_meta_capabilities();
		if ( isset( $post_type_meta_caps[ $cap ] ) ) {
			$args = array_merge( array( $post_type_meta_caps[ $cap ], $user_id ), $args );
			return call_user_func_array( 'map_meta_cap', $args );
		}

		// If no meta caps match, return the original cap.
		$caps[] = $cap;
	}

<<<<<<< HEAD
	return apply_filters('map_meta_cap', $caps, $cap, $user_id, $args);
=======
	/**
	 * Filter a user's capabilities depending on specific context and/or privilege.
	 *
	 * @since 2.8.0
	 *
	 * @param array  $caps    Returns the user's actual capabilities.
	 * @param string $cap     Capability name.
	 * @param int    $user_id The user ID.
	 * @param array  $args    Adds the context to the cap. Typically the object ID.
	 */
	return apply_filters( 'map_meta_cap', $caps, $cap, $user_id, $args );
>>>>>>> WPHome/master
}

/**
 * Whether current user has capability or role.
 *
 * @since 2.0.0
 *
 * @param string $capability Capability or role name.
 * @return bool
 */
function current_user_can( $capability ) {
	$current_user = wp_get_current_user();

	if ( empty( $current_user ) )
		return false;

	$args = array_slice( func_get_args(), 1 );
	$args = array_merge( array( $capability ), $args );

	return call_user_func_array( array( $current_user, 'has_cap' ), $args );
}

/**
 * Whether current user has a capability or role for a given blog.
 *
 * @since 3.0.0
 *
 * @param int $blog_id Blog ID
 * @param string $capability Capability or role name.
 * @return bool
 */
function current_user_can_for_blog( $blog_id, $capability ) {
<<<<<<< HEAD
	if ( is_multisite() )
		switch_to_blog( $blog_id );

	$current_user = wp_get_current_user();

	if ( empty( $current_user ) )
		return false;
=======
	$switched = is_multisite() ? switch_to_blog( $blog_id ) : false;

	$current_user = wp_get_current_user();

	if ( empty( $current_user ) ) {
		if ( $switched ) {
			restore_current_blog();
		}
		return false;
	}
>>>>>>> WPHome/master

	$args = array_slice( func_get_args(), 2 );
	$args = array_merge( array( $capability ), $args );

	$can = call_user_func_array( array( $current_user, 'has_cap' ), $args );

<<<<<<< HEAD
	if ( is_multisite() )
		restore_current_blog();
=======
	if ( $switched ) {
		restore_current_blog();
	}
>>>>>>> WPHome/master

	return $can;
}

/**
 * Whether author of supplied post has capability or role.
 *
 * @since 2.9.0
 *
 * @param int|object $post Post ID or post object.
 * @param string $capability Capability or role name.
 * @return bool
 */
function author_can( $post, $capability ) {
	if ( !$post = get_post($post) )
		return false;

	$author = get_userdata( $post->post_author );

	if ( ! $author )
		return false;

	$args = array_slice( func_get_args(), 2 );
	$args = array_merge( array( $capability ), $args );

	return call_user_func_array( array( $author, 'has_cap' ), $args );
}

/**
 * Whether a particular user has capability or role.
 *
 * @since 3.1.0
 *
 * @param int|object $user User ID or object.
 * @param string $capability Capability or role name.
 * @return bool
 */
function user_can( $user, $capability ) {
	if ( ! is_object( $user ) )
		$user = get_userdata( $user );

	if ( ! $user || ! $user->exists() )
		return false;

	$args = array_slice( func_get_args(), 2 );
	$args = array_merge( array( $capability ), $args );

	return call_user_func_array( array( $user, 'has_cap' ), $args );
}

/**
 * Retrieve role object.
 *
 * @see WP_Roles::get_role() Uses method to retrieve role object.
 * @since 2.0.0
 *
 * @param string $role Role name.
<<<<<<< HEAD
 * @return object
=======
 * @return WP_Role|null WP_Role object if found, null if the role does not exist.
>>>>>>> WPHome/master
 */
function get_role( $role ) {
	global $wp_roles;

	if ( ! isset( $wp_roles ) )
		$wp_roles = new WP_Roles();

	return $wp_roles->get_role( $role );
}

/**
 * Add role, if it does not exist.
 *
 * @see WP_Roles::add_role() Uses method to add role.
 * @since 2.0.0
 *
 * @param string $role Role name.
 * @param string $display_name Display name for role.
 * @param array $capabilities List of capabilities, e.g. array( 'edit_posts' => true, 'delete_posts' => false );
<<<<<<< HEAD
 * @return null|WP_Role WP_Role object if role is added, null if already exists.
=======
 * @return WP_Role|null WP_Role object if role is added, null if already exists.
>>>>>>> WPHome/master
 */
function add_role( $role, $display_name, $capabilities = array() ) {
	global $wp_roles;

	if ( ! isset( $wp_roles ) )
		$wp_roles = new WP_Roles();

	return $wp_roles->add_role( $role, $display_name, $capabilities );
}

/**
 * Remove role, if it exists.
 *
 * @see WP_Roles::remove_role() Uses method to remove role.
 * @since 2.0.0
 *
 * @param string $role Role name.
<<<<<<< HEAD
 * @return null
=======
>>>>>>> WPHome/master
 */
function remove_role( $role ) {
	global $wp_roles;

	if ( ! isset( $wp_roles ) )
		$wp_roles = new WP_Roles();

<<<<<<< HEAD
	return $wp_roles->remove_role( $role );
=======
	$wp_roles->remove_role( $role );
>>>>>>> WPHome/master
}

/**
 * Retrieve a list of super admins.
 *
 * @since 3.0.0
 *
 * @uses $super_admins Super admins global variable, if set.
 *
 * @return array List of super admin logins
 */
function get_super_admins() {
	global $super_admins;

	if ( isset($super_admins) )
		return $super_admins;
	else
		return get_site_option( 'site_admins', array('admin') );
}

/**
 * Determine if user is a site admin.
 *
 * @since 3.0.0
 *
 * @param int $user_id (Optional) The ID of a user. Defaults to the current user.
 * @return bool True if the user is a site admin.
 */
function is_super_admin( $user_id = false ) {
	if ( ! $user_id || $user_id == get_current_user_id() )
		$user = wp_get_current_user();
	else
		$user = get_userdata( $user_id );

	if ( ! $user || ! $user->exists() )
		return false;

	if ( is_multisite() ) {
		$super_admins = get_super_admins();
		if ( is_array( $super_admins ) && in_array( $user->user_login, $super_admins ) )
			return true;
	} else {
		if ( $user->has_cap('delete_users') )
			return true;
	}

	return false;
}
