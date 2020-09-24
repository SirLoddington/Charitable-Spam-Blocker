<?php
/**
 * Spam blocker modules class.
 *
 * @package   Charitable SpamBlocker/Classes/\Charitable\Packages\SpamBlocker\Modules\Modules
 * @author    Eric Daams
 * @copyright Copyright (c) 2020, Studio 164a
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since     1.0.0
 * @version   1.0.0
 */

namespace Charitable\Packages\SpamBlocker\Modules;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( '\Charitable\Packages\SpamBlocker\Modules\Modules' ) ) :

	/**
	 * \Charitable\Packages\SpamBlocker\Modules\Modules
	 *
	 * @since 1.0.0
	 */
	class Modules {

		/**
		 * Load up module functionality.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {
			$this->get_all_modules();
		}

		/**
		 * Get the list of all modules.
		 *
		 * @since  1.0.0
		 *
		 * @return array
		 */
		public function get_module_list() {
			/**
			 * Filter the list of all modules.
			 *
			 * @since 1.0.0
			 *
			 * @param array $modules The list of modules.
			 */
			return apply_filters(
				'charitable_security_modules',
				array(
					'captcha'          => '\Charitable\Packages\SpamBlocker\Modules\Captcha\Captcha',
					'hcaptcha'         => '\Charitable\Packages\SpamBlocker\Modules\Captcha\HCaptcha',
					'google-recaptcha' => '\Charitable\Packages\SpamBlocker\Modules\Captcha\GoogleReCAPTCHA',
				)
			);
		}

		/**
		 * Get all modules.
		 *
		 * @since  1.0.0
		 *
		 * @return array
		 */
		public function get_all_modules() {
			if ( ! isset( $modules ) ) {
				$this->modules = array_map(
					function( $module ) {
						return new $module;
					},
					$this->get_module_list()
				);
			}

			return $this->modules;
		}

		/**
		 * Get all active modules.
		 *
		 * @since  1.0.0
		 *
		 * @return array
		 */
		public function get_active_modules() {
			return array_filter(
				$this->get_all_modules(),
				function( $module ) {
					return $module->is_active();
				}
			);
		}
	}

endif;
