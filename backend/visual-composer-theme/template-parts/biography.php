<?php
/**
 * The template part for displaying an Author biography
 *
 * @package WordPress
 * @subpackage Visual_Composer_Theme
 * @since Visual Composer Theme 1.0
 */
?>
<div class="entry-author-data">
    <div class="author-avatar">
        <div class="fade-in-img">
            <img src="<?php echo get_avatar_url( get_the_author_meta( 'ID' ), array( 'size' => 100 ) ); ?>"
                 data-src="<?php echo get_avatar_url( get_the_author_meta( 'ID' ), array( 'size' => 100 ) ); ?>"
                 alt="<?php the_author(); ?>">
            <noscript>
                <img src="<?php echo get_avatar_url( get_the_author_meta( 'ID' ), array( 'size' => 100 ) ); ?>"
                     alt="<?php the_author(); ?>">
            </noscript>
        </div>
    </div><!--.author-avatar-->
    <p class="author-name"><?php the_author(); ?></p>
    <p class="author-biography"><?php the_author_meta( 'description' ) ?></p>
</div><!--.entry-author-data-->