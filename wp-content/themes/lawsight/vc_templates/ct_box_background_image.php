<?php
extract(shortcode_atts(array(
    'bg_image' => '',
    'layer_image' => '',
    'box_height' => '',
    'box_height_mobile' => '',
    'el_class' => '',
), $atts));

$uqid = uniqid();

$bg_image_url = '';
if (!empty($bg_image)) {
    $attachment_image = wp_get_attachment_image_src($bg_image, 'full');
    $bg_image_url = $attachment_image[0];
}

$layer_image_url = '';
if (!empty($layer_image)) {
    $attachment_image_layer = wp_get_attachment_image_src($layer_image, 'full');
    $layer_image_url = $attachment_image_layer[0];
}

?>
<div id="ct-box-bg-<?php echo esc_attr($uqid);?>" class="ct-box-bg bg-image <?php echo esc_attr($el_class); ?>" style="background-image: url(<?php echo esc_url( $bg_image_url ); ?>);">
    <style type="text/css">
        <?php if(!empty($box_height)) : ?>
            @media screen and (min-width: 768px) {
                #ct-box-bg-<?php echo esc_attr($uqid);?> {
                    height: <?php echo esc_attr($box_height); ?>px;
                }
            }
        <?php endif; ?>

        <?php if(!empty($box_height_mobile)) : ?>
            @media screen and (max-width: 767px) {
                #ct-box-bg-<?php echo esc_attr($uqid);?> {
                    height: <?php echo esc_attr($box_height_mobile); ?>px;
                }
            }
        <?php endif; ?>
    </style>
    <?php if(!empty($layer_image_url)) : ?>
        <div class="ct-box-image"><img src="<?php echo esc_url( $layer_image_url ); ?>" alt="<?php echo esc_html__('Layer', 'lawsight'); ?>" /></div>
    <?php endif; ?>
</div>