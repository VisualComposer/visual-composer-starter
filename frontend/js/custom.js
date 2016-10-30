[].forEach.call(document.querySelectorAll('img[data-src]'), function(img) {
    img.setAttribute('src', img.getAttribute('data-src'));
    img.onload = function() {
        img.removeAttribute('data-src');
    };
});

jQuery(window).load(function(){

    //Header without background
    if(jQuery('body').hasClass('navbar-no-background')) {
        jQuery('#header').css({minHeight: jQuery('nav.navbar').outerHeight()});
    }

    //Fixed header
	if (jQuery('body').hasClass('fixed-header')) {
        jQuery('nav.navbar').addClass('fixed');
        if(!jQuery('body').hasClass('navbar-no-background')) {
            jQuery('body').css({paddingTop: jQuery('nav.navbar').outerHeight()});
        }
        else {
            if (jQuery(this).scrollTop() > 0) {
                jQuery('nav.navbar').addClass('scroll');
            }
        }
	}

    jQuery(this).scroll(function () {
        if (jQuery(this).scrollTop() > 0 && jQuery('body').hasClass('navbar-no-background')) {
            jQuery('nav.navbar').addClass('scroll');
        }
        else {
            if (jQuery('body').hasClass('navbar-no-background')) {
                jQuery('nav.navbar').removeClass('scroll');
            }
        }
    });


    //Sandwich menu
    if (jQuery(this).width() < 768) {
        jQuery('body').addClass('mobile');
    }
    //Footer social icons vertical align
    if (jQuery(this).width() >= 992) {
        jQuery('.footer-right-block').height(jQuery('.footer-left-block').height());
    }

    jQuery(window).on('resize', function(){
        //Sandwich menu
        if (jQuery(this).width() < 768) {
            jQuery('body').addClass('mobile');
        }
        else {
            jQuery('body').removeClass('mobile');
        }

        //Footer social icons vertical align
        if (jQuery(this).width() > 992) {
            jQuery('.footer-right-block').height(jQuery('.footer-left-block').height());
        }
        else {
            jQuery('.footer-right-block').height('auto');
        }
    });

    //Sandwich menu
    jQuery(document).on('click', 'body.mobile #main-menu .menu-item-has-children>a, body.menu-sandwich #main-menu .menu-item-has-children>a', function(){
        jQuery(this).siblings('ul').slideToggle(600);
        return false;
    });

    jQuery(document).on('click', '.navbar-toggle', function(){
        jQuery(this).fadeOut('fast');
        jQuery('#main-menu').addClass('open');
    });

    jQuery(document).on('click', '#main-menu .button-close', function(){
        jQuery('.navbar-toggle').show();
        jQuery('#main-menu').removeClass('open');
    });

    //Gallery Slider
    jQuery('.gallery-slider').slick({
        autoplay: true,
        arrows: false,
        dots: true,

    });
});
