<?php
/**
 * Charitable SpamBlocker Core Functions.
 *
 * @package   Charitable SpamBlocker/Functions/Core
 * @copyright Copyright (c) 2020, Studio 164a
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since     1.0.0
 * @version   1.0.0
 */

use \Charitable\Packages\SpamBlocker\SpamBlocker;
use \Charitable\Packages\SpamBlocker\Deprecated;
use \Charitable\Packages\SpamBlocker\Template;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * This returns the original Charitable_SpamBlocker object.
 *
 * Use this whenever you want to get an instance of the class. There is no
 * reason to instantiate a new object, though you can do so if you're stubborn :)
 *
 * @since   1.0.0
 *
 * @return \Charitable\Pro\SpamBlocker\SpamBlocker
 */
function charitable_spamblocker() {
	return SpamBlocker::get_instance();
}

/**
 * This returns the Charitable_SpamBlocker_Deprecated object.
 *
 * @since  1.0.0
 *
 * @return \Charitable\Pro\SpamBlocker\Deprecated
 */
function charitable_spamblocker_deprecated() {
	return Deprecated::get_instance();
}
