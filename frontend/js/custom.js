//Fixed header
jQuery(window).load(function(){
	if (jQuery(this).scrollTop() > 0 && jQuery('body').hasClass('fixed-header')) {
        jQuery('nav.navbar').css({position: 'fixed'});
	}

    jQuery(this).scroll(function () {
        if (jQuery(this).scrollTop() > 0 && jQuery('body').hasClass('fixed-header')) {
            jQuery('nav.navbar').css({position: 'fixed'});
        }
        else {
            jQuery('nav.navbar').css({position: 'static'});
        }
    });
});
