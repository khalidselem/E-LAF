<?php

namespace Codemanas\ZoomWooBookingAddon\Bookings;

use Codemanas\ZoomWooBookingAddon\DataStore;

/**
 * Class Shortcode
 *
 * @package Codemanas\ZoomWooBookingAddon
 * @since   2.0.2
 */
class Shortcode {

	/**
	 * Shortcode constructor.
	 */
	public function __construct() {
		add_shortcode( 'vczapi_bookings_customer_list', array( $this, 'show_meetings' ) );
	}

	/**
	 * Render Shortcode
	 *
	 * @param $args
	 *
	 * @return false|string
	 */
	public function show_meetings( $args ) {
		$args = shortcode_atts(
			array( 'user_id' => '' ),
			$args, 'vczapi_bookings_customer_list'
		);

		$bookings = new \WP_Query( array(
			'post_type'      => 'wc_booking',
			'posts_per_page' => - 1,
			'meta_query'     => array(
				array(
					'key'     => '_vczapi_woo_addon_meeting_details',
					'compare' => 'EXISTS'
				),
				array(
					'key'     => '_booking_customer_id',
					'value'   => ! empty( $args['user_id'] ) ? $args['user_id'] : get_current_user_id(),
					'compare' => '='
				)
			)
		) );

		ob_start();
		?>
        <table class="shop_table my_account_bookings">
            <thead>
            <tr>
                <th scope="col" class="booking-id"><?php esc_html_e( 'ID', 'vczapi-woo-addon' ); ?></th>
                <th scope="col" class="booked-product"><?php esc_html_e( 'Booked', 'vczapi-woo-addon' ); ?></th>
                <th scope="col" class="booking-start-date"><?php esc_html_e( 'Start Date', 'vczapi-woo-addon' ); ?></th>
                <th scope="col" class="booking-join-link"><?php esc_html_e( 'Join Link', 'vczapi-woo-addon' ); ?></th>
                <th scope="col" class="booking-status"><?php esc_html_e( 'Status', 'vczapi-woo-addon' ); ?></th>
            </tr>
            </thead>
            <tbody>
			<?php
			if ( ! empty( $bookings->have_posts() ) ) {
				while ( $bookings->have_posts() ) {
					$bookings->the_post();
					$booking = get_wc_booking( get_the_id() );
					?>
                    <tr>
                        <td class="booking-id"><?php echo esc_html( $booking->get_id() ); ?></td>
                        <td class="booked-product">
							<?php if ( $booking->get_product() && $booking->get_product()->is_type( 'booking' ) ) : ?>
                                <a href="<?php echo esc_url( get_permalink( $booking->get_product()->get_id() ) ); ?>">
									<?php echo esc_html( $booking->get_product()->get_title() ); ?>
                                </a>
							<?php endif; ?>
                        </td>
                        <td class="booking-start-date"><?php echo esc_html( $booking->get_start_date( null, null, wc_should_convert_timezone( $booking ) ) ); ?></td>
                        <td class="booking-join-link"><?php echo DataStore::get_join_link( $booking ); ?></td>
                        <td class="booking-status"><?php echo esc_html( wc_bookings_get_status_label( $booking->get_status() ) ); ?></td>
                    </tr>
					<?php
				}
			} else { ?>
                <tr>
                    <td colspan="5"><?php esc_html_e( 'No bookings available yet.', 'vczapi-woo-addon' ); ?></td>
                </tr>
				<?php
			}
			?>
            </tbody>
        </table>
		<?php

		return ob_get_clean();
	}
}