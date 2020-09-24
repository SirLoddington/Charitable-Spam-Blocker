<?php
/**
 * A helper class for logging deprecated arguments, functions and methods.
 *
 * @package   Charitable SpamBlocker/Classes
 * @author    Eric Daams
 * @copyright Copyright (c) 2020, Studio 164a
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since     1.0.0
 * @version   1.0.0
 */

namespace Charitable\Packages\SpamBlocker;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( '\Charitable\Packages\SpamBlocker\Deprecated' ) ) :

	/**
	 * Charitable_Deprecated
	 *
	 * @since 1.0.0
	 */
	class Deprecated extends \Charitable_Deprecated {

		/**
		 * One true class object.
		 *
		 * @since 1.0.0
		 *
		 * @var   \Charitable\Packages\SpamBlocker\Deprecated
		 */
		private static $instance = null;

		/**
		 * Create class object. Private constructor.
		 *
		 * @since 1.0.0
		 */
		private function __construct() {
			$this->context = 'Charitable SpamBlocker';
		}

		/**
		 * Create and return the class object.
		 *
		 * @since  1.0.0
		 *
		 * @return \Charitable\Packages\SpamBlocker\Deprecated
		 */
		public static function get_instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}
	}

endif;
