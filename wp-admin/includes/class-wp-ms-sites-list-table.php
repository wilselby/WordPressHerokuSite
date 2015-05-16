<?php
/**
 * Sites List Table class.
 *
 * @package WordPress
 * @subpackage List_Table
 * @since 3.1.0
 * @access private
 */
class WP_MS_Sites_List_Table extends WP_List_Table {

<<<<<<< HEAD
	function __construct( $args = array() ) {
=======
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
		parent::__construct( array(
			'plural' => 'sites',
			'screen' => isset( $args['screen'] ) ? $args['screen'] : null,
		) );
	}

<<<<<<< HEAD
	function ajax_user_can() {
		return current_user_can( 'manage_sites' );
	}

	function prepare_items() {
		global $s, $mode, $wpdb, $current_site;
=======
	public function ajax_user_can() {
		return current_user_can( 'manage_sites' );
	}

	public function prepare_items() {
		global $s, $mode, $wpdb;

		$current_site = get_current_site();
>>>>>>> WPHome/master

		$mode = ( empty( $_REQUEST['mode'] ) ) ? 'list' : $_REQUEST['mode'];

		$per_page = $this->get_items_per_page( 'sites_network_per_page' );

		$pagenum = $this->get_pagenum();

<<<<<<< HEAD
		$s = isset( $_REQUEST['s'] ) ? stripslashes( trim( $_REQUEST[ 's' ] ) ) : '';
=======
		$s = isset( $_REQUEST['s'] ) ? wp_unslash( trim( $_REQUEST[ 's' ] ) ) : '';
>>>>>>> WPHome/master
		$wild = '';
		if ( false !== strpos($s, '*') ) {
			$wild = '%';
			$s = trim($s, '*');
		}

<<<<<<< HEAD
		$like_s = esc_sql( like_escape( $s ) );

		// If the network is large and a search is not being performed, show only the latest blogs with no paging in order
		// to avoid expensive count queries.
=======
		/*
		 * If the network is large and a search is not being performed, show only
		 * the latest blogs with no paging in order to avoid expensive count queries.
		 */
>>>>>>> WPHome/master
		if ( !$s && wp_is_large_network() ) {
			if ( !isset($_REQUEST['orderby']) )
				$_GET['orderby'] = $_REQUEST['orderby'] = '';
			if ( !isset($_REQUEST['order']) )
				$_GET['order'] = $_REQUEST['order'] = 'DESC';
		}

		$query = "SELECT * FROM {$wpdb->blogs} WHERE site_id = '{$wpdb->siteid}' ";

		if ( empty($s) ) {
			// Nothing to do.
		} elseif ( preg_match( '/^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$/', $s ) ||
					preg_match( '/^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.?$/', $s ) ||
					preg_match( '/^[0-9]{1,3}\.[0-9]{1,3}\.?$/', $s ) ||
					preg_match( '/^[0-9]{1,3}\.$/', $s ) ) {
			// IPv4 address
<<<<<<< HEAD
			$reg_blog_ids = $wpdb->get_col( "SELECT blog_id FROM {$wpdb->registration_log} WHERE {$wpdb->registration_log}.IP LIKE ( '{$like_s}$wild' )" );
=======
			$sql = $wpdb->prepare( "SELECT blog_id FROM {$wpdb->registration_log} WHERE {$wpdb->registration_log}.IP LIKE %s", $wpdb->esc_like( $s ) . $wild );
			$reg_blog_ids = $wpdb->get_col( $sql );
>>>>>>> WPHome/master

			if ( !$reg_blog_ids )
				$reg_blog_ids = array( 0 );

			$query = "SELECT *
				FROM {$wpdb->blogs}
				WHERE site_id = '{$wpdb->siteid}'
				AND {$wpdb->blogs}.blog_id IN (" . implode( ', ', $reg_blog_ids ) . ")";
		} else {
			if ( is_numeric($s) && empty( $wild ) ) {
<<<<<<< HEAD
				$query .= " AND ( {$wpdb->blogs}.blog_id = '{$like_s}' )";
			} elseif ( is_subdomain_install() ) {
				$blog_s = str_replace( '.' . $current_site->domain, '', $like_s );
				$blog_s .= $wild . '.' . $current_site->domain;
				$query .= " AND ( {$wpdb->blogs}.domain LIKE '$blog_s' ) ";
			} else {
				if ( $like_s != trim('/', $current_site->path) )
					$blog_s = $current_site->path . $like_s . $wild . '/';
				else
					$blog_s = $like_s;
				$query .= " AND  ( {$wpdb->blogs}.path LIKE '$blog_s' )";
=======
				$query .= $wpdb->prepare( " AND ( {$wpdb->blogs}.blog_id = %s )", $s );
			} elseif ( is_subdomain_install() ) {
				$blog_s = str_replace( '.' . $current_site->domain, '', $s );
				$blog_s = $wpdb->esc_like( $blog_s ) . $wild . $wpdb->esc_like( '.' . $current_site->domain );
				$query .= $wpdb->prepare( " AND ( {$wpdb->blogs}.domain LIKE %s ) ", $blog_s );
			} else {
				if ( $s != trim('/', $current_site->path) ) {
					$blog_s = $wpdb->esc_like( $current_site->path . $s ) . $wild . $wpdb->esc_like( '/' );
				} else {
					$blog_s = $wpdb->esc_like( $s );
				}
				$query .= $wpdb->prepare( " AND  ( {$wpdb->blogs}.path LIKE %s )", $blog_s );
>>>>>>> WPHome/master
			}
		}

		$order_by = isset( $_REQUEST['orderby'] ) ? $_REQUEST['orderby'] : '';
		if ( $order_by == 'registered' ) {
			$query .= ' ORDER BY registered ';
		} elseif ( $order_by == 'lastupdated' ) {
			$query .= ' ORDER BY last_updated ';
		} elseif ( $order_by == 'blogname' ) {
			if ( is_subdomain_install() )
				$query .= ' ORDER BY domain ';
			else
				$query .= ' ORDER BY path ';
		} elseif ( $order_by == 'blog_id' ) {
			$query .= ' ORDER BY blog_id ';
		} else {
			$order_by = null;
		}

		if ( isset( $order_by ) ) {
			$order = ( isset( $_REQUEST['order'] ) && 'DESC' == strtoupper( $_REQUEST['order'] ) ) ? "DESC" : "ASC";
			$query .= $order;
		}

		// Don't do an unbounded count on large networks
		if ( ! wp_is_large_network() )
			$total = $wpdb->get_var( str_replace( 'SELECT *', 'SELECT COUNT( blog_id )', $query ) );

		$query .= " LIMIT " . intval( ( $pagenum - 1 ) * $per_page ) . ", " . intval( $per_page );
		$this->items = $wpdb->get_results( $query, ARRAY_A );

		if ( wp_is_large_network() )
			$total = count($this->items);

		$this->set_pagination_args( array(
			'total_items' => $total,
			'per_page' => $per_page,
		) );
	}

<<<<<<< HEAD
	function no_items() {
		_e( 'No sites found.' );
	}

	function get_bulk_actions() {
=======
	public function no_items() {
		_e( 'No sites found.' );
	}

	protected function get_bulk_actions() {
>>>>>>> WPHome/master
		$actions = array();
		if ( current_user_can( 'delete_sites' ) )
			$actions['delete'] = __( 'Delete' );
		$actions['spam'] = _x( 'Mark as Spam', 'site' );
		$actions['notspam'] = _x( 'Not Spam', 'site' );

		return $actions;
	}

<<<<<<< HEAD
	function pagination( $which ) {
=======
	/**
	 * @param string $which
	 */
	protected function pagination( $which ) {
>>>>>>> WPHome/master
		global $mode;

		parent::pagination( $which );

		if ( 'top' == $which )
			$this->view_switcher( $mode );
	}

<<<<<<< HEAD
	function get_columns() {
=======
	public function get_columns() {
>>>>>>> WPHome/master
		$blogname_columns = ( is_subdomain_install() ) ? __( 'Domain' ) : __( 'Path' );
		$sites_columns = array(
			'cb'          => '<input type="checkbox" />',
			'blogname'    => $blogname_columns,
			'lastupdated' => __( 'Last Updated' ),
			'registered'  => _x( 'Registered', 'site' ),
			'users'       => __( 'Users' )
		);

		if ( has_filter( 'wpmublogsaction' ) )
			$sites_columns['plugins'] = __( 'Actions' );

<<<<<<< HEAD
=======
		/**
		 * Filter the displayed site columns in Sites list table.
		 *
		 * @since MU
		 *
		 * @param array $sites_columns An array of displayed site columns. Default 'cb',
		 *                             'blogname', 'lastupdated', 'registered', 'users'.
		 */
>>>>>>> WPHome/master
		$sites_columns = apply_filters( 'wpmu_blogs_columns', $sites_columns );

		return $sites_columns;
	}

<<<<<<< HEAD
	function get_sortable_columns() {
=======
	protected function get_sortable_columns() {
>>>>>>> WPHome/master
		return array(
			'blogname'    => 'blogname',
			'lastupdated' => 'lastupdated',
			'registered'  => 'blog_id',
		);
	}

<<<<<<< HEAD
	function display_rows() {
		global $current_site, $mode;
=======
	public function display_rows() {
		global $mode;
>>>>>>> WPHome/master

		$status_list = array(
			'archived' => array( 'site-archived', __( 'Archived' ) ),
			'spam'     => array( 'site-spammed', _x( 'Spam', 'site' ) ),
			'deleted'  => array( 'site-deleted', __( 'Deleted' ) ),
			'mature'   => array( 'site-mature', __( 'Mature' ) )
		);

<<<<<<< HEAD
		$class = '';
		foreach ( $this->items as $blog ) {
			$class = ( 'alternate' == $class ) ? '' : 'alternate';
=======
		if ( 'list' == $mode ) {
			$date = __( 'Y/m/d' );
		} else {
			$date = __( 'Y/m/d g:i:s a' );
		}

		foreach ( $this->items as $blog ) {
			$class = '';
>>>>>>> WPHome/master
			reset( $status_list );

			$blog_states = array();
			foreach ( $status_list as $status => $col ) {
				if ( get_blog_status( $blog['blog_id'], $status ) == 1 ) {
<<<<<<< HEAD
					$class = $col[0];
=======
					$class = " class='{$col[0]}'";
>>>>>>> WPHome/master
					$blog_states[] = $col[1];
				}
			}
			$blog_state = '';
			if ( ! empty( $blog_states ) ) {
				$state_count = count( $blog_states );
				$i = 0;
				$blog_state .= ' - ';
				foreach ( $blog_states as $state ) {
					++$i;
					( $i == $state_count ) ? $sep = '' : $sep = ', ';
					$blog_state .= "<span class='post-state'>$state$sep</span>";
				}
			}
<<<<<<< HEAD
			echo "<tr class='$class'>";

			$blogname = ( is_subdomain_install() ) ? str_replace( '.'.$current_site->domain, '', $blog['domain'] ) : $blog['path'];
=======
			echo "<tr{$class}>";

			$blogname = ( is_subdomain_install() ) ? str_replace( '.' . get_current_site()->domain, '', $blog['domain'] ) : $blog['path'];
>>>>>>> WPHome/master

			list( $columns, $hidden ) = $this->get_column_info();

			foreach ( $columns as $column_name => $column_display_name ) {
				$style = '';
				if ( in_array( $column_name, $hidden ) )
					$style = ' style="display:none;"';

				switch ( $column_name ) {
					case 'cb': ?>
						<th scope="row" class="check-column">
<<<<<<< HEAD
							<label class="screen-reader-text" for="blog_<?php echo $blog['blog_id']; ?>"><?php printf( __( 'Select %s' ), $blogname ); ?></label>
							<input type="checkbox" id="blog_<?php echo $blog['blog_id'] ?>" name="allblogs[]" value="<?php echo esc_attr( $blog['blog_id'] ) ?>" />
=======
							<?php if ( ! is_main_site( $blog['blog_id'] ) ) : ?>
							<label class="screen-reader-text" for="blog_<?php echo $blog['blog_id']; ?>"><?php printf( __( 'Select %s' ), $blogname ); ?></label>
							<input type="checkbox" id="blog_<?php echo $blog['blog_id'] ?>" name="allblogs[]" value="<?php echo esc_attr( $blog['blog_id'] ) ?>" />
							<?php endif; ?>
>>>>>>> WPHome/master
						</th>
					<?php
					break;

					case 'id':?>
<<<<<<< HEAD
						<th valign="top" scope="row">
=======
						<th scope="row">
>>>>>>> WPHome/master
							<?php echo $blog['blog_id'] ?>
						</th>
					<?php
					break;

					case 'blogname':
						echo "<td class='column-$column_name $column_name'$style>"; ?>
							<a href="<?php echo esc_url( network_admin_url( 'site-info.php?id=' . $blog['blog_id'] ) ); ?>" class="edit"><?php echo $blogname . $blog_state; ?></a>
							<?php
							if ( 'list' != $mode ) {
								switch_to_blog( $blog['blog_id'] );
<<<<<<< HEAD
								echo '<p>' . sprintf( _x( '%1$s &#8211; <em>%2$s</em>', '%1$s: site name. %2$s: site tagline.' ), get_option( 'blogname' ), get_option( 'blogdescription ' ) ) . '</p>';
=======
								/* translators: 1: site name, 2: site tagline. */
								echo '<p>' . sprintf( __( '%1$s &#8211; <em>%2$s</em>' ), get_option( 'blogname' ), get_option( 'blogdescription ' ) ) . '</p>';
>>>>>>> WPHome/master
								restore_current_blog();
							}

							// Preordered.
							$actions = array(
								'edit' => '', 'backend' => '',
								'activate' => '', 'deactivate' => '',
								'archive' => '', 'unarchive' => '',
								'spam' => '', 'unspam' => '',
								'delete' => '',
								'visit' => '',
							);

							$actions['edit']	= '<span class="edit"><a href="' . esc_url( network_admin_url( 'site-info.php?id=' . $blog['blog_id'] ) ) . '">' . __( 'Edit' ) . '</a></span>';
							$actions['backend']	= "<span class='backend'><a href='" . esc_url( get_admin_url( $blog['blog_id'] ) ) . "' class='edit'>" . __( 'Dashboard' ) . '</a></span>';
<<<<<<< HEAD
							if ( $current_site->blog_id != $blog['blog_id'] ) {
=======
							if ( get_current_site()->blog_id != $blog['blog_id'] ) {
>>>>>>> WPHome/master
								if ( get_blog_status( $blog['blog_id'], 'deleted' ) == '1' )
									$actions['activate']	= '<span class="activate"><a href="' . esc_url( wp_nonce_url( network_admin_url( 'sites.php?action=confirm&amp;action2=activateblog&amp;id=' . $blog['blog_id'] . '&amp;msg=' . urlencode( sprintf( __( 'You are about to activate the site %s' ), $blogname ) ) ), 'confirm' ) ) . '">' . __( 'Activate' ) . '</a></span>';
								else
									$actions['deactivate']	= '<span class="activate"><a href="' . esc_url( wp_nonce_url( network_admin_url( 'sites.php?action=confirm&amp;action2=deactivateblog&amp;id=' . $blog['blog_id'] . '&amp;msg=' . urlencode( sprintf( __( 'You are about to deactivate the site %s' ), $blogname ) ) ), 'confirm') ) . '">' . __( 'Deactivate' ) . '</a></span>';

								if ( get_blog_status( $blog['blog_id'], 'archived' ) == '1' )
									$actions['unarchive']	= '<span class="archive"><a href="' . esc_url( wp_nonce_url( network_admin_url( 'sites.php?action=confirm&amp;action2=unarchiveblog&amp;id=' . $blog['blog_id'] . '&amp;msg=' . urlencode( sprintf( __( 'You are about to unarchive the site %s.' ), $blogname ) ) ), 'confirm') ) . '">' . __( 'Unarchive' ) . '</a></span>';
								else
									$actions['archive']	= '<span class="archive"><a href="' . esc_url( wp_nonce_url( network_admin_url( 'sites.php?action=confirm&amp;action2=archiveblog&amp;id=' . $blog['blog_id'] . '&amp;msg=' . urlencode( sprintf( __( 'You are about to archive the site %s.' ), $blogname ) ) ), 'confirm') ) . '">' . _x( 'Archive', 'verb; site' ) . '</a></span>';

								if ( get_blog_status( $blog['blog_id'], 'spam' ) == '1' )
									$actions['unspam']	= '<span class="spam"><a href="' . esc_url( wp_nonce_url( network_admin_url( 'sites.php?action=confirm&amp;action2=unspamblog&amp;id=' . $blog['blog_id'] . '&amp;msg=' . urlencode( sprintf( __( 'You are about to unspam the site %s.' ), $blogname ) ) ), 'confirm') ) . '">' . _x( 'Not Spam', 'site' ) . '</a></span>';
								else
									$actions['spam']	= '<span class="spam"><a href="' . esc_url( wp_nonce_url( network_admin_url( 'sites.php?action=confirm&amp;action2=spamblog&amp;id=' . $blog['blog_id'] . '&amp;msg=' . urlencode( sprintf( __( 'You are about to mark the site %s as spam.' ), $blogname ) ) ), 'confirm') ) . '">' . _x( 'Spam', 'site' ) . '</a></span>';

								if ( current_user_can( 'delete_site', $blog['blog_id'] ) )
									$actions['delete']	= '<span class="delete"><a href="' . esc_url( wp_nonce_url( network_admin_url( 'sites.php?action=confirm&amp;action2=deleteblog&amp;id=' . $blog['blog_id'] . '&amp;msg=' . urlencode( sprintf( __( 'You are about to delete the site %s.' ), $blogname ) ) ), 'confirm') ) . '">' . __( 'Delete' ) . '</a></span>';
							}

							$actions['visit']	= "<span class='view'><a href='" . esc_url( get_home_url( $blog['blog_id'], '/' ) ) . "' rel='permalink'>" . __( 'Visit' ) . '</a></span>';

<<<<<<< HEAD
=======
							/**
							 * Filter the action links displayed for each site in the Sites list table.
							 *
							 * The 'Edit', 'Dashboard', 'Delete', and 'Visit' links are displayed by
							 * default for each site. The site's status determines whether to show the
							 * 'Activate' or 'Deactivate' link, 'Unarchive' or 'Archive' links, and
							 * 'Not Spam' or 'Spam' link for each site.
							 *
							 * @since 3.1.0
							 *
							 * @param array  $actions  An array of action links to be displayed.
							 * @param int    $blog_id  The site ID.
							 * @param string $blogname Site path, formatted depending on whether it is a sub-domain
							 *                         or subdirectory multisite install.
							 */
>>>>>>> WPHome/master
							$actions = apply_filters( 'manage_sites_action_links', array_filter( $actions ), $blog['blog_id'], $blogname );
							echo $this->row_actions( $actions );
					?>
						</td>
					<?php
					break;

					case 'lastupdated':
<<<<<<< HEAD
						echo "<td valign='top' class='$column_name column-$column_name'$style>";
							if ( 'list' == $mode )
								$date = 'Y/m/d';
							else
								$date = 'Y/m/d \<\b\r \/\> g:i:s a';
=======
						echo "<td class='$column_name column-$column_name'$style>";
>>>>>>> WPHome/master
							echo ( $blog['last_updated'] == '0000-00-00 00:00:00' ) ? __( 'Never' ) : mysql2date( $date, $blog['last_updated'] ); ?>
						</td>
					<?php
					break;
				case 'registered':
<<<<<<< HEAD
						echo "<td valign='top' class='$column_name column-$column_name'$style>";
=======
						echo "<td class='$column_name column-$column_name'$style>";
>>>>>>> WPHome/master
						if ( $blog['registered'] == '0000-00-00 00:00:00' )
							echo '&#x2014;';
						else
							echo mysql2date( $date, $blog['registered'] );
						?>
						</td>
					<?php
					break;
				case 'users':
<<<<<<< HEAD
						echo "<td valign='top' class='$column_name column-$column_name'$style>";
=======
						echo "<td class='$column_name column-$column_name'$style>";
>>>>>>> WPHome/master
							$blogusers = get_users( array( 'blog_id' => $blog['blog_id'], 'number' => 6) );
							if ( is_array( $blogusers ) ) {
								$blogusers_warning = '';
								if ( count( $blogusers ) > 5 ) {
									$blogusers = array_slice( $blogusers, 0, 5 );
									$blogusers_warning = __( 'Only showing first 5 users.' ) . ' <a href="' . esc_url( network_admin_url( 'site-users.php?id=' . $blog['blog_id'] ) ) . '">' . __( 'More' ) . '</a>';
								}
								foreach ( $blogusers as $user_object ) {
									echo '<a href="' . esc_url( network_admin_url( 'user-edit.php?user_id=' . $user_object->ID ) ) . '">' . esc_html( $user_object->user_login ) . '</a> ';
									if ( 'list' != $mode )
										echo '( ' . $user_object->user_email . ' )';
									echo '<br />';
								}
								if ( $blogusers_warning != '' )
									echo '<strong>' . $blogusers_warning . '</strong><br />';
							}
							?>
						</td>
					<?php
					break;

				case 'plugins': ?>
					<?php if ( has_filter( 'wpmublogsaction' ) ) {
<<<<<<< HEAD
					echo "<td valign='top' class='$column_name column-$column_name'$style>";
=======
					echo "<td class='$column_name column-$column_name'$style>";
						/**
						 * Fires inside the auxiliary 'Actions' column of the Sites list table.
						 *
						 * By default this column is hidden unless something is hooked to the action.
						 *
						 * @since MU
						 *
						 * @param int $blog_id The site ID.
						 */
>>>>>>> WPHome/master
						do_action( 'wpmublogsaction', $blog['blog_id'] ); ?>
					</td>
					<?php }
					break;

				default:
					echo "<td class='$column_name column-$column_name'$style>";
<<<<<<< HEAD
=======
					/**
					 * Fires for each registered custom column in the Sites list table.
					 *
					 * @since 3.1.0
					 *
					 * @param string $column_name The name of the column to display.
					 * @param int    $blog_id     The site ID.
					 */
>>>>>>> WPHome/master
					do_action( 'manage_sites_custom_column', $column_name, $blog['blog_id'] );
					echo "</td>";
					break;
				}
			}
			?>
			</tr>
			<?php
		}
	}
}
