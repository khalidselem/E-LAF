<?php

namespace Codemanas\ZoomWooBookingAddon\Admin\Woocommerce;

/**
 * Class BookingTable
 *
 * Manage all booking admin settings from here
 *
 * @author Deepen Bajracharya, CodeManas, 2020. All Rights reserved.
 * @package Codemanas\ZoomWooBookingAddon\Admin
 * @since 1.0.0
 */
class WooCommerceTable {

	private $type = 'product';

	public function __construct() {
		add_action( 'manage_' . $this->type . '_posts_custom_column', array( $this, 'render_data' ), 20, 2 );
	}

	/**
	 * Render HTML
	 *
	 * @param $column
	 * @param $post_id
	 */
	public function render_data( $column, $post_id ) {
		if ( $column === "name" ) {
			$product = wc_get_product( $post_id );
			if ( $product->get_type() === "zoom_meeting" ) {
				echo "<strong>- Zoom Product</strong>";
			}
		}
	}
}