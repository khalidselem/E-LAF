<?php
extract(shortcode_atts(array(

    'images' => '',
    'img_size' => '359x455',
    'el_class' => '',

), $atts));
$ct_images = explode( ',', $images );
$html_id = cmsHtmlID('ct-image-gallery-carousel');
wp_enqueue_script( 'owl-carousel' );
wp_enqueue_script( 'lawsight-carousel' );
extract(lawsight_get_param_carousel($atts));
?>
<div class="ct-image-gallery-carousel images-light-box owl-carousel <?php echo esc_attr( $el_class ); ?>" <?php echo !empty($carousel_data) ?  esc_attr($carousel_data) : '' ?>>
    <?php foreach ($ct_images as $img_id) :
        $img = wpb_getImageBySize( array(
            'attach_id'  => $img_id,
            'thumb_size' => $img_size,
            'class'      => '',
        ));
        $thumbnail = $img['thumbnail'];
        ?>
        <div class="ct-image-gallery-item">
            <a class="light-box" href="<?php echo esc_url(wp_get_attachment_image_url($img_id, 'full'));?>"><?php echo wp_kses_post($thumbnail); ?></a>
        </div> 
    <?php endforeach; ?> 
</div>