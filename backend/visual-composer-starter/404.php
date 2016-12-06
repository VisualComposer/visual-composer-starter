<?php get_header(); ?>
    <div class="<?php echo vc_get_content_container_class(); ?>">
        <div class="content-wrapper">
            <div class="row">
                <div class="<?php echo vc_get_maincontent_block_class(); ?>">
                    <div class="main-content">
                        <div class="entry-content error-404 not-found">
                            <h1><?php _e( 'Oops! That page can&rsquo;t be found.', 'visual-composer-starter' ); ?></h1>
                            <p><?php _e( 'It looks like nothing was found at this location. Maybe try a search?', 'visual-composer-starter' ); ?></p>
                            <?php get_search_form(); ?>
                        </div><!--.entry-content-->
                    </div><!--.main-content-->
                </div><!--.<?php echo vc_get_maincontent_block_class(); ?>-->

                <?php if ( vc_get_sidebar_class() ): ?>
                    <?php get_sidebar(); ?>
                <?php endif; ?>

            </div><!--.row-->
        </div><!--.content-wrapper-->
    </div><!--.<?php echo vc_get_content_container_class(); ?>-->
<?php get_footer(); ?>