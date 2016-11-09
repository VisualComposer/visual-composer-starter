<?php
/**
 * The template part for displaying single posts
 *
 * @package WordPress
 * @subpackage Visual_Composer_Theme
 * @since Visual Composer Theme 1.0
 */
?>
<div class="entry-content">
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <h1><?php the_title() ?></h1>
        <?php the_content() ?>
    </article>
    <?php visualcomposertheme_entry_tags(); ?>
</div><!--.entry-content-->
