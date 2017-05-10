<?php
/**
 * Functions
 *
 * @package WordPress
 * @subpackage Visual Composer Starter
 * @since Visual Composer Starter 1.0
 */

/** Slug used in update mechanism */
define( 'VCT_SLUG', basename( get_template_directory() ) );
define( 'VCT_VERSION', '1.1.1' );

if ( ! function_exists( 'visualcomposerstarter_setup' ) ) :
	/**
	 * Theme setup
	 */
	function visualcomposerstarter_setup() {
		/*
		 * Make theme available for translation.
		 */
		load_theme_textdomain( 'visual-composer-starter', get_template_directory() . '/languages' );

		/*
		 * Define sidebars
		 */
		define( 'VCT_PAGE_SIDEBAR',                     'vct_overall_site_page_sidebar' );
		define( 'VCT_POST_SIDEBAR',                     'vct_overall_site_post_sidebar' );
		define( 'VCT_ARCHIVE_AND_CATEGORY_SIDEBAR',     'vct_overall_site_aac_sidebar' );
		define( 'VCT_DISABLE_HEADER',                   'vct_overall_site_disable_header' );
		define( 'VCT_DISABLE_FOOTER',                   'vct_overall_site_disable_footer' );

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
		add_theme_support( 'custom-logo' );

		/*
		 * This theme uses wp_nav_menu() in two locations.
		 */
		register_nav_menus( array(
			'primary'       => esc_html__( 'Primary Menu', 'visual-composer-starter' ),
			'secondary'     => esc_html__( 'Footer Menu', 'visual-composer-starter' ),
		) );

		/*
		 * Comment reply
		 */
		add_action( 'comment_form_before', 'visualcomposerstarter_enqueue_comments_reply' );

		/*
		 * ACF Integration
		 */

		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

		$plugins   = get_plugins();
		$basic_acf = array_key_exists( 'advanced-custom-fields/acf.php', $plugins );
		$pro_acf   = array_key_exists( 'advanced-custom-fields-pro/acf.php', $plugins );
		if ( ! $basic_acf && ! $pro_acf ) {
			add_action( 'admin_notices', 'vct_acf_admin_notice__install' );
		} else {
			$activated_pro   = $pro_acf && is_plugin_active( 'advanced-custom-fields-pro/acf.php' );
			$activated_basic = $basic_acf && is_plugin_active( 'advanced-custom-fields/acf.php' );
			if ( ( ! $activated_pro && ! $activated_basic )
				 || ( ! $activated_pro && ! $basic_acf )
				 || ( ! $activated_basic && ! $pro_acf )
			) {
				add_action( 'admin_notices', 'vct_acf_admin_notice__activate' );
			} else {
				$name     = $activated_pro ? 'advanced-custom-fields-pro/acf.php' : 'advanced-custom-fields/acf.php';
				$acf_info = get_plugin_data( WP_PLUGIN_DIR . '/' . $name );
				if ( version_compare( $acf_info['Version'], '4.1.0', '<' ) ) {
					add_action( 'admin_notices', 'vct_acf_admin_notice__update' );
				} else {
					if ( function_exists( 'register_field_group' ) ) {
						$vct_acf_page_options = array(
							'id' => 'acf_page-options',
							'title' => __( 'Page Options' ),
							'fields' => array(
								array(
									'key' => 'field_589f5a321f0bc',
									'label' => __( 'Sidebar Position' ),
									'name' => 'sidebar_position',
									'type' => 'select',
									'instructions' => __( 'Select specific sidebar position.' ),
									'choices' => array(
										'none' => __( 'None' ),
										'left' => __( 'Left' ),
										'right' => __( 'Right' ),
									),
									'default_value' => get_theme_mod( VCT_PAGE_SIDEBAR, 'none' ),
									'allow_null' => 0,
									'multiple' => 0,
								),
								array(
									'key' => 'field_589f55db2faa9',
									'label' => __( 'Hide Page Title' ),
									'name' => 'hide_page_title',
									'type' => 'checkbox',
									'choices' => array(
										1 => __( 'Yes' ),
									),
									'default_value' => '',
									'layout' => 'vertical',
								),
							),
							'location' => array(
								array(
									array(
										'param' => 'post_type',
										'operator' => '==',
										'value' => 'page',
										'order_no' => 0,
										'group_no' => 0,
									),
								),
							),
							'options' => array(
								'position' => 'side',
								'layout' => 'default',
								'hide_on_screen' => array(),
							),
							'menu_order' => 0,
						);

						$vct_acf_post_options = array(
							'id' => 'acf_post-options',
							'title' => __( 'Post Options' ),
							'fields' => array(
								array(
									'key' => 'field_589f5b1d656ca',
									'label' => __( 'Sidebar Position' ),
									'name' => 'sidebar_position',
									'type' => 'select',
									'instructions' => __( 'Select specific sidebar position.' ),
									'choices' => array(
										'none' => __( 'None' ),
										'left' => __( 'Left' ),
										'right' => __( 'Right' ),
									),
									'default_value' => get_theme_mod( VCT_POST_SIDEBAR, 'none' ),
									'allow_null' => 0,
									'multiple' => 0,
								),
								array(
									'key' => 'field_589f5b9a56207',
									'label' => __( 'Hide Post Title' ),
									'name' => 'hide_page_title',
									'type' => 'checkbox',
									'choices' => array(
										1 => __( 'Yes' ),
									),
									'default_value' => '',
									'layout' => 'vertical',
								),
							),
							'location' => array(
								array(
									array(
										'param' => 'post_type',
										'operator' => '==',
										'value' => 'post',
										'order_no' => 0,
										'group_no' => 0,
									),
								),
							),
							'options' => array(
								'position' => 'side',
								'layout' => 'default',
								'hide_on_screen' => array(),
							),
							'menu_order' => 0,
						);

						if ( ! get_theme_mod( VCT_DISABLE_HEADER, false ) ) {
							$vct_acf_page_options['fields'][] = array(
								'key' => 'field_58c800e5a7722',
								'label' => 'Disable Header',
								'name' => 'disable_page_header',
								'type' => 'checkbox',
								'choices' => array(
									1 => __( 'Yes' ),
								),
								'default_value' => '',
								'layout' => 'vertical',
							);

							$vct_acf_post_options['fields'][] = array(
								'key' => 'field_58c7e3f0b7dfb',
								'label' => 'Disable Header',
								'name' => 'disable_post_header',
								'type' => 'checkbox',
								'choices' => array(
									1 => __( 'Yes' ),
								),
								'default_value' => '',
								'layout' => 'vertical',
							);
						}

						if ( ! get_theme_mod( VCT_DISABLE_FOOTER, false ) ) {
							$vct_acf_page_options['fields'][] = array(
								'key' => 'field_58c800faa7723',
								'label' => 'Disable Footer',
								'name' => 'disable_page_footer',
								'type' => 'checkbox',
								'choices' => array(
									1 => __( 'Yes' ),
								),
								'default_value' => '',
								'layout' => 'vertical',
							);

							$vct_acf_post_options['fields'][] = array(
								'key' => 'field_58c7e40db7dfc',
								'label' => 'Disable Footer',
								'name' => 'disable_post_footer',
								'type' => 'checkbox',
								'choices' => array(
									1 => __( 'Yes' ),
								),
								'default_value' => '',
								'layout' => 'vertical',
							);
						}

						register_field_group( $vct_acf_page_options );
						register_field_group( $vct_acf_post_options );
					} // End if().
				} // End if().
			} // End if().
		} // End if().

		/**
		 * Customizer settings.
		 */
		require get_template_directory() . '/inc/customizer/class-vct-fonts.php';
		require get_template_directory() . '/inc/customizer/class-vct-customizer.php';
		require get_template_directory() . '/inc/class-vct-update.php';
		require get_template_directory() . '/inc/hooks.php';
		new VCT_Fonts();
		new VCT_Customizer();
		new VCT_Update();

	}
