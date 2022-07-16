<?php
extract(shortcode_atts(array(
    'video_link' => '',
    'video_intro' => '',
    'btn_styles' => 'style1',
    'intro_styles' => 'style1',
    'intro_size' => 'full',
    'animation' => '',
    'el_class' => '',
), $atts));
$html_id = cmsHtmlID('ct-video');
$img = wpb_getImageBySize( array(
    'attach_id'  => $video_intro,
    'thumb_size' => $intro_size,
    'class'      => '',
));
$thumbnail = $img['thumbnail'];
$link = vc_build_link($video_link);
$a_href = 'https://www.youtube.com/watch?v=SF4aHwxHtZ0';
if ( strlen( $link['url'] ) > 0 ) {
    $a_href = $link['url'];
}
$animation_tmp = isset($animation) ? $animation : '';
$animation_classes = $this->getCSSAnimation( $animation_tmp ); ?>

<div id="<?php echo esc_attr($html_id);?>" class="ct-video-wrapper <?php echo esc_attr( $el_class.' '.$animation_classes ); ?>">
    <div class="ct-video-inner intro-<?php echo esc_attr($intro_styles); ?>">
        <?php if (!empty($video_intro)) : ?>
            <?php echo wp_kses_post($thumbnail); ?>
        <?php endif; ?>
        <a class="ct-video-button <?php echo esc_attr($btn_styles); ?>" href="<?php echo esc_url($a_href);?>">
            <i class="fa fa-play"></i>
        </a>
    </div>
</div>