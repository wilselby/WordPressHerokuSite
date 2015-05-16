<?php
/**
<<<<<<< HEAD
 * Makes a custom Widget for displaying Aside, Link, Status, and Quote Posts available with Twenty Eleven
 *
 * Learn more: http://codex.wordpress.org/Widgets_API#Developing_Widgets
=======
 * Widget For displaying post format posts
 *
 * Handles displaying Aside, Link, Status, and Quote Posts available with Twenty Eleven.
 *
 * @link https://codex.wordpress.org/Widgets_API#Developing_Widgets
>>>>>>> WPHome/master
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */
class Twenty_Eleven_Ephemera_Widget extends WP_Widget {

	/**
	 * Constructor
	 *
<<<<<<< HEAD
	 * @return void
=======
	 * @since Twenty Eleven 1.0
>>>>>>> WPHome/master
	 **/
	function Twenty_Eleven_Ephemera_Widget() {
		$widget_ops = array( 'classname' => 'widget_twentyeleven_ephemera', 'description' => __( 'Use this widget to list your recent Aside, Status, Quote, and Link posts', 'twentyeleven' ) );
		$this->WP_Widget( 'widget_twentyeleven_ephemera', __( 'Twenty Eleven Ephemera', 'twentyeleven' ), $widget_ops );
		$this->alt_option_name = 'widget_twentyeleven_ephemera';

<<<<<<< HEAD
		add_action( 'save_post', array(&$this, 'flush_widget_cache' ) );
		add_action( 'deleted_post', array(&$this, 'flush_widget_cache' ) );
		add_action( 'switch_theme', array(&$this, 'flush_widget_cache' ) );
=======
		add_action( 'save_post', array( &$this, 'flush_widget_cache' ) );
		add_action( 'deleted_post', array( &$this, 'flush_widget_cache' ) );
		add_action( 'switch_theme', array( &$this, 'flush_widget_cache' ) );
>>>>>>> WPHome/master
	}