endif; /* visualcomposerstarter_setup */

add_action( 'after_setup_theme', 'visualcomposerstarter_setup' );

/**
 *  Style Switch Toggle function
 */
function vct_style_switch_toggle_acf() {
	wp_register_style( 'toggle-acf-style', get_template_directory_uri() . '/css/toggle-switch.css', array(), false );
	wp_enqueue_style( 'toggle-acf-style' );
}
add_action( 'admin_enqueue_scripts', 'vct_style_switch_toggle_acf' );

/**
 *  Script Switch Toggle function
 */
function vct_script_switch_toggle_acf() {
	wp_register_script( 'toggle-acf-script', get_template_directory_uri() . '/js/toggle-switch-acf.js',  array( 'jquery' ), false, true );
	wp_enqueue_script( 'toggle-acf-script' );
}
add_action( 'admin_enqueue_scripts', 'vct_script_switch_toggle_acf' );

/**
 * Ajax Comment Reply
 */
function visualcomposerstarter_enqueue_comments_reply() {
	if ( get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}

/**
 * ACF install admin notice
 */
function vct_acf_admin_notice__install() {
	?>
	<div class="notice notice-success">
		<p><?php esc_html_e( 'In order to access full theme options, please make sure to install <a href="https://wordpress.org/plugins/advanced-custom-fields/" target="_blank">Advanced Custom Fields</a>', 'visual-composer-starter' ); ?></p>
	</div>
	<?php
}
/**
 * ACF activate admin notice
 */
function vct_acf_admin_notice__activate() {
	?>
	<div class="notice notice-success">
		<p><?php
			/* translators: %s: link to Advanced Custom Fields */
			echo sprintf( esc_html__( 'In order to access full theme options, please make sure to activate <a href="%s">Advanced Custom Fields</a>', 'visual-composer-starter' ), esc_url( admin_url( 'plugins.php' ) ) ); ?></p>
	</div>
	<?php
}
/**
 * ACF update admin notice
 */
function vct_acf_admin_notice__update() {
	?>
	<div class="notice notice-success">
		<p><?php
			/* translators: %s: link to Advanced Custom Fields */
			echo sprintf( esc_html__( 'In order to access full theme options, please make sure to update <a href="%s">Advanced Custom Fields</a>', 'visual-composer-starter' ), esc_url( admin_url( 'plugins.php' ) ) ); ?></p>
	</div>
	<?php
}

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';


add_theme_support( 'post-formats', array( 'gallery', 'video', 'image' ) );

if ( get_theme_mod( 'vct_overall_site_featured_image', true ) === true ) {
	add_theme_support( 'post-thumbnails' );

}

add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );

/*
 * Add Next Page Button to WYSIWYG editor
 */

add_filter( 'mce_buttons', 'mce_page_break' );

/**
 * Add page break
 *
 * @param VCT_Customizer $mce_buttons Add page break.
 *
 * @return array
 */
function mce_page_break( $mce_buttons ) {
	$pos = array_search( 'wp_more', $mce_buttons, true );

	if ( false !== $pos ) {
		$buttons = array_slice( $mce_buttons, 0, $pos );
		$buttons[] = 'wp_page';
		$mce_buttons = array_merge( $buttons, array_slice( $mce_buttons, $pos ) );
	}

	return $mce_buttons;
}

/**
 * Enqueues styles.
 *
 * @since Visual Composer Starter 1.0
 */
function visualcomposerstarter_style() {

	/* Bootstrap stylesheet */
	wp_register_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css', array(), '3.3.7' );

	/* Add Visual Composer Starter Font */
	wp_register_style( 'visual-composer-starter-font', get_template_directory_uri() . '/css/visual-composer-starter-font.min.css', array(), VCT_VERSION );

	/* Slick slider stylesheet */
	wp_register_style( 'slick-style', get_template_directory_uri() . '/css/slick.min.css', array(), '1.6.0' );

	/* General theme stylesheet */
	wp_register_style( 'visual-composer-starter-general', get_template_directory_uri() . '/css/style.min.css', array(), VCT_VERSION );

	/* Stylesheet with additional responsive style */
	wp_register_style( 'visual-composer-starter-responsive', get_template_directory_uri() . '/css/responsive.min.css', array(), VCT_VERSION );

	/* Theme stylesheet */
	wp_register_style( 'visual-composer-starter-style', get_stylesheet_uri() );

	/* Font options */
	$fonts = array(
		get_theme_mod( 'vct_fonts_and_style_body_font_family', 'Roboto' ),
		get_theme_mod( 'vct_fonts_and_style_h1_font_family', 'Playfair Display' ),
		get_theme_mod( 'vct_fonts_and_style_h2_font_family', 'Playfair Display' ),
		get_theme_mod( 'vct_fonts_and_style_h3_font_family', 'Playfair Display' ),
		get_theme_mod( 'vct_fonts_and_style_h4_font_family', 'Playfair Display' ),
		get_theme_mod( 'vct_fonts_and_style_h5_font_family', 'Playfair Display' ),
		get_theme_mod( 'vct_fonts_and_style_h6_font_family', 'Playfair Display' ),
		get_theme_mod( 'vct_fonts_and_style_buttons_font_family', 'Playfair Display' ),
	);

	$font_uri = VCT_Fonts::vct_theme_get_google_font_uri( $fonts );

	/* Load Google Fonts */
	wp_register_style( 'vct-theme-fonts', $font_uri, array(), null, 'screen' );

	/* Enqueue styles */
	wp_enqueue_style( 'bootstrap' );
	wp_enqueue_style( 'visual-composer-starter-font' );
	wp_enqueue_style( 'slick-style' );
	wp_enqueue_style( 'visual-composer-starter-general' );
	wp_enqueue_style( 'visual-composer-starter-responsive' );
	wp_enqueue_style( 'visual-composer-starter-style' );
	wp_enqueue_style( 'vct-theme-fonts' );
}
add_action( 'wp_enqueue_scripts', 'visualcomposerstarter_style' );


