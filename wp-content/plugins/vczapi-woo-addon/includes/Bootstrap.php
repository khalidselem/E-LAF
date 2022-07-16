<?php

namespace Codemanas\ZoomWooBookingAddon;

use Codemanas\ZoomWooBookingAddon\Admin\Bookings\BookingMetaBox;
use Codemanas\ZoomWooBookingAddon\Admin\Bookings\BookingResources;
use Codemanas\ZoomWooBookingAddon\Tools\Tools;
use Codemanas\ZoomWooBookingAddon\WooCommerce\Cart;
use Codemanas\ZoomWooBookingAddon\WooCommerce\Orders;

/**
 * Class Bootstrap
 *
 * Bootstrap our plugin
 *
 * @author  Deepen Bajracharya, CodeManas, 2020. All Rights reserved.
 * @since   1.0.0
 * @package Codemanas\ZoomWooBookingAddon
 */
class Bootstrap {

	public static $item_id = 1594;
	public static $store_url = 'https://www.codemanas.com';
	public static $options_page = 'edit.php?post_type=zoom-meetings&page=woocommerce&tab=license';
	private static $license = '_vczapi_woo_addon_license';

	private static $_instance = null;

	private $key_validate;

	private $plugin_settings;

	/**
	 * Create only one instance so that it may not Repeat
	 *
	 * @since 1.0.0
	 */
	public static function get_instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	public function __construct() {
		$this->key_validate    = trim( get_option( self::$license ) );
		$this->plugin_settings = get_option( '_vczapi_settings' );

		$this->load();

		add_action( 'admin_init', array( $this, 'updater' ), 1 );
		add_action( 'admin_init', array( $this, 'load_admin' ), 1 );

		add_action( 'wp_enqueue_scripts', array( $this, 'scripts' ) );
	}

	static function activate() {
		//Deactivate WooCommerce Addon to avoid conflict
		$active_plugins = get_option( 'active_plugins' );
		foreach ( $active_plugins as $active_plugin ) {
			if ( strpos( $active_plugin, 'vczapi-woocommerce-addon.php' ) ) {
				deactivate_plugins( $active_plugin );
			}
		}
		//Check if WooCommerce Exists
		if ( ! is_plugin_active( 'video-conferencing-with-zoom-api/video-conferencing-with-zoom-api.php' ) and current_user_can( 'activate_plugins' ) ) {
			$exit_msg = __( "This Plugin requires Video Conferencing with zoom api plugin by Deepen Bajracharya to work. Please install it first to use this.", "vczapi-woo-addon" );
			wp_die( $exit_msg );
		}

		//Deactivate WooCommerce Addon to avoid conflict
		$active_plugins = get_option( 'active_plugins' );
		foreach ( $active_plugins as $active_plugin ) {
			if ( strpos( $active_plugin, 'vczapi-woocommerce-addon.php' ) ) {
				deactivate_plugins( $active_plugin );
			}
		}

		//Create rewrite endpoint
		add_rewrite_endpoint( 'wc-zoom-meetings', EP_ROOT | EP_PAGES );
		flush_rewrite_rules();
	}

	public function load_admin() {
		if ( ! empty( $this->key_validate ) ) {
			if ( vczapi_woo_booking_isactive() ) {
				//Bookings Product
				$this->autowire( Admin\Bookings\BookingTabs::class );
				$this->autowire( Admin\Bookings\BookingTable::class );
			}

			//Normal WooCommerce Product
			$this->autowire( Admin\Woocommerce\WooCommerceTable::class );
			$this->autowire( Admin\Woocommerce\ZoomMetaBox::class );
		}
	}

	/**
	 * Load Dependencies
	 */
	public function load() {
		$woocommerce_standalone_active = Helper::check_is_woocommerce_addon_active();

		if ( ! empty( $this->key_validate ) ) {
			if ( vczapi_woo_booking_isactive() ) {
				$this->autowire( Bookings\Bookings::class );
				$this->autowire( Bookings\Shortcode::class );
			}

			if ( empty( $this->plugin_settings['override_tpl'] ) ) {
				$this->autowire( TemplateOverrides::class );
			}

			if ( ! $woocommerce_standalone_active ) {
				$this->autowire( Admin\Woocommerce\ProductType::class );
				Admin\Woocommerce\WooCommerceZoomConnection::get_instance();
				$this->autowire( WooCommerce\Shortcode::class );
				Cart::get_instance();
				Orders::get_instance();
			}

			$this->autowire( WooCommerce\CronHandlers::class );

			if ( vczapi_wc_product_vendors_addon_active() ) {
				ProductVendors::get_instance();
			}

			if ( class_exists( 'WC_Bookings' ) ) {
				BookingResources::get_instance();
			}

			//ADD TOOLS
			Tools::get_instance();

		}

		$this->autowire( Admin\Settings::class );
		$this->autowire( Admin\Activator::class );

		//WPML compatibility
		if ( class_exists( 'SitePress' ) ) {
			$this->autowire( Admin\Bookings\BookingsWPML::class );
		}

		BookingMetaBox::get_instance();
	}

	/**
	 * Dependency Injection Process
	 *
	 * @param $obj
	 *
	 * @since  1.0.2
	 * @author Deepen Bajracharya
	 */
	private function autowire( $obj ) {
		new $obj;
	}

	/**
	 * Updater
	 */
	public static function updater() {
		$license_key = trim( get_option( self::$license ) );
		$updater     = new Updater( self::$store_url, VZAPI_WOO_ADDON_DIR_PATH . 'vczapi-woo-addon.php', array(
			'version' => VZAPI_WOO_ADDON_PLUGIN_VERSION,
			'license' => $license_key,
			'author'  => 'Deepen Bajracharya',
			'item_id' => self::$item_id,
			'beta'    => false,
		) );

		$updater->check();
	}

	/**
	 * Enqueue Scripts in frontend side
	 */
	public function scripts() {
	}
}