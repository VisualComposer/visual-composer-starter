<?php
class VC_Customizer {

    /**
     * Visual Composer Theme Customizer constructor.
     *
     *
     * @access public
     * @since  1.1
     */
    public function __construct() {

        add_action( 'customize_register', array( $this, 'include_controls' ) );
        add_action( 'customize_register', array( $this, 'register_customize_sections' ) );

    }

    /**
     * Include Custom Controls
     *
     * Includes all our custom control classes.
     *
     * @param WP_Customize_Manager $wp_customize
     *
     * @access public
     * @since  1.1
     * @return void
     */
    public function include_controls( $wp_customize ) {

        require_once get_template_directory() . '/inc/customizer/controls/class-vc-image-select-control.php';

        $wp_customize->register_control_type( 'VC_Image_Select_Control' );

    }

    /**
     * Add all panels and sections to the Customizer
     *
     * @param WP_Customize_Manager $wp_customize
     *
     * @access public
     * @since  1.1
     * @return void
     */
    public function register_customize_sections( $wp_customize ) {

        // Create sections
        $wp_customize->add_section( 'vc_overall_site', array(
            'title'    => __( 'Overall Site', 'visual-composer-theme' ),
            'priority' => 101
        ) );
        $wp_customize->add_section( 'vc_content_area', array(
            'title'    => __( 'Content Area', 'visual-composer-theme' ),
            'priority' => 102
        ) );
        $wp_customize->add_section( 'vc_header_and_menu_area', array(
            'title'    => __( 'Header (Menu) Area', 'visual-composer-theme' ),
            'priority' => 103
        ) );
        $wp_customize->add_section( 'vc_footer_area', array(
            'title'    => __( 'Footer Area', 'visual-composer-theme' ),
            'priority' => 103
        ) );
        $wp_customize->add_section( 'vc_fonts_and_style', array(
            'title'    => __( 'Body Fonts & Style', 'visual-composer-theme' ),
            'priority' => 104
        ) );
        $wp_customize->add_section( 'vc_fonts_and_style_headers', array(
            'title'    => __( 'H1-H6 Fonts & Style', 'visual-composer-theme' ),
            'priority' => 105
        ) );

        // Populate sections
        $this->overall_site_section( $wp_customize );
        $this->content_area_section( $wp_customize );
        $this->header_and_menu_section( $wp_customize );
        $this->footer_section( $wp_customize );
        $this->fonts_and_style_section( $wp_customize );
        $this->fonts_and_style_headers_section( $wp_customize );

    }

    /**
     * Section: Overall Site
     *
     * @param WP_Customize_Manager $wp_customize
     *
     * @access private
     * @since  1.1
     * @return void
     */
    private function overall_site_section( $wp_customize ) {

        $wp_customize->add_setting('vc_overall_site_bg_color',  array(
            'default'       => '#ffffff',
        ));

        $wp_customize->add_setting('vc_overall_site_featured_image',  array(
            'default' => 'show'
        ));

        $wp_customize->add_control(
            new WP_Customize_Color_Control(
                $wp_customize,
                'vc_overall_site_bg_color',
                array(
                    'label'         => __( 'Background Color', 'visual-composer-theme' ),
                    'description'   => __( 'Choose a site background color.', 'visual-composer-theme' ),
                    'section'       => 'vc_overall_site',
                    'settings'      => 'vc_overall_site_bg_color',
                ) )
        );

        $wp_customize->add_control(
            new WP_Customize_Control(
                $wp_customize,
                'vc_overall_site_featured_image',
                array(
                    'type'          => 'radio',
                    'label'         => __( 'Featured image', 'visual-composer-theme' ),
                    'description'   => __( 'Show or hide featured image for posts and pages.', 'visual-composer-theme' ),
                    'section'       => 'vc_overall_site',
                    'settings'      => 'vc_overall_site_featured_image',
                    'choices'       => array(
                                            'show' => __( 'Show (default)', 'visual-composer-theme' ),
                                            'hide' => __( 'Hide', 'visual-composer-theme' ),
                                    ),

                    ) )
        );



    }
    /**
     * Section: Content Area Section
     *
     * @param WP_Customize_Manager $wp_customize
     *
     * @access private
     * @since  1.1
     * @return void
     */
    private function content_area_section( $wp_customize ) {

        $wp_customize->add_setting('vc_content_area_sidebar',  array(
            'default'       => 'none',
        ));

        $wp_customize->add_setting('vc_content_area_size',  array(
            'default'       => 'boxed',
        ));

        $wp_customize->add_control(
            new WP_Customize_Control(
                $wp_customize,
                'vc_content_area_sidebar',
                array(
                    'type'          => 'select',
                    'label'         => __( 'Sidebar Customization', 'visual-composer-theme' ),
                    'description'   => __( 'Default content area of theme is defined as Boxed and No Sidebar.', 'visual-composer-theme' ),
                    'section'       => 'vc_content_area',
                    'settings'      => 'vc_content_area_sidebar',
                    'choices'       => array(
                        'none'  => __( 'None (default)', 'visual-composer-theme' ),
                        'left'  => __( 'Position left', 'visual-composer-theme' ),
                        'right' => __( 'Position right', 'visual-composer-theme' ),

                    ),

                ) )
        );

        $wp_customize->add_control(
            new WP_Customize_Control(
                $wp_customize,
                'vc_content_area_size',
                array(
                    'type'          => 'select',
                    'label'         => __( 'Content Area Size Customization', 'visual-composer-theme' ),
                    'description'   => __( 'Default content area size is defined as Boxed and Full width.', 'visual-composer-theme' ),
                    'section'       => 'vc_content_area',
                    'settings'      => 'vc_content_area_size',
                    'choices'       => array(
                        'boxed'         => __( 'Boxed (default)', 'visual-composer-theme' ),
                        'full_width'    => __( 'Full width', 'visual-composer-theme' ),
                    ),

                ) )
        );

    }

