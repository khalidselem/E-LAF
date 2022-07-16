<?php

namespace Codemanas\ZoomWooBookingAddon\Admin\Bookings;

/**
 * Class BookingsWPML
 *
 * Save WPML products
 *
 * @author Deepen Bajracharya, CodeManas, 2020. All Rights reserved.
 * @package Codemanas\ZoomWooBookingAddon\Admin
 * @since 1.0.0
 */
class BookingsWPML {

	public function __construct() {
		add_action( 'wcml_before_sync_product_data', [ $this, 'sync_bookings' ], 10, 3 );
		add_action( 'wcml_before_sync_product', [ $this, 'sync_booking_data' ], 10, 2 );

		//Booking
		add_action( 'woocommerce_booking_paid', array( $this, 'update_status_for_translations' ), 20 );
		add_action( 'woocommerce_booking_confirmed', array( $this, 'update_status_for_translations' ), 20 );
	}

	/**
	 * Sync zoom details when a translation is edited from translation screen.
	 *
	 * @param $original_product_id
	 * @param $product_id
	 * @param $language
	 */
	public function sync_bookings( $original_product_id, $product_id, $language ) {
		if ( has_term( 'booking', 'product_type', $original_product_id ) && has_term( 'booking', 'product_type', $product_id ) ) {
			// Sync Zoom Fields
			$this->sync_zoom_fields( $original_product_id, $product_id, $language );
		}
	}

	/**
	 * Sync zoom details when an original product is edited.
	 *
	 * @param $original_product_id
	 * @param $current_product_id
	 */
	public function sync_booking_data( $original_product_id, $current_product_id ) {
		if ( has_term( 'booking', 'product_type', $original_product_id ) ) {
			global $wpml_post_translations;
			$translations = $wpml_post_translations->get_element_translations( $original_product_id, false, true );
			foreach ( $translations as $translation ) {
				$language = $wpml_post_translations->get_element_lang_code( $translation );

				// Sync Zoom Fields
				$this->sync_zoom_fields( $original_product_id, $translation, $language );
			}
		}
	}

	/**
	 * Sync fields to new product created
	 *
	 * @param $original_product_id
	 * @param $translated_product_id
	 * @param $lang_code
	 * @param bool $duplicate
	 */
	public function sync_zoom_fields( $original_product_id, $translated_product_id, $lang_code, $duplicate = true ) {
		$old_values = array(
			'_vczapi_woo_addon_booking_enable_zoom'   => get_post_meta( $original_product_id, '_vczapi_woo_addon_booking_enable_zoom', true ),
			'_vczapi_woo_addon_booking_product_host'  => get_post_meta( $original_product_id, '_vczapi_woo_addon_booking_product_host', true ),
			'_vczapi_woo_addon_booking_jbh'           => get_post_meta( $original_product_id, '_vczapi_woo_addon_booking_jbh', true ),
			'_vczapi_woo_addon_booking_enforce_login' => get_post_meta( $original_product_id, '_vczapi_woo_addon_booking_enforce_login', true ),
		);

		foreach ( $old_values as $k => $new_value ) {
			update_post_meta( $translated_product_id, $k, $new_value );
		}
	}

	/**
	 * Update same details for the translated order as well.
	 *
	 * @param $booking_id
	 */
	public function update_status_for_translations( $booking_id ) {
		global $sitepress;
		$original_booking_id = $sitepress->get_original_element_id( $booking_id, 'post_product' );
		//Get Original Booking ID and fetch its data
		if ( ! empty( $original_booking_id ) ) {
			$booking_fields = array(
				'_vczapi_woo_addon_meeting_details' => get_post_meta( $original_booking_id, '_vczapi_woo_addon_meeting_details', true ),
				'_vczapi_woo_addon_meeting_exists'  => get_post_meta( $original_booking_id, '_vczapi_woo_addon_meeting_exists', true ),
				'_vczapi_woo_addon_meeting_error'   => get_post_meta( $original_booking_id, '_vczapi_woo_addon_meeting_error', true )
			);
		} else {
			$details = get_post_meta( $booking_id, '_vczapi_woo_addon_meeting_details', true );
			$exists  = get_post_meta( $booking_id, '_vczapi_woo_addon_meeting_exists', true );
			$error   = get_post_meta( $booking_id, '_vczapi_woo_addon_meeting_error', true );
			if ( ! empty( $details ) ) {
				$booking_fields['_vczapi_woo_addon_meeting_details'] = $details;
			}

			if ( ! empty( $exists ) ) {
				$booking_fields['_vczapi_woo_addon_meeting_exists'] = $exists;
			}

			if ( ! empty( $error ) ) {
				$booking_fields['_vczapi_woo_addon_meeting_error'] = $error;
			}
		}

		//Save Fields with the acquired data
		global $wpml_post_translations;
		if ( ! empty( $booking_fields ) ) {
			$get_translated_bookings = $wpml_post_translations->get_element_translations( $booking_id, false, false );
			foreach ( $get_translated_bookings as $lang => $translated_booking_id ) {
				if ( ! empty( $booking_fields['_vczapi_woo_addon_meeting_details'] ) ) {
					update_post_meta( $translated_booking_id, '_vczapi_woo_addon_meeting_details', $booking_fields['_vczapi_woo_addon_meeting_details'] );
				}

				if ( ! empty( $booking_fields['_vczapi_woo_addon_meeting_exists'] ) ) {
					update_post_meta( $translated_booking_id, '_vczapi_woo_addon_meeting_exists', $booking_fields['_vczapi_woo_addon_meeting_exists'] );
				}

				if ( ! empty( $booking_fields['_vczapi_woo_addon_meeting_error'] ) ) {
					update_post_meta( $translated_booking_id, '_vczapi_woo_addon_meeting_error', $booking_fields['_vczapi_woo_addon_meeting_error'] );
				}
			}
		}
	}
}