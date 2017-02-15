<?php
class VCT_Toggle_Switch_Control extends WP_Customize_Control {

    /**
     * The type of customize control being rendered.
     *
     * @access public
     * @since  1.0
     * @var    string
     */
    public $type = 'toggle-switch';

    /**
     * Add our JavaScript and CSS to the Customizer.
     *
     * @access public
     * @since  1.0
     * @return void
     */
    public function enqueue() {
        wp_register_script( 'vct-toggle-switch-control', get_template_directory_uri() . '/js/control-toggle-switch.js', array( 'jquery' ), false, true );
        wp_register_script( 'vct-select-control', get_template_directory_uri() . '/js/control-select.js', array( 'jquery' ), false, true );
        wp_enqueue_script( 'vct-toggle-switch-control' );
        wp_enqueue_script( 'vct-select-control' );
        wp_register_style( 'vct-toggle-switch', get_template_directory_uri() . '/css/toggle-switch.css' );
        wp_enqueue_style( 'vct-toggle-switch' );
    }

    /**
     * Add custom JSON parameters to use in the JS template.
     *
     * @access public
     * @since  1.0
     * @return void
     */
    public function to_json() {
        parent::to_json();


        $this->json['value']   = $this->value();
        $this->json['id']      = $this->id;
    }

    /**
     * An Underscore (JS) template for this control's content.
     *
     * Class variables for this control class are available in the `data` JS object;
     * export custom variables by overriding {@see WP_Customize_Control::to_json()}.
     *
     * @see    WP_Customize_Control::print_template()
     *
     * @access protected
     * @since  1.0
     * @return void
     */
    protected function content_template() {
        ?>

        <# if ( data.label ) { #>
            <span class="customize-control-title">{{ data.label }}</span>
        <# } #>

        <# if ( data.description ) { #>
                    <span class="description customize-control-description">{{{ data.description }}}</span>
        <# } #>
            
        <div class="onoffswitch">
            <input id="{{ data.id }}" type="checkbox" name="_customize-{{ data.type }}-{{ data.id }}" class="onoffswitch-checkbox" value="{{ data.value }}" <# if ( data.value === true) { #> checked <# } #>>
            <label class="onoffswitch-label" for="{{ data.id }}">
                <span class="onoffswitch-inner"></span>
                <span class="onoffswitch-switch"></span>
            </label>
        </div>
        <?php
    }
}
