<div class="vczapi-woo-licensing-wrap">
    <?php
    if($heading != false){
        echo '<h2>'.$heading.'</h2>';
    }
    ?>
    <p><i>Enter your license keys here to receive updates and support for purchased addon.</i></p>
    <form method="POST" action="">
        <table class="form-table">
            <tbody>
			<?php if ( $this->status !== 'valid' ) { ?>
                <tr valign="top">
                    <th scope="row" valign="top">
						<?php _e( 'License Key', 'vczapi-woo-addon' ); ?>
                    </th>
                    <td>
                        <input id="vczapi_woo_addon_license_key" name="vczapi_woo_addon_license_key" type="password" class="regular-text" value="<?php esc_attr_e( $this->license ); ?>"/>
                        <p class="description" for="vczapi_woo_addon_license_key"><?php _e( 'Enter your license key', 'vczapi-woo-addon' ); ?></p>
                    </td>
                </tr>
			<?php } ?>
			<?php //if ( false != $this->license ) {
			?>
            <tr valign="top">
                <th scope="row" valign="top">
					<?php _e( 'License', 'vczapi-woo-addon' ); ?>
                </th>
                <td>
					<?php wp_nonce_field( '_vczapi_woo_addon_licensing_nonce', 'vczapi_woo_addon' ); ?>
					<?php if ( ! empty( $this->status ) && $this->status === 'valid' ) { ?>
                        <input type="submit" class="button button-primary" name="vczapi_woo_addon_license_deactivate" value="<?php _e( 'Deactivate License', 'vczapi-woo-addon' ); ?>"/>
					<?php } else { ?>
                        <input type="submit" class="button button-primary" name="vczapi_woo_addon_license_activate" value="<?php _e( 'Save and Activate License', 'vczapi-woo-addon' ); ?>"/>
					<?php } ?>
                </td>
            </tr>
			<?php //} ?>
            </tbody>
        </table>
    </form>
</div>