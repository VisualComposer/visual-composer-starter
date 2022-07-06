( function( $, document, window, wp ) {
	let popupElement = null;

	const handlePopupClose = ( e ) => {
		e && e.preventDefault && e.preventDefault();
		closePopup();
	};

	const closePopup = () => {
		popupElement.style = 'display: none;';
	};

	const handleOpenPopup = ( id ) => {
		popupElement = document.getElementById( id );
		if ( popupElement ) {
			popupElement.style = 'display: flex;';
		}
	};

	window.vctHandleOpenPopup = handleOpenPopup;

	const fontSettings = [
		'vct_fonts_and_style_h1_font_family',
		'vct_fonts_and_style_h2_font_family',
		'vct_fonts_and_style_h3_font_family',
		'vct_fonts_and_style_h4_font_family',
		'vct_fonts_and_style_h5_font_family',
		'vct_fonts_and_style_h6_font_family',
		'vct_fonts_and_style_body_font_family',
		'vct_fonts_and_style_buttons_font_family'
	];

	let changedFonts = {};

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
				} ).fail( function( xhr, status, error ) {
					alert( xhr.responseText );
				} ).done( function( response ) {
					if ( false === response.success ) {
						alert( response.data );
					} else {
						let data = response.data;

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
		e && e.preventDefault && e.preventDefault();
		if ( ! $.isEmptyObject( changedFonts ) ) {
			$.post( window.ajaxurl, {
				'action': 'vct_download_fonts',
				'security': window.googleFontControlData.nonce,
				'fonts': changedFonts
			} ).fail( function( xhr, status, error ) {
				alert( xhr.responseText );
			} ).done( function( response ) {
				if ( false === response.success ) {
					alert( response.data );
				} else {
					closePopup();
					wp.customize.previewer.save();
				}
			} );
		} else {
			wp.customize.previewer.save();
		}
	} );

	// Handle click of "Revert" button
	$( document ).on( 'click', '#vct-popup-cancel-button', function( e ) {
		e && e.preventDefault && e.preventDefault();
		let previousFonts = window.vctCurrentFonts;
		if ( ! $.isEmptyObject( changedFonts ) && ! $.isEmptyObject( previousFonts ) ) {
			$.each( changedFonts, function( id, value ) {
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

