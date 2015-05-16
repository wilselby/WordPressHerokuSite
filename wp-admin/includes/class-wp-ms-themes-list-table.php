<?php
/**
 * MS Themes List Table class.
 *
 * @package WordPress
 * @subpackage List_Table
 * @since 3.1.0
 * @access private
 */
class WP_MS_Themes_List_Table extends WP_List_Table {

<<<<<<< HEAD
	var $site_id;
	var $is_site_themes;

	function __construct( $args = array() ) {
=======
	public $site_id;
	public $is_site_themes;

	private $has_items;

	/**
	 * Constructor.
	 *
	 * @since 3.1.0
	 * @access public
	 *
	 * @see WP_List_Table::__construct() for more information on default arguments.
	 *
	 * @param array $args An associative array of arguments.
	 */
	public function __construct( $args = array() ) {
>>>>>>> WPHome/master
		global $status, $page;

		parent::__construct( array(
			'plural' => 'themes',
			'screen' => isset( $args['screen'] ) ? $args['screen'] : null,
		) );

		$status = isset( $_REQUEST['theme_status'] ) ? $_REQUEST['theme_status'] : 'all';
		if ( !in_array( $status, array( 'all', 'enabled', 'disabled', 'upgrade', 'search', 'broken' ) ) )
			$status = 'all';

		$page = $this->get_pagenum();

		$this->is_site_themes = ( 'site-themes-network' == $this->screen->id ) ? true : false;

		if ( $this->is_site_themes )
			$this->site_id = isset( $_REQUEST['id'] ) ? intval( $_REQUEST['id'] ) : 0;
	}

<<<<<<< HEAD
	function get_table_classes() {
		return array( 'widefat', 'plugins' );	// todo: remove and add CSS for .themes
	}

	function ajax_user_can() {
=======
	protected function get_table_classes() {
		// todo: remove and add CSS for .themes
		return array( 'widefat', 'plugins' );
	}

	public function ajax_user_can() {
>>>>>>> WPHome/master
		if ( $this->is_site_themes )
			return current_user_can( 'manage_sites' );
		else
			return current_user_can( 'manage_network_themes' );
	}

<<<<<<< HEAD
	function prepare_items() {
=======
	public function prepare_items() {
>>>>>>> WPHome/master
		global $status, $totals, $page, $orderby, $order, $s;

		wp_reset_vars( array( 'orderby', 'order', 's' ) );

		$themes = array(
<<<<<<< HEAD
=======
			/**
			 * Filter the full array of WP_Theme objects to list in the Multisite
			 * themes list table.
			 *
			 * @since 3.1.0
			 *
			 * @param array $all An array of WP_Theme objects to display in the list table.
			 */
>>>>>>> WPHome/master
			'all' => apply_filters( 'all_themes', wp_get_themes() ),
			'search' => array(),
			'enabled' => array(),
			'disabled' => array(),
			'upgrade' => array(),
			'broken' => $this->is_site_themes ? array() : wp_get_themes( array( 'errors' => true ) ),
		);

		if ( $this->is_site_themes ) {
			$themes_per_page = $this->get_items_per_page( 'site_themes_network_per_page' );
			$allowed_where = 'site';
		} else {
			$themes_per_page = $this->get_items_per_page( 'themes_network_per_page' );
			$allowed_where = 'network';
		}

		$maybe_update = current_user_can( 'update_themes' ) && ! $this->is_site_themes && $current = get_site_transient( 'update_themes' );

		foreach ( (array) $themes['all'] as $key => $theme ) {
			if ( $this->is_site_themes && $theme->is_allowed( 'network' ) ) {
				unset( $themes['all'][ $key ] );
				continue;
			}

			if ( $maybe_update && isset( $current->response[ $key ] ) ) {
				$themes['all'][ $key ]->update = true;
				$themes['upgrade'][ $key ] = $themes['all'][ $key ];
			}

			$filter = $theme->is_allowed( $allowed_where, $this->site_id ) ? 'enabled' : 'disabled';
			$themes[ $filter ][ $key ] = $themes['all'][ $key ];
		}

		if ( $s ) {
			$status = 'search';
<<<<<<< HEAD
			$themes['search'] = array_filter( array_merge( $themes['all'], $themes['broken'] ), array( &$this, '_search_callback' ) );
=======
			$themes['search'] = array_filter( array_merge( $themes['all'], $themes['broken'] ), array( $this, '_search_callback' ) );
>>>>>>> WPHome/master
		}

		$totals = array();
		foreach ( $themes as $type => $list )
			$totals[ $type ] = count( $list );

		if ( empty( $themes[ $status ] ) && !in_array( $status, array( 'all', 'search' ) ) )
			$status = 'all';

		$this->items = $themes[ $status ];
		WP_Theme::sort_by_name( $this->items );

		$this->has_items = ! empty( $themes['all'] );
		$total_this_page = $totals[ $status ];

		if ( $orderby ) {
			$orderby = ucfirst( $orderby );
			$order = strtoupper( $order );

			if ( $orderby == 'Name' ) {
				if ( 'ASC' == $order )
					$this->items = array_reverse( $this->items );
			} else {
<<<<<<< HEAD
				uasort( $this->items, array( &$this, '_order_callback' ) );
=======
				uasort( $this->items, array( $this, '_order_callback' ) );
>>>>>>> WPHome/master
			}
		}

		$start = ( $page - 1 ) * $themes_per_page;

		if ( $total_this_page > $themes_per_page )
			$this->items = array_slice( $this->items, $start, $themes_per_page, true );

		$this->set_pagination_args( array(
			'total_items' => $total_this_page,
			'per_page' => $themes_per_page,
		) );
	}

<<<<<<< HEAD
	function _search_callback( $theme ) {
		static $term;
		if ( is_null( $term ) )
			$term = stripslashes( $_REQUEST['s'] );
=======
	/**
	 * @staticvar string $term
	 * @param WP_Theme $theme
	 * @return bool
	 */
	public function _search_callback( $theme ) {
		static $term;
		if ( is_null( $term ) )
			$term = wp_unslash( $_REQUEST['s'] );
>>>>>>> WPHome/master

		foreach ( array( 'Name', 'Description', 'Author', 'Author', 'AuthorURI' ) as $field ) {
			// Don't mark up; Do translate.
			if ( false !== stripos( $theme->display( $field, false, true ), $term ) )
				return true;
		}

		if ( false !== stripos( $theme->get_stylesheet(), $term ) )
			return true;

		if ( false !== stripos( $theme->get_template(), $term ) )
			return true;

		return false;
	}

	// Not used by any core columns.
<<<<<<< HEAD
	function _order_callback( $theme_a, $theme_b ) {
=======
	/**
	 * @global string $orderby
	 * @global string $order
	 * @param array $theme_a
	 * @param array $theme_b
	 * @return int
	 */
	public function _order_callback( $theme_a, $theme_b ) {
>>>>>>> WPHome/master
		global $orderby, $order;

		$a = $theme_a[ $orderby ];
		$b = $theme_b[ $orderby ];

		if ( $a == $b )
			return 0;

		if ( 'DESC' == $order )
			return ( $a < $b ) ? 1 : -1;
		else
			return ( $a < $b ) ? -1 : 1;
	}

<<<<<<< HEAD
	function no_items() {
=======
	public function no_items() {
>>>>>>> WPHome/master
		if ( ! $this->has_items )
			_e( 'No themes found.' );
		else
			_e( 'You do not appear to have any themes available at this time.' );
	}

<<<<<<< HEAD
	function get_columns() {
=======
	public function get_columns() {
>>>>>>> WPHome/master
		global $status;

		return array(
			'cb'          => '<input type="checkbox" />',
			'name'        => __( 'Theme' ),
			'description' => __( 'Description' ),
		);
	}

<<<<<<< HEAD
	function get_sortable_columns() {
=======
	protected function get_sortable_columns() {
>>>>>>> WPHome/master
		return array(
			'name'         => 'name',
		);
	}

<<<<<<< HEAD
	function get_views() {
=======
	protected function get_views() {
>>>>>>> WPHome/master
		global $totals, $status;

		$status_links = array();
		foreach ( $totals as $type => $count ) {
			if ( !$count )
				continue;

			switch ( $type ) {
				case 'all':
					$text = _nx( 'All <span class="count">(%s)</span>', 'All <span class="count">(%s)</span>', $count, 'themes' );
					break;
				case 'enabled':
					$text = _n( 'Enabled <span class="count">(%s)</span>', 'Enabled <span class="count">(%s)</span>', $count );
					break;
				case 'disabled':
					$text = _n( 'Disabled <span class="count">(%s)</span>', 'Disabled <span class="count">(%s)</span>', $count );
					break;
				case 'upgrade':
					$text = _n( 'Update Available <span class="count">(%s)</span>', 'Update Available <span class="count">(%s)</span>', $count );
					break;
				case 'broken' :
					$text = _n( 'Broken <span class="count">(%s)</span>', 'Broken <span class="count">(%s)</span>', $count );
					break;
			}

			if ( $this->is_site_themes )
				$url = 'site-themes.php?id=' . $this->site_id;
			else
				$url = 'themes.php';

			if ( 'search' != $type ) {
				$status_links[$type] = sprintf( "<a href='%s' %s>%s</a>",
					esc_url( add_query_arg('theme_status', $type, $url) ),
					( $type == $status ) ? ' class="current"' : '',
					sprintf( $text, number_format_i18n( $count ) )
				);
			}
		}

		return $status_links;
	}

<<<<<<< HEAD
	function get_bulk_actions() {
=======
	protected function get_bulk_actions() {
>>>>>>> WPHome/master
		global $status;

		$actions = array();
		if ( 'enabled' != $status )
			$actions['enable-selected'] = $this->is_site_themes ? __( 'Enable' ) : __( 'Network Enable' );
		if ( 'disabled' != $status )
			$actions['disable-selected'] = $this->is_site_themes ? __( 'Disable' ) : __( 'Network Disable' );
		if ( ! $this->is_site_themes ) {
			if ( current_user_can( 'update_themes' ) )
				$actions['update-selected'] = __( 'Update' );
			if ( current_user_can( 'delete_themes' ) )
				$actions['delete-selected'] = __( 'Delete' );
		}
		return $actions;
	}

<<<<<<< HEAD
	function display_rows() {
		foreach ( $this->items as $key => $theme )
			$this->single_row( $key, $theme );
	}

	function single_row( $key, $theme ) {
=======
	public function display_rows() {
		foreach ( $this->items as $theme )
			$this->single_row( $theme );
	}

	/**
	 * @global string $status
	 * @global int $page
	 * @global string $s
	 * @global array $totals
	 * @param WP_Theme $theme
	 */
	public function single_row( $theme ) {
>>>>>>> WPHome/master
		global $status, $page, $s, $totals;

		$context = $status;

		if ( $this->is_site_themes ) {
			$url = "site-themes.php?id={$this->site_id}&amp;";
			$allowed = $theme->is_allowed( 'site', $this->site_id );
		} else {
			$url = 'themes.php?';
			$allowed = $theme->is_allowed( 'network' );
		}

<<<<<<< HEAD
		// preorder
=======
		// Pre-order.
>>>>>>> WPHome/master
		$actions = array(
			'enable' => '',
			'disable' => '',
			'edit' => '',
			'delete' => ''
		);

		$stylesheet = $theme->get_stylesheet();
		$theme_key = urlencode( $stylesheet );

		if ( ! $allowed ) {
			if ( ! $theme->errors() )
				$actions['enable'] = '<a href="' . esc_url( wp_nonce_url($url . 'action=enable&amp;theme=' . $theme_key . '&amp;paged=' . $page . '&amp;s=' . $s, 'enable-theme_' . $stylesheet ) ) . '" title="' . esc_attr__('Enable this theme') . '" class="edit">' . ( $this->is_site_themes ? __( 'Enable' ) : __( 'Network Enable' ) ) . '</a>';
		} else {
			$actions['disable'] = '<a href="' . esc_url( wp_nonce_url($url . 'action=disable&amp;theme=' . $theme_key . '&amp;paged=' . $page . '&amp;s=' . $s, 'disable-theme_' . $stylesheet ) ) . '" title="' . esc_attr__('Disable this theme') . '">' . ( $this->is_site_themes ? __( 'Disable' ) : __( 'Network Disable' ) ) . '</a>';
		}

		if ( current_user_can('edit_themes') )
			$actions['edit'] = '<a href="' . esc_url('theme-editor.php?theme=' . $theme_key ) . '" title="' . esc_attr__('Open this theme in the Theme Editor') . '" class="edit">' . __('Edit') . '</a>';

		if ( ! $allowed && current_user_can( 'delete_themes' ) && ! $this->is_site_themes && $stylesheet != get_option( 'stylesheet' ) && $stylesheet != get_option( 'template' ) )
			$actions['delete'] = '<a href="' . esc_url( wp_nonce_url( 'themes.php?action=delete-selected&amp;checked[]=' . $theme_key . '&amp;theme_status=' . $context . '&amp;paged=' . $page . '&amp;s=' . $s, 'bulk-themes' ) ) . '" title="' . esc_attr__( 'Delete this theme' ) . '" class="delete">' . __( 'Delete' ) . '</a>';

<<<<<<< HEAD
		$actions = apply_filters( 'theme_action_links', array_filter( $actions ), $stylesheet, $theme, $context );
		$actions = apply_filters( "theme_action_links_$stylesheet", $actions, $stylesheet, $theme, $context );
=======
		/**
		 * Filter the action links displayed for each theme in the Multisite
		 * themes list table.
		 *
		 * The action links displayed are determined by the theme's status, and
		 * which Multisite themes list table is being displayed - the Network
		 * themes list table (themes.php), which displays all installed themes,
		 * or the Site themes list table (site-themes.php), which displays the
		 * non-network enabled themes when editing a site in the Network admin.
		 *
		 * The default action links for the Network themes list table include
		 * 'Network Enable', 'Network Disable', 'Edit', and 'Delete'.
		 *
		 * The default action links for the Site themes list table include
		 * 'Enable', 'Disable', and 'Edit'.
		 *
		 * @since 2.8.0
		 *
		 * @param array    $actions An array of action links.
		 * @param WP_Theme $theme   The current WP_Theme object.
		 * @param string   $context Status of the theme.
		 */
		$actions = apply_filters( 'theme_action_links', array_filter( $actions ), $theme, $context );

		/**
		 * Filter the action links of a specific theme in the Multisite themes
		 * list table.
		 *
		 * The dynamic portion of the hook name, `$stylesheet`, refers to the
		 * directory name of the theme, which in most cases is synonymous
		 * with the template name.
		 *
		 * @since 3.1.0
		 *
		 * @param array    $actions An array of action links.
		 * @param WP_Theme $theme   The current WP_Theme object.
		 * @param string   $context Status of the theme.
		 */
		$actions = apply_filters( "theme_action_links_$stylesheet", $actions, $theme, $context );
>>>>>>> WPHome/master

		$class = ! $allowed ? 'inactive' : 'active';
		$checkbox_id = "checkbox_" . md5( $theme->get('Name') );
		$checkbox = "<input type='checkbox' name='checked[]' value='" . esc_attr( $stylesheet ) . "' id='" . $checkbox_id . "' /><label class='screen-reader-text' for='" . $checkbox_id . "' >" . __('Select') . " " . $theme->display('Name') . "</label>";

		$id = sanitize_html_class( $theme->get_stylesheet() );

		if ( ! empty( $totals['upgrade'] ) && ! empty( $theme->update ) )
			$class .= ' update';

		echo "<tr id='$id' class='$class'>";

		list( $columns, $hidden ) = $this->get_column_info();

		foreach ( $columns as $column_name => $column_display_name ) {
			$style = '';
			if ( in_array( $column_name, $hidden ) )
				$style = ' style="display:none;"';

			switch ( $column_name ) {
				case 'cb':
					echo "<th scope='row' class='check-column'>$checkbox</th>";
					break;
				case 'name':
					echo "<td class='theme-title'$style><strong>" . $theme->display('Name') . "</strong>";
					echo $this->row_actions( $actions, true );
					echo "</td>";
					break;
				case 'description':
					echo "<td class='column-description desc'$style>";
					if ( $theme->errors() ) {
<<<<<<< HEAD
						$pre = $status == 'broken' ? '' : __( 'Broken Theme:' ) . ' ';
=======
						$pre = $status == 'broken' ? __( 'Broken Theme:' ) . ' ' : '';
>>>>>>> WPHome/master
						echo '<p><strong class="attention">' . $pre . $theme->errors()->get_error_message() . '</strong></p>';
					}
					echo "<div class='theme-description'><p>" . $theme->display( 'Description' ) . "</p></div>
						<div class='$class second theme-version-author-uri'>";

					$theme_meta = array();

					if ( $theme->get('Version') )
						$theme_meta[] = sprintf( __( 'Version %s' ), $theme->display('Version') );

					$theme_meta[] = sprintf( __( 'By %s' ), $theme->display('Author') );

					if ( $theme->get('ThemeURI') )
						$theme_meta[] = '<a href="' . $theme->display('ThemeURI') . '" title="' . esc_attr__( 'Visit theme homepage' ) . '">' . __( 'Visit Theme Site' ) . '</a>';

<<<<<<< HEAD
=======
					/**
					 * Filter the array of row meta for each theme in the Multisite themes
					 * list table.
					 *
					 * @since 3.1.0
					 *
					 * @param array    $theme_meta An array of the theme's metadata,
					 *                             including the version, author, and
					 *                             theme URI.
					 * @param string   $stylesheet Directory name of the theme.
					 * @param WP_Theme $theme      WP_Theme object.
					 * @param string   $status     Status of the theme.
					 */
>>>>>>> WPHome/master
					$theme_meta = apply_filters( 'theme_row_meta', $theme_meta, $stylesheet, $theme, $status );
					echo implode( ' | ', $theme_meta );

					echo "</div></td>";
					break;

				default:
					echo "<td class='$column_name column-$column_name'$style>";
<<<<<<< HEAD
=======

					/**
					 * Fires inside each custom column of the Multisite themes list table.
					 *
					 * @since 3.1.0
					 *
					 * @param string   $column_name Name of the column.
					 * @param string   $stylesheet  Directory name of the theme.
					 * @param WP_Theme $theme       Current WP_Theme object.
					 */
>>>>>>> WPHome/master
					do_action( 'manage_themes_custom_column', $column_name, $stylesheet, $theme );
					echo "</td>";
			}
		}

		echo "</tr>";

		if ( $this->is_site_themes )
			remove_action( "after_theme_row_$stylesheet", 'wp_theme_update_row' );
<<<<<<< HEAD
		do_action( 'after_theme_row', $stylesheet, $theme, $status );
=======

		/**
		 * Fires after each row in the Multisite themes list table.
		 *
		 * @since 3.1.0
		 *
		 * @param string   $stylesheet Directory name of the theme.
		 * @param WP_Theme $theme      Current WP_Theme object.
		 * @param string   $status     Status of the theme.
		 */
		do_action( 'after_theme_row', $stylesheet, $theme, $status );

		/**
		 * Fires after each specific row in the Multisite themes list table.
		 *
		 * The dynamic portion of the hook name, `$stylesheet`, refers to the
		 * directory name of the theme, most often synonymous with the template
		 * name of the theme.
		 *
		 * @since 3.5.0
		 *
		 * @param string   $stylesheet Directory name of the theme.
		 * @param WP_Theme $theme      Current WP_Theme object.
		 * @param string   $status     Status of the theme.
		 */
>>>>>>> WPHome/master
		do_action( "after_theme_row_$stylesheet", $stylesheet, $theme, $status );
	}
}
