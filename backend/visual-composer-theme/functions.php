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

        /**
         * Customizer settings.
         */
        require get_template_directory() . '/inc/customizer/vc-fonts.class.php';
        require get_template_directory() . '/inc/customizer/vc-customizer.class.php';
        new VC_Fonts();
        new VC_Customizer();


    }
endif; // visualcomposertheme_setup
add_action( 'after_setup_theme', 'visualcomposertheme_setup' );


/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';


add_theme_support( 'post-formats', array( 'gallery', 'video', 'image' ) );

add_theme_support( 'post-thumbnails' );

add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );

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

    // Font options
    $fonts = array(
        get_theme_mod( 'vc_fonts_and_style_first_font_family', 'Playfair Display' ),
        get_theme_mod( 'vc_fonts_and_style_second_font_family', 'Roboto' )
    );

    $font_uri = VC_Fonts::vc_theme_get_google_font_uri( $fonts );

    // Load Google Fonts
    wp_enqueue_style( 'vc-theme-fonts', $font_uri, array(), null, 'screen' );

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


/**
 * Adds custom classes to the array of body classes.
 */
function visualcomposertheme_body_classes( $classes ) {
    // Sandwich color.
    if ( get_theme_mod( 'vc_header_and_menu_area_sandwich_style' ) == '#FFFFFF' ) {
        $classes[] = 'sandwich-color-light';
    }

    // Menu type
    if ( get_theme_mod( 'vc_header_and_menu_area_position' ) == 'sandwich' ) {
        $classes[] = 'menu-sandwich';
    }

    //Menu position
    if ( get_theme_mod( 'vc_header_and_menu_area_top_header' ) == 'fixed' ) {
        $classes[] = 'fixed-header';
    }

    //Navbar background
    if ( get_theme_mod( 'vc_header_and_menu_area_background_remove' ) == 'yes' ) {
        $classes[] = 'navbar-no-background';
    }

    //Width of header-area
    if ( get_theme_mod( 'vc_header_and_menu_area_top_header_width' ) == 'full_width' ) {
        $classes[] = 'header-full-width';
    }
    elseif ( get_theme_mod( 'vc_header_and_menu_area_top_header_width' ) == 'full_width_boxed' ) {
        $classes[] = 'header-full-width-boxed';
    }

    //Width of content-area
    if ( get_theme_mod( 'vc_content_area_size' ) == 'full_width' ) {
        $classes[] = 'content-full-width';
    }

    return $classes;
}
add_filter( 'body_class', 'visualcomposertheme_body_classes' );

/*
 * Register sidebars
 */
