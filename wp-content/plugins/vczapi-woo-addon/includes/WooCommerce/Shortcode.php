<?php

namespace Codemanas\ZoomWooBookingAddon\WooCommerce;

use Codemanas\ZoomWooBookingAddon\TemplateOverrides;

/**
 * Class Shortcode
 *
 * @package Codemanas\ZoomWooBookingAddon
 * @since   2.0.2
 */
class Shortcode {

	public $post_type = 'zoom-meetings';

	/**
	 * Shortcode constructor.
	 */
	public function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_shortcode( 'vczapi_wc_show_purchasable_meetings', array( $this, 'show_meetings' ) );
	}

	/**
	 * Enqueue Shortcode Scripts
	 */
	public function enqueue_scripts() {
		wp_register_style( 'vczapi-shortcode-style', VZAPI_WOO_ADDON_DIR_URI . 'assets/frontend/css/style.min.css' );
		wp_enqueue_style( 'vczapi-shortcode-style' );
	}

	/**
	 * @param $args
	 *
	 * @return string
	 */
	/**
	 * @param $atts
	 *
	 * @return string
	 */
	public function show_meetings( $atts ) {
		$atts = shortcode_atts( array(
			'per_page'      => 10,
			'type'          => 'boxed',
			'order'         => 'DESC',
			'upcoming_only' => 'no'
		), $atts, 'vczapi_wc_show_purchasable_meetings' );
		if ( is_front_page() ) {
			$paged = ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1;
		} else {
			$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
		}

		$args = array(
			'post_type'      => $this->post_type,
			'posts_per_page' => $atts['per_page'],
			'post_status'    => 'publish',
			'paged'          => $paged,
			'orderby'        => 'meta_value',
			'meta_key'       => '_meeting_start_date',
			'order'          => $atts['order'],
			'meta_query'     => array(
				array(
					'key'     => '_vczapi_zoom_product_id',
					'value'   => '',
					'compare' => '!=',
				),
			)
		);

		if ( $atts['upcoming_only'] === "yes" ) {
			$args['meta_query'][] = array(
				'key'     => '_meeting_start_date',
				'value'   => date( "Y-m-d H:i" ),
				'type'    => 'DATE',
				'compare' => '>='
			);
		}

		$query                     = apply_filters( 'vczapi_wc_purchasable_products_query_args', $args );
		$purchasable_zoom_products = new \WP_Query( $query );
		$GLOBALS['zoom_products']  = $purchasable_zoom_products;
		$content                   = '';

		ob_start();
		if ( $atts['type'] === "boxed" ) {
			include VZAPI_WOO_ADDON_DIR_PATH . 'templates/shortcode/purchasable-products-box.php';
		} else {
			$tpl = TemplateOverrides::get_template( array( 'shortcode/purchasable-products-list.php' ) );
			include $tpl;
		}
		$content .= ob_get_clean();

		return $content;
	}

	/**
	 * Paginate here.
	 *
	 * @param $query
	 */
	public function pagination( $query ) {
		$big = 999999999999999;
		if ( is_front_page() ) {
			$paged = ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1;
		} else {
			$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
		}
		echo paginate_links( array(
			'base'    => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
			'format'  => '?paged=%#%',
			'current' => max( 1, $paged ),
			'total'   => $query->max_num_pages
		) );
	}
}