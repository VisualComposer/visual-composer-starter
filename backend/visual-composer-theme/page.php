<?php get_header(); ?>
    <div class="container">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-9">
                    <div class="main-content">
                        <?php
                        // Start the loop.
                        while ( have_posts() ) : the_post();

                            get_template_part( 'template-parts/content', 'page' );

                        // End the loop.
                        endwhile;
                        ?>
                    </div>
                </div>

                <?php get_sidebar(); ?>

            </div>
        </div>
    </div>
<?php get_footer(); ?>