<?php
/**
 * The main Charitable SpamBlocker class.
 *
 * The responsibility of this class is to load all the plugin's functionality.
 *
 * @package   Charitable SpamBlocker
 * @copyright Copyright (c) 2020, Eric Daams
 * @license   http://opensource.org/licenses/gpl-1.0.0.php GNU Public License
 * @version   1.0.0
 * @since     1.0.0
 */

namespace Charitable\Packages\SpamBlocker\Modules\Captcha;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( '\Charitable\Packages\SpamBlocker\Modules\Captcha\Captcha' ) ) :

	/**
	 * Captcha module.
	 *
	 * @since 1.0.0
	 */
	class Captcha implements \Charitable\Packages\SpamBlocker\Modules\ModuleInterface {

		/**
		 * Return whether the module is active.
		 *
		 * @since  1.0.0
		 *
		 * @return boolean
		 */
		public function is_active() {
			return 'disabled' !== charitable_get_option( 'hcpatcha_sitekey' );
		}

		/**
		 * Get the module settings.
		 *
		 * @since  1.0.0
		 *
		 * @return array
		 */
		public function get_settings() {
			return array(
				'captcha_section_header' => array(
					'title'    => __( 'Captcha', 'charitable-spamblocker' ),
					'type'     => 'heading',
					'priority' => 100,
				),
				'captcha_provider'       => array(
					'title'    => __( 'Captcha Provider', 'charitable-spamblocker' ),
					'type'     => 'radio',
					'options'  => array(
						'disabled'         => __( 'Disabled', 'charitable-spamblocker' ),
						'google-recaptcha' => __( 'Google reCAPTCHA', 'charitable-spamblocker' ),
						'hcaptcha'         => __( 'hCaptcha', 'charitable-spamblocker' ),
					),
					'priority' => 104,
					'default'  => 'disabled',
				),
				'captcha_logged_in'      => array(
					'title'    => __( 'Require Captcha for Logged In Users', 'charitable-spamblocker' ),
					'type'     => 'radio',
					'options'  => array(
						'yes' => __( 'Yes', 'charitable-spamblocker' ),
						'no'  => __( 'No', 'charitable-spamblocker' ),
					),
					'priority' => 108,
					'default'  => 'no',
					'attrs'    => array(
						'data-trigger-key'   => '#charitable_settings_captcha_provider_disabled',
						'data-trigger-value' => '!checked',
					),
				),
			);
		}
	}

endif;