    /**
     * Section: Header (Menu) Section
     *
     * @param WP_Customize_Manager $wp_customize
     *
     * @access private
     * @since  1.1
     * @return void
     */
    private function header_and_menu_section( $wp_customize ) {

        $wp_customize->add_setting('vc_header_and_menu_area_background',  array(
            'default'       => '#ffffff',
        ));

        $wp_customize->add_setting('vc_header_and_menu_area_text_color',  array(
            'default'       => '#555555',
        ));

        $wp_customize->add_setting('vc_header_and_menu_area_text_active_color',  array(
            'default'       => '#333333',
        ));

        $wp_customize->add_setting('vc_header_and_menu_area_background_remove',  array(
            'default'       => 'no',
        ));

        $wp_customize->add_setting('vc_header_and_menu_area_position',  array(
            'default'       => 'top',
        ));

        $wp_customize->add_setting('vc_header_and_menu_area_sandwich_style',  array(
            'default'       => '#333333',
        ));

        $wp_customize->add_setting('vc_header_and_menu_area_top_header',  array(
            'default'       => 'regular',
        ));

        $wp_customize->add_setting('vc_header_and_menu_area_top_header_width',  array(
            'default'       => 'boxed',
        ));


        $wp_customize->add_control(
            new WP_Customize_Color_Control(
                $wp_customize,
                'vc_header_and_menu_area_background',
                array(
                    'label'         => __( 'Background Color', 'visual-composer-theme' ),
                    'description'   => __( 'Choose a header background color.', 'visual-composer-theme' ),
                    'section'       => 'vc_header_and_menu_area',
                    'settings'      => 'vc_header_and_menu_area_background',
                ) )
        );

        $wp_customize->add_control(
            new WP_Customize_Control(
                $wp_customize,
                'vc_header_and_menu_area_background_remove',
                array(
                    'type'          => 'radio',
                    'label'         => __( 'Remove background color', 'visual-composer-theme' ),
                    'section'       => 'vc_header_and_menu_area',
                    'settings'      => 'vc_header_and_menu_area_background_remove',
                    'choices'       => array(
                        'yes'           => __( 'Yes', 'visual-composer-theme' ),
                        'no'            => __( 'No', 'visual-composer-theme' ),
                    ),
                ) )
        );

        $wp_customize->add_control(
            new WP_Customize_Color_Control(
                $wp_customize,
                'vc_header_and_menu_area_text_color',
                array(
                    'label'         => __( 'Text color', 'visual-composer-theme' ),
                    'description'   => __( 'Choose a text color.', 'visual-composer-theme' ),
                    'section'       => 'vc_header_and_menu_area',
                    'settings'      => 'vc_header_and_menu_area_text_color',
                ) )
        );

        $wp_customize->add_control(
            new WP_Customize_Color_Control(
                $wp_customize,
                'vc_header_and_menu_area_text_active_color',
                array(
                    'label'         => __( 'Active text color', 'visual-composer-theme' ),
                    'description'   => __( 'Choose active text color.', 'visual-composer-theme' ),
                    'section'       => 'vc_header_and_menu_area',
                    'settings'      => 'vc_header_and_menu_area_text_active_color',
                ) )
        );

        $wp_customize->add_control(
            new WP_Customize_Control(
                $wp_customize,
                'vc_header_and_menu_area_sandwich_style',
                array(
                    'type'          => 'select',
                    'label'         => __( 'Sandwich style', 'visual-composer-theme' ),
                    'description'   => __( 'Default sandwich style of theme is defined as Dark and Light.', 'visual-composer-theme' ),
                    'section'       => 'vc_header_and_menu_area',
                    'settings'      => 'vc_header_and_menu_area_sandwich_style',
                    'choices'       => array(
                        '#333333'      => __( 'Dark (default)', 'visual-composer-theme' ),
                        '#FFFFFF'      => __( 'Light', 'visual-composer-theme' ),
                    ),
                ) )
        );

        $wp_customize->add_control(
            new WP_Customize_Control(
                $wp_customize,
                'vc_header_and_menu_area_position',
                array(
                    'type'          => 'select',
                    'label'         => __( 'Header position', 'visual-composer-theme' ),
                    'description'   => __( 'Default header position of theme is defined as Top and Sandwich.', 'visual-composer-theme' ),
                    'section'       => 'vc_header_and_menu_area',
                    'settings'      => 'vc_header_and_menu_area_position',
                    'choices'       => array(
                        'top'           => __( 'Top (default)', 'visual-composer-theme' ),
                        'sandwich'      => __( 'Sandwich', 'visual-composer-theme' ),
                    ),
                ) )
        );

        $wp_customize->add_control(
            new WP_Customize_Control(
                $wp_customize,
                'vc_header_and_menu_area_top_header',
                array(
                    'type'          => 'select',
                    'label'         => __( 'Top header', 'visual-composer-theme' ),
                    'description'   => __( 'Default top header option of theme is defined as Regular and Fixed (it will stay on the top of the screen always when scrolling).', 'visual-composer-theme' ),
                    'section'       => 'vc_header_and_menu_area',
                    'settings'      => 'vc_header_and_menu_area_top_header',
                    'choices'       => array(
                        'regular'       => __( 'Regular (default)', 'visual-composer-theme' ),
                        'fixed'         => __( 'Fixed', 'visual-composer-theme' ),
                    ),
                ) )
        );
        $wp_customize->add_control(
            new WP_Customize_Control(
                $wp_customize,
                'vc_header_and_menu_area_top_header_width',
                array(
                    'type'          => 'select',
                    'label'         => __( 'Top header width', 'visual-composer-theme' ),
                    'description'   => __( 'Default top header width of theme is defined as<ol><li> Boxed (all header content and background is boxed)</li><li>Full width boxed (header background is full width, but content is boxed)</li><li>Full width (header background and content is full width)</li></ol>', 'visual-composer-theme' ),
                    'section'       => 'vc_header_and_menu_area',
                    'settings'      => 'vc_header_and_menu_area_top_header_width',
                    'choices'       => array(
                        'boxed'             => __( 'Boxed (default)', 'visual-composer-theme' ),
                        'full_width_boxed'  => __( 'Full width boxed', 'visual-composer-theme' ),
                        'full_width'        => __( 'Full width', 'visual-composer-theme' ),
                    ),
                ) )
        );

    }

