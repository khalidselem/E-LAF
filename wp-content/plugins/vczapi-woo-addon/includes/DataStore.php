<?php

namespace Codemanas\ZoomWooBookingAddon;

/**
 * Class DataStore
 *
 * Handle the getters and setters - More needs to be done. Simple execution right now.
 *
 * @author  Deepen Bajracharya, CodeManas, 2020. All Rights reserved.
 * @since   1.0.0
 * @package Codemanas\ZoomWooBookingAddon
 */
class DataStore {
	/**
	 * Helper function to set correct time zone
	 *
	 * @return false|mixed|string|void
	 */
	private function get_system_timezone() {
		$timezone = get_option( 'timezone_string' );
		if ( empty( $timezone ) ) {
			$timezone = zvc_get_timezone_offset_wp();
		}

		if ( $timezone == false ) {
			$timezone = 'UTC';
		}

		return $timezone;
	}

	/**
	 * Get join via browser Link
	 *
	 * @param $password
	 * @param $meeting_id
	 *
	 * @return string
	 */
	public static function get_browser_join_link( $meeting_id, $password = false ) {
		$link               = get_post_type_archive_link( 'zoom-meetings' );
		$encrypt_meeting_id = vczapi_encrypt_decrypt( 'encrypt', $meeting_id );
		if ( ! empty( $password ) ) {
			$encrypt_pwd = vczapi_encrypt_decrypt( 'encrypt', $password );

			$query = add_query_arg( array( 'pak' => $encrypt_pwd, 'join' => $encrypt_meeting_id, 'type' => 'meeting' ), $link );

			return '<a target="_blank" rel="nofollow" href="' . esc_url( $query ) . '" class="btn btn-join-link btn-join-via-browser">' . apply_filters( 'vczoom_join_meeting_via_browser_text', __( 'Join via Web Browser', 'vczapi-woo-addon' ) ) . '</a>';
		} else {
			$query = add_query_arg( array( 'join' => $encrypt_meeting_id, 'type' => 'meeting' ), $link );

			return '<a target="_blank" rel="nofollow" href="' . esc_url( $query ) . '" class="btn btn-join-link btn-join-via-browser">' . apply_filters( 'vczoom_join_meeting_via_browser_text', __( 'Join via Web Browser', 'vczapi-woo-addon' ) ) . '</a>';
		}
	}

	/**
	 * Get Join link to show in frontend.
	 *
	 * @param \WC_Booking $booking
	 *
	 * @return mixed|void
	 */
	public static function get_join_link( $booking ) {
		$meeting = json_decode( get_post_meta( $booking->get_id(), '_vczapi_woo_addon_meeting_details', true ) );
		if ( ! empty( $meeting ) ) {
			if ( 'paid' === $booking->get_status() || 'confirmed' === $booking->get_status() || 'paid' === $booking->get_status() || 'complete' === $booking->get_status() ) {
				$disabled = get_option( '_vczapi_woocommerce_disable_browser_join' );
				$html     = '<a href="' . esc_url( $meeting->join_url ) . '" title="' . esc_attr( $meeting->topic ) . '">' . esc_html__( 'via App', 'vczapi-woo-addon' ) . '</a>';
				if ( empty( $disabled ) ) {
					$pwd  = ! empty( $meeting->password ) ? $meeting->password : false;
					$html .= ' / ' . DataStore::get_browser_join_link( $meeting->id, $pwd );
				}
			} else {
				$html = apply_filters( 'vczapi_woo_addon_join_fail_html', __( 'You have not completed your order yet.', 'vczapi-woo-addon' ) );
			}
		} else {
			$html = apply_filters( 'vczapi_woo_addon_join_fail_html', __( 'You have not completed your order yet.', 'vczapi-woo-addon' ) );
		}

		return $html;
	}

	/**
	 * Get start link from booking
	 *
	 * @param \WC_Booking $booking
	 *
	 * @return mixed|void
	 */
	public static function get_start_link( $booking ) {
		$meeting = json_decode( get_post_meta( $booking->get_id(), '_vczapi_woo_addon_meeting_details', true ) );
		if ( ! empty( $meeting ) && isset( $meeting->start_url ) ) {
			$html = '<a href="' . esc_url( $meeting->start_url ) . '" title="' . esc_attr( $meeting->topic ) . '">' . esc_html__( 'Start', 'vczapi-woo-addon' ) . '</a>';
		} else {
			$html = apply_filters( 'vczapi_woo_addon_start_fail_html', 'N/A', 'no-meeting' );
		}

		return $html;
	}


