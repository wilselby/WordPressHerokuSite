<?php
/**
 * BackPress Scripts enqueue.
 *
 * These classes were refactored from the WordPress WP_Scripts and WordPress
 * script enqueue API.
 *
 * @package BackPress
 * @since r16
 */

/**
 * BackPress Scripts enqueue class.
 *
 * @package BackPress
 * @uses WP_Dependencies
 * @since r16
 */
class WP_Scripts extends WP_Dependencies {
<<<<<<< HEAD
	var $base_url; // Full URL with trailing slash
	var $content_url;
	var $default_version;
	var $in_footer = array();
	var $concat = '';
	var $concat_version = '';
	var $do_concat = false;
	var $print_html = '';
	var $print_code = '';
	var $ext_handles = '';
	var $ext_version = '';
	var $default_dirs;

	function __construct() {
=======
	public $base_url; // Full URL with trailing slash
	public $content_url;
	public $default_version;
	public $in_footer = array();
	public $concat = '';
	public $concat_version = '';
	public $do_concat = false;
	public $print_html = '';
	public $print_code = '';
	public $ext_handles = '';
	public $ext_version = '';
	public $default_dirs;

	public function __construct() {
>>>>>>> WPHome/master
		$this->init();
		add_action( 'init', array( $this, 'init' ), 0 );
	}

<<<<<<< HEAD
	function init() {
=======
	public function init() {
		/**
		 * Fires when the WP_Scripts instance is initialized.
		 *
		 * @since 2.6.0
		 *
		 * @param WP_Scripts &$this WP_Scripts instance, passed by reference.
		 */
>>>>>>> WPHome/master
		do_action_ref_array( 'wp_default_scripts', array(&$this) );
	}

	/**
<<<<<<< HEAD
	 * Prints scripts
	 *
	 * Prints the scripts passed to it or the print queue. Also prints all necessary dependencies.
	 *
	 * @param mixed $handles (optional) Scripts to be printed. (void) prints queue, (string) prints that script, (array of strings) prints those scripts.
	 * @param int $group (optional) If scripts were queued in groups prints this group number.
	 * @return array Scripts that have been printed
	 */
	function print_scripts( $handles = false, $group = false ) {
=======
	 * Prints scripts.
	 *
	 * Prints the scripts passed to it or the print queue. Also prints all necessary dependencies.
	 *
	 * @param mixed $handles Optional. Scripts to be printed. (void) prints queue, (string) prints
	 *                       that script, (array of strings) prints those scripts. Default false.
	 * @param int   $group   Optional. If scripts were queued in groups prints this group number.
	 *                       Default false.
	 * @return array Scripts that have been printed.
	 */
	public function print_scripts( $handles = false, $group = false ) {
>>>>>>> WPHome/master
		return $this->do_items( $handles, $group );
	}

	// Deprecated since 3.3, see print_extra_script()
<<<<<<< HEAD
	function print_scripts_l10n( $handle, $echo = true ) {
=======
	public function print_scripts_l10n( $handle, $echo = true ) {
>>>>>>> WPHome/master
		_deprecated_function( __FUNCTION__, '3.3', 'print_extra_script()' );
		return $this->print_extra_script( $handle, $echo );
	}

<<<<<<< HEAD
	function print_extra_script( $handle, $echo = true ) {
=======
	public function print_extra_script( $handle, $echo = true ) {
>>>>>>> WPHome/master
		if ( !$output = $this->get_data( $handle, 'data' ) )
			return;

		if ( !$echo )
			return $output;

		echo "<script type='text/javascript'>\n"; // CDATA and type='text/javascript' is not needed for HTML 5
		echo "/* <![CDATA[ */\n";
		echo "$output\n";
		echo "/* ]]> */\n";
		echo "</script>\n";

		return true;
	}

<<<<<<< HEAD
	function do_item( $handle, $group = false ) {
=======
	public function do_item( $handle, $group = false ) {
>>>>>>> WPHome/master
		if ( !parent::do_item($handle) )
			return false;

		if ( 0 === $group && $this->groups[$handle] > 0 ) {
			$this->in_footer[] = $handle;
			return false;
		}

		if ( false === $group && in_array($handle, $this->in_footer, true) )
			$this->in_footer = array_diff( $this->in_footer, (array) $handle );

<<<<<<< HEAD
		if ( null === $this->registered[$handle]->ver )
			$ver = '';
		else
			$ver = $this->registered[$handle]->ver ? $this->registered[$handle]->ver : $this->default_version;
=======
		$obj = $this->registered[$handle];

		if ( null === $obj->ver ) {
			$ver = '';
		} else {
			$ver = $obj->ver ? $obj->ver : $this->default_version;
		}
>>>>>>> WPHome/master

		if ( isset($this->args[$handle]) )
			$ver = $ver ? $ver . '&amp;' . $this->args[$handle] : $this->args[$handle];

<<<<<<< HEAD
		$src = $this->registered[$handle]->src;

		if ( $this->do_concat ) {
			$srce = apply_filters( 'script_loader_src', $src, $handle );
			if ( $this->in_default_dir($srce) ) {
=======
		$src = $obj->src;
		$cond_before = $cond_after = '';
		$conditional = isset( $obj->extra['conditional'] ) ? $obj->extra['conditional'] : '';

		if ( $conditional ) {
			$cond_before = "<!--[if {$conditional}]>\n";
			$cond_after = "<![endif]-->\n";
		}

		if ( $this->do_concat ) {
			/**
			 * Filter the script loader source.
			 *
			 * @since 2.2.0
			 *
			 * @param string $src    Script loader source path.
			 * @param string $handle Script handle.
			 */
			$srce = apply_filters( 'script_loader_src', $src, $handle );
			if ( $this->in_default_dir( $srce ) && ! $conditional ) {
>>>>>>> WPHome/master
				$this->print_code .= $this->print_extra_script( $handle, false );
				$this->concat .= "$handle,";
				$this->concat_version .= "$handle$ver";
				return true;
			} else {
				$this->ext_handles .= "$handle,";
				$this->ext_version .= "$handle$ver";
			}
		}

<<<<<<< HEAD
		$this->print_extra_script( $handle );
		if ( !preg_match('|^(https?:)?//|', $src) && ! ( $this->content_url && 0 === strpos($src, $this->content_url) ) ) {
			$src = $this->base_url . $src;
		}

		if ( !empty($ver) )
			$src = add_query_arg('ver', $ver, $src);

		$src = esc_url( apply_filters( 'script_loader_src', $src, $handle ) );

		if ( $this->do_concat )
			$this->print_html .= "<script type='text/javascript' src='$src'></script>\n";
		else
			echo "<script type='text/javascript' src='$src'></script>\n";
=======
		$has_conditional_data = $conditional && $this->get_data( $handle, 'data' );

		if ( $has_conditional_data ) {
			echo $cond_before;
		}

		$this->print_extra_script( $handle );

		if ( $has_conditional_data ) {
			echo $cond_after;
		}

		if ( ! preg_match( '|^(https?:)?//|', $src ) && ! ( $this->content_url && 0 === strpos( $src, $this->content_url ) ) ) {
			$src = $this->base_url . $src;
		}

		if ( ! empty( $ver ) )
			$src = add_query_arg( 'ver', $ver, $src );

		/** This filter is documented in wp-includes/class.wp-scripts.php */
		$src = esc_url( apply_filters( 'script_loader_src', $src, $handle ) );

		if ( ! $src )
			return true;

		$tag = "{$cond_before}<script type='text/javascript' src='$src'></script>\n{$cond_after}";

		/** 
		 * Filter the HTML script tag of an enqueued script.
		 *
		 * @since 4.1.0
		 *
		 * @param string $tag    The `<script>` tag for the enqueued script.
		 * @param string $handle The script's registered handle.
		 * @param string $src    The script's source URL.
		 */
		$tag = apply_filters( 'script_loader_tag', $tag, $handle, $src );

		if ( $this->do_concat ) {
			$this->print_html .= $tag;
		} else {
			echo $tag;
		}
>>>>>>> WPHome/master

		return true;
	}

	/**
	 * Localizes a script
	 *
	 * Localizes only if the script has already been added
	 */
<<<<<<< HEAD
	function localize( $handle, $object_name, $l10n ) {
=======
	public function localize( $handle, $object_name, $l10n ) {
		if ( $handle === 'jquery' )
			$handle = 'jquery-core';

>>>>>>> WPHome/master
		if ( is_array($l10n) && isset($l10n['l10n_print_after']) ) { // back compat, preserve the code in 'l10n_print_after' if present
			$after = $l10n['l10n_print_after'];
			unset($l10n['l10n_print_after']);
		}

		foreach ( (array) $l10n as $key => $value ) {
			if ( !is_scalar($value) )
				continue;

			$l10n[$key] = html_entity_decode( (string) $value, ENT_QUOTES, 'UTF-8');
		}

<<<<<<< HEAD
		$script = "var $object_name = " . json_encode($l10n) . ';';
=======
		$script = "var $object_name = " . wp_json_encode( $l10n ) . ';';
>>>>>>> WPHome/master

		if ( !empty($after) )
			$script .= "\n$after;";

		$data = $this->get_data( $handle, 'data' );

		if ( !empty( $data ) )
			$script = "$data\n$script";

		return $this->add_data( $handle, 'data', $script );
	}

<<<<<<< HEAD
	function set_group( $handle, $recursion, $group = false ) {
=======
	public function set_group( $handle, $recursion, $group = false ) {
>>>>>>> WPHome/master

		if ( $this->registered[$handle]->args === 1 )
			$grp = 1;
		else
			$grp = (int) $this->get_data( $handle, 'group' );

		if ( false !== $group && $grp > $group )
			$grp = $group;

		return parent::set_group( $handle, $recursion, $grp );
	}

<<<<<<< HEAD
	function all_deps( $handles, $recursion = false, $group = false ) {
		$r = parent::all_deps( $handles, $recursion );
		if ( !$recursion )
			$this->to_do = apply_filters( 'print_scripts_array', $this->to_do );
		return $r;
	}

	function do_head_items() {
=======
	public function all_deps( $handles, $recursion = false, $group = false ) {
		$r = parent::all_deps( $handles, $recursion );
		if ( ! $recursion ) {
			/**
			 * Filter the list of script dependencies left to print.
			 *
			 * @since 2.3.0
			 *
			 * @param array $to_do An array of script dependencies.
			 */
			$this->to_do = apply_filters( 'print_scripts_array', $this->to_do );
		}
		return $r;
	}

	public function do_head_items() {
>>>>>>> WPHome/master
		$this->do_items(false, 0);
		return $this->done;
	}

<<<<<<< HEAD
	function do_footer_items() {
=======
	public function do_footer_items() {
>>>>>>> WPHome/master
		$this->do_items(false, 1);
		return $this->done;
	}

<<<<<<< HEAD
	function in_default_dir($src) {
		if ( ! $this->default_dirs )
			return true;

		if ( 0 === strpos( $src, '/wp-includes/js/l10n' ) )
			return false;

		foreach ( (array) $this->default_dirs as $test ) {
			if ( 0 === strpos($src, $test) )
				return true;
=======
	public function in_default_dir( $src ) {
		if ( ! $this->default_dirs ) {
			return true;
		}

		if ( 0 === strpos( $src, '/' . WPINC . '/js/l10n' ) ) {
			return false;
		}

		foreach ( (array) $this->default_dirs as $test ) {
			if ( 0 === strpos( $src, $test ) ) {
				return true;
			}
>>>>>>> WPHome/master
		}
		return false;
	}

<<<<<<< HEAD
	function reset() {
=======
	public function reset() {
>>>>>>> WPHome/master
		$this->do_concat = false;
		$this->print_code = '';
		$this->concat = '';
		$this->concat_version = '';
		$this->print_html = '';
		$this->ext_version = '';
		$this->ext_handles = '';
	}
}
