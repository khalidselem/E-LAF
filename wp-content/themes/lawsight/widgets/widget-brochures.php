<?php
class Brochures_Widget extends WP_Widget {

    function __construct() {
        parent::__construct(
            'brochures_widget',
            esc_html__('* Brochures', 'lawsight'),
            array('link' => esc_html__('Brochures Widget', 'lawsight'),)
        );
    }

    function widget($args, $instance) {

        extract($args);

        $text = isset($instance['text']) ? (!empty($instance['text']) ? $instance['text']: '') : '';
        $link = isset($instance['link']) ? (!empty($instance['link']) ? $instance['link']: '') : '';
        $icon = isset($instance['icon']) ? (!empty($instance['icon']) ? $instance['icon']: '') : '';
        if(!empty($text)) :?>
            <div class="ct-brochures">
                <a href="<?php echo esc_url($link); ?>" target="_blank">
                    <span>
                        <?php if($icon == 'download') { ?>
                            <i class="zmdi zmdi-download text-gradient"></i>
                        <?php } else { ?>
                            <i class="fa fa-file-pdf-o text-gradient"></i>
                        <?php } ?>
                        <?php echo esc_attr($text); ?>
                    </span>
                </a>
            </div>
    <?php endif; }

    function update( $new_instance, $old_instance ) {
         $instance = $old_instance;
         $instance['text'] = strip_tags($new_instance['text']);
         $instance['link'] = strip_tags($new_instance['link']);
         $instance['icon'] = strip_tags($new_instance['icon']);

         return $instance;
    }

    function form( $instance ) {
         $text = isset($instance['text']) ? esc_attr($instance['text']) : '';
         $link = isset($instance['link']) ? esc_attr($instance['link']) : '';
         $icon = isset($instance['icon']) ? esc_attr($instance['icon']) : '';

         ?>
        <p><label for="<?php echo esc_url($this->get_field_id('text')); ?>"><?php esc_html_e( 'Text', 'lawsight' ); ?></label>
        <input class="widefat" id="<?php echo esc_attr( $this->get_field_id('text') ); ?>" name="<?php echo esc_attr( $this->get_field_name('text') ); ?>" type="text" value="<?php echo esc_attr( $text ); ?>" /></p>

        <p><label for="<?php echo esc_url($this->get_field_id('link')); ?>"><?php esc_html_e( 'Link', 'lawsight' ); ?></label>
        <input class="widefat" id="<?php echo esc_attr( $this->get_field_id('link') ); ?>" name="<?php echo esc_attr( $this->get_field_name('link') ); ?>" type="text" value="<?php echo esc_attr( $link ); ?>" /></p>

        <p><label for="<?php echo esc_url($this->get_field_id('icon')); ?>"><?php esc_html_e( 'Icon', 'lawsight' ); ?></label>
         <select class="widefat" id="<?php echo esc_attr( $this->get_field_id('icon') ); ?>" name="<?php echo esc_attr( $this->get_field_name('icon') ); ?>">
            <option value="download"<?php if( $icon == 'download' ){ echo 'selected="selected"';} ?>><?php esc_html_e('Download', 'lawsight'); ?></option>
            <option value="pdf"<?php if( $icon == 'pdf' ){ echo 'selected="selected"';} ?>><?php esc_html_e('PDF', 'lawsight'); ?></option>
         </select>
         </p>
    <?php
    }
}
function register_brochures_widget() {
    if(function_exists('ct_allow_RegisterWidget')){
        ct_allow_RegisterWidget( 'Brochures_Widget' );
    }
}
add_action('widgets_init', 'register_brochures_widget');
