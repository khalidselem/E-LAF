<?php
extract(shortcode_atts(array(
    'image_animation' => '',
), $atts));

$image_url = '';
if (!empty($image_animation)) {
    $attachment_image = wp_get_attachment_image_src($image_animation, 'full');
    $image_url = $attachment_image[0];
}
?>
<div class="ct-background-animate">
    <div class="ct-animate-inner" <?php if(!empty($image_url)) : ?> style="background-image: url(<?php echo esc_url($image_url); ?>);" <?php endif; ?>></div>
</div>