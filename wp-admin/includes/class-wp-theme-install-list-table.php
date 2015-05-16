<?php
/**
 * Theme Installer List Table class.
 *
 * @package WordPress
 * @subpackage List_Table
 * @since 3.1.0
 * @access private
 */
class WP_Theme_Install_List_Table extends WP_Themes_List_Table {

<<<<<<< HEAD
	var $features = array();

	function ajax_user_can() {
		return current_user_can( 'install_themes' );
	}

	function prepare_items() {
=======
	public $features = array();

	public function ajax_user_can() {
		return current_user_can( 'install_themes' );
	}

	public function prepare_items() {
>>>>>>> WPHome/master
		include( ABSPATH . 'wp-admin/includes/theme-install.php' );

		global $tabs, $tab, $paged, $type, $theme_field_defaults;
		wp_reset_vars( array( 'tab' ) );

		$search_terms = array();
		$search_string = '';
		if ( ! empty( $_REQUEST['s'] ) ){
<<<<<<< HEAD
			$search_string = strtolower( stripslashes( $_REQUEST['s'] ) );
=======
			$search_string = strtolower( wp_unslash( $_REQUEST['s'] ) );
>>>>>>> WPHome/master
			$search_terms = array_unique( array_filter( array_map( 'trim', explode( ',', $search_string ) ) ) );
		}

		if ( ! empty( $_REQUEST['features'] ) )
			$this->features = $_REQUEST['features'];

		$paged = $this->get_pagenum();

		$per_page = 36;

		// These are the tabs which are shown on the page,
		$tabs = array();
		$tabs['dashboard'] = __( 'Search' );
		if ( 'search' == $tab )
			$tabs['search']	= __( 'Search Results' );
		$tabs['upload'] = __( 'Upload' );
<<<<<<< HEAD
		$tabs['featured'] = _x( 'Featured','Theme Installer' );
		//$tabs['popular']  = _x( 'Popular','Theme Installer' );
		$tabs['new']      = _x( 'Newest','Theme Installer' );
		$tabs['updated']  = _x( 'Recently Updated','Theme Installer' );

		$nonmenu_tabs = array( 'theme-information' ); // Valid actions to perform which do not have a Menu item.

		$tabs = apply_filters( 'install_themes_tabs', $tabs );
		$nonmenu_tabs = apply_filters( 'install_themes_nonmenu_tabs', $nonmenu_tabs );

		// If a non-valid menu tab has been selected, And its not a non-menu action.
=======
		$tabs['featured'] = _x( 'Featured', 'themes' );
		//$tabs['popular']  = _x( 'Popular', 'themes' );
		$tabs['new']      = _x( 'Latest', 'themes' );
		$tabs['updated']  = _x( 'Recently Updated', 'themes' );

		$nonmenu_tabs = array( 'theme-information' ); // Valid actions to perform which do not have a Menu item.

		/** This filter is documented in wp-admin/theme-install.php */
		$tabs = apply_filters( 'install_themes_tabs', $tabs );

		/**
		 * Filter tabs not associated with a menu item on the Install Themes screen.
		 *
		 * @since 2.8.0
		 *
		 * @param array $nonmenu_tabs The tabs that don't have a menu item on
		 *                            the Install Themes screen.
		 */
		$nonmenu_tabs = apply_filters( 'install_themes_nonmenu_tabs', $nonmenu_tabs );

		// If a non-valid menu tab has been selected, And it's not a non-menu action.
>>>>>>> WPHome/master
		if ( empty( $tab ) || ( ! isset( $tabs[ $tab ] ) && ! in_array( $tab, (array) $nonmenu_tabs ) ) )
			$tab = key( $tabs );

		$args = array( 'page' => $paged, 'per_page' => $per_page, 'fields' => $theme_field_defaults );

		switch ( $tab ) {
			case 'search':
<<<<<<< HEAD
				$type = isset( $_REQUEST['type'] ) ? stripslashes( $_REQUEST['type'] ) : 'term';
=======
				$type = isset( $_REQUEST['type'] ) ? wp_unslash( $_REQUEST['type'] ) : 'term';
>>>>>>> WPHome/master
				switch ( $type ) {
					case 'tag':
						$args['tag'] = array_map( 'sanitize_key', $search_terms );
						break;
					case 'term':
						$args['search'] = $search_string;
						break;
					case 'author':
						$args['author'] = $search_string;
						break;
				}

				if ( ! empty( $this->features ) ) {
					$args['tag'] = $this->features;
					$_REQUEST['s'] = implode( ',', $this->features );
					$_REQUEST['type'] = 'tag';
				}

				add_action( 'install_themes_table_header', 'install_theme_search_form', 10, 0 );
				break;

			case 'featured':
<<<<<<< HEAD
			//case 'popular':
=======
			// case 'popular':
>>>>>>> WPHome/master
			case 'new':
			case 'updated':
				$args['browse'] = $tab;
				break;

			default:
				$args = false;
<<<<<<< HEAD
		}

=======
				break;
		}

		/**
		 * Filter API request arguments for each Install Themes screen tab.
		 *
		 * The dynamic portion of the hook name, `$tab`, refers to the theme install
		 * tabs. Default tabs are 'dashboard', 'search', 'upload', 'featured',
		 * 'new', and 'updated'.
		 *
		 * @since 3.7.0
		 *
		 * @param array $args An array of themes API arguments.
		 */
		$args = apply_filters( 'install_themes_table_api_args_' . $tab, $args );

>>>>>>> WPHome/master
		if ( ! $args )
			return;

		$api = themes_api( 'query_themes', $args );

		if ( is_wp_error( $api ) )
			wp_die( $api->get_error_message() . '</p> <p><a href="#" onclick="document.location.reload(); return false;">' . __( 'Try again' ) . '</a>' );

		$this->items = $api->themes;

		$this->set_pagination_args( array(
			'total_items' => $api->info['results'],
<<<<<<< HEAD
			'per_page' => $per_page,
=======
			'per_page' => $args['per_page'],
>>>>>>> WPHome/master
			'infinite_scroll' => true,
		) );
	}

<<<<<<< HEAD
	function no_items() {
		_e( 'No themes match your request.' );
	}

