<?php

namespace Codemanas\ZoomWooBookingAddon\Admin\Bookings;

use Codemanas\ZoomWooBookingAddon\DataStore as DataStore;

/**
 * Class BookingTable
 *
 * Manage all booking admin settings from here
 *
 * @author Deepen Bajracharya, CodeManas, 2020. All Rights reserved.
 * @package Codemanas\ZoomWooBookingAddon\Admin
 * @since 1.0.0
 */
class BookingTable {

	private $type = 'wc_booking';

	public function __construct() {
		add_filter( 'manage_' . $this->type . '_posts_columns', array( $this, 'add_columns' ), 20 );
		add_action( 'manage_' . $this->type . '_posts_custom_column', array( $this, 'render_data' ), 20, 2 );
	}

	/**
	 * Add New Start Link column
	 *
	 * @param $columns
	 *
	 * @return mixed
	 */
	public function add_columns( $columns ) {
		$columns['zoom_start_link'] = __( 'Start Link', 'vczapi-woo-addon' );

		return $columns;
	}

	/**
	 * Render HTML
	 *
	 * @param $column
	 * @param $post_id
	 */
	public function render_data( $column, $post_id ) {
		switch ( $column ) {

			case 'zoom_start_link' :
				echo DataStore::get_start_link( get_wc_booking( $post_id ) );
				break;
		}
	}
}