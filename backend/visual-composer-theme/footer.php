<footer id="footer">
    <div class="footer-widget-area">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <?php if ( is_active_sidebar( 'footer' )  ) : ?>
                        <?php dynamic_sidebar( 'footer' ); ?>
                    <?php endif; ?>
                </div>
                <div class="col-md-4">
                    <?php if ( is_active_sidebar( 'footer-2' )  ) : ?>
                        <?php dynamic_sidebar( 'footer-2' ); ?>
                    <?php endif; ?>
                </div>
                <div class="col-md-4">
                    <?php if ( is_active_sidebar( 'footer-3' )  ) : ?>
                        <?php dynamic_sidebar( 'footer-3' ); ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container">
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