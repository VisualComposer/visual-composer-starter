<?php
/**
 * The template part for displaying single posts
 *
 * @package WordPress
 * @subpackage Visual Composer Starter
 * @since Visual Composer Starter 1.0
 */

?>
<?php if ( visualcomposerstarter_is_the_title_displayed() && get_the_title() ) : ?>
<h1 class="entry-title"><?php the_title(); ?></h1>
<?php endif; ?>
<div class="entry-content">
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

		<?php the_content( '', true ); ?>
		<?php
			wp_link_pages(
				array(
					'before' => '<div class="nav-links post-inner-navigation">',
					'after' => '</div>',
					'link_before' => '<span>',
					'link_after' => '</span>',
				)
			);
		?>
	</article>
	<?php visualcomposerstarter_entry_tags(); ?>
</div><!--.entry-content-->
