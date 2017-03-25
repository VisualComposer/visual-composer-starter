<?php
/**
 * Theme updater
 *
 * @package WordPress
 * @subpackage Visual Composer Starter
 * @since Visual Composer Starter 1.0
 */

/**
 * Class VCT_Update
 */
class VCT_Update {
	/**
	 * Update path
	 *
	 * @var string
	 */
	protected $update_path = 'http://updates.wpbakery.com/visual-composer-theme/index.html';

	/**
	 * VCT_Update constructor.
	 */
	public function __construct() {
		/**
		 * Init check update.
		 *
		 * @see \VCT_Update::check_for_updates
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
		// Extra check for 3rd plugins.
		if ( isset( $transient->response[ VCT_SLUG ] ) ) {
			return $transient;
		}
		// Get the remote version.
		$version = $this->get_remote_version();
		// If a newer version is available, add the update.
		if ( version_compare( VCT_VERSION, $version, '<' ) ) {
			$theme                           = array();
			$theme['theme']                  = VCT_SLUG;
			$theme['new_version']            = $version;
			$theme['url']                    = 'http://updates.wpbakery.com/visual-composer-theme/changes.html';
			$theme['package']                = 'http://updates.wpbakery.com/visual-composer-theme/visual-composer-theme.zip';
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
		$request = vip_safe_wp_remote_get( $this->update_path );
		if ( ! is_wp_error( $request ) || wp_remote_retrieve_response_code( $request ) === 200 ) {
			return $request['body'];
		}

		return false;
	}
}
