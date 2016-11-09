<footer id="footer">
    <?php
        $footer_columns = get_theme_mod( 'vc_footer_area_widgetized_columns', 0 );
        if ( $footer_columns > 0 ):
            $footer_columns_width = 12/$footer_columns;
        ?>
            <div class="footer-widget-area">
                <div class="<?php echo vc_get_content_container_class(); ?>">
                    <div class="row">
                        <div class="col-md-<?php echo $footer_columns_width; ?>">
                            <?php if ( is_active_sidebar( 'footer' )  ) : ?>
                                <?php dynamic_sidebar( 'footer' ); ?>
                            <?php endif; ?>
                        </div>
                        <?php for ( $i = 2; $i <= $footer_columns; $i++ ): ?>
                        <div class="col-md-<?php echo $footer_columns_width; ?>">
                            <?php if ( is_active_sidebar( 'footer-'.$i )  ) : ?>
                                <?php dynamic_sidebar( 'footer-'.$i ); ?>
                            <?php endif; ?>
                        </div>
                        <?php endfor; ?>
                    </div>
                </div>
        </div>
    <?php endif; ?>
    <div class="footer-bottom">
        <div class="<?php echo vc_get_content_container_class(); ?>">
            <div class="footer-right-block">
                <div class="footer-socials">
                    <ul>
                        <li><a href="#"><span class="vc-icon-facebook-with-circle"></span></a></li>
                        <li><a href="#"><span class="vc-icon-twitter-with-circle"></span></a></li>
                        <li><a href="#"><span class="vc-icon-instagram-with-circle"></span></a></li>
                        <li><a href="#"><span class="vc-icon-vimeo-with-circle"></span></a></li>
                        <li><a href="mailto:"><span class="vc-icon-mail-circle"></span></a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-left-block">
                <p class="copyright">Copyright &copy; <?php echo date('Y') ?> <?php bloginfo('name') ?>. All Rights Reserved. Proudly powered by <a href="http://visualcomposer.io">Visual Composer</a> and <a href="https://wordpress.org">WordPress</a></p>
                <?php if ( has_nav_menu( 'secondary' ) ) : ?>
                    <div class="footer-menu">
                        <?php
                        wp_nav_menu( array(
                            'theme_location' => 'secondary'
                        ) );
                        ?>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
</footer>
<?php wp_footer() ?>
</body>
</html>