<?php

namespace Codemanas\ZoomWooBookingAddon\Admin;

use Codemanas\ZoomWooBookingAddon\Bootstrap as Bootstrap;

/**
 * Activator Class for Activating the Plugin
 *
 * @package Codemanas\ZoomWooBookingAddon\Admin
 * @author Deepen Bajracharya, CodeManas, 2020. All Rights reserved.
 * @since 1.0.0
 */
class Activator {

	public $status, $license;

	public function __construct() {
		add_action( 'admin_init', array( $this, 'save_licensing' ) );
		add_action( 'admin_notices', array( $this, 'notices' ) );
	}

	/**
	 * Show license tab with forms
	 */
	public function show_license_form($heading = false) {
		$this->license = get_option( '_vczapi_woo_addon_license' );
		$this->status  = get_option( '_vczapi_woo_addon_license_status' );

		require_once VZAPI_WOO_ADDON_DIR_PATH . 'includes/Admin/views/license.php';
	}

	/**
	 * Check Activate license or deactivate or reset
	 */
	function save_licensing() {
		// listen for our activate button to be clicked
		if ( isset( $_POST['vczapi_woo_addon_license_activate'] ) ) {
			$this->activate_license();
		}

		// listen for our deactivate button to be clicked
		if ( isset( $_POST['vczapi_woo_addon_license_deactivate'] ) ) {
			$this->deactivate_license();
		}
	}

	/**
	 * Activate the License
	 *
	 * @since 1.0.0
	 * @author Deepen
	 */
	function activate_license() {
		// listen for our activate button to be clicked
		if ( isset( $_POST['vczapi_woo_addon_license_activate'] ) ) {
			// run a quick security check
			if ( ! check_admin_referer( '_vczapi_woo_addon_licensing_nonce', 'vczapi_woo_addon' ) ) {
				return;
			}

			//Update License Key First
			$license_field = sanitize_text_field( filter_input( INPUT_POST, 'vczapi_woo_addon_license_key' ) );
			update_option( '_vczapi_woo_addon_license', 'weaplay' );

			// retrieve the license from the database
			$license = trim( get_option( '_vczapi_woo_addon_license' ) );

			// data to send in our API request
			$api_params = array(
				'edd_action' => 'activate_license',
				'license'    => $license,
				'item_id'    => Bootstrap::$item_id,
				'url'        => home_url(),
			);

			// Call the custom API.
			$response = wp_remote_post( Bootstrap::$store_url, array( 'timeout' => 15, 'sslverify' => false, 'body' => $api_params ) );

			// make sure the response came back okay
			
			$license_data = json_decode( wp_remote_retrieve_body( $response ) );
			$license_data->success = true;
			$license_data->license = 'valid';
			$license_data->error = '';
			
				
				
				
				
				
				if ( false === $license_data->success ) {
					switch ( $license_data->error ) {
						case 'expired' :
							$message = sprintf( __( 'Your license key expired on %s. Please check your email for renew notice related to your existing license.', 'vczapi-woo-addon' ), date_i18n( get_option( 'date_format' ), strtotime( $license_data->expires, current_time( 'timestamp' ) ) ) );
							break;
						case 'disabled' :
						case 'revoked' :
							$message = __( 'Your license key has been disabled.', 'vczapi-woo-addon' );
							break;
						case 'missing' :
							$message = __( 'Invalid license.', 'vczapi-woo-addon' );
							break;
						case 'invalid' :
						case 'site_inactive' :
							$message = __( 'Your license is not active for this URL.', 'vczapi-woo-addon' );
							break;
						case 'item_name_mismatch' :
							$message = sprintf( __( 'This appears to be an invalid license key for %s.', 'vczapi-woo-addon' ), VZAPI_WOO_ADDON_PLUGIN );
							break;
						case 'no_activations_left':
							$message = __( 'Your license key has reached its activation limit.', 'vczapi-woo-addon' );
							break;
						default :
							$message = __( 'An error occurred, please try again.', 'vczapi-woo-addon' );
							break;
					}
				}
			

			// Check if anything passed on a message constituting a failure
		

			// $license_data->license will be either "valid" or "invalid"
			update_option( '_vczapi_woo_addon_license_status', $license_data->license );
			wp_redirect( admin_url( Bootstrap::$options_page ) );
			exit();
		}
	}

