<?php
extract(shortcode_atts(array(

    'title'         => '',
    'title_color'         => '',
    'grouping'         => '0',
    'separator'         => '',
    'digit'         => '',
    'digit_color'         => '',
    'prefix'         => '',
    'suffix'         => '',

    'icon_type' => 'icon',
    'icon_list' => 'fontawesome',
    'icon_fontawesome' => '',
    'icon_material_design' => '',
    'icon_flaticon' => '',
    'icon_etline' => '',
    'icon_image' => '',
    'icon_color' => '',
    'icon_font_size' => '',

    'el_class'         => '',
    'animation'         => '',
    'style'         => 'style1',

), $atts));
wp_enqueue_script( 'waypoints' );
wp_enqueue_script( 'lawsight-counter-lib' );
wp_enqueue_script( 'lawsight-counter' );
$icon_image_url = '';
if (!empty($icon_image)) {
    $attachment_image = wp_get_attachment_image_src($icon_image, 'full');
    $icon_image_url = $attachment_image[0];
}
$icon_name = "icon_" . $icon_list;
$icon_class = isset(${$icon_name}) ? ${$icon_name} : '';
$html_id = cmsHtmlID('ct-counter');
$animation_tmp = isset($animation) ? $animation : '';
$animation_classes = $this->getCSSAnimation( $animation_tmp );
?>
<div id="<?php echo esc_attr($html_id);?>" class="ct-counter ct-counter-default col-same-height <?php echo esc_attr( $style.' '.$animation_classes.' '.$el_class ); ?>">

    <div class="ct-counter-inner">
        <div class="ct-counter-holder">
            <?php if(!empty($icon_image_url) && $icon_type == 'image' ) { ?>
                <div class="ct-counter-icon">
                    <img class="icon-main" src="<?php echo esc_url( $icon_image_url ); ?>" alt="<?php echo esc_attr( $title ); ?>"/>
                </div>
            <?php } else { ?>
                <?php if($icon_class):?>
                    <div class="ct-counter-icon">
                        <i class="<?php echo esc_attr($icon_class); ?> <?php if(!empty($icon_color)) { echo 'colored'; } ?>" style="<?php if(!empty($icon_color)) { echo 'color:'.esc_attr($icon_color).';'; } if(!empty($icon_font_size)) { echo 'font-size:'.esc_attr($icon_font_size).'px;'; } ?>"></i>
                    </div>
                <?php endif;?>
            <?php } ?>
            <span id="<?php echo esc_attr($html_id);?>-digit" class="ct-counter-digit" data-grouping="<?php echo esc_attr($grouping); ?>" data-separator="<?php echo esc_attr($separator); ?>" data-digit="<?php echo esc_attr($digit);?>" data-prefix="<?php echo esc_attr($prefix);?>" data-suffix="<?php echo esc_attr($suffix);?>" style="<?php if(!empty($digit_color)) { echo 'color:'.esc_attr($digit_color).';'; } ?>"></span>
            <?php if(!empty($title)) : ?>
                <h3 class="ct-counter-title" style="<?php if(!empty($title_color)) { echo 'color:'.esc_attr($title_color).';'; } ?>">
                    <?php echo apply_filters('the_title', $title);?>
                </h3>
            <?php endif;?>
        </div>
    </div>
</div>