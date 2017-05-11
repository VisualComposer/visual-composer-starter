(function( $ ) {
    function showFeaturedImageCustomHeight() {
        $( '#customize-control-vct_overall_site_featured_image_custom_height' ).show();
    }

    function hideFeaturedImageCustomHeight() {
        $( '#customize-control-vct_overall_site_featured_image_custom_height' ).hide();
    }

    wp.customize.controlConstructor.select = wp.customize.Control.extend({
        ready: function() {

            this.container.on( 'change', 'select', function() {

                var $this = $( this );
                if ( 'vct_overall_site_featured_image_height' === $this.attr( 'data-customize-setting-link' ) ) {
                    if ( 'custom' === $this.val() ) {
                        showFeaturedImageCustomHeight();
                    } else {
                        hideFeaturedImageCustomHeight();
                    }
                }

                // Refresh the preview
                wp.customize.previewer.refresh();
            });
        }

    });

    $( document ).ready(function() {
        if ( 'custom' !== $( 'select[data-customize-setting-link="vct_overall_site_featured_image_height"]' ).val() ) {
            hideFeaturedImageCustomHeight();
        }
    });
})( window.jQuery );
