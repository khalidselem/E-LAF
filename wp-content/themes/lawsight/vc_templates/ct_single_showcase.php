<?php
extract(shortcode_atts(array(
    'title' => '',
    'showcase_image' => '',
    'demo_link' => '',
    'coming_soon' => '',

    'animation' => '',
    'el_class' => '',
), $atts));

$image_url = '';
if (!empty($showcase_image)) {
    $attachment_image = wp_get_attachment_image_src($showcase_image, 'full');
    $image_url = $attachment_image[0];
}

$link = vc_build_link($demo_link);
$a_href = '';
$a_target = '';
if ( strlen( $link['url'] ) > 0 ) {
    $a_href = $link['url'];
    $a_target = strlen( $link['target'] ) > 0 ? $link['target'] : '_self';
}
?>
<div class="ct-single-showcase <?php if($coming_soon == 'yes') { echo 'coming-soon'; } ?> <?php echo esc_attr($el_class); ?>">
	<div class="ct-single-showcase-inner">
		<?php if( !empty($image_url) ) { ?>
            <div class="ct-single-showcase-image">
                <img class="icon-main" src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $title ); ?>"/>
                <div class="item-overlay">
                    <?php if($coming_soon == 'yes') { ?>
                        <a class="btn" href="<?php echo esc_url($a_href);?>" target="<?php  echo esc_attr($a_target); ?>"><?php echo esc_html__('More Pages+', 'lawsight'); ?></a>
                    <?php } else { ?>
                        <a class="btn" href="<?php echo esc_url($a_href);?>" target="<?php  echo esc_attr($a_target); ?>"><?php echo esc_html__('View now', 'lawsight'); ?></a>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
        <div class="ct-single-showcase-meta">
            <h3><a href="<?php echo esc_url($a_href);?>" target="<?php  echo esc_attr($a_target); ?>"><?php echo wp_kses_post($title); ?></a></h3>
        </div>
	</div>
</div>