    /**
     * Section: Footer Section
     *
     * @param WP_Customize_Manager $wp_customize
     *
     * @access private
     * @since  1.1
     * @return void
     */
    private function footer_section( $wp_customize ) {

        $wp_customize->add_setting('vc_footer_area_background',  array(
            'default'       => '#333333',
        ));

        $wp_customize->add_setting('vc_footer_area_text_color',  array(
            'default'       => '#777777',
        ));

        $wp_customize->add_setting('vc_footer_area_text_active_color',  array(
            'default'       => '#ffffff',
        ));
        

        $wp_customize->add_setting('vc_footer_area_widgetized_columns',  array(
            'default'       => 0,
        ));

        $wp_customize->add_control(
            new WP_Customize_Color_Control(
                $wp_customize,
                'vc_footer_area_background',
                array(
                    'label'         => __( 'Background Color', 'visual-composer-theme' ),
                    'description'   => __( 'Choose a header background color.', 'visual-composer-theme' ),
                    'section'       => 'vc_footer_area',
                    'settings'      => 'vc_footer_area_background',
                ) )
        );


        $wp_customize->add_control(
            new WP_Customize_Color_Control(
                $wp_customize,
                'vc_footer_area_text_color',
                array(
                    'label'         => __( 'Text color', 'visual-composer-theme' ),
                    'description'   => __( 'Choose a text color.', 'visual-composer-theme' ),
                    'section'       => 'vc_footer_area',
                    'settings'      => 'vc_footer_area_text_color',
                ) )
        );

        $wp_customize->add_control(
            new WP_Customize_Color_Control(
                $wp_customize,
                'vc_footer_area_text_active_color',
                array(
                    'label'         => __( 'Active text color', 'visual-composer-theme' ),
                    'description'   => __( 'Choose active text color.', 'visual-composer-theme' ),
                    'section'       => 'vc_footer_area',
                    'settings'      => 'vc_footer_area_text_active_color',
                ) )
        );

        $wp_customize->add_control(
            new WP_Customize_Control(
                $wp_customize,
                'vc_footer_area_widgetized_columns',
                array(
                    'type'          => 'radio',
                    'label'         => __( 'Number of columns where widgets can be placed', 'visual-composer-theme' ),
                    'section'       => 'vc_footer_area',
                    'settings'      => 'vc_footer_area_widgetized_columns',
                    'choices'       => array(
                        0           => __( 'Zero', 'visual-composer-theme' ),
                        1           => __( 'One column', 'visual-composer-theme' ),
                        2           => __( 'Two columns', 'visual-composer-theme' ),
                        3           => __( 'Three columns', 'visual-composer-theme' ),
                        4           => __( 'Four columns', 'visual-composer-theme' ),

                    ),
                ) )
        );


        $wp_customize->add_setting('vc_footer_area_social_link_facebook',  array(
            'default'       => '',
        ));
        $wp_customize->add_setting('vc_footer_area_social_link_twitter',  array(
            'default'       => '',
        ));
        $wp_customize->add_setting('vc_footer_area_social_link_linkedin',  array(
            'default'       => '',
        ));
        $wp_customize->add_setting('vc_footer_area_social_link_instagram',  array(
            'default'       => '',
        ));
        $wp_customize->add_setting('vc_footer_area_social_link_pinterest',  array(
            'default'       => '',
        ));
        $wp_customize->add_setting('vc_footer_area_social_link_youtube',  array(
            'default'       => '',
        ));
        $wp_customize->add_setting('vc_footer_area_social_link_vimeo',  array(
            'default'       => '',
        ));
        $wp_customize->add_setting('vc_footer_area_social_link_flickr',  array(
            'default'       => '',
        ));
        $wp_customize->add_setting('vc_footer_area_social_link_github',  array(
            'default'       => '',
        ));
        $wp_customize->add_setting('vc_footer_area_social_email',  array(
            'default'       => '',
        ));
        $wp_customize->add_control(
            new WP_Customize_Control(
                $wp_customize,
                'vc_footer_area_social_link_facebook',
                array(
                    'type'          => 'text',
                    'label'         => __( 'Facebook link', 'visual-composer-theme' ),
                    'section'       => 'vc_footer_area',
                    'settings'      => 'vc_footer_area_social_link_facebook',
                ) )
        );
        $wp_customize->add_control(
            new WP_Customize_Control(
                $wp_customize,
                'vc_footer_area_social_link_twitter',
                array(
                    'type'          => 'text',
                    'label'         => __( 'Twitter link', 'visual-composer-theme' ),
                    'section'       => 'vc_footer_area',
                    'settings'      => 'vc_footer_area_social_link_twitter',
                ) )
        );
        $wp_customize->add_control(
            new WP_Customize_Control(
                $wp_customize,
                'vc_footer_area_social_link_linkedin',
                array(
                    'type'          => 'text',
                    'label'         => __( 'LinkedIn link', 'visual-composer-theme' ),
                    'section'       => 'vc_footer_area',
                    'settings'      => 'vc_footer_area_social_link_linkedin',
                ) )
        );
        $wp_customize->add_control(
            new WP_Customize_Control(
                $wp_customize,
                'vc_footer_area_social_link_instagram',
                array(
                    'type'          => 'text',
                    'label'         => __( 'Instagram link', 'visual-composer-theme' ),
                    'section'       => 'vc_footer_area',
                    'settings'      => 'vc_footer_area_social_link_instagram',
                ) )
        );
        $wp_customize->add_control(
            new WP_Customize_Control(
                $wp_customize,
                'vc_footer_area_social_link_pinterest',
                array(
                    'type'          => 'text',
                    'label'         => __( 'Pinterest link', 'visual-composer-theme' ),
                    'section'       => 'vc_footer_area',
                    'settings'      => 'vc_footer_area_social_link_pinterest',
                ) )
        );
        $wp_customize->add_control(
            new WP_Customize_Control(
                $wp_customize,
                'vc_footer_area_social_link_youtube',
                array(
                    'type'          => 'text',
                    'label'         => __( 'YouTube link', 'visual-composer-theme' ),
                    'section'       => 'vc_footer_area',
                    'settings'      => 'vc_footer_area_social_link_youtube',
                ) )
        );
        $wp_customize->add_control(
            new WP_Customize_Control(
                $wp_customize,
                'vc_footer_area_social_link_vimeo',
                array(
                    'type'          => 'text',
                    'label'         => __( 'Vimeo link', 'visual-composer-theme' ),
                    'section'       => 'vc_footer_area',
                    'settings'      => 'vc_footer_area_social_link_vimeo',
                ) )
        );
        $wp_customize->add_control(
            new WP_Customize_Control(
                $wp_customize,
                'vc_footer_area_social_link_flickr',
                array(
                    'type'          => 'text',
                    'label'         => __( 'Flickr link', 'visual-composer-theme' ),
                    'section'       => 'vc_footer_area',
                    'settings'      => 'vc_footer_area_social_link_flickr',
                ) )
        );
        $wp_customize->add_control(
            new WP_Customize_Control(
                $wp_customize,
                'vc_footer_area_social_link_github',
                array(
                    'type'          => 'text',
                    'label'         => __( 'Github link', 'visual-composer-theme' ),
                    'section'       => 'vc_footer_area',
                    'settings'      => 'vc_footer_area_social_link_github',
                ) )
        );
        $wp_customize->add_control(
            new WP_Customize_Control(
                $wp_customize,
                'vc_footer_area_social_email',
                array(
                    'type'          => 'text',
                    'label'         => __( 'Email', 'visual-composer-theme' ),
                    'section'       => 'vc_footer_area',
                    'settings'      => 'vc_footer_area_social_email',
                ) )
        );

    }


