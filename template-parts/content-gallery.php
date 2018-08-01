<?php
/**
 * The template part for displaying gallery
 *
 * @package WordPress
 * @subpackage Visual Composer Starter
 * @since Visual Composer Starter 1.0
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry-preview' ); ?>>
	<div class="featured-content">
		<div class="gallery-slider">
			<?php
			$gallery_images = get_post_gallery( get_the_ID(), false );
			$gallery_images_ids = explode( ',', $gallery_images['ids'] );
			$featured_image_width = get_theme_mod( 'vct_overall_site_featured_image_width', 'full_width' );

			foreach ( $gallery_images_ids as $id ) :
				if ( 'full_width' === $featured_image_width ) {
					$image = wp_get_attachment_image_src( $id, 'visualcomposerstarter-featured-loop-image-full' );
				} else {
					$image = wp_get_attachment_image_src( $id, 'visualcomposerstarter-featured-loop-image-boxed' );
				}
				?>
				<div class="gallery-item">
					<div class="fade-in-img">
						<img src="<?php echo esc_url( $image[0] ); ?>" data-src="<?php echo esc_url( $image[0] ); ?>">
						<noscript>
							<img src="<?php echo esc_url( $image[0] ); ?>">
						</noscript>
					</div><!--.fade-in-img-->
				</div><!--.gallery-item-->
				<?php
			endforeach;
			?>
		</div><!--.gallery-slider-->
	</div><!--.featured-content-->

	<?php visualcomposerstarter_entry_meta(); ?>

	<div class="entry-content">

		<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

	</div>
	<?php if ( ! is_singular() ) :?>
		<a href="<?php echo esc_url( get_permalink( get_the_ID() ) ) ?>" class="blue-button read-more"><?php echo esc_html__( 'Read More', 'visual-composer-starter' ) ?></a>
	<?php endif;?>
</article><!--.entry-preview-->
