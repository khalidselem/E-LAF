<?php
extract(shortcode_atts(array(
    'title' => '',
    'price' => '',
    'pricing_time' => '',
    'description' => '',
    'text_button' => '',
    'link_button' => '',

    'icon_type' => 'icon',
    'icon_list' => 'fontawesome',
    'icon_fontawesome' => '',
    'icon_material_design' => '',
    'icon_flaticon' => '',
    'icon_etline' => '',
    'icon_image' => '',

    'el_class' => '',
    'animation' => '',
), $atts));

$icon_image_url = '';
if (!empty($icon_image)) {
    $attachment_image = wp_get_attachment_image_src($icon_image, 'full');
    $icon_image_url = $attachment_image[0];
}

$icon_name = "icon_" . $icon_list;
$icon_class = isset(${$icon_name}) ? ${$icon_name} : '';

$link = vc_build_link($link_button);
$a_href = '';
$a_target = '_self';
if ( strlen( $link['url'] ) > 0 ) {
    $a_href = $link['url'];
    $a_target = strlen( $link['target'] ) > 0 ? $link['target'] : '_self';
} 
$animation_tmp = isset($animation) ? $animation : '';
$animation_classes = $this->getCSSAnimation( $animation_tmp );
?>

<div class="ct-pricing-wrapper <?php echo esc_attr($el_class.' '.$animation_classes); ?>">
    <div class="ct-pricing-inner">
        <div class="ct-pricing-header">
            <div class="ct-pricing-holder">
                <?php if(!empty($icon_image_url) && $icon_type == 'image' ) { ?>
                    <div class="ct-pricing-icon">
                        <img class="icon-main" src="<?php echo esc_url( $icon_image_url ); ?>" alt="<?php echo esc_attr( $title ); ?>"/>
                    </div>
                <?php } else { ?>
                    <?php if($icon_class):?>
                        <div class="ct-pricing-icon">
                            <?php if(!empty($a_href)) : ?><a class="more-overlay" href="<?php echo esc_url($a_href);?>" target="<?php  echo esc_attr($a_target); ?>"><?php endif; ?>
                                <i class="<?php echo esc_attr($icon_class); ?>"></i>
                            <?php if(!empty($a_href)) : ?></a><?php endif; ?>
                        </div>
                    <?php endif;?>
                <?php } ?>
                <?php if(!empty($title)) : ?>
                    <h3 class="ct-pricing-title" style="<?php if(!empty($title_color)) { echo 'color:'.esc_attr($title_color).';'; } ?>"><?php echo esc_attr($title);?></h3> 
                <?php endif;?>
            </div>
            <div class="ct-pricing-meta">
                <span class="ct-pricing-price">
                    <?php echo esc_attr($price);?>  
                </span>
                <span class="ct-pricing-time" style="<?php if(!empty($title_color)) { echo 'color:'.esc_attr($title_color).';'; } ?>">
                    <?php echo esc_attr('/ '.$pricing_time);?>  
                </span>
            </div>
        </div>
        <div class="ct-pricing-body">
            <div class="ct-pricing-desc">
                <?php echo esc_attr($description); ?>
            </div>
            <?php if(!empty($text_button)) : ?>
                <div class="ct-pricing-button">
                    <a class="btn btn-gradient" href="<?php echo esc_url($a_href);?>" target="<?php echo esc_attr( $a_target ); ?>">
                        <?php echo esc_attr($text_button); ?>
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>