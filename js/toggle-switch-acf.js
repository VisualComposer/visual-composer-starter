(function( $ ) {
    $( document ).ready( function() {
        $( '#acf-hide_page_title, #acf-hide_post_title, #acf-disable_page_header, #acf-disable_page_footer, #acf-disable_post_header, #acf-disable_post_footer' ).addClass( 'acf-toggle-wrap' );

        $( '.acf-toggle-wrap .acf-checkbox-list' ).each( function() {
            var currentObject = $( this );
            var checkboxID = currentObject.find( 'input[type=checkbox]' ).attr( 'id' );
            var checkboxClone = $( '#' + checkboxID ).clone().addClass( 'onoffswitch-checkbox' );
            var toggleSwitchHTML = '<div class="onoffswitch">' +
                checkboxClone[0].outerHTML +
                '<label class="onoffswitch-label" for="' + checkboxID + '">' +
                    '<span class="onoffswitch-inner"></span><span class="onoffswitch-switch"></span>' +
                '</label>' +
                '</div>';

            currentObject.find( 'li' ).html( toggleSwitchHTML );
        });
    });
} )( window.jQuery );