    /**
     * Section: Body Fonts & Styles Section
     *
     * @param WP_Customize_Manager $wp_customize
     *
     * @access private
     * @since  1.1
     * @return void
     */
    private function fonts_and_style_section( $wp_customize ) {
        

        $wp_customize->add_setting( 'vc_fonts_and_style', array(
            'default'        => '',
        ) );

        $wp_customize->add_setting( 'vc_fonts_and_style_text_color', array(
            'default'        => '#000000',
        ) );

        $wp_customize->add_setting( 'vc_fonts_and_style_link_color', array(
            'default'        => '#000000',
        ) );

        $wp_customize->add_setting( 'vc_fonts_and_style_active_color', array(
            'default'        => '#ffffff',
        ) );

        $wp_customize->add_setting( 'vc_fonts_and_style_first_font_family', array(
            'default'        => 'Playfair Display',
        ) );
        $wp_customize->add_setting( 'vc_fonts_and_style_second_font_family', array(
            'default'        => 'Roboto',
        ) );

        $wp_customize->add_setting( 'vc_fonts_and_style_subsets', array(
            'default'        => 'all',
        ) );

        $wp_customize->add_setting( 'vc_fonts_and_style_font_size', array(
            'default'        => '13px',
        ) );
        $wp_customize->add_setting( 'vc_fonts_and_style_line_height', array(
            'default'        => '1.5',
        ) );

        $wp_customize->add_setting( 'vc_fonts_and_style_letter_spacing', array(
            'default'        => '0',
        ) );
        $wp_customize->add_setting( 'vc_fonts_and_style_weight', array(
                'default'        => '400',
        ) );



        $wp_customize->add_control(
            new WP_Customize_Color_Control(
                $wp_customize,
                'vc_fonts_and_style_text_color',
                array(
                    'label'         => __( 'Text color', 'visual-composer-theme' ),
                    'description'   => __( 'Choose text color', 'visual-composer-theme' ),
                    'section'       => 'vc_fonts_and_style',
                    'settings'      => 'vc_fonts_and_style_text_color',
                ) )
        );

        $wp_customize->add_control(
            new WP_Customize_Color_Control(
                $wp_customize,
                'vc_fonts_and_style_link_color',
                array(
                    'label'         => __( 'Link color', 'visual-composer-theme' ),
                    'description'   => __( 'Choose link color', 'visual-composer-theme' ),
                    'section'       => 'vc_fonts_and_style',
                    'settings'      => 'vc_fonts_and_style_link_color',
                ) )
        );

        $wp_customize->add_control(
            new WP_Customize_Color_Control(
                $wp_customize,
                'vc_fonts_and_style_active_color',
                array(
                    'label'         => __( 'Active color', 'visual-composer-theme' ),
                    'description'   => __( 'Active color that will be applied to links and bullets.', 'visual-composer-theme' ),
                    'section'       => 'vc_fonts_and_style',
                    'settings'      => 'vc_fonts_and_style_active_color',
                ) )
        );



        $wp_customize->add_control(  'vc_fonts_and_style_first_font_family', array(
            'label'   => __( 'First font', 'visual-composer-theme' ),
            'description'   => __( 'First theme font', 'visual-composer-theme' ),
            'section' => 'vc_fonts_and_style',
            'settings'   => 'vc_fonts_and_style_first_font_family',
            'type'    => 'select',
            'choices'     => VC_Fonts::vc_theme_font_choices(),
            'priority' => 12
        ) );
        $wp_customize->add_control(  'vc_fonts_and_style_second_font_family', array(
            'label'   => __( 'Second font', 'visual-composer-theme' ),
            'description'   => __( 'Second theme font', 'visual-composer-theme' ),
            'section' => 'vc_fonts_and_style',
            'settings'   => 'vc_fonts_and_style_second_font_family',
            'type'    => 'select',
            'choices'     => VC_Fonts::vc_theme_font_choices(),
            'priority' => 13
        ) );

        $wp_customize->add_control( 'vc_fonts_and_style_subsets', array(
            'label'   => __( 'Font subsets', 'visual-composer-theme' ),
            'description'   => __( 'Google Fonts Subsets', 'visual-composer-theme' ),
            'section' => 'vc_fonts_and_style',
            'settings'   => 'vc_fonts_and_style_subsets',
            'type'    => 'select',
            'choices'     => VC_Fonts::vc_theme_font_subsets(),
            'priority' => 14
        ) );
        $wp_customize->add_control(  'vc_fonts_and_style_weight', array(
            'label'   => __( 'Font Weight & Style', 'visual-composer-theme' ),
            'section' => 'vc_fonts_and_style',
            'settings'   => 'vc_fonts_and_style_weight',
            'type'    => 'select',
            'choices'  => array(
                '300' => __( 'Light', 'visual-composer-theme' ),
                'italic 300' => __( 'Light Italic', 'visual-composer-theme' ),
                '400' => __( 'Normal (default)', 'visual-composer-theme' ),
                'italic 400' => __( 'Normal Italic', 'visual-composer-theme' ),
                '600' => __( 'Semi-Bold', 'visual-composer-theme' ),
                'italic 600' => __( 'Semi-Bold Italic', 'visual-composer-theme' ),
                '700' => __( 'Bold', 'visual-composer-theme' ),
                'italic 700' => __( 'Bold Italic', 'visual-composer-theme' ),
            ),
            'priority' => 17
        ) );

        $wp_customize->add_control(  'vc_fonts_and_style_font_size', array(
            'label'   => __( 'Font size', 'visual-composer-theme' ),
            'description'   => __( 'Site main font size', 'visual-composer-theme' ),
            'section' => 'vc_fonts_and_style',
            'settings'   => 'vc_fonts_and_style_font_size',
            'type'    => 'text',
            'priority' => 15
        ) );
        $wp_customize->add_control(  'vc_fonts_and_style_line_height', array(
            'label'   => __( 'Line height', 'visual-composer-theme' ),
            'section' => 'vc_fonts_and_style',
            'settings'   => 'vc_fonts_and_style_line_height',
            'type'    => 'text',
            'priority' => 16
        ) );

        $wp_customize->add_control(  'vc_fonts_and_style_letter_spacing', array(
            'label'   => __( 'Letter spacing', 'visual-composer-theme' ),
            'section' => 'vc_fonts_and_style',
            'settings'   => 'vc_fonts_and_style_letter_spacing',
            'type'    => 'text',
            'priority' => 17
        ) );

    }


