<?php
/**
 * @package Decode
 */
?>

<?php if ( has_post_format( 'quote' ) ) : ?>
	
		<?php tha_entry_before(); ?>
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<?php tha_entry_top(); ?>
		
		<div class="entry-content">
			<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'decode' ) ); ?>
		</div>
		
		<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'decode' ), 'after' => '</div>' ) ); ?>
		
		<footer class="entry-footer">
			<?php if ( get_theme_mod( 'show_author_section', false ) == true ) : ?>
				<section class="author-section cf">
					<div class="author-image"><a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) )?>" rel="author"><?php echo get_avatar( get_the_author_meta( 'ID' ), 250 ); ?></a></div>
					<div class="author-text">
						<div class="author-name"><a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) )?>" rel="author"><?php echo get_the_author_meta( 'display_name' ); ?></a></div>
						<?php if ( get_the_author_meta( 'user_url' ) ) echo '<div class="author-site"><a href="' . get_the_author_meta( 'user_url' ) . '" rel="me">' . __( 'Website', 'decode' ) . '</a></div>'; ?>
						<?php if ( get_the_author_meta( 'google_profile' ) ) echo '<a href="' . esc_url( get_the_author_meta( 'google_profile' ) . '?rel=author' ) . '" class="screen-reader-text"></a>'; ?>
						<div class="author-bio"><?php echo get_the_author_meta( 'description' ); ?></div>
					</div>
				</section>
			<?php endif; ?>
			<?php edit_post_link( __( 'Edit', 'decode' ), '<div class="edit-link">', '</div>' ); ?>
			<div class="entry-meta">
				<p class="tags"><?php the_tags( __( 'Tagged as: ', 'decode' ),', ' ); ?></p>
				<p class="categories"><?php _e( 'Categorized in&#58; ', 'decode' ) . the_category( ', ' ); ?></p>
				<p class="date"><?php decode_posted_on(); ?></p>
			</div>
		</footer><!-- .entry-footer -->
		
		<?php tha_entry_bottom(); ?>
	</article><!-- #post-<?php the_ID(); ?> -->
		<?php tha_entry_after(); ?>
		
<?php elseif ( has_post_format( 'link' ) ): ?>

		<?php tha_entry_before(); ?>
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<?php tha_entry_top(); ?>
		
		<header class="entry-header">
			<?php if ( has_post_thumbnail() && get_theme_mod( 'show_featured_images_on_singles', false ) == true ) : ?>
			<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
				<?php the_post_thumbnail(); ?>
			</a>
			<?php endif; ?>
			<div class="entry-title"><h2><?php decode_print_post_title() ?><?php if (get_theme_mod( 'link_post_title_arrow', false ) == true ) echo '<span class="link-title-arrow">&#8594;</span>'; ?></h2></div>
			<?php if ( get_theme_mod( 'entry_date_position', 'below' ) == 'above' ) : ?>
			<div class="entry-meta">
				<p class="date"><?php decode_posted_on(); ?></p>
			</div><!-- .entry-meta -->
			<?php endif; ?>
		</header>
		
		<div class="entry-content">
			<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'decode' ) ); ?>
		</div>
		
		<footer class="entry-footer">
			<?php if ( get_theme_mod( 'show_author_section', false ) == true ) : ?>
				<section class="author-section cf">
					<div class="author-image"><a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) )?>" rel="author"><?php echo get_avatar( get_the_author_meta( 'ID' ), 250 ); ?></a></div>
					<div class="author-text">
						<div class="author-name"><a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) )?>" rel="author"><?php echo get_the_author_meta( 'display_name' ); ?></a></div>
						<?php if ( get_the_author_meta( 'user_url' ) ) echo '<div class="author-site"><a href="' . get_the_author_meta( 'user_url' ) . '" rel="me">' . __( 'Website', 'decode' ) . '</a></div>'; ?>
						<?php if ( get_the_author_meta( 'google_profile' ) ) echo '<a href="' . esc_url( get_the_author_meta( 'google_profile' ) . '?rel=author' ) . '" class="screen-reader-text"></a>'; ?>
						<div class="author-bio"><?php echo get_the_author_meta( 'description' ); ?></div>
					</div>
				</section>
			<?php endif; ?>
			<?php edit_post_link( __( 'Edit', 'decode' ), '<div class="edit-link">', '</div>' ); ?>
			<div class="entry-meta">
				<p class="tags"><?php the_tags( __( 'Tagged as: ', 'decode' ),', ' ); ?></p>
				<p class="categories"><?php _e( 'Categorized in&#58; ', 'decode' ) . the_category( ', ' ); ?></p>
				<?php if ( get_theme_mod( 'entry_date_position', 'below' ) == 'below' ) : ?>
					<p class="date"><?php decode_posted_on(); ?></p>
				<?php endif; ?>
			</div>
		</footer><!-- .entry-footer -->
		
		<?php tha_entry_bottom(); ?>
	</article>
		<?php tha_entry_after(); ?>
	
