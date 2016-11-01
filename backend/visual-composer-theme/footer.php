<footer id="footer">
    <div class="footer-widget-area">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="widget">
                        <h3 class="widget-title">About Us</h3>
                        <p>The pear is any of several tree and shrub species of genus Pyrus in the family Rosaceae.</p>
                        <p>It is also the name of the pomaceous fruit of these trees. Several species of pear are valued
                            for their edible fruit, while others are cultivated as ornamental trees.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="widget">
                        <h3 class="widget-title">Instagram</h3>
                        <div class="instagram-feed">
                            <div class="instagram-item"><img src="<?= get_template_directory_uri() ?>/images/footer-img-1.jpg" alt=""></div>
                            <div class="instagram-item"><img src="<?= get_template_directory_uri() ?>/images/footer-img-2.jpg" alt=""></div>
                            <div class="instagram-item"><img src="<?= get_template_directory_uri() ?>/images/footer-img-3.jpg" alt=""></div>
                            <div class="instagram-item"><img src="<?= get_template_directory_uri() ?>/images/footer-img-4.jpg" alt=""></div>
                            <div class="instagram-item"><img src="<?= get_template_directory_uri() ?>/images/footer-img-5.jpg" alt=""></div>
                            <div class="instagram-item"><img src="<?= get_template_directory_uri() ?>/images/footer-img-6.jpg" alt=""></div>
                            <div class="instagram-item"><img src="<?= get_template_directory_uri() ?>/images/footer-img-7.jpg" alt=""></div>
                            <div class="instagram-item"><img src="<?= get_template_directory_uri() ?>/images/footer-img-8.jpg" alt=""></div>
                            <div class="instagram-item"><img src="<?= get_template_directory_uri() ?>/images/footer-img-9.jpg" alt=""></div>
                            <div class="instagram-item"><img src="<?= get_template_directory_uri() ?>/images/footer-img-10.jpg" alt=""></div>

                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="widget">
                        <h3 class="widget-title">Office</h3>
                        <p>
                            2020 Greyrock Avenue, New York City, US, NY 9008<br>
                            T. 001 29393300; 001 29303933<br>
                            F. 001 29299900<br>
                            E. <a href="mailto:office@visualcomposer.io">office@visualcomposer.io</a><br>
                        </p>
                    </div>
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
                <p class="copyright">Copyright &copy; 2016 Visual Composer. All Rights Reserved. Proudly powered by <a
                        href="http://visualcomposer.io">Visual Composer</a> and
                    <a href="https://wordpress.org">WordPress</a></p>
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