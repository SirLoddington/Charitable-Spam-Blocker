<?php
/**
 * Interface for modules.
 *
 * @version   1.0.0
 * @package   Charitable SpamBlocker/Interfaces/Interface
 * @author    Eric Daams
 * @copyright Copyright (c) 2020, Studio 164a
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */

namespace Charitable\Packages\SpamBlocker\Modules;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! interface_exists( '\Charitable\Packages\SpamBlocker\Modules\ModuleInterface' ) ) :

	/**
	 * Module interface.
	 *
	 * @since 1.0.0
	 */
	interface ModuleInterface {

		/**
		 * Return whether the module is active.
		 *
		 * @since  1.0.0
		 *
		 * @return boolean
		 */
		public function is_active();

		/**
		 * Get the module settings.
		 *
		 * @since  1.0.0
		 *
		 * @return array
		 */
		public function get_settings();
	}

endif;
