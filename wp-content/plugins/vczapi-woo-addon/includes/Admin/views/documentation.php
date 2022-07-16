<section class="vczapi-shortcode-section">
    <h3>Basic Documentation</h3>
    <p>* Please carefully read below guides to understand how to override WooCommerce Booking templates to get your meeting join and start links
        directly from email or my-accounts page. <strong>This guide is intended for normal users.</strong></p>

    <div class="vczapi-shortcode-body-section">
        <h3>Overridden Booking Information:</h3>
        <p>Default booking templates found in below list are overridden in this plugin. So, if you have overridden these templates from your theme
            then also, it gets overridden from this plugin. To get links from the templates. </p>
        <ol>
            <li>/wp-content/plugins/woocommerce-bookings/templates/myaccount/bookings.php</li>
            <li>/wp-content/plugins/woocommerce-bookings/templates/emails/admin-new-booking.php</li>
            <li>/wp-content/plugins/woocommerce-bookings/templates/emails/customer-booking-confirmed.php</li>
        </ol>
        <hr>
        <h3>Follow; Only if your WooCommerce template is customized:</h3>
        <p>Only follow if you have customized these below templates as custom on your themes or plugins.</p>
        <ol>
            <li>/wp-content/plugins/woocommerce-bookings/templates/myaccount/bookings.php</li>
            <li>/wp-content/plugins/woocommerce-bookings/templates/emails/admin-new-booking.php</li>
            <li>/wp-content/plugins/woocommerce-bookings/templates/emails/customer-booking-confirmed.php</li>
        </ol>
        <p>Copy: <code>echo \Codemanas\ZoomWooBookingAddon\DataStore::get_join_link( $booking );</code> to your Booking template where you want to
            show join links.</p>
        <p>Copy: <code>echo \Codemanas\ZoomWooBookingAddon\DataStore::get_start_link( $booking );</code> to your Booking template where you want to
            show start links.</p>
        <hr>
        <h3>Overriding Booking Templates:</h3>
        First, check "Override Email Templates ?" setting above and save it to make this functional.

        <h4>My account bookings List page:</h4>
        * Copy: <code>/wp-content/plugins/vczapi-woo-addon/templates/myaccount/bookings.php</code> To: <code>wp-content/your-theme/woocommerce-bookings/myaccount/bookings.php</code>

        <h4>Admin New Booking Email:</h4>
        * Copy: <code>/wp-content/plugins/vczapi-woo-addon/templates/emails/admin-new-booking.php</code> To: <code>wp-content/your-theme/woocommerce-bookings/emails/admin-new-booking.php</code>

        <h4>Customer Booking Confirmation Email:</h4>
        * Copy: <code>/wp-content/plugins/vczapi-woo-addon/templates/emails/customer-booking-confirmed.php</code> To: <code>wp-content/your-theme/woocommerce-bookings/emails/customer-booking-confirmed.php</code>
        <hr>
        <h3>Overriding Meeting Cronjob Emails:</h3>
        <p>These are the emails which are sent when a meeting is purchased from a single meeting page. Customer and Admin both will receive cron
            emails before 24 hours of the meeting time. You can easily overwrite this email from your themes folder.</p>
        <ol>
            <li><strong>3 hours cron Host Email:</strong> Copy from vczapi-woo-addon/templates/email/html/host-invite-threehours.html to
                yourtheme/zoom-woocommerce-addon/email/html/host-invite-threehours.html
            </li>
            <li><strong>24 hour cron Host Email:</strong> Copy from vczapi-woo-addon/templates/email/html/host-invite-twentyfourhours.html to
                yourtheme/zoom-woocommerce-addon/email/html/host-invite-twentyfourhours.html
            </li>
            <li><strong>3 hours cron Customer Email:</strong> Copy from vczapi-woo-addon/templates/email/html/meeting-invite-threehours.html to
                yourtheme/zoom-woocommerce-addon/email/html/meeting-invite-threehours.html
            </li>
            <li><strong>24 hours cron Customer Email:</strong> Copy from vczapi-woo-addon/templates/email/html/meeting-invite-twentyfourhours.html to
                yourtheme/zoom-woocommerce-addon/email/html/meeting-invite-twentyfourhours.html
            </li>
        </ol>
    </div>
</section>