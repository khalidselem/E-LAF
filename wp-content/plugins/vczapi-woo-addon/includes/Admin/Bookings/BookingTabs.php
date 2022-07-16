<?php

namespace Codemanas\ZoomWooBookingAddon\Admin\Bookings;

/**
 * Class ProductTabs
 *
 * Display and render new tabs in single product page on wp-admin
 *
 * @author  Deepen Bajracharya, CodeManas, 2020. All Rights reserved.
 * @package Codemanas\ZoomWooBookingAddon\Admin
 * @since   1.0.0
 */
class BookingTabs {

	public function __construct() {
		add_filter( 'woocommerce_product_data_tabs', array( $this, 'register_tabs' ) );
		add_action( 'woocommerce_product_data_panels', array( $this, 'render_panels' ) );
		add_action( 'woocommerce_process_product_meta_booking', array( $this, 'save' ) );
	}

	/**
	 * Register New tab event
	 *
	 * @param $tabs
	 *
	 * @return mixed
	 */
	public function register_tabs( $tabs ) {
		$tabs['vczapi-woo-addon'] = array(
			'label'  => __( 'Zoom', 'vczapi-woo-addon' ),
			'target' => 'vczapi_woo_addon_product_data',
			'class'  => array(
				'show_if_booking vczapi-zoom-booking-icon',
			)
		);

		return $tabs;
	}

	/**
	 * Render tab panel HTML
	 */
	public function render_panels() {
		global $post;
		?>
        <div id='vczapi_woo_addon_product_data' class='panel woocommerce_options_panel'>
			<?php
			$users        = video_conferencing_zoom_api_get_user_transients();
			$user_options = array();
			if ( ! empty( $users ) ) {
				foreach ( $users as $user ) {
					$user_options[ $user->id ] = ! empty( $user->first_name ) ? $user->first_name . ' ' . $user->last_name : $user->email;
				}
			}
			$user_options = apply_filters( 'vczapi_bookings_hosts', $user_options );
			$saved_host   = get_post_meta( $post->ID, '_vczapi_woo_addon_booking_product_host', true );
			$host_exists  = false;
			if ( ! empty( $saved_host ) ) {
				foreach ( $user_options as $host_id => $host_name ) {
					if ( $host_id == $saved_host ) {
						$host_exists = true;
						break;
					}
				}
			}

			if ( $host_exists == false ) {
				?>
                <p class="warning" style="color:red; padding-left:10px;">
					<?php
					_e( 'WARNING: It seems like Zoom Host previously saved no longer exists, this will cause issues when booking is made,
				    Please select a host and save the product again.' );
					?>
                </p>
				<?php
			}
			?>
            <div class='options_group'>
				<?php


				woocommerce_wp_checkbox( array(
					'id'          => '_vczapi_woo_addon_booking_enable_zoom',
					'label'       => __( 'Enable Zoom Meeting', 'vczapi-woo-addon' ),
					'description' => __( 'Checking this option will create a meeting when this product is booked.', 'vczapi-woo-addon' ),
					'default'     => '0',
					'desc_tip'    => false,
				) );

				woocommerce_wp_select(
					array(
						'id'          => '_vczapi_woo_addon_booking_product_host',
						'label'       => __( 'Default Host', 'woocommerce' ),
						'options'     => $user_options,
						'description' => __( 'Select which host would be responsible for hosting this booking product. Add more users to your zoom account to show them here.', 'vczapi-woo-addon' ),
						'desc_tip'    => true,
					)
				);

				woocommerce_wp_checkbox( array(
					'id'          => '_vczapi_woo_addon_booking_host_list_frontend',
					'label'       => __( 'Allow customer choose HOST?', 'vczapi-woo-addon' ),
					'description' => __( 'Allow customers to choose above host list at the time booking in frontend. If you enable this above host will not be used.', 'vczapi-woo-addon' ),
					'default'     => '0',
					'desc_tip'    => false,
				) );

				woocommerce_wp_checkbox( array(
					'id'          => '_vczapi_woo_addon_booking_jbh',
					'label'       => __( 'Allow Join Before Host ?', 'vczapi-woo-addon' ),
					'description' => __( 'Allow participants to join the meeting before the host starts the meeting. Only used for scheduled or recurring meetings.', 'vczapi-woo-addon' ),
					'default'     => '0',
					'desc_tip'    => false,
				) );

				woocommerce_wp_checkbox( array(
					'id'          => '_vczapi_woo_addon_booking_enforce_login',
					'label'       => __( 'Enforce Login ?', 'vczapi-woo-addon' ),
					'description' => __( 'Only signed in users can join this meeting. i.e Signed into Zoom Account.', 'vczapi-woo-addon' ),
					'default'     => '0',
					'desc_tip'    => false,
				) );

				woocommerce_wp_text_input( [
					'id'                => '_vczapi_woo_addon_booking_passcode',
					'label'             => __( 'Enter Passcode/Password', 'vczapi-woo-addon' ),
					'description'       => __( 'Enter a passcode/password for meetings - all Zoom Meetings made using this product will use this password - if left empty it will use the booking id
					- sNote this password will not update if you update password on Zoom', 'vczapi-woo-addon' ),
					'desc_tip'          => true,
					'default'           => '',
					'custom_attributes' => array(
						'maxlength' => '10'
					)
				] );
				?>
            </div>
            <p class="description" style="color:red;">NOTE: If you enable Zoom Meetings, <strong>General > Booking Duration</strong> should be defined
                in hours or minutes.</p>
        </div>
		<?php
	}

	/**
	 * Save Tab Data on post
	 *
	 * @param $post_id
	 */
	function save( $post_id ) {
		$enable        = sanitize_text_field( filter_input( INPUT_POST, '_vczapi_woo_addon_booking_enable_zoom' ) );
		$host          = sanitize_text_field( filter_input( INPUT_POST, '_vczapi_woo_addon_booking_product_host' ) );
		$host_list     = sanitize_text_field( filter_input( INPUT_POST, '_vczapi_woo_addon_booking_host_list_frontend' ) );
		$jbh           = sanitize_text_field( filter_input( INPUT_POST, '_vczapi_woo_addon_booking_jbh' ) );
		$enforce_login = sanitize_text_field( filter_input( INPUT_POST, '_vczapi_woo_addon_booking_enforce_login' ) );
		$passcode      = sanitize_text_field( filter_input( INPUT_POST, '_vczapi_woo_addon_booking_passcode' ) );

		update_post_meta( $post_id, '_vczapi_woo_addon_booking_enable_zoom', $enable );
		update_post_meta( $post_id, '_vczapi_woo_addon_booking_product_host', $host );
		update_post_meta( $post_id, '_vczapi_woo_addon_booking_host_list_frontend', $host_list );
		update_post_meta( $post_id, '_vczapi_woo_addon_booking_jbh', $jbh );
		update_post_meta( $post_id, '_vczapi_woo_addon_booking_enforce_login', $enforce_login );
		if ( ! empty( $passcode ) ) {
			update_post_meta( $post_id, '_vczapi_woo_addon_booking_passcode', $passcode );
		} else {
			delete_post_meta( $post_id, '_vczapi_woo_addon_booking_passcode' );
		}
	}
}