<?php
/**
 * The template part for displaying content
 *
 * @package WordPress
 * @subpackage Visual_Composer_Theme
 * @since Visual Composer Theme 1.0
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('entry-preview'); ?>>

	<?php visualcomposertheme_post_thumbnail(); ?>

	<?php visualcomposertheme_entry_meta(); ?>

	<div class="entry-content">

		<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

		<?php the_excerpt(); ?>

	</div><!--.entry-content-->

	<?php if( ! is_singular() ):?>
		<a href="<?php echo get_permalink( get_the_ID() ) ?>" class="blue-button read-more"><?php echo __('Read More', 'visual-composer-theme') ?></a>
	<?php endif;?>
</article><!--.entry-preview-->

