jQuery(window).load(function(){

    //Header without background
    if(jQuery('body').hasClass('navbar-no-background')) {
        jQuery('#header').css({minHeight: jQuery('nav.navbar').outerHeight()})
    }

    //Fixed header
	if (jQuery(this).scrollTop() > 0 && jQuery('body').hasClass('fixed-header')) {
        jQuery('nav.navbar').css({position: 'fixed'});
	}

    jQuery(this).scroll(function () {
        if (jQuery(this).scrollTop() > 0 && jQuery('body').hasClass('fixed-header')) {
            jQuery('nav.navbar').css({position: 'fixed'});
        }
        else {
            if (jQuery('body').hasClass('fixed-header')) {
                jQuery('nav.navbar').css({position: 'static'});
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
