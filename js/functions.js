( function( $ ) {
    var $body = $( 'body' );
    var $mainMenu = $( '#main-menu' );
    var $navBar = $( 'nav.navbar' );
    var $header = $( '#header' );
    var $footerRightBlock = $( '.footer-right-block' );
    var $footerLeftBlock = $( '.footer-left-block' );
    var windowHeight, featuredImageHeight, navbarHeight, subMenu, subMenuRect;
    var menuItems = $( '.menu-item.menu-item-has-children' );
    var menuItemLinks = $( '.menu-item.menu-item-has-children > a' );
    var vcThemeVars = window.visualcomposerstarter;

    // Add dropdown toggle that displays child menu items.
    var $dropdownToggle = $( '<button />', {
        'class': 'dropdown-toggle vct-icon-dropdown'
    } );

    $( 'img[data-src]' ).each( function() {
        var $this = $( this );
        $this.attr( 'src', $this.attr( 'data-src' ) );
        $this.load( function() {
            $this.removeAttr( 'data-src' );
        } );
    } );

    $mainMenu.find( '.menu-item-has-children > a' ).after( $dropdownToggle );

    // Header without background
    if ( $body.hasClass( 'navbar-no-background' ) ) {
        $header.css( { minHeight: $navBar.outerHeight() } );
    }

    // Fixed header
    if ( $body.hasClass( 'fixed-header' ) ) {
        $navBar.addClass( 'fixed' );
        if ( ! $body.hasClass( 'navbar-no-background' ) ) {
            $body.css( { paddingTop: $navBar.outerHeight() } );
        } else {
            if ( $( window ).scrollTop() > 0 ) {
                $navBar.addClass( 'scroll' );
            }
        }
    }

    $( window ).scroll( function() {
        if ( $( window ).scrollTop() > 0 ) {
            if ( $body.hasClass( 'navbar-no-background' ) ) {
                $navBar.addClass( 'scroll' );
            }
        } else {
            if ( $body.hasClass( 'navbar-no-background' ) ) {
                $navBar.removeClass( 'scroll' );
            }
        }
    } );

    // Sandwich menu
    if ( $( window ).width() < 768 ) {
        $body.addClass( 'mobile' );
    }

    // Footer social icons vertical align
    if ( $( window ).width() >= 992 ) {
        $footerRightBlock.height( $footerLeftBlock.height() );
    }

    $( window ).on( 'load', function() {

        //Full height featured images
        if ( $body.hasClass( 'featured-image-full-height' ) ) {
            windowHeight = $( window ).height();
            navbarHeight = $navBar.height();
            if ( $body.hasClass( 'navbar-no-background' ) ) {
                featuredImageHeight = windowHeight;
            } else {
                featuredImageHeight = windowHeight - navbarHeight;
            }
            $( '.header-image .fade-in-img' ).css( { height: featuredImageHeight + 'px' } );
            $( '.header-image .fade-in-img' ).addClass( 'cover-image' );
        }
    } );

    $( window ).on( 'resize', function() {
        var $this = $( this );

        //Fixed header
        if ( $body.hasClass( 'fixed-header' ) && ! $body.hasClass( 'navbar-no-background' ) ) {
            $body.css( { paddingTop: $navBar.outerHeight() } );
        }

        //Header no-background
        if ( $body.hasClass( 'navbar-no-background' ) ) {
            $header.css( { minHeight: $navBar.outerHeight() } );
        }

        //Sandwich menu
        if ( $this.width() < 768 ) {
            $body.addClass( 'mobile' );
        } else {
            $body.removeClass( 'mobile' );
        }

        //Full height featured images
        if ( $body.hasClass( 'featured-image-full-height' ) ) {
            windowHeight = $( window ).height();
            navbarHeight = $navBar.height();
            if ( $body.hasClass( 'navbar-no-background' ) ) {
                featuredImageHeight = windowHeight;
            } else {
                featuredImageHeight = windowHeight - navbarHeight;
            }
            $( '.header-image' ).css( { height: featuredImageHeight + 'px' } );
        }

        // Footer social icons vertical align
        if ( $this.width() > 992 ) {
            $footerRightBlock.height( $footerLeftBlock.outerHeight() );
        } else {
            $footerRightBlock.height( 'auto' );
        }
    } );

    // Sandwich menu
    $( document ).on( 'click', '.dropdown-toggle', function() {
        var $this = $( this );
        $this.siblings( 'ul' ).slideToggle( 600 );
        $this.toggleClass( 'open' );
        return false;
    } );

    $( document ).on( 'click', '.navbar-toggle', function() {
        var $this = $( this );
        $this.fadeOut( 'fast' );
        $mainMenu.addClass( 'open' );
    } );

    $( document ).on( 'click', '#main-menu .button-close', function() {
        $( '.navbar-toggle' ).show();
        $mainMenu.removeClass( 'open' );
    } );

    $( document ).on( 'click', '#main-menu li', function() {
        $( '.navbar-toggle' ).show();
        $( '#main-menu' ).removeClass( 'open' );
    } );

    //Gallery Slider
    $( '.gallery-slider' ).slick( {
        autoplay: true,
        arrows: false,
        dots: true,
        adaptiveHeight: true
    } );

    // Set scroller to submenu when submenu height is bigger than screen height
    if ( 'fixed' === $navBar.css( 'position' ) ) {
        menuItems.each( function( index, item ) {
            item.addEventListener( 'mouseenter', function() {
                if ( window.innerWidth < 768 ) {
                    return;
                }

                subMenu = item.querySelector( '.sub-menu' );
                if ( subMenu ) {
                    subMenuRect = subMenu.getBoundingClientRect();

                    if ( subMenuRect.top + subMenuRect.height > window.innerHeight ) {
                        subMenu.style.maxHeight = window.innerHeight - subMenuRect.top + 'px';
                        subMenu.style.overflow = 'auto';
                    }
                }
            }, false );

            item.addEventListener( 'mouseleave', function() {
                if ( window.innerWidth < 768 ) {
                    return;
                }

                subMenu = item.querySelector( '.sub-menu' );
                if ( subMenu ) {
                    subMenu.style.maxHeight = '';
                    subMenu.style.overflow = '';
                }
            } );
        } );
    }

    // Prevent click on menu links before sub menu is opened
    menuItemLinks.on( 'click', function( e ) {
        if ( 'hidden' === $( this ).siblings( '.sub-menu' ).css( 'visibility' ) ) {
            e.preventDefault();
        }
    } );

    $( document.body ).on( 'added_to_cart', function() {
      $.ajax({
        url: vcThemeVars.ajax_url,
        data: {
          'action': 'visualcomposerstarter_woo_cart_count',
          'nonce': vcThemeVars.nonce
        },
        success: function( data ) {
          $( '.vct-cart-items-count' ).html( data );
        }
      });
    });

    // Handle click on quantity input controls
    $body.on( 'click', '.vct-input-qty-control', function() {
      var $this = $( this ),
          $qtyContainer = $this.closest( '.vct-input-qty' ),
          $currentInput = $qtyContainer.find( '.qty' ),
		  currentValue = parseInt( $currentInput.val(), 10 ),
		  value = currentValue,
		  minValue = parseInt( $currentInput.attr( 'min' ), 10 );
      if ( $this.hasClass( 'vct-input-qty-control-add' ) ) {
        value = ++currentValue;
        $currentInput.trigger( 'change' );
      }
      if ( $this.hasClass( 'vct-input-qty-control-remove' ) && currentValue > minValue ) {
        value = --currentValue;
        $currentInput.trigger( 'change' );
      }
      $currentInput.val( value );
    });

    // Handle click on message close control
    $body.on( 'click', '.vct-close-woocommerce-msg', function() {
      var $this = $( this ),
          parentSelector = $this.data( 'parent' ),
          $parentMessage = $this.closest( '.' + parentSelector );
      $parentMessage.remove();
    });

    // Toggle custom coupon code field
    $( document ).on( 'click', '#vct-show-promo-form', function() {
    $( this ).parent().toggleClass( 'vct-visible' ).find( '.vct-promo-content' ).slideToggle( 500 );
      return false;
    });

    $( '#vct-promo-code' ).keyup(function() {
      $( '#coupon_code' ).val( this.value );
    });

    // Copy coupon code to the default input field
    $( document ).on( 'click', '#vct-apply-promo-code', function() {
      $( '#coupon_code' ).val( $( '#vct-promo-code' ).val() );
      $( '#vct-submit-coupon' ).trigger( 'click' );
      return false;
    });

    // Remove the coupon code
    $( document ).on( 'click', '.woocommerce-remove-coupon', function() {
      $( '#vct-promo-code' ).val( '' );
      return false;
    });

    // Enable coupon visibility if it is set so in Customizer settings
    if ( vcThemeVars && vcThemeVars.woo_coupon_form && '1' === vcThemeVars.woo_coupon_form ) {
      $( '.vct-promo' ).addClass( 'vct-visible' );
      $( '.vct-promo' ).find( '.vct-promo-content' ).show();
    }

    // Handle click on Add to cart button
    $body.on( 'click', '.add_to_cart_button', function() {
      var $this = $( this );
      var opacityTimeout = null;
      var removeTimeout = null;
      var interval = setInterval(function() {
        if ( $this.hasClass( 'added' ) ) {
          opacityTimeout = setTimeout(function() {
            $this.removeClass( 'added' );
            $this.blur();
            $this.next( '.added_to_cart' ).css( 'opacity', '0' );
            removeTimeout = setTimeout(function() {
              $this.next( '.added_to_cart' ).remove();
              window.clearTimeout( removeTimeout );
              removeTimeout = null;
            }, 250 );
            window.clearTimeout( opacityTimeout );
            opacityTimeout = null;
          }, 2000 );
          window.clearInterval( interval );
          interval = null;
        }
      }, 1000 );

    });
} )( window.jQuery );
