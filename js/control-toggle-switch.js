(function ($) {
    var vct_social_icons = [
        'facebook',
        'twitter',
        'linkedin',
        'instagram',
        'pinterest',
        'youtube',
        'vimeo',
        'flickr',
        'github',
        'email'
    ];
    // available social icons

    function isToggleTrue(el) {
        return $(el).prop('checked');
    }

    function hideSocialIcons() {
        $.each(vct_social_icons, function (key, icon) {
            $('#customize-control-vct_footer_area_social_link_' + icon).hide();
        });
    }

    function showSocialIcons() {
        $.each(vct_social_icons, function (key, icon) {
            $('#customize-control-vct_footer_area_social_link_' + icon).show();
        });
    }

    function hideNumberOfColumns() {
        $('#customize-control-vct_footer_area_widgetized_columns').hide();
    }

    function showNumberOfColumns() {
        $('#customize-control-vct_footer_area_widgetized_columns').show();
    }

    wp.customize.controlConstructor['toggle-switch'] = wp.customize.Control.extend({
        ready: function () {
            var control = this;
            var value = ( undefined !== control.setting._value ) ? control.setting._value : '';

            /**
             * Social Icons
             */
            this.container.on('change', 'input:checkbox', function () {
                value = isToggleTrue(this);
                var $this = $(this);
                if ($this.attr('id') === 'vct_footer_area_social_icons') {
                    if (!value) {
                        hideSocialIcons();
                    }
                    else {
                        showSocialIcons();
                    }
                }
                if ($this.attr('id') === 'vct_footer_area_widget_area') {
                    if (!value) {
                        hideNumberOfColumns();
                    }
                    else {
                        showNumberOfColumns();
                    }
                }

                control.setting.set(value);
                // refresh the preview
                wp.customize.previewer.refresh();
            });
        }

    });

    $(document).ready(function () {
        if (!isToggleTrue('#vct_footer_area_social_icons')) {
            hideSocialIcons();
        }
        if (!isToggleTrue('#vct_footer_area_widget_area')) {
            hideNumberOfColumns();
        }
    });
})(window.jQuery);
