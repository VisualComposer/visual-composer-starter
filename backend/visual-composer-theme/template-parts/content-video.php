<?php
/**
 * The template part for displaying video
 *
 * @package WordPress
 * @subpackage Visual_Composer_Theme
 * @since Visual Composer Theme 1.0
 */
?>
<article class="entry-preview" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="featured-content">
		<div class="video-wrapper">
			<?php the_content( '', TRUE );?>
		</div>
	</div>

	<?php visualcomposertheme_entry_meta(); ?>

	<div class="entry-content">

		<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

		<p>
		<?php

		echo get_the_content( '', FALSE );
		
		?>
		</p>

	</div>
	<?php if( ! is_singular() ):?>
		<a href="<?php echo get_permalink( get_the_ID() ) ?>" class="blue-button read-more"><?php echo __('Read More', 'visual-composer-theme') ?></a>
	<?php endif;?>
</article>

