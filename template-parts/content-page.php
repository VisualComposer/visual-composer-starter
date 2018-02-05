<?php
/**
 * The template part for displaying page content
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
</div><!--.entry-content-->
