<?php
/**
 * Theme updater
 *
 * @package WordPress
 * @subpackage Visual Composer Starter
 * @since Visual Composer Starter 1.0
 */

/**
 * Class VisualComposerStarter_Update
 */
class VisualComposerStarter_Update {
	/**
	 * Update path
	 *
	 * @var string
	 */
	protected $update_path = 'http://updates.wpbakery.com/visual-composer-starter/index.html';

	/**
	 * VisualComposerStarter_Update constructor.
	 */
	public function __construct() {
		/**
		 * Init check update.
		 *
		 * @see \VisualComposerStarter_Update::check_for_updates
		 */
		add_filter( 'pre_set_site_transient_update_themes', array(
			$this,
			'check_for_updates',
			)
		);
	}

	/**
	 * Check for updates
	 *
	 * @param object $transient Transient.
	 *
	 * @return mixed
	 */
	public function check_for_updates( $transient ) {
		if ( did_action( 'upgrader_process_complete' ) || ! isset( $transient->response ) ) {
			return $transient;
		}
		// Extra check for 3rd plugins.
		if ( isset( $transient->response[ VCT_SLUG ] ) ) {
			return $transient;
		}
		// Get the remote version.
		$version = $this->get_remote_version();
		// If a newer version is available, add the update.
		if ( version_compare( VISUALCOMPOSERSTARTER_VERSION, $version, '<' ) ) {
			$theme                           = array();
			$theme['theme']                  = VCT_SLUG;
			$theme['new_version']            = $version;
			$theme['url']                    = 'http://updates.wpbakery.com/visual-composer-starter/changes.html';
			$theme['package']                = 'http://updates.wpbakery.com/visual-composer-starter/visual-composer-starter.zip';
			$transient->response[ VCT_SLUG ] = $theme;

		}

		return $transient;
	}

	/**
	 * Get remote version
	 *
	 * @return bool
	 */
	protected function get_remote_version() {
		$request = wp_remote_get( $this->update_path );
		if ( ! is_wp_error( $request ) || wp_remote_retrieve_response_code( $request ) === 200 ) {
			return $request['body'];
		}

		return false;
	}
}
