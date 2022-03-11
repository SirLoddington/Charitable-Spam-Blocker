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
 * @since     1.0.4
 * @author 	  Ben Jackson
 */

namespace Charitable\Packages\SpamBlocker\Modules;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( '\Charitable\Packages\SpamBlocker\Modules\StopForumSpam' ) ) :

	/**
	 * 
	 *
	 * @since 1.0.0
	 */
	class StopForumSpam implements \Charitable\Packages\SpamBlocker\Modules\ModuleInterface {

		/**
		 * Class constructor.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {
			if ( $this->is_active() ) {
				$this->setup();
			}
		}

		/**
		 * Return whether this model should be active.
		 *
		 * @since  1.0.0
		 *
		 * @return boolean
		 */
        public function is_active() {

			// Always active when this plugin is installed
            return true;
		}

		/**
		 * Automatically do everything if plugin is installed,
		 * So no settings yet
		 * @since  1.0.0
		 *
		 * @return array
		 */
		public function get_settings() {
            return array();
		}

		/**
		 * Set up module hooks.
		 *
		 * @since  1.0.0
		 *
		 * @return void
		 */
		public function setup() {
			/**
			 * For the donation form, block spam as part of the security check.
			 */
			add_filter( 'charitable_validate_donation_form_submission_security_check', array( $this, 'stopforumspam_check' ), 10, 2 );
		}

		/**
		 * Run the donation form through the stopforumspam check
		 *
		 * @since  now
		 *
		 * @param  boolean                  $ret  The result to be returned. True or False.
		 * @param  Charitable_Donation_Form $form The donation form object.
		 * @return boolean
		 */
		public function stopforumspam_check( $ret, \Charitable_Donation_Form $form ) {
			if ( !$ret ) {
				return $ret;
			}

			if ( ! $this->is_active() ) {
				return $ret;
			}

			//Collect and package our data to be sent to StopForumSpam
			$form_params = $form->get_submitted_values();
			$data = array(
				'username' => array(
					$form_params['first_name'] . " " . $form_params['last_name']
				),
				'email' => $form_params['email'],
				'ip' => $_SERVER['REMOTE_ADDR'],
				"badtorexit"
			);

			// setup the URL
			$url = 'http://api.stopforumspam.org/api';

			$data = http_build_query($data);

			// init the request, set some info, send it and finally close it
			$ch = curl_init($url);

			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

			$result_XML_str = curl_exec($ch);
			$result_XML = simpleXML_load_string($result_XML_str);
			curl_close($ch);
			
			$is_spam = false;

			// Look through all responses in the result
			// If any return 'yes', the donation is spam
			foreach($result_XML->appears as $appears => $response) {
				if( $response == 'yes') { 
					$is_spam = true; 
				}
			}

			//Return false if its spam, true if it isnt
			return ! $is_spam;
		}

	}

endif;
