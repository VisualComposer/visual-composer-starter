<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:400,400i,700,700i|Roboto:400,400i,700,700i" rel="stylesheet">
    <?php wp_head() ?>
</head>
<body <?php body_class(); ?>>
<header id="header">
    <nav class="navbar">
        <div class="container">
            <div class="navbar-wrapper clearfix">
                <div class="navbar-header">
                    <div class="navbar-brand">

                        <?php if (has_custom_logo()): ?>
                            <?php the_custom_logo() ?>
                        <?php else: ?>
                            <a href="http://visualcomposer.io">
                                <img width="50" height="49" src="<?= get_template_directory_uri() ?>/images/vc-logo.svg" alt="<?= __('Visual Composer Theme', 'visual-composer-theme') ?>">
                            </a>
                        <?php endif; ?>
                        
                    </div>

                    <?php if ( has_nav_menu( 'primary' ) ) : ?>
                        <button type="button" class="navbar-toggle">
                            <span class="sr-only"><?= __('Toggle navigation', 'visual-composer-theme') ?></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    <?php endif; ?>

                </div>
                <?php if ( has_nav_menu( 'primary' ) ) : ?>
                    <div id="main-menu">
                        <div class="button-close"></div>
                        <?php
                        wp_nav_menu( array(
                            'theme_location' => 'primary',
                            'menu_class'     => 'nav navbar-nav navbar-right',
                            'container'      => '',
                        ) );
                        ?>
                    </div><!--#main-menu-->
                <?php endif; ?>
            </div><!--.navbar-wrapper-->
        </div><!--.container-->
    </nav>
    <div class="header-image">
        <div class="fade-in-img">
            <img src="<?= get_template_directory_uri() ?>/images/header-image.jpg" data-src="<?= get_template_directory_uri() ?>/images/header-image.jpg" alt="">
            <noscript>
                <img src="<?= get_template_directory_uri() ?>/images/header-image.jpg" alt="">
            </noscript>
        </div><!--.fade-in-image-->
    </div><!--.header-image-->
</header>