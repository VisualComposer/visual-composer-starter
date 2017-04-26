<?php
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">
	<div class="<?php echo vct_get_content_container_class(); ?>">
		<div class="row">
			<div class="col-md-12">
	<?php if ( have_comments() ) : ?>
		<h3 class="comments-title">
			<?php
				$comments_number = get_comments_number();
				if ( $comments_number === 1 ) {
					printf( _x( 'One comment' ), 'Comments' );
				} else {
					printf(
						_nx(
							'%1$s Comment',
							'%1$s Comments',
							$comments_number,
							'comments title',
							'visual-composer-starter'
						),
						number_format_i18n( $comments_number )
					);
				}
			?>
		</h3>
		<p class="comments-subtitle"><?php esc_html_e( 'Join the discussion and tell us your opinion.', 'visual-composer-starter' ); ?></p>

		<?php the_comments_navigation(); ?>

		<ol class="comment-list">
			<?php wp_list_comments(
				array(
					'callback'    => 'visualcomposerstarter_comment',
					'reply_text'  => esc_html__( 'Reply', 'visual-composer-starter' ),
					'avatar_size' => 80,
					'style' 	  => 'ol'
				)
			); ?>
		</ol><!-- .comment-list -->

		<?php the_comments_navigation(); ?>

	<?php endif; // Check for have_comments(). ?>

	<?php
		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>
		<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'twentysixteen' ); ?></p>
	<?php endif; ?>

	<?php
	if (get_comments_number()) {
		comment_form( array(
			'title_reply_before' => '<h2 id="reply-title" class="comment-reply-title">',
			'title_reply_after'  => '</h2>',
			'title_reply' => esc_html__( 'Leave A Comment', 'visual-composer-starter' )
		) );
	}
	else {
		comment_form( array(
			'title_reply_before' => '<h2 id="reply-title" class="comment-reply-title">',
			'title_reply_after'  => '</h2>',
			'title_reply' => esc_html__( 'Share Your Thoughts', 'visual-composer-starter' )
		) );
	}

	?>

</div><!-- .col-md-12 -->
</div><!-- .row -->
</div><!-- .container -->
</div><!-- .comments-area -->