<?php else : ?>

		<?php tha_entry_before(); ?>
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<?php tha_entry_top(); ?>
		
		<header class="entry-header">
			<?php if ( has_post_thumbnail() && get_theme_mod( 'show_featured_images_on_singles', false ) == true ) : ?>
			<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" >
				<?php the_post_thumbnail(); ?>
			</a>
			<?php endif; ?>
			<div class="entry-title"><h2><?php the_title(); ?></h2></div>
			<?php if ( get_theme_mod( 'entry_date_position', 'below' ) == 'above' ) : ?>
			<div class="entry-meta">
				<p class="date"><?php decode_posted_on(); ?></p>
			</div><!-- .entry-meta -->
			<?php endif; ?>
		</header><!-- .entry-header -->
		
		<div class="entry-content">
			<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'decode' ) ); ?>
		</div>
		
		<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'decode' ), 'after' => '</div>' ) ); ?>
		
		<footer class="entry-footer">
			<?php if ( get_theme_mod( 'show_author_section', false ) == true ) : ?>
				<section class="author-section cf">
					<div class="author-image"><a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) )?>" rel="author"><?php echo get_avatar( get_the_author_meta( 'ID' ), 250 ); ?></a></div>
					<div class="author-text">
						<div class="author-name"><a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) )?>" rel="author"><?php echo get_the_author_meta( 'display_name' ); ?></a></div>
						<?php if ( get_the_author_meta( 'user_url' ) ) echo '<div class="author-site"><a href="' . get_the_author_meta( 'user_url' ) . '" rel="me">' . __( 'Website', 'decode' ) . '</a></div>'; ?>
						<?php if ( get_the_author_meta( 'google_profile' ) ) echo '<a href="' . esc_url( get_the_author_meta( 'google_profile' ) . '?rel=author' ) . '" class="screen-reader-text"></a>'; ?>
						<div class="author-bio"><?php echo get_the_author_meta( 'description' ); ?></div>
					</div>
				</section>
			<?php endif; ?>
			<?php edit_post_link( __( 'Edit', 'decode' ), '<div class="edit-link">', '</div>' ); ?>
			<div class="entry-meta">
				<p class="tags"><?php the_tags( __( 'Tagged as: ', 'decode' ),', ' ); ?></p>
				<p class="categories"><?php _e( 'Categorized in&#58; ', 'decode' ) . the_category( ', ' ); ?></p>
				<?php if ( get_theme_mod( 'entry_date_position', 'below' ) == 'below' ) : ?>
					<p class="date"><?php decode_posted_on(); ?></p>
				<?php endif; ?>
			</div>
		</footer><!-- .entry-footer -->
		
		<?php tha_entry_bottom(); ?>
	</article><!-- #post-<?php the_ID(); ?> -->
		<?php tha_entry_after(); ?>

<?php endif; ?>