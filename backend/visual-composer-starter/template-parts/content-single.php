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
        <h1><?php the_title(); ?></h1>
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