    /**
     * Section: Headers and Style Section
     *
     * @param WP_Customize_Manager $wp_customize
     *
     * @access private
     * @since  1.1
     * @return void
     */
    private function fonts_and_style_headers_section( $wp_customize ) {


        $wp_customize->add_setting( 'vc_fonts_and_style_headers', array(
            'default'        => '',
        ) );
        $wp_customize->add_setting( 'vc_fonts_and_style_headers_text_color', array(
            'default'        => '#000000',
        ) );

        $wp_customize->add_setting( 'vc_fonts_and_style_headers_font_family', array(
            'default'        => 'Playfair Display',
        ) );

        $wp_customize->add_setting( 'vc_fonts_and_style_headers_subsets', array(
            'default'        => 'all',
        ) );

        $wp_customize->add_setting( 'vc_fonts_and_style_headers_h1_font_size', array(
            'default'        => '25px',
        ) );
        $wp_customize->add_setting( 'vc_fonts_and_style_headers_h2_font_size', array(
            'default'        => '23px',
        ) );
        $wp_customize->add_setting( 'vc_fonts_and_style_headers_h3_font_size', array(
            'default'        => '20px',
        ) );
        $wp_customize->add_setting( 'vc_fonts_and_style_headers_h4_font_size', array(
            'default'        => '18px',
        ) );
        $wp_customize->add_setting( 'vc_fonts_and_style_headers_h5_font_size', array(
            'default'        => '15px',
        ) );
        $wp_customize->add_setting( 'vc_fonts_and_style_headers_h6_font_size', array(
            'default'        => '14px',
        ) );
        $wp_customize->add_setting( 'vc_fonts_and_style_headers_line_height', array(
            'default'        => '1.5',
        ) );

        $wp_customize->add_setting( 'vc_fonts_and_style_headers_letter_spacing', array(
            'default'        => '0',
        ) );
        $wp_customize->add_setting( 'vc_fonts_and_style_headers_weight', array(
            'default'        => '400',
        ) );
        $wp_customize->add_setting( 'vc_fonts_and_style_headers_margin_top', array(
            'default'        => '0.67em',
        ) );
        $wp_customize->add_setting( 'vc_fonts_and_style_headers_margin_bottom', array(
            'default'        => '0.67em',
        ) );
        $wp_customize->add_setting( 'vc_fonts_and_style_headers_capitalization', array(
            'default'        => 'capitalize',
        ) );



        $wp_customize->add_control(
            new WP_Customize_Color_Control(
                $wp_customize,
                'vc_fonts_and_style_headers_text_color',
                array(
                    'label'         => __( 'Text color', 'visual-composer-theme' ),
                    'description'   => __( 'Choose text color', 'visual-composer-theme' ),
                    'section'       => 'vc_fonts_and_style_headers',
                    'settings'      => 'vc_fonts_and_style_headers_text_color',
                ) )
        );



        $wp_customize->add_control(  'vc_fonts_and_style_headers_font_family', array(
            'label'   => __( 'Headers font', 'visual-composer-theme' ),
            'section' => 'vc_fonts_and_style_headers',
            'settings'   => 'vc_fonts_and_style_headers_font_family',
            'type'    => 'select',
            'choices'     => VC_Fonts::vc_theme_font_choices(),
        ) );


        $wp_customize->add_control( 'vc_fonts_and_style_headers_subsets', array(
            'label'   => __( 'Font subsets', 'visual-composer-theme' ),
            'description'   => __( 'Google Fonts Subsets', 'visual-composer-theme' ),
            'section' => 'vc_fonts_and_style_headers',
            'settings'   => 'vc_fonts_and_style_headers_subsets',
            'type'    => 'select',
            'choices'     => VC_Fonts::vc_theme_font_subsets(),
        ) );
        $wp_customize->add_control(  'vc_fonts_and_style_headers_weight', array(
            'label'   => __( 'Font Weight & Style', 'visual-composer-theme' ),
            'section' => 'vc_fonts_and_style_headers',
            'settings'   => 'vc_fonts_and_style_headers_weight',
            'type'    => 'select',
            'choices'  => array(
                '300' => __( 'Light', 'visual-composer-theme' ),
                'italic 300' => __( 'Light Italic', 'visual-composer-theme' ),
                '400' => __( 'Normal (default)', 'visual-composer-theme' ),
                'italic 400' => __( 'Normal Italic', 'visual-composer-theme' ),
                '600' => __( 'Semi-Bold', 'visual-composer-theme' ),
                'italic 600' => __( 'Semi-Bold Italic', 'visual-composer-theme' ),
                '700' => __( 'Bold', 'visual-composer-theme' ),
                'italic 700' => __( 'Bold Italic', 'visual-composer-theme' ),
            ),
        ) );

        $wp_customize->add_control(  'vc_fonts_and_style_headers_h1_font_size', array(
            'label'   => __( 'H1 Font size', 'visual-composer-theme' ),
            'section' => 'vc_fonts_and_style_headers',
            'settings'   => 'vc_fonts_and_style_headers_h1_font_size',
            'type'    => 'text',
        ) );
        $wp_customize->add_control(  'vc_fonts_and_style_headers_h2_font_size', array(
            'label'   => __( 'H2 Font size', 'visual-composer-theme' ),
            'section' => 'vc_fonts_and_style_headers',
            'settings'   => 'vc_fonts_and_style_headers_h1_font_size',
            'type'    => 'text',
        ) );
        $wp_customize->add_control(  'vc_fonts_and_style_headers_h3_font_size', array(
            'label'   => __( 'H3 Font size', 'visual-composer-theme' ),
            'section' => 'vc_fonts_and_style_headers',
            'settings'   => 'vc_fonts_and_style_headers_h3_font_size',
            'type'    => 'text',
        ) );
        $wp_customize->add_control(  'vc_fonts_and_style_headers_h4_font_size', array(
            'label'   => __( 'H4 Font size', 'visual-composer-theme' ),
            'section' => 'vc_fonts_and_style_headers',
            'settings'   => 'vc_fonts_and_style_headers_h4_font_size',
            'type'    => 'text',
        ) );
        $wp_customize->add_control(  'vc_fonts_and_style_headers_h5_font_size', array(
            'label'   => __( 'H5 Font size', 'visual-composer-theme' ),
            'section' => 'vc_fonts_and_style_headers',
            'settings'   => 'vc_fonts_and_style_headers_h5_font_size',
            'type'    => 'text',
        ) );
        $wp_customize->add_control(  'vc_fonts_and_style_headers_h6_font_size', array(
            'label'   => __( 'H6 Font size', 'visual-composer-theme' ),
            'section' => 'vc_fonts_and_style_headers',
            'settings'   => 'vc_fonts_and_style_headers_h6_font_size',
            'type'    => 'text',
        ) );

        $wp_customize->add_control(  'vc_fonts_and_style_headers_line_height', array(
            'label'   => __( 'Line height', 'visual-composer-theme' ),
            'section' => 'vc_fonts_and_style_headers',
            'settings'   => 'vc_fonts_and_style_headers_line_height',
            'type'    => 'text',
        ) );

        $wp_customize->add_control(  'vc_fonts_and_style_headers_letter_spacing', array(
            'label'   => __( 'Letter spacing', 'visual-composer-theme' ),
            'section' => 'vc_fonts_and_style_headers',
            'settings'   => 'vc_fonts_and_style_headers_letter_spacing',
            'type'    => 'text',
        ) );
        $wp_customize->add_control(  'vc_fonts_and_style_headers_margin_top', array(
            'label'   => __( 'Margin Top', 'visual-composer-theme' ),
            'section' => 'vc_fonts_and_style_headers',
            'settings'   => 'vc_fonts_and_style_headers_margin_top',
            'type'    => 'text',
        ) );
        $wp_customize->add_control(  'vc_fonts_and_style_headers_margin_bottom', array(
            'label'   => __( 'Margin Bottom', 'visual-composer-theme' ),
            'section' => 'vc_fonts_and_style_headers',
            'settings'   => 'vc_fonts_and_style_headers_margin_bottom',
            'type'    => 'text',
        ) );
        $wp_customize->add_control(  'vc_fonts_and_style_headers_capitalization', array(
            'label'   => __( 'Capitalization', 'visual-composer-theme' ),
            'section' => 'vc_fonts_and_style_headers',
            'settings'   => 'vc_fonts_and_style_headers_capitalization',
            'type'    => 'select',
            'choices'  => array(
                'uppercase' => __( 'Uppercase', 'visual-composer-theme' ),
                'lowercase' => __( 'Lowercase', 'visual-composer-theme' ),
                'capitalize' => __( 'Capitalize (default)', 'visual-composer-theme' ),
            ),
        ) );


    }
}