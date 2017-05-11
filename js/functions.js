(function( $ ) {
    var $body = $( 'body' );
    var $mainMenu = $( '#main-menu' );
    var $navBar = $( 'nav.navbar' );
    var $header = $( '#header' );
    var $footerRightBlock = $( '.footer-right-block' );
    var $footerLeftBlock = $( '.footer-left-block' );
    var windowHeight, featuredImageHeight, navbarHeight;

    // Add dropdown toggle that displays child menu items.
    var $dropdownToggle = $( '<button />', {
        'class': 'dropdown-toggle vct-icon-dropdown'
    });

    $( 'img[data-src]' ).each(function() {
        var $this = $( this );
        $this.attr( 'src', $this.attr( 'data-src' ) );
        $this.load( function() {
            $this.removeAttr( 'data-src' );
        });
    });

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

    $( window ).scroll(function() {
        if ( $( window ).scrollTop() > 0 ) {
            if ( $body.hasClass( 'navbar-no-background' ) ) {
                $navBar.addClass( 'scroll' );
            }
        } else {
            if ( $body.hasClass( 'navbar-no-background' ) ) {
                $navBar.removeClass( 'scroll' );
            }
        }
    });

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
    });

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
    });

    // Sandwich menu
    $( document ).on( 'click', '.dropdown-toggle', function() {
        var $this = $( this );
        $this.siblings( 'ul' ).slideToggle( 600 );
        $this.toggleClass( 'open' );
        return false;
    });

    $( document ).on( 'click', '.navbar-toggle', function() {
        var $this = $( this );
        $this.fadeOut( 'fast' );
        $mainMenu.addClass( 'open' );
    });

    $( document ).on( 'click', '#main-menu .button-close', function() {
        $( '.navbar-toggle' ).show();
        $mainMenu.removeClass( 'open' );
    });

    $( document ).on( 'click', '#main-menu li', function() {
        $( '.navbar-toggle' ).show();
        $( '#main-menu' ).removeClass( 'open' );

    });

    //Gallery Slider
    $( '.gallery-slider' ).slick({
        autoplay: true,
        arrows: false,
        dots: true
    });
})( window.jQuery );
