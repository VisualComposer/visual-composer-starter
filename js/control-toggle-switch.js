var social_icons = [
    'facebook',
    'twitter',
    'linkedin',
    'instagram',
    'pinterest',
    'youtube',
    'vimeo',
    'flickr',
    'github',
    'email' ]; // available social icons

function isToggleTrue(_this) {
    return jQuery( _this ).prop( 'checked' );
}

function hideSocialIcons() {
    jQuery.each( social_icons, function( key, icon ) {
        jQuery( '#customize-control-vct_footer_area_social_link_' + icon ).hide();
    });
}

function showSocialIcons() {
    jQuery.each( social_icons, function( key, icon ) {
        jQuery( '#customize-control-vct_footer_area_social_link_' + icon ).show();
    });
}

function hideNumberOfColumns() {
    jQuery( '#customize-control-vct_footer_area_widgetized_columns' ).hide();
}

function showNumberOfColumns() {
    jQuery( '#customize-control-vct_footer_area_widgetized_columns' ).show();
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
            if( jQuery( this ).attr( 'id' ) === 'vct_footer_area_social_icons' ) {
                if( ! value ) {
                    hideSocialIcons();
                }
                else
                {
                    showSocialIcons();
                }
            }
            if( jQuery( this ).attr( 'id' ) === 'vct_footer_area_widget_area' ) {
                if( ! value ) {
                    hideNumberOfColumns();
                }
                else
                {
                    showNumberOfColumns();
                }
            }

            control.setting.set( value );
            // refresh the preview
            wp.customize.previewer.refresh();
        } );
    }

});

jQuery( document ).ready(function() {
    if( !isToggleTrue( '#vct_footer_area_social_icons' ) ) {
        hideSocialIcons();
    }
    if( !isToggleTrue( '#vct_footer_area_widget_area' ) ) {
        hideNumberOfColumns();
    }
});