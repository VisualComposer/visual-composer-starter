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
			$gallery = get_post_gallery_images( get_the_ID() );

			foreach ( $gallery as $key => $src ) :
				?>
				<div class="gallery-item">
					<div class="fade-in-img">
						<img src="<?php echo esc_url( $src );?>" data-src="<?php echo esc_url( $src );?>">
						<noscript>
							<img src="<?php echo esc_url( $src );?>">
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
