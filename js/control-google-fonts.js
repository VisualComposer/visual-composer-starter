(function( $, wp, document, window ) {
    wp.customize.controlConstructor['google-fonts'] = wp.customize.Control.extend({
        ready: function() {
			const control = this;
			const setting = this.setting;

	        let message = $( control.container.find( '#_customize-message-' + control.id ) );

	        // Fonts from Google CDN should be hosted locally to comply with GDPR.
	        // Check whether it is required to show a message with download link for the user.
	        this.setting.bind( function ( value ) {
		        $.post( window.ajaxurl, {
			        'action': 'vct_check_font',
			        'security': window.googleFontControlData.nonce,
			        'font': value,
		        } ).fail( function ( xhr, status, error ) {
			        wp.customize.notifications.add( 'vct_check_font_ajax', {
				        type: 'error',
				        message: xhr.responseText
			        } )
		        } ).done( function ( response ) {
			        if ( false === response.success ) {
				        wp.customize.notifications.add( 'vct_fail_to_check_font', {
					        type: 'warning',
					        message: response.data
				        } );
			        } else {
				        let isGoogleFont = response.data.isGoogleFont;
				        let existsLocally = response.data.existsLocally;
				        if ( isGoogleFont && existsLocally ) {
					        // Refresh the preview
					        wp.customize.previewer.refresh();
					        message.hide();
				        } else if ( isGoogleFont && !existsLocally ) {
					        message.show();
				        } else {
					        message.hide();
				        }
			        }
		        } ).always( function () {
			        wp.customize.notifications.remove( 'vct_check_font_ajax' );
			        wp.customize.notifications.remove( 'vct_fail_to_check_font' );
		        } );
	        } );

	        // Handle click on a "download" button
	        this.container.on( 'click', '[data-vct-download-font]', function ( e ) {
				e.preventDefault();
		        $.post( window.ajaxurl, {
			        'action': 'vct_download_font',
			        'security': window.googleFontControlData.nonce,
			        'font': setting.get(),
		        } ).fail( function ( xhr, status, error ) {
			        wp.customize.notifications.add( 'vct_download_font_ajax', {
				        type: 'error',
				        message: xhr.responseText
			        } )
		        } ).done( function ( response ) {
			        if ( false === response.success ) {
				        wp.customize.notifications.add( 'vct_failed_to_download_font', {
					        type: 'warning',
					        message: response.data
				        } );
			        } else {
				        // Refresh the preview
				        wp.customize.previewer.refresh();
				        message.hide();
			        }
		        } ).always( function () {
			        wp.customize.notifications.remove( 'vct_check_font_ajax' );
			        wp.customize.notifications.remove( 'vct_fail_to_check_font' );
		        } );
	        } );
        }
    });
})( jQuery, wp, document, window );