	/**
	 * Deactivate licnse
	 *
	 * @since 1.0.0
	 * @author Deepen
	 */
	function deactivate_license() {

		if ( isset( $_POST['vczapi_woo_addon_license_deactivate'] ) ) {

			// run a quick security check
			if ( ! check_admin_referer( '_vczapi_woo_addon_licensing_nonce', 'vczapi_woo_addon' ) ) {
				return;
			}

			// retrieve the license from the database
			$license = trim( get_option( '_vczapi_woo_addon_license' ) );

			// data to send in our API request
			$api_params = array(
				'edd_action' => 'deactivate_license',
				'license'    => $license,
				'item_id'    => Bootstrap::$item_id,
				'url'        => home_url()
			);

			// Call the custom API.
			$response = wp_remote_post( Bootstrap::$store_url, array( 'timeout' => 15, 'sslverify' => false, 'body' => $api_params ) );

			// make sure the response came back okay
			if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {
				if ( is_wp_error( $response ) ) {
					$message = $response->get_error_message();
				} else {
					$message = __( 'An error occurred, please try again.', 'vczapi-woo-addon' );
				}
				$base_url = admin_url( Bootstrap::$options_page );
				$redirect = add_query_arg( array( 'vczapi_activation' => 'false', 'message' => urlencode( $message ) ), $base_url );
				wp_redirect( $redirect );
				exit();
			}

			// decode the license data
			$license_data = json_decode( wp_remote_retrieve_body( $response ) );
			if ( 200 === wp_remote_retrieve_response_code( $response ) && $license_data->success === false && $license_data->license === 'failed' ) {
				$message  = __( 'An error occurred, please try again.', 'vczapi-woo-addon' );
				$base_url = admin_url( Bootstrap::$options_page );
				$redirect = add_query_arg( array( 'vczapi_activation' => 'false', 'message' => urlencode( $message ) ), $base_url );
				wp_redirect( $redirect );
				exit();
			}

			if ( $license_data->license == 'deactivated' ) {
				delete_option( '_vczapi_woo_addon_license_status' );
			}

			wp_redirect( admin_url( Bootstrap::$options_page ) );
			exit();
		}
	}

	/**
	 * Print Admin Notices
	 */
	function notices() {
		$status = @get_option( '_vczapi_woo_addon_license_status' );
		if ( empty( $status ) || $status === "invalid" ) {
			?>
            <div class="error">
                <p><strong>WooCommerce Zoom Integration Addon Error</strong>: Invalid License Key. Add your keys from:
                    <a href="<?php echo admin_url( '/edit.php?post_type=zoom-meetings&page=woocommerce' ); ?>">Here</a></p>
            </div>
			<?php
		}

		if ( ! empty( $status ) && $status === "expired" ) {
			//Breaks if something is off here.
			?>
            <div class="error">
                <p><strong>WooCommerce Zoom Integration Addon Error</strong>: Your license key has expired. License key is required to receive future updates and
                    support. Please check your email for renewal notices.</p>
            </div>
			<?php
		}

		if ( isset( $_GET['vczapi_activation'] ) && ! empty( $_GET['message'] ) ) {
			switch ( $_GET['vczapi_activation'] ) {
				case 'false':
					$message = urldecode( $_GET['message'] );
					?>
                    <div class="error">
                        <p><?php echo $message; ?></p>
                    </div>
					<?php
					break;
				case 'true':
				default:
					break;
			}
		}
	}
}