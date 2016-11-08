<?php get_header(); ?>
    <div class="container">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-9">
                    <div class="main-content">
                        <div class="entry-content error-404 not-found">
                            <h1><?php _e( 'Oops! That page can&rsquo;t be found.', 'visual-composer-theme' ); ?></h1>
                            <p><?php _e( 'It looks like nothing was found at this location. Maybe try a search?', 'visual-composer-theme' ); ?></p>
                            <?php get_search_form(); ?>
                        </div>
                    </div>
                </div>

                <?php get_sidebar(); ?>

            </div>
        </div>
    </div>
<?php get_footer(); ?>