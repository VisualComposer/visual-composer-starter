<?php get_header(); ?>
<div class="container">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-9">
                    <div class="main-content">
                        <div class="archive">
                            <?php if ( have_posts() ) : ?>
                                
                                <?php
                                // Start the loop.
                                while ( have_posts() ) : the_post();

                                    /*
                                     * Include the Post-Format-specific template for the content.
                                     * If you want to override this in a child theme, then include a file
                                     * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                                     */
                                    get_template_part( 'template-parts/content', get_post_format() );

                                    // End the loop.
                                endwhile;

                            // If no content, include the "No posts found" template.
                            else :
                                get_template_part( 'template-parts/content', 'none' );

                            endif;

                            ?>
                        </div>
                        <div class="pagination">
                            <h2 class="screen-reader-text">Posts navigation</h2>
                            <div class="nav-links archive-navigation">
                                <a class="page-numbers" href="#"><span class="meta-nav screen-reader-text">Page </span>1</a>
                                <a class="page-numbers" href="#"><span class="meta-nav screen-reader-text">Page </span>2</a>
                            <span class="page-numbers current"><span
                                    class="meta-nav screen-reader-text">Page </span>3</span>
                                <a class="page-numbers" href="#"><span class="meta-nav screen-reader-text">Page </span>4</a>
                                <span class="page-numbers dots">&hellip;</span>
                                <a class="page-numbers" href="#"><span class="meta-nav screen-reader-text">Page </span>8</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="sidebar-widget-area">
                        <section class="widget widget_recent_entries">
                            <h3 class="widget-title">Recent Posts</h3>
                            <ul>
                                <li><a href="#">Sweet Corn Increases Ferulic Acid</a></li>
                                <li><a href="#">Economic Botany In Springer New York City Downtown</a></li>
                                <li><a href="#">New Revelations of the Americas Before Columbus</a></li>
                            </ul>
                        </section>
                        <section class="widget widget_search">
                            <form role="search" method="get" class="search-form" action="">
                                <label>
                                    <span class="screen-reader-text">Search for:</span>
                                    <input type="search" class="search-field" placeholder="Search &hellip;" value="" name="s"/>
                                </label>
                                <input type="submit" class="search-submit" value="Search"/>
                            </form>
                        </section>
                        <section class="widget widget_categories">
                            <h3 class="widget-title">Post Categories</h3>
                            <ul>
                                <li><a href="#">Food</a></li>
                                <li><a href="#">Rural Economics</a></li>
                                <li><a href="#">Cooking</a></li>
                                <li><a href="#">Manufacturing</a></li>
                                <li><a href="#">Research</a></li>
                                <li><a href="#">United States</a></li>
                                <li><a href="#">Case Studies</a></li>
                                <li><a href="#">Energy</a></li>
                                <li><a href="#">Green Peace</a></li>
                            </ul>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php get_footer(); ?>