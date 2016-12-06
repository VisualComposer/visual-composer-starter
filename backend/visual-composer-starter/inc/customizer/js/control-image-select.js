wp.customize.controlConstructor['radio-image'] = wp.customize.Control.extend({

    ready: function() {
        var control = this;
        var value = (undefined !== control.setting._value) ? control.setting._value : '';

        this.container.on( 'change', 'input:radio', function() {
            value = jQuery( this ).val();
            control.setting.set( value );
            // refresh the preview
            wp.customize.previewer.refresh();
        });
    }

});