	function get_views() {
=======
	public function no_items() {
		_e( 'No themes match your request.' );
	}

	protected function get_views() {
>>>>>>> WPHome/master
		global $tabs, $tab;

		$display_tabs = array();
		foreach ( (array) $tabs as $action => $text ) {
			$class = ( $action == $tab ) ? ' class="current"' : '';
			$href = self_admin_url('theme-install.php?tab=' . $action);
			$display_tabs['theme-install-'.$action] = "<a href='$href'$class>$text</a>";
		}

		return $display_tabs;
	}

<<<<<<< HEAD
	function display() {
=======
	public function display() {
>>>>>>> WPHome/master
		wp_nonce_field( "fetch-list-" . get_class( $this ), '_ajax_fetch_list_nonce' );
?>
		<div class="tablenav top themes">
			<div class="alignleft actions">
<<<<<<< HEAD
				<?php do_action( 'install_themes_table_header' ); ?>
=======
				<?php
				/**
				 * Fires in the Install Themes list table header.
				 *
				 * @since 2.8.0
				 */
				do_action( 'install_themes_table_header' );
				?>
>>>>>>> WPHome/master
			</div>
			<?php $this->pagination( 'top' ); ?>
			<br class="clear" />
		</div>

		<div id="availablethemes">
			<?php $this->display_rows_or_placeholder(); ?>
		</div>

		<?php
<<<<<<< HEAD
		parent::tablenav( 'bottom' );
	}

	function display_rows() {
=======
		$this->tablenav( 'bottom' );
	}

	public function display_rows() {
>>>>>>> WPHome/master
		$themes = $this->items;
		foreach ( $themes as $theme ) {
				?>
				<div class="available-theme installable-theme"><?php
					$this->single_row( $theme );
				?></div>
		<?php } // end foreach $theme_names

		$this->theme_installer();
	}

<<<<<<< HEAD
	/*
=======
	/**
>>>>>>> WPHome/master
	 * Prints a theme from the WordPress.org API.
	 *
	 * @param object $theme An object that contains theme data returned by the WordPress.org API.
	 *
	 * Example theme data:
	 *   object(stdClass)[59]
<<<<<<< HEAD
	 *     public 'name' => string 'Magazine Basic' (length=14)
	 *     public 'slug' => string 'magazine-basic' (length=14)
	 *     public 'version' => string '1.1' (length=3)
	 *     public 'author' => string 'tinkerpriest' (length=12)
	 *     public 'preview_url' => string 'http://wp-themes.com/?magazine-basic' (length=36)
	 *     public 'screenshot_url' => string 'http://wp-themes.com/wp-content/themes/magazine-basic/screenshot.png' (length=68)
	 *     public 'rating' => float 80
	 *     public 'num_ratings' => int 1
	 *     public 'homepage' => string 'http://wordpress.org/extend/themes/magazine-basic' (length=49)
	 *     public 'description' => string 'A basic magazine style layout with a fully customizable layout through a backend interface. Designed by <a href="http://bavotasan.com">c.bavota</a> of <a href="http://tinkerpriestmedia.com">Tinker Priest Media</a>.' (length=214)
	 *     public 'download_link' => string 'http://wordpress.org/extend/themes/download/magazine-basic.1.1.zip' (length=66)
	 */
	function single_row( $theme ) {
=======
	 *     public 'name' => string 'Magazine Basic'
	 *     public 'slug' => string 'magazine-basic'
	 *     public 'version' => string '1.1'
	 *     public 'author' => string 'tinkerpriest'
	 *     public 'preview_url' => string 'http://wp-themes.com/?magazine-basic'
	 *     public 'screenshot_url' => string 'http://wp-themes.com/wp-content/themes/magazine-basic/screenshot.png'
	 *     public 'rating' => float 80
	 *     public 'num_ratings' => int 1
	 *     public 'homepage' => string 'http://wordpress.org/themes/magazine-basic'
	 *     public 'description' => string 'A basic magazine style layout with a fully customizable layout through a backend interface. Designed by <a href="http://bavotasan.com">c.bavota</a> of <a href="http://tinkerpriestmedia.com">Tinker Priest Media</a>.'
	 *     public 'download_link' => string 'http://wordpress.org/themes/download/magazine-basic.1.1.zip'
	 */
	public function single_row( $theme ) {
>>>>>>> WPHome/master
		global $themes_allowedtags;

		if ( empty( $theme ) )
			return;

		$name   = wp_kses( $theme->name,   $themes_allowedtags );
		$author = wp_kses( $theme->author, $themes_allowedtags );

		$preview_title = sprintf( __('Preview &#8220;%s&#8221;'), $name );
		$preview_url   = add_query_arg( array(
			'tab'   => 'theme-information',
			'theme' => $theme->slug,
<<<<<<< HEAD
		) );
=======
		), self_admin_url( 'theme-install.php' ) );
>>>>>>> WPHome/master

		$actions = array();

		$install_url = add_query_arg( array(
			'action' => 'install-theme',
			'theme'  => $theme->slug,
		), self_admin_url( 'update.php' ) );

		$update_url = add_query_arg( array(
			'action' => 'upgrade-theme',
			'theme'  => $theme->slug,
		), self_admin_url( 'update.php' ) );

		$status = $this->_get_theme_status( $theme );

		switch ( $status ) {
<<<<<<< HEAD
			default:
			case 'install':
				$actions[] = '<a class="install-now" href="' . esc_url( wp_nonce_url( $install_url, 'install-theme_' . $theme->slug ) ) . '" title="' . esc_attr( sprintf( __( 'Install %s' ), $name ) ) . '">' . __( 'Install Now' ) . '</a>';
				break;
=======
>>>>>>> WPHome/master
			case 'update_available':
				$actions[] = '<a class="install-now" href="' . esc_url( wp_nonce_url( $update_url, 'upgrade-theme_' . $theme->slug ) ) . '" title="' . esc_attr( sprintf( __( 'Update to version %s' ), $theme->version ) ) . '">' . __( 'Update' ) . '</a>';
				break;
			case 'newer_installed':
			case 'latest_installed':
				$actions[] = '<span class="install-now" title="' . esc_attr__( 'This theme is already installed and is up to date' ) . '">' . _x( 'Installed', 'theme' ) . '</span>';
				break;
<<<<<<< HEAD
=======
			case 'install':
			default:
				$actions[] = '<a class="install-now" href="' . esc_url( wp_nonce_url( $install_url, 'install-theme_' . $theme->slug ) ) . '" title="' . esc_attr( sprintf( __( 'Install %s' ), $name ) ) . '">' . __( 'Install Now' ) . '</a>';
				break;
>>>>>>> WPHome/master
		}

		$actions[] = '<a class="install-theme-preview" href="' . esc_url( $preview_url ) . '" title="' . esc_attr( sprintf( __( 'Preview %s' ), $name ) ) . '">' . __( 'Preview' ) . '</a>';

<<<<<<< HEAD
=======
		/**
		 * Filter the install action links for a theme in the Install Themes list table.
		 *
		 * @since 3.4.0
		 *
		 * @param array    $actions An array of theme action hyperlinks. Defaults are
		 *                          links to Install Now, Preview, and Details.
		 * @param WP_Theme $theme   Theme object.
		 */
>>>>>>> WPHome/master
		$actions = apply_filters( 'theme_install_actions', $actions, $theme );

		?>
		<a class="screenshot install-theme-preview" href="<?php echo esc_url( $preview_url ); ?>" title="<?php echo esc_attr( $preview_title ); ?>">
<<<<<<< HEAD
			<img src='<?php echo esc_url( $theme->screenshot_url ); ?>' width='150' />
=======
			<img src="<?php echo esc_url( $theme->screenshot_url ); ?>" width="150" />
>>>>>>> WPHome/master
		</a>

		<h3><?php echo $name; ?></h3>
		<div class="theme-author"><?php printf( __( 'By %s' ), $author ); ?></div>

		<div class="action-links">
			<ul>
				<?php foreach ( $actions as $action ): ?>
					<li><?php echo $action; ?></li>
				<?php endforeach; ?>
				<li class="hide-if-no-js"><a href="#" class="theme-detail"><?php _e('Details') ?></a></li>
			</ul>
		</div>

		<?php
		$this->install_theme_info( $theme );
	}

<<<<<<< HEAD
	/*
	 * Prints the wrapper for the theme installer.
	 */
	function theme_installer() {
=======
	/**
	 * Prints the wrapper for the theme installer.
	 */
	public function theme_installer() {
>>>>>>> WPHome/master
		?>
		<div id="theme-installer" class="wp-full-overlay expanded">
			<div class="wp-full-overlay-sidebar">
				<div class="wp-full-overlay-header">
<<<<<<< HEAD
					<a href="#" class="close-full-overlay"><?php _e( '&larr; Close' ); ?></a>
=======
					<a href="#" class="close-full-overlay button-secondary"><?php _e( 'Close' ); ?></a>
					<span class="theme-install"></span>
>>>>>>> WPHome/master
				</div>
				<div class="wp-full-overlay-sidebar-content">
					<div class="install-theme-info"></div>
				</div>
				<div class="wp-full-overlay-footer">
<<<<<<< HEAD
					<a href="#" class="collapse-sidebar button-secondary" title="<?php esc_attr_e('Collapse Sidebar'); ?>">
=======
					<a href="#" class="collapse-sidebar" title="<?php esc_attr_e('Collapse Sidebar'); ?>">
>>>>>>> WPHome/master
						<span class="collapse-sidebar-label"><?php _e('Collapse'); ?></span>
						<span class="collapse-sidebar-arrow"></span>
					</a>
				</div>
			</div>
			<div class="wp-full-overlay-main"></div>
		</div>
		<?php
	}

<<<<<<< HEAD
	/*
=======
	/**
>>>>>>> WPHome/master
	 * Prints the wrapper for the theme installer with a provided theme's data.
	 * Used to make the theme installer work for no-js.
	 *
	 * @param object $theme - A WordPress.org Theme API object.
	 */
<<<<<<< HEAD
	function theme_installer_single( $theme ) {
=======
	public function theme_installer_single( $theme ) {
>>>>>>> WPHome/master
		?>
		<div id="theme-installer" class="wp-full-overlay single-theme">
			<div class="wp-full-overlay-sidebar">
				<?php $this->install_theme_info( $theme ); ?>
			</div>
			<div class="wp-full-overlay-main">
				<iframe src="<?php echo esc_url( $theme->preview_url ); ?>"></iframe>
			</div>
		</div>
		<?php
	}

<<<<<<< HEAD
	/*
=======
	/**
>>>>>>> WPHome/master
	 * Prints the info for a theme (to be used in the theme installer modal).
	 *
	 * @param object $theme - A WordPress.org Theme API object.
	 */
<<<<<<< HEAD
	function install_theme_info( $theme ) {
=======
	public function install_theme_info( $theme ) {
>>>>>>> WPHome/master
		global $themes_allowedtags;

		if ( empty( $theme ) )
			return;

		$name   = wp_kses( $theme->name,   $themes_allowedtags );
		$author = wp_kses( $theme->author, $themes_allowedtags );

<<<<<<< HEAD
		$num_ratings = sprintf( _n( '(based on %s rating)', '(based on %s ratings)', $theme->num_ratings ), number_format_i18n( $theme->num_ratings ) );

=======
>>>>>>> WPHome/master
		$install_url = add_query_arg( array(
			'action' => 'install-theme',
			'theme'  => $theme->slug,
		), self_admin_url( 'update.php' ) );

		$update_url = add_query_arg( array(
			'action' => 'upgrade-theme',
			'theme'  => $theme->slug,
		), self_admin_url( 'update.php' ) );

		$status = $this->_get_theme_status( $theme );

		?>
		<div class="install-theme-info"><?php
			switch ( $status ) {
<<<<<<< HEAD
				default:
				case 'install':
					echo '<a class="theme-install button-primary" href="' . esc_url( wp_nonce_url( $install_url, 'install-theme_' . $theme->slug ) ) . '">' . __( 'Install' ) . '</a>';
					break;
=======
>>>>>>> WPHome/master
				case 'update_available':
					echo '<a class="theme-install button-primary" href="' . esc_url( wp_nonce_url( $update_url, 'upgrade-theme_' . $theme->slug ) ) . '" title="' . esc_attr( sprintf( __( 'Update to version %s' ), $theme->version ) ) . '">' . __( 'Update' ) . '</a>';
					break;
				case 'newer_installed':
				case 'latest_installed':
					echo '<span class="theme-install" title="' . esc_attr__( 'This theme is already installed and is up to date' ) . '">' . _x( 'Installed', 'theme' ) . '</span>';
					break;
<<<<<<< HEAD
=======
				case 'install':
				default:
					echo '<a class="theme-install button-primary" href="' . esc_url( wp_nonce_url( $install_url, 'install-theme_' . $theme->slug ) ) . '">' . __( 'Install' ) . '</a>';
					break;
>>>>>>> WPHome/master
			} ?>
			<h3 class="theme-name"><?php echo $name; ?></h3>
			<span class="theme-by"><?php printf( __( 'By %s' ), $author ); ?></span>
			<?php if ( isset( $theme->screenshot_url ) ): ?>
				<img class="theme-screenshot" src="<?php echo esc_url( $theme->screenshot_url ); ?>" />
			<?php endif; ?>
			<div class="theme-details">
<<<<<<< HEAD
				<div class="star-holder" title="<?php echo esc_attr( $num_ratings ); ?>">
					<div class="star-rating" style="width:<?php echo esc_attr( intval( $theme->rating ) . 'px' ); ?>;"></div>
				</div>
=======
				<?php wp_star_rating( array( 'rating' => $theme->rating, 'type' => 'percent', 'number' => $theme->num_ratings ) ); ?>
>>>>>>> WPHome/master
				<div class="theme-version">
					<strong><?php _e('Version:') ?> </strong>
					<?php echo wp_kses( $theme->version, $themes_allowedtags ); ?>
				</div>
				<div class="theme-description">
					<?php echo wp_kses( $theme->description, $themes_allowedtags ); ?>
				</div>
			</div>
			<input class="theme-preview-url" type="hidden" value="<?php echo esc_url( $theme->preview_url ); ?>" />
		</div>
		<?php
	}

	/**
	 * Send required variables to JavaScript land
	 *
<<<<<<< HEAD
	 * @since 3.4
	 * @access private
=======
	 * @since 3.4.0
	 * @access public
>>>>>>> WPHome/master
	 *
	 * @uses $tab Global; current tab within Themes->Install screen
	 * @uses $type Global; type of search.
	 */
<<<<<<< HEAD
	function _js_vars() {
=======
	public function _js_vars( $extra_args = array() ) {
>>>>>>> WPHome/master
		global $tab, $type;
		parent::_js_vars( compact( 'tab', 'type' ) );
	}

	/**
	 * Check to see if the theme is already installed.
	 *
<<<<<<< HEAD
	 * @since 3.4
=======
	 * @since 3.4.0
>>>>>>> WPHome/master
	 * @access private
	 *
	 * @param object $theme - A WordPress.org Theme API object.
	 * @return string Theme status.
	 */
	private function _get_theme_status( $theme ) {
		$status = 'install';

		$installed_theme = wp_get_theme( $theme->slug );
		if ( $installed_theme->exists() ) {
			if ( version_compare( $installed_theme->get('Version'), $theme->version, '=' ) )
				$status = 'latest_installed';
			elseif ( version_compare( $installed_theme->get('Version'), $theme->version, '>' ) )
				$status = 'newer_installed';
			else
				$status = 'update_available';
		}

		return $status;
	}
}