	/**
	 * Outputs the HTML for this widget.
	 *
<<<<<<< HEAD
	 * @param array An array of standard parameters for widgets in this theme
	 * @param array An array of settings for this widget instance
	 * @return void Echoes it's output
=======
	 * @since Twenty Eleven 1.0
	 *
	 * @param array $args     An array of standard parameters for widgets in this theme.
	 * @param array $instance An array of settings for this widget instance.
>>>>>>> WPHome/master
	 **/
	function widget( $args, $instance ) {
		$cache = wp_cache_get( 'widget_twentyeleven_ephemera', 'widget' );

<<<<<<< HEAD
		if ( !is_array( $cache ) )
=======
		if ( ! is_array( $cache ) )
>>>>>>> WPHome/master
			$cache = array();

		if ( ! isset( $args['widget_id'] ) )
			$args['widget_id'] = null;

<<<<<<< HEAD
		if ( isset( $cache[$args['widget_id']] ) ) {
			echo $cache[$args['widget_id']];
=======
		if ( isset( $cache[ $args['widget_id'] ] ) ) {
			echo $cache[ $args['widget_id'] ];
>>>>>>> WPHome/master
			return;
		}

		ob_start();
		extract( $args, EXTR_SKIP );

<<<<<<< HEAD
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? __( 'Ephemera', 'twentyeleven' ) : $instance['title'], $instance, $this->id_base);
=======
		/** This filter is documented in wp-includes/default-widgets.php */
		$args['title'] = apply_filters( 'widget_title', empty( $instance['title'] ) ? __( 'Ephemera', 'twentyeleven' ) : $instance['title'], $instance, $this->id_base );
>>>>>>> WPHome/master

		if ( ! isset( $instance['number'] ) )
			$instance['number'] = '10';

<<<<<<< HEAD
		if ( ! $number = absint( $instance['number'] ) )
 			$number = 10;

		$ephemera_args = array(
			'order' => 'DESC',
			'posts_per_page' => $number,
			'no_found_rows' => true,
			'post_status' => 'publish',
			'post__not_in' => get_option( 'sticky_posts' ),
			'tax_query' => array(
				array(
					'taxonomy' => 'post_format',
					'terms' => array( 'post-format-aside', 'post-format-link', 'post-format-status', 'post-format-quote' ),
					'field' => 'slug',
=======
		if ( ! $args['number'] = absint( $instance['number'] ) )
			$args['number'] = 10;

		$ephemera_args = array(
			'order'          => 'DESC',
			'posts_per_page' => $args['number'],
			'no_found_rows'  => true,
			'post_status'    => 'publish',
			'post__not_in'   => get_option( 'sticky_posts' ),
			'tax_query'      => array(
				array(
					'taxonomy' => 'post_format',
					'terms'    => array( 'post-format-aside', 'post-format-link', 'post-format-status', 'post-format-quote' ),
					'field'    => 'slug',
>>>>>>> WPHome/master
					'operator' => 'IN',
				),
			),
		);
		$ephemera = new WP_Query( $ephemera_args );

		if ( $ephemera->have_posts() ) :
<<<<<<< HEAD
			echo $before_widget;
			echo $before_title;
			echo $title; // Can set this with a widget option, or omit altogether
			echo $after_title;
=======
			echo $args['before_widget'];
			echo $args['before_title'];
			echo $args['title'];
			echo $args['after_title'];
>>>>>>> WPHome/master
			?>
			<ol>
			<?php while ( $ephemera->have_posts() ) : $ephemera->the_post(); ?>

				<?php if ( 'link' != get_post_format() ) : ?>

				<li class="widget-entry-title">
<<<<<<< HEAD
					<a href="<?php echo esc_url( get_permalink() ); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'twentyeleven' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
=======
					<a href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark"><?php the_title(); ?></a>
>>>>>>> WPHome/master
					<span class="comments-link">
						<?php comments_popup_link( __( '0 <span class="reply">comments &rarr;</span>', 'twentyeleven' ), __( '1 <span class="reply">comment &rarr;</span>', 'twentyeleven' ), __( '% <span class="reply">comments &rarr;</span>', 'twentyeleven' ) ); ?>
					</span>
				</li>

				<?php else : ?>

				<li class="widget-entry-title">
<<<<<<< HEAD
					<?php
						// Grab first link from the post content. If none found, use the post permalink as fallback.
						$link_url = twentyeleven_url_grabber();

						if ( empty( $link_url ) )
							$link_url = get_permalink();
					?>
					<a href="<?php echo esc_url( $link_url ); ?>" title="<?php echo esc_attr( sprintf( __( 'Link to %s', 'twentyeleven' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?>&nbsp;<span>&rarr;</span></a>
=======
					<a href="<?php echo esc_url( twentyeleven_get_first_url() ); ?>" rel="bookmark"><?php the_title(); ?>&nbsp;<span>&rarr;</span></a>
>>>>>>> WPHome/master
					<span class="comments-link">
						<?php comments_popup_link( __( '0 <span class="reply">comments &rarr;</span>', 'twentyeleven' ), __( '1 <span class="reply">comment &rarr;</span>', 'twentyeleven' ), __( '% <span class="reply">comments &rarr;</span>', 'twentyeleven' ) ); ?>
					</span>
				</li>

				<?php endif; ?>

			<?php endwhile; ?>
			</ol>
			<?php

<<<<<<< HEAD
			echo $after_widget;
=======
			echo $args['after_widget'];
>>>>>>> WPHome/master

			// Reset the post globals as this query will have stomped on it
			wp_reset_postdata();

		// end check for ephemeral posts
		endif;

<<<<<<< HEAD
		$cache[$args['widget_id']] = ob_get_flush();
=======
		$cache[ $args['widget_id'] ] = ob_get_flush();
>>>>>>> WPHome/master
		wp_cache_set( 'widget_twentyeleven_ephemera', $cache, 'widget' );
	}

	/**
<<<<<<< HEAD
	 * Deals with the settings when they are saved by the admin. Here is
	 * where any validation should be dealt with.
=======
	 * Update widget settings.
	 *
	 * Deals with the settings when they are saved by the admin. Here is
	 * where any validation should be dealt with.
	 *
	 * @since Twenty Eleven 1.0
>>>>>>> WPHome/master
	 **/
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['number'] = (int) $new_instance['number'];
		$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset( $alloptions['widget_twentyeleven_ephemera'] ) )
			delete_option( 'widget_twentyeleven_ephemera' );

		return $instance;
	}

<<<<<<< HEAD
=======
	/**
	 * Flush widget cache.
	 *
	 * @since Twenty Eleven 1.0
	 */
>>>>>>> WPHome/master
	function flush_widget_cache() {
		wp_cache_delete( 'widget_twentyeleven_ephemera', 'widget' );
	}

	/**
<<<<<<< HEAD
	 * Displays the form for this widget on the Widgets page of the WP Admin area.
=======
	 * Set up the widget form.
	 *
	 * Displays the form for this widget on the Widgets page of the WP Admin area.
	 *
	 * @since Twenty Eleven 1.0
>>>>>>> WPHome/master
	 **/
	function form( $instance ) {
		$title = isset( $instance['title']) ? esc_attr( $instance['title'] ) : '';
		$number = isset( $instance['number'] ) ? absint( $instance['number'] ) : 10;
?>
			<p><label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:', 'twentyeleven' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" /></p>

			<p><label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"><?php _e( 'Number of posts to show:', 'twentyeleven' ); ?></label>
			<input id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" type="text" value="<?php echo esc_attr( $number ); ?>" size="3" /></p>
		<?php
	}
<<<<<<< HEAD
}
=======
}
>>>>>>> WPHome/master
