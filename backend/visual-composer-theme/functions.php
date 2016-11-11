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

if( get_theme_mod( 'vc_overall_site_featured_image', 'show' ) == 'show' ) {
    add_theme_support('post-thumbnails');
}

add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );

/**
 * Enqueues styles.
 *
 * @since Visual Composer Theme 1.0
 */
function visualcomposertheme_style() {
    // Bootstrap stylesheet
    wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css', array(), '3.3.7' );

    // Add Visual Composer Theme Font
    wp_enqueue_style( 'visual-composer-theme-font', get_template_directory_uri() . '/css/visual-composer-theme-font.min.css', array(), '1.0' );

    //Slick slider stylesheet
    wp_enqueue_style( 'slick-style', get_template_directory_uri() . '/css/slick.min.css', array(), '1.6.0' );

    // General theme stylesheet
    wp_enqueue_style( 'visual-composer-theme-general', get_template_directory_uri() . '/css/style.min.css', array(), '1.0' );

    // Stylesheet with additional responsive style
    wp_enqueue_style( 'visual-composer-theme-responsive', get_template_directory_uri() . '/css/responsive.min.css', array(), '1.0' );

    // Theme stylesheet.
    wp_enqueue_style( 'visual-composer-theme-style', get_stylesheet_uri() );

    // Font options
    $fonts = array(
        get_theme_mod( 'vc_fonts_and_style_first_font_family', 'Roboto' ),
        get_theme_mod( 'vc_fonts_and_style_headers_font_family', 'Playfair Display' ),
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
    wp_enqueue_script( 'bootstrap-transition', get_template_directory_uri() . '/js/transition.min.js', array('jquery'), '3.3.7', true );

    // Bootstrap Transition JS
    wp_enqueue_script( 'bootstrap-collapser', get_template_directory_uri() . '/js/collapse.min.js', array('jquery'), '3.3.7', true );

    // Slick Slider JS
    wp_enqueue_script( 'slick-js', get_template_directory_uri() . '/js/slick.min.js', array('jquery'), '1.6.0', true );

    // Main theme JS functions
    wp_enqueue_script( 'visual-composer-theme-script', get_template_directory_uri() . '/js/functions.min.js', array('jquery'), '1.0', true );
}
add_action( 'wp_enqueue_scripts', 'visualcomposertheme_script' );


/**
 * Adds custom classes to the array of body classes.
 */
function visualcomposertheme_body_classes( $classes ) {
    // Sandwich color.
    if ( get_theme_mod( 'vc_header_and_menu_area_sandwich_style', '#333333' ) == '#FFFFFF' ) {
        $classes[] = 'sandwich-color-light';
    }

    // Menu type
    if ( get_theme_mod( 'vc_header_and_menu_area_position', 'top' ) == 'sandwich' ) {
        $classes[] = 'menu-sandwich';
    }

    // Menu position
    if ( get_theme_mod( 'vc_header_and_menu_area_top_header', 'regular' ) == 'fixed' ) {
        $classes[] = 'fixed-header';
    }

    // Navbar background
    if ( get_theme_mod( 'vc_header_and_menu_area_background_remove', 'no' ) == 'yes' ) {
        $classes[] = 'navbar-no-background';
    }

    // Width of header-area
    if ( get_theme_mod( 'vc_header_and_menu_area_top_header_width', 'boxed' ) == 'full_width' ) {
        $classes[] = 'header-full-width';
    }
    elseif ( get_theme_mod( 'vc_header_and_menu_area_top_header_width', 'boxed' ) == 'full_width_boxed' ) {
        $classes[] = 'header-full-width-boxed';
    }

    //Width of content-area
    if ( get_theme_mod( 'vc_content_area_size', 'boxed' ) == 'full_width' ) {
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

register_sidebar(
    array (
        'name'          => __( 'Menu Area', 'visual-composer-theme' ),
        'id'            => 'menu',
        'description'   => __( 'Add widgets here to appear in menu area.', 'visual-composer-theme' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h2>',
    )
);

$footer_columns = intval( get_theme_mod( 'vc_footer_area_widgetized_columns', 0 ) );
if ( $footer_columns !== 0 && $footer_columns > 1 ) {
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
elseif( $footer_columns )
{
    register_sidebar(
        array(
            'name' => __('Footer Area', 'visual-composer-theme'),
            'id' => 'footer',
            'description' => __('Add widgets here to appear in your footer.', 'visual-composer-theme'),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h2>',
        )
    );
}

function vc_get_header_container_class () {
    if ( get_theme_mod( 'vc_header_and_menu_area_top_header_width', 'boxed' ) == 'full_width' ) {
        return 'container-fluid';
    }
    else {
        return 'container';
    }
}

function vc_get_content_container_class () {
    if( get_theme_mod( 'vc_content_area_size', 'boxed' ) == 'full_width' ) {
        return 'container-fluid';
    }
    else {
        return 'container';
    }
}

function vc_get_maincontent_block_class () {
    switch ( get_theme_mod( 'vc_content_area_sidebar', 'none' ) ) {
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
    switch ( get_theme_mod( 'vc_content_area_sidebar', 'none' ) ) {
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

    //Fonts and style
    $css .= '
    /*Body fonts and style*/
    body,
    #main-menu ul li ul li,
    .comment-content cite,
    .entry-content cite { font-family: '.get_theme_mod('vc_fonts_and_style_first_font_family', 'Roboto').'; }
     body,
     .comment-content ul > li ul li:before,
     .entry-content ul > li ul li:before,
     .sidebar-widget-area a:hover, .sidebar-widget-area a:focus,
     .sidebar-widget-area .widget_recent_entries ul li:hover, .sidebar-widget-area .widget_archive ul li:hover, .sidebar-widget-area .widget_categories ul li:hover, .sidebar-widget-area .widget_meta ul li:hover, .sidebar-widget-area .widget_recent_entries ul li:focus, .sidebar-widget-area .widget_archive ul li:focus, .sidebar-widget-area .widget_categories ul li:focus, .sidebar-widget-area .widget_meta ul li:focus { color: '. get_theme_mod( 'vc_fonts_and_style_text_color', '#555555' ) .'; }
      .comment-content table,
      .entry-content table { border-color: '. get_theme_mod( 'vc_fonts_and_style_text_color', '#555555' ) .'; }
      .entry-full-content .entry-author-data .author-biography,
      .entry-full-content .entry-meta,
      .nav-links.post-navigation a .meta-nav,
      .search-results-header h4,
      .entry-preview .entry-meta li,
      .entry-preview .entry-meta li a,
      .entry-content .gallery-caption,
      .comment-content blockquote,
      .entry-content blockquote,
      .wp-caption .wp-caption-text,
      .comments-area .comment-list .comment-metadata a { color: '.get_theme_mod ( 'vc_fonts_and_style_secondary_text_color', '#777777' ).'; }
      .comments-area .comment-list .comment-metadata a:hover,
      .comments-area .comment-list .comment-metadata a:focus { border-bottom-color: '.get_theme_mod ( 'vc_fonts_and_style_secondary_text_color', '#777777' ).'; }
      a,
      .comments-area .comment-list .reply a,
      .comments-area span.required,
      .comments-area .comment-subscription-form label:before,
      .entry-preview .entry-meta li a:hover:before,
      .entry-preview .entry-meta li a:focus:before,
      .entry-content p a:hover,
      .entry-content ol a:hover,
      .entry-content ul a:hover,
      .entry-content table a:hover,
      .entry-content datalist a:hover,
      .entry-content blockquote a:hover,
      .entry-content dl a:hover,
      .entry-content address a:hover,
      .entry-content p a:focus,
      .entry-content ol a:focus,
      .entry-content ul a:focus,
      .entry-content table a:focus,
      .entry-content datalist a:focus,
      .entry-content blockquote a:focus,
      .entry-content dl a:focus,
      .entry-content address a:focus,
      .entry-content ul > li:before,
      .comment-content p a:hover,
      .comment-content ol a:hover,
      .comment-content ul a:hover,
      .comment-content table a:hover,
      .comment-content datalist a:hover,
      .comment-content blockquote a:hover,
      .comment-content dl a:hover,
      .comment-content address a:hover,
      .comment-content p a:focus,
      .comment-content ol a:focus,
      .comment-content ul a:focus,
      .comment-content table a:focus,
      .comment-content datalist a:focus,
      .comment-content blockquote a:focus,
      .comment-content dl a:focus,
      .comment-content address a:focus,
      .comment-content ul > li:before,
      .sidebar-widget-area .widget_recent_entries ul li,
      .sidebar-widget-area .widget_archive ul li,
      .sidebar-widget-area .widget_categories ul li,
      .sidebar-widget-area .widget_meta ul li { color: '.get_theme_mod( 'vc_fonts_and_style_active_color', '#557cbf' ).'; }     
      .comments-area .comment-list .reply a:hover,
      .comments-area .comment-list .reply a:focus,
      .comment-content p a,
      .comment-content ol a,
      .comment-content ul a,
      .comment-content table a,
      .comment-content datalist a,
      .comment-content blockquote a,
      .comment-content dl a,
      .comment-content address a,
      .entry-content p a,
      .entry-content ol a,
      .entry-content ul a,
      .entry-content table a,
      .entry-content datalist a,
      .entry-content blockquote a,
      .entry-content dl a,
      .entry-content address a { border-bottom-color: '.get_theme_mod( 'vc_fonts_and_style_active_color', '#557cbf' ).'; }    
      .entry-content blockquote, .comment-content { border-left-color: '.get_theme_mod( 'vc_fonts_and_style_active_color', '#557cbf' ).'; }
      html, #main-menu ul li ul li { font-size: '.get_theme_mod( 'vc_fonts_and_style_font_size', '16px' ).' }
      body, #footer, .footer-widget-area .widget-title { line-height: '.get_theme_mod( 'vc_fonts_and_style_line_height', '1.7' ).'; }
      body { letter-spacing: '.get_theme_mod( 'vc_fonts_and_style_letter_spacing', '0.01rem' ).' }
    ';

    //Headers font and style
    $css .= '
    /*Headers fonts and style*/
    .header-widgetised-area .widget_text,
    .blue-button,
     #main-menu > ul > li > a, 
     .entry-full-content .entry-author-data .author-name, 
     .nav-links.post-navigation a .post-title, 
     .comments-area .comment-list .comment-author,
     .comments-area .comment-form-comment label,
     .comments-area .comment-form-author label,
     .comments-area .comment-form-email label,
     .comments-area .comment-form-url label,
     .comments-area .form-submit input[type="submit"],
     h1, h2, h3, h4, h5, h6,
     .comment-content blockquote,
     .entry-content blockquote { font-family: '.get_theme_mod( 'vc_fonts_and_style_headers_font_family', 'Playfair Display' ).'; }
    .entry-full-content .entry-author-data .author-name,
    .entry-full-content .entry-meta a,
    .nav-links.post-navigation a .post-title,
    .comments-area .comment-list .comment-author,
    .search-results-header h4 strong,
    .entry-preview .entry-meta li a:hover,
    .entry-preview .entry-meta li a:focus,
    h1, h2, h3, h4, h5, h6,
    h1 a, h2 a, h3 a, h4 a, h5 a, h6 a,
    h1 a:hover, h2 a:hover, h3 a:hover, h4 a:hover, h5 a:hover, h6 a:hover,
    h1 a:focus, h2 a:focus, h3 a:focus, h4 a:focus, h5 a:focus, h6 a:focus{ color: '.get_theme_mod( 'vc_fonts_and_style_headers_text_color', '#333333' ).'; }
    
    .entry-full-content .entry-meta a:hover,
    .entry-full-content .entry-meta a:focus,
    .nav-links.post-navigation a:hover .post-title,
    h1 a:hover, h2 a:hover, h3 a:hover, h4 a:hover, h5 a:hover, h6 a:hover,
    h1 a:focus, h2 a:focus, h3 a:focus, h4 a:focus, h5 a:focus, h6 a:focus { border-bottom-color: '.get_theme_mod( 'vc_fonts_and_style_headers_text_color', '#333333' ).'; }
    
    h1, h2, h3, h4, h5, h6 { 
     font-weight: '.get_theme_mod( 'vc_fonts_and_style_headers_weight', '400' ).';
     font-style: '.get_theme_mod( 'vc_fonts_and_style_headers_font_style', 'normal' ).';
     line-height: '.get_theme_mod( 'vc_fonts_and_style_headers_line_height', '1.1' ).';
     letter-spacing: '.get_theme_mod( 'vc_fonts_and_style_headers_letter_spacing', '0.01rem' ).';
     text-transform: '.get_theme_mod( 'vc_fonts_and_style_headers_capitalization', 'none' ).';
     }
     
     h1 { 
        margin-bottom: '.get_theme_mod( 'vc_fonts_and_style_headers_margin_bottom', '2.125rem' ).';
        font-size: '.get_theme_mod( 'vc_fonts_and_style_headers_h1_font_size', '42px' ).';
     }
     h2 { font-size: '.get_theme_mod( 'vc_fonts_and_style_headers_h2_font_size', '36px' ).'; }
     h3 { font-size: '.get_theme_mod( 'vc_fonts_and_style_headers_h3_font_size', '30px' ).'; }
     h4 { font-size: '.get_theme_mod( 'vc_fonts_and_style_headers_h4_font_size', '22px' ).'; }
     h5 { font-size: '.get_theme_mod( 'vc_fonts_and_style_headers_h5_font_size', '18px' ).'; }
     h6 { font-size: '.get_theme_mod( 'vc_fonts_and_style_headers_h6_font_size', '16px' ).'; }
     h2, h3, h4, h5, h6 { margin-bottom: '.get_theme_mod( 'vc_fonts_and_style_headers_margin_bottom', '0.625rem' ).'; }
     h1, h2, h3, h4, h5, h6 { margin-top: '.get_theme_mod( 'vc_fonts_and_style_headers_margin_top', '0' ).'; }
    ';

    $overall_site_bg_color = get_theme_mod('vc_overall_site_bg_color', '#ffffff');
    if ( $overall_site_bg_color != '#ffffff' ) {
        $css .= "
        /*Overall site background color*/
        body,
        #header,
        nav.navbar  {background-color: {$overall_site_bg_color};}
        ";
    }

    $header_and_menu_area_background = get_theme_mod( 'vc_header_and_menu_area_background', '#ffffff');
    if ( $header_and_menu_area_background != '#ffffff' ) {
        $css .= "
        /*Header and menu area background color*/
        #header .navbar .navbar-wrapper,
        body.navbar-no-background #header .navbar.fixed.scroll,
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

    $header_and_menu_area_menu_hover_background = get_theme_mod ( 'vc_header_and_menu_area_menu_hover_background', '#eeeeee' );
    if ( $header_and_menu_area_menu_hover_background != '#eeeeee' ) {
        $css .= "
        /*Header and menu area menu hover background color*/
        @media only screen and (min-width: 768px) { body:not(.menu-sandwich) #main-menu ul li ul li:hover > a { background-color: {$header_and_menu_area_menu_hover_background}; } }
        ";
    }

    $content_area_background = get_theme_mod( 'vc_content_area_background', '#ffffff' );
    if ( $content_area_background != '#ffffff' ) {
        $css .= "
        /*Content area background*/
        .content-wrapper { background-color: {$content_area_background}; }
        ";
    }

    $content_area_comments_background = get_theme_mod( 'vc_content_area_comments_background', '#f4f4f4' );
    if ( $content_area_comments_background != '#f4f4f4' ) {
        $css .= "
        /*Comments background*/
        .comments-area { background-color: {$content_area_comments_background}; }
        ";
    }

    $footer_area_background = get_theme_mod( 'vc_footer_area_background', '#333333' );
    if ( $footer_area_background != '#333333' ) {
        // Work out if hash given
        $hex = str_replace( '#', '', $footer_area_background );

        /// HEX TO RGB
        $rgb = array(hexdec(substr($hex,0,2)), hexdec(substr($hex,2,2)), hexdec(substr($hex,4,2)));
        //// CALCULATE
        for ($i=0; $i<3; $i++) {
            $rgb[$i] = round($rgb[$i] * 1.1 );

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
        $css .= "
        /*Footer area text color*/
        #footer {color: {$footer_area_text_color}; }
        ";
    }

    $footer_area_text_active_color = get_theme_mod( 'vc_footer_area_text_active_color', '#ffffff' );
    if ( $footer_area_text_active_color != '#ffffff' ) {
        $css .= "
        /*Footer area text active color*/
        .footer-widget-area .widget-title,
        #footer a,
        #footer .footer-socials ul li a { color: {$footer_area_text_active_color}; }
        #footer a:hover { border-bottom-color: {$footer_area_text_active_color}; }
        ";
    }

    wp_add_inline_style( 'custom-style', $css );
}
add_action( 'wp_enqueue_scripts', 'visualcomposertheme_inline_styles' );