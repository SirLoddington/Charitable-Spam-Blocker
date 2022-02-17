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
 */

namespace Charitable\Packages\SpamBlocker\Modules;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( '\Charitable\Packages\SpamBlocker\Modules\charitable_akismet' ) ) :

	/**
	 * HCaptcha module.
	 *
	 * @since 1.0.0
	 */
	class charitable_akismet implements \Charitable\Packages\SpamBlocker\Modules\ModuleInterface {

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

			#Check if akismet is installed and if there is a valid API key
			if ( is_callable( array( '\Akismet', 'get_api_key' ) ) ) {
                return (bool) \Akismet::get_api_key();
            }

            return false;
		}

		/**
		 * Automatically do everything if akismet is installed,
		 * So no settings yet
		 * @since  1.0.0
		 *
		 * @return array
		 */
		public function get_settings() {
            return array();
		}

		/**
		 * Get the API key.
		 * *Not currently used
		 *
		 * @since  1.0.0
		 *
		 * @return string
		 */
		public function charitable_get_akismet_API_key() {
			if ( is_callable( array( '\Akismet', 'get_api_key' ) ) ) {
                return \Akismet::get_api_key();
            } else {
				return false;
			}
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
			add_filter( 'charitable_validate_donation_form_submission_security_check', array( $this, 'akismet_spam_check' ), 10, 2 );
		}
		

		public function charitable_akismet_api_call( $donation ) {
			$spam = false;
			$query_string = http_build_query( $donation );
	
			if ( is_callable( array( '\Akismet', 'http_post' ) ) ) {
				$response = \Akismet::http_post( $query_string, 'comment-check' );
			} else {
				return $spam;
			}
			
			if ( 'true' == $response[1] ) {
				$spam = true;
			}
			
			return apply_filters( 'charitable_akismet_api_call', $spam, $donation );
		}

		/**
		 * Run the donation form through the akismet spam check
		 *
		 * @since  now
		 *
		 * @param  boolean                  $ret  The result to be returned. True or False.
		 * @param  Charitable_Donation_Form $form The donation form object.
		 * @return boolean
		 */
		public function akismet_spam_check( $ret, \Charitable_Donation_Form $form ) {
			if ( !$ret ) {
				return $ret;
			}

			if ( ! $this->is_active() ) {
				return $ret;
			}

			$form_params = $form->get_submitted_values();
			$donation_details = array();

			#Use firstname lastname as the author
			#If no first/last name, username used instead
			if ( isset( $form_params['first_name'], $form_params['last_name'] ) ) {
				$donation_details['comment_author'] = $form_params['first_name'] . " " . $form_params['last_name'];
			}
			if ( isset( $form_params['email'] ) ) {
				$donation_details['comment_author_email'] = $form_params['email'];
			}
			
			$donation_details['blog'] = get_option( 'home' );
			$donation_details['blog_lang'] = get_locale();
			$donation_details['blog_charset'] = get_option( 'blog_charset' );
			$donation_details['user_ip'] = $_SERVER['REMOTE_ADDR'];
			$donation_details['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
			$donation_details['referrer'] = $_SERVER['HTTP_REFERER'];
			$donation_details['comment_type'] = 'donation-form';

			if ( $permalink = \get_permalink() ) {
				$donation_details['permalink'] = $permalink;
			}

			$ignore = array( 'HTTP_COOKIE', 'HTTP_COOKIE2', 'PHP_AUTH_PW' );

			foreach ( $_SERVER as $key => $value ) {
				if ( ! in_array( $key, (array) $ignore ) ) {
					$donation_details["$key"] = $value;
				}
			}

			return ! $this->charitable_akismet_api_call( $donation_details ); 

		}

	}

endif;
