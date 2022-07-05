<?php

/**
 * Select with Google Fonts with GDPR message
 */
class VisualComposerStarter_Google_Fonts_Control extends WP_Customize_Control {

	/**
	 * @inheritDoc
	 */
	public $type = 'google-fonts';

	/**
	 * @inheritDoc
	 */
	public function enqueue() {
		wp_enqueue_script(
			'visualcomposerstarter-google-fonts-control',
			get_template_directory_uri() . '/js/control-google-fonts.js',
			array( 'jquery' ),
			false,
			true
		);
		wp_localize_script(
			'visualcomposerstarter-google-fonts-control',
			'googleFontControlData',
			array(
				'nonce' => wp_create_nonce( 'vct_google_fonts_ajax_nonce' ),
			)
		);
	}

	/**
	 * @inheritDoc
	 */
	protected function render_content() {
		if ( empty( $this->choices ) ) {
			return;
		}

		$input_id         = '_customize-input-' . $this->id;
		$description_id   = '_customize-description-' . $this->id;
		$message_id       = '_customize-message-' . $this->id;
		$describedby_attr = ( ! empty( $this->description ) ) ? ' aria-describedby="' . esc_attr( $description_id ) . '" ' : '';

		?>
		<?php if ( ! empty( $this->label ) ) : ?>
			<label for="<?php echo esc_attr( $input_id ); ?>" class="customize-control-title"><?php echo esc_html( $this->label ); ?></label>
		<?php endif; ?>
		<?php if ( ! empty( $this->description ) ) : ?>
			<span id="<?php echo esc_attr( $description_id ); ?>" class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
		<?php endif; ?>
		<select id="<?php echo esc_attr( $input_id ); ?>" <?php echo esc_html( $describedby_attr ); ?> <?php $this->link(); ?>>
			<?php
			foreach ( $this->choices as $value => $label ) :
				echo '<option value="' . esc_attr( $value ) . '"' . selected( $this->value(), $value, false ) . '>' . $label . '</option>';
			endforeach;
			?>
		</select>
		<span id="<?php echo esc_attr( $message_id ); ?>" class="description customize-control-description" style="display: none;">
			<?php echo strip_tags(
				__(
					'To see the typography preview you need to <a href="#" data-vct-download-font="true">download</a> this font family locally',
					'visual-composer-starter'
				),
				'<a>'
			); ?>
		</span>
		<?php
	}
}
