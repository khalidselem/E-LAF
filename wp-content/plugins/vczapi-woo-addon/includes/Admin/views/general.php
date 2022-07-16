<form method="POST" action="">
    <table class="form-table">
        <tbody>
        <tr valign="top">
            <th scope="row" valign="top">
				<?php _e( 'Disable Override Templates ?', 'vczapi-woo-addon' ); ?>
            </th>
            <td>
                <input id="override-email-templates" name="override_template" type="checkbox" class="regular-text" <?php checked( isset( $this->settings['override_tpl'] ) ? $this->settings['override_tpl'] : false, 'on' ); ?>/>
                <span class="description" for="override-email-templates"><?php _e( 'Checking this will use default WooCommerce Booking confirmation email and my account bookings template from WooCommerce Booking plugin, theme if you have copied into your theme. Customizations to your template is necessary if this option is checked.', 'vczapi-woo-addon' ); ?></span>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row" valign="top">
				<?php _e( 'Disable Meetings Tab (Frontend)?', 'vczapi-woo-addon' ); ?>
            </th>
            <td>
                <input id="disable-meetings-link" name="disable_meetings_tab" type="checkbox" class="regular-text" <?php checked( isset( $this->settings['disable_meetings_tab'] ) ? $this->settings['disable_meetings_tab'] : false, 'on' ); ?>/>
                <span class="description" for="override-email-templates"><?php _e( 'Checking this option will disable "Meetings" tab in your my-accounts page in frontend. Enable this if you\'ll use WooCommerce Bookings only for zoom meetings.', 'vczapi-woo-addon' ); ?></span>
            </td>
        </tr>
        <tr>
            <th>
                <label for="vczapi_disable_browser_join_links">
					<?php _e( 'Disable Browser Join Links', 'vczapi-woo-addon' ); ?>
                </label>
            </th>
            <td>
                <input type="checkbox" name="vczapi_disable_browser_join_links" id="vczapi_disable_browser_join_links" <?php checked( 'on', $this->settings['jvb'] ) ?>>
                <span class="description">
		                        <?php _e( 'Check this box if you want to disable join via browser links in your email as well as your meeting listing pages.', 'vczapi-woo-addon' ); ?>
	                        </span>
            </td>
        </tr>
        </tbody>
    </table>
    <p><input type="submit" class="button button-primary" name="save_general" value="Save"></p>
</form>

