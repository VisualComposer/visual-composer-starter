<?php
class VC_Image_Select_Control extends WP_Customize_Control {

    /**
     * The type of customize control being rendered.
     *
     * @access public
     * @since  1.1
     * @var    string
     */
    public $type = 'radio-image';

    /**
     * Add our JavaScript and CSS to the Customizer.
     *
     * @access public
     * @since  1.1
     * @return void
     */
    public function enqueue() {
        wp_enqueue_script( 'ng-image-select-control', get_template_directory_uri() . '/inc/customizer/js/control-image-select.js', array( 'jquery' ), false, true );
        wp_enqueue_style( 'ng-image-select', get_template_directory_uri() . '/inc/customizer/css/image-select.css' );
    }

    /**
     * Add custom JSON parameters to use in the JS template.
     *
     * @access public
     * @since  1.1
     * @return void
     */
    public function to_json() {
        parent::to_json();

        // Create the image URL. Replaces the %s placeholder with the URL to the customizer /images/ directory.
        foreach ( $this->choices as $value => $args ) {
            $this->choices[ $value ]['url'] = esc_url( sprintf( $args['url'], get_template_directory_uri() . '/inc/customizer/images/' ) );
        }

        $this->json['choices'] = $this->choices;
        $this->json['link']    = $this->get_link();
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
     * @since  1.1
     * @return void
     */
    protected function content_template() {
        ?>
        <# if ( ! data.choices ) {
            return;
            } #>

            <# if ( data.label ) { #>
                <span class="customize-control-title">{{ data.label }}</span>
                <# } #>

                    <# if ( data.description ) { #>
                        <span class="description customize-control-description">{{{ data.description }}}</span>
                        <# } #>

                            <# for ( key in data.choices ) { #>

                                <label for="{{ data.id }}-{{ key }}">
                                    <span class="screen-reader-text">{{ data.choices[ key ]['label'] }}</span>
                                    <input type="radio" value="{{ key }}" name="_customize-{{ data.type }}-{{ data.id }}" id="{{ data.id }}-{{ key }}" {{{ data.link }}} <# if ( key === data.value ) { #> checked="checked" <# } #> />
                                            <img src="{{ data.choices[ key ]['url'] }}" alt="{{ data.choices[ key ]['label'] }}" />
                                </label>
                                <# } #>
        <?php
    }

}