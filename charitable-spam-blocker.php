<?php
/**
 * Plugin Name:       Charitable - Spam Blocker
 * Plugin URI:        https://github.com/Charitable/Charitable-Spam-Blocker
 * Description:       Add a series of tools to help block spam donation form submissions.
 * Version:           1.0.0
 * Author:            WP Charitable
 * Author URI:        https://www.wpcharitable.com
 * Requires at least: 5.0
 * Tested up to:      5.5.1
 *
 * Text Domain: charitable-spam-blocker
 * Domain Path: /languages/
 *
 * @package Charitable SpamBlocker
 * @author  WP Charitable
 */

namespace Charitable\Packages\SpamBlocker;

use \Charitable\Extensions\Activation\Activation;
use \Charitable\Packages\SpamBlocker\Domain\Bootstrap;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'CHARITABLE_SPAMBLOCKER_FEATURE_PLUGIN', true );

/**
 * Load plugin class, but only if Charitable is found and activated.
 *
 * @return false|\Charitable\Packages\SpamBlocker\SpamBlocker Whether the class was loaded.
 */
add_action(
	'plugins_loaded',
	function() {
		/* Load Composer packages. */
		require_once( 'vendor/autoload.php' );

		$activation = new Activation( '1.6.40' );

		if ( $activation->ok() ) {
			require_once( 'src/Domain/Bootstrap.php' );
			return new Bootstrap();
		}

		/* translators: %s: link to activate Charitable */
		$activation->activation_notice = __( 'Charitable Spam Blocker requires Charitable! Please <a href="%s">activate it</a> to continue.', 'charitable-spam-blocker' );

		/* translators: %s: link to install Charitable */
		$activation->installation_notice = __( 'Charitable Spam Blocker requires Charitable! Please <a href="%s">install it</a> to continue.', 'charitable-spam-blocker' );

		/* translators: %s: link to update Charitable */
		$activation->update_notice = __( 'Charitable Spam Blocker requires Charitable 1.6.40+! Please <a href="%s">update Charitable</a> to continue.', 'charitable-spam-blocker' );

		$activation->run();

		return false;
	}
);
