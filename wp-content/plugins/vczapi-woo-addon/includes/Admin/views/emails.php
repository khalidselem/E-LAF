<form method="post" action="">
	<?php wp_nonce_field( 'vczapi_verify_email_settings', 'vczapi_email_settings_nonce' ) ?>
    <table class="form-table">
        <tr>
            <th>
                <label for="vczapi_disable_meeting_reminder_email">
					<?php _e( 'Disable Meeting Reminder', 'vczapi-woo-addon' ); ?>
                </label>
            </th>
            <td>
                <input type="checkbox" name="vczapi_disable_meeting_reminder_email" id="vczapi_disable_meeting_reminder_email" <?php checked( 'on', $this->settings['disable_reminder'], true ) ?>>
                <span class="description"><?php _e( 'Check this box to disable Meeting Reminder, by default the e-mail will be sent 24 hours before the meeting.', 'vczapi-woo-addon' ); ?></span>
            </td>
        </tr>
        <tr id="meeting-reminder-time-section">
            <th><?php _e( 'Meeting Reminder Email Schedule', 'vczapi-woo-addon' ); ?></th>
            <td>
				<?php
				/* @todo sync this with cron so the meeting defined via filter work as expected
				 * at present it wont work
				 */
				$meeting_schedules = apply_filters( 'vczapi_wc_email_meeting_reminder_times', $this->email_reminder_times );
				foreach ( $meeting_schedules as $key => $label ):
					?>
                    <label>
                        <input type="checkbox" name="meeting-reminder-time[]" id="meeting-reminder-time[<?php echo $key; ?> ]" value="<?php echo $key; ?>" <?php echo $this->checked_in_array( $key, $this->settings['email_schedule'] ) ?>>
						<?php echo $label; ?>
                    </label><br>
				<?php
				endforeach;
				?>
            </td>
        </tr>
        <tr>
            <th><label for="vczapi-enable-debug-log"><?php _e( 'Enable Mail Debug Log', 'vczapi-woocommerce-addons' ); ?></label></th>
            <td>
                <input id="vczapi-enable-debug-log" name="vczapi-enable-debug-log" type="checkbox" <?php ! empty( $this->settings['enable_log'] ) ? checked( 'on', $this->settings['enable_log'] ) : false; ?>>
                <span class="description">Logs will be stored inside <i>uploads/vczapi-wc-logs</i> folder.</span>
            </td>
        </tr>
    </table>
    <p>
        <input title="Save Form" type="submit" name="save_emails_form" class="button button-primary button-large" value="<?php _e( 'Save', 'vczapi-woo-addon' ) ?>">
    </p>
</form>