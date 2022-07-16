<?php
class GetInTouch_Widget extends WP_Widget {

    function __construct() {
        parent::__construct(
            'getintouch_widget',
            esc_html__('* Get In Touch', 'lawsight'),
            array('description' => esc_html__('Get In Touch Widget', 'lawsight'),)
        );
    }

    function widget($args, $instance) {

        extract($args);

        $title = isset($instance['title']) ? (!empty($instance['title']) ? $instance['title']: '') : '';
        $address_text = isset($instance['address_text']) ? (!empty($instance['address_text']) ? $instance['address_text']: '') : '';
        $phone_text = isset($instance['phone_text']) ? (!empty($instance['phone_text']) ? $instance['phone_text']: '') : '';
        $phone_text_result = preg_replace('#[+ () ]*#', '', $phone_text);
        $email_text = isset($instance['email_text']) ? (!empty($instance['email_text']) ? $instance['email_text']: '') : '';
        $styles = isset($instance['styles']) ? (!empty($instance['styles']) ? $instance['styles']: '') : '';
        ?>
        <div class="contact-info widget">
            <?php if(!empty($title)) : ?>
                <h3 class="footer-widget-title widget-title"><?php echo esc_attr($title); ?></h3>
            <?php endif; ?>
            <?php if($styles == 'style1') { ?>
                <ul class="ct-contact-info-inner <?php echo esc_attr($styles); ?>">
                    <?php if(!empty($phone_text)): ?>
                        <li>
                            <i class="fa fa-phone"></i>
                            <span><?php echo wp_kses_post( $phone_text  ); ?></span>
                        </li>
                    <?php endif; ?>
                    <?php if(!empty($email_text)): ?>
                        <li>
                            <i class="fa fa-envelope"></i>
                            <span><?php echo wp_kses_post( $email_text  ); ?></span>
                        </li>
                    <?php endif; ?>
                    <?php if(!empty($address_text)): ?>
                        <li>
                            <i class="fa fa-home"></i>
                            <span><?php echo wp_kses_post( $address_text  ); ?></span>
                        </li>
                    <?php endif; ?>
                </ul>
            <?php } else { ?>
                <ul class="ct-contact-info-inner <?php echo esc_attr($styles); ?>">
                    <?php if(!empty($address_text)): ?>
                        <li>
                            <i class="fac fac-map-marker"></i>
                            <span><?php echo wp_kses_post( $address_text  ); ?></span>
                        </li>
                    <?php endif; ?>
                    <?php if(!empty($phone_text)): ?>
                        <li>
                            <i class="fac fac-phone"></i>
                            <span><?php echo wp_kses_post( $phone_text  ); ?></span>
                        </li>
                    <?php endif; ?>
                    <?php if(!empty($email_text)): ?>
                        <li>
                            <i class="fac fac-envelope"></i>
                            <span><?php echo wp_kses_post( $email_text  ); ?></span>
                        </li>
                    <?php endif; ?>
                </ul>
            <?php } ?>
        </div>
    <?php }

    function update( $new_instance, $old_instance ) {
         $instance = $old_instance;
         $instance['title'] = strip_tags($new_instance['title']);
         $instance['address_text'] = strip_tags($new_instance['address_text']);
         $instance['phone_text'] = strip_tags($new_instance['phone_text']);
         $instance['email_text'] = strip_tags($new_instance['email_text']);
         $instance['styles'] = strip_tags($new_instance['styles']);

         return $instance;
    }

    function form( $instance ) {
         $title = isset($instance['title']) ? esc_attr($instance['title']) : '';
         $address_text = isset($instance['address_text']) ? esc_attr($instance['address_text']) : '';
         $phone_text = isset($instance['phone_text']) ? esc_attr($instance['phone_text']) : '';
         $email_text = isset($instance['email_text']) ? esc_attr($instance['email_text']) : '';
         $styles = isset($instance['styles']) ? esc_attr($instance['styles']) : '';

         ?>
        <p><label for="<?php echo esc_url($this->get_field_id('title')); ?>"><?php esc_html_e( 'Title', 'lawsight' ); ?></label>
        <input class="widefat" id="<?php echo esc_attr( $this->get_field_id('title') ); ?>" name="<?php echo esc_attr( $this->get_field_name('title') ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" /></p>

        <p><label for="<?php echo esc_url($this->get_field_id('address_text')); ?>"><?php esc_html_e( 'Address', 'lawsight' ); ?></label>
        <input class="widefat" id="<?php echo esc_attr( $this->get_field_id('address_text') ); ?>" name="<?php echo esc_attr( $this->get_field_name('address_text') ); ?>" type="text" value="<?php echo esc_attr( $address_text ); ?>" /></p>

        <p><label for="<?php echo esc_url($this->get_field_id('phone_text')); ?>"><?php esc_html_e( 'Phone', 'lawsight' ); ?></label>
        <input class="widefat" id="<?php echo esc_attr( $this->get_field_id('phone_text') ); ?>" name="<?php echo esc_attr( $this->get_field_name('phone_text') ); ?>" type="text" value="<?php echo esc_attr( $phone_text ); ?>" /></p>
        
        <p><label for="<?php echo esc_url($this->get_field_id('email_text')); ?>"><?php esc_html_e( 'Email Text', 'lawsight' ); ?></label>
        <input class="widefat" id="<?php echo esc_attr( $this->get_field_id('email_text') ); ?>" name="<?php echo esc_attr( $this->get_field_name('email_text') ); ?>" type="text" value="<?php echo esc_attr( $email_text ); ?>" /></p>
        
        <p><label for="<?php echo esc_url($this->get_field_id('styles')); ?>"><?php esc_html_e( 'Styles', 'lawsight' ); ?></label>
         <select class="widefat" id="<?php echo esc_attr( $this->get_field_id('styles') ); ?>" name="<?php echo esc_attr( $this->get_field_name('styles') ); ?>">
            <option value="style1"<?php if( $styles == 'style1' ){ echo 'selected="selected"';} ?>><?php esc_html_e('Style 1', 'lawsight'); ?></option>
            <option value="style2"<?php if( $styles == 'style2' ){ echo 'selected="selected"';} ?>><?php esc_html_e('Style 2', 'lawsight'); ?></option>
         </select>
         </p>
    <?php
    }
}
function register_getintouch_widget() {
    if(function_exists('ct_allow_RegisterWidget')){
        ct_allow_RegisterWidget( 'GetInTouch_Widget' );
    }
}
add_action('widgets_init', 'register_getintouch_widget');