	/**
	 * Get resource ID if available otherwise return false
	 *
	 * @param $wc_booking
	 *
	 * @return false|mixed
	 */
	public function get_bookable_resource_host( $wc_booking ) {
		$host = false;
		if ( $wc_booking->has_resources() ) {
			$resource_id            = $wc_booking->get_resource_id();
			$is_zoom_resource       = get_post_meta( $resource_id, 'vczapi_is_zoom_resource', true );
			$bookable_resource_host = get_post_meta( $resource_id, 'vczapi_bookable_resource_host', true );

			if ( $is_zoom_resource && ! empty( $bookable_resource_host ) ) {
				$host = $bookable_resource_host;
			}
		}

		return $host;
	}

	/**
	 * Create Meeting Finally !
	 *
	 * @param \WC_Booking $wc_booking
	 * @param             $booking_id
	 * @param             $order_id
	 * @param             $host
	 */
	protected function create_meeting( $wc_booking, $booking_id, $order_id, $host = false ) {
		$product_id   = $wc_booking->get_product_id();
		$zoom_enabled = get_post_meta( $product_id, '_vczapi_woo_addon_booking_enable_zoom', true );
		$posted_data = $_POST;
		
		$enabled_zoom = apply_filters('vczapi_woo_addon_booking_enable_zoom',$zoom_enabled,$posted_data,$product_id,$booking_id,$order_id);

		if ( empty( $enabled_zoom ) ) {
			return;
		}

		//Only process if booking is not all day bookings
		if ( ! $wc_booking->get_all_day() ) {
			$start_date = $wc_booking->get_start_date( 'Y-m-d', 'H:i:s' );
			$end_date   = $wc_booking->get_end_date( 'Y-m-d', 'H:i:s' );
			$duration   = ! empty( $end_date ) ? ( strtotime( $end_date ) - strtotime( $start_date ) ) / 60 : 60;

			$timezone = $this->get_system_timezone();

			$product_host  = get_post_meta( $product_id, '_vczapi_woo_addon_booking_product_host', true );
			$jbh           = get_post_meta( $product_id, '_vczapi_woo_addon_booking_jbh', true );
			$enforce_login = get_post_meta( $product_id, '_vczapi_woo_addon_booking_enforce_login', true );
			if ( ! empty( $product_host ) ) {
				$host_id = ! empty( $host ) ? $host : $product_host;
				//check if has bookable resource as host
				$bookable_resource_host = $this->get_bookable_resource_host( $wc_booking );
				$host_id                = ! empty( $bookable_resource_host ) ? $bookable_resource_host : $host_id;
				$passcode               = get_post_meta( $product_id, '_vczapi_woo_addon_booking_passcode', true );
				$password               = ! empty( $passcode ) ? html_entity_decode( $passcode ) : $booking_id;

				$create_meeting_arr = apply_filters( 'vczapi_woo_addon_create_meeting_params', array(
					'userId'               => $host_id,
					'meetingTopic'         => "Booking Session for " . get_the_title( $product_id ) . '-' . $booking_id,
					'start_date'           => $start_date,
					'password'             => $password,
					'timezone'             => $timezone,
					'duration'             => $duration,
					'join_before_host'     => ! empty( $jbh ) ? true : false,
					'option_enforce_login' => ! empty( $enforce_login ) ? true : false
				), $wc_booking, $product_id, $order_id );

				$booked_zoom_meetings = get_post_meta( $product_id, '_vczapi_bookings_zoom_meetings', true );

				//convert  from timezone to UTC
				$date_time_for_index = new \DateTime( $start_date, new \DateTimeZone( $timezone ) );
				$date_time_for_index->setTimezone( new \DateTimeZone( 'UTC' ) );
				$save_index = $date_time_for_index->format( 'Y-m-d-H:i:s' );

				//isset and !empty
				if ( isset( $booked_zoom_meetings[ $host_id ][ $save_index ] ) && ! empty( $booked_zoom_meetings[ $host_id ][ $save_index ] ) ) {
					$meeting_created_id   = $booked_zoom_meetings[ $host_id ][ $save_index ];
					$meeting_created      = zoom_conference()->getMeetingInfo( $meeting_created_id );
					$prev_meeting_details = json_decode( $meeting_created );

					//if meeting is deleted from Zoom by user for some reason we need to recreate it.
					if ( is_object( $prev_meeting_details ) ) {
						if ( isset( $prev_meeting_details->code ) && $prev_meeting_details->code != 200 ) {
							$meeting_created     = zoom_conference()->createAMeeting( $create_meeting_arr );
							$new_meeting_details = json_decode( $meeting_created );
							//updates the index with new meeting id
							$booked_zoom_meetings[ $host_id ][ $save_index ] = $new_meeting_details->id;
							update_post_meta( $product_id, '_vczapi_bookings_zoom_meetings', $booked_zoom_meetings );
						}
					}
					//lets keep it simple for now
					update_post_meta( $order_id, '_vczapi_woo_addon_meeting_exists', true );
					update_post_meta( $booking_id, '_vczapi_woo_addon_meeting_exists', true );
					update_post_meta( $booking_id, '_vczapi_woo_addon_meeting_details', $meeting_created );
					update_post_meta( $booking_id, '_vczapi_woo_addon_meeting_error', null );
				} else {
					$meeting_created = zoom_conference()->createAMeeting( $create_meeting_arr );
					$meeting_details = json_decode( $meeting_created );
					if ( ! isset( $meeting_details->code ) || empty( $meeting_details->code ) ) {
						//If Success
						$booked_zoom_meetings                            = empty( $booked_zoom_meetings ) ? [] : $booked_zoom_meetings;
						$booked_zoom_meetings[ $host_id ][ $save_index ] = $meeting_details->id;
						update_post_meta( $product_id, '_vczapi_bookings_zoom_meetings', $booked_zoom_meetings );
						update_post_meta( $order_id, '_vczapi_woo_addon_meeting_exists', true );
						update_post_meta( $booking_id, '_vczapi_woo_addon_meeting_exists', true );
						update_post_meta( $booking_id, '_vczapi_woo_addon_meeting_details', $meeting_created );
						update_post_meta( $booking_id, '_vczapi_woo_addon_meeting_error', null );
					} else {
						//If Fails
						update_post_meta( $booking_id, '_vczapi_woo_addon_meeting_error', $meeting_created );
						$site_email  = apply_filters( 'vczapi_woo_addon_notify_email_on_error', get_option( 'admin_email' ) );
						$product_obj = wc_get_product( $product_id );
						$headers[]   = 'Content-Type: text/html; charset=UTF-8';
						/*******
						 * **********
						 * ********** Send Email Template
						 * **********
						 */
						$body          = apply_filters( 'vczapi_woo_addon_meeting_create_error_message', '<p>There was an error when creating a Zoom Meeting for booking ' . $booking_id . '<br /><br/> 
 Error message from Zoom API call: ' . $meeting_details->message . '<br /><br />
 Seems Host is not defined for the product: <strong>' . $product_obj->get_name() . '</strong> Please see the details under Zoom Details of booking here <a href="' . get_edit_post_link( $booking_id ) . '">' . get_edit_post_link( $booking_id ) . '</a>', $meeting_details, $product_id, $booking_id );
						$email_subject = 'Error when creating Zoom Meeting for Booking' . $booking_id;
						wp_mail( $site_email, $email_subject, $body, $headers );
					}
				}
				//Trigger After meeting is created
				do_action( 'vczapi_woo_addon_meeting_created', $meeting_created );
			}
		}
	}

	/**
	 * Delete Zoom Meeting Finally !
	 *
	 * @param $booking_id
	 * @param $order_id
	 * @param $product_id
	 */
	protected function delete_meeting( $booking_id, $order_id, $product_id ) {
		$meeting      = json_decode( get_post_meta( $booking_id, '_vczapi_woo_addon_meeting_details', true ) );
		$product_host = get_post_meta( $product_id, '_vczapi_woo_addon_booking_product_host', true );
		if ( ! empty( $meeting ) && ! empty( $product_host ) ) {
			do_action( 'vczapi_before_delete_meeting', $booking_id, true );
			zoom_conference()->deleteAMeeting( $meeting->id );
			delete_post_meta( $booking_id, '_vczapi_woo_addon_meeting_details' );
			delete_post_meta( $booking_id, '_vczapi_woo_addon_meeting_error' );
			delete_post_meta( $booking_id, '_vczapi_woo_addon_meeting_exists' );
			delete_post_meta( $order_id, '_vczapi_woo_addon_meeting_exists' );

			//Trigger After meeting is deleted
			do_action( 'vczapi_woo_addon_meeting_deleted', $product_host );
		}
	}

	/**
	 * Get Zoom Product type by Product ID
	 *
	 * @param $product_id
	 *
	 * @return bool
	 */
	public static function get_zoom_product_type( $product_id ) {
		$product = ! empty( $product_id ) ? wc_get_product( $product_id ) : false;
		if ( ! empty( $product ) && $product->get_type() === 'zoom_meeting' ) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Get All meetings or with meta query filter
	 *
	 * @param array $meta_query
	 *
	 * @return \WP_Post[]
	 */
	public static function get_all_meetings( $meta_query = array() ) {
		$args = array(
			'post_type'      => 'zoom-meetings',
			'posts_per_page' => - 1
		);

		if ( ! empty( $meta_query ) ) {
			$args['meta_query'] = $meta_query;
		}

		$meetings = get_posts( $args );

		return $meetings;
	}

	/**
	 * Get All orders IDs for a given product ID.
	 *
	 * @param integer $product_id   (required)
	 * @param array   $order_status (optional) Default is 'wc-completed'
	 *
	 * @return array
	 */
	public static function get_orders_ids_by_product_id( $product_id, $order_status = array( 'wc-completed', 'wc-processing' ) ) {
		global $wpdb;

		$results = $wpdb->get_col( "
	        SELECT order_items.order_id
	        FROM {$wpdb->prefix}woocommerce_order_items as order_items
	        LEFT JOIN {$wpdb->prefix}woocommerce_order_itemmeta as order_item_meta ON order_items.order_item_id = order_item_meta.order_item_id
	        LEFT JOIN {$wpdb->posts} AS 		posts ON order_items.order_id = posts.ID
	        WHERE posts.post_type = 'shop_order'
	        AND posts.post_status IN ( '" . implode( "','", $order_status ) . "' )
	        AND order_items.order_item_type = 'line_item'
	        AND order_item_meta.meta_key = '_product_id'
	        AND order_item_meta.meta_value = '$product_id'
	    " );

		return $results;
	}

	/**
	 * Get Email Reminder data
	 *
	 * @return array|mixed|void
	 */
	public static function get_email_reminder() {
		$email_settings = get_option( 'vczapi_meeting_reminder_email_settings' );
		//for backward compatibiliy for version 2.2.5 and below
		$email_settings = ! empty( $email_settings ) ? $email_settings : get_option( '_vczapi_email_settings' );
		$email_settings = ! empty( $email_settings )
			? $email_settings
			: [
				'disable_reminder' => false,
				'email_schedule'   => [ '24_hours_before' ],
				'enable_log'       => null
			];

		return $email_settings;
	}

	/**
	 * Get orders IDS from a product ID
	 *
	 * @param $product_id
	 *
	 * @return array
	 * @since 2.1.4
	 *
	 */
	static function orders_ids_from_a_product_id( $product_id ) {
		global $wpdb;

		$orders_statuses = "'wc-completed', 'wc-processing'";

		# Get All defined statuses Orders IDs for a defined product ID (or variation ID)
		return $wpdb->get_col( "
        SELECT DISTINCT woi.order_id
        FROM {$wpdb->prefix}woocommerce_order_itemmeta as woim, 
             {$wpdb->prefix}woocommerce_order_items as woi, 
             {$wpdb->prefix}posts as p
        WHERE  woi.order_item_id = woim.order_item_id
        AND woi.order_id = p.ID
        AND p.post_status IN ( $orders_statuses )
        AND woim.meta_key IN ( '_product_id', '_variation_id' )
        AND woim.meta_value LIKE '$product_id'
        ORDER BY woi.order_item_id DESC"
		);
	}
}