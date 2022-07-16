<?php

namespace Codemanas\ZoomWooBookingAddon;

/**
 * Class WooTemplateOverrides
 *
 * Helps overriding default Woo Templates
 *
 * @author Deepen Bajracharya, CodeManas, 2020. All Rights reserved.
 * @package Codemanas\ZoomWooBookingAddon
 * @since 1.0.0
 */
class TemplateOverrides {

	public function __construct() {
		add_filter( 'wc_get_template', array( $this, 'templates' ), 10, 5 );
	}

	/**
	 * Give me templates
	 *
	 * @param $located
	 * @param $template_name
	 * @param $args
	 * @param $template_path
	 * @param $default_path
	 *
	 * @return string
	 */
	public function templates( $located, $template_name, $args, $template_path, $default_path ) {
		if ( 'myaccount/bookings.php' == $template_name ) {
			$located = self::get_template( array( 'myaccount/bookings.php' ) );
		}

		if ( 'emails/admin-new-booking.php' == $template_name ) {
			$located = self::get_template( array( 'emails/admin-new-booking.php' ) );
		}

		return $located;
	}

	/**
	 * Get desired template
	 *
	 * @param $template_names
	 * @param bool $load
	 * @param bool $require_once
	 *
	 * @return bool|string
	 */
	static function get_template( $template_names, $load = false, $require_once = true ) {
		if ( ! is_array( $template_names ) ) {
			return '';
		}

		$located         = false;
		$this_plugin_dir = VZAPI_WOO_ADDON_DIR_PATH;
		foreach ( $template_names as $template_name ) {
			if ( file_exists( STYLESHEETPATH . '/zoom-woocommerce-addon/' . $template_name ) ) {
				$located = STYLESHEETPATH . '/zoom-woocommerce-addon/' . $template_name;
				break;
			} elseif ( file_exists( TEMPLATEPATH . '/zoom-woocommerce-addon/' . $template_name ) ) {
				$located = TEMPLATEPATH . '/zoom-woocommerce-addon/' . $template_name;
				break;
			} elseif ( file_exists( $this_plugin_dir . 'templates/' . $template_name ) ) {
				$located = $this_plugin_dir . 'templates/' . $template_name;
				break;
			}
		}

		if ( $load && ! empty( $located ) ) {
			load_template( $located, $require_once );
		}

		return $located;
	}
}