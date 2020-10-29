<?php
/**
 * Load the class.
 *
 * @package   Charitable SpamBlocker
 * @copyright Copyright (c) 2020, Eric Daams
 * @license   http://opensource.org/licenses/gpl-1.0.0.php GNU Public License
 * @version   1.0.1
 * @since     1.0.1
 */

namespace Charitable\Packages\SpamBlocker\Domain;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( '\Charitable\Packages\SpamBlocker\Package' ) ) :

	/**
	 * Package.
	 *
	 * @since 1.0.1
	 */
	class Package {

		/**
		 * Load the class.
		 *
		 * @since  1.0.1
		 *
		 * @return void
		 */
		public static function init() {
			if ( defined( 'CHARITABLE_SPAMBLOCKER_FEATURE_PLUGIN' ) && CHARITABLE_SPAMBLOCKER_FEATURE_PLUGIN ) {
				return;
			}

			return new Bootstrap();
		}
	}

endif;