/**
 * Enqueues scripts.
 *
 * @since Visual Composer Starter 1.0
 */
function visualcomposerstarter_script() {
	/* Bootstrap Transition JS */
	wp_register_script( 'bootstrap-transition', get_template_directory_uri() . '/js/bootstrap/transition.min.js', array( 'jquery' ), '3.3.7', true );

	/* Bootstrap Transition JS */
	wp_register_script( 'bootstrap-collapser', get_template_directory_uri() . '/js/bootstrap/collapse.min.js', array( 'jquery' ), '3.3.7', true );

	/* Slick Slider JS */
	wp_register_script( 'slick-js', get_template_directory_uri() . '/js/slick/slick.min.js', array( 'jquery' ), '1.6.0', true );

	/* Main theme JS functions */
	wp_register_script( 'visual-composer-starter-script', get_template_directory_uri() . '/js/functions.min.js', array( 'jquery' ), VCT_VERSION, true );

	/* Enqueue scripts */
	wp_enqueue_script( 'bootstrap-transition' );
	wp_enqueue_script( 'bootstrap-collapser' );
	wp_enqueue_script( 'slick-js' );
	wp_enqueue_script( 'visual-composer-starter-script' );
}
add_action( 'wp_enqueue_scripts', 'visualcomposerstarter_script' );


/**
 * Adds custom classes to the array of body classes.
 *
 * @param Classes $classes Classes list.
 *
 * @return array
 */
function visualcomposerstarter_body_classes( $classes ) {
	/* Sandwich color */
	if ( get_theme_mod( 'vct_header_sandwich_style', '#333333' ) === '#FFFFFF' ) {
		$classes[] = 'sandwich-color-light';
	}

	/* Header Style */
	if ( get_theme_mod( 'vct_header_position', 'top' ) === 'sandwich' ) {
		$classes[] = 'menu-sandwich';
	}

	/* Menu position */
	if ( get_theme_mod( 'vct_header_sticky_header', false ) === true ) {
		$classes[] = 'fixed-header';
	}

	/* Navbar background */
	if ( get_theme_mod( 'vct_header_reserve_space_for_header', true ) === false ) {
		$classes[] = 'navbar-no-background';
	}

	/* Width of header-area */
	if ( get_theme_mod( 'vct_header_top_header_width', 'boxed' ) === 'full_width' ) {
		$classes[] = 'header-full-width';
	} elseif ( get_theme_mod( 'vct_header_top_header_width', 'boxed' ) === 'full_width_boxed' ) {
		$classes[] = 'header-full-width-boxed';
	}

	/* Width of content-area */
	if ( get_theme_mod( 'vct_content_area_size', 'boxed' ) === 'full_width' ) {
		$classes[] = 'content-full-width';
	}

	/* Height of featured image */
	if ( get_theme_mod( 'vct_overall_site_featured_image_height', 'auto' ) === 'full_height' ) {
		$classes[] = 'featured-image-full-height';
	}

	if ( get_theme_mod( 'vct_overall_site_featured_image_height', 'auto' ) === 'custom' ) {
		$classes[] = 'featured-image-custom-height';
	}

	return $classes;
}
add_filter( 'body_class', 'visualcomposerstarter_body_classes' );

/**
 *  Give linked images class
 *
 * @param string $html Html.
 * @since Visual Composer Starter 1.2
 * @return mixed
 */
function visualcomposerstarter_give_linked_images_class( $html ) {
	$classes = 'image-link'; // separated by spaces, e.g. 'img image-link'.

	$patterns = array();
	$replacements = array();

	// Matches img tag wrapped in anchor tag where anchor has existing classes contained in double quotes.
	$patterns[0] = '/<a([^>]*)class="([^"]*)"([^>]*)>\s*<img([^>]*)>\s*<\/a>/';
	$replacements[0] = '<a\1class="' . $classes . ' \2"\3><img\4></a>';

	// Matches img tag wrapped in anchor tag where anchor has existing classes contained in single quotes.
	$patterns[1] = '/<a([^>]*)class=\'([^\']*)\'([^>]*)>\s*<img([^>]*)>\s*<\/a>/';
	$replacements[1] = '<a\1class="' . $classes . ' \2"\3><img\4></a>';

	// Matches img tag wrapped in anchor tag where anchor tag has no existing classes.
	$patterns[2] = '/<a(?![^>]*class)([^>]*)>\s*<img([^>]*)>\s*<\/a>/';
	$replacements[2] = '<a\1 class="' . $classes . '"><img\2></a>';

	$html = preg_replace( $patterns, $replacements, $html );

	return $html;
}
add_filter( 'the_content', 'visualcomposerstarter_give_linked_images_class' );

/*
 * Register sidebars
 */
