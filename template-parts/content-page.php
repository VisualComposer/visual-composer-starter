<?php
/**
 * The template part for displaying page content
 *
 * @package WordPress
 * @subpackage Visual_Composer_Theme
 * @since Visual Composer Theme 1.0
 */
?>
<h1 class="entry-title"><?php the_title(); ?></h1>

<div class="entry-content">
    <?php the_content( '', true ); ?>
</div><!--.entry-content-->
