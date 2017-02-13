<?php
/**
 * The template part for displaying page content
 *
 * @package WordPress
 * @subpackage Visual Composer Starter
 * @since Visual Composer Starter 1.0
 */
?>
<?php if( vct_is_the_title_displayed() ): ?>
<h1 class="entry-title"><?php the_title(); ?></h1>
<?php endif; ?>

<div class="entry-content">
    <?php the_content( '', true ); ?>
</div><!--.entry-content-->
