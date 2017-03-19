<?php
class VCT_Customizer {
	/**
	 * Visual Composer Starter Customizer constructor.
	 *
	 *
	 * @access public
	 * @since  1.0
	 */
	public function __construct() {
		add_action( 'customize_register', array( $this, 'include_controls' ) );
		add_action( 'customize_register', array( $this, 'custom_css' ) );
		add_action( 'customize_register', array( $this, 'register_customize_sections' ) );
	}

	public function custom_css() {
		wp_register_style( 'vct-custom-css', get_template_directory_uri() . '/css/customizer-custom.css' );
		wp_enqueue_style( 'vct-custom-css' );
	}

	/**
	 * Include Custom Controls
	 *
	 * Includes all our custom control classes.
	 *
	 * @param WP_Customize_Manager $wp_customize
	 *
	 * @access public
	 * @since  1.0
	 * @return void
	 */
	public function include_controls( $wp_customize ) {
		require_once get_template_directory() . '/inc/customizer/controls/class-vct-toggle-switch-control.php';
		$wp_customize->register_control_type( 'VCT_Toggle_Switch_Control' );
	}

	/**
	 * Add all panels and sections to the Customizer
	 *
	 * @param WP_Customize_Manager $wp_customize
	 *
	 * @access public
	 * @since  1.0
	 * @return void
	 */
	public function register_customize_sections( $wp_customize ) {
		// Create sections
		$wp_customize->add_section( 'vct_overall_site', array(
			'title'             => __( 'Theme Options', 'visual-composer-starter' ),
			'priority'          => 101,
			'capability'        => 'edit_theme_options',
		) );
		$wp_customize->add_section( 'vct_header_and_menu_area', array(
			'title'             => __( 'Header', 'visual-composer-starter' ),
			'priority'          => 102,
			'capability'        => 'edit_theme_options',
		) );
		$wp_customize->add_section( 'vct_footer_area', array(
			'title'             => __( 'Footer', 'visual-composer-starter' ),
			'priority'          => 103,
			'capability'        => 'edit_theme_options',
		) );
		$wp_customize->add_panel( 'vct_fonts_and_style', array(
			'priority'          => 104,
			'capability'        => 'edit_theme_options',
			'theme_supports'    => '',
			'title'             => __( 'Fonts & Style', 'visual-composer-starter' ),
		) );
		$wp_customize->add_section( 'vct_scripts', array(
			'priority'          => 999,
			'capability'        => 'edit_theme_options',
			'theme_supports'    => '',
			'title'             => __( 'Scripts', 'visual-composer-starter' ),
		) );

		// Populate sections
		$this->overall_site_section( $wp_customize );
		$this->content_area_section( $wp_customize );
		$this->header_and_menu_section( $wp_customize );
		$this->footer_section( $wp_customize );
		$this->fonts_and_style_panel( $wp_customize );
		$this->scripts( $wp_customize );
	}

	public function sanitize_custom_height( $height ) {
		$matches = null;
		preg_match( '/^(([0-9]+)px|[0-9]+)$/', $height, $matches );

		if ( (bool) $matches ) {
			return $height;
		}
		return null;
	}

	public function sanitize_checkbox( $input ) {
		return ( true === $input ) ? true : false;
	}

	public function sanitize_textarea( $text ) {
		return esc_textarea( $text );
	}

	public function sanitize_url( $input ) {
		$url = parse_url( $input );
		if ( ! empty( $url['scheme'] ) ) {
			if ( 'http' !== $url['scheme'] && 'https' !== $url['scheme'] ) {
				return '//' . $input;
			} else {
				return $input;
			}
		} else {
			return $input;
		}
	}

