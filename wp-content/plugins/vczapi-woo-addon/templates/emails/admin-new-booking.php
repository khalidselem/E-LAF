<?php
/**
 * Admin new booking email.
 *
 * @see     https://docs.woocommerce.com/document/bookings-templates/
 * @author  Automattic
 * @version 1.10.0
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( wc_booking_order_requires_confirmation( $booking->get_order() ) && $booking->get_status() === 'pending-confirmation' ) {
	/* translators: 1: billing first and last name */
	$opening_paragraph = __( 'A booking has been made by %s and is awaiting your approval. The details of this booking are as follows:', 'vczapi-woo-addon' );
} else {
	/* translators: 1: billing first and last name */
	$opening_paragraph = __( 'A new booking has been made by %s. The details of this booking are as follows:', 'vczapi-woo-addon' );
}
?>

<?php
do_action( 'woocommerce_email_header', $email_heading );

$order = $booking->get_order();

if ( $order ) {
	if ( version_compare( WC_VERSION, '3.0', '<' ) ) {
		$first_name = $order->billing_first_name;
		$last_name  = $order->billing_last_name;
	} else {
		$first_name = $order->get_billing_first_name();
		$last_name  = $order->get_billing_last_name();
	}
}

?>

<?php if ( ! empty( $first_name ) && ! empty( $last_name ) ) : ?>
    <p><?php echo esc_html( sprintf( $opening_paragraph, $first_name . ' ' . $last_name ) ); ?></p>
<?php endif; ?>

<table cellspacing="0" cellpadding="6" style="width: 100%; border: 1px solid #eee;" border="1" bordercolor="#eee">
    <tbody>
    <tr>
        <th scope="row" style="text-align:left; border: 1px solid #eee;"><?php esc_html_e( 'Booked Product', 'vczapi-woo-addon' ); ?></th>
        <td style="text-align:left; border: 1px solid #eee;"><?php echo esc_html( $booking->get_product()->get_title() ); ?></td>
    </tr>
    <tr>
        <th style="text-align:left; border: 1px solid #eee;" scope="row"><?php esc_html_e( 'Booking ID', 'vczapi-woo-addon' ); ?></th>
        <td style="text-align:left; border: 1px solid #eee;"><?php echo esc_html( $booking->get_id() ); ?></td>
    </tr>
	<?php
	$meeting = get_post_meta( $booking->get_id(), '_vczapi_woo_addon_meeting_details', true );
	if ( ! empty( $meeting ) ) {
		$meeting = json_decode( $meeting );
		if ( ! empty( $meeting->id ) ) {
			?>
            <tr>
                <th style="text-align:left; border: 1px solid #eee;" scope="row">
					<?php _e( 'Booking Start Link', 'vczapi-woo-addon' ); ?>
                </th>
                <td style="text-align:left; border: 1px solid #eee;"><?php echo \Codemanas\ZoomWooBookingAddon\DataStore::get_start_link( $booking ); ?></td>
            </tr>
			<?php
		}
	}
	?>
	<?php
	$resource       = $booking->get_resource();
	$resource_label = $booking->get_product()->get_resource_label();

	if ( $booking->has_resources() && $resource ) :
		?>
        <tr>
            <th style="text-align:left; border: 1px solid #eee;" scope="row"><?php echo ( '' !== $resource_label ) ? esc_html( $resource_label ) : esc_html__( 'Booking Type', 'vczapi-woo-addon' ); ?></th>
            <td style="text-align:left; border: 1px solid #eee;"><?php echo esc_html( $resource->post_title ); ?></td>
        </tr>
	<?php endif; ?>
    <tr>
        <th style="text-align:left; border: 1px solid #eee;" scope="row"><?php esc_html_e( 'Booking Start Date', 'vczapi-woo-addon' ); ?></th>
        <td style="text-align:left; border: 1px solid #eee;"><?php echo esc_html( $booking->get_start_date( null, null, wc_should_convert_timezone( $booking ) ) ); ?></td>
    </tr>
    <tr>
        <th style="text-align:left; border: 1px solid #eee;" scope="row"><?php esc_html_e( 'Booking End Date', 'vczapi-woo-addon' ); ?></th>
        <td style="text-align:left; border: 1px solid #eee;"><?php echo esc_html( $booking->get_end_date( null, null, wc_should_convert_timezone( $booking ) ) ); ?></td>
    </tr>
	<?php if ( wc_should_convert_timezone( $booking ) ) : ?>
        <tr>
            <th style="text-align:left; border: 1px solid #eee;" scope="row"><?php esc_html_e( 'Time Zone', 'vczapi-woo-addon' ); ?></th>
            <td style="text-align:left; border: 1px solid #eee;"><?php echo esc_html( str_replace( '_', ' ', $booking->get_local_timezone() ) ); ?></td>
        </tr>
	<?php endif; ?>
	<?php if ( $booking->has_persons() ) : ?><?php
		foreach ( $booking->get_persons() as $id => $qty ) :
			if ( 0 === $qty ) {
				continue;
			}

			$person_type = ( 0 < $id ) ? get_the_title( $id ) : __( 'Person(s)', 'vczapi-woo-addon' );
			?>
            <tr>
                <th style="text-align:left; border: 1px solid #eee;" scope="row"><?php echo esc_html( $person_type ); ?></th>
                <td style="text-align:left; border: 1px solid #eee;"><?php echo esc_html( $qty ); ?></td>
            </tr>
		<?php endforeach; ?><?php endif; ?>
    </tbody>
</table>

<?php if ( wc_booking_order_requires_confirmation( $booking->get_order() ) && $booking->get_status() === 'pending-confirmation' ) : ?>
    <p><?php esc_html_e( 'This booking is awaiting your approval. Please check it and inform the customer if the date is available or not.', 'vczapi-woo-addon' ); ?></p>
<?php endif; ?>

<p>
	<?php
	/* translators: 1: a href to booking */
	echo wp_kses_post( make_clickable( sprintf( __( 'You can view and edit this booking in the dashboard here: %s', 'vczapi-woo-addon' ), admin_url( 'post.php?post=' . $booking->get_id() . '&action=edit' ) ) ) );
	?>
</p>

<?php do_action( 'woocommerce_email_footer' ); ?>
