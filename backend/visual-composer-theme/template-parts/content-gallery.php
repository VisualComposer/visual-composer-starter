<?php
/**
 * The template part for displaying gallery
 *
 * @package WordPress
 * @subpackage Visual_Composer_Theme
 * @since Visual Composer Theme 1.0
 */
?>
<article class="entry-preview" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="featured-content">
		<div class="gallery-slider">
			<?php
			$attachments = get_children( array(
					'post_parent' => get_the_ID(),
					'post_status' => 'inherit',
					'post_type' => 'attachment',
					'post_mime_type' => 'image',
					'order' => 'ASC',
					'orderby' => 'menu_order ID',
					'numberposts' => 3)
			);
			foreach ( $attachments as $thumb_id => $attachment ):

				$attach = wp_get_attachment_image_src($thumb_id, 'full')
			?>
				<div class="gallery-item">
					<div class="fade-in-img">
						<img src="<?php echo $attach[0];?>" data-src="<?php echo $attach[0];?>" alt="">
						<noscript>
							<img src="<?php echo $attach[0];?>" alt="">
						</noscript>
					</div><!--.fade-in-img-->
				</div><!--.gallery-item-->
				<?php
			endforeach;
			?>
		</div><!--.gallery-slider-->
	</div><!--.featured-content-->

	<?php visualcomposertheme_entry_meta(); ?>

	<div class="entry-content">

		<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

	</div>
	<?php if( ! is_singular() ):?>
		<a href="<?php echo get_permalink( get_the_ID() ) ?>" class="blue-button read-more"><?php echo __('Read More', 'visual-composer-theme') ?></a>
	<?php endif;?>
</article><!--.entry-preview-->

