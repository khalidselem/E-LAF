<?php

namespace Codemanas\ZoomWooBookingAddon\Admin;

use Codemanas\ZoomWooBookingAddon\Admin\Activator as Activator;
use Codemanas\ZoomWooBookingAddon\DataStore as Datastore;

/**
 * Class VideoConferencingZoomSettings
 *
 * @since   1.0.0
 * @author  Deepen Bajracharya, CodeManas, 2020. All Rights reserved.
 * @package Codemanas\ZoomWooBookingAddon\Admin
 */
class Settings {

	private $settings;

	private $email_reminder_times = [];

	public function __construct() {
		$this->email_reminder_times = [
			'24_hours_before' => __( '24 hours before meeting', 'vczapi-woo-addon' ),
			'3_hours_before'  => __( '3 hours before meeting', 'vczapi-woo-addon' )
		];

		add_action( 'admin_enqueue_scripts', array( $this, 'scripts' ) );
		add_action( 'admin_menu', array( $this, 'submenu' ) );
		add_action( 'vczapi_admin_settings', array( $this, 'render_tabs' ) );
		add_action( 'admin_notices', array( $this, 'render_notices' ) );
		add_filter( 'plugin_action_links', array( $this, 'action_link' ), 10, 2 );
	}

	/**
	 * @param $current_value
	 * @param $saved_array
	 *
	 * @return bool|string
	 */
	public function checked_in_array( $current_value, $saved_array ) {

		if ( ! is_array( $saved_array ) ) {
			return false;
		}

		if ( in_array( $current_value, $saved_array ) ) {
			return 'checked="checked"';
		}

		return false;
	}

	/**
	 * Render Notices
	 */
	function render_notices() {
		if ( isset( $_POST['save_general'] ) && current_user_can( 'manage_options' ) ) {
			?>
            <div class="updated"><p><?php _e( 'Options Saved !', 'vczapi-woo-addon' ); ?></p></div>
			<?php
		}
	}

	/**
	 * Render Tab Contents
	 */
	public function render_tabs() {
		$tab        = filter_input( INPUT_GET, 'tab', FILTER_SANITIZE_STRING );
		$active_tab = isset( $tab ) ? $tab : 'general';
		?>
        <h2 class="nav-tab-wrapper">
            <a href="<?php echo add_query_arg( array( 'tab' => 'general' ) ); ?>" class="nav-tab <?php echo ( 'general' === $active_tab ) ? esc_attr( 'nav-tab-active' ) : ''; ?>">
				<?php esc_html_e( 'General', 'vczapi-woo-addon' ); ?>
            </a>
            <a href="<?php echo add_query_arg( array( 'tab' => 'documentation' ) ); ?>" class="nav-tab <?php echo ( 'documentation' === $active_tab ) ? esc_attr( 'nav-tab-active' ) : ''; ?>">
				<?php esc_html_e( 'Documentation', 'vczapi-woo-addon' ); ?>
            </a>
            <a href="<?php echo add_query_arg( array( 'tab' => 'shortcode' ) ); ?>" class="nav-tab <?php echo ( 'shortcode' === $active_tab ) ? esc_attr( 'nav-tab-active' ) : ''; ?>">
				<?php esc_html_e( 'Shortcode', 'vczapi-woo-addon' ); ?>
            </a>
            <a href="<?php echo add_query_arg( array( 'tab' => 'email' ) ); ?>" class="nav-tab <?php echo ( 'email' === $active_tab ) ? esc_attr( 'nav-tab-active' ) : ''; ?>">
				<?php esc_html_e( 'Email', 'vczapi-woo-addon' ); ?>
            </a>
            <a href="<?php echo add_query_arg( array( 'tab' => 'license' ) ); ?>" class="nav-tab <?php echo ( 'license' === $active_tab ) ? esc_attr( 'nav-tab-active' ) : ''; ?>">
				<?php esc_html_e( 'Licensing', 'vczapi-woo-addon' ); ?>
            </a>
			<?php do_action( 'vczapi-woo-addon-setting-header' ); ?>
        </h2>
		<?php

		if ( 'general' === $active_tab ) {
			$this->save_general();

			$this->settings        = get_option( '_vczapi_settings' );
			$this->settings['jvb'] = get_option( '_vczapi_woocommerce_disable_browser_join' );
			require_once VZAPI_WOO_ADDON_DIR_PATH . 'includes/Admin/views/general.php';
		} else if ( 'documentation' === $active_tab ) {
			require_once VZAPI_WOO_ADDON_DIR_PATH . 'includes/Admin/views/documentation.php';
		} else if ( 'shortcode' === $active_tab ) {
			require_once VZAPI_WOO_ADDON_DIR_PATH . 'includes/Admin/views/shortcode.php';
		} else if ( 'email' == $active_tab ) {
			$this->save_general();
			$this->settings = Datastore::get_email_reminder();
			require_once VZAPI_WOO_ADDON_DIR_PATH . 'includes/Admin/views/emails.php';
		} else if ( 'license' == $active_tab ) {
			$activate = new Activator();
			$activate->show_license_form( 'Zoom Integration for WooCommerce and Bookings' );
		}

		do_action( 'vzczpi-woo-addon-settings-content', $active_tab );
	}

