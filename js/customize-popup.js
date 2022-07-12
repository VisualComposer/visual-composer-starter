( function( $, document, window, wp ) {
	var popupElement = null;

	var handlePopupClose = function( e ) {
		e && e.preventDefault && e.preventDefault();
		closePopup();
	};

	var closePopup = function() {
		popupElement.style = 'display: none;';
	};

	var handleOpenPopup = function( id ) {
		popupElement = document.getElementById( id );
		if ( popupElement ) {
			popupElement.style = 'display: flex;';
		}
	};

	var fontSettings = [
		'vct_fonts_and_style_h1_font_family',
		'vct_fonts_and_style_h2_font_family',
		'vct_fonts_and_style_h3_font_family',
		'vct_fonts_and_style_h4_font_family',
		'vct_fonts_and_style_h5_font_family',
		'vct_fonts_and_style_h6_font_family',
		'vct_fonts_and_style_body_font_family',
		'vct_fonts_and_style_buttons_font_family'
	];

	var changedFonts = {};

	window.vctHandleOpenPopup = handleOpenPopup;

	wp.customize.bind( 'ready', function() {
		wp.customize.bind( 'change', function( setting ) {
			if ( fontSettings.includes( setting.id ) ) {
				changedFonts[setting.id] = setting.get();
			}
		} );
	} );

	$( function() {

		// Handle click on "Publish"
		$( '#save' ).off( 'click' ).on( 'click', function( e ) {

			// Make sure all font are downloaded if changed any
			if ( ! $.isEmptyObject( changedFonts ) ) {
				$.post( window.ajaxurl, {
					'action': 'vct_check_fonts',
					'security': window.googleFontControlData.nonce,
					'fonts': changedFonts
				} ).fail( function( xhr ) {
					window.alert( xhr.responseText );
				} ).done( function( response ) {
					var data = response.data;
					if ( false === response.success ) {
						window.alert( data );
					} else {

						// All fonts are downloaded: just save
						if ( data.hasOwnProperty( 'all_fonts_exists' ) && true === data.all_fonts_exists ) {
							wp.customize.previewer.save();
						} else if ( data.hasOwnProperty( 'at_least_one_missing' ) && true === data.at_least_one_missing ) {

							// Show popup
							window.vctHandleOpenPopup( 'vct-popup' );
						}
					}
				} );
			} else {
				wp.customize.previewer.save();
			}

			e.preventDefault();
		} );
	} );

	// Download fonts
	$( document ).on( 'click', '#vct-popup-accept-button', function( e ) {
		var $downloadBtn = $( this );
		var $revertBtn = $downloadBtn.siblings( 'button' );
		var $spinner = $downloadBtn.parents( '.vct-popup-buttons' ).siblings( '.vct-spinner-wrapper' );

		e && e.preventDefault && e.preventDefault();

		if ( ! $.isEmptyObject( changedFonts ) ) {
			$.ajax( {
				method: 'POST',
				url: window.ajaxurl,
				beforeSend: function() {
					$downloadBtn.prop('disabled', true);
					$revertBtn.prop('disabled', true);
					$spinner.show();
				},
				data: {
					'action': 'vct_download_fonts',
					'security': window.googleFontControlData.nonce,
					'fonts': changedFonts
				}
			} ).fail( function( xhr ) {
				window.alert( xhr.responseText );
			} ).done( function( response ) {
				if ( false === response.success ) {
					window.alert( response.data );
				} else {
					closePopup();
					wp.customize.previewer.refresh();

					// Hide messages from all "font-family" fields
					$.each( fontSettings, function( id, settingId ) {
						wp.customize.control( settingId, function( control ) {
							var message = $( control.container.find( '#_customize-message-' + control.id ) );
							if ( message ) {
								message.hide();
							}
						} );
					} );

					// Save settings
					wp.customize.previewer.save();
				}

				$downloadBtn.prop( 'disabled', false );
				$revertBtn.prop( 'disabled', false );
				$spinner.hide();
			} );
		} else {
			wp.customize.previewer.save();
		}
	} );

	// Handle click of "Revert" button
	$( document ).on( 'click', '#vct-popup-cancel-button', function( e ) {
		var previousFonts = window.vctCurrentFonts;
		e && e.preventDefault && e.preventDefault();
		if ( ! $.isEmptyObject( changedFonts ) && ! $.isEmptyObject( previousFonts ) ) {
			$.each( changedFonts, function( id ) {
				if ( previousFonts.hasOwnProperty( id ) ) {
					wp.customize( id, function( setting ) {
						setting.set( previousFonts[id] );
					} );
				}
			} );
		}

		closePopup();
		wp.customize.previewer.save();
	} );

	// Close popup
	$( document ).on( 'click', '.vct-popup-close', handlePopupClose );
}( jQuery, document, window, window.wp ) );