	/**
	 * Section: Overall Site
	 *
	 * @param WP_Customize_Manager $wp_customize
	 *
	 * @access private
	 * @since  1.0
	 * @return void
	 */
	private function overall_site_section( $wp_customize ) {

		$wp_customize->add_setting( 'vct_overall_site_bg_color',  array(
			'default'       => '#ffffff',
		) );

		$wp_customize->add_setting( 'vct_overall_site_featured_image',  array(
			'default' => true,
			'sanitize_callback' => array( $this, 'sanitize_checkbox' ),
		) );

		$wp_customize->add_setting( 'vct_overall_site_featured_image_width',  array(
			'default' => 'full_width',
		) );

		$wp_customize->add_setting( 'vct_overall_site_featured_image_height',  array(
			'default' => 'auto',
		) );

		$wp_customize->add_setting( 'vct_overall_site_featured_image_custom_height', array(
			'default'                   => '400px',
			'sanitize_callback'         => array( $this, 'sanitize_custom_height' ),
		) );

		$wp_customize->add_setting( VCT_PAGE_SIDEBAR,  array(
			'default'       => 'none',
		) );

		$wp_customize->add_setting( VCT_POST_SIDEBAR,  array(
			'default'       => 'none',
		) );

		$wp_customize->add_setting( VCT_ARCHIVE_AND_CATEGORY_SIDEBAR,  array(
			'default'       => 'none',
		) );

		$wp_customize->add_setting( 'vct_overall_site_content_background',  array(
			'default'       => '#ffffff',
		) );

		$wp_customize->add_setting( 'vct_overall_site_comments_background',  array(
			'default'       => '#f4f4f4',
		) );

		$wp_customize->add_control(
			new VCT_Toggle_Switch_Control(
				$wp_customize,
				'vct_overall_site_featured_image',
				array(
					'type'          => 'toggle-switch',
					'label'         => __( 'Featured Image', 'visual-composer-starter' ),
					'description'   => __( 'Show featured image for posts and pages.', 'visual-composer-starter' ),
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
					'label'         => __( 'Featured Image Width', 'visual-composer-starter' ),
					'section'       => 'vct_overall_site',
					'settings'      => 'vct_overall_site_featured_image_width',
					'choices'       => array(
						'full_width' => __( 'Full width (default)', 'visual-composer-starter' ),
						'boxed' => __( 'Boxed', 'visual-composer-starter' ),
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
					'label'         => __( 'Featured Image Height', 'visual-composer-starter' ),
					'section'       => 'vct_overall_site',
					'settings'      => 'vct_overall_site_featured_image_height',
					'choices'       => array(
						'auto'              => __( 'Auto (default)', 'visual-composer-starter' ),
						'full_height'       => __( 'Full height', 'visual-composer-starter' ),
						'custom'            => __( 'Custom', 'visual-composer-starter' ),
					),
				)
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'vct_overall_site_featured_image_custom_height',
				array(
					'label'                     => __( 'Custom Height', 'visual-composer-starter' ),
					'description'               => __( 'Please specify featured image height in pixels (ex. 400px).', 'visual-composer-starter' ),
					'section'                   => 'vct_overall_site',
					'settings'                  => 'vct_overall_site_featured_image_custom_height',
				)
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				VCT_PAGE_SIDEBAR,
				array(
					'type'          => 'select',
					'label'         => __( 'Page Sidebar Position', 'visual-composer-starter' ),
					'section'       => 'vct_overall_site',
					'settings'      => VCT_PAGE_SIDEBAR,
					'choices'       => array(
						'none'  => __( 'None (default)', 'visual-composer-starter' ),
						'left'  => __( 'Left', 'visual-composer-starter' ),
						'right' => __( 'Right', 'visual-composer-starter' ),
					),
				)
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				VCT_POST_SIDEBAR,
				array(
					'type'          => 'select',
					'label'         => __( 'Post Sidebar Position', 'visual-composer-starter' ),
					'section'       => 'vct_overall_site',
					'settings'      => VCT_POST_SIDEBAR,
					'choices'       => array(
						'none'  => __( 'None (default)', 'visual-composer-starter' ),
						'left'  => __( 'Left', 'visual-composer-starter' ),
						'right' => __( 'Right', 'visual-composer-starter' ),
					),
				)
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				VCT_ARCHIVE_AND_CATEGORY_SIDEBAR,
				array(
					'type'          => 'select',
					'label'         => __( 'Archive/Category Sidebar Position', 'visual-composer-starter' ),
					'section'       => 'vct_overall_site',
					'settings'      => VCT_ARCHIVE_AND_CATEGORY_SIDEBAR,
					'choices'       => array(
						'none'  => __( 'None (default)', 'visual-composer-starter' ),
						'left'  => __( 'Left', 'visual-composer-starter' ),
						'right' => __( 'Right', 'visual-composer-starter' ),
					),
				)
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'vct_overall_site_bg_color',
				array(
					'label'         => __( 'Site Background', 'visual-composer-starter' ),
					'section'       => 'vct_overall_site',
					'settings'      => 'vct_overall_site_bg_color',
				)
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'vct_overall_site_content_background',
				array(
					'label'         => __( 'Content Background', 'visual-composer-starter' ),
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
					'label'         => __( 'Comments Background', 'visual-composer-starter' ),
					'section'       => 'vct_overall_site',
					'settings'      => 'vct_overall_site_comments_background',
				)
			)
		);
	}

	/**
	 * Section: Content Area Section
	 *
	 * @param WP_Customize_Manager $wp_customize
	 *
	 * @access private
	 * @since  1.0
	 * @return void
	 */
	private function content_area_section( $wp_customize ) {
		$wp_customize->add_setting( 'vct_content_area_sidebar',  array(
			'default'       => 'none',
		) );

		$wp_customize->add_setting( 'vct_content_area_size',  array(
			'default'       => 'boxed',
		) );

		$wp_customize->add_setting( 'vct_content_area_background',  array(
			'default'       => '#ffffff',
		) );
		$wp_customize->add_setting( 'vct_content_area_comments_background',  array(
			'default'       => '#f4f4f4',
		) );

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'vct_content_area_sidebar',
				array(
					'type'          => 'select',
					'label'         => __( 'Sidebar Customization', 'visual-composer-starter' ),
					'description'   => __( 'Default content area of theme is defined as Boxed and No Sidebar.', 'visual-composer-starter' ),
					'section'       => 'vct_content_area',
					'settings'      => 'vct_content_area_sidebar',
					'choices'       => array(
						'none'  => __( 'None (default)', 'visual-composer-starter' ),
						'left'  => __( 'Position left', 'visual-composer-starter' ),
						'right' => __( 'Position right', 'visual-composer-starter' ),
					),
				)
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'vct_content_area_size',
				array(
					'type'          => 'select',
					'label'         => __( 'Content Area Size Customization', 'visual-composer-starter' ),
					'description'   => __( 'Default content area size is defined as Boxed and Full width.', 'visual-composer-starter' ),
					'section'       => 'vct_content_area',
					'settings'      => 'vct_content_area_size',
					'choices'       => array(
						'boxed'         => __( 'Boxed (default)', 'visual-composer-starter' ),
						'full_width'    => __( 'Full width', 'visual-composer-starter' ),
					),
				)
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'vct_content_area_background',
				array(
					'label'         => __( 'Content background color', 'visual-composer-starter' ),
					'description'   => __( 'Choose content background color', 'visual-composer-starter' ),
					'section'       => 'vct_content_area',
					'settings'      => 'vct_content_area_background',
				)
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'vct_content_area_comments_background',
				array(
					'label'         => __( 'Comments background color', 'visual-composer-starter' ),
					'description'   => __( 'Choose comments background color', 'visual-composer-starter' ),
					'section'       => 'vct_content_area',
					'settings'      => 'vct_content_area_comments_background',
				)
			)
		);
	}

	/**
	 * Section: Header Section
	 *
	 * @param WP_Customize_Manager $wp_customize
	 *
	 * @access private
	 * @since  1.0
	 * @return void
	 */
	private function header_and_menu_section( $wp_customize ) {
		$wp_customize->add_setting( 'vct_header_background',  array(
			'default'       => '#ffffff',
		) );

		$wp_customize->add_setting( 'vct_header_menu_hover_background',  array(
			'default'       => '#eeeeee',
		) );

		$wp_customize->add_setting( 'vct_header_text_color',  array(
			'default'       => '#555555',
		) );

		$wp_customize->add_setting( 'vct_header_text_active_color',  array(
			'default'       => '#333333',
		) );

		$wp_customize->add_setting( 'vct_header_background_remove',  array(
			'default'       => 'no',
		) );

		$wp_customize->add_setting( 'vct_header_position',  array(
			'default'       => 'top',
		) );

		$wp_customize->add_setting( 'vct_header_sandwich_style',  array(
			'default'       => '#333333',
		) );

		$wp_customize->add_setting( 'vct_header_top_header_width',  array(
			'default'       => 'boxed',
		) );

		$wp_customize->add_setting( 'vct_header_reserve_space_for_header',  array(
			'default'       => true,
		) );

		$wp_customize->add_setting( 'vct_header_sticky_header',  array(
			'default'       => false,
		) );

		$wp_customize->add_setting( 'vct_header_sandwich_icon_color',  array(
			'default'       => '#ffffff',
		) );

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'vct_header_position',
				array(
					'type'          => 'select',
					'label'         => __( 'Header Style', 'visual-composer-starter' ),
					'section'       => 'vct_header_and_menu_area',
					'settings'      => 'vct_header_position',
					'choices'       => array(
						'top'           => __( 'Top (default)', 'visual-composer-starter' ),
						'sandwich'      => __( 'Sandwich', 'visual-composer-starter' ),
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
					'label'         => __( 'Header Width', 'visual-composer-starter' ),
					'section'       => 'vct_header_and_menu_area',
					'settings'      => 'vct_header_top_header_width',
					'choices'       => array(
						'boxed'             => __( 'Boxed (default)', 'visual-composer-starter' ),
						'full_width_boxed'  => __( 'Full width boxed', 'visual-composer-starter' ),
						'full_width'        => __( 'Full width', 'visual-composer-starter' ),
					),
				)
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'vct_header_background',
				array(
					'label'         => __( 'Background Color', 'visual-composer-starter' ),
					'description'   => __( 'Define header and submenu background color.', 'visual-composer-starter' ),
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
					'label'         => __( 'Submenu Background Hover Color', 'visual-composer-starter' ),
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
					'label'         => __( 'Text Color', 'visual-composer-starter' ),
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
					'label'         => __( 'Active Text Color', 'visual-composer-starter' ),
					'section'       => 'vct_header_and_menu_area',
					'settings'      => 'vct_header_text_active_color',
				)
			)
		);

		$wp_customize->add_control(
			new VCT_Toggle_Switch_Control(
				$wp_customize,
				'vct_header_reserve_space_for_header',
				array(
					'type'          => 'toggle-switch',
					'label'         => __( 'Reserve Space For Header', 'visual-composer-starter' ),
					'description'   => __( 'By default header will be placed on the top of featured image.', 'visual-composer-starter' ),
					'section'       => 'vct_header_and_menu_area',
					'settings'      => 'vct_header_reserve_space_for_header',
				)
			)
		);

		$wp_customize->add_control(
			new VCT_Toggle_Switch_Control(
				$wp_customize,
				'vct_header_sticky_header',
				array(
					'type'          => 'toggle-switch',
					'label'         => __( 'Sticky Header', 'visual-composer-starter' ),
					'description'   => __( 'If set to \'On\' header will stay fixed on the top when scrolling.', 'visual-composer-starter' ),
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
					'label'         => __( 'Sandwich Style', 'visual-composer-starter' ),
					'description'   => __( 'Define sandwich background and control style.', 'visual-composer-starter' ),
					'section'       => 'vct_header_and_menu_area',
					'settings'      => 'vct_header_sandwich_style',
					'choices'       => array(
						'#333333'      => __( 'Dark (default)', 'visual-composer-starter' ),
						'#FFFFFF'      => __( 'Light', 'visual-composer-starter' ),
					),
				)
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'vct_header_sandwich_icon_color',
				array(
					'label'         => __( 'Sandwich Icon Color', 'visual-composer-starter' ),
					'section'       => 'vct_header_and_menu_area',
					'settings'      => 'vct_header_sandwich_icon_color',
				)
			)
		);

	}

	/**
	 * Section: Footer Section
	 *
	 * @param WP_Customize_Manager $wp_customize
	 *
	 * @access private
	 * @since  1.0
	 * @return void
	 */
	private function footer_section( $wp_customize ) {
		$wp_customize->add_setting( 'vct_footer_area_background',  array(
			'default'       => '#333333',
		) );

		$wp_customize->add_setting( 'vct_footer_area_text_color',  array(
			'default'       => '#777777',
		) );

		$wp_customize->add_setting( 'vct_footer_area_text_active_color',  array(
			'default'       => '#ffffff',
		) );

		$wp_customize->add_setting( 'vct_footer_area_widget_area',  array(
			'default'       => false,
		) );

		$wp_customize->add_setting( 'vct_footer_area_widgetized_columns',  array(
			'default'       => 1,
		) );

		$wp_customize->add_setting( 'vct_footer_area_social_icons',  array(
			'default'       => false,
		) );

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'vct_footer_area_background',
				array(
					'label'         => __( 'Footer Background Color', 'visual-composer-starter' ),
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
					'label'         => __( 'Text Color', 'visual-composer-starter' ),
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
					'label'         => __( 'Active Color', 'visual-composer-starter' ),
					'section'       => 'vct_footer_area',
					'settings'      => 'vct_footer_area_text_active_color',
				)
			)
		);

		$wp_customize->add_control(
			new VCT_Toggle_Switch_Control(
				$wp_customize,
				'vct_footer_area_widget_area',
				array(
					'type'          => 'toggle-switch',
					'label'         => __( 'Widget Area', 'visual-composer-starter' ),
					'description'   => __( 'Theme footer allows inserting widget area at the top of the footer.', 'visual-composer-starter' ),
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
					'label'         => __( 'Number of Columns', 'visual-composer-starter' ),
					'description'   => __( 'Widget area can be divided into up to four columns.', 'visual-composer-starter' ),
					'section'       => 'vct_footer_area',
					'settings'      => 'vct_footer_area_widgetized_columns',
					'type'    => 'select',
					'choices'  => array(
						1 => __( 'One', 'visual-composer-starter' ),
						2 => __( 'Two', 'visual-composer-starter' ),
						3 => __( 'Three', 'visual-composer-starter' ),
						4 => __( 'Four', 'visual-composer-starter' ),
					),
				)
			)
		);

		$wp_customize->add_control(
			new VCT_Toggle_Switch_Control(
				$wp_customize,
				'vct_footer_area_social_icons',
				array(
					'type'          => 'toggle-switch',
					'label'         => __( 'Social Icons', 'visual-composer-starter' ),
					'description'   => __( 'Add url to your social network profiles.', 'visual-composer-starter' ),
					'section'       => 'vct_footer_area',
					'settings'      => 'vct_footer_area_social_icons',
				)
			)
		);

		$wp_customize->add_setting( 'vct_footer_area_social_link_facebook',  array(
			'default'       => '',
			'sanitize_callback' => 'sanitize_url',
		) );

		$wp_customize->add_setting( 'vct_footer_area_social_link_twitter',  array(
			'default'       => '',
			'sanitize_callback' => 'sanitize_url',
		) );

		$wp_customize->add_setting( 'vct_footer_area_social_link_linkedin',  array(
			'default'       => '',
			'sanitize_callback' => 'sanitize_url',
		) );

		$wp_customize->add_setting( 'vct_footer_area_social_link_github',  array(
			'default'       => '',
			'sanitize_callback' => 'sanitize_url',
		) );

		$wp_customize->add_setting( 'vct_footer_area_social_link_instagram',  array(
			'default'       => '',
			'sanitize_callback' => 'sanitize_url',
		) );

		$wp_customize->add_setting( 'vct_footer_area_social_link_pinterest',  array(
			'default'       => '',
			'sanitize_callback' => 'sanitize_url',
		) );

		$wp_customize->add_setting( 'vct_footer_area_social_link_flickr',  array(
			'default'       => '',
			'sanitize_callback' => 'sanitize_url',
		) );

		$wp_customize->add_setting( 'vct_footer_area_social_link_youtube',  array(
			'default'       => '',
			'sanitize_callback' => 'sanitize_url',
		) );

		$wp_customize->add_setting( 'vct_footer_area_social_link_vimeo',  array(
			'default'       => '',
			'sanitize_callback' => 'sanitize_url',
		) );

		$wp_customize->add_setting( 'vct_footer_area_social_link_email',  array(
			'default'       => '',
		) );

		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'vct_footer_area_social_link_facebook',
				array(
					'type'          => 'text',
					'label'         => __( 'Facebook', 'visual-composer-starter' ),
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
					'label'         => __( 'Twitter', 'visual-composer-starter' ),
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
					'label'         => __( 'LinkedIn', 'visual-composer-starter' ),
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
					'label'         => __( 'Instagram', 'visual-composer-starter' ),
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
					'label'         => __( 'Pinterest', 'visual-composer-starter' ),
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
					'label'         => __( 'YouTube', 'visual-composer-starter' ),
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
					'label'         => __( 'Vimeo', 'visual-composer-starter' ),
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
					'label'         => __( 'Flickr', 'visual-composer-starter' ),
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
					'label'         => __( 'Github', 'visual-composer-starter' ),
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
					'label'         => __( 'Email', 'visual-composer-starter' ),
					'section'       => 'vct_footer_area',
					'settings'      => 'vct_footer_area_social_link_email',
				)
			)
		);
	}

	/**
	 * Section: Body Fonts & Styles Section
	 *
	 * @param WP_Customize_Manager $wp_customize
	 *
	 * @access private
	 * @since  1.0
	 * @return void
	 */
	private function fonts_and_style_panel( $wp_customize ) {
		$wp_customize->add_section( 'vct_fonts_and_style_h1', array(
			'title'         => __( 'H1', 'visual-composer-starter' ),
			'priority'      => 100,
			'capability'    => 'edit_theme_options',
			'panel'         => 'vct_fonts_and_style',
		) );
		$wp_customize->add_section( 'vct_fonts_and_style_h2', array(
			'title'         => __( 'H2', 'visual-composer-starter' ),
			'priority'      => 101,
			'capability'    => 'edit_theme_options',
			'panel'         => 'vct_fonts_and_style',
		) );
		$wp_customize->add_section( 'vct_fonts_and_style_h3', array(
			'title'         => __( 'H3', 'visual-composer-starter' ),
			'priority'      => 102,
			'capability'    => 'edit_theme_options',
			'panel'         => 'vct_fonts_and_style',
		) );
		$wp_customize->add_section( 'vct_fonts_and_style_h4', array(
			'title'         => __( 'H4', 'visual-composer-starter' ),
			'priority'      => 103,
			'capability'    => 'edit_theme_options',
			'panel'         => 'vct_fonts_and_style',
		) );
		$wp_customize->add_section( 'vct_fonts_and_style_h5', array(
			'title'         => __( 'H5', 'visual-composer-starter' ),
			'priority'      => 104,
			'capability'    => 'edit_theme_options',
			'panel'         => 'vct_fonts_and_style',
		) );
		$wp_customize->add_section( 'vct_fonts_and_style_h6', array(
			'title'         => __( 'H6', 'visual-composer-starter' ),
			'priority'      => 105,
			'capability'    => 'edit_theme_options',
			'panel'         => 'vct_fonts_and_style',
		) );
		$wp_customize->add_section( 'vct_fonts_and_style_body', array(
			'title'         => __( 'Body', 'visual-composer-starter' ),
			'priority'      => 106,
			'capability'    => 'edit_theme_options',
			'panel'         => 'vct_fonts_and_style',
		) );
		$wp_customize->add_section( 'vct_fonts_and_style_buttons', array(
			'title'         => __( 'Buttons', 'visual-composer-starter' ),
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
	 * Section: Scripts Section
	 *
	 * @param WP_Customize_Manager $wp_customize
	 *
	 * @access private
	 * @since  1.0
	 * @return void
	 */
	private function scripts( $wp_customize ) {
		$wp_customize->add_setting( 'vct_scripts_header', array(
			'default'        => '',
		) );
		$wp_customize->add_setting( 'vct_scripts_footer', array(
			'default'        => '',
		) );
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'vct_scripts_header',
				array(
					'label'             => __( 'Header Scripts', 'visual-composer-starter' ),
					'description'       => __( 'Add scripts to your theme header (ex. Google Analytics tracking code).', 'visual-composer-starter' ),
					'section'           => 'vct_scripts',
					'settings'          => 'vct_scripts_header',
					'type'              => 'textarea',
					'sanitize_callback' => array( $this, 'sanitize_textarea' ),
				)
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'vct_scripts_footer',
				array(
					'label'             => __( 'Footer Scripts', 'visual-composer-starter' ),
					'description'       => __( 'Add scripts to your theme footer.', 'visual-composer-starter' ),
					'section'           => 'vct_scripts',
					'settings'          => 'vct_scripts_footer',
					'type'              => 'textarea',
					'sanitize_callback' => array( $this, 'sanitize_textarea' ),
				)
			)
		);
	}

	private function fonts_and_style_section_h1( $wp_customize ) {
		$wp_customize->add_setting( 'vct_fonts_and_style_h1', array(
			'default'        => '',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_h1_text_color', array(
			'default'        => '#333333',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_h1_active_color', array(
			'default'        => '#557cbf',
		) );

		$wp_customize->add_setting( 'vct_fonts_and_style_h1_font_family', array(
			'default'        => 'Playfair Display',
		) );

		$wp_customize->add_setting( 'vct_fonts_and_style_h1_subsets', array(
			'default'        => 'all',
		) );

		$wp_customize->add_setting( 'vct_fonts_and_style_h1_font_size', array(
			'default'        => '42px',
		) );

		$wp_customize->add_setting( 'vct_fonts_and_style_h1_letter_spacing', array(
			'default'        => '0.01rem',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_h1_line_height', array(
			'default'        => '1.1',
		) );

		$wp_customize->add_setting( 'vct_fonts_and_style_h1_weight', array(
			'default'        => '400',
		) );

		$wp_customize->add_setting( 'vct_fonts_and_style_h1_font_style', array(
			'default'        => 'normal',
		) );

		$wp_customize->add_setting( 'vct_fonts_and_style_h1_margin_top', array(
			'default'        => '0',
		) );

		$wp_customize->add_setting( 'vct_fonts_and_style_h1_margin_bottom', array(
			'default'        => '2.125rem',
		) );

		$wp_customize->add_setting( 'vct_fonts_and_style_h1_capitalization', array(
			'default'        => 'none',
		) );

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'vct_fonts_and_style_h1_text_color',
				array(
					'label'         => __( 'Сolor', 'visual-composer-starter' ),
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
					'label'         => __( 'Active Сolor', 'visual-composer-starter' ),
					'section'       => 'vct_fonts_and_style_h1',
					'settings'      => 'vct_fonts_and_style_h1_active_color',
				)
			)
		);
		$wp_customize->add_control( 'vct_fonts_and_style_h1_font_family', array(
			'label'   => __( 'Font-family', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h1',
			'settings'   => 'vct_fonts_and_style_h1_font_family',
			'type'    => 'select',
			'choices'     => VCT_Fonts::vct_theme_font_choices(),
		) );
		$wp_customize->add_control( 'vct_fonts_and_style_h1_subsets', array(
			'label'   => __( 'Google Fonts Subsets', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h1',
			'settings'   => 'vct_fonts_and_style_h1_subsets',
			'type'    => 'select',
			'choices'     => VCT_Fonts::vct_theme_font_subsets(),
		) );
		$wp_customize->add_control( 'vct_fonts_and_style_h1_weight', array(
			'label'   => __( 'Font Weight', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h1',
			'settings'   => 'vct_fonts_and_style_h1_weight',
			'type'    => 'select',
			'choices'  => array(
				'300' => __( 'Light', 'visual-composer-starter' ),
				'400' => __( 'Normal (default)', 'visual-composer-starter' ),
				'600' => __( 'Semi-Bold', 'visual-composer-starter' ),
				'700' => __( 'Bold', 'visual-composer-starter' ),
			),
		) );
		$wp_customize->add_control( 'vct_fonts_and_style_h1_font_style', array(
			'label'   => __( 'Font Style', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h1',
			'settings'   => 'vct_fonts_and_style_h1_font_style',
			'type'    => 'select',
			'choices'  => array(
				'normal' => __( 'Normal (default)', 'visual-composer-starter' ),
				'italic' => __( 'Italic', 'visual-composer-starter' ),
				'oblique' => __( 'Oblique', 'visual-composer-starter' ),
				'inherit' => __( 'Inherit', 'visual-composer-starter' ),
			),
		) );
		$wp_customize->add_control( 'vct_fonts_and_style_h1_font_size', array(
			'label'   => __( 'Size', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h1',
			'settings'   => 'vct_fonts_and_style_h1_font_size',
			'type'    => 'text',
		) );
		$wp_customize->add_control( 'vct_fonts_and_style_h1_line_height', array(
			'label'   => __( 'Line Height', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h1',
			'settings'   => 'vct_fonts_and_style_h1_line_height',
			'type'    => 'text',
		) );
		$wp_customize->add_control( 'vct_fonts_and_style_h1_letter_spacing', array(
			'label'   => __( 'Letter Spacing', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h1',
			'settings'   => 'vct_fonts_and_style_h1_letter_spacing',
			'type'    => 'text',
		) );
		$wp_customize->add_control( 'vct_fonts_and_style_h1_margin_top', array(
			'label'   => __( 'Margin Top', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h1',
			'settings'   => 'vct_fonts_and_style_h1_margin_top',
			'type'    => 'text',
		) );
		$wp_customize->add_control( 'vct_fonts_and_style_h1_margin_bottom', array(
			'label'   => __( 'Margin Bottom', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h1',
			'settings'   => 'vct_fonts_and_style_h1_margin_bottom',
			'type'    => 'text',
		) );
		$wp_customize->add_control( 'vct_fonts_and_style_h1_capitalization', array(
			'label'   => __( 'Capitalization', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h1',
			'settings'   => 'vct_fonts_and_style_h1_capitalization',
			'type'    => 'select',
			'choices'  => array(
				'none'  => __( 'None (default)', 'visual-composer-starter' ),
				'uppercase' => __( 'Uppercase', 'visual-composer-starter' ),
				'lowercase' => __( 'Lowercase', 'visual-composer-starter' ),
				'capitalize' => __( 'Capitalize', 'visual-composer-starter' ),
			),
		) );
	}

	private function fonts_and_style_section_h2( $wp_customize ) {
		$wp_customize->add_setting( 'vct_fonts_and_style_h2', array(
			'default'        => '',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_h2_text_color', array(
			'default'        => '#333333',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_h2_active_color', array(
			'default'        => '#557cbf',
		) );

		$wp_customize->add_setting( 'vct_fonts_and_style_h2_font_family', array(
			'default'        => 'Playfair Display',
		) );

		$wp_customize->add_setting( 'vct_fonts_and_style_h2_subsets', array(
			'default'        => 'all',
		) );

		$wp_customize->add_setting( 'vct_fonts_and_style_h2_font_size', array(
			'default'        => '36px',
		) );

		$wp_customize->add_setting( 'vct_fonts_and_style_h2_letter_spacing', array(
			'default'        => '0.01rem',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_h2_line_height', array(
			'default'        => '1.1',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_h2_weight', array(
			'default'        => '400',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_h2_font_style', array(
			'default'        => 'normal',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_h2_margin_top', array(
			'default'        => '0',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_h2_margin_bottom', array(
			'default'        => '0.625rem',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_h2_capitalization', array(
			'default'        => 'none',
		) );

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'vct_fonts_and_style_h2_text_color',
				array(
					'label'         => __( 'Сolor', 'visual-composer-starter' ),
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
					'label'         => __( 'Active Сolor', 'visual-composer-starter' ),
					'section'       => 'vct_fonts_and_style_h2',
					'settings'      => 'vct_fonts_and_style_h2_active_color',
				)
			)
		);

		$wp_customize->add_control( 'vct_fonts_and_style_h2_font_family', array(
			'label'   => __( 'Font-family', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h2',
			'settings'   => 'vct_fonts_and_style_h2_font_family',
			'type'    => 'select',
			'choices'     => VCT_Fonts::vct_theme_font_choices(),
		) );

		$wp_customize->add_control( 'vct_fonts_and_style_h2_subsets', array(
			'label'   => __( 'Google Fonts Subsets', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h2',
			'settings'   => 'vct_fonts_and_style_h2_subsets',
			'type'    => 'select',
			'choices'     => VCT_Fonts::vct_theme_font_subsets(),
		) );

		$wp_customize->add_control( 'vct_fonts_and_style_h2_weight', array(
			'label'   => __( 'Font Weight', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h2',
			'settings'   => 'vct_fonts_and_style_h2_weight',
			'type'    => 'select',
			'choices'  => array(
				'300' => __( 'Light', 'visual-composer-starter' ),
				'400' => __( 'Normal (default)', 'visual-composer-starter' ),
				'600' => __( 'Semi-Bold', 'visual-composer-starter' ),
				'700' => __( 'Bold', 'visual-composer-starter' ),
			),
		) );

		$wp_customize->add_control( 'vct_fonts_and_style_h2_font_style', array(
			'label'   => __( 'Font Style', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h2',
			'settings'   => 'vct_fonts_and_style_h2_font_style',
			'type'    => 'select',
			'choices'  => array(
				'normal' => __( 'Normal (default)', 'visual-composer-starter' ),
				'italic' => __( 'Italic', 'visual-composer-starter' ),
				'oblique' => __( 'Oblique', 'visual-composer-starter' ),
				'inherit' => __( 'Inherit', 'visual-composer-starter' ),
			),
		) );

		$wp_customize->add_control( 'vct_fonts_and_style_h2_font_size', array(
			'label'   => __( 'Size', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h2',
			'settings'   => 'vct_fonts_and_style_h2_font_size',
			'type'    => 'text',
		) );

		$wp_customize->add_control( 'vct_fonts_and_style_h2_line_height', array(
			'label'   => __( 'Line Height', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h2',
			'settings'   => 'vct_fonts_and_style_h2_line_height',
			'type'    => 'text',
		) );

		$wp_customize->add_control( 'vct_fonts_and_style_h2_letter_spacing', array(
			'label'   => __( 'Letter Spacing', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h2',
			'settings'   => 'vct_fonts_and_style_h2_letter_spacing',
			'type'    => 'text',
		) );
		$wp_customize->add_control( 'vct_fonts_and_style_h2_margin_top', array(
			'label'   => __( 'Margin Top', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h2',
			'settings'   => 'vct_fonts_and_style_h2_margin_top',
			'type'    => 'text',
		) );
		$wp_customize->add_control( 'vct_fonts_and_style_h2_margin_bottom', array(
			'label'   => __( 'Margin Bottom', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h2',
			'settings'   => 'vct_fonts_and_style_h2_margin_bottom',
			'type'    => 'text',
		) );
		$wp_customize->add_control( 'vct_fonts_and_style_h2_capitalization', array(
			'label'   => __( 'Capitalization', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h2',
			'settings'   => 'vct_fonts_and_style_h2_capitalization',
			'type'    => 'select',
			'choices'  => array(
				'none'  => __( 'None (default)', 'visual-composer-starter' ),
				'uppercase' => __( 'Uppercase', 'visual-composer-starter' ),
				'lowercase' => __( 'Lowercase', 'visual-composer-starter' ),
				'capitalize' => __( 'Capitalize', 'visual-composer-starter' ),
			),
		) );
	}

	private function fonts_and_style_section_h3( $wp_customize ) {
		$wp_customize->add_setting( 'vct_fonts_and_style_h3', array(
			'default'        => '',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_h3_text_color', array(
			'default'        => '#333333',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_h3_active_color', array(
			'default'        => '#557cbf',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_h3_font_family', array(
			'default'        => 'Playfair Display',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_h3_subsets', array(
			'default'        => 'all',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_h3_font_size', array(
			'default'        => '30px',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_h3_letter_spacing', array(
			'default'        => '0.01rem',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_h3_line_height', array(
			'default'        => '1.1',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_h3_weight', array(
			'default'        => '400',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_h3_font_style', array(
			'default'        => 'normal',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_h3_margin_top', array(
			'default'        => '0',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_h3_margin_bottom', array(
			'default'        => '0.625rem',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_h3_capitalization', array(
			'default'        => 'none',
		) );

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'vct_fonts_and_style_h3_text_color',
				array(
					'label'         => __( 'Сolor', 'visual-composer-starter' ),
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
					'label'         => __( 'Active Сolor', 'visual-composer-starter' ),
					'section'       => 'vct_fonts_and_style_h3',
					'settings'      => 'vct_fonts_and_style_h3_active_color',
				)
			)
		);
		$wp_customize->add_control( 'vct_fonts_and_style_h3_font_family', array(
			'label'   => __( 'Font-family', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h3',
			'settings'   => 'vct_fonts_and_style_h3_font_family',
			'type'    => 'select',
			'choices'     => VCT_Fonts::vct_theme_font_choices(),
		) );
		$wp_customize->add_control( 'vct_fonts_and_style_h3_subsets', array(
			'label'   => __( 'Google Fonts Subsets', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h3',
			'settings'   => 'vct_fonts_and_style_h3_subsets',
			'type'    => 'select',
			'choices'     => VCT_Fonts::vct_theme_font_subsets(),
		) );
		$wp_customize->add_control( 'vct_fonts_and_style_h3_weight', array(
			'label'   => __( 'Font Weight', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h3',
			'settings'   => 'vct_fonts_and_style_h3_weight',
			'type'    => 'select',
			'choices'  => array(
				'300' => __( 'Light', 'visual-composer-starter' ),
				'400' => __( 'Normal (default)', 'visual-composer-starter' ),
				'600' => __( 'Semi-Bold', 'visual-composer-starter' ),
				'700' => __( 'Bold', 'visual-composer-starter' ),
			),
		) );
		$wp_customize->add_control( 'vct_fonts_and_style_h3_font_style', array(
			'label'   => __( 'Font Style', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h3',
			'settings'   => 'vct_fonts_and_style_h3_font_style',
			'type'    => 'select',
			'choices'  => array(
				'normal' => __( 'Normal (default)', 'visual-composer-starter' ),
				'italic' => __( 'Italic', 'visual-composer-starter' ),
				'oblique' => __( 'Oblique', 'visual-composer-starter' ),
				'inherit' => __( 'Inherit', 'visual-composer-starter' ),
			),
		) );

		$wp_customize->add_control( 'vct_fonts_and_style_h3_font_size', array(
			'label'   => __( 'Size', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h3',
			'settings'   => 'vct_fonts_and_style_h3_font_size',
			'type'    => 'text',
		) );

		$wp_customize->add_control( 'vct_fonts_and_style_h3_line_height', array(
			'label'   => __( 'Line Height', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h3',
			'settings'   => 'vct_fonts_and_style_h3_line_height',
			'type'    => 'text',
		) );

		$wp_customize->add_control( 'vct_fonts_and_style_h3_letter_spacing', array(
			'label'   => __( 'Letter Spacing', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h3',
			'settings'   => 'vct_fonts_and_style_h3_letter_spacing',
			'type'    => 'text',
		) );
		$wp_customize->add_control( 'vct_fonts_and_style_h3_margin_top', array(
			'label'   => __( 'Margin Top', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h3',
			'settings'   => 'vct_fonts_and_style_h3_margin_top',
			'type'    => 'text',
		) );
		$wp_customize->add_control( 'vct_fonts_and_style_h3_margin_bottom', array(
			'label'   => __( 'Margin Bottom', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h3',
			'settings'   => 'vct_fonts_and_style_h3_margin_bottom',
			'type'    => 'text',
		) );
		$wp_customize->add_control( 'vct_fonts_and_style_h3_capitalization', array(
			'label'   => __( 'Capitalization', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h3',
			'settings'   => 'vct_fonts_and_style_h3_capitalization',
			'type'    => 'select',
			'choices'  => array(
				'none'  => __( 'None (default)', 'visual-composer-starter' ),
				'uppercase' => __( 'Uppercase', 'visual-composer-starter' ),
				'lowercase' => __( 'Lowercase', 'visual-composer-starter' ),
				'capitalize' => __( 'Capitalize', 'visual-composer-starter' ),
			),
		) );
	}

	private function fonts_and_style_section_h4( $wp_customize ) {
		$wp_customize->add_setting( 'vct_fonts_and_style_h4', array(
			'default'        => '',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_h4_text_color', array(
			'default'        => '#333333',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_h4_active_color', array(
			'default'        => '#557cbf',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_h4_font_family', array(
			'default'        => 'Playfair Display',
		) );

		$wp_customize->add_setting( 'vct_fonts_and_style_h4_subsets', array(
			'default'        => 'all',
		) );

		$wp_customize->add_setting( 'vct_fonts_and_style_h4_font_size', array(
			'default'        => '22px',
		) );

		$wp_customize->add_setting( 'vct_fonts_and_style_h4_letter_spacing', array(
			'default'        => '0.01rem',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_h4_line_height', array(
			'default'        => '1.1',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_h4_weight', array(
			'default'        => '400',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_h4_font_style', array(
			'default'        => 'normal',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_h4_margin_top', array(
			'default'        => '0',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_h4_margin_bottom', array(
			'default'        => '0.625rem',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_h4_capitalization', array(
			'default'        => 'none',
		) );

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'vct_fonts_and_style_h4_text_color',
				array(
					'label'         => __( 'Сolor', 'visual-composer-starter' ),
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
					'label'         => __( 'Active Сolor', 'visual-composer-starter' ),
					'section'       => 'vct_fonts_and_style_h4',
					'settings'      => 'vct_fonts_and_style_h4_active_color',
				)
			)
		);

		$wp_customize->add_control( 'vct_fonts_and_style_h4_font_family', array(
			'label'   => __( 'Font-family', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h4',
			'settings'   => 'vct_fonts_and_style_h4_font_family',
			'type'    => 'select',
			'choices'     => VCT_Fonts::vct_theme_font_choices(),
		) );

		$wp_customize->add_control( 'vct_fonts_and_style_h4_subsets', array(
			'label'   => __( 'Google Fonts Subsets', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h4',
			'settings'   => 'vct_fonts_and_style_h4_subsets',
			'type'    => 'select',
			'choices'     => VCT_Fonts::vct_theme_font_subsets(),
		) );

		$wp_customize->add_control( 'vct_fonts_and_style_h4_weight', array(
			'label'   => __( 'Font Weight', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h4',
			'settings'   => 'vct_fonts_and_style_h4_weight',
			'type'    => 'select',
			'choices'  => array(
				'300' => __( 'Light', 'visual-composer-starter' ),
				'400' => __( 'Normal (default)', 'visual-composer-starter' ),
				'600' => __( 'Semi-Bold', 'visual-composer-starter' ),
				'700' => __( 'Bold', 'visual-composer-starter' ),
			),
		) );
		$wp_customize->add_control( 'vct_fonts_and_style_h4_font_style', array(
			'label'   => __( 'Font Style', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h4',
			'settings'   => 'vct_fonts_and_style_h4_font_style',
			'type'    => 'select',
			'choices'  => array(
				'normal' => __( 'Normal (default)', 'visual-composer-starter' ),
				'italic' => __( 'Italic', 'visual-composer-starter' ),
				'oblique' => __( 'Oblique', 'visual-composer-starter' ),
				'inherit' => __( 'Inherit', 'visual-composer-starter' ),
			),
		) );

		$wp_customize->add_control( 'vct_fonts_and_style_h4_font_size', array(
			'label'   => __( 'Size', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h4',
			'settings'   => 'vct_fonts_and_style_h4_font_size',
			'type'    => 'text',
		) );

		$wp_customize->add_control( 'vct_fonts_and_style_h4_line_height', array(
			'label'   => __( 'Line Height', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h4',
			'settings'   => 'vct_fonts_and_style_h4_line_height',
			'type'    => 'text',
		) );

		$wp_customize->add_control( 'vct_fonts_and_style_h4_letter_spacing', array(
			'label'   => __( 'Letter Spacing', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h4',
			'settings'   => 'vct_fonts_and_style_h4_letter_spacing',
			'type'    => 'text',
		) );
		$wp_customize->add_control( 'vct_fonts_and_style_h4_margin_top', array(
			'label'   => __( 'Margin Top', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h4',
			'settings'   => 'vct_fonts_and_style_h4_margin_top',
			'type'    => 'text',
		) );
		$wp_customize->add_control( 'vct_fonts_and_style_h4_margin_bottom', array(
			'label'   => __( 'Margin Bottom', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h4',
			'settings'   => 'vct_fonts_and_style_h4_margin_bottom',
			'type'    => 'text',
		) );
		$wp_customize->add_control( 'vct_fonts_and_style_h4_capitalization', array(
			'label'   => __( 'Capitalization', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h4',
			'settings'   => 'vct_fonts_and_style_h4_capitalization',
			'type'    => 'select',
			'choices'  => array(
				'none'  => __( 'None (default)', 'visual-composer-starter' ),
				'uppercase' => __( 'Uppercase', 'visual-composer-starter' ),
				'lowercase' => __( 'Lowercase', 'visual-composer-starter' ),
				'capitalize' => __( 'Capitalize', 'visual-composer-starter' ),
			),
		) );
	}

	private function fonts_and_style_section_h5( $wp_customize ) {
		$wp_customize->add_setting( 'vct_fonts_and_style_h5', array(
			'default'        => '',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_h5_text_color', array(
			'default'        => '#333333',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_h5_active_color', array(
			'default'        => '#557cbf',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_h5_font_family', array(
			'default'        => 'Playfair Display',
		) );

		$wp_customize->add_setting( 'vct_fonts_and_style_h5_subsets', array(
			'default'        => 'all',
		) );

		$wp_customize->add_setting( 'vct_fonts_and_style_h5_font_size', array(
			'default'        => '18px',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_h5_letter_spacing', array(
			'default'        => '0.01rem',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_h5_line_height', array(
			'default'        => '1.1',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_h5_weight', array(
			'default'        => '400',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_h5_font_style', array(
			'default'        => 'normal',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_h5_margin_top', array(
			'default'        => '0',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_h5_margin_bottom', array(
			'default'        => '0.625rem',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_h5_capitalization', array(
			'default'        => 'none',
		) );

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'vct_fonts_and_style_h5_text_color',
				array(
					'label'         => __( 'Сolor', 'visual-composer-starter' ),
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
					'label'         => __( 'Active Сolor', 'visual-composer-starter' ),
					'section'       => 'vct_fonts_and_style_h5',
					'settings'      => 'vct_fonts_and_style_h5_active_color',
				)
			)
		);

		$wp_customize->add_control( 'vct_fonts_and_style_h5_font_family', array(
			'label'   => __( 'Font-family', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h5',
			'settings'   => 'vct_fonts_and_style_h5_font_family',
			'type'    => 'select',
			'choices'     => VCT_Fonts::vct_theme_font_choices(),
		) );

		$wp_customize->add_control( 'vct_fonts_and_style_h5_subsets', array(
			'label'   => __( 'Google Fonts Subsets', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h5',
			'settings'   => 'vct_fonts_and_style_h5_subsets',
			'type'    => 'select',
			'choices'     => VCT_Fonts::vct_theme_font_subsets(),
		) );

		$wp_customize->add_control( 'vct_fonts_and_style_h5_weight', array(
			'label'   => __( 'Font Weight', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h5',
			'settings'   => 'vct_fonts_and_style_h5_weight',
			'type'    => 'select',
			'choices'  => array(
				'300' => __( 'Light', 'visual-composer-starter' ),
				'400' => __( 'Normal (default)', 'visual-composer-starter' ),
				'600' => __( 'Semi-Bold', 'visual-composer-starter' ),
				'700' => __( 'Bold', 'visual-composer-starter' ),
			),
		) );
		$wp_customize->add_control( 'vct_fonts_and_style_h5_font_style', array(
			'label'   => __( 'Font Style', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h5',
			'settings'   => 'vct_fonts_and_style_h5_font_style',
			'type'    => 'select',
			'choices'  => array(
				'normal' => __( 'Normal (default)', 'visual-composer-starter' ),
				'italic' => __( 'Italic', 'visual-composer-starter' ),
				'oblique' => __( 'Oblique', 'visual-composer-starter' ),
				'inherit' => __( 'Inherit', 'visual-composer-starter' ),
			),
		) );

		$wp_customize->add_control( 'vct_fonts_and_style_h5_font_size', array(
			'label'   => __( 'Size', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h5',
			'settings'   => 'vct_fonts_and_style_h5_font_size',
			'type'    => 'text',
		) );

		$wp_customize->add_control( 'vct_fonts_and_style_h5_line_height', array(
			'label'   => __( 'Line Height', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h5',
			'settings'   => 'vct_fonts_and_style_h5_line_height',
			'type'    => 'text',
		) );

		$wp_customize->add_control( 'vct_fonts_and_style_h5_letter_spacing', array(
			'label'   => __( 'Letter Spacing', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h5',
			'settings'   => 'vct_fonts_and_style_h5_letter_spacing',
			'type'    => 'text',
		) );
		$wp_customize->add_control( 'vct_fonts_and_style_h5_margin_top', array(
			'label'   => __( 'Margin Top', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h5',
			'settings'   => 'vct_fonts_and_style_h5_margin_top',
			'type'    => 'text',
		) );
		$wp_customize->add_control( 'vct_fonts_and_style_h5_margin_bottom', array(
			'label'   => __( 'Margin Bottom', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h5',
			'settings'   => 'vct_fonts_and_style_h5_margin_bottom',
			'type'    => 'text',
		) );
		$wp_customize->add_control( 'vct_fonts_and_style_h5_capitalization', array(
			'label'   => __( 'Capitalization', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h5',
			'settings'   => 'vct_fonts_and_style_h5_capitalization',
			'type'    => 'select',
			'choices'  => array(
				'none'  => __( 'None (default)', 'visual-composer-starter' ),
				'uppercase' => __( 'Uppercase', 'visual-composer-starter' ),
				'lowercase' => __( 'Lowercase', 'visual-composer-starter' ),
				'capitalize' => __( 'Capitalize', 'visual-composer-starter' ),
			),
		) );
	}

	private function fonts_and_style_section_h6( $wp_customize ) {
		$wp_customize->add_setting( 'vct_fonts_and_style_h6', array(
			'default'        => '',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_h6_text_color', array(
			'default'        => '#333333',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_h6_active_color', array(
			'default'        => '#557cbf',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_h6_font_family', array(
			'default'        => 'Playfair Display',
		) );

		$wp_customize->add_setting( 'vct_fonts_and_style_h6_subsets', array(
			'default'        => 'all',
		) );

		$wp_customize->add_setting( 'vct_fonts_and_style_h6_font_size', array(
			'default'        => '16px',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_h6_letter_spacing', array(
			'default'        => '0.01rem',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_h6_line_height', array(
			'default'        => '1.1',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_h6_weight', array(
			'default'        => '400',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_h6_font_style', array(
			'default'        => 'normal',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_h6_margin_top', array(
			'default'        => '0',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_h6_margin_bottom', array(
			'default'        => '0.625rem',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_h6_capitalization', array(
			'default'        => 'none',
		) );

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'vct_fonts_and_style_h6_text_color',
				array(
					'label'         => __( 'Сolor', 'visual-composer-starter' ),
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
					'label'         => __( 'Active Сolor', 'visual-composer-starter' ),
					'section'       => 'vct_fonts_and_style_h6',
					'settings'      => 'vct_fonts_and_style_h6_active_color',
				)
			)
		);

		$wp_customize->add_control( 'vct_fonts_and_style_h6_font_family', array(
			'label'   => __( 'Font-family', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h6',
			'settings'   => 'vct_fonts_and_style_h6_font_family',
			'type'    => 'select',
			'choices'     => VCT_Fonts::vct_theme_font_choices(),
		) );

		$wp_customize->add_control( 'vct_fonts_and_style_h6_subsets', array(
			'label'   => __( 'Google Fonts Subsets', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h6',
			'settings'   => 'vct_fonts_and_style_h6_subsets',
			'type'    => 'select',
			'choices'     => VCT_Fonts::vct_theme_font_subsets(),
		) );

		$wp_customize->add_control( 'vct_fonts_and_style_h6_weight', array(
			'label'   => __( 'Font Weight', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h6',
			'settings'   => 'vct_fonts_and_style_h6_weight',
			'type'    => 'select',
			'choices'  => array(
				'300' => __( 'Light', 'visual-composer-starter' ),
				'400' => __( 'Normal (default)', 'visual-composer-starter' ),
				'600' => __( 'Semi-Bold', 'visual-composer-starter' ),
				'700' => __( 'Bold', 'visual-composer-starter' ),
			),
		) );

		$wp_customize->add_control( 'vct_fonts_and_style_h6_font_style', array(
			'label'   => __( 'Font Style', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h6',
			'settings'   => 'vct_fonts_and_style_h6_font_style',
			'type'    => 'select',
			'choices'  => array(
				'normal' => __( 'Normal (default)', 'visual-composer-starter' ),
				'italic' => __( 'Italic', 'visual-composer-starter' ),
				'oblique' => __( 'Oblique', 'visual-composer-starter' ),
				'inherit' => __( 'Inherit', 'visual-composer-starter' ),
			),
		) );

		$wp_customize->add_control( 'vct_fonts_and_style_h6_font_size', array(
			'label'   => __( 'Size', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h6',
			'settings'   => 'vct_fonts_and_style_h6_font_size',
			'type'    => 'text',
		) );

		$wp_customize->add_control( 'vct_fonts_and_style_h6_line_height', array(
			'label'   => __( 'Line Height', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h6',
			'settings'   => 'vct_fonts_and_style_h6_line_height',
			'type'    => 'text',
		) );

		$wp_customize->add_control( 'vct_fonts_and_style_h6_letter_spacing', array(
			'label'   => __( 'Letter Spacing', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h6',
			'settings'   => 'vct_fonts_and_style_h6_letter_spacing',
			'type'    => 'text',
		) );

		$wp_customize->add_control( 'vct_fonts_and_style_h6_margin_top', array(
			'label'   => __( 'Margin Top', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h6',
			'settings'   => 'vct_fonts_and_style_h6_margin_top',
			'type'    => 'text',
		) );

		$wp_customize->add_control( 'vct_fonts_and_style_h6_margin_bottom', array(
			'label'   => __( 'Margin Bottom', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h6',
			'settings'   => 'vct_fonts_and_style_h6_margin_bottom',
			'type'    => 'text',
		) );

		$wp_customize->add_control( 'vct_fonts_and_style_h6_capitalization', array(
			'label'   => __( 'Capitalization', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_h6',
			'settings'   => 'vct_fonts_and_style_h6_capitalization',
			'type'    => 'select',
			'choices'  => array(
				'none'  => __( 'None (default)', 'visual-composer-starter' ),
				'uppercase' => __( 'Uppercase', 'visual-composer-starter' ),
				'lowercase' => __( 'Lowercase', 'visual-composer-starter' ),
				'capitalize' => __( 'Capitalize', 'visual-composer-starter' ),
			),
		) );
	}

	private function fonts_and_style_section_body( $wp_customize ) {
		$wp_customize->add_setting( 'vct_fonts_and_style_body', array(
			'default'        => '',
		) );

		$wp_customize->add_setting( 'vct_fonts_and_style_body_primary_color', array(
			'default'        => '#555555',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_body_secondary_text_color', array(
			'default'        => '#777777',
		) );

		$wp_customize->add_setting( 'vct_fonts_and_style_body_active_color', array(
			'default'        => '#557cbf',
		) );

		$wp_customize->add_setting( 'vct_fonts_and_style_body_font_family', array(
			'default'        => 'Roboto',
		) );

		$wp_customize->add_setting( 'vct_fonts_and_style_body_subsets', array(
				'default'        => 'all',
		) );

		$wp_customize->add_setting( 'vct_fonts_and_style_body_font_size', array(
			'default'        => '16px',
		) );

		$wp_customize->add_setting( 'vct_fonts_and_style_body_letter_spacing', array(
			'default'        => '0.01rem',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_body_line_height', array(
			'default'        => '1.7',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_body_weight', array(
			'default'        => '400',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_body_font_style', array(
			'default'        => 'normal',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_body_margin_top', array(
			'default'        => '0',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_body_margin_bottom', array(
			'default'        => '1.5rem',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_body_capitalization', array(
			'default'        => 'none',
		) );

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'vct_fonts_and_style_body_primary_color',
				array(
					'label'         => __( 'Primary Color', 'visual-composer-starter' ),
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
					'label'         => __( 'Secondary Color', 'visual-composer-starter' ),
					'description'   => __( 'Secondary text color will be applied to block quotes, image captions, etc.', 'visual-composer-starter' ),
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
					'label'         => __( 'Active Color', 'visual-composer-starter' ),
					'description'   => __( 'Active color that will be applied to links and bullets.', 'visual-composer-starter' ),
					'section'       => 'vct_fonts_and_style_body',
					'settings'      => 'vct_fonts_and_style_body_active_color',
				)
			)
		);

		$wp_customize->add_control( 'vct_fonts_and_style_body_font_family', array(
			'label'   => __( 'Font-family', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_body',
			'settings'   => 'vct_fonts_and_style_body_font_family',
			'type'    => 'select',
			'choices'     => VCT_Fonts::vct_theme_font_choices(),
		) );

		$wp_customize->add_control( 'vct_fonts_and_style_body_subsets', array(
			'label'   => __( 'Google Fonts Subsets', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_body',
			'settings'   => 'vct_fonts_and_style_body_subsets',
			'type'    => 'select',
			'choices'     => VCT_Fonts::vct_theme_font_subsets(),
		) );

		$wp_customize->add_control( 'vct_fonts_and_style_body_weight', array(
			'label'   => __( 'Font Weight', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_body',
			'settings'   => 'vct_fonts_and_style_body_weight',
			'type'    => 'select',
			'choices'  => array(
				'300' => __( 'Light', 'visual-composer-starter' ),
				'400' => __( 'Normal (default)', 'visual-composer-starter' ),
				'600' => __( 'Semi-Bold', 'visual-composer-starter' ),
				'700' => __( 'Bold', 'visual-composer-starter' ),
			),
		) );
		$wp_customize->add_control( 'vct_fonts_and_style_body_font_style', array(
			'label'   => __( 'Font Style', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_body',
			'settings'   => 'vct_fonts_and_style_body_font_style',
			'type'    => 'select',
			'choices'  => array(
				'normal' => __( 'Normal (default)', 'visual-composer-starter' ),
				'italic' => __( 'Italic', 'visual-composer-starter' ),
				'oblique' => __( 'Oblique', 'visual-composer-starter' ),
				'inherit' => __( 'Inherit', 'visual-composer-starter' ),
			),
		) );

		$wp_customize->add_control( 'vct_fonts_and_style_body_font_size', array(
			'label'   => __( 'Size', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_body',
			'settings'   => 'vct_fonts_and_style_body_font_size',
			'type'    => 'text',
		) );

		$wp_customize->add_control( 'vct_fonts_and_style_body_line_height', array(
			'label'   => __( 'Line Height', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_body',
			'settings'   => 'vct_fonts_and_style_body_line_height',
			'type'    => 'text',
		) );

		$wp_customize->add_control( 'vct_fonts_and_style_body_letter_spacing', array(
			'label'   => __( 'Letter Spacing', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_body',
			'settings'   => 'vct_fonts_and_style_body_letter_spacing',
			'type'    => 'text',
		) );
		$wp_customize->add_control( 'vct_fonts_and_style_body_margin_top', array(
			'label'   => __( 'Margin Top', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_body',
			'settings'   => 'vct_fonts_and_style_body_margin_top',
			'type'    => 'text',
		) );
		$wp_customize->add_control( 'vct_fonts_and_style_body_margin_bottom', array(
			'label'   => __( 'Margin Bottom', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_body',
			'settings'   => 'vct_fonts_and_style_body_margin_bottom',
			'type'    => 'text',
		) );
		$wp_customize->add_control( 'vct_fonts_and_style_body_capitalization', array(
			'label'   => __( 'Capitalization', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_body',
			'settings'   => 'vct_fonts_and_style_body_capitalization',
			'type'    => 'select',
			'choices'  => array(
				'none'  => __( 'None (default)', 'visual-composer-starter' ),
				'uppercase' => __( 'Uppercase', 'visual-composer-starter' ),
				'lowercase' => __( 'Lowercase', 'visual-composer-starter' ),
				'capitalize' => __( 'Capitalize', 'visual-composer-starter' ),
			),
		) );
	}

	private function fonts_and_style_section_buttons( $wp_customize ) {
		$wp_customize->add_setting( 'vct_fonts_and_style_buttons', array(
			'default'        => '',
		) );

		$wp_customize->add_setting( 'vct_fonts_and_style_buttons_background_color', array(
			'default'        => '#557cbf',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_buttons_text_color', array(
			'default'        => '#f4f4f4',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_buttons_background_hover_color', array(
			'default'        => '#3c63a6',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_buttons_text_hover_color', array(
			'default'        => '#f4f4f4',
		) );

		$wp_customize->add_setting( 'vct_fonts_and_style_buttons_font_family', array(
			'default'        => 'Playfair Display',
		) );

		$wp_customize->add_setting( 'vct_fonts_and_style_buttons_subsets', array(
				'default'        => 'all',
		) );

		$wp_customize->add_setting( 'vct_fonts_and_style_buttons_font_size', array(
			'default'        => '16px',
		) );

		$wp_customize->add_setting( 'vct_fonts_and_style_buttons_letter_spacing', array(
			'default'        => '0.01rem',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_buttons_line_height', array(
			'default'        => '1',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_buttons_weight', array(
			'default'        => '400',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_buttons_font_style', array(
			'default'        => 'normal',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_buttons_margin_top', array(
			'default'        => '0',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_buttons_margin_bottom', array(
			'default'        => '0',
		) );
		$wp_customize->add_setting( 'vct_fonts_and_style_buttons_capitalization', array(
			'default'        => 'none',
		) );

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'vct_fonts_and_style_buttons_background_color',
				array(
					'label'         => __( 'Background Color', 'visual-composer-starter' ),
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
					'label'         => __( 'Text Color', 'visual-composer-starter' ),
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
					'label'         => __( 'Background Hover Color', 'visual-composer-starter' ),
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
					'label'         => __( 'Text Hover Color', 'visual-composer-starter' ),
					'section'       => 'vct_fonts_and_style_buttons',
					'settings'      => 'vct_fonts_and_style_buttons_text_hover_color',
				)
			)
		);

		$wp_customize->add_control( 'vct_fonts_and_style_buttons_font_family', array(
			'label'   => __( 'Font-family', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_buttons',
			'settings'   => 'vct_fonts_and_style_buttons_font_family',
			'type'    => 'select',
			'choices'     => VCT_Fonts::vct_theme_font_choices(),
		) );

		$wp_customize->add_control( 'vct_fonts_and_style_buttons_subsets', array(
			'label'   => __( 'Google Fonts Subsets', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_buttons',
			'settings'   => 'vct_fonts_and_style_buttons_subsets',
			'type'    => 'select',
			'choices'     => VCT_Fonts::vct_theme_font_subsets(),
		) );

		$wp_customize->add_control( 'vct_fonts_and_style_buttons_weight', array(
			'label'   => __( 'Font Weight', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_buttons',
			'settings'   => 'vct_fonts_and_style_buttons_weight',
			'type'    => 'select',
			'choices'  => array(
				'300' => __( 'Light', 'visual-composer-starter' ),
				'400' => __( 'Normal (default)', 'visual-composer-starter' ),
				'600' => __( 'Semi-Bold', 'visual-composer-starter' ),
				'700' => __( 'Bold', 'visual-composer-starter' ),
			),
		) );
		$wp_customize->add_control( 'vct_fonts_and_style_buttons_font_style', array(
			'label'   => __( 'Font Style', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_buttons',
			'settings'   => 'vct_fonts_and_style_buttons_font_style',
			'type'    => 'select',
			'choices'  => array(
				'normal' => __( 'Normal (default)', 'visual-composer-starter' ),
				'italic' => __( 'Italic', 'visual-composer-starter' ),
				'oblique' => __( 'Oblique', 'visual-composer-starter' ),
				'inherit' => __( 'Inherit', 'visual-composer-starter' ),
			),
		) );

		$wp_customize->add_control( 'vct_fonts_and_style_buttons_font_size', array(
			'label'   => __( 'Size', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_buttons',
			'settings'   => 'vct_fonts_and_style_buttons_font_size',
			'type'    => 'text',
		) );

		$wp_customize->add_control( 'vct_fonts_and_style_buttons_line_height', array(
			'label'   => __( 'Line Height', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_buttons',
			'settings'   => 'vct_fonts_and_style_buttons_line_height',
			'type'    => 'text',
		) );

		$wp_customize->add_control( 'vct_fonts_and_style_buttons_letter_spacing', array(
			'label'   => __( 'Letter Spacing', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_buttons',
			'settings'   => 'vct_fonts_and_style_buttons_letter_spacing',
			'type'    => 'text',
		) );
		$wp_customize->add_control( 'vct_fonts_and_style_buttons_margin_top', array(
			'label'   => __( 'Margin Top', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_buttons',
			'settings'   => 'vct_fonts_and_style_buttons_margin_top',
			'type'    => 'text',
		) );
		$wp_customize->add_control( 'vct_fonts_and_style_buttons_margin_bottom', array(
			'label'   => __( 'Margin Bottom', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_buttons',
			'settings'   => 'vct_fonts_and_style_buttons_margin_bottom',
			'type'    => 'text',
		) );
		$wp_customize->add_control( 'vct_fonts_and_style_buttons_capitalization', array(
			'label'   => __( 'Capitalization', 'visual-composer-starter' ),
			'section' => 'vct_fonts_and_style_buttons',
			'settings'   => 'vct_fonts_and_style_buttons_capitalization',
			'type'    => 'select',
			'choices'  => array(
				'none'  => __( 'None (default)', 'visual-composer-starter' ),
				'uppercase' => __( 'Uppercase', 'visual-composer-starter' ),
				'lowercase' => __( 'Lowercase', 'visual-composer-starter' ),
				'capitalize' => __( 'Capitalize', 'visual-composer-starter' ),
			),
		) );
	}
}
