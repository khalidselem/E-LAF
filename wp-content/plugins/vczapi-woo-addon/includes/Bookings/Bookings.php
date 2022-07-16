<?php

namespace Codemanas\ZoomWooBookingAddon\Bookings;

use Codemanas\ZoomWooBookingAddon\DataStore;

/**
 * Class Bookings
 *
 * Handle WooCommerce Booking Operations
 *
 * @author  Deepen Bajracharya, CodeManas, 2020. All Rights reserved.
 * @since   1.0.0
 * @package Codemanas\ZoomWooBookingAddon
 */
class Bookings extends DataStore {

	public function __construct() {
		//WooCommerce
		add_action( 'woocommerce_order_status_completed', array( $this, 'wc_booking_completed' ), 5 );
		add_action( 'woocommerce_order_status_processing', array( $this, 'wc_booking_completed' ), 5 );
		//add_action( 'woocommerce_order_status_cancelled', array( $this, 'wc_booking_delete' ) );

		//Booking
		add_action( 'woocommerce_new_booking', array( $this, 'booking_create' ), 10 );
		add_action( 'woocommerce_booking_paid', array( $this, 'booking_paid' ), 10 );
		add_action( 'woocommerce_booking_confirmed', array( $this, 'booking_paid' ), 10 );
		add_action( 'woocommerce_booking_cancelled', array( $this, 'booking_cancelled' ), 10 );

		//add_action( 'woocommerce_delete_order_items', array( $this, 'wc_booking_delete' ) );

		//WooCommerce Email Template
		add_action( 'woocommerce_order_item_meta_end', array( $this, 'email_meeting_details' ), 10, 3 );

		//Add Dropdown list
		add_action( 'woocommerce_before_booking_form', array( $this, 'host_list' ) );
		add_action( 'before_delete_post', [ $this, 'before_delete_booking' ] );

		//Google Calendar Integration
		add_filter( 'woocommerce_bookings_gcalendar_sync', [ $this, 'add_zoom_meeting_to_google_calendar' ], 10, 2 );
	}

	/**
	 * @param $booking_id
	 * @param $product_id
	 *
	 * @return int|void
	 */
	public function get_bookings_on_date_count( $booking_id, $product_id ) {
		$meeting_start_time = get_post_meta( $booking_id, '_booking_start', true );
		$meeting_end_time   = get_post_meta( $booking_id, '_booking_end', true );
		$booking_statuses   = (array) get_wc_booking_statuses();
		$booking_statuses[] = 'trash';
		$args               = [
			'object_id'    => $product_id,
			'object_type'  => 'product',
			'status'       => $booking_statuses,
			'limit'        => - 1,
			'date_between' => [
				'start' => strtotime( $meeting_start_time ),
				'end'   => strtotime( $meeting_end_time ),
			],
		];
		$bookings_on_date   = \WC_Booking_Data_Store::get_booking_ids_by( $args );

		return count( $bookings_on_date );
	}

	/**
	 * Create booking meeting based on order ID
	 *
	 * @param $order_id
	 */
	public function wc_booking_completed( $order_id ) {
		$booking_ids = \WC_Booking_Data_Store::get_booking_ids_from_order_id( $order_id );
		if ( ! empty( $booking_ids ) ) {
			foreach ( $booking_ids as $booking_id ) {
				$host   = get_post_meta( $booking_id, '_vczapi_booking_host_list', true );
				$host   = ! empty( $host ) ? $host : false;
				$exists = get_post_meta( $booking_id, '_vczapi_woo_addon_meeting_exists', true );
				if ( empty( $exists ) ) {
					$wc_booking = get_wc_booking( $booking_id );
					//Create Meeting
					$this->create_meeting( $wc_booking, $booking_id, $order_id, $host );
				}
			}
		}
	}

	/**
	 * Update host meta when booking is created
	 *
	 * @param $booking_id
	 */
	public function booking_create( $booking_id ) {
		if ( isset( $_POST['vczapi_bookings_host_list'] ) ) {
			$host_id = sanitize_text_field( filter_input( INPUT_POST, 'vczapi_bookings_host_list' ) );
			update_post_meta( $booking_id, '_vczapi_booking_host_list', $host_id );
		}
	}

	/**
	 * Create Meeting if booking status is changed to Paid in wc-booking order page.
	 *
	 * @param $booking_id
	 */
	public function booking_paid( $booking_id ) {
		$host = get_post_meta( $booking_id, '_vczapi_booking_host_list', true );
		$host = ! empty( $host ) ? $host : false;

		$wc_booking = get_wc_booking( $booking_id );
		$order_id   = $wc_booking->get_order_id();
		$exists     = get_post_meta( $booking_id, '_vczapi_woo_addon_meeting_exists', true );
		$error      = get_post_meta( $booking_id, '_vczapi_woo_addon_meeting_error', true );
		if ( empty( $exists ) && ! empty( $error ) ) {
			//Create Meeting
			$this->create_meeting( $wc_booking, $booking_id, $order_id, $host );
		}
	}

