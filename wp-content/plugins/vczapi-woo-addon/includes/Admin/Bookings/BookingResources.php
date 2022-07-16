<?php


namespace Codemanas\ZoomWooBookingAddon\Admin\Bookings;


/**
 * Register a meta box using a class.
 */
class BookingResources {

	public static $instance = null;
	private $post_type = 'bookable_resource';

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
			'vczapi-zoom-resources-meta-box',
			__( 'Zoom Details', 'vczapi-woo-addon' ),
			array( $this, 'render_metabox' ),
			$this->post_type,
			'advanced',
			'default'
		);

	}

	/**
	 * Renders the meta box.
	 */
	public function render_metabox( $post ) {
		// Add nonce for security and authentication.
		wp_nonce_field( 'vczapi_zoom_booking_resources_meta_nonce_verify', 'vczapi_zoom_booking_resources_meta_nonce' );
		$users                  = video_conferencing_zoom_api_get_user_transients();
		$is_zoom_resource       = get_post_meta( $post->ID, 'vczapi_is_zoom_resource', true );
		$bookable_resource_host = get_post_meta( $post->ID, 'vczapi_bookable_resource_host', true );
		?>
        <table class="form-table">
            <tr>
                <th><label for="vczapi-is-zoom-resource"><?php _e( 'Is zoom resource', 'vczapi-woocommerce-addon' ); ?></label></th>
                <td>
                    <input type="checkbox" name="vczapi-is-zoom-resource" id="vczapi-is-zoom-resource" value="yes" <?php checked( 'yes', $is_zoom_resource ) ?>>
                    <p class="description">
						<?php _e( 'Check this box to mark this resource as Zoom Host', 'vczapi-woocommerce-addon' ); ?>
                    </p>
                </td>
            </tr>
            <tr>
                <th><label for="vczapi_bookable_resource_host">
						<?php _e( 'Assign Host', 'vczapi-woocommerce-addon' ); ?>
                    </label></th>
                <td>
                    <select name="vczapi_bookable_resource_host" id="vczapi_bookable_resource_host">
                        <option value=""><?php _e( 'Assign Host', 'vczapi-woocommerce-addon' ); ?></option>
						<?php
						foreach ( $users as $user ) {
							$display_name = $user->first_name . ' ' . $user->last_name . '(' . $user->email . ')';
							$display_name = ! empty( $display_name ) ? $display_name : $user->email;
							echo '<option value="' . $user->id . '" ' . selected( $user->id, $bookable_resource_host ) . '>' . $display_name . '</option>';
						}
						?>
                    </select>

                </td>
            </tr>
        </table>
		<?php
	}

	/**
	 * Handles saving the meta box.
	 *
	 * @param int      $post_id Post ID.
	 * @param \WP_Post $post    Post object.
	 *
	 */
	public function save_metabox( $post_id, $post ) {
		// Add nonce for security and authentication.
		//var_dump($_POST); die;
		$nonce_name   = filter_input( INPUT_POST, 'vczapi_zoom_booking_resources_meta_nonce' );
		$nonce_action = 'vczapi_zoom_booking_resources_meta_nonce_verify';


		// Check if nonce is valid.
		if ( ! wp_verify_nonce( $nonce_name, $nonce_action ) ) {
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

		$is_zoom_resource = filter_input( INPUT_POST, 'vczapi-is-zoom-resource' );
		if ( $is_zoom_resource == 'yes' ) {
			update_post_meta( $post_id, 'vczapi_is_zoom_resource', $is_zoom_resource );
			$bookable_resource_host = filter_input( INPUT_POST, 'vczapi_bookable_resource_host' );
			if ( ! empty( $bookable_resource_host ) ) {
				update_post_meta( $post_id, 'vczapi_bookable_resource_host', $bookable_resource_host );
			}
		} else {
			delete_post_meta( $post_id, 'vczapi_is_zoom_resource' );
			delete_post_meta( $post_id, 'vczapi_bookable_resource_host' );
		}

	}
}