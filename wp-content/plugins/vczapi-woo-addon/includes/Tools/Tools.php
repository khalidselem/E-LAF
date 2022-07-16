<?php


namespace Codemanas\ZoomWooBookingAddon\Tools;


class Tools {
	public static $_instance = null;

	public static function get_instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	public function __construct() {
		if ( ! vczapi_woo_booking_isactive() ) {
			return;
		}
		add_action( 'vczapi-woo-addon-setting-header', [ $this, 'add_tools_header' ] );
		add_action( 'vzczpi-woo-addon-settings-content', [ $this, 'load_tools' ] );
		add_action( 'init', [ $this, 'recalibrate_booking_to_utc' ] );

		//add_action( 'admin_notices', [ $this, 'timezone_fix_admin_notice__error' ] );

	}

	function timezone_fix_admin_notice__error() {
		$class       = 'notice notice-large notice-warning is-dismissible';
		$format_link = '<a href="'. admin_url( 'edit.php?post_type=zoom-meetings&page=woocommerce&tab=tools' ) . '">Tools</a>';
		$message     = __( sprintf( 'If you have been using version 2.2.12 or below  - please see %s', $format_link ), 'vczapi-woo-addon' );

		printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), ( $message ) );
	}

	public function add_tools_header() {
		$tab        = filter_input( INPUT_GET, 'tab', FILTER_SANITIZE_STRING );
		$active_tab = isset( $tab ) ? $tab : 'general';
		?>
        <a href="<?php echo add_query_arg( array( 'tab' => 'tools' ) ); ?>" class="nav-tab <?php echo ( 'tools' === $active_tab ) ? esc_attr( 'nav-tab-active' ) : ''; ?>">
			<?php esc_html_e( 'Tools', 'vczapi-woo-addon' ); ?>
        </a>
		<?php
	}

	public function load_tools() {
		$tab = filter_input( INPUT_GET, 'tab' );
		if ( $tab !== 'tools' ) {
			return;
		}
		?>
        <h2><?php esc_html_e( 'Tools', 'vczapi-woo-addon' ); ?></h2>
        <style>
            .vczapi-admin-info-table {
                border: 1px solid #000;
            }

            .vczapi-admin-info-table td {
                border: 1px solid #000;
            }
        </style>
        <div class="wrap">
            <table class="form-table">
                <tbody>
                <tr>
                    <th><?php _e( 'Update Bookings', 'vczapi-woo-addon' ) ?></th>
                    <td>
                        <p>This action will -- update all your bookings to resolve timezone differences. <br>
                            Please only use it if you have been using version 2.2.12 or below, if multiple meetings have been created for the same time and date due to timezone difference. After running the tool - the first meeting will be referenced on all subsequent bookings.</p>
                        <p>For Example: <br>
                            If there are 2 bookings with same time booked with different timezones and two different meetings have been created on Zoom:<br/>
                            Booking 1: Timezone Asia/Kathmandu - Meeting_ID_1 <br>
                            Booking 2: Timezone London - Meeting_ID_2 <br>
                            After update Booking 2: will now be linked with Meeting_ID_1 <br>
                        </p> <br><br>
                        <table class="vczapi-admin-info-table" style="border:1px solid #000;">
                            <tr>
                                <td>Before Update</td>
                                <td>After Update</td>
                            </tr>
                            <tr>
                                <td>
                                    Booking 1 - Meeting_ID_1 <br>
                                    Booking 2 - Meeting_ID_2
                                </td>
                                <td>
                                    Booking 1 - Meeting_ID_1 <br>
                                    Booking 2 - Meeting_ID_1
                                </td>
                            </tr>
                        </table>

                    </td>

                    <td>
                        <a href="<?php echo wp_nonce_url( add_query_arg( array( 'tab' => 'tools' ) ), 'recalibrate_to_utc_time' );
						?>" class="button button-primary">
							<?php _e( 'Update Now', 'vczapi-woo-addon' ); ?>
                        </a>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
		<?php
	}

	public function recalibrate_booking_to_utc() {
		$nonce = filter_input( INPUT_GET, '_wpnonce' );
		if ( ! wp_verify_nonce( $nonce, 'recalibrate_to_utc_time' ) ) {
			return;
		}

		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		$args              = [
			'post_type'      => 'product',
			'tax_query'      => [
				[
					'taxonomy' => 'product_type',
					'field'    => 'slug',
					'terms'    => 'booking'
				]
			],
			'meta_query'     => [
				[
					'key'   => '_vczapi_woo_addon_booking_enable_zoom',
					'value' => 'yes'
				]
			],
			'posts_per_page' => - 1,
		];
		$bookable_products = new \WP_Query( $args );
		if ( $bookable_products->have_posts() ) {
			while ( $bookable_products->have_posts() ):$bookable_products->the_post();
				$product_id = get_the_ID();
				//$indexed_zoom_meetings = get_post_meta( $product_id, '_vczapi_bookings_zoom_meetings', true );
				$indexed_zoom_meetings = [];

				$bookings = \WC_Booking_Data_Store::get_bookings_for_product( $product_id );
				foreach ( $bookings as $booking ) {

					$booking_id = $booking->get_id();
					var_dump( $booking_id );
					$meeting_details_raw = get_post_meta( $booking_id, '_vczapi_woo_addon_meeting_details', true );
					$meeting_details     = json_decode( $meeting_details_raw );
					if ( ! empty( $meeting_details ) && is_object( $meeting_details ) && isset( $meeting_details->id ) ) {
						$meeting_id = $meeting_details->id;
						$host_id    = $meeting_details->host_id;

						$index_date = vczapi_dateConverter( $meeting_details->start_time, 'UTC', 'Y-m-d-H:i:s', false );
						if ( is_array( $indexed_zoom_meetings ) ) {
							$indexed_zoom_meetings[ $host_id ][ $index_date ] = $meeting_id;
							update_post_meta( $product_id, '_vczapi_bookings_zoom_meetings', $indexed_zoom_meetings );
						}
						//echo $product_id;

					}
				}
			endwhile;
			wp_reset_postdata();
		}

		wp_redirect( admin_url( 'edit.php?post_type=zoom-meetings&page=woocommerce&tab=tools' ) );
		die;

	}
}