register_sidebar(
    array (
        'name'          => __( 'Sidebar', 'visual-composer-theme' ),
        'id'            => 'sidebar',
        'description'   => __( 'Add widgets here to appear in your sidebar.', 'visual-composer-theme' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h2>',
    )
);

$footer_columns = intval( get_theme_mod( 'vc_footer_area_widgetized_columns' ) );
if ( $footer_columns != 0 ) {
    register_sidebars( $footer_columns,
        array(
            'name' => __('Footer Area %d', 'visual-composer-theme'),
            'id' => 'footer',
            'description' => __('Add widgets here to appear in your footer.', 'visual-composer-theme'),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h2>',
        )
    );
}

function colourBrightness($hex, $percent) {
    // Work out if hash given
    $hash = '';
    if (stristr($hex,'#')) {
        $hex = str_replace('#','',$hex);
        $hash = '#';
    }
    /// HEX TO RGB
    $rgb = array(hexdec(substr($hex,0,2)), hexdec(substr($hex,2,2)), hexdec(substr($hex,4,2)));
    //// CALCULATE
    for ($i=0; $i<3; $i++) {
        $rgb[$i] = round($rgb[$i] * $percent) + round(255 * (1-$percent));

        // In case rounding up causes us to go to 256
        if ($rgb[$i] > 255) {
            $rgb[$i] = 255;
        }
    }
    //// RBG to Hex
    $hex = '';
    for($i=0; $i < 3; $i++) {
        // Convert the decimal digit to hex
        $hexDigit = dechex($rgb[$i]);
        // Add a leading zero if necessary
        if(strlen($hexDigit) == 1) {
            $hexDigit = "0" . $hexDigit;
        }
        // Append to the hex string
        $hex .= $hexDigit;
    }
    return $hash.$hex;
}

function vc_get_header_container_class () {
    if ( get_theme_mod( 'vc_header_and_menu_area_top_header_width' ) == 'full_width' ) {
        return 'container-fluid';
    }
    else {
        return 'container';
    }
}

function vc_get_content_container_class () {
    if( get_theme_mod( 'vc_content_area_size' ) == 'full_width' ) {
        return 'container-fluid';
    }
    else {
        return 'container';
    }
}

function vc_get_maincontent_block_class () {
    switch ( get_theme_mod( 'vc_content_area_sidebar' ) ) {
        case 'none':
            return 'col-md-12';
        case 'left':
            return 'col-md-9 col-md-push-3';
        case 'right':
            return 'col-md-9';
        default:
            return 'col-md-12';
    }
}


function vc_get_sidebar_class () {
    switch ( get_theme_mod( 'vc_content_area_sidebar' ) ) {
        case 'none':
            return false;
        case 'left':
            return 'col-md-3 col-md-pull-9';
        case 'right':
            return 'col-md-3';
        default:
            return false;
    }
}


function visualcomposertheme_inline_styles () {
    wp_enqueue_style('custom-style', get_template_directory_uri() . '/css/custom.css');
    $css = '';

    $overall_site_bg_color = get_theme_mod('vc_overall_site_bg_color', '#ffffff');
    if ( $overall_site_bg_color != '#ffffff' ) {
        $css .= "
        /*Overall site background color*/
        body,
        #header {background-color: {$overall_site_bg_color};}
        ";
    }

    $header_and_menu_area_background = get_theme_mod( 'vc_header_and_menu_area_background', '#ffffff');
    if ( $header_and_menu_area_background != '#ffffff' ) {
        $css .= "
        /*Header and menu area background color*/
        #header .navbar .navbar-wrapper,
        #header .navbar.fixed.scroll,
        body.header-full-width-boxed #header .navbar,
        body.header-full-width #header .navbar,
        #main-menu {background-color: {$header_and_menu_area_background};}
        @media only screen and (min-width: 768px) {
            body:not(.menu-sandwich) #main-menu ul li ul { background-color: {$header_and_menu_area_background}; }
        }
        ";
    }

    $header_and_menu_area_text_color = get_theme_mod( 'vc_header_and_menu_area_text_color', '#555555' );
    if ( $header_and_menu_area_text_color != '#555555' ) {
        $css .= "
        /*Header and menu area text color*/
        #header,
        #main-menu ul li,
        #main-menu ul li a { color: {$header_and_menu_area_text_color} }
        ";
    }

    $header_and_menu_area_text_active_color = get_theme_mod( 'vc_header_and_menu_area_text_active_color', '#333333' );
    if ( $header_and_menu_area_text_active_color != '#333333' ) {
        $css .= "
        /*Header and menu area active text color*/
        #header a:hover,
        #main-menu ul li a:hover,
        #main-menu ul li.current-menu-item > a {
            color: {$header_and_menu_area_text_active_color};
            border-bottom-color: {$header_and_menu_area_text_active_color};
        }
        ";
    }

    $footer_area_background = get_theme_mod( 'vc_footer_area_background', '#333333' );
    if ( true ) {
        // Work out if hash given
        $hex = str_replace( '#', '', $footer_area_background );

        /// HEX TO RGB
        $rgb = array(hexdec(substr($hex,0,2)), hexdec(substr($hex,2,2)), hexdec(substr($hex,4,2)));
        //// CALCULATE
        for ($i=0; $i<3; $i++) {
            $rgb[$i] = round($rgb[$i] * 1.05 );

            // In case rounding up causes us to go to 256
            if ($rgb[$i] > 255) {
                $rgb[$i] = 255;
            }
        }
        //// RBG to Hex
        $hex = '';
        for($i=0; $i < 3; $i++) {
            // Convert the decimal digit to hex
            $hexDigit = dechex($rgb[$i]);
            // Add a leading zero if necessary
            if(strlen($hexDigit) == 1) {
                $hexDigit = "0" . $hexDigit;
            }
            // Append to the hex string
            $hex .= $hexDigit;
        }
        $footer_widget_area_background = '#'.$hex;
        $css .= "
        /*Footer area background color*/
        #footer { background-color: {$footer_area_background}; }
        .footer-widget-area { background-color: {$footer_widget_area_background}; }
        ";
    }

    $footer_area_text_color = get_theme_mod( 'vc_footer_area_text_color', '#777777' );
    if ( $footer_area_text_color != '#777777' ) {
        $css = "
        /*Footer area text color*/
        #footer {color: {$footer_area_text_color}; }
        ";
    }


    wp_add_inline_style( 'custom-style', $css );
}
add_action( 'wp_enqueue_scripts', 'visualcomposertheme_inline_styles' );