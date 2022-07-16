<?php

use Codemanas\ZoomWooBookingAddon\DataStore;

$query = new \WC_Order_Query( array(
	'limit'       => - 1,
	'orderby'     => 'date',
	'order'       => 'DESC',
	'customer_id' => get_current_user_id(),
	'status'      => array( 'completed', 'processing' ),
) );

$orders    = $query->get_orders();
$tbl_class = apply_filters( 'vczapi_woocommerce_addon_meeting_table_class', 'woocommerce-orders-table woocommerce-MyAccount-orders shop_table shop_table_responsive my_account_orders account-orders-table woocommerce-zoom-meetings' );
?>
<table class="<?php echo $tbl_class; ?>">
    <thead>
    <tr>
        <th class="woocommerce-orders-table__header woocommerce-orders-table__header-order-number">
            <span class="nobr"><?php _e( 'Order', 'vczapi-woo-addon' ) ?></span></th>
        <th class="woocommerce-orders-table__header woocommerce-orders-table__header-order-date">
            <span class="nobr"><?php _e( 'Date', 'vczapi-woo-addon' ) ?></span></th>
        <th class="woocommerce-orders-table__header woocommerce-orders-table__header-order-actions">
            <span class="nobr"><?php _e( 'Join', 'vczapi-woo-addon' ) ?></span></th>
        <th class="woocommerce-orders-table__header woocommerce-orders-table__header-order-actions woocommerce-orders-table__meeting_post__header">
            <span class="nobr"><?php _e( 'Meeting Link', 'vczapi-woo-addon' ) ?></span></th>
    </tr>
    </thead>
    <tbody>
	<?php
	$count = 0;
	if ( ! empty( $orders ) ) {
		foreach ( $orders as $order ) {
			$items = $order->get_items();
			if ( ! empty( $items ) ) {
				foreach ( $items as $item ) {
					$post_id = get_post_meta( $item->get_product_id(), '_vczapi_zoom_post_id', true );
					$exists  = get_the_title( $post_id );

					if ( ! empty( $post_id ) && ! empty( $exists ) ) {
						$meeting_details = get_post_meta( $post_id, '_meeting_zoom_details', true );
						?>
                        <tr class="woocommerce-orders-table__row woocommerce-orders-table__row--status-processing order">
                            <td class="woocommerce-orders-table__cell woocommerce-orders-table__cell-order-number" data-title="Order">
                                <a href="<?php echo esc_url( $order->get_view_order_url() ); ?>"> <?php echo esc_html( $order->get_id() ); ?></a>
                            </td>
                            <td class="woocommerce-orders-table__cell woocommerce-orders-table__cell-order-date" data-title="Date">
								<?php
								if ( ( $meeting_details->type === 8 || $meeting_details->type === 3 ) && vczapi_recurring_addon_active() ) {
									$meeting_details->occurrences = ! empty( $meeting_details->occurrences ) ? $meeting_details->occurrences : false;
									$now                          = new \DateTime( 'now -1 hour', new \DateTimeZone( $meeting_details->timezone ) );
									$next_occurence               = false;
									if ( $meeting_details->type === 8 && ! empty( $meeting_details->occurrences ) ) {
										foreach ( $meeting_details->occurrences as $occurrence ) {
											if ( $occurrence->status === "available" ) {
												$start_date = new \DateTime( $occurrence->start_time, new \DateTimeZone( $meeting_details->timezone ) );
												if ( $start_date >= $now ) {
													$next_occurence = $occurrence->start_time;
													break;
												}

												$next_occurence = 'ended';
												break;
											}
										}
									} else if ( $meeting_details->type === 3 ) {
										//No time fixed meeting
										$next_occurence = false;
									} else {
										//Set Past date
										$next_occurence = 'ended';
									}

									if ( ! $next_occurence ) {
										$next_occurence = __( 'No fixed time Meeting', 'vczapi-woo-addon' );
									} else if ( $next_occurence === "ended" ) {
										$next_occurence = __( 'Meeting Ended', 'vczapi-woo-addon' );
									} else {
										$next_occurence = vczapi_dateConverter( $next_occurence, $meeting_details->timezone, 'F j, Y, g:i a' );
									}

									echo $next_occurence;
								} else {
									echo vczapi_dateConverter( $meeting_details->start_time, $meeting_details->timezone, 'F j, Y @ g:i a' );
								}
								?>
                            </td>
                            <td class="woocommerce-orders-table__cell woocommerce-orders-table__cell-order-actions" data-title="Actions">
								<?php
								$disabled = get_option( '_vczapi_woocommerce_disable_browser_join' );
								echo '<a target="_blank" class="vzapi-woo-join-meeting-btn" rel="nofollow" href="' . esc_url( $meeting_details->join_url ) . '">' . __( "via App", "vczapi-woo-addon" ) . '</a>';
								if ( empty( $disabled ) ) {
									$pwd = ! empty( $meeting_details->password ) ? $meeting_details->password : false;
									echo ' / ' . DataStore::get_browser_join_link( $meeting_details->id, $pwd );
								} ?>
                            </td>
                            <td class="woocommerce-orders-table__cell woocommerce-orders-table__cell-order-actions woocommerce-orders-table__meeting_post" data-title="Actions">
								<?php
								echo '<a class="vzapi-woo-join-meeting-btn" rel="nofollow" href="' . esc_url( get_permalink( $post_id ) ) . '">' . __( "View Post", "vczapi-woo-addon" ) . '</a>';
								?>
                            </td>
                        </tr>
						<?php
						$count ++;
					}
				}
			}
		}

		if ( $count === 0 ) {
			\Codemanas\ZoomWooBookingAddon\WooCommerce\Orders::output_no_order_text();
		}
	} else {
		\Codemanas\ZoomWooBookingAddon\WooCommerce\Orders::output_no_order_text();
	}
	?>
    </tbody>
</table>

