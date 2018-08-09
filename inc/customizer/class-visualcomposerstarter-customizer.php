<?php
/**
 * Customizer
 *
 * @package WordPress
 * @subpackage Visual Composer Starter
 * @since Visual Composer Starter 1.0
 */

/**
 * Class VisualComposerStarter_Customizer
 */
class VisualComposerStarter_Customizer {
	/**
	 * Visual Composer Starter Customizer constructor.
	 *
	 * @access public
	 * @since  1.0
	 */
	public function __construct() {
		add_action( 'customize_register', array( $this, 'include_controls' ) );
		add_action( 'customize_register', array( $this, 'custom_css' ) );
		add_action( 'customize_register', array( $this, 'register_customize_sections' ) );
	}

	/**
	 * Custom css.
	 */
	public function custom_css() {
		wp_register_style( 'visualcomposerstarter-custom-css', get_template_directory_uri() . '/css/customizer-custom.css' );
		wp_enqueue_style( 'visualcomposerstarter-custom-css' );
	}

	/**
	 * Include Custom Controls
	 *
	 * Includes all our custom control classes.
	 *
	 * @param WP_Customize_Manager $wp_customize Customize manager class.
	 *
	 * @access public
	 * @since  1.0
	 * @return void
	 */
	public function include_controls( $wp_customize ) {
		require_once get_template_directory() . '/inc/customizer/controls/class-visualcomposerstarter-toggle-switch-control.php';
		$wp_customize->register_control_type( 'VisualComposerStarter_Toggle_Switch_Control' );
	}

	/**
	 * Add all panels and sections to the Customizer
	 *
	 * @param WP_Customize_Manager $wp_customize Customize manager class.
	 *
	 * @access public
	 * @since  1.0
	 * @return void
	 */
	public function register_customize_sections( $wp_customize ) {
		// Create sections.
		$wp_customize->add_section( 'vct_overall_site', array(
			'title'             => esc_html__( 'Theme Options', 'visual-composer-starter' ),
			'priority'          => 101,
			'capability'        => 'edit_theme_options',
		) );
		$wp_customize->add_section( 'vct_header_and_menu_area', array(
			'title'             => esc_html__( 'Header', 'visual-composer-starter' ),
			'priority'          => 102,
			'capability'        => 'edit_theme_options',
		) );
		$wp_customize->add_section( 'vct_footer_area', array(
			'title'             => esc_html__( 'Footer', 'visual-composer-starter' ),
			'priority'          => 103,
			'capability'        => 'edit_theme_options',
		) );
		$wp_customize->add_panel( 'vct_fonts_and_style', array(
			'priority'          => 105,
			'capability'        => 'edit_theme_options',
			'theme_supports'    => '',
			'title'             => esc_html__( 'Fonts & Style', 'visual-composer-starter' ),
		) );
		$wp_customize->add_section( 'vct_scripts', array(
			'priority'          => 999,
			'capability'        => 'edit_theme_options',
			'theme_supports'    => '',
			'title'             => esc_html__( 'Scripts', 'visual-composer-starter' ),
		) );

		// Populate sections.
		$this->overall_site_section( $wp_customize );
		$this->header_and_menu_section( $wp_customize );
		$this->footer_section( $wp_customize );
		$this->fonts_and_style_panel( $wp_customize );
	}

	/**
	 * Sanitize Custom Height
	 *
	 * @param integer $height Height.
	 *
	 * @return null
	 */
	public function sanitize_custom_height( $height ) {
		$matches = null;
		preg_match( '/^(([0-9]+)px|[0-9]+)$/', $height, $matches );

		if ( (bool) $matches ) {
			return $height;
		}
		return null;
	}

	/**
	 * Sanitize checkbox
	 *
	 * @param bool $input Input data.
	 *
	 * @return bool
	 */
	public function sanitize_checkbox( $input ) {
		return ( true === $input ) ? true : false;
	}

	/**
	 * Sanitize textarea
	 *
	 * @param string $text Text data.
	 *
	 * @return mixed
	 */
	public function sanitize_textarea( $text ) {
		return sanitize_textarea_field( $text );
	}

	/**
	 * Sanitize select
	 *
	 * @param string $input Text data.
	 * @param object $setting Settings object data.
	 *
	 * @return mixed
	 */
	public function sanitize_select( $input, $setting ) {
		$input = sanitize_key( $input );
		$choices = $setting->manager->get_control( $setting->id )->choices;
		return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
	}

	/**
	 * Sanitize google fonts select
	 *
	 * @param string $input Text data.
	 * @param object $setting Settings object data.
	 *
	 * @return mixed
	 */
	public function sanitize_select_google_fonts( $input, $setting ) {
		$input = wp_strip_all_tags( $input );
		$choices = $setting->manager->get_control( $setting->id )->choices;

		return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
	}

