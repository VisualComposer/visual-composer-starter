(function($){

    $('img[data-src]').each(function () {
        $(this).attr('src', $(this).attr('data-src'));
        $(this).load(function () {
            $(this).removeAttr('data-src');
        });
    });

    var menu_container = $('#main-menu');

    // Add dropdown toggle that displays child menu items.
    var dropdownToggle = $( '<button />', {
        'class': 'dropdown-toggle vc-icon-dropdown-icon',
    } );

    menu_container.find( '.menu-item-has-children > a' ).after( dropdownToggle );
    
    // Header without background
    if($('body').hasClass('navbar-no-background')) {
        $('#header').css({minHeight: $('nav.navbar').outerHeight()});
    }

    // Fixed header
    if ($('body').hasClass('fixed-header')) {
        $('nav.navbar').addClass('fixed');
        if(!$('body').hasClass('navbar-no-background')) {
            $('body').css({paddingTop: $('nav.navbar').outerHeight()});
        }
        else {
            if ($(this).scrollTop() > 0) {
                $('nav.navbar').addClass('scroll');
            }
        }
    }

    $(this).scroll(function () {
        if ($(this).scrollTop() > 0) {
            if ($('body').hasClass('navbar-no-background')) {
                $('nav.navbar').addClass('scroll');
            }
        }
        else {
            if ($('body').hasClass('navbar-no-background')) {
                $('nav.navbar').removeClass('scroll');
            }
        }
    });


    // Sandwich menu
    if ($(this).width() < 768) {
        $('body').addClass('mobile');
    }
    // Footer social icons vertical align
    if ($(this).width() >= 992) {
        $('.footer-right-block').height($('.footer-left-block').height());
    }

    $(window).on('resize', function(){
        //Fixed header
        if ($('body').hasClass('fixed-header') && !$('body').hasClass('navbar-no-background')) {
            $('body').css({paddingTop: $('nav.navbar').outerHeight()});
        }
        //Header no-background
        if($('body').hasClass('navbar-no-background')) {
            $('#header').css({minHeight: $('nav.navbar').outerHeight()});
        }
        //Sandwich menu
        if ($(this).width() < 768) {
            $('body').addClass('mobile');
        }
        else {
            $('body').removeClass('mobile');
        }

        // Footer social icons vertical align
        if ($(this).width() > 992) {
            $('.footer-right-block').height($('.footer-left-block').outerHeight());
        }
        else {
            $('.footer-right-block').height('auto');
        }
    });

    // Sandwich menu
    $(document).on('click', '.dropdown-toggle', function(){
        $(this).siblings('ul').slideToggle(600);
        $(this).toggleClass('open');
        return false;
    });

    $(document).on('click', '.navbar-toggle', function(){
        $(this).fadeOut('fast');
        $('#main-menu').addClass('open');
    });

    $(document).on('click', '#main-menu .button-close', function(){
        $('.navbar-toggle').show();
        $('#main-menu').removeClass('open');
    });

    //Gallery Slider
    $('.gallery-slider').slick({
        autoplay: true,
        arrows: false,
        dots: true

    });
})(jQuery);