	/**
	 * Delete meeting When booking order is Cancelled from wc-booking page.
	 *
	 * @param $booking_id
	 */
	public function booking_cancelled( $booking_id ) {
		$booking                = get_wc_booking( $booking_id );
		$order_id               = $booking->get_order_id();
		$product_id             = $booking->get_product_id();
		$bookings_on_date_count = $this->get_bookings_on_date_count( $booking_id, $product_id );
		//if count is greater than or equal to one - doing this because order status has changed to cancel 1 it indicates that there are still other bookings on this same time for this same product so bail early
		if ( $bookings_on_date_count >= 1 ) {
			return;
		}

		$this->delete_meeting( $booking_id, $order_id, $product_id );
	}

	/**
	 * Delete Meeting when booking is deleted
	 *
	 * @param $booking_id
	 */
	public function before_delete_booking( $booking_id ) {
		if ( 'wc_booking' != get_post_type( $booking_id ) ) {
			return;
		}
		$booking = get_wc_booking( $booking_id );
		if ( is_object( $booking ) ) {
			$exists     = get_post_meta( $booking_id, '_vczapi_woo_addon_meeting_exists', true );
			$product_id = $booking->get_product_id();
			if ( ! empty( $exists ) ) {
				$bookings_on_date_count = $this->get_bookings_on_date_count( $booking_id, $product_id );

				//if count is greater than 1 it indicates that there are still other bookings on this same time for this same product so bail early
				if ( $bookings_on_date_count > 1 ) {
					return;
				}
				$this->delete_meeting( $booking_id, $booking->get_order_id(), $product_id );
			}
		}
	}

	/**
	 * Show in order emails
	 *
	 * @param $item_id
	 * @param $item
	 * @param $order
	 */
	public function email_meeting_details( $item_id, $item, $order ) {
		$booking_ids = \WC_Booking_Data_Store::get_booking_ids_from_order_item_id( $item_id );
		if ( ! empty( $booking_ids ) ) {
			foreach ( $booking_ids as $booking_id ) {
				$booking  = get_wc_booking( $booking_id );
				$meeting  = get_post_meta( $booking_id, '_vczapi_woo_addon_meeting_details', true );
				$meeting  = ! empty( $meeting ) ? json_decode( $meeting ) : false;
				$disabled = get_option( '_vczapi_woocommerce_disable_browser_join' );			
				if ( ! empty( $meeting ) && in_array($order->get_status(),['completed','processing']) && $booking->get_status() === 'paid' ) {
					do_action( 'vczapi_bookings_before_meeting_details', $meeting );

					echo '<p style="margin: 20px 0;"><a target="_blank" rel="nofollow" href="' . esc_url( $meeting->join_url ) . '">' . apply_filters( 'vczoom_join_meeting_via_app_text', __( 'Join via App.', 'vczapi-woo-addon' ) ) . '</a>';
					if ( empty( $disabled ) ) {
						$password = ! empty( $meeting->password ) ? $meeting->password : false;
						echo '/' . DataStore::get_browser_join_link( $meeting->id, $password );
					}
					echo "</p>";

					do_action( 'vczapi_bookings_after_meeting_details', $meeting );
				}
			}
		}
	}

	/**
	 * Show Host List if host list is checked
	 *
	 * @author Deepen
	 * @since  2.0.0
	 */
	public function host_list() {
		$product_id = get_the_id();
		$enable     = get_post_meta( $product_id, '_vczapi_woo_addon_booking_enable_zoom', true );
		$host_list  = get_post_meta( $product_id, '_vczapi_woo_addon_booking_host_list_frontend', true );
		if ( ! empty( $enable ) && ! empty( $host_list ) ) {
			$users = video_conferencing_zoom_api_get_user_transients();
			if ( ! empty( $users ) ) {
				?>
                <strong><?php echo apply_filters( 'vczapi_booking_choose_host_label', __( 'Choose Host:', 'vczapi-woo-addon' ) ); ?></strong>
                <select class="vczapi-booking-addon-host-list" name="vczapi_bookings_host_list">
					<?php foreach ( $users as $user ) { ?>
                        <option value="<?php echo $user->id; ?>"><?php echo ! empty( $user->first_name ) ? $user->first_name . ' ' . $user->last_name : $user->email; ?></option>
					<?php } ?>
                </select>
				<?php
			}
		}
	}

	/**
	 * @param \Google_Service_Calendar_Event $event
	 * @param \WC_Booking                    $booking
	 *
	 * @return mixed
	 */
	public function add_zoom_meeting_to_google_calendar( $event, $booking ) {
		$booking_html = DataStore::get_join_link( $booking );
		if ( ! empty( $booking_html ) ) {
			$eventDescription = $event->getDescription();
			$eventDescription .= PHP_EOL . __( 'Join via Zoom :' ) . ' ' . $booking_html . PHP_EOL;
			$event->setDescription( $eventDescription );
		}

		return $event;
	}
}