	/**
	 * Section: Overall Site
	 *
	 * @param WP_Customize_Manager $wp_customize Customize manager class.
	 *
	 * @access private
	 * @since  1.0
	 * @return void
	 */
	private function overall_site_section( $wp_customize ) {
		$wp_customize->add_setting( VISUALCOMPOSERSTARTER_DISABLE_HEADER,  array(
			'default'           => false,
			'sanitize_callback' => array( $this, 'sanitize_checkbox' ),
		) );

		$wp_customize->add_setting( VISUALCOMPOSERSTARTER_DISABLE_FOOTER,  array(
			'default'           => false,
			'sanitize_callback' => array( $this, 'sanitize_checkbox' ),
		) );

		$wp_customize->add_setting( 'vct_overall_site_featured_image',  array(
			'default' => true,
			'sanitize_callback' => array( $this, 'sanitize_checkbox' ),
		) );

		$wp_customize->add_setting( 'vct_overall_site_featured_image_width',  array(
			'default' => 'full_width',
			'sanitize_callback' => array( $this, 'sanitize_select' ),
		) );

		$wp_customize->add_setting( 'vct_overall_site_featured_image_height',  array(
			'default' => 'auto',
			'sanitize_callback' => array( $this, 'sanitize_select' ),
		) );

		$wp_customize->add_setting( 'vct_overall_site_featured_image_custom_height', array(
			'default'                   => '400px',
			'sanitize_callback'         => array( $this, 'sanitize_custom_height' ),
		) );

		$wp_customize->add_setting( 'vct_overall_content_area_size',  array(
			'default'       => 'boxed',
			'sanitize_callback' => array( $this, 'sanitize_select' ),
		) );

		$wp_customize->add_setting( VISUALCOMPOSERSTARTER_PAGE_SIDEBAR,  array(
			'default'       => 'none',
			'sanitize_callback' => array( $this, 'sanitize_select' ),
		) );

		$wp_customize->add_setting( VISUALCOMPOSERSTARTER_POST_SIDEBAR,  array(
			'default'       => 'none',
			'sanitize_callback' => array( $this, 'sanitize_select' ),
		) );

		$wp_customize->add_setting( VISUALCOMPOSERSTARTER_ARCHIVE_AND_CATEGORY_SIDEBAR,  array(
			'default'       => 'none',
			'sanitize_callback' => array( $this, 'sanitize_select' ),
		) );

		$wp_customize->add_setting( 'vct_overall_site_content_background',  array(
			'default'       => '#ffffff',
			'sanitize_callback' => 'sanitize_hex_color',
		) );

		$wp_customize->add_setting( 'vct_overall_site_comments_background',  array(
			'default'       => '#f4f4f4',
			'sanitize_callback' => 'sanitize_hex_color',
		) );

		$wp_customize->add_control(
			new VisualComposerStarter_Toggle_Switch_Control(
				$wp_customize,
				VISUALCOMPOSERSTARTER_DISABLE_HEADER,
				array(
					'type'          => 'toggle-switch',
					'label'         => esc_html__( 'Disable Theme Header', 'visual-composer-starter' ),
					'section'       => 'vct_overall_site',
					'settings'      => VISUALCOMPOSERSTARTER_DISABLE_HEADER,
			) )
		);

		$wp_customize->add_control(
			new VisualComposerStarter_Toggle_Switch_Control(
				$wp_customize,
				VISUALCOMPOSERSTARTER_DISABLE_FOOTER,
				array(
					'type'          => 'toggle-switch',
					'label'         => esc_html__( 'Disable Theme Footer', 'visual-composer-starter' ),
					'section'       => 'vct_overall_site',
					'settings'      => VISUALCOMPOSERSTARTER_DISABLE_FOOTER,
			) )
		);

		$wp_customize->add_control(
			new VisualComposerStarter_Toggle_Switch_Control(
				$wp_customize,
				'vct_overall_site_featured_image',
				array(
					'type'          => 'toggle-switch',
					'label'         => esc_html__( 'Featured Image', 'visual-composer-starter' ),
					'description'   => esc_html__( 'Show featured image for posts and pages.', 'visual-composer-starter' ),
					'section'       => 'vct_overall_site',
					'settings'      => 'vct_overall_site_featured_image',
				)
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'vct_overall_site_featured_image_width',
				array(
					'type'          => 'select',
					'label'         => esc_html__( 'Featured Image Width', 'visual-composer-starter' ),
					'section'       => 'vct_overall_site',
					'settings'      => 'vct_overall_site_featured_image_width',
					'choices'       => array(
						'full_width' => esc_html__( 'Full width (default)', 'visual-composer-starter' ),
						'boxed' => esc_html__( 'Boxed', 'visual-composer-starter' ),
					),
				)
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'vct_overall_site_featured_image_height',
				array(
					'type'          => 'select',
					'label'         => esc_html__( 'Featured Image Height', 'visual-composer-starter' ),
					'section'       => 'vct_overall_site',
					'settings'      => 'vct_overall_site_featured_image_height',
					'choices'       => array(
						'auto'              => esc_html__( 'Auto (default)', 'visual-composer-starter' ),
						'full_height'       => esc_html__( 'Full height', 'visual-composer-starter' ),
						'custom'            => esc_html__( 'Custom', 'visual-composer-starter' ),
					),
				)
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'vct_overall_site_featured_image_custom_height',
				array(
					'label'                     => esc_html__( 'Custom Height', 'visual-composer-starter' ),
					'description'               => esc_html__( 'Please specify featured image height in pixels (ex. 400px).', 'visual-composer-starter' ),
					'section'                   => 'vct_overall_site',
					'settings'                  => 'vct_overall_site_featured_image_custom_height',
				)
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'vct_overall_content_area_size',
				array(
					'type'          => 'select',
					'label'         => esc_html__( 'Content Area Size Customization', 'visual-composer-starter' ),
					'description'   => esc_html__( 'Default content area size is defined as Boxed and Full width.', 'visual-composer-starter' ),
					'section'       => 'vct_overall_site',
					'settings'      => 'vct_overall_content_area_size',
					'choices'       => array(
						'boxed'         => esc_html__( 'Boxed (default)', 'visual-composer-starter' ),
						'full_width'    => esc_html__( 'Full width', 'visual-composer-starter' ),
					),
				)
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				VISUALCOMPOSERSTARTER_PAGE_SIDEBAR,
				array(
					'type'          => 'select',
					'label'         => esc_html__( 'Page Sidebar Position', 'visual-composer-starter' ),
					'section'       => 'vct_overall_site',
					'settings'      => VISUALCOMPOSERSTARTER_PAGE_SIDEBAR,
					'choices'       => array(
						'none'  => esc_html__( 'None (default)', 'visual-composer-starter' ),
						'left'  => esc_html__( 'Left', 'visual-composer-starter' ),
						'right' => esc_html__( 'Right', 'visual-composer-starter' ),
					),
				)
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				VISUALCOMPOSERSTARTER_POST_SIDEBAR,
				array(
					'type'          => 'select',
					'label'         => esc_html__( 'Post Sidebar Position', 'visual-composer-starter' ),
					'section'       => 'vct_overall_site',
					'settings'      => VISUALCOMPOSERSTARTER_POST_SIDEBAR,
					'choices'       => array(
						'none'  => esc_html__( 'None (default)', 'visual-composer-starter' ),
						'left'  => esc_html__( 'Left', 'visual-composer-starter' ),
						'right' => esc_html__( 'Right', 'visual-composer-starter' ),
					),
				)
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				VISUALCOMPOSERSTARTER_ARCHIVE_AND_CATEGORY_SIDEBAR,
				array(
					'type'          => 'select',
					'label'         => esc_html__( 'Archive/Category Sidebar Position', 'visual-composer-starter' ),
					'section'       => 'vct_overall_site',
					'settings'      => VISUALCOMPOSERSTARTER_ARCHIVE_AND_CATEGORY_SIDEBAR,
					'choices'       => array(
						'none'  => esc_html__( 'None (default)', 'visual-composer-starter' ),
						'left'  => esc_html__( 'Left', 'visual-composer-starter' ),
						'right' => esc_html__( 'Right', 'visual-composer-starter' ),
					),
				)
			)
		);

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'background_color', array(
			'label'   => esc_html__( 'Site Background', 'visual-composer-starter' ),
			'section' => 'vct_overall_site',
		) ) );

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'vct_overall_site_content_background',
				array(
					'label'         => esc_html__( 'Content Background', 'visual-composer-starter' ),
					'section'       => 'vct_overall_site',
					'settings'      => 'vct_overall_site_content_background',
				)
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'vct_overall_site_comments_background',
				array(
					'label'         => esc_html__( 'Comments Background', 'visual-composer-starter' ),
					'section'       => 'vct_overall_site',
					'settings'      => 'vct_overall_site_comments_background',
				)
			)
		);
	}

	/**
	 * Section: Header Section
	 *
	 * @param WP_Customize_Manager $wp_customize Customize manager class.
	 *
	 * @access private
	 * @since  1.0
	 * @return void
	 */
	private function header_and_menu_section( $wp_customize ) {
		$wp_customize->add_setting( 'vct_header_background',  array(
			'default'       => '#ffffff',
			'sanitize_callback' => 'sanitize_hex_color',
		) );

		$wp_customize->add_setting( 'vct_header_menu_hover_background',  array(
			'default'       => '#eeeeee',
			'sanitize_callback' => 'sanitize_hex_color',
		) );

		$wp_customize->add_setting( 'vct_header_text_color',  array(
			'default'       => '#555555',
			'sanitize_callback' => 'sanitize_hex_color',
		) );

		$wp_customize->add_setting( 'vct_header_text_active_color',  array(
			'default'       => '#333333',
			'sanitize_callback' => 'sanitize_hex_color',
		) );

		$wp_customize->add_setting( 'vct_header_padding',  array(
			'default'       => '25px',
			'sanitize_callback' => 'wp_strip_all_tags',
		) );

		$wp_customize->add_setting( 'vct_header_position',  array(
			'default'       => 'top',
			'sanitize_callback' => array( $this, 'sanitize_select' ),
		) );

		$wp_customize->add_setting( 'vct_header_sandwich_style',  array(
			'default'       => '#333333',
			'sanitize_callback' => array( $this, 'sanitize_select' ),
		) );

		$wp_customize->add_setting( 'vct_header_top_header_width',  array(
			'default'       => 'boxed',
			'sanitize_callback' => array( $this, 'sanitize_select' ),
		) );

		$wp_customize->add_setting( 'vct_header_reserve_space_for_header',  array(
			'default'       => true,
			'sanitize_callback' => array( $this, 'sanitize_checkbox' ),
		) );

		$wp_customize->add_setting( 'vct_header_sticky_header',  array(
			'default'       => false,
			'sanitize_callback' => array( $this, 'sanitize_checkbox' ),
		) );

		$wp_customize->add_setting( 'vct_header_sandwich_icon_color',  array(
			'default'       => '#ffffff',
			'sanitize_callback' => 'sanitize_hex_color',
		) );

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'vct_header_position',
				array(
					'type'          => 'select',
					'label'         => esc_html__( 'Header Style', 'visual-composer-starter' ),
					'section'       => 'vct_header_and_menu_area',
					'settings'      => 'vct_header_position',
					'choices'       => array(
						'top'           => esc_html__( 'Top (default)', 'visual-composer-starter' ),
						'sandwich'      => esc_html__( 'Sandwich', 'visual-composer-starter' ),
					),
				)
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'vct_header_top_header_width',
				array(
					'type'          => 'select',
					'label'         => esc_html__( 'Header Width', 'visual-composer-starter' ),
					'section'       => 'vct_header_and_menu_area',
					'settings'      => 'vct_header_top_header_width',
					'choices'       => array(
						'boxed'             => esc_html__( 'Boxed (default)', 'visual-composer-starter' ),
						'full_width_boxed'  => esc_html__( 'Full width boxed', 'visual-composer-starter' ),
						'full_width'        => esc_html__( 'Full width', 'visual-composer-starter' ),
					),
				)
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'vct_header_background',
				array(
					'label'         => esc_html__( 'Background Color', 'visual-composer-starter' ),
					'description'   => esc_html__( 'Define header and submenu background color.', 'visual-composer-starter' ),
					'section'       => 'vct_header_and_menu_area',
					'settings'      => 'vct_header_background',
				)
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'vct_header_menu_hover_background',
				array(
					'label'         => esc_html__( 'Submenu Background Hover Color', 'visual-composer-starter' ),
					'section'       => 'vct_header_and_menu_area',
					'settings'      => 'vct_header_menu_hover_background',
				)
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'vct_header_text_color',
				array(
					'label'         => esc_html__( 'Text Color', 'visual-composer-starter' ),
					'section'       => 'vct_header_and_menu_area',
					'settings'      => 'vct_header_text_color',
				)
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'vct_header_text_active_color',
				array(
					'label'         => esc_html__( 'Active Text Color', 'visual-composer-starter' ),
					'section'       => 'vct_header_and_menu_area',
					'settings'      => 'vct_header_text_active_color',
				)
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'vct_header_padding',
				array(
					'label'    => esc_html__( 'Header Padding', 'visual-composer-starter' ),
					'section'  => 'vct_header_and_menu_area',
					'settings' => 'vct_header_padding',
					'type'     => 'text',
				) )
		);

		$wp_customize->add_control(
			new VisualComposerStarter_Toggle_Switch_Control(
				$wp_customize,
				'vct_header_reserve_space_for_header',
				array(
					'type'          => 'toggle-switch',
					'label'         => esc_html__( 'Reserve Space For Header', 'visual-composer-starter' ),
					'description'   => esc_html__( 'By default header will be placed on the top of featured image.', 'visual-composer-starter' ),
					'section'       => 'vct_header_and_menu_area',
					'settings'      => 'vct_header_reserve_space_for_header',
				)
			)
		);

		$wp_customize->add_control(
			new VisualComposerStarter_Toggle_Switch_Control(
				$wp_customize,
				'vct_header_sticky_header',
				array(
					'type'          => 'toggle-switch',
					'label'         => esc_html__( 'Sticky Header', 'visual-composer-starter' ),
					'description'   => esc_html__( 'If set to \'On\' header will stay fixed on the top when scrolling.', 'visual-composer-starter' ),
					'section'       => 'vct_header_and_menu_area',
					'settings'      => 'vct_header_sticky_header',
				)
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'vct_header_sandwich_style',
				array(
					'type'          => 'select',
					'label'         => esc_html__( 'Sandwich Style', 'visual-composer-starter' ),
					'description'   => esc_html__( 'Define sandwich background and control style.', 'visual-composer-starter' ),
					'section'       => 'vct_header_and_menu_area',
					'settings'      => 'vct_header_sandwich_style',
					'choices'       => array(
						'#333333'      => esc_html__( 'Dark (default)', 'visual-composer-starter' ),
						'#FFFFFF'      => esc_html__( 'Light', 'visual-composer-starter' ),
					),
				)
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'vct_header_sandwich_icon_color',
				array(
					'label'         => esc_html__( 'Sandwich Icon Color', 'visual-composer-starter' ),
					'section'       => 'vct_header_and_menu_area',
					'settings'      => 'vct_header_sandwich_icon_color',
				)
			)
		);

	}

	/**
	 * Section: Footer Section
	 *
	 * @param WP_Customize_Manager $wp_customize Customize manager class.
	 *
	 * @access private
	 * @since  1.0
	 * @return void
	 */
	private function footer_section( $wp_customize ) {
		$wp_customize->add_setting( 'vct_footer_area_background',  array(
			'default'       => '#333333',
			'sanitize_callback' => 'sanitize_hex_color',
		) );

		$wp_customize->add_setting( 'vct_footer_area_text_color',  array(
			'default'       => '#777777',
			'sanitize_callback' => 'sanitize_hex_color',
		) );

		$wp_customize->add_setting( 'vct_footer_area_text_active_color',  array(
			'default'       => '#ffffff',
			'sanitize_callback' => 'sanitize_hex_color',
		) );

		$wp_customize->add_setting( 'vct_footer_area_widget_area',  array(
			'default'       => false,
			'sanitize_callback' => array( $this, 'sanitize_checkbox' ),
		) );

		$wp_customize->add_setting( 'vct_footer_area_widgetized_columns',  array(
			'default'       => 1,
			'sanitize_callback' => array( $this, 'sanitize_select' ),
		) );

		$wp_customize->add_setting( 'vct_footer_area_social_icons',  array(
			'default'       => false,
			'sanitize_callback' => array( $this, 'sanitize_checkbox' ),
		) );

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'vct_footer_area_background',
				array(
					'label'         => esc_html__( 'Footer Background Color', 'visual-composer-starter' ),
					'section'       => 'vct_footer_area',
					'settings'      => 'vct_footer_area_background',
				)
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'vct_footer_area_text_color',
				array(
					'label'         => esc_html__( 'Text Color', 'visual-composer-starter' ),
					'section'       => 'vct_footer_area',
					'settings'      => 'vct_footer_area_text_color',
				)
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'vct_footer_area_text_active_color',
				array(
					'label'         => esc_html__( 'Active Color', 'visual-composer-starter' ),
					'section'       => 'vct_footer_area',
					'settings'      => 'vct_footer_area_text_active_color',
				)
			)
		);

		$wp_customize->add_control(
			new VisualComposerStarter_Toggle_Switch_Control(
				$wp_customize,
				'vct_footer_area_widget_area',
				array(
					'type'          => 'toggle-switch',
					'label'         => esc_html__( 'Widget Area', 'visual-composer-starter' ),
					'description'   => esc_html__( 'Theme footer allows inserting widget area at the top of the footer.', 'visual-composer-starter' ),
					'section'       => 'vct_footer_area',
					'settings'      => 'vct_footer_area_widget_area',
				)
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'vct_footer_area_widgetized_columns',
				array(
					'label'         => esc_html__( 'Number of Columns', 'visual-composer-starter' ),
					'description'   => esc_html__( 'Widget area can be divided into up to four columns.', 'visual-composer-starter' ),
					'section'       => 'vct_footer_area',
					'settings'      => 'vct_footer_area_widgetized_columns',
					'type'    => 'select',
					'choices'  => array(
						1 => esc_html__( 'One', 'visual-composer-starter' ),
						2 => esc_html__( 'Two', 'visual-composer-starter' ),
						3 => esc_html__( 'Three', 'visual-composer-starter' ),
						4 => esc_html__( 'Four', 'visual-composer-starter' ),
					),
				)
			)
		);

		$wp_customize->add_control(
			new VisualComposerStarter_Toggle_Switch_Control(
				$wp_customize,
				'vct_footer_area_social_icons',
				array(
					'type'          => 'toggle-switch',
					'label'         => esc_html__( 'Social Icons', 'visual-composer-starter' ),
					'description'   => esc_html__( 'Add url to your social network profiles.', 'visual-composer-starter' ),
					'section'       => 'vct_footer_area',
					'settings'      => 'vct_footer_area_social_icons',
				)
			)
		);

		$wp_customize->add_setting( 'vct_footer_area_social_link_facebook',  array(
			'default'       => '',
			'sanitize_callback' => 'esc_url_raw',
		) );

		$wp_customize->add_setting( 'vct_footer_area_social_link_twitter',  array(
			'default'       => '',
			'sanitize_callback' => 'esc_url_raw',
		) );

		$wp_customize->add_setting( 'vct_footer_area_social_link_linkedin',  array(
			'default'       => '',
			'sanitize_callback' => 'esc_url_raw',
		) );

		$wp_customize->add_setting( 'vct_footer_area_social_link_github',  array(
			'default'       => '',
			'sanitize_callback' => 'esc_url_raw',
		) );

		$wp_customize->add_setting( 'vct_footer_area_social_link_instagram',  array(
			'default'       => '',
			'sanitize_callback' => 'esc_url_raw',
		) );

		$wp_customize->add_setting( 'vct_footer_area_social_link_pinterest',  array(
			'default'       => '',
			'sanitize_callback' => 'esc_url_raw',
		) );

		$wp_customize->add_setting( 'vct_footer_area_social_link_flickr',  array(
			'default'       => '',
			'sanitize_callback' => 'esc_url_raw',
		) );

		$wp_customize->add_setting( 'vct_footer_area_social_link_youtube',  array(
			'default'       => '',
			'sanitize_callback' => 'esc_url_raw',
		) );

		$wp_customize->add_setting( 'vct_footer_area_social_link_vimeo',  array(
			'default'       => '',
			'sanitize_callback' => 'esc_url_raw',
		) );

		$wp_customize->add_setting( 'vct_footer_area_social_link_email', array(
			'default' => '',
			'sanitize_callback' => 'sanitize_email',
		) );

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'vct_footer_area_social_link_facebook',
				array(
					'type'          => 'text',
					'label'         => esc_html__( 'Facebook', 'visual-composer-starter' ),
					'section'       => 'vct_footer_area',
					'settings'      => 'vct_footer_area_social_link_facebook',
				)
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'vct_footer_area_social_link_twitter',
				array(
					'type'          => 'text',
					'label'         => esc_html__( 'Twitter', 'visual-composer-starter' ),
					'section'       => 'vct_footer_area',
					'settings'      => 'vct_footer_area_social_link_twitter',
				)
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'vct_footer_area_social_link_linkedin',
				array(
					'type'          => 'text',
					'label'         => esc_html__( 'LinkedIn', 'visual-composer-starter' ),
					'section'       => 'vct_footer_area',
					'settings'      => 'vct_footer_area_social_link_linkedin',
				)
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'vct_footer_area_social_link_instagram',
				array(
					'type'          => 'text',
					'label'         => esc_html__( 'Instagram', 'visual-composer-starter' ),
					'section'       => 'vct_footer_area',
					'settings'      => 'vct_footer_area_social_link_instagram',
				)
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'vct_footer_area_social_link_pinterest',
				array(
					'type'          => 'text',
					'label'         => esc_html__( 'Pinterest', 'visual-composer-starter' ),
					'section'       => 'vct_footer_area',
					'settings'      => 'vct_footer_area_social_link_pinterest',
				)
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'vct_footer_area_social_link_youtube',
				array(
					'type'          => 'text',
					'label'         => esc_html__( 'YouTube', 'visual-composer-starter' ),
					'section'       => 'vct_footer_area',
					'settings'      => 'vct_footer_area_social_link_youtube',
				)
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'vct_footer_area_social_link_vimeo',
				array(
					'type'          => 'text',
					'label'         => esc_html__( 'Vimeo', 'visual-composer-starter' ),
					'section'       => 'vct_footer_area',
					'settings'      => 'vct_footer_area_social_link_vimeo',
				)
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'vct_footer_area_social_link_flickr',
				array(
					'type'          => 'text',
					'label'         => esc_html__( 'Flickr', 'visual-composer-starter' ),
					'section'       => 'vct_footer_area',
					'settings'      => 'vct_footer_area_social_link_flickr',
				)
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'vct_footer_area_social_link_github',
				array(
					'type'          => 'text',
					'label'         => esc_html__( 'Github', 'visual-composer-starter' ),
					'section'       => 'vct_footer_area',
					'settings'      => 'vct_footer_area_social_link_github',
				)
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'vct_footer_area_social_link_email',
				array(
					'type'          => 'text',
					'label'         => esc_html__( 'Email', 'visual-composer-starter' ),
					'section'       => 'vct_footer_area',
					'settings'      => 'vct_footer_area_social_link_email',
				)
			)
		);
	}

	/**
	 * Section: Body Fonts & Styles Section
	 *
	 * @param WP_Customize_Manager $wp_customize Customize manager class.
	 *
	 * @access private
	 * @since  1.0
	 * @return void
	 */
	private function fonts_and_style_panel( $wp_customize ) {
		$wp_customize->add_section( 'vct_fonts_and_style_h1', array(
			'title'         => esc_html__( 'H1', 'visual-composer-starter' ),
			'priority'      => 100,
			'capability'    => 'edit_theme_options',
			'panel'         => 'vct_fonts_and_style',
		) );
		$wp_customize->add_section( 'vct_fonts_and_style_h2', array(
			'title'         => esc_html__( 'H2', 'visual-composer-starter' ),
			'priority'      => 101,
			'capability'    => 'edit_theme_options',
			'panel'         => 'vct_fonts_and_style',
		) );
		$wp_customize->add_section( 'vct_fonts_and_style_h3', array(
			'title'         => esc_html__( 'H3', 'visual-composer-starter' ),
			'priority'      => 102,
			'capability'    => 'edit_theme_options',
			'panel'         => 'vct_fonts_and_style',
		) );
		$wp_customize->add_section( 'vct_fonts_and_style_h4', array(
			'title'         => esc_html__( 'H4', 'visual-composer-starter' ),
			'priority'      => 103,
			'capability'    => 'edit_theme_options',
			'panel'         => 'vct_fonts_and_style',
		) );
		$wp_customize->add_section( 'vct_fonts_and_style_h5', array(
			'title'         => esc_html__( 'H5', 'visual-composer-starter' ),
			'priority'      => 104,
			'capability'    => 'edit_theme_options',
			'panel'         => 'vct_fonts_and_style',
		) );
		$wp_customize->add_section( 'vct_fonts_and_style_h6', array(
			'title'         => esc_html__( 'H6', 'visual-composer-starter' ),
			'priority'      => 105,
			'capability'    => 'edit_theme_options',
			'panel'         => 'vct_fonts_and_style',
		) );
		$wp_customize->add_section( 'vct_fonts_and_style_body', array(
			'title'         => esc_html__( 'Body', 'visual-composer-starter' ),
			'priority'      => 106,
			'capability'    => 'edit_theme_options',
			'panel'         => 'vct_fonts_and_style',
		) );
		$wp_customize->add_section( 'vct_fonts_and_style_buttons', array(
			'title'         => esc_html__( 'Buttons', 'visual-composer-starter' ),
			'priority'      => 107,
			'capability'    => 'edit_theme_options',
			'panel'         => 'vct_fonts_and_style',
		) );

		$this->fonts_and_style_section_h1( $wp_customize );
		$this->fonts_and_style_section_h2( $wp_customize );
		$this->fonts_and_style_section_h3( $wp_customize );
		$this->fonts_and_style_section_h4( $wp_customize );
		$this->fonts_and_style_section_h5( $wp_customize );
		$this->fonts_and_style_section_h6( $wp_customize );
		$this->fonts_and_style_section_body( $wp_customize );
		$this->fonts_and_style_section_buttons( $wp_customize );
	}

	/**
	 * H1 fonts and style section
	 *
	 * @param object $wp_customize Customizer object.
	 */
	private function fonts_and_style_section_h1( $wp_customize ) {
		$wp_customize->add_setting( 'vct_fonts_and_style_h1_text_color', array(
			'default'        => '#333333',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_h1_active_color', array(
			'default'        => '#557cbf',
			'sanitize_callback' => 'sanitize_hex_color',
		) );

		$wp_customize->add_setting( 'vct_fonts_and_style_h1_font_family', array(
			'default'        => 'Playfair Display',
			'sanitize_callback' => array( $this, 'sanitize_select_google_fonts' ),
		) );

		$wp_customize->add_setting( 'vct_fonts_and_style_h1_subsets', array(
			'default'        => 'all',
			'sanitize_callback' => array( $this, 'sanitize_select' ),
		) );

		$wp_customize->add_setting( 'vct_fonts_and_style_h1_font_size', array(
			'default'        => '42px',
			'sanitize_callback' => 'wp_strip_all_tags',
		) );

		$wp_customize->add_setting( 'vct_fonts_and_style_h1_letter_spacing', array(
			'default'        => '0.01rem',
			'sanitize_callback' => 'wp_strip_all_tags',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_h1_line_height', array(
			'default'        => '1.1',
			'sanitize_callback' => 'wp_strip_all_tags',
		) );

		$wp_customize->add_setting( 'vct_fonts_and_style_h1_weight', array(
			'default'        => '400',
			'sanitize_callback' => array( $this, 'sanitize_select' ),
		) );

		$wp_customize->add_setting( 'vct_fonts_and_style_h1_font_style', array(
			'default'        => 'normal',
			'sanitize_callback' => array( $this, 'sanitize_select' ),
		) );

		$wp_customize->add_setting( 'vct_fonts_and_style_h1_margin_top', array(
			'default'        => '0',
			'sanitize_callback' => 'wp_strip_all_tags',
		) );

		$wp_customize->add_setting( 'vct_fonts_and_style_h1_margin_bottom', array(
			'default'        => '2.125rem',
			'sanitize_callback' => 'wp_strip_all_tags',
		) );

		$wp_customize->add_setting( 'vct_fonts_and_style_h1_capitalization', array(
			'default'        => 'none',
			'sanitize_callback' => array( $this, 'sanitize_select' ),
		) );

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'vct_fonts_and_style_h1_text_color',
				array(
					'label'         => esc_html__( 'Color', 'visual-composer-starter' ),
					'section'       => 'vct_fonts_and_style_h1',
					'settings'      => 'vct_fonts_and_style_h1_text_color',
				)
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'vct_fonts_and_style_h1_active_color',
				array(
					'label'         => esc_html__( 'Active Color', 'visual-composer-starter' ),
					'section'       => 'vct_fonts_and_style_h1',
					'settings'      => 'vct_fonts_and_style_h1_active_color',
				)
			)
		);
		$wp_customize->add_control( 'vct_fonts_and_style_h1_font_family', array(
			'label'   => esc_html__( 'Font-family', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h1',
			'settings'   => 'vct_fonts_and_style_h1_font_family',
			'type'    => 'select',
			'choices'     => VisualComposerStarter_Fonts::vct_theme_font_choices(),
		) );
		$wp_customize->add_control( 'vct_fonts_and_style_h1_subsets', array(
			'label'   => esc_html__( 'Google Fonts Subsets', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h1',
			'settings'   => 'vct_fonts_and_style_h1_subsets',
			'type'    => 'select',
			'choices'     => VisualComposerStarter_Fonts::vct_theme_font_subsets(),
		) );
		$wp_customize->add_control( 'vct_fonts_and_style_h1_weight', array(
			'label'   => esc_html__( 'Font Weight', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h1',
			'settings'   => 'vct_fonts_and_style_h1_weight',
			'type'    => 'select',
			'choices'  => array(
				'300' => esc_html__( 'Light', 'visual-composer-starter' ),
				'400' => esc_html__( 'Normal (default)', 'visual-composer-starter' ),
				'600' => esc_html__( 'Semi-Bold', 'visual-composer-starter' ),
				'700' => esc_html__( 'Bold', 'visual-composer-starter' ),
			),
		) );
		$wp_customize->add_control( 'vct_fonts_and_style_h1_font_style', array(
			'label'   => esc_html__( 'Font Style', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h1',
			'settings'   => 'vct_fonts_and_style_h1_font_style',
			'type'    => 'select',
			'choices'  => array(
				'normal' => esc_html__( 'Normal (default)', 'visual-composer-starter' ),
				'italic' => esc_html__( 'Italic', 'visual-composer-starter' ),
				'oblique' => esc_html__( 'Oblique', 'visual-composer-starter' ),
				'inherit' => esc_html__( 'Inherit', 'visual-composer-starter' ),
			),
		) );
		$wp_customize->add_control( 'vct_fonts_and_style_h1_font_size', array(
			'label'   => esc_html__( 'Size', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h1',
			'settings'   => 'vct_fonts_and_style_h1_font_size',
			'type'    => 'text',
		) );
		$wp_customize->add_control( 'vct_fonts_and_style_h1_line_height', array(
			'label'   => esc_html__( 'Line Height', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h1',
			'settings'   => 'vct_fonts_and_style_h1_line_height',
			'type'    => 'text',
		) );
		$wp_customize->add_control( 'vct_fonts_and_style_h1_letter_spacing', array(
			'label'   => esc_html__( 'Letter Spacing', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h1',
			'settings'   => 'vct_fonts_and_style_h1_letter_spacing',
			'type'    => 'text',
		) );
		$wp_customize->add_control( 'vct_fonts_and_style_h1_margin_top', array(
			'label'   => esc_html__( 'Margin Top', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h1',
			'settings'   => 'vct_fonts_and_style_h1_margin_top',
			'type'    => 'text',
		) );
		$wp_customize->add_control( 'vct_fonts_and_style_h1_margin_bottom', array(
			'label'   => esc_html__( 'Margin Bottom', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h1',
			'settings'   => 'vct_fonts_and_style_h1_margin_bottom',
			'type'    => 'text',
		) );
		$wp_customize->add_control( 'vct_fonts_and_style_h1_capitalization', array(
			'label'   => esc_html__( 'Capitalization', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h1',
			'settings'   => 'vct_fonts_and_style_h1_capitalization',
			'type'    => 'select',
			'choices'  => array(
				'none'  => esc_html__( 'None (default)', 'visual-composer-starter' ),
				'uppercase' => esc_html__( 'Uppercase', 'visual-composer-starter' ),
				'lowercase' => esc_html__( 'Lowercase', 'visual-composer-starter' ),
				'capitalize' => esc_html__( 'Capitalize', 'visual-composer-starter' ),
			),
		) );
	}

	/**
	 * H2 fonts and style section
	 *
	 * @param object $wp_customize Customizer object.
	 */
	private function fonts_and_style_section_h2( $wp_customize ) {
		$wp_customize->add_setting( 'vct_fonts_and_style_h2_text_color', array(
			'default'        => '#333333',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_h2_active_color', array(
			'default'        => '#557cbf',
			'sanitize_callback' => 'sanitize_hex_color',
		) );

		$wp_customize->add_setting( 'vct_fonts_and_style_h2_font_family', array(
			'default'        => 'Playfair Display',
			'sanitize_callback' => array( $this, 'sanitize_select_google_fonts' ),
		) );

		$wp_customize->add_setting( 'vct_fonts_and_style_h2_subsets', array(
			'default'        => 'all',
			'sanitize_callback' => array( $this, 'sanitize_select' ),
		) );

		$wp_customize->add_setting( 'vct_fonts_and_style_h2_font_size', array(
			'default'        => '36px',
			'sanitize_callback' => 'wp_strip_all_tags',
		) );

		$wp_customize->add_setting( 'vct_fonts_and_style_h2_letter_spacing', array(
			'default'        => '0.01rem',
			'sanitize_callback' => 'wp_strip_all_tags',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_h2_line_height', array(
			'default'        => '1.1',
			'sanitize_callback' => 'wp_strip_all_tags',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_h2_weight', array(
			'default'        => '400',
			'sanitize_callback' => array( $this, 'sanitize_select' ),
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_h2_font_style', array(
			'default'        => 'normal',
			'sanitize_callback' => array( $this, 'sanitize_select' ),
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_h2_margin_top', array(
			'default'        => '0',
			'sanitize_callback' => 'wp_strip_all_tags',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_h2_margin_bottom', array(
			'default'        => '0.625rem',
			'sanitize_callback' => 'wp_strip_all_tags',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_h2_capitalization', array(
			'default'        => 'none',
			'sanitize_callback' => array( $this, 'sanitize_select' ),
		) );

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'vct_fonts_and_style_h2_text_color',
				array(
					'label'         => esc_html__( 'Color', 'visual-composer-starter' ),
					'section'       => 'vct_fonts_and_style_h2',
					'settings'      => 'vct_fonts_and_style_h2_text_color',
				)
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'vct_fonts_and_style_h2_active_color',
				array(
					'label'         => esc_html__( 'Active Color', 'visual-composer-starter' ),
					'section'       => 'vct_fonts_and_style_h2',
					'settings'      => 'vct_fonts_and_style_h2_active_color',
				)
			)
		);

		$wp_customize->add_control( 'vct_fonts_and_style_h2_font_family', array(
			'label'   => esc_html__( 'Font-family', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h2',
			'settings'   => 'vct_fonts_and_style_h2_font_family',
			'type'    => 'select',
			'choices'     => VisualComposerStarter_Fonts::vct_theme_font_choices(),
		) );

		$wp_customize->add_control( 'vct_fonts_and_style_h2_subsets', array(
			'label'   => esc_html__( 'Google Fonts Subsets', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h2',
			'settings'   => 'vct_fonts_and_style_h2_subsets',
			'type'    => 'select',
			'choices'     => VisualComposerStarter_Fonts::vct_theme_font_subsets(),
		) );

		$wp_customize->add_control( 'vct_fonts_and_style_h2_weight', array(
			'label'   => esc_html__( 'Font Weight', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h2',
			'settings'   => 'vct_fonts_and_style_h2_weight',
			'type'    => 'select',
			'choices'  => array(
				'300' => esc_html__( 'Light', 'visual-composer-starter' ),
				'400' => esc_html__( 'Normal (default)', 'visual-composer-starter' ),
				'600' => esc_html__( 'Semi-Bold', 'visual-composer-starter' ),
				'700' => esc_html__( 'Bold', 'visual-composer-starter' ),
			),
		) );

		$wp_customize->add_control( 'vct_fonts_and_style_h2_font_style', array(
			'label'   => esc_html__( 'Font Style', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h2',
			'settings'   => 'vct_fonts_and_style_h2_font_style',
			'type'    => 'select',
			'choices'  => array(
				'normal' => esc_html__( 'Normal (default)', 'visual-composer-starter' ),
				'italic' => esc_html__( 'Italic', 'visual-composer-starter' ),
				'oblique' => esc_html__( 'Oblique', 'visual-composer-starter' ),
				'inherit' => esc_html__( 'Inherit', 'visual-composer-starter' ),
			),
		) );

		$wp_customize->add_control( 'vct_fonts_and_style_h2_font_size', array(
			'label'   => esc_html__( 'Size', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h2',
			'settings'   => 'vct_fonts_and_style_h2_font_size',
			'type'    => 'text',
		) );

		$wp_customize->add_control( 'vct_fonts_and_style_h2_line_height', array(
			'label'   => esc_html__( 'Line Height', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h2',
			'settings'   => 'vct_fonts_and_style_h2_line_height',
			'type'    => 'text',
		) );

		$wp_customize->add_control( 'vct_fonts_and_style_h2_letter_spacing', array(
			'label'   => esc_html__( 'Letter Spacing', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h2',
			'settings'   => 'vct_fonts_and_style_h2_letter_spacing',
			'type'    => 'text',
		) );
		$wp_customize->add_control( 'vct_fonts_and_style_h2_margin_top', array(
			'label'   => esc_html__( 'Margin Top', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h2',
			'settings'   => 'vct_fonts_and_style_h2_margin_top',
			'type'    => 'text',
		) );
		$wp_customize->add_control( 'vct_fonts_and_style_h2_margin_bottom', array(
			'label'   => esc_html__( 'Margin Bottom', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h2',
			'settings'   => 'vct_fonts_and_style_h2_margin_bottom',
			'type'    => 'text',
		) );
		$wp_customize->add_control( 'vct_fonts_and_style_h2_capitalization', array(
			'label'   => esc_html__( 'Capitalization', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h2',
			'settings'   => 'vct_fonts_and_style_h2_capitalization',
			'type'    => 'select',
			'choices'  => array(
				'none'  => esc_html__( 'None (default)', 'visual-composer-starter' ),
				'uppercase' => esc_html__( 'Uppercase', 'visual-composer-starter' ),
				'lowercase' => esc_html__( 'Lowercase', 'visual-composer-starter' ),
				'capitalize' => esc_html__( 'Capitalize', 'visual-composer-starter' ),
			),
		) );
	}

	/**
	 * H3 fonts and style section
	 *
	 * @param object $wp_customize Customizer object.
	 */
	private function fonts_and_style_section_h3( $wp_customize ) {
		$wp_customize->add_setting( 'vct_fonts_and_style_h3_text_color', array(
			'default'        => '#333333',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_h3_active_color', array(
			'default'        => '#557cbf',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_h3_font_family', array(
			'default'        => 'Playfair Display',
			'sanitize_callback' => array( $this, 'sanitize_select_google_fonts' ),
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_h3_subsets', array(
			'default'        => 'all',
			'sanitize_callback' => array( $this, 'sanitize_select' ),
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_h3_font_size', array(
			'default'        => '30px',
			'sanitize_callback' => 'wp_strip_all_tags',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_h3_letter_spacing', array(
			'default'        => '0.01rem',
			'sanitize_callback' => 'wp_strip_all_tags',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_h3_line_height', array(
			'default'        => '1.1',
			'sanitize_callback' => 'wp_strip_all_tags',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_h3_weight', array(
			'default'        => '400',
			'sanitize_callback' => array( $this, 'sanitize_select' ),
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_h3_font_style', array(
			'default'        => 'normal',
			'sanitize_callback' => array( $this, 'sanitize_select' ),
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_h3_margin_top', array(
			'default'        => '0',
			'sanitize_callback' => 'wp_strip_all_tags',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_h3_margin_bottom', array(
			'default'        => '0.625rem',
			'sanitize_callback' => 'wp_strip_all_tags',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_h3_capitalization', array(
			'default'        => 'none',
			'sanitize_callback' => array( $this, 'sanitize_select' ),
		) );

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'vct_fonts_and_style_h3_text_color',
				array(
					'label'         => esc_html__( 'Color', 'visual-composer-starter' ),
					'section'       => 'vct_fonts_and_style_h3',
					'settings'      => 'vct_fonts_and_style_h3_text_color',
				)
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'vct_fonts_and_style_h3_active_color',
				array(
					'label'         => esc_html__( 'Active Color', 'visual-composer-starter' ),
					'section'       => 'vct_fonts_and_style_h3',
					'settings'      => 'vct_fonts_and_style_h3_active_color',
				)
			)
		);
		$wp_customize->add_control( 'vct_fonts_and_style_h3_font_family', array(
			'label'   => esc_html__( 'Font-family', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h3',
			'settings'   => 'vct_fonts_and_style_h3_font_family',
			'type'    => 'select',
			'choices'     => VisualComposerStarter_Fonts::vct_theme_font_choices(),
		) );
		$wp_customize->add_control( 'vct_fonts_and_style_h3_subsets', array(
			'label'   => esc_html__( 'Google Fonts Subsets', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h3',
			'settings'   => 'vct_fonts_and_style_h3_subsets',
			'type'    => 'select',
			'choices'     => VisualComposerStarter_Fonts::vct_theme_font_subsets(),
		) );
		$wp_customize->add_control( 'vct_fonts_and_style_h3_weight', array(
			'label'   => esc_html__( 'Font Weight', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h3',
			'settings'   => 'vct_fonts_and_style_h3_weight',
			'type'    => 'select',
			'choices'  => array(
				'300' => esc_html__( 'Light', 'visual-composer-starter' ),
				'400' => esc_html__( 'Normal (default)', 'visual-composer-starter' ),
				'600' => esc_html__( 'Semi-Bold', 'visual-composer-starter' ),
				'700' => esc_html__( 'Bold', 'visual-composer-starter' ),
			),
		) );
		$wp_customize->add_control( 'vct_fonts_and_style_h3_font_style', array(
			'label'   => esc_html__( 'Font Style', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h3',
			'settings'   => 'vct_fonts_and_style_h3_font_style',
			'type'    => 'select',
			'choices'  => array(
				'normal' => esc_html__( 'Normal (default)', 'visual-composer-starter' ),
				'italic' => esc_html__( 'Italic', 'visual-composer-starter' ),
				'oblique' => esc_html__( 'Oblique', 'visual-composer-starter' ),
				'inherit' => esc_html__( 'Inherit', 'visual-composer-starter' ),
			),
		) );

		$wp_customize->add_control( 'vct_fonts_and_style_h3_font_size', array(
			'label'   => esc_html__( 'Size', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h3',
			'settings'   => 'vct_fonts_and_style_h3_font_size',
			'type'    => 'text',
		) );

		$wp_customize->add_control( 'vct_fonts_and_style_h3_line_height', array(
			'label'   => esc_html__( 'Line Height', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h3',
			'settings'   => 'vct_fonts_and_style_h3_line_height',
			'type'    => 'text',
		) );

		$wp_customize->add_control( 'vct_fonts_and_style_h3_letter_spacing', array(
			'label'   => esc_html__( 'Letter Spacing', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h3',
			'settings'   => 'vct_fonts_and_style_h3_letter_spacing',
			'type'    => 'text',
		) );
		$wp_customize->add_control( 'vct_fonts_and_style_h3_margin_top', array(
			'label'   => esc_html__( 'Margin Top', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h3',
			'settings'   => 'vct_fonts_and_style_h3_margin_top',
			'type'    => 'text',
		) );
		$wp_customize->add_control( 'vct_fonts_and_style_h3_margin_bottom', array(
			'label'   => esc_html__( 'Margin Bottom', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h3',
			'settings'   => 'vct_fonts_and_style_h3_margin_bottom',
			'type'    => 'text',
		) );
		$wp_customize->add_control( 'vct_fonts_and_style_h3_capitalization', array(
			'label'   => esc_html__( 'Capitalization', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h3',
			'settings'   => 'vct_fonts_and_style_h3_capitalization',
			'type'    => 'select',
			'choices'  => array(
				'none'  => esc_html__( 'None (default)', 'visual-composer-starter' ),
				'uppercase' => esc_html__( 'Uppercase', 'visual-composer-starter' ),
				'lowercase' => esc_html__( 'Lowercase', 'visual-composer-starter' ),
				'capitalize' => esc_html__( 'Capitalize', 'visual-composer-starter' ),
			),
		) );
	}

	/**
	 * H4 fonts and style section
	 *
	 * @param object $wp_customize Customizer object.
	 */
	private function fonts_and_style_section_h4( $wp_customize ) {
		$wp_customize->add_setting( 'vct_fonts_and_style_h4_text_color', array(
			'default'        => '#333333',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_h4_active_color', array(
			'default'        => '#557cbf',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_h4_font_family', array(
			'default'        => 'Playfair Display',
			'sanitize_callback' => array( $this, 'sanitize_select_google_fonts' ),
		) );

		$wp_customize->add_setting( 'vct_fonts_and_style_h4_subsets', array(
			'default'        => 'all',
			'sanitize_callback' => array( $this, 'sanitize_select' ),
		) );

		$wp_customize->add_setting( 'vct_fonts_and_style_h4_font_size', array(
			'default'        => '22px',
			'sanitize_callback' => 'wp_strip_all_tags',
		) );

		$wp_customize->add_setting( 'vct_fonts_and_style_h4_letter_spacing', array(
			'default'        => '0.01rem',
			'sanitize_callback' => 'wp_strip_all_tags',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_h4_line_height', array(
			'default'        => '1.1',
			'sanitize_callback' => 'wp_strip_all_tags',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_h4_weight', array(
			'default'        => '400',
			'sanitize_callback' => array( $this, 'sanitize_select' ),
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_h4_font_style', array(
			'default'        => 'normal',
			'sanitize_callback' => array( $this, 'sanitize_select' ),
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_h4_margin_top', array(
			'default'        => '0',
			'sanitize_callback' => 'wp_strip_all_tags',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_h4_margin_bottom', array(
			'default'        => '0.625rem',
			'sanitize_callback' => 'wp_strip_all_tags',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_h4_capitalization', array(
			'default'        => 'none',
			'sanitize_callback' => array( $this, 'sanitize_select' ),
		) );

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'vct_fonts_and_style_h4_text_color',
				array(
					'label'         => esc_html__( 'Color', 'visual-composer-starter' ),
					'section'       => 'vct_fonts_and_style_h4',
					'settings'      => 'vct_fonts_and_style_h4_text_color',
				)
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'vct_fonts_and_style_h4_active_color',
				array(
					'label'         => esc_html__( 'Active Color', 'visual-composer-starter' ),
					'section'       => 'vct_fonts_and_style_h4',
					'settings'      => 'vct_fonts_and_style_h4_active_color',
				)
			)
		);

		$wp_customize->add_control( 'vct_fonts_and_style_h4_font_family', array(
			'label'   => esc_html__( 'Font-family', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h4',
			'settings'   => 'vct_fonts_and_style_h4_font_family',
			'type'    => 'select',
			'choices'     => VisualComposerStarter_Fonts::vct_theme_font_choices(),
		) );

		$wp_customize->add_control( 'vct_fonts_and_style_h4_subsets', array(
			'label'   => esc_html__( 'Google Fonts Subsets', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h4',
			'settings'   => 'vct_fonts_and_style_h4_subsets',
			'type'    => 'select',
			'choices'     => VisualComposerStarter_Fonts::vct_theme_font_subsets(),
		) );

		$wp_customize->add_control( 'vct_fonts_and_style_h4_weight', array(
			'label'   => esc_html__( 'Font Weight', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h4',
			'settings'   => 'vct_fonts_and_style_h4_weight',
			'type'    => 'select',
			'choices'  => array(
				'300' => esc_html__( 'Light', 'visual-composer-starter' ),
				'400' => esc_html__( 'Normal (default)', 'visual-composer-starter' ),
				'600' => esc_html__( 'Semi-Bold', 'visual-composer-starter' ),
				'700' => esc_html__( 'Bold', 'visual-composer-starter' ),
			),
		) );
		$wp_customize->add_control( 'vct_fonts_and_style_h4_font_style', array(
			'label'   => esc_html__( 'Font Style', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h4',
			'settings'   => 'vct_fonts_and_style_h4_font_style',
			'type'    => 'select',
			'choices'  => array(
				'normal' => esc_html__( 'Normal (default)', 'visual-composer-starter' ),
				'italic' => esc_html__( 'Italic', 'visual-composer-starter' ),
				'oblique' => esc_html__( 'Oblique', 'visual-composer-starter' ),
				'inherit' => esc_html__( 'Inherit', 'visual-composer-starter' ),
			),
		) );

		$wp_customize->add_control( 'vct_fonts_and_style_h4_font_size', array(
			'label'   => esc_html__( 'Size', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h4',
			'settings'   => 'vct_fonts_and_style_h4_font_size',
			'type'    => 'text',
		) );

		$wp_customize->add_control( 'vct_fonts_and_style_h4_line_height', array(
			'label'   => esc_html__( 'Line Height', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h4',
			'settings'   => 'vct_fonts_and_style_h4_line_height',
			'type'    => 'text',
		) );

		$wp_customize->add_control( 'vct_fonts_and_style_h4_letter_spacing', array(
			'label'   => esc_html__( 'Letter Spacing', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h4',
			'settings'   => 'vct_fonts_and_style_h4_letter_spacing',
			'type'    => 'text',
		) );
		$wp_customize->add_control( 'vct_fonts_and_style_h4_margin_top', array(
			'label'   => esc_html__( 'Margin Top', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h4',
			'settings'   => 'vct_fonts_and_style_h4_margin_top',
			'type'    => 'text',
		) );
		$wp_customize->add_control( 'vct_fonts_and_style_h4_margin_bottom', array(
			'label'   => esc_html__( 'Margin Bottom', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h4',
			'settings'   => 'vct_fonts_and_style_h4_margin_bottom',
			'type'    => 'text',
		) );
		$wp_customize->add_control( 'vct_fonts_and_style_h4_capitalization', array(
			'label'   => esc_html__( 'Capitalization', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h4',
			'settings'   => 'vct_fonts_and_style_h4_capitalization',
			'type'    => 'select',
			'choices'  => array(
				'none'  => esc_html__( 'None (default)', 'visual-composer-starter' ),
				'uppercase' => esc_html__( 'Uppercase', 'visual-composer-starter' ),
				'lowercase' => esc_html__( 'Lowercase', 'visual-composer-starter' ),
				'capitalize' => esc_html__( 'Capitalize', 'visual-composer-starter' ),
			),
		) );
	}

	/**
	 * H5 fonts and style section
	 *
	 * @param object $wp_customize Customizer object.
	 */
	private function fonts_and_style_section_h5( $wp_customize ) {
		$wp_customize->add_setting( 'vct_fonts_and_style_h5_text_color', array(
			'default'        => '#333333',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_h5_active_color', array(
			'default'        => '#557cbf',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_h5_font_family', array(
			'default'        => 'Playfair Display',
			'sanitize_callback' => array( $this, 'sanitize_select_google_fonts' ),
		) );

		$wp_customize->add_setting( 'vct_fonts_and_style_h5_subsets', array(
			'default'        => 'all',
			'sanitize_callback' => array( $this, 'sanitize_select' ),
		) );

		$wp_customize->add_setting( 'vct_fonts_and_style_h5_font_size', array(
			'default'        => '18px',
			'sanitize_callback' => 'wp_strip_all_tags',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_h5_letter_spacing', array(
			'default'        => '0.01rem',
			'sanitize_callback' => 'wp_strip_all_tags',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_h5_line_height', array(
			'default'        => '1.1',
			'sanitize_callback' => 'wp_strip_all_tags',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_h5_weight', array(
			'default'        => '400',
			'sanitize_callback' => array( $this, 'sanitize_select' ),
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_h5_font_style', array(
			'default'        => 'normal',
			'sanitize_callback' => array( $this, 'sanitize_select' ),
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_h5_margin_top', array(
			'default'        => '0',
			'sanitize_callback' => 'wp_strip_all_tags',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_h5_margin_bottom', array(
			'default'        => '0.625rem',
			'sanitize_callback' => 'wp_strip_all_tags',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_h5_capitalization', array(
			'default'        => 'none',
			'sanitize_callback' => array( $this, 'sanitize_select' ),
		) );

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'vct_fonts_and_style_h5_text_color',
				array(
					'label'         => esc_html__( 'Color', 'visual-composer-starter' ),
					'section'       => 'vct_fonts_and_style_h5',
					'settings'      => 'vct_fonts_and_style_h5_text_color',
				)
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'vct_fonts_and_style_h5_active_color',
				array(
					'label'         => esc_html__( 'Active Color', 'visual-composer-starter' ),
					'section'       => 'vct_fonts_and_style_h5',
					'settings'      => 'vct_fonts_and_style_h5_active_color',
				)
			)
		);

		$wp_customize->add_control( 'vct_fonts_and_style_h5_font_family', array(
			'label'   => esc_html__( 'Font-family', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h5',
			'settings'   => 'vct_fonts_and_style_h5_font_family',
			'type'    => 'select',
			'choices'     => VisualComposerStarter_Fonts::vct_theme_font_choices(),
		) );

		$wp_customize->add_control( 'vct_fonts_and_style_h5_subsets', array(
			'label'   => esc_html__( 'Google Fonts Subsets', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h5',
			'settings'   => 'vct_fonts_and_style_h5_subsets',
			'type'    => 'select',
			'choices'     => VisualComposerStarter_Fonts::vct_theme_font_subsets(),
		) );

		$wp_customize->add_control( 'vct_fonts_and_style_h5_weight', array(
			'label'   => esc_html__( 'Font Weight', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h5',
			'settings'   => 'vct_fonts_and_style_h5_weight',
			'type'    => 'select',
			'choices'  => array(
				'300' => esc_html__( 'Light', 'visual-composer-starter' ),
				'400' => esc_html__( 'Normal (default)', 'visual-composer-starter' ),
				'600' => esc_html__( 'Semi-Bold', 'visual-composer-starter' ),
				'700' => esc_html__( 'Bold', 'visual-composer-starter' ),
			),
		) );
		$wp_customize->add_control( 'vct_fonts_and_style_h5_font_style', array(
			'label'   => esc_html__( 'Font Style', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h5',
			'settings'   => 'vct_fonts_and_style_h5_font_style',
			'type'    => 'select',
			'choices'  => array(
				'normal' => esc_html__( 'Normal (default)', 'visual-composer-starter' ),
				'italic' => esc_html__( 'Italic', 'visual-composer-starter' ),
				'oblique' => esc_html__( 'Oblique', 'visual-composer-starter' ),
				'inherit' => esc_html__( 'Inherit', 'visual-composer-starter' ),
			),
		) );

		$wp_customize->add_control( 'vct_fonts_and_style_h5_font_size', array(
			'label'   => esc_html__( 'Size', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h5',
			'settings'   => 'vct_fonts_and_style_h5_font_size',
			'type'    => 'text',
		) );

		$wp_customize->add_control( 'vct_fonts_and_style_h5_line_height', array(
			'label'   => esc_html__( 'Line Height', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h5',
			'settings'   => 'vct_fonts_and_style_h5_line_height',
			'type'    => 'text',
		) );

		$wp_customize->add_control( 'vct_fonts_and_style_h5_letter_spacing', array(
			'label'   => esc_html__( 'Letter Spacing', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h5',
			'settings'   => 'vct_fonts_and_style_h5_letter_spacing',
			'type'    => 'text',
		) );
		$wp_customize->add_control( 'vct_fonts_and_style_h5_margin_top', array(
			'label'   => esc_html__( 'Margin Top', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h5',
			'settings'   => 'vct_fonts_and_style_h5_margin_top',
			'type'    => 'text',
		) );
		$wp_customize->add_control( 'vct_fonts_and_style_h5_margin_bottom', array(
			'label'   => esc_html__( 'Margin Bottom', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h5',
			'settings'   => 'vct_fonts_and_style_h5_margin_bottom',
			'type'    => 'text',
		) );
		$wp_customize->add_control( 'vct_fonts_and_style_h5_capitalization', array(
			'label'   => esc_html__( 'Capitalization', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h5',
			'settings'   => 'vct_fonts_and_style_h5_capitalization',
			'type'    => 'select',
			'choices'  => array(
				'none'  => esc_html__( 'None (default)', 'visual-composer-starter' ),
				'uppercase' => esc_html__( 'Uppercase', 'visual-composer-starter' ),
				'lowercase' => esc_html__( 'Lowercase', 'visual-composer-starter' ),
				'capitalize' => esc_html__( 'Capitalize', 'visual-composer-starter' ),
			),
		) );
	}

	/**
	 * H6 fonts and style section
	 *
	 * @param object $wp_customize Customizer object.
	 */
	private function fonts_and_style_section_h6( $wp_customize ) {
		$wp_customize->add_setting( 'vct_fonts_and_style_h6_text_color', array(
			'default'        => '#333333',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_h6_active_color', array(
			'default'        => '#557cbf',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_h6_font_family', array(
			'default'        => 'Playfair Display',
			'sanitize_callback' => array( $this, 'sanitize_select_google_fonts' ),
		) );

		$wp_customize->add_setting( 'vct_fonts_and_style_h6_subsets', array(
			'default'        => 'all',
			'sanitize_callback' => array( $this, 'sanitize_select' ),
		) );

		$wp_customize->add_setting( 'vct_fonts_and_style_h6_font_size', array(
			'default'        => '16px',
			'sanitize_callback' => 'wp_strip_all_tags',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_h6_letter_spacing', array(
			'default'        => '0.01rem',
			'sanitize_callback' => 'wp_strip_all_tags',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_h6_line_height', array(
			'default'        => '1.1',
			'sanitize_callback' => 'wp_strip_all_tags',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_h6_weight', array(
			'default'        => '400',
			'sanitize_callback' => array( $this, 'sanitize_select' ),
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_h6_font_style', array(
			'default'        => 'normal',
			'sanitize_callback' => array( $this, 'sanitize_select' ),
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_h6_margin_top', array(
			'default'        => '0',
			'sanitize_callback' => 'wp_strip_all_tags',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_h6_margin_bottom', array(
			'default'        => '0.625rem',
			'sanitize_callback' => 'wp_strip_all_tags',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_h6_capitalization', array(
			'default'        => 'none',
			'sanitize_callback' => array( $this, 'sanitize_select' ),
		) );

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'vct_fonts_and_style_h6_text_color',
				array(
					'label'         => esc_html__( 'Color', 'visual-composer-starter' ),
					'section'       => 'vct_fonts_and_style_h6',
					'settings'      => 'vct_fonts_and_style_h6_text_color',
				)
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'vct_fonts_and_style_h6_active_color',
				array(
					'label'         => esc_html__( 'Active Color', 'visual-composer-starter' ),
					'section'       => 'vct_fonts_and_style_h6',
					'settings'      => 'vct_fonts_and_style_h6_active_color',
				)
			)
		);

		$wp_customize->add_control( 'vct_fonts_and_style_h6_font_family', array(
			'label'   => esc_html__( 'Font-family', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h6',
			'settings'   => 'vct_fonts_and_style_h6_font_family',
			'type'    => 'select',
			'choices'     => VisualComposerStarter_Fonts::vct_theme_font_choices(),
		) );

		$wp_customize->add_control( 'vct_fonts_and_style_h6_subsets', array(
			'label'   => esc_html__( 'Google Fonts Subsets', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h6',
			'settings'   => 'vct_fonts_and_style_h6_subsets',
			'type'    => 'select',
			'choices'     => VisualComposerStarter_Fonts::vct_theme_font_subsets(),
		) );

		$wp_customize->add_control( 'vct_fonts_and_style_h6_weight', array(
			'label'   => esc_html__( 'Font Weight', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h6',
			'settings'   => 'vct_fonts_and_style_h6_weight',
			'type'    => 'select',
			'choices'  => array(
				'300' => esc_html__( 'Light', 'visual-composer-starter' ),
				'400' => esc_html__( 'Normal (default)', 'visual-composer-starter' ),
				'600' => esc_html__( 'Semi-Bold', 'visual-composer-starter' ),
				'700' => esc_html__( 'Bold', 'visual-composer-starter' ),
			),
		) );

		$wp_customize->add_control( 'vct_fonts_and_style_h6_font_style', array(
			'label'   => esc_html__( 'Font Style', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h6',
			'settings'   => 'vct_fonts_and_style_h6_font_style',
			'type'    => 'select',
			'choices'  => array(
				'normal' => esc_html__( 'Normal (default)', 'visual-composer-starter' ),
				'italic' => esc_html__( 'Italic', 'visual-composer-starter' ),
				'oblique' => esc_html__( 'Oblique', 'visual-composer-starter' ),
				'inherit' => esc_html__( 'Inherit', 'visual-composer-starter' ),
			),
		) );

		$wp_customize->add_control( 'vct_fonts_and_style_h6_font_size', array(
			'label'   => esc_html__( 'Size', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h6',
			'settings'   => 'vct_fonts_and_style_h6_font_size',
			'type'    => 'text',
		) );

		$wp_customize->add_control( 'vct_fonts_and_style_h6_line_height', array(
			'label'   => esc_html__( 'Line Height', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h6',
			'settings'   => 'vct_fonts_and_style_h6_line_height',
			'type'    => 'text',
		) );

		$wp_customize->add_control( 'vct_fonts_and_style_h6_letter_spacing', array(
			'label'   => esc_html__( 'Letter Spacing', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h6',
			'settings'   => 'vct_fonts_and_style_h6_letter_spacing',
			'type'    => 'text',
		) );

		$wp_customize->add_control( 'vct_fonts_and_style_h6_margin_top', array(
			'label'   => esc_html__( 'Margin Top', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h6',
			'settings'   => 'vct_fonts_and_style_h6_margin_top',
			'type'    => 'text',
		) );

		$wp_customize->add_control( 'vct_fonts_and_style_h6_margin_bottom', array(
			'label'   => esc_html__( 'Margin Bottom', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h6',
			'settings'   => 'vct_fonts_and_style_h6_margin_bottom',
			'type'    => 'text',
		) );

		$wp_customize->add_control( 'vct_fonts_and_style_h6_capitalization', array(
			'label'   => esc_html__( 'Capitalization', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h6',
			'settings'   => 'vct_fonts_and_style_h6_capitalization',
			'type'    => 'select',
			'choices'  => array(
				'none'  => esc_html__( 'None (default)', 'visual-composer-starter' ),
				'uppercase' => esc_html__( 'Uppercase', 'visual-composer-starter' ),
				'lowercase' => esc_html__( 'Lowercase', 'visual-composer-starter' ),
				'capitalize' => esc_html__( 'Capitalize', 'visual-composer-starter' ),
			),
		) );
	}

	/**
	 * Body fonts and style section
	 *
	 * @param object $wp_customize Customizer object.
	 */
	private function fonts_and_style_section_body( $wp_customize ) {
		$wp_customize->add_setting( 'vct_fonts_and_style_body_primary_color', array(
			'default'        => '#555555',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_body_secondary_text_color', array(
			'default'        => '#777777',
			'sanitize_callback' => 'sanitize_hex_color',
		) );

		$wp_customize->add_setting( 'vct_fonts_and_style_body_active_color', array(
			'default'        => '#557cbf',
			'sanitize_callback' => 'sanitize_hex_color',
		) );

		$wp_customize->add_setting( 'vct_fonts_and_style_body_font_family', array(
			'default'        => 'Roboto',
			'sanitize_callback' => array( $this, 'sanitize_select_google_fonts' ),
		) );

		$wp_customize->add_setting( 'vct_fonts_and_style_body_subsets', array(
			'default'        => 'all',
			'sanitize_callback' => array( $this, 'sanitize_select' ),
		) );

		$wp_customize->add_setting( 'vct_fonts_and_style_body_font_size', array(
			'default'        => '16px',
			'sanitize_callback' => 'wp_strip_all_tags',
		) );

		$wp_customize->add_setting( 'vct_fonts_and_style_body_letter_spacing', array(
			'default'        => '0.01rem',
			'sanitize_callback' => 'wp_strip_all_tags',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_body_line_height', array(
			'default'        => '1.7',
			'sanitize_callback' => 'wp_strip_all_tags',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_body_weight', array(
			'default'        => '400',
			'sanitize_callback' => array( $this, 'sanitize_select' ),
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_body_font_style', array(
			'default'        => 'normal',
			'sanitize_callback' => array( $this, 'sanitize_select' ),
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_body_margin_top', array(
			'default'        => '0',
			'sanitize_callback' => 'wp_strip_all_tags',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_body_margin_bottom', array(
			'default'        => '1.5rem',
			'sanitize_callback' => 'wp_strip_all_tags',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_body_capitalization', array(
			'default'        => 'none',
			'sanitize_callback' => array( $this, 'sanitize_select' ),
		) );

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'vct_fonts_and_style_body_primary_color',
				array(
					'label'         => esc_html__( 'Primary Color', 'visual-composer-starter' ),
					'section'       => 'vct_fonts_and_style_body',
					'settings'      => 'vct_fonts_and_style_body_primary_color',
				)
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'vct_fonts_and_style_body_secondary_text_color',
				array(
					'label'         => esc_html__( 'Secondary Color', 'visual-composer-starter' ),
					'description'   => esc_html__( 'Secondary text color will be applied to block quotes, image captions, etc.', 'visual-composer-starter' ),
					'section'       => 'vct_fonts_and_style_body',
					'settings'      => 'vct_fonts_and_style_body_secondary_text_color',
				)
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'vct_fonts_and_style_body_active_color',
				array(
					'label'         => esc_html__( 'Active Color', 'visual-composer-starter' ),
					'description'   => esc_html__( 'Active color that will be applied to links and bullets.', 'visual-composer-starter' ),
					'section'       => 'vct_fonts_and_style_body',
					'settings'      => 'vct_fonts_and_style_body_active_color',
				)
			)
		);

		$wp_customize->add_control( 'vct_fonts_and_style_body_font_family', array(
			'label'   => esc_html__( 'Font-family', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_body',
			'settings'   => 'vct_fonts_and_style_body_font_family',
			'type'    => 'select',
			'choices'     => VisualComposerStarter_Fonts::vct_theme_font_choices(),
		) );

		$wp_customize->add_control( 'vct_fonts_and_style_body_subsets', array(
			'label'   => esc_html__( 'Google Fonts Subsets', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_body',
			'settings'   => 'vct_fonts_and_style_body_subsets',
			'type'    => 'select',
			'choices'     => VisualComposerStarter_Fonts::vct_theme_font_subsets(),
		) );

		$wp_customize->add_control( 'vct_fonts_and_style_body_weight', array(
			'label'   => esc_html__( 'Font Weight', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_body',
			'settings'   => 'vct_fonts_and_style_body_weight',
			'type'    => 'select',
			'choices'  => array(
				'300' => esc_html__( 'Light', 'visual-composer-starter' ),
				'400' => esc_html__( 'Normal (default)', 'visual-composer-starter' ),
				'600' => esc_html__( 'Semi-Bold', 'visual-composer-starter' ),
				'700' => esc_html__( 'Bold', 'visual-composer-starter' ),
			),
		) );
		$wp_customize->add_control( 'vct_fonts_and_style_body_font_style', array(
			'label'   => esc_html__( 'Font Style', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_body',
			'settings'   => 'vct_fonts_and_style_body_font_style',
			'type'    => 'select',
			'choices'  => array(
				'normal' => esc_html__( 'Normal (default)', 'visual-composer-starter' ),
				'italic' => esc_html__( 'Italic', 'visual-composer-starter' ),
				'oblique' => esc_html__( 'Oblique', 'visual-composer-starter' ),
				'inherit' => esc_html__( 'Inherit', 'visual-composer-starter' ),
			),
		) );

		$wp_customize->add_control( 'vct_fonts_and_style_body_font_size', array(
			'label'   => esc_html__( 'Size', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_body',
			'settings'   => 'vct_fonts_and_style_body_font_size',
			'type'    => 'text',
		) );

		$wp_customize->add_control( 'vct_fonts_and_style_body_line_height', array(
			'label'   => esc_html__( 'Line Height', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_body',
			'settings'   => 'vct_fonts_and_style_body_line_height',
			'type'    => 'text',
		) );

		$wp_customize->add_control( 'vct_fonts_and_style_body_letter_spacing', array(
			'label'   => esc_html__( 'Letter Spacing', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_body',
			'settings'   => 'vct_fonts_and_style_body_letter_spacing',
			'type'    => 'text',
		) );
		$wp_customize->add_control( 'vct_fonts_and_style_body_margin_top', array(
			'label'   => esc_html__( 'Margin Top', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_body',
			'settings'   => 'vct_fonts_and_style_body_margin_top',
			'type'    => 'text',
		) );
		$wp_customize->add_control( 'vct_fonts_and_style_body_margin_bottom', array(
			'label'   => esc_html__( 'Margin Bottom', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_body',
			'settings'   => 'vct_fonts_and_style_body_margin_bottom',
			'type'    => 'text',
		) );
		$wp_customize->add_control( 'vct_fonts_and_style_body_capitalization', array(
			'label'   => esc_html__( 'Capitalization', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_body',
			'settings'   => 'vct_fonts_and_style_body_capitalization',
			'type'    => 'select',
			'choices'  => array(
				'none'  => esc_html__( 'None (default)', 'visual-composer-starter' ),
				'uppercase' => esc_html__( 'Uppercase', 'visual-composer-starter' ),
				'lowercase' => esc_html__( 'Lowercase', 'visual-composer-starter' ),
				'capitalize' => esc_html__( 'Capitalize', 'visual-composer-starter' ),
			),
		) );
	}

	/**
	 * Buttons fonts and style section
	 *
	 * @param object $wp_customize Customizer object.
	 */
	private function fonts_and_style_section_buttons( $wp_customize ) {
		$wp_customize->add_setting( 'vct_fonts_and_style_buttons_background_color', array(
			'default'        => '#557cbf',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_buttons_text_color', array(
			'default'        => '#f4f4f4',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_buttons_background_hover_color', array(
			'default'        => '#3c63a6',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_buttons_text_hover_color', array(
			'default'        => '#f4f4f4',
			'sanitize_callback' => 'sanitize_hex_color',
		) );

		$wp_customize->add_setting( 'vct_fonts_and_style_buttons_font_family', array(
			'default'        => 'Playfair Display',
			'sanitize_callback' => array( $this, 'sanitize_select_google_fonts' ),
		) );

		$wp_customize->add_setting( 'vct_fonts_and_style_buttons_subsets', array(
			'default'        => 'all',
			'sanitize_callback' => array( $this, 'sanitize_select' ),
		) );

		$wp_customize->add_setting( 'vct_fonts_and_style_buttons_font_size', array(
			'default'        => '16px',
			'sanitize_callback' => 'wp_strip_all_tags',
		) );

		$wp_customize->add_setting( 'vct_fonts_and_style_buttons_letter_spacing', array(
			'default'        => '0.01rem',
			'sanitize_callback' => 'wp_strip_all_tags',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_buttons_line_height', array(
			'default'        => '1',
			'sanitize_callback' => 'wp_strip_all_tags',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_buttons_weight', array(
			'default'        => '400',
			'sanitize_callback' => array( $this, 'sanitize_select' ),
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_buttons_font_style', array(
			'default'        => 'normal',
			'sanitize_callback' => array( $this, 'sanitize_select' ),
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_buttons_margin_top', array(
			'default'        => '0',
			'sanitize_callback' => 'wp_strip_all_tags',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_buttons_margin_bottom', array(
			'default'        => '0',
			'sanitize_callback' => 'wp_strip_all_tags',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_buttons_capitalization', array(
			'default'        => 'none',
			'sanitize_callback' => array( $this, 'sanitize_select' ),
		) );

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'vct_fonts_and_style_buttons_background_color',
				array(
					'label'         => esc_html__( 'Background Color', 'visual-composer-starter' ),
					'section'       => 'vct_fonts_and_style_buttons',
					'settings'      => 'vct_fonts_and_style_buttons_background_color',
				)
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'vct_fonts_and_style_buttons_text_color',
				array(
					'label'         => esc_html__( 'Text Color', 'visual-composer-starter' ),
					'section'       => 'vct_fonts_and_style_buttons',
					'settings'      => 'vct_fonts_and_style_buttons_text_color',
				)
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'vct_fonts_and_style_buttons_background_hover_color',
				array(
					'label'         => esc_html__( 'Background Hover Color', 'visual-composer-starter' ),
					'section'       => 'vct_fonts_and_style_buttons',
					'settings'      => 'vct_fonts_and_style_buttons_background_hover_color',
				)
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'vct_fonts_and_style_buttons_text_hover_color',
				array(
					'label'         => esc_html__( 'Text Hover Color', 'visual-composer-starter' ),
					'section'       => 'vct_fonts_and_style_buttons',
					'settings'      => 'vct_fonts_and_style_buttons_text_hover_color',
				)
			)
		);

		$wp_customize->add_control( 'vct_fonts_and_style_buttons_font_family', array(
			'label'   => esc_html__( 'Font-family', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_buttons',
			'settings'   => 'vct_fonts_and_style_buttons_font_family',
			'type'    => 'select',
			'choices'     => VisualComposerStarter_Fonts::vct_theme_font_choices(),
		) );

		$wp_customize->add_control( 'vct_fonts_and_style_buttons_subsets', array(
			'label'   => esc_html__( 'Google Fonts Subsets', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_buttons',
			'settings'   => 'vct_fonts_and_style_buttons_subsets',
			'type'    => 'select',
			'choices'     => VisualComposerStarter_Fonts::vct_theme_font_subsets(),
		) );

		$wp_customize->add_control( 'vct_fonts_and_style_buttons_weight', array(
			'label'   => esc_html__( 'Font Weight', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_buttons',
			'settings'   => 'vct_fonts_and_style_buttons_weight',
			'type'    => 'select',
			'choices'  => array(
				'300' => esc_html__( 'Light', 'visual-composer-starter' ),
				'400' => esc_html__( 'Normal (default)', 'visual-composer-starter' ),
				'600' => esc_html__( 'Semi-Bold', 'visual-composer-starter' ),
				'700' => esc_html__( 'Bold', 'visual-composer-starter' ),
			),
		) );
		$wp_customize->add_control( 'vct_fonts_and_style_buttons_font_style', array(
			'label'   => esc_html__( 'Font Style', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_buttons',
			'settings'   => 'vct_fonts_and_style_buttons_font_style',
			'type'    => 'select',
			'choices'  => array(
				'normal' => esc_html__( 'Normal (default)', 'visual-composer-starter' ),
				'italic' => esc_html__( 'Italic', 'visual-composer-starter' ),
				'oblique' => esc_html__( 'Oblique', 'visual-composer-starter' ),
				'inherit' => esc_html__( 'Inherit', 'visual-composer-starter' ),
			),
		) );

		$wp_customize->add_control( 'vct_fonts_and_style_buttons_font_size', array(
			'label'   => esc_html__( 'Size', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_buttons',
			'settings'   => 'vct_fonts_and_style_buttons_font_size',
			'type'    => 'text',
		) );

		$wp_customize->add_control( 'vct_fonts_and_style_buttons_line_height', array(
			'label'   => esc_html__( 'Line Height', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_buttons',
			'settings'   => 'vct_fonts_and_style_buttons_line_height',
			'type'    => 'text',
		) );

		$wp_customize->add_control( 'vct_fonts_and_style_buttons_letter_spacing', array(
			'label'   => esc_html__( 'Letter Spacing', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_buttons',
			'settings'   => 'vct_fonts_and_style_buttons_letter_spacing',
			'type'    => 'text',
		) );
		$wp_customize->add_control( 'vct_fonts_and_style_buttons_margin_top', array(
			'label'   => esc_html__( 'Margin Top', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_buttons',
			'settings'   => 'vct_fonts_and_style_buttons_margin_top',
			'type'    => 'text',
		) );
		$wp_customize->add_control( 'vct_fonts_and_style_buttons_margin_bottom', array(
			'label'   => esc_html__( 'Margin Bottom', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_buttons',
			'settings'   => 'vct_fonts_and_style_buttons_margin_bottom',
			'type'    => 'text',
		) );
		$wp_customize->add_control( 'vct_fonts_and_style_buttons_capitalization', array(
			'label'   => esc_html__( 'Capitalization', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_buttons',
			'settings'   => 'vct_fonts_and_style_buttons_capitalization',
			'type'    => 'select',
			'choices'  => array(
				'none'  => esc_html__( 'None (default)', 'visual-composer-starter' ),
				'uppercase' => esc_html__( 'Uppercase', 'visual-composer-starter' ),
				'lowercase' => esc_html__( 'Lowercase', 'visual-composer-starter' ),
				'capitalize' => esc_html__( 'Capitalize', 'visual-composer-starter' ),
			),
		) );
	}
}
