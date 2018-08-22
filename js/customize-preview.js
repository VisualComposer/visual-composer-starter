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

	// Woocmmerce sale icon
	wp.customize( 'woo_on_sale_color', function( value ) {
		value.bind( function( newval ) {
			if ( newval ) {
				$( '.vct-sale svg>g>g' ).css( 'fill', newval );
			} else {
				$( '.vct-sale svg>g>g' ).css( 'fill', '#FAC917' );
			}
		} );
	} );

})( window.jQuery );
