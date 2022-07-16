<?php

namespace Codemanas\ZoomWooBookingAddon;

class Helper {
	public static $_instance = null;

	public static function get_instance() {
		if ( self::$_instance == null ) {
			self::$_instance = new self();
		}

		return self::$_instance;

	}

	public static function is_plugin_active( $plugin ) {
		$active = false;
		// check for plugin using plugin name
		if ( in_array( $plugin, apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
			$active = true;
		}

		return $active;
	}

	public static function check_is_woocommerce_addon_active() {
		return self::is_plugin_active( 'vczapi-woocommerce-addon/vczapi-woocommerce-addon.php' );
	}
}