<?php
/**
 * Single
 *
 * @package WordPress
 * @subpackage Visual Composer Starter
 * @since Visual Composer Starter 1.0
 */

get_header();
// Start the loop.
while ( have_posts() ) :
	the_post();
?>
<div class="<?php echo esc_attr( vct_get_content_container_class() ); ?>">
	<div class="content-wrapper">
		<div class="row">
			<div class="col-md-12">
				<div class="main-content">
					<article class="entry-full-content">
						<div class="row">
							<div class="<?php echo esc_attr( vct_get_maincontent_block_class() ); ?>">
								<div class="col-md-2">
									<?php
										get_template_part( 'template-parts/biography' );
									?>
								</div><!--.col-md-2-->
								<div class="col-md-10">
									<?php
									visualcomposerstarter_single_meta();
									get_template_part( 'template-parts/content', 'single' );

									if ( is_singular( 'post' ) ) : ?>
										<div class="nav-links post-navigation">
											<div class="row">
												<div class="col-md-5">
													<div class="nav-previous">
														<?php $prev_post = wpcom_vip_get_adjacent_post( true, '', true, 'taxonomy_slug' ); ?>
														<?php if ( is_a( $prev_post, 'WP_Post' ) ) { ?>
															<span class="meta-nav"><?php echo esc_html__( 'Previous', 'visual-composer-starter' )  ?></span>
															<span class="screen-reader-text"><?php echo esc_html__( 'Previous post:', 'visual-composer-starter' ) ?></span>
															<span class="post-title"><?php echo get_the_title( $prev_post->ID ); ?></span>'
														<?php } ?>
													</div><!--nav-previous-->
												</div><!--.col-md-5-->
												<div class="col-md-5 col-md-offset-2">
													<div class="nav-next">
														<?php $next_post = wpcom_vip_get_adjacent_post( true, '', false, 'taxonomy_slug' ); ?>
														<?php if ( is_a( $next_post, 'WP_Post' ) ) { ?>
															<span class="meta-nav"><?php echo esc_html__( 'Previous', 'visual-composer-starter' )  ?></span>
															<span class="screen-reader-text"><?php echo esc_html__( 'Previous post:', 'visual-composer-starter' ) ?></span>
															<span class="post-title"><?php echo get_the_title( $next_post->ID ); ?></span>'
														<?php } ?>
													</div><!--.nav-next-->
												</div><!--.col-md-5-->
											</div><!--.row-->
										</div><!--.nav-links post-navigation-->
									<?php endif; ?>
								</div><!--.col-md-10-->
							</div><!--.<?php echo esc_html( vct_get_maincontent_block_class() ); ?>-->
							<?php if ( vct_get_sidebar_class() ) : ?>
								<?php get_sidebar(); ?>
							<?php endif; ?>
						</div><!--.row-->
					</article><!--.entry-full-content-->
				</div><!--.main-content-->
			</div>
		</div><!--.row-->
	</div><!--.content-wrapper-->
</div><!--.<?php echo esc_html( vct_get_content_container_class() ); ?>-->
<?php if ( comments_open() || get_comments_number() ) {
	comments_template();
}
// End of the loop.
endwhile;
get_footer();
