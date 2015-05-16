<?php
/**
<<<<<<< HEAD
 * BackPress Scripts enqueue.
 *
 * These classes were refactored from the WordPress WP_Scripts and WordPress
 * script enqueue API.
 *
 * @package BackPress
 * @since r74
 */

/**
 * BackPress enqueued dependiences class.
=======
 * BackPress Scripts enqueue
 *
 * Classes were refactored from the WP_Scripts and WordPress script enqueue API.
 *
 * @since BackPress r74
>>>>>>> WPHome/master
 *
 * @package BackPress
 * @uses _WP_Dependency
 * @since r74
 */
class WP_Dependencies {
<<<<<<< HEAD
	var $registered = array();
	var $queue = array();
	var $to_do = array();
	var $done = array();
	var $args = array();
	var $groups = array();
	var $group = 0;

	/**
	 * Do the dependencies
	 *
	 * Process the items passed to it or the queue. Processes all dependencies.
	 *
	 * @param mixed $handles (optional) items to be processed. (void) processes queue, (string) process that item, (array of strings) process those items
	 * @return array Items that have been processed
	 */
	function do_items( $handles = false, $group = false ) {
		// Print the queue if nothing is passed. If a string is passed, print that script. If an array is passed, print those scripts.
=======
	/**
	 * An array of registered handle objects.
	 *
	 * @access public
	 * @since 2.6.8
	 * @var array
	 */
	public $registered = array();

	/**
	 * An array of queued _WP_Dependency handle objects.
	 *
	 * @access public
	 * @since 2.6.8
	 * @var array
	 */
	public $queue = array();

	/**
	 * An array of _WP_Dependency handle objects to queue.
	 *
	 * @access public
	 * @since 2.6.0
	 * @var array
	 */
	public $to_do = array();

	/**
	 * An array of _WP_Dependency handle objects already queued.
	 *
	 * @access public
	 * @since 2.6.0
	 * @var array
	 */
	public $done = array();

	/**
	 * An array of additional arguments passed when a handle is registered.
	 *
	 * Arguments are appended to the item query string.
	 *
	 * @access public
	 * @since 2.6.0
	 * @var array
	 */
	public $args = array();

	/**
	 * An array of handle groups to enqueue.
	 *
	 * @access public
	 * @since 2.8.0
	 * @var array
	 */
	public $groups = array();

	/**
	 * A handle group to enqueue.
	 *
	 * @access public
	 * @since 2.8.0
	 * @var int
	 */
	public $group = 0;

	/**
	 * Process the items and dependencies.
	 *
	 * Processes the items passed to it or the queue, and their dependencies.
	 *
	 * @access public
	 * @since 2.1.0
	 *
	 * @param mixed $handles Optional. Items to be processed: Process queue (false), process item (string), process items (array of strings).
	 * @param mixed $group   Group level: level (int), no groups (false).
	 * @return array Handles of items that have been processed.
	 */
	public function do_items( $handles = false, $group = false ) {
		/*
		 * If nothing is passed, print the queue. If a string is passed,
		 * print that item. If an array is passed, print those items.
		 */
>>>>>>> WPHome/master
		$handles = false === $handles ? $this->queue : (array) $handles;
		$this->all_deps( $handles );

		foreach( $this->to_do as $key => $handle ) {
			if ( !in_array($handle, $this->done, true) && isset($this->registered[$handle]) ) {

<<<<<<< HEAD
				if ( ! $this->registered[$handle]->src ) { // Defines a group.
=======
				/*
				 * A single item may alias a set of items, by having dependencies,
				 * but no source. Queuing the item queues the dependencies.
				 *
				 * Example: The extending class WP_Scripts is used to register 'scriptaculous' as a set of registered handles:
				 *   <code>add( 'scriptaculous', false, array( 'scriptaculous-dragdrop', 'scriptaculous-slider', 'scriptaculous-controls' ) );</code>
				 *
				 * The src property is false.
				 */
				if ( ! $this->registered[$handle]->src ) {
>>>>>>> WPHome/master
					$this->done[] = $handle;
					continue;
				}

<<<<<<< HEAD
=======
				/*
				 * Attempt to process the item. If successful,
				 * add the handle to the done array.
				 *
				 * Unset the item from the to_do array.
				 */
>>>>>>> WPHome/master
				if ( $this->do_item( $handle, $group ) )
					$this->done[] = $handle;

				unset( $this->to_do[$key] );
			}
		}

		return $this->done;
	}

<<<<<<< HEAD
	function do_item( $handle ) {
=======
	/**
	 * Process a dependency.
	 *
	 * @access public
	 * @since 2.6.0
	 *
	 * @param string $handle Name of the item. Should be unique.
	 * @return bool True on success, false if not set.
	 */
	public function do_item( $handle ) {
>>>>>>> WPHome/master
		return isset($this->registered[$handle]);
	}

	/**
<<<<<<< HEAD
	 * Determines dependencies
	 *
	 * Recursively builds array of items to process taking dependencies into account. Does NOT catch infinite loops.
	 *
	 *
	 * @param mixed $handles Accepts (string) dep name or (array of strings) dep names
	 * @param bool $recursion Used internally when function calls itself
	 */
	function all_deps( $handles, $recursion = false, $group = false ) {
=======
	 * Determine dependencies.
	 *
	 * Recursively builds an array of items to process taking
	 * dependencies into account. Does NOT catch infinite loops.
	 *
	 * @access public
	 * @since 2.1.0
	 *
	 * @param mixed $handles   Item handle and argument (string) or item handles and arguments (array of strings).
	 * @param bool  $recursion Internal flag that function is calling itself.
	 * @param mixed $group     Group level: (int) level, (false) no groups.
	 * @return bool True on success, false on failure.
	 */
	public function all_deps( $handles, $recursion = false, $group = false ) {
>>>>>>> WPHome/master
		if ( !$handles = (array) $handles )
			return false;

		foreach ( $handles as $handle ) {
			$handle_parts = explode('?', $handle);
			$handle = $handle_parts[0];
			$queued = in_array($handle, $this->to_do, true);

			if ( in_array($handle, $this->done, true) ) // Already done
				continue;

			$moved = $this->set_group( $handle, $recursion, $group );

			if ( $queued && !$moved ) // already queued and in the right group
				continue;

			$keep_going = true;
			if ( !isset($this->registered[$handle]) )
<<<<<<< HEAD
				$keep_going = false; // Script doesn't exist
			elseif ( $this->registered[$handle]->deps && array_diff($this->registered[$handle]->deps, array_keys($this->registered)) )
				$keep_going = false; // Script requires deps which don't exist (not a necessary check. efficiency?)
			elseif ( $this->registered[$handle]->deps && !$this->all_deps( $this->registered[$handle]->deps, true, $group ) )
				$keep_going = false; // Script requires deps which don't exist

			if ( !$keep_going ) { // Either script or its deps don't exist.
=======
				$keep_going = false; // Item doesn't exist.
			elseif ( $this->registered[$handle]->deps && array_diff($this->registered[$handle]->deps, array_keys($this->registered)) )
				$keep_going = false; // Item requires dependencies that don't exist.
			elseif ( $this->registered[$handle]->deps && !$this->all_deps( $this->registered[$handle]->deps, true, $group ) )
				$keep_going = false; // Item requires dependencies that don't exist.

			if ( ! $keep_going ) { // Either item or its dependencies don't exist.
>>>>>>> WPHome/master
				if ( $recursion )
					return false; // Abort this branch.
				else
					continue; // We're at the top level. Move on to the next one.
			}

<<<<<<< HEAD
			if ( $queued ) // Already grobbed it and its deps
=======
			if ( $queued ) // Already grabbed it and its dependencies.
>>>>>>> WPHome/master
				continue;

			if ( isset($handle_parts[1]) )
				$this->args[$handle] = $handle_parts[1];

			$this->to_do[] = $handle;
		}

		return true;
	}

	/**
<<<<<<< HEAD
	 * Adds item
	 *
	 * Adds the item only if no item of that name already exists
	 *
	 * @param string $handle Script name
	 * @param string $src Script url
	 * @param array $deps (optional) Array of script names on which this script depends
	 * @param string $ver (optional) Script version (used for cache busting)
	 * @return array Hierarchical array of dependencies
	 */
	function add( $handle, $src, $deps = array(), $ver = false, $args = null ) {
=======
	 * Register an item.
	 *
	 * Registers the item if no item of that name already exists.
	 *
	 * @access public
	 * @since 2.1.0
	 *
	 * @param string $handle Unique item name.
	 * @param string $src    The item url.
	 * @param array  $deps   Optional. An array of item handle strings on which this item depends.
	 * @param string $ver    Optional. Version (used for cache busting).
	 * @param mixed  $args   Optional. Custom property of the item. NOT the class property $args. Examples: $media, $in_footer.
	 * @return bool Whether the item has been registered. True on success, false on failure.
	 */
	public function add( $handle, $src, $deps = array(), $ver = false, $args = null ) {
>>>>>>> WPHome/master
		if ( isset($this->registered[$handle]) )
			return false;
		$this->registered[$handle] = new _WP_Dependency( $handle, $src, $deps, $ver, $args );
		return true;
	}

	/**
<<<<<<< HEAD
	 * Adds extra data
	 *
	 * Adds data only if script has already been added.
	 *
	 * @param string $handle Script name
	 * @param string $key
	 * @param mixed $value
	 * @return bool success
	 */
	function add_data( $handle, $key, $value ) {
=======
	 * Add extra item data.
	 *
	 * Adds data to a registered item.
	 *
	 * @access public
	 * @since 2.6.0
	 *
	 * @param string $handle Name of the item. Should be unique.
	 * @param string $key    The data key.
	 * @param mixed  $value  The data value.
	 * @return bool True on success, false on failure.
	 */
	public function add_data( $handle, $key, $value ) {
>>>>>>> WPHome/master
		if ( !isset( $this->registered[$handle] ) )
			return false;

		return $this->registered[$handle]->add_data( $key, $value );
	}

	/**
<<<<<<< HEAD
	 * Get extra data
	 *
	 * Gets data associated with a certain handle.
	 *
	 * @since WP 3.3
	 *
	 * @param string $handle Script name
	 * @param string $key
	 * @return mixed
	 */
	function get_data( $handle, $key ) {
=======
	 * Get extra item data.
	 *
	 * Gets data associated with a registered item.
	 *
	 * @access public
	 * @since 3.3.0
	 *
	 * @param string $handle Name of the item. Should be unique.
	 * @param string $key    The data key.
	 * @return mixed Extra item data (string), false otherwise.
	 */
	public function get_data( $handle, $key ) {
>>>>>>> WPHome/master
		if ( !isset( $this->registered[$handle] ) )
			return false;

		if ( !isset( $this->registered[$handle]->extra[$key] ) )
			return false;

		return $this->registered[$handle]->extra[$key];
	}

<<<<<<< HEAD
	function remove( $handles ) {
=======
	/**
	 * Un-register an item or items.
	 *
	 * @access public
	 * @since 2.1.0
	 *
	 * @param mixed $handles Item handle and argument (string) or item handles and arguments (array of strings).
	 * @return void
	 */
	public function remove( $handles ) {
>>>>>>> WPHome/master
		foreach ( (array) $handles as $handle )
			unset($this->registered[$handle]);
	}

<<<<<<< HEAD
	function enqueue( $handles ) {
=======
	/**
	 * Queue an item or items.
	 *
	 * Decodes handles and arguments, then queues handles and stores
	 * arguments in the class property $args. For example in extending
	 * classes, $args is appended to the item url as a query string.
	 * Note $args is NOT the $args property of items in the $registered array.
	 *
	 * @access public
	 * @since 2.1.0
	 *
	 * @param mixed $handles Item handle and argument (string) or item handles and arguments (array of strings).
	 */
	public function enqueue( $handles ) {
>>>>>>> WPHome/master
		foreach ( (array) $handles as $handle ) {
			$handle = explode('?', $handle);
			if ( !in_array($handle[0], $this->queue) && isset($this->registered[$handle[0]]) ) {
				$this->queue[] = $handle[0];
				if ( isset($handle[1]) )
					$this->args[$handle[0]] = $handle[1];
			}
		}
	}

<<<<<<< HEAD
	function dequeue( $handles ) {
=======
	/**
	 * Dequeue an item or items.
	 *
	 * Decodes handles and arguments, then dequeues handles
	 * and removes arguments from the class property $args.
	 *
	 * @access public
	 * @since 2.1.0
	 *
	 * @param mixed $handles Item handle and argument (string) or item handles and arguments (array of strings).
	 */
	public function dequeue( $handles ) {
>>>>>>> WPHome/master
		foreach ( (array) $handles as $handle ) {
			$handle = explode('?', $handle);
			$key = array_search($handle[0], $this->queue);
			if ( false !== $key ) {
				unset($this->queue[$key]);
				unset($this->args[$handle[0]]);
			}
		}
	}

<<<<<<< HEAD

	function query( $handle, $list = 'registered' ) {
=======
	/**
	 * Recursively search the passed dependency tree for $handle
	 *
	 * @since 4.0.0
	 *
	 * @param array  $queue  An array of queued _WP_Dependency handle objects.
	 * @param string $handle Name of the item. Should be unique.
	 * @return boolean Whether the handle is found after recursively searching the dependency tree.
	 */
	protected function recurse_deps( $queue, $handle ) {
		foreach ( $queue as $queued ) {
			if ( ! isset( $this->registered[ $queued ] ) ) {
				continue;
			}

			if ( in_array( $handle, $this->registered[ $queued ]->deps ) ) {
				return true;
			} elseif ( $this->recurse_deps( $this->registered[ $queued ]->deps, $handle ) ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Query list for an item.
	 *
	 * @access public
	 * @since 2.1.0
	 *
	 * @param string $handle Name of the item. Should be unique.
	 * @param string $list   Property name of list array.
	 * @return bool Found, or object Item data.
	 */
	public function query( $handle, $list = 'registered' ) {
>>>>>>> WPHome/master
		switch ( $list ) {
			case 'registered' :
			case 'scripts': // back compat
				if ( isset( $this->registered[ $handle ] ) )
					return $this->registered[ $handle ];
				return false;

			case 'enqueued' :
			case 'queue' :
<<<<<<< HEAD
				return in_array( $handle, $this->queue );
=======
				if ( in_array( $handle, $this->queue ) ) {
					return true;
				}
				return $this->recurse_deps( $this->queue, $handle );
>>>>>>> WPHome/master

			case 'to_do' :
			case 'to_print': // back compat
				return in_array( $handle, $this->to_do );

			case 'done' :
			case 'printed': // back compat
				return in_array( $handle, $this->done );
		}
		return false;
	}

<<<<<<< HEAD
	function set_group( $handle, $recursion, $group ) {
=======
	/**
	 * Set item group, unless already in a lower group.
	 *
	 * @access public
	 * @since 2.8.0
	 *
	 * @param string $handle    Name of the item. Should be unique.
	 * @param bool   $recursion Internal flag that calling function was called recursively.
	 * @param mixed  $group     Group level.
	 * @return bool Not already in the group or a lower group
	 */
	public function set_group( $handle, $recursion, $group ) {
>>>>>>> WPHome/master
		$group = (int) $group;

		if ( $recursion )
			$group = min($this->group, $group);
		else
			$this->group = $group;

		if ( isset($this->groups[$handle]) && $this->groups[$handle] <= $group )
			return false;

		$this->groups[$handle] = $group;
		return true;
	}

<<<<<<< HEAD
}

class _WP_Dependency {
	var $handle;
	var $src;
	var $deps = array();
	var $ver = false;
	var $args = null;

	var $extra = array();

	function __construct() {
=======
} // WP_Dependencies

/**
 * Class _WP_Dependency
 *
 * Helper class to register a handle and associated data.
 *
 * @access private
 * @since 2.6.0
 */
class _WP_Dependency {
	/**
	 * The handle name.
	 *
	 * @access public
	 * @since 2.6.0
	 * @var null
	 */
	public $handle;

	/**
	 * The handle source.
	 *
	 * @access public
	 * @since 2.6.0
	 * @var null
	 */
	public $src;

	/**
	 * An array of handle dependencies.
	 *
	 * @access public
	 * @since 2.6.0
	 * @var array
	 */
	public $deps = array();

	/**
	 * The handle version.
	 *
	 * Used for cache-busting.
	 *
	 * @access public
	 * @since 2.6.0
	 * @var bool|string
	 */
	public $ver = false;

	/**
	 * Additional arguments for the handle.
	 *
	 * @access public
	 * @since 2.6.0
	 * @var null
	 */
	public $args = null;  // Custom property, such as $in_footer or $media.

	/**
	 * Extra data to supply to the handle.
	 *
	 * @access public
	 * @since 2.6.0
	 * @var array
	 */
	public $extra = array();

	/**
	 * Setup dependencies.
	 *
	 * @since 2.6.0
	 */
	public function __construct() {
>>>>>>> WPHome/master
		@list( $this->handle, $this->src, $this->deps, $this->ver, $this->args ) = func_get_args();
		if ( ! is_array($this->deps) )
			$this->deps = array();
	}

<<<<<<< HEAD
	function add_data( $name, $data ) {
=======
	/**
	 * Add handle data.
	 *
	 * @access public
	 * @since 2.6.0
	 *
	 * @param string $name The data key to add.
	 * @param mixed  $data The data value to add.
	 * @return bool False if not scalar, true otherwise.
	 */
	public function add_data( $name, $data ) {
>>>>>>> WPHome/master
		if ( !is_scalar($name) )
			return false;
		$this->extra[$name] = $data;
		return true;
	}
<<<<<<< HEAD
}
=======

} // _WP_Dependencies
>>>>>>> WPHome/master
