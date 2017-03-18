(function( $ ) {
    // Available social icons
    var vct_social_icons = [
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
        return $(el).prop('checked');
    }

    function hideSocialIcons() {
        $.each( vct_social_icons, function( key, icon ) {
            $( '#customize-control-vct_footer_area_social_link_' + icon ).hide();
        });
    }

    function showSocialIcons() {
        $.each( vct_social_icons, function( key, icon ) {
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
        if ( $( 'select[data-customize-setting-link="vct_overall_site_featured_image_height"]' ).val() === 'custom' ) {
            $( '#customize-control-vct_overall_site_featured_image_custom_height' ).show();
        }
    }

    wp.customize.controlConstructor['toggle-switch'] = wp.customize.Control.extend( {
        ready: function() {
            var control = this;
            var value = ( undefined !== control.setting._value ) ? control.setting._value : '';

            /**
             * Social Icons
             */
            this.container.on( 'change', 'input:checkbox', function() {
                value = isToggleTrue( this );
                var $this = $( this );
                if ( $this.attr( 'id' ) === 'vct_footer_area_social_icons' ) {
                    if ( !value ) {
                        hideSocialIcons();
                    } else {
                        showSocialIcons();
                    }
                }
                if ( $this.attr( 'id' ) === 'vct_footer_area_widget_area' ) {
                    if ( !value ) {
                        hideNumberOfColumns();
                    } else {
                        showNumberOfColumns();
                    }
                }
                if ( $this.attr( 'id' ) === 'vct_overall_site_featured_image' ) {
                    if ( !value ) {
                        hideFeaturedImageSettings();
                    } else {
                        showFeaturedImageSettings();
                    }
                }
                if ( $this.attr( 'id' ) === 'vct_overall_site_featured_image_height' ) {
                    if ( !value ) {
                        hideFeaturedImageSettings();
                    } else {
                        showFeaturedImageSettings();
                    }
                }
                control.setting.set( value );
                // refresh the preview
                wp.customize.previewer.refresh();
            });
        }

    });

    $( document ).ready( function() {
        if ( !isToggleTrue( '#vct_footer_area_social_icons' ) ) {
            hideSocialIcons();
        }
        if ( !isToggleTrue('#vct_footer_area_widget_area') ) {
            hideNumberOfColumns();
        }
        if ( !isToggleTrue('#vct_overall_site_featured_image') ) {
            hideFeaturedImageSettings();
        }
    });
})( window.jQuery );
