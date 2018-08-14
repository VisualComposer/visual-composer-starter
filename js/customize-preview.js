(function( $ ) {

	/* Update data in real time. */

	// Site title
	wp.customize( 'blogname', function( value ) {
		value.bind( function( newval ) {
			$( '.navbar-brand h1 a' ).html( newval );
		} );
	} );

	// Woocmmerce cart icon
	wp.customize( 'woocommerce_header_cart_icon', function( value ) {
		value.bind( function( newval ) {
			if ( newval ) {
				$( '.vct-cart-wrapper' ).show();
			} else {
				$( '.vct-cart-wrapper' ).hide();
			}
		} );
	} );

})( window.jQuery );
