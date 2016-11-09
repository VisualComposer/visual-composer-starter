<?php get_header(); ?>
    <div class="<?php echo vc_get_content_container_class(); ?>">
        <div class="content-wrapper">
            <div class="row">
                <div class="<?php echo vc_get_maincontent_block_class(); ?>">
                    <div class="main-content">
                        <?php
                        // Start the loop.
                        while ( have_posts() ) : the_post();

                            get_template_part( 'template-parts/content', 'page' );

                        // End the loop.
                        endwhile;
                        ?>
                    </div><!--.main-content-->
                </div><!--.<?php echo vc_get_maincontent_block_class(); ?>-->

                <?php if ( vc_get_sidebar_class() ): ?>
                    <?php get_sidebar(); ?>
                <?php endif; ?>

            </div><!--.row-->
        </div><!--.content-wrapper-->
    </div><!--.<?php echo vc_get_content_container_class(); ?>-->
<?php get_footer(); ?>