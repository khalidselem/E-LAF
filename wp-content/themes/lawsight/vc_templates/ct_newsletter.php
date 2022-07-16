<?php
extract(shortcode_atts(array(
    'form' => '',
    'el_title' => '',
    'el_image' => '',
    'animation'   => '',
    'el_class'   => '',
), $atts));
$bg_image_url = '';
if (!empty($el_image)) {
    $attachment_image = wp_get_attachment_image_src($el_image, 'full');
    $bg_image_url = $attachment_image[0];
}
$animation_tmp = isset($animation) ? $animation : '';
$animation_classes = $this->getCSSAnimation( $animation_tmp );
$defined_forms = array( 'form_1', 'form_2', 'form_3', 'form_4', 'form_5', 'form_6', 'form_7', 'form_8', 'form_9', 'form_10' );
if(class_exists('Newsletter')) { ?>
    <div class="ct-newsletter bg-image <?php echo esc_attr( $el_class.' '.$animation_classes ); ?>" <?php if(!empty($bg_image_url)) : ?>style="background-image: url(<?php echo esc_url($bg_image_url); ?>);"<?php endif; ?>>
        <div class="ct-newsletter-inner">
            <?php if(!empty($el_title)) : ?>
                <h3 class="ct-newsletter-title">
                    <?php echo wp_kses_post($el_title); ?>
                </h3>
            <?php endif; ?>
            <?php if ( in_array( $form, $defined_forms ) ) {
                $form = str_replace( 'form_', '', $form );
                echo do_shortcode( '[newsletter_form form="' . esc_attr( $form ) . '"]' );
            } else {
                echo NewsletterSubscription::instance()->get_subscription_form();
            } ?>
        </div>
    </div>
<?php } ?>