	/**
	 * Save General Section
	 */
	private function save_general() {
		if ( isset( $_POST['save_general'] ) && current_user_can( 'manage_options' ) ) {
			$saveData = array(
				'override_tpl'         => sanitize_text_field( filter_input( INPUT_POST, 'override_template' ) ),
				'disable_meetings_tab' => sanitize_text_field( filter_input( INPUT_POST, 'disable_meetings_tab' ) ),
			);

			update_option( '_vczapi_woocommerce_disable_browser_join', sanitize_text_field( filter_input( INPUT_POST, 'vczapi_disable_browser_join_links' ) ) );
			update_option( '_vczapi_settings', $saveData );
		}

		if ( isset( $_POST['save_emails_form'] ) && current_user_can( 'manage_options' ) ) {
			$email_settings_nonce = filter_input( INPUT_POST, 'vczapi_email_settings_nonce' );
			if ( ! wp_verify_nonce( $email_settings_nonce, 'vczapi_verify_email_settings' ) ) {
				return;
			}
			$disable_email_reminder = filter_input( INPUT_POST, 'vczapi_disable_meeting_reminder_email' );
			$reminder_when          = filter_input( INPUT_POST, 'meeting-reminder-time', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY );
			$data                   = array(
				'disable_reminder' => $disable_email_reminder,
				'email_schedule'   => $reminder_when,
				'enable_log'       => filter_input( INPUT_POST, 'vczapi-enable-debug-log' )
			);
			update_option( 'vczapi_meeting_reminder_email_settings', $data );
		}
	}

	/**
	 * Add Sub menu to main menu
	 */
	public function submenu() {
		add_submenu_page( 'edit.php?post_type=zoom-meetings', __( 'WooCommerce', 'vczapi-woo-addon' ), __( 'WooCommerce', 'vczapi-woo-addon' ), 'manage_options', 'woocommerce', array(
			$this,
			'woocommerce_options_render'
		) );
	}

	/**
	 * Render WooCommerce settings page
	 */
	public function woocommerce_options_render() {
		require_once VZAPI_WOO_ADDON_DIR_PATH . 'includes/Admin/views/woocommerce-settings.php';
	}

	/**
	 * Enqueue Admin Scripts
	 *
	 * @param $hook
	 */
	public function scripts( $hook ) {
		global $current_screen;
		if ( $hook === "toplevel_page_woocommerce" || $current_screen->id === "product" || $current_screen->id === "zoom-meetings" ) {
			wp_enqueue_style( 'vczapi-wooaddon-style', VZAPI_WOO_ADDON_DIR_URI . 'assets/backend/css/style.min.css', false, '1.0.0' );
		}

		if ( $current_screen->id === "zoom-meetings" ) {
			wp_enqueue_script( 'vczapi-wooaddon-script', VZAPI_WOO_ADDON_DIR_URI . 'assets/backend/js/script.min.js', array( 'jquery' ), '1.0.0', true );
		}
	}

	/**
	 * Show settings menu in plugin page.
	 *
	 * @param $actions
	 * @param $plugin_file
	 *
	 * @return array
	 */
	function action_link( $actions, $plugin_file ) {
		if ( 'vczapi-woo-addon/vczapi-woo-addon.php' == $plugin_file ) {
			$settings = array( 'settings' => '<a href="' . admin_url( 'edit.php?post_type=zoom-meetings&page=woocommerce' ) . '">' . __( 'Configure', 'vczapi-woo-addon' ) . '</a>' );

			$actions = array_merge( $settings, $actions );
		}

		return $actions;
	}
}