register_sidebar(
	array(
		'name'          => __( 'Sidebar', 'visual-composer-starter' ),
		'id'            => 'sidebar',
		'description'   => __( 'Add widgets here to appear in your sidebar.', 'visual-composer-starter' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h2>',
	)
);

register_sidebar(
	array(
		'name'          => __( 'Menu Area', 'visual-composer-starter' ),
		'id'            => 'menu',
		'description'   => __( 'Add widgets here to appear in menu area.', 'visual-composer-starter' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h2>',
	)
);
/**
 * Footer area 1.
 *
 * @return array
 */
function vct_footer_1() {
	return array(
		'name' => __( 'Footer Widget Column 1', 'visual-composer-starter' ),
		'id' => 'footer',
		'description' => __( 'Add widgets here to appear in your footer.', 'visual-composer-starter' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h2>',
	);
}
/**
 * Footer area 2.
 *
 * @return array
 */
function vct_footer_2() {
	return array(
		'name' => __( 'Footer Widget Column 2', 'visual-composer-starter' ),
		'id' => 'footer-2',
		'description' => __( 'Add widgets here to appear in your footer.', 'visual-composer-starter' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h2>',
	);
}
/**
 * Footer area 3.
 *
 * @return array
 */
function vct_footer_3() {
	return array(
		'name' => __( 'Footer Widget Column 3', 'visual-composer-starter' ),
		'id' => 'footer-3',
		'description' => __( 'Add widgets here to appear in your footer.', 'visual-composer-starter' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h2>',
	);
}
/**
 * Footer area 4.
 *
 * @return array
 */
function vct_footer_4() {
	return array(
		'name' => __( 'Footer Widget Column 4', 'visual-composer-starter' ),
		'id' => 'footer-4',
		'description' => __( 'Add widgets here to appear in your footer.', 'visual-composer-starter' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h2>',
	);
}

add_action( 'widgets_init',             'visual_composer_starter_all_widgets' );
add_action( 'admin_bar_init',           'visual_composer_starter_widgets' );

/**
 * All widgets.
 */
function visual_composer_starter_all_widgets() {
	/**
	 * Register all zones for availability in customizer
	 */
	register_sidebar(
		vct_footer_1()
	);
	register_sidebar(
		vct_footer_2()
	);
	register_sidebar(
		vct_footer_3()
	);
	register_sidebar(
		vct_footer_4()
	);
}

/**
 * Widgets handler
 */
function visual_composer_starter_widgets() {
	unregister_sidebar( 'footer' );
	unregister_sidebar( 'footer-2' );
	unregister_sidebar( 'footer-3' );
	unregister_sidebar( 'footer-4' );
	if ( get_theme_mod( 'vct_footer_area_widget_area', false ) ) {
		$footer_columns = intval( get_theme_mod( 'vct_footer_area_widgetized_columns', 1 ) );
		if ( $footer_columns >= 1 ) {
			register_sidebar(
				vct_footer_1()
			);
		}

		if ( $footer_columns >= 2 ) {
			register_sidebar(
				vct_footer_2()
			);
		}

		if ( $footer_columns >= 3 ) {
			register_sidebar(
				vct_footer_3()
			);
		}
		if ( 4 === $footer_columns ) {
			register_sidebar(
				vct_footer_4()
			);
		}
	}

}

/**
 * Is header displayed
 *
 * @return bool
 */
function vct_is_the_header_displayed() {
	if ( get_theme_mod( VCT_DISABLE_HEADER, false ) ) {
		return false;
	} elseif ( function_exists( 'get_field' ) ) {
		if ( is_page() ) {
			return ! get_field( 'field_58c800e5a7722' );
		} elseif ( is_singular() ) {
			return ! get_field( 'field_58c7e3f0b7dfb' );
		} else {
			return true;
		}
	} else {
		return true;
	}
}

/**
 * Is footer displayed.
 *
 * @return bool
 */
function vct_is_the_footer_displayed() {
	if ( get_theme_mod( VCT_DISABLE_FOOTER, false ) ) {
		return false;
	} elseif ( function_exists( 'get_field' ) ) {
		if ( is_page() ) {
			return ! get_field( 'field_58c800faa7723' );
		} elseif ( is_singular() ) {
			return ! get_field( 'field_58c7e40db7dfc' );
		} else {
			return true;
		}
	} else {
		return true;
	}
}

/**
 * Get header container class.
 *
 * @return string
 */
function vct_get_header_container_class() {
	if ( get_theme_mod( 'vct_header_top_header_width', 'boxed' ) === 'full_width' ) {
		return 'container-fluid';
	} else {
		return 'container';
	}
}

/**
 * Get header image container class.
 *
 * @return string
 */
function vct_get_header_image_container_class() {
	if ( get_theme_mod( 'vct_overall_site_featured_image_width', 'full_width' ) === 'full_width' ) {
		return 'container-fluid';
	} else {
		return 'container';
	}
}

/**
 * Get contant container class
 *
 * @return string
 */
function vct_get_content_container_class() {
	if ( 'full_width' === get_theme_mod( 'vct_content_area_size', 'boxed' ) ) {
		return 'container-fluid';
	} else {
		return 'container';
	}
}


if ( get_theme_mod( 'vct_overall_site_sidebar' ) ) {
	set_theme_mod( VCT_PAGE_SIDEBAR, get_theme_mod( 'vct_overall_site_sidebar' ) );
	set_theme_mod( VCT_POST_SIDEBAR, get_theme_mod( 'vct_overall_site_sidebar' ) );
	remove_theme_mod( 'vct_overall_site_sidebar' );
}

/**
 * Check needed sidebar
 *
 * @return string
 */
function vct_check_needed_sidebar() {
	if ( is_page() ) {
		return VCT_PAGE_SIDEBAR;
	} elseif ( is_singular() ) {
		return VCT_POST_SIDEBAR;
	} elseif ( is_archive() || is_category() || is_search() || is_front_page() ) {
		return VCT_ARCHIVE_AND_CATEGORY_SIDEBAR;
	} else {
		return 'none';
	}
}

/**
 * Specify sidebar
 *
 * @return null
 */
function vct_specify_sidebar() {
	if ( is_page() ) {
		$value = function_exists( 'get_field' ) ? get_field( 'field_589f5a321f0bc' ) : null;
	} elseif ( is_singular() ) {
		$value = function_exists( 'get_field' ) ? get_field( 'field_589f5b1d656ca' ) : null;
	} else {
		$value = null;
	}

	$specify_setting = function_exists( 'get_field' ) ? $value : null;

	if ( $specify_setting ) {
		return $specify_setting;
	} else {
		return get_theme_mod( vct_check_needed_sidebar(), 'none' );
	}
}

/**
 * Is the title displayed
 *
 * @return bool
 */
function vct_is_the_title_displayed() {
	if ( function_exists( 'get_field' ) ) {
		if ( is_page() ) {
			return (bool) ! get_field( 'field_589f55db2faa9' );
		} elseif ( is_singular() ) {
			return (bool) ! get_field( 'field_589f5b9a56207' );
		} else {
			return true;
		}
	} else {
		return true;
	}
}

/**
 * Get main content block class
 *
 * @return string
 */
function vct_get_maincontent_block_class() {
	switch ( vct_specify_sidebar() ) {
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

/**
 * Get sidebar class
 *
 * @return bool|string
 */
function vct_get_sidebar_class() {
	switch ( vct_specify_sidebar() ) {
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

/**
 * Inline styles.
 */
function visualcomposerstarter_inline_styles() {
	wp_register_style( 'vct-custom-style', get_template_directory_uri() . '/css/customizer-custom.css', array(), false );
	wp_enqueue_style( 'vct-custom-style' );
	$css = '';

	// Fonts and style.
	$css .= '
	/*Body fonts and style*/
	body,
	#main-menu ul li ul li,
	.comment-content cite,
	.entry-content cite { font-family: ' . get_theme_mod( 'vct_fonts_and_style_body_font_family', 'Roboto' ) . '; }
	 body,
	 .sidebar-widget-area a:hover, .sidebar-widget-area a:focus,
	 .sidebar-widget-area .widget_recent_entries ul li:hover, .sidebar-widget-area .widget_archive ul li:hover, .sidebar-widget-area .widget_categories ul li:hover, .sidebar-widget-area .widget_meta ul li:hover, .sidebar-widget-area .widget_recent_entries ul li:focus, .sidebar-widget-area .widget_archive ul li:focus, .sidebar-widget-area .widget_categories ul li:focus, .sidebar-widget-area .widget_meta ul li:focus { color: ' . get_theme_mod( 'vct_fonts_and_style_body_primary_color', '#555555' ) . '; }
	  .comment-content table,
	  .entry-content table { border-color: ' . get_theme_mod( 'vct_fonts_and_style_body_primary_color', '#555555' ) . '; }
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
	  .comments-area .comment-list .comment-metadata a { color: ' . get_theme_mod( 'vct_fonts_and_style_body_secondary_text_color', '#777777' ) . '; }
	  .comments-area .comment-list .comment-metadata a:hover,
	  .comments-area .comment-list .comment-metadata a:focus { border-bottom-color: ' . get_theme_mod( 'vct_fonts_and_style_body_secondary_text_color', '#777777' ) . '; }
	  a,
	  .comments-area .comment-list .reply a,
	  .comments-area span.required,
	  .comments-area .comment-subscription-form label:before,
	  .entry-preview .entry-meta li a:hover:before,
	  .entry-preview .entry-meta li a:focus:before,
	  .entry-preview .entry-meta li.entry-meta-category:hover:before,
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
	  .sidebar-widget-area .widget_meta ul li { color: ' . get_theme_mod( 'vct_fonts_and_style_body_active_color', '#557cbf' ) . '; }     
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
	  .entry-content address a { border-bottom-color: ' . get_theme_mod( 'vct_fonts_and_style_body_active_color', '#557cbf' ) . '; }    
	  .entry-content blockquote, .comment-content { border-left-color: ' . get_theme_mod( 'vct_fonts_and_style_body_active_color', '#557cbf' ) . '; }
	  
	  .comments-area .form-submit input[type=submit]:hover, .comments-area .form-submit input[type=submit]:focus,
	  .blue-button:hover, .blue-button:focus {
		background-color: ' . get_theme_mod( 'vct_fonts_and_style_hover_background', '#3c63a6' ) . ';
		color: ' . get_theme_mod( 'vct_fonts_and_style_button_text_color', '#f4f4f4' ) . ';
	  }
	  
	  html, #main-menu ul li ul li { font-size: ' . get_theme_mod( 'vct_fonts_and_style_body_font_size', '16px' ) . ' }
	  body, #footer, .footer-widget-area .widget-title { line-height: ' . get_theme_mod( 'vct_fonts_and_style_body_line_height', '1.7' ) . '; }
	  body {
		letter-spacing: ' . get_theme_mod( 'vct_fonts_and_style_body_letter_spacing', '0.01rem' ) . ';
		font-weight: ' . get_theme_mod( 'vct_fonts_and_style_body_weight', '400' ) . ';
		font-style: ' . get_theme_mod( 'vct_fonts_and_style_body_font_style', 'normal' ) . ';
		text-transform: ' . get_theme_mod( 'vct_fonts_and_style_body_capitalization', 'none' ) . ';
	  }
	  
	  .comment-content address,
	  .comment-content blockquote,
	  .comment-content datalist,
	  .comment-content dl,
	  .comment-content ol,
	  .comment-content p,
	  .comment-content table,
	  .comment-content ul,
	  .entry-content address,
	  .entry-content blockquote,
	  .entry-content datalist,
	  .entry-content dl,
	  .entry-content ol,
	  .entry-content p,
	  .entry-content table,
	  .entry-content ul {
		margin-top: ' . get_theme_mod( 'vct_fonts_and_style_body_margin_top', '0' ) . ';
		margin-bottom: ' . get_theme_mod( 'vct_fonts_and_style_body_margin_bottom', '1.5rem' ) . ';
	  }
	  
	  /*Buttons font and style*/
	  .comments-area .form-submit input[type=submit],
	  .blue-button { 
			background-color: ' . get_theme_mod( 'vct_fonts_and_style_buttons_background_color', '#557cbf' ) . '; 
			color: ' . get_theme_mod( 'vct_fonts_and_style_buttons_text_color', '#f4f4f4' ) . ';
			font-family: ' . get_theme_mod( 'vct_fonts_and_style_buttons_font_family', 'Playfair Display' ) . ';
			font-size: ' . get_theme_mod( 'vct_fonts_and_style_buttons_font_size', '16px' ) . ';
			font-weight: ' . get_theme_mod( 'vct_fonts_and_style_buttons_weight', '400' ) . ';
			font-style: ' . get_theme_mod( 'vct_fonts_and_style_buttons_font_style', 'normal' ) . ';
			letter-spacing: ' . get_theme_mod( 'vct_fonts_and_style_buttons_letter_spacing', '0.01rem' ) . ';
			line-height: ' . get_theme_mod( 'vct_fonts_and_style_buttons_line_height', '1' ) . ';
			text-transform: ' . get_theme_mod( 'vct_fonts_and_style_buttons_capitalization', 'none' ) . ';
			margin-top: ' . get_theme_mod( 'vct_fonts_and_style_buttons_margin_top', '0' ) . ';
			margin-bottom: ' . get_theme_mod( 'vct_fonts_and_style_buttons_margin_bottom', '0' ) . ';
	  }
	  .comments-area .form-submit input[type=submit]:hover, .comments-area .form-submit input[type=submit]:focus,
	  .blue-button:hover, .blue-button:focus { 
			background-color: ' . get_theme_mod( 'vct_fonts_and_style_buttons_background_hover_color', '#3c63a6' ) . '; 
			color: ' . get_theme_mod( 'vct_fonts_and_style_buttons_text_hover_color', '#f4f4f4' ) . '; 
	  }
	';

	// Headers font and style.
	$css .= '
	/*Headers fonts and style*/
	.header-widgetised-area .widget_text,
	 #main-menu > ul > li > a, 
	 .entry-full-content .entry-author-data .author-name, 
	 .nav-links.post-navigation a .post-title, 
	 .comments-area .comment-list .comment-author,
	 .comments-area .comment-list .reply a,
	 .comments-area .comment-form-comment label,
	 .comments-area .comment-form-author label,
	 .comments-area .comment-form-email label,
	 .comments-area .comment-form-url label,
	 .comment-content blockquote,
	 .entry-content blockquote { font-family: ' . get_theme_mod( 'vct_fonts_and_style_h1_font_family', 'Playfair Display' ) . '; }
	.entry-full-content .entry-author-data .author-name,
	.entry-full-content .entry-meta a,
	.nav-links.post-navigation a .post-title,
	.comments-area .comment-list .comment-author,
	.comments-area .comment-list .comment-author a,
	.search-results-header h4 strong,
	.entry-preview .entry-meta li a:hover,
	.entry-preview .entry-meta li a:focus { color: ' . get_theme_mod( 'vct_fonts_and_style_h1_text_color', '#333333' ) . '; }
	
	.entry-full-content .entry-meta a,
	.comments-area .comment-list .comment-author a:hover,
	.comments-area .comment-list .comment-author a:focus,
	.nav-links.post-navigation a .post-title { border-bottom-color: ' . get_theme_mod( 'vct_fonts_and_style_h1_text_color', '#333333' ) . '; }

	 
	 h1 {
		color: ' . get_theme_mod( 'vct_fonts_and_style_h1_text_color', '#333333' ) . ';
		font-family: ' . get_theme_mod( 'vct_fonts_and_style_h1_font_family', 'Playfair Display' ) . ';
		font-size: ' . get_theme_mod( 'vct_fonts_and_style_h1_font_size', '42px' ) . ';
		font-weight: ' . get_theme_mod( 'vct_fonts_and_style_h1_weight', '400' ) . ';
		font-style: ' . get_theme_mod( 'vct_fonts_and_style_h1_font_style', 'normal' ) . ';
		letter-spacing: ' . get_theme_mod( 'vct_fonts_and_style_h1_letter_spacing', '0.01rem' ) . ';
		line-height: ' . get_theme_mod( 'vct_fonts_and_style_h1_line_height', '1.1' ) . ';
		margin-top: ' . get_theme_mod( 'vct_fonts_and_style_h1_margin_top', '0' ) . ';
		margin-bottom: ' . get_theme_mod( 'vct_fonts_and_style_h1_margin_bottom', '2.125rem' ) . ';
		text-transform: ' . get_theme_mod( 'vct_fonts_and_style_h1_capitalization', 'none' ) . ';  
	 }
	 h1 a {color: ' . get_theme_mod( 'vct_fonts_and_style_h1_active_color', '#557cbf' ) . ';}
	 h1 a:hover, h1 a:focus {color: ' . get_theme_mod( 'vct_fonts_and_style_h1_active_color', '#557cbf' ) . ';}
	 h2 {
		color: ' . get_theme_mod( 'vct_fonts_and_style_h2_text_color', '#333333' ) . ';
		font-family: ' . get_theme_mod( 'vct_fonts_and_style_h2_font_family', 'Playfair Display' ) . ';
		font-size: ' . get_theme_mod( 'vct_fonts_and_style_h2_font_size', '36px' ) . ';
		font-weight: ' . get_theme_mod( 'vct_fonts_and_style_h2_weight', '400' ) . ';
		font-style: ' . get_theme_mod( 'vct_fonts_and_style_h2_font_style', 'normal' ) . ';
		letter-spacing: ' . get_theme_mod( 'vct_fonts_and_style_h2_letter_spacing', '0.01rem' ) . ';
		line-height: ' . get_theme_mod( 'vct_fonts_and_style_h2_line_height', '1.1' ) . ';
		margin-top: ' . get_theme_mod( 'vct_fonts_and_style_h2_margin_top', '0' ) . ';
		margin-bottom: ' . get_theme_mod( 'vct_fonts_and_style_h2_margin_bottom', '0.625rem' ) . ';
		text-transform: ' . get_theme_mod( 'vct_fonts_and_style_h2_capitalization', 'none' ) . ';  
	 }
	 h2 a {color: ' . get_theme_mod( 'vct_fonts_and_style_h2_active_color', '#557cbf' ) . ';}
	 h2 a:hover, h2 a:focus {color: ' . get_theme_mod( 'vct_fonts_and_style_h2_active_color', '#557cbf' ) . ';}
	 h3 {
		color: ' . get_theme_mod( 'vct_fonts_and_style_h3_text_color', '#333333' ) . ';
		font-family: ' . get_theme_mod( 'vct_fonts_and_style_h3_font_family', 'Playfair Display' ) . ';
		font-size: ' . get_theme_mod( 'vct_fonts_and_style_h3_font_size', '30px' ) . ';
		font-weight: ' . get_theme_mod( 'vct_fonts_and_style_h3_weight', '400' ) . ';
		font-style: ' . get_theme_mod( 'vct_fonts_and_style_h3_font_style', 'normal' ) . ';
		letter-spacing: ' . get_theme_mod( 'vct_fonts_and_style_h3_letter_spacing', '0.01rem' ) . ';
		line-height: ' . get_theme_mod( 'vct_fonts_and_style_h3_line_height', '1.1' ) . ';
		margin-top: ' . get_theme_mod( 'vct_fonts_and_style_h3_margin_top', '0' ) . ';
		margin-bottom: ' . get_theme_mod( 'vct_fonts_and_style_h3_margin_bottom', '0.625rem' ) . ';
		text-transform: ' . get_theme_mod( 'vct_fonts_and_style_h3_capitalization', 'none' ) . ';  
	 }
	 h3 a {color: ' . get_theme_mod( 'vct_fonts_and_style_h3_active_color', '#557cbf' ) . ';}
	 h3 a:hover, h3 a:focus {color: ' . get_theme_mod( 'vct_fonts_and_style_h3_active_color', '#557cbf' ) . ';}
	 h4 {
		color: ' . get_theme_mod( 'vct_fonts_and_style_h4_text_color', '#333333' ) . ';
		font-family: ' . get_theme_mod( 'vct_fonts_and_style_h4_font_family', 'Playfair Display' ) . ';
		font-size: ' . get_theme_mod( 'vct_fonts_and_style_h4_font_size', '22px' ) . ';
		font-weight: ' . get_theme_mod( 'vct_fonts_and_style_h4_weight', '400' ) . ';
		font-style: ' . get_theme_mod( 'vct_fonts_and_style_h4_font_style', 'normal' ) . ';
		letter-spacing: ' . get_theme_mod( 'vct_fonts_and_style_h4_letter_spacing', '0.01rem' ) . ';
		line-height: ' . get_theme_mod( 'vct_fonts_and_style_h4_line_height', '1.1' ) . ';
		margin-top: ' . get_theme_mod( 'vct_fonts_and_style_h4_margin_top', '0' ) . ';
		margin-bottom: ' . get_theme_mod( 'vct_fonts_and_style_h4_margin_bottom', '0.625rem' ) . ';
		text-transform: ' . get_theme_mod( 'vct_fonts_and_style_h4_capitalization', 'none' ) . ';  
	 }
	 h4 a {color: ' . get_theme_mod( 'vct_fonts_and_style_h4_active_color', '#557cbf' ) . ';}
	 h4 a:hover, h4 a:focus {color: ' . get_theme_mod( 'vct_fonts_and_style_h4_active_color', '#557cbf' ) . ';}
	 h5 {
		color: ' . get_theme_mod( 'vct_fonts_and_style_h5_text_color', '#333333' ) . ';
		font-family: ' . get_theme_mod( 'vct_fonts_and_style_h5_font_family', 'Playfair Display' ) . ';
		font-size: ' . get_theme_mod( 'vct_fonts_and_style_h5_font_size', '22px' ) . ';
		font-weight: ' . get_theme_mod( 'vct_fonts_and_style_h5_weight', '400' ) . ';
		font-style: ' . get_theme_mod( 'vct_fonts_and_style_h5_font_style', 'normal' ) . ';
		letter-spacing: ' . get_theme_mod( 'vct_fonts_and_style_h5_letter_spacing', '0.01rem' ) . ';
		line-height: ' . get_theme_mod( 'vct_fonts_and_style_h5_line_height', '1.1' ) . ';
		margin-top: ' . get_theme_mod( 'vct_fonts_and_style_h5_margin_top', '0' ) . ';
		margin-bottom: ' . get_theme_mod( 'vct_fonts_and_style_h5_margin_bottom', '0.625rem' ) . ';
		text-transform: ' . get_theme_mod( 'vct_fonts_and_style_h5_capitalization', 'none' ) . ';  
	 }
	 h5 a {color: ' . get_theme_mod( 'vct_fonts_and_style_h5_active_color', '#557cbf' ) . ';}
	 h5 a:hover, h5 a:focus {color: ' . get_theme_mod( 'vct_fonts_and_style_h5_active_color', '#557cbf' ) . ';}
	 h6 {
		color: ' . get_theme_mod( 'vct_fonts_and_style_h6_text_color', '#333333' ) . ';
		font-family: ' . get_theme_mod( 'vct_fonts_and_style_h6_font_family', 'Playfair Display' ) . ';
		font-size: ' . get_theme_mod( 'vct_fonts_and_style_h6_font_size', '16px' ) . ';
		font-weight: ' . get_theme_mod( 'vct_fonts_and_style_h6_weight', '400' ) . ';
		font-style: ' . get_theme_mod( 'vct_fonts_and_style_h6_font_style', 'normal' ) . ';
		letter-spacing: ' . get_theme_mod( 'vct_fonts_and_style_h6_letter_spacing', '0.01rem' ) . ';
		line-height: ' . get_theme_mod( 'vct_fonts_and_style_h6_line_height', '1.1' ) . ';
		margin-top: ' . get_theme_mod( 'vct_fonts_and_style_h6_margin_top', '0' ) . ';
		margin-bottom: ' . get_theme_mod( 'vct_fonts_and_style_h6_margin_bottom', '0.625rem' ) . ';
		text-transform: ' . get_theme_mod( 'vct_fonts_and_style_h6_capitalization', 'none' ) . ';  
	 }
	 h6 a {color: ' . get_theme_mod( 'vct_fonts_and_style_h6_active_color', '#557cbf' ) . ';}
	 h6 a:hover, h6 a:focus {color: ' . get_theme_mod( 'vct_fonts_and_style_h6_active_color', '#557cbf' ) . ';}
	';

	$overall_site_bg_color = get_theme_mod( 'vct_overall_site_bg_color', '#ffffff' );
	if ( '#ffffff' !== $overall_site_bg_color ) {
		$css .= "
		/*Overall site background color*/
		body {background-color: {$overall_site_bg_color};}
		";
	}

	if ( get_theme_mod( 'vct_overall_site_enable_bg_image', false ) ) {
		$overall_site_bg_image = get_theme_mod( 'vct_overall_site_bg_image', '' );
		if ( 'repeat' === get_theme_mod( 'vct_overall_site_bg_image_style', 'cover' ) ) {
			$overall_site_bg_image_style = 'background-repeat: repeat;';
		} else {
			$overall_site_bg_image_style = '
			background-size: ' . get_theme_mod( 'vct_overall_site_bg_image_style', 'cover' ) . ';
			background-repeat: no-repeat;';
		}

		if ( '' !== $overall_site_bg_image ) {
			$css .= "
			body {
				background-image: url('{$overall_site_bg_image}');
				{$overall_site_bg_image_style}
			}
			";
		}
	}

	$header_and_menu_area_background = get_theme_mod( 'vct_header_background', '#ffffff' );
	if ( '#ffffff' !== $header_and_menu_area_background ) {
		$css .= "
		/*Header and menu area background color*/
		#header .navbar .navbar-wrapper,
		body.navbar-no-background #header .navbar.fixed.scroll,
		body.header-full-width-boxed #header .navbar,
		body.header-full-width #header .navbar {
			background-color: {$header_and_menu_area_background};
		}
		
		@media only screen and (min-width: 768px) {
			body:not(.menu-sandwich) #main-menu ul li ul { background-color: {$header_and_menu_area_background}; }
		}
		body.navbar-no-background #header .navbar {background-color: transparent;}
		";
	}

	$header_and_menu_area_text_color = get_theme_mod( 'vct_header_text_color', '#555555' );
	if ( '#555555' !== $header_and_menu_area_text_color ) {
		$css .= "
		/*Header and menu area text color*/
		#header { color: {$header_and_menu_area_text_color} }
		
		@media only screen and (min-width: 768px) {
			body:not(.menu-sandwich) #main-menu ul li,
			body:not(.menu-sandwich) #main-menu ul li a,
			body:not(.menu-sandwich) #main-menu ul li ul li a { color: {$header_and_menu_area_text_color} }
		}
		";
	}

	$header_and_menu_area_text_active_color = get_theme_mod( 'vct_header_text_active_color', '#333333' );
	if ( '#333333' !== $header_and_menu_area_text_active_color ) {
		$css .= "
		/*Header and menu area active text color*/
		#header a:hover {
			color: {$header_and_menu_area_text_active_color};
			border-bottom-color: {$header_and_menu_area_text_active_color};
		}
		
		@media only screen and (min-width: 768px) {
			body:not(.menu-sandwich) #main-menu ul li a:hover,
			body:not(.menu-sandwich) #main-menu ul li.current-menu-item > a
			body:not(.menu-sandwich) #main-menu ul li ul li a:focus, body:not(.menu-sandwich) #main-menu ul li ul li a:hover,
			body:not(.menu-sandwich) .sandwich-color-light #main-menu>ul>li.current_page_item>a,
			body:not(.menu-sandwich) .sandwich-color-light #main-menu>ul ul li.current_page_item>a {
				color: {$header_and_menu_area_text_active_color};
				border-bottom-color: {$header_and_menu_area_text_active_color};
			}
		}
		";
	}

	$header_padding = get_theme_mod( 'vct_header_padding', '25px' );
	if ( '25px' !== $header_padding ) {
		$css .= "
		/* Header padding */

		.navbar-wrapper { padding: {$header_padding} 15px; }
		";
	}

	$header_sandwich_icon_color = get_theme_mod( 'vct_header_sandwich_icon_color', '#ffffff' );
	if ( '#ffffff' !== $header_sandwich_icon_color ) {
		$css .= '
			.navbar-toggle .icon-bar {background-color: ' . $header_sandwich_icon_color . ';}
		';
	}

	$header_and_menu_area_menu_hover_background = get_theme_mod( 'vct_header_menu_hover_background', '#eeeeee' );
	if ( '#eeeeee' !== $header_and_menu_area_menu_hover_background ) {
		$css .= "
		/*Header and menu area menu hover background color*/
		@media only screen and (min-width: 768px) { body:not(.menu-sandwich) #main-menu ul li ul li:hover > a { background-color: {$header_and_menu_area_menu_hover_background}; } }
		";
	}

	// Featured image custom height.
	$vct_featured_image_custom_height = get_theme_mod( 'vct_overall_site_featured_image_custom_height', '400px' );
	if ( is_numeric( $vct_featured_image_custom_height ) ) {
		$vct_featured_image_custom_height .= 'px';
	}
	if ( get_theme_mod( 'vct_overall_site_featured_image_height', 'auto' ) === 'custom' ) {
		$css .= '
		/*Featured image custom height*/
		.header-image .fade-in-img { height: ' . $vct_featured_image_custom_height . '; }
		';

	}

	$content_area_background = get_theme_mod( 'vct_overall_site_content_background', '#ffffff' );
	if ( '#ffffff' !== $content_area_background ) {
		$css .= "
		/*Content area background*/
		.content-wrapper { background-color: {$content_area_background}; }
		";
	}

	$content_area_comments_background = get_theme_mod( 'vct_overall_site_comments_background', '#f4f4f4' );
	if ( '#f4f4f4' !== $content_area_comments_background ) {
		$css .= "
		/*Comments background*/
		.comments-area { background-color: {$content_area_comments_background}; }
		";
	}

	$footer_area_background = get_theme_mod( 'vct_footer_area_background', '#333333' );
	if ( '#333333' !== $footer_area_background ) {
		// Work out if hash given.
		$hex = str_replace( '#', '', $footer_area_background );

		// HEX TO RGB.
		$rgb = array( hexdec( substr( $hex,0,2 ) ), hexdec( substr( $hex,2,2 ) ), hexdec( substr( $hex,4,2 ) ) );
		// CALCULATE.
		for ( $i = 0; $i < 3; $i++ ) {
			$rgb[ $i ] = round( $rgb[ $i ] * 1.1 );

			// In case rounding up causes us to go to 256.
			if ( $rgb[ $i ] > 255 ) {
				$rgb[ $i ] = 255;
			}
		}
		// RBG to Hex.
		$hex = '';
		for ( $i = 0; $i < 3; $i++ ) {
			// Convert the decimal digit to hex.
			$hex_digit = dechex( $rgb[ $i ] );
			// Add a leading zero if necessary.
			if ( strlen( $hex_digit ) === 1 ) {
				$hex_digit = '0' . $hex_digit;
			}
			// Append to the hex string.
			$hex .= $hex_digit;
		}
		$footer_widget_area_background = '#' . $hex;
		$css .= "
		/*Footer area background color*/
		#footer { background-color: {$footer_area_background}; }
		.footer-widget-area { background-color: {$footer_widget_area_background}; }
		";
	}

	$footer_area_text_color = get_theme_mod( 'vct_footer_area_text_color', '#777777' );
	if ( '#777777' !== $footer_area_text_color ) {
		$css .= "
		/*Footer area text color*/
		#footer,
		#footer .footer-socials ul li a span {color: {$footer_area_text_color}; }
		";
	}

	$footer_area_text_active_color = get_theme_mod( 'vct_footer_area_text_active_color', '#ffffff' );
	if ( '#ffffff' !== $footer_area_text_active_color ) {
		$css .= "
		/*Footer area text active color*/
		#footer a,
		#footer .footer-socials ul li a:hover span { color: {$footer_area_text_active_color}; }
		#footer a:hover { border-bottom-color: {$footer_area_text_active_color}; }
		";
	}

	wp_add_inline_style( 'vct-custom-style', $css );
}
add_action( 'wp_enqueue_scripts', 'visualcomposerstarter_inline_styles' );
