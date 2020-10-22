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

namespace Charitable\Packages\SpamBlocker\Admin;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( '\Charitable\Packages\SpamBlocker\Admin\Settings' ) ) :

	/**
	 * Settings.
	 *
	 * @since 1.0.0
	 */
	class Settings {

		/**
		 * Create class object.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {
			add_filter( 'charitable_settings_tabs', array( $this, 'add_security_section' ) );
			add_filter( 'charitable_security_admin_settings_groups', array( $this, 'add_security_settings_group' ) );
			add_filter( 'charitable_settings_tab_fields_security', array( $this, 'add_settings' ) );
		}

		/**
		 * Add Security tab to the Charitable settings UI.
		 *
		 * @since  1.0.0
		 *
		 * @param  string[] $sections The settings sections.
		 * @return string[]
		 */
		public function add_security_section( $sections ) {
			$keys   = array_keys( $sections );
			$values = array_values( $sections );

			array_splice( $keys, 5, 0, 'security' );
			array_splice( $values, 5, 0, __( 'Security', 'charitable-spam-blocker' ) );

			return array_combine( $keys, $values );
		}

		/**
		 * Include "security" as a setting group.
		 *
		 * @since  1.0.0
		 *
		 * @param  string[] $groups The setting groups.
		 * @return string[]
		 */
		public function add_security_settings_group( $groups ) {
			$groups[] = 'security';
			return $groups;
		}

		/**
		 * Add settings to the Security page.
		 *
		 * @since  1.0.0
		 *
		 * @param  array $settings Existing settings on the Security page.
		 * @return array
		 */
		public function add_settings( $settings ) {
			foreach ( \charitable_spamblocker()->modules->get_all_modules() as $module ) {
				$settings = array_merge(
					$settings,
					$module->get_settings()
				);
			}

			return $settings;
		}
	}

endif;
