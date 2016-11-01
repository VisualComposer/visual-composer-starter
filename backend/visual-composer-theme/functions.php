<?php
if ( ! function_exists( 'visualcomposertheme_setup' ) ) :

    function visualcomposertheme_setup() {
        /*
         * Make theme available for translation.
         */
        load_theme_textdomain( 'visual-composer-theme' );

        /*
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
        add_theme_support( 'title-tag' );

        /*
         * Enable custom logo
         */
        add_theme_support( 'custom-logo');

        /*
         * This theme uses wp_nav_menu() in two locations.
         */
        register_nav_menus( array(
            'primary'       => __( 'Primary Menu', 'visual-composer-theme' ),
            'secondary'     => __( 'Secondary Menu', 'visual-composer-theme' ),
        ) );
    }
endif; // visualcomposertheme_setup
add_action( 'after_setup_theme', 'visualcomposertheme_setup' );


/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';


add_theme_support( 'post-formats', array( 'gallery', 'video', 'image' ) );

add_theme_support( 'post-thumbnails' );

/**
 * Enqueues styles.
 *
 * @since Visual Composer Theme 1.0
 */
function visualcomposertheme_style() {
    // Bootstrap stylesheet
    wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.css', array(), '3.3.7' );

    // Add Visual Composer Theme Font
    wp_enqueue_style( 'visual-composer-theme-font', get_template_directory_uri() . '/css/visual-composer-theme-font.css', array(), '1.0' );

    //Slick slider stylesheet
    wp_enqueue_style( 'slick-style', get_template_directory_uri() . '/css/slick.css', array(), '1.6.0' );

    // General theme stylesheet
    wp_enqueue_style( 'visual-composer-theme-general', get_template_directory_uri() . '/css/style.css', array(), '1.0' );

    // Stylesheet with additional responsive style
    wp_enqueue_style( 'visual-composer-theme-responsive', get_template_directory_uri() . '/css/responsive.css', array(), '1.0' );

    // Theme stylesheet.
    wp_enqueue_style( 'visual-composer-theme-style', get_stylesheet_uri() );

}
add_action( 'wp_enqueue_scripts', 'visualcomposertheme_style' );


/**
 * Enqueues scripts.
 *
 * @since Visual Composer Theme 1.0
 */

function visualcomposertheme_script() {
    // Bootstrap Transition JS
    wp_enqueue_script( 'bootstrap-transition', get_template_directory_uri() . '/js/transition.js', array('jquery'), '3.3.7', true );

    // Bootstrap Transition JS
    wp_enqueue_script( 'bootstrap-collapser', get_template_directory_uri() . '/js/collapse.js', array('jquery'), '3.3.7', true );

    // Slick Slider JS
    wp_enqueue_script( 'bootstrap-transition', get_template_directory_uri() . '/js/slick.min.js', array('jquery'), '1.6.0', true );

    // Slick Slider JS
    wp_enqueue_script( 'slick-js', get_template_directory_uri() . '/js/slick.min.js', array('jquery'), '1.6.0', true );

    // Main theme JS functions
    wp_enqueue_script( 'visual-composer-theme-script', get_template_directory_uri() . '/js/functions.js', array('jquery'), '1.0', true );
}
add_action( 'wp_enqueue_scripts', 'visualcomposertheme_script' );