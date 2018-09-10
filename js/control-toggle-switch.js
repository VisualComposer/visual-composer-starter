(function( $ ) {

    // Available social icons
    var vctSocialIcons = [
        'facebook',
        'twitter',
        'linkedin',
        'instagram',
        'pinterest',
        'youtube',
        'vimeo',
        'flickr',
        'github',
        'email'
    ];
    function isToggleTrue( el ) {
        return $( el ).prop( 'checked' );
    }

    function hideHeaderSection () {
        $( '#accordion-section-vct_header_and_menu_area' ).addClass( 'hiddenSection' );
    }

    function showHeaderSection () {
        $( '#accordion-section-vct_header_and_menu_area' ).removeClass( 'hiddenSection' );
    }

    function hideFooterSection () {
        $( '#accordion-section-vct_footer_area' ).addClass( 'hiddenSection' );
    }

    function showFooterSection () {
        $( '#accordion-section-vct_footer_area' ).removeClass( 'hiddenSection' );
    }

    function hideSocialIcons() {
        $.each( vctSocialIcons, function( key, icon ) {
            $( '#customize-control-vct_footer_area_social_link_' + icon ).hide();
        });
    }

    function showSocialIcons() {
        $.each( vctSocialIcons, function( key, icon ) {
            $( '#customize-control-vct_footer_area_social_link_' + icon ).show();
        });
    }

    function hideNumberOfColumns() {
        $( '#customize-control-vct_footer_area_widgetized_columns' ).hide();
    }

    function showNumberOfColumns() {
        $( '#customize-control-vct_footer_area_widgetized_columns' ).show();
    }

    function hideFeaturedImageSettings() {
        $( '#customize-control-vct_overall_site_featured_image_width' ).hide();
        $( '#customize-control-vct_overall_site_featured_image_height' ).hide();
        $( '#customize-control-vct_overall_site_featured_image_custom_height' ).hide();
    }

    function showFeaturedImageSettings() {
        $( '#customize-control-vct_overall_site_featured_image_width' ).show();
        $( '#customize-control-vct_overall_site_featured_image_height' ).show();
        if ( 'custom' === $( 'select[data-customize-setting-link="vct_overall_site_featured_image_height"]' ).val() ) {
            $( '#customize-control-vct_overall_site_featured_image_custom_height' ).show();
        }
    }

    function hideBackgroundImageSettings () {
        $( '#customize-control-vct_overall_site_bg_image' ).hide();
        $( '#customize-control-vct_overall_site_bg_image_style' ).hide();
    }

    function showBackgroundImageSettings () {
        $( '#customize-control-vct_overall_site_bg_image' ).show();
        $( '#customize-control-vct_overall_site_bg_image_style' ).show();
    }

    wp.customize.controlConstructor['toggle-switch'] = wp.customize.Control.extend( {
        ready: function() {
            var control = this;
			var value = ( undefined !== control.setting._value ) ? control.setting._value : '';

            /**
             * Social Icons
             */
            this.container.on( 'change', 'input:checkbox', function() {
                var $this = $( this );
                value = isToggleTrue( this );
                if ( 'vct_overall_site_disable_header' === $this.attr( 'id' ) ) {
                    if ( ! value ) {
                        showHeaderSection();
                    } else {
                        hideHeaderSection();
                    }
                }
                if ( 'vct_overall_site_disable_footer' === $this.attr( 'id' ) ) {
                    if ( ! value ) {
                        showFooterSection();
                    } else {
                        hideFooterSection();
                    }
                }
                if ( 'vct_footer_area_social_icons' === $this.attr( 'id' ) ) {
                    if ( ! value ) {
                        hideSocialIcons();
                    } else {
                        showSocialIcons();
                    }
                }
                if ( 'vct_footer_area_widget_area' === $this.attr( 'id' ) ) {
                    if ( ! value ) {
                        hideNumberOfColumns();
                    } else {
                        showNumberOfColumns();
                    }
                }
                if ( 'vct_overall_site_featured_image' === $this.attr( 'id' ) ) {
                    if ( ! value ) {
                        hideFeaturedImageSettings();
                    } else {
                        showFeaturedImageSettings();
                    }
                }
                if ( 'vct_overall_site_featured_image_height' === $this.attr( 'id' ) ) {
                    if ( ! value ) {
                        hideFeaturedImageSettings();
                    } else {
                        showFeaturedImageSettings();
                    }
                }

                if ( 'vct_overall_site_enable_bg_image' === $this.attr( 'id' ) ) {
                    if ( ! value ) {
                        hideBackgroundImageSettings();
                    } else {
                        showBackgroundImageSettings();
                    }
                }
                control.setting.set( value );

				if ( 'woocommerce_header_cart_icon' !== $this.attr( 'id' ) ) {

					// Refresh the preview
					wp.customize.previewer.refresh();
				}
            });
        }

    });

    $( document ).ready( function() {
        if ( isToggleTrue( '#vct_overall_site_disable_header' ) ) {
            hideHeaderSection();
        }
        if ( isToggleTrue( '#vct_overall_site_disable_footer' ) ) {
            hideFooterSection();
        }
        if ( ! isToggleTrue( '#vct_footer_area_social_icons' ) ) {
            hideSocialIcons();
        }
        if ( ! isToggleTrue( '#vct_footer_area_widget_area' ) ) {
            hideNumberOfColumns();
        }
        if ( ! isToggleTrue( '#vct_overall_site_featured_image' ) ) {
            hideFeaturedImageSettings();
        }
        if ( ! isToggleTrue( '#vct_overall_site_enable_bg_image' ) ) {
            hideBackgroundImageSettings();
        }
		if ( ! isToggleTrue( '#woocommerce_header_cart_icon' ) ) {
			$( '#customize-control-woo_cart_color' ).hide();
			$( '#customize-control-woo_cart_text_color' ).hide();
		}
    });

	// Woocmmerce cart icon dependency
	wp.customize( 'woocommerce_header_cart_icon', function( value ) {
		value.bind( function( newval ) {
			if ( newval ) {
				$( '#customize-control-woo_cart_color' ).show();
				$( '#customize-control-woo_cart_text_color' ).show();
			} else {
				$( '#customize-control-woo_cart_color' ).hide();
				$( '#customize-control-woo_cart_text_color' ).hide();
			}
		} );
	} );
})( window.jQuery );
