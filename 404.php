<?php get_header(); ?>
    <div class="<?php echo vct_get_content_container_class(); ?>">
        <div class="content-wrapper">
            <div class="row">
                <div class="<?php echo vct_get_maincontent_block_class(); ?>">
                    <div class="main-content">
                        <div class="entry-content error-404 not-found">
                            <h1><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'visual-composer-starter' ); ?></h1>
                            <p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try a search?', 'visual-composer-starter' ); ?></p>
                            <?php get_search_form(); ?>
                        </div><!--.entry-content-->
                    </div><!--.main-content-->
                </div><!--.<?php echo vct_get_maincontent_block_class(); ?>-->

                <?php if ( vct_get_sidebar_class() ): ?>
                    <?php get_sidebar(); ?>
                <?php endif; ?>

            </div><!--.row-->
        </div><!--.content-wrapper-->
    </div><!--.<?php echo vct_get_content_container_class(); ?>-->
<?php get_footer();
