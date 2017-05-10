<?php
/**
 * Template tags
 *
 * @package WordPress
 * @subpackage Visual Composer Starter
 * @since Visual Composer Starter 1.0
 */

if ( ! function_exists( 'visualcomposerstarter_post_thumbnail' ) ) :
	/**
	 * Post Thumbnail.
	 */
	function visualcomposerstarter_post_thumbnail() {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() || ! get_theme_mod( 'vct_overall_site_featured_image', true ) ) {
			return;
		}
			?>
			<div class="featured-content">
				<div class="fade-in-img">
					<img src="<?php the_post_thumbnail_url(); ?>" data-src="<?php the_post_thumbnail_url() ?>" alt="<?php the_title() ?>">
					<noscript>
						<?php the_post_thumbnail(); ?>
					</noscript>
				</div>
			</div><!-- .post-thumbnail -->
		<?php
	}
endif;

if ( ! function_exists( 'visualcomposerstarter_header_featured_content' ) ) :
	/**
	 * Header featured content.
	 */
	function visualcomposerstarter_header_featured_content() {
		if ( 'video' === get_post_format() ) {
			$post = get_post( get_the_ID() );
			remove_filter( 'the_content', 'wpautop' );
			?>
			<div class="<?php echo esc_attr( vct_get_header_image_container_class() ); ?>">
				<div class="row">
					<div class="video-wrapper">
						<?php echo esc_html( apply_filters( 'the_content', $post->post_content ) ); ?>
					</div>
				</div>
			</div>
			<?php
			add_filter( 'the_content', 'wpautop' );
		} elseif ( 'gallery' === get_post_format() ) {
			?>
			<div class="<?php echo esc_attr( vct_get_header_image_container_class() ); ?>">
				<div class="row">
					<div class="gallery-slider">
						<?php
						$gallery = get_post_gallery_images( get_the_ID() );

						foreach ( $gallery as $key => $src ) :
							?>
							<div class="gallery-item">
								<div class="fade-in-img">
									<div class="fade-in-img-inner-wrap">
										<img src="<?php echo esc_url( $src );?>" data-src="<?php echo esc_url( $src );?>" alt="">
										<noscript>
											<img src="<?php echo esc_url( $src );?>" alt="">
										</noscript>
									</div>
								</div><!--.fade-in-img-->
							</div><!--.gallery-item-->
							<?php
						endforeach;
						?>
					</div><!--.gallery-slider-->
				</div>
			</div>

			<?php
		} elseif ( post_password_required() || is_attachment() || ! has_post_thumbnail() || ! get_theme_mod( 'vct_overall_site_featured_image', true ) ) {
			return;
		} else {
			?>
			<div class="<?php echo esc_attr( vct_get_header_image_container_class() ); ?>">
				<div class="row">
					<div class="fade-in-img">
						<div class="fade-in-img-inner-wrap">
							<img src="<?php the_post_thumbnail_url(); ?>" data-src="<?php the_post_thumbnail_url() ?>"
								 alt="<?php the_title() ?>">
							<noscript>
								<?php the_post_thumbnail(); ?>
							</noscript>
						</div>
					</div>
				</div>
			</div>

			<?php
		} // End if().
	}
endif;

if ( ! function_exists( 'visualcomposerstarter_entry_date' ) ) :
	/**
	 * Entry date
	 */
	function visualcomposerstarter_entry_date() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			get_the_date( DATE_W3C ),
			get_the_date(),
			get_the_modified_date( DATE_W3C ),
			get_the_modified_date()
		);

		// Wrap the time string in a link, and preface it with 'Posted on'.
		echo sprintf(
			/* translators: %s: post date */
			esc_html__( '%sPosted on%s %s', 'visual-composer-starter' ),
			'<span class="screen-reader-text">',
			'</span>',
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);
	}
endif;

if ( ! function_exists( 'visualcomposerstarter_entry_meta' ) ) :
	/**
	 * Entry meta
	 */
	function visualcomposerstarter_entry_meta() {
		?>
		<ul class="entry-meta">
			<?php if ( in_array( get_post_type(), array( 'post', 'attachment' ), true ) ) : ?>
				<li class="entry-meta-date">
					<span class="date"><?php visualcomposerstarter_entry_date(); ?></span>
				</li>
			<?php endif;?>
			<?php if ( 'post' === get_post_type() ) : ?>
				<li class="entry-meta-author"><a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"><span class="author vcard"><?php the_author(); ?></span></a></li>
			<?php endif; ?>

			<li class="entry-meta-category"><?php the_category( _x( ', ', 'Used between list items, there is a space after the comma.', 'visual-composer-starter' ) ); ?></li>

			<?php if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) : ?>
				<li class="entry-meta-comments"><?php comments_popup_link( __( 'Leave a comment', 'visual-composer-starter' ), __( '1 Comment', 'visual-composer-starter' ), __( '% Comments', 'visual-composer-starter' ) ); ?>
			<?php endif; ?>

			</li>
		</ul>
		<?php
	}
