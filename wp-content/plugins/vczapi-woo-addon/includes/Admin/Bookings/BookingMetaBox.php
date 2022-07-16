<?php


namespace Codemanas\ZoomWooBookingAddon\Admin\Bookings;


use Codemanas\ZoomWooBookingAddon\DataStore;

/**
 * Register a meta box using a class.
 */
class BookingMetaBox extends DataStore {

	public static $instance = null;

	public static function get_instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Constructor.
	 */
	public function __construct() {
		if ( is_admin() ) {
			add_action( 'load-post.php', array( $this, 'init_metabox' ) );
			add_action( 'load-post-new.php', array( $this, 'init_metabox' ) );
		}

	}

	/**
	 * Meta box initialization.
	 */
	public function init_metabox() {
		add_action( 'add_meta_boxes', array( $this, 'add_metabox' ) );
		add_action( 'save_post', array( $this, 'save_metabox' ), 100, 2 );
	}

	/**
	 * Adds the meta box.
	 */
	public function add_metabox() {
		add_meta_box(
			'vczapi-zoom-meta-box',
			__( 'Zoom Details', 'vczapi-woo-addon' ),
			array( $this, 'render_metabox' ),
			'wc_booking',
			'advanced',
			'default'
		);

	}

	/**
	 * Renders the meta box.
	 */
	public function render_metabox( $post ) {
		// Add nonce for security and authentication.
		wp_nonce_field( 'vczapi_zoom_booking_meta_nonce_verify', 'vczapi_zoom_booking_meta_nonce' );
		$booking = get_wc_booking( $post->ID );
		if ( ! is_object( $booking ) ) {
			return;
		}
		$product_id        = $booking->get_product_id();
		$product_edit_link = get_edit_post_link( $product_id );
		$meeting_exists    = get_post_meta( $post->ID, '_vczapi_woo_addon_meeting_exists', true );
		$meeting_error     = json_decode( get_post_meta( $post->ID, '_vczapi_woo_addon_meeting_error', true ) );
		$meeting_details   = get_post_meta( $post->ID, '_vczapi_woo_addon_meeting_details', true );
		$meeting_details   = ! empty( $meeting_details ) ? json_decode( $meeting_details ) : '';
		if ( ! empty( $meeting_error ) ) {
			?>
            <h2 style="color:red">
				<?php
				_e( "There was an error when creating the meeting - see details bellow:", 'vczapi-woo-addons' );
				?>
            </h2>
            <table class="form-table">
                <tr>
                    <td>Code</td>
                    <td><?php echo $meeting_error->code; ?></td>
                </tr>
                <tr>
                    <td>Message</td>
                    <td><?php echo $meeting_error->message; ?></td>
                </tr>
                <tr>
                    <td><label for="vczapi_create_meeting">Create Meeting:</label></td>
                    <td><input type="checkbox" id="vczapi_create_meeting" name="vczapi_create_meeting" value="yes">
                        <span class="description">
                            <?php printf( __( 'Check this box after you have assigned host to <a href="%s" target="_blank" rel="nofollow noopener">product</a>, and then save the booking, this will create the meeting in Zoom', 'vczapi-woo-addon' ), $product_edit_link ); ?>
                        </span>
                    </td>
                </tr>

            </table>
			<?php
		} else if ( ! empty( $meeting_details ) ) {
			?>
            <table class="form-table vczapi-woocommerce-email-mtg-details">
                <tr class="vczapi-woocommerce-email-mtg-details--list1">
                    <td><?php _e( 'Meeting Details', 'vczapi-woo-addon' ); ?>:</td>
                </tr>
                <tr class="vczapi-woocommerce-email-mtg-details--list2">
                    <td><?php _e( 'Topic', 'vczapi-woo-addon' ); ?>
                        :
                    </td>
                    <td><?php echo $meeting_details->topic; ?></td>
                </tr>
                <tr class="vczapi-woocommerce-email-mtg-details--list3">
                    <td><?php _e( 'Start Time', 'vczapi-woo-addon' ); ?>:</td>
                    <td><?php echo vczapi_dateConverter( $meeting_details->start_time, $meeting_details->timezone, 'F j, Y @ g:i a' );
						?></td>
                </tr>
                <tr class="vczapi-woocommerce-email-mtg-details--list3">
                    <td><?php _e( 'Timezone', 'vczapi-woo-addon' ); ?>:</td>
                    <td><?php echo $meeting_details->timezone; ?></td>
                </tr>
                <tr class="vczapi-woocommerce-email-mtg-details--list4">
                    <td><a target="_blank" rel="nofollow" href="<?php echo esc_url( $meeting_details->join_url ); ?>"><?php _e( 'Join via App', 'vczapi-woo-addon' ); ?></a></td>

                </tr>
                <tr>
					<?php if ( empty( $disabled ) ) { ?>
                        <td class="vczapi-woocommerce-email-mtg-details--list5">
							<?php
							$pwd = ! empty( $meeting_details->password ) ? $meeting_details->password : false;
							echo DataStore::get_browser_join_link( $meeting_details->id, $pwd );
							?>
                        </td>
					<?php } ?>
                </tr>
                <tr>
                    <td>
                        <a href="<?php echo $meeting_details->start_url; ?>" class="button button-primary button-large"><?php _e( 'Start Meeting', 'vczapi-woo-addon' ); ?></a>
                    </td>
                </tr>
            </table>
			<?php
		}
	}

	/**
	 * Handles saving the meta box.
	 *
	 * @param int     $post_id Post ID.
	 * @param WP_Post $post    Post object.
	 *
	 * @return null
	 */
	public function save_metabox( $post_id, $post ) {
		// Add nonce for security and authentication.
		$nonce_name     = isset( $_POST['vczapi_zoom_booking_meta_nonce'] ) ? $_POST['vczapi_zoom_booking_meta_nonce'] : '';
		$nonce_action   = 'vczapi_zoom_booking_meta_nonce_verify';
		$create_meeting = filter_input( INPUT_POST, 'vczapi_create_meeting' );


		// Check if nonce is valid.
		if ( ! wp_verify_nonce( $nonce_name, $nonce_action ) ) {
			return;
		}

		if ( $create_meeting != 'yes' ) {
			return;
		}

		// Check if user has permissions to save data.
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		// Check if not an autosave.
		if ( wp_is_post_autosave( $post_id ) ) {
			return;
		}

		// Check if not a revision.
		if ( wp_is_post_revision( $post_id ) ) {
			return;
		}

		$booking = get_wc_booking( $post_id );
		if ( ! is_object( $booking ) ) {
			return;
		}
		$order_id = $booking->get_order_id();
		$this->create_meeting( $booking, $post_id, $order_id );
	}
}