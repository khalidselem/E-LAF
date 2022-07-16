<?php

namespace Codemanas\ZoomWooBookingAddon\WooCommerce;

use Codemanas\ZoomWooBookingAddon\DataStore as DataStore;
use Codemanas\ZoomWooBookingAddon\TemplateOverrides;
use DateTime;
use DateTimeZone;

/**
 * Class Orders
 *
 * Handle WooCommerce Order Operations
 *
 * @author Deepen Bajracharya, CodeManas, 2020. All Rights reserved.
 * @since 1.1.0
 * @package Codemanas\ZoomWooBookingAddon
 */
class Orders {

	/**
	 * @var string
	 */
	private $column = 'wc-zoom-meetings';

	/**
	 * @var null
	 */
	public static $instance = null;

	/**
	 * @return Orders|null
	 */
	public static function get_instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	private $plugin_settings;

	public function __construct() {
		$this->plugin_settings = get_option( '_vczapi_settings' );
		if ( empty( $this->plugin_settings['disable_meetings_tab'] ) ) {
			add_action( 'init', array( $this, 'add_meeting_link_endpoint' ) );
			add_filter( 'query_vars', array( $this, 'meeting_link_query_vars' ), 0 );
			add_filter( 'woocommerce_account_menu_items', array( $this, 'meeting_link' ), 5 );
			add_action( 'woocommerce_account_' . $this->column . '_endpoint', array( $this, 'display_links' ) );
		}

		//WooCommerce Order Template End
		add_action( 'woocommerce_order_item_meta_end', array( $this, 'email_meeting_details' ), 20, 3 );
	}

	/**
	 * Add endpoint to wc-zoom-meetings
	 */
	public function add_meeting_link_endpoint() {
		add_rewrite_endpoint( $this->column, EP_ROOT | EP_PAGES );
	}

	/**
	 * Define Vars
	 *
	 * @param $vars
	 *
	 * @return array
	 */
	public function meeting_link_query_vars( $vars ) {
		$vars[] = $this->column;

		return $vars;
	}

	/**
	 * Add new link into my-account section in WooCommerce
	 *
	 * @param $items
	 *
	 * @return mixed
	 */
	public function meeting_link( $items ) {
		$items[ $this->column ] = __( 'Meetings', 'vczapi-woo-addon' );

		return $items;
	}

	/**
	 * Display links
	 */
	public function display_links() {
		$this->show_column_data();
	}

	/**
	 * Display Column data for zoom link
	 *
	 * @author Deepen Bajracharya
	 * @since 1.1.0
	 */
	public function show_column_data() {
		// Get 10 most recent order ids in date descending order.
		TemplateOverrides::get_template( [ 'frontend/meeting-list.php' ], true );
	}

	/**
	 * No orders text
	 */
	public static function output_no_order_text() {
		?>
        <tr class="woocommerce-orders-table__row woocommerce-orders-table__row--status-processing order">
            <td colspan="4"><?php _e( 'No meeting orders received yet.', 'vczapi-woo-addon' ); ?></td>
        </tr>
		<?php
	}

	/**
	 * Show in order details
	 *
	 * @param $item_id
	 * @param $item
	 * @param \WC_Order $order
	 */
	public function email_meeting_details( $item_id, $item, $order ) {
		if ( $order->get_status() === "completed" || $order->get_status() === "processing" ) {
			$product_id = $item['product_id'];
			$post_id    = get_post_meta( $product_id, '_vczapi_zoom_post_id', true );
			if ( ! empty( $post_id ) ) {
				$fields          = get_post_meta( $post_id, '_meeting_fields_woocommerce', true );
				$meeting_details = get_post_meta( $post_id, '_meeting_zoom_details', true );
				if ( ! empty( $meeting_details ) && ! empty( $fields['enable_woocommerce'] ) ) {
					do_action( 'vczapi_woocommerce_before_meeting_details' );
					$disabled = get_option( '_vczapi_woocommerce_disable_browser_join' );
					$content  = apply_filters( 'vczapi_woocommerce_order_item_meta', '', $item_id, $item, $order );
					if ( ! empty( $content ) ) {
						echo $content;
					} else {
					    ob_start();
						?>
                        <ul class="vczapi-woocommerce-email-mtg-details">
                            <li class="vczapi-woocommerce-email-mtg-details--list1"><strong><?php _e( 'Meeting Details', 'vczapi-woo-addon' ); ?>
                                    :</strong></li>
                            <li class="vczapi-woocommerce-email-mtg-details--list2"><strong><?php _e( 'Topic', 'vczapi-woo-addon' ); ?>
                                    :</strong> <?php echo $meeting_details->topic; ?></li>
                            <li class="vczapi-woocommerce-email-mtg-details--list3"><strong><?php _e( 'Start Time', 'vczapi-woo-addon' ); ?>
                                    :</strong> <?php echo vczapi_dateConverter( $meeting_details->start_time, $meeting_details->timezone, 'F j, Y @ g:i a' );
								?></li>
                            <li class="vczapi-woocommerce-email-mtg-details--list3"><strong><?php _e( 'Timezone', 'vczapi-woo-addon' ); ?>
                                    :</strong> <?php echo $meeting_details->timezone; ?></li>
                            <li class="vczapi-woocommerce-email-mtg-details--list4">
                                <a target="_blank" rel="nofollow" href="<?php echo esc_url( $meeting_details->join_url ); ?>"><?php _e( 'Join via App', 'vczapi-woo-addon' ); ?></a>
                            </li>
							<?php if ( empty( $disabled ) ) { ?>
                                <li class="vczapi-woocommerce-email-mtg-details--list5">
									<?php
									$pwd = ! empty( $meeting_details->password ) ? $meeting_details->password : false;
									echo DataStore::get_browser_join_link( $meeting_details->id, $pwd );
									?>
                                </li>
							<?php } ?>
                        </ul>
						<?php
                        echo ob_get_clean();
					}
					do_action( 'vczapi_woocommerce_after_meeting_details' );
				}
			}
		}
	}
}