endif;

if ( ! function_exists( 'visualcomposerstarter_single_meta' ) ) :
	/**
	 * Single meta
	 */
	function visualcomposerstarter_single_meta() {
		?>
		<div class="entry-meta">
			<?php echo esc_html( _x( 'On', 'Post meta' ) ); ?>
			<?php if ( in_array( get_post_type(), array( 'post', 'attachment' ), true ) ) : ?>
				<span class="date"><?php visualcomposerstarter_entry_date(); ?></span>
			<?php endif;?>
			<?php echo esc_html( _x( 'by', 'Post meta' ) ); ?>
			<?php if ( 'post' === get_post_type() ) : ?>
				<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"><span class="author vcard"><?php echo get_the_author(); ?></span></a>
			<?php endif; ?>
			<?php echo esc_html( _x( 'to', 'Post meta' ) ); ?>
			<?php the_category( _x( ', ', 'Used between list items, there is a space after the comma.', 'visual-composer-starter' ) ); ?>
		</div>
		<?php
	}
endif;

if ( ! function_exists( 'visualcomposerstarter_entry_tags' ) ) :

	/**
	 * Entry tags.
	 */
	function visualcomposerstarter_entry_tags() {
		$tags_list = get_the_tag_list();
		if ( $tags_list ) {
			printf( '<div class="entry-tags"><span class="screen-reader-text">%1$s </span>%2$s</div>',
				esc_html( _x( 'Tags', 'Used before tag names.', 'visual-composer-starter' ) ),
				$tags_list
			);
		}
	}
endif;

if ( ! function_exists( 'visualcomposerstarter_comment' ) ) :

	/**
	 * Comment
	 *
	 * @param string  $comment Comment data.
	 * @param array   $args Args.
	 * @param integer $depth Depth.
	 */
	function visualcomposerstarter_comment( $comment, $args, $depth ) {
		if ( 'div' === $args['style'] ) {
			$tag       = 'div';
			$add_below = 'comment';
		} else {
			$tag       = 'li';
			$add_below = 'div-comment';
		}
		?>
		<<?php echo esc_html( $tag ); ?> <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?> id="comment-<?php comment_ID(); ?>">
		<?php if ( 'div' !== $args['style'] ) : ?>
			<div id="div-comment-<?php comment_ID(); ?>" class="comment-body">
		<?php endif; ?>
		<div class="author-avatar">
			<div class="fade-in-image">
				<?php if ( 0 !== $args['avatar_size'] ) : ?>
					<img src="<?php echo esc_url( get_avatar_url( $comment, array(
						'size' => $args['avatar_size'],
					) ) ); ?>"
						data-src="<?php echo esc_url( get_avatar_url( $comment, array(
							'size' => $args['avatar_size'],
						) ) ); ?>">
					<noscript>
						<img src="<?php echo esc_url( get_avatar_url( $comment, array(
							'size' => $args['avatar_size'],
						) ) ); ?>">
					</noscript>
				<?php endif; ?>
			</div>
		</div>
		<div class="comment-wrapper">
			<footer class="comment-meta">
				<div class="comment-author vcard">
					<?php  printf( esc_html__("%s %s says: %s", "visual-composer-starter"), '<cite>'.get_comment_author_link().'</cite>', '<span class="says">', '</span>' ); ?>
				</div>
				<div class="comment-metadata">
					<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
						<?php
						/* translators: 1: date, 2: time */
						printf( esc_html__( 'On %1$s at %2$s' ), get_comment_date(),  get_comment_time() ); ?>
					</a>
					<?php edit_comment_link( __( '(Edit)' ), '  ', '' ); ?>
					<?php if ( '0' === $comment->comment_approved ) : ?>
						<em class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.' ); ?></em>
					<?php endif; ?>
				</div>
			</footer>
			<div class="comment-content">
				<?php comment_text(); ?>
			</div>
			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array(
					'add_below' => $add_below,
					'depth' => $depth,
					'max_depth' => $args['max_depth'],
				))); ?>
			</div>
		</div>

		<?php if ( 'div' !== $args['style'] ) : ?>
			</div>
		<?php endif; ?>
		</<?php echo esc_html( $tag ); ?>>
		<?php
	}
endif;
