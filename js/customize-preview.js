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

	// Woocmmerce header cart color
	wp.customize( 'woo_cart_color', function( value ) {
		value.bind( function( newval ) {
			if ( newval ) {
				$( '.visualcomposerstarter .vct-cart-items-count' ).css( { 'background-color': newval } );
				$( '.visualcomposerstarter .vct-cart-wrapper svg g>g ' ).css( 'fill', newval );
			} else {
				$( '.visualcomposerstarter .vct-cart-items-count' ).css( { 'background-color': '#2b4b80' } );
				$( '.visualcomposerstarter .vct-cart-wrapper svg g>g ' ).css( 'fill', '#2b4b80' );
			}
		} );
	} );

	// Woocmmerce header cart text color
	wp.customize( 'woo_cart_text_color', function( value ) {
		value.bind( function( newval ) {
			if ( newval ) {
				$( '.visualcomposerstarter .vct-cart-items-count' ).css( { 'color': newval } );
			} else {
				$( '.visualcomposerstarter .vct-cart-items-count' ).css( { 'color': '#fff' } );
			}
		} );
	} );

	// Woocmmerce price tag color
	wp.customize( 'woo_price_tag_color', function( value ) {
		value.bind( function( newval ) {
			if ( newval ) {
				$( '\t.visualcomposerstarter.woocommerce ul.products li.product .price,\n\t.visualcomposerstarter.woocommerce div.product p.price,\n\t.visualcomposerstarter.woocommerce div.product p.price ins,\n\t.visualcomposerstarter.woocommerce div.product span.price,\n\t.visualcomposerstarter.woocommerce div.product span.price ins,\n\t.visualcomposerstarter.woocommerce.widget .quantity,\n\t.visualcomposerstarter.woocommerce.widget del,\n\t.visualcomposerstarter.woocommerce.widget ins,\n\t.visualcomposerstarter.woocommerce.widget span.woocommerce-Price-amount.amount,\n\t.visualcomposerstarter.woocommerce p.price ins,\n\t.visualcomposerstarter.woocommerce p.price,\n\t.visualcomposerstarter.woocommerce span.price,\n\t.visualcomposerstarter.woocommerce span.price ins,\n\t.visualcomposerstarter .woocommerce.widget span.amount,\n\t.visualcomposerstarter .woocommerce.widget ins' ).css( { 'color': newval } );
			} else {
				$( '\t.visualcomposerstarter.woocommerce ul.products li.product .price,\n\t.visualcomposerstarter.woocommerce div.product p.price,\n\t.visualcomposerstarter.woocommerce div.product p.price ins,\n\t.visualcomposerstarter.woocommerce div.product span.price,\n\t.visualcomposerstarter.woocommerce div.product span.price ins,\n\t.visualcomposerstarter.woocommerce.widget .quantity,\n\t.visualcomposerstarter.woocommerce.widget del,\n\t.visualcomposerstarter.woocommerce.widget ins,\n\t.visualcomposerstarter.woocommerce.widget span.woocommerce-Price-amount.amount,\n\t.visualcomposerstarter.woocommerce p.price ins,\n\t.visualcomposerstarter.woocommerce p.price,\n\t.visualcomposerstarter.woocommerce span.price,\n\t.visualcomposerstarter.woocommerce span.price ins,\n\t.visualcomposerstarter .woocommerce.widget span.amount,\n\t.visualcomposerstarter .woocommerce.widget ins' ).css( { 'color': '#2b4b80' } );
			}
		} );
	} );

	// Woocmmerce old price tag color
	wp.customize( 'woo_old_price_tag_color', function( value ) {
		value.bind( function( newval ) {
			if ( newval ) {
				$( '\t.visualcomposerstarter.woocommerce span.price del,\n\t.visualcomposerstarter.woocommerce p.price del,\n\t.visualcomposerstarter.woocommerce p.price del span,\n\t.visualcomposerstarter.woocommerce span.price del span,\n\t.visualcomposerstarter .woocommerce.widget del,\n\t.visualcomposerstarter .woocommerce.widget del span.amount,\n\t.visualcomposerstarter.woocommerce ul.products li.product .price del ' ).css( { 'color': newval } );
			} else {
				$( '\t.visualcomposerstarter.woocommerce span.price del,\n\t.visualcomposerstarter.woocommerce p.price del,\n\t.visualcomposerstarter.woocommerce p.price del span,\n\t.visualcomposerstarter.woocommerce span.price del span,\n\t.visualcomposerstarter .woocommerce.widget del,\n\t.visualcomposerstarter .woocommerce.widget del span.amount,\n\t.visualcomposerstarter.woocommerce ul.products li.product .price del ' ).css( { 'color': '#d5d5d5' } );
			}
		} );
	} );

	// Woocmmerce link color
	wp.customize( 'woo_link_color', function( value ) {
		value.bind( function( newval ) {
			if ( newval ) {
				$( '\t.visualcomposerstarter.woocommerce div.product .entry-categories a,\n\t.visualcomposerstarter.woocommerce div.product .woocommerce-tabs ul.tabs li:not(.active) a' ).css( { 'color': newval } );
			} else {
				$( '\t.visualcomposerstarter.woocommerce div.product .entry-categories a,\n\t.visualcomposerstarter.woocommerce div.product .woocommerce-tabs ul.tabs li:not(.active) a' ).css( { 'color': '#d5d5d5' } );
			}
		} );
	} );

	// Woocmmerce outline button color
	wp.customize( 'woo_outline_button_color', function( value ) {
		value.bind( function( newval ) {
			if ( newval ) {
				$( '.woocommerce button.button[name="update_cart"],\n\t.button[name="apply_coupon"],\n\t.vct-checkout-button,\n\t.woocommerce button.button:disabled, \n\t.woocommerce button.button:disabled[disabled]' ).css( { 'color': newval } );
			} else {
				$( '.woocommerce button.button[name="update_cart"],\n\t.button[name="apply_coupon"],\n\t.vct-checkout-button,\n\t.woocommerce button.button:disabled, \n\t.woocommerce button.button:disabled[disabled]' ).css( { 'color': '#4e4e4e' } );
			}
		} );
	} );

	// Woocmmerce price filder widget
	wp.customize( 'woo_price_filter_widget_color', function( value ) {
		value.bind( function( newval ) {
			if ( newval ) {
				$( '\t.visualcomposerstarter .woocommerce.widget.widget_price_filter .ui-slider .ui-slider-handle,\n\t.visualcomposerstarter .woocommerce.widget.widget_price_filter .ui-slider .ui-slider-range' ).css( { 'background-color': newval } );
			} else {
				$( '\t.visualcomposerstarter .woocommerce.widget.widget_price_filter .ui-slider .ui-slider-handle,\n\t.visualcomposerstarter .woocommerce.widget.widget_price_filter .ui-slider .ui-slider-range' ).css( { 'background-color': '#2b4b80' } );
			}
		} );
	} );

	// Woocmmerce widget link color
	wp.customize( 'woo_widget_links_color', function( value ) {
		value.bind( function( newval ) {
			if ( newval ) {
				$( '.visualcomposerstarter .woocommerce.widget li a' ).css( { 'color': newval } );
			} else {
				$( '.visualcomposerstarter .woocommerce.widget li a' ).css( { 'color': '#000' } );
			}
		} );
	} );

})( window.jQuery );
