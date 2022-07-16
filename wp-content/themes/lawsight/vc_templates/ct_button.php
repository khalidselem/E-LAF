<?php
extract(shortcode_atts(array(
    'button_text' => '',
    'button_link' => '',
    'button_style' => 'btn-default',
    'button_size' => 'size-default',
    'align_lg' => 'align-left',
    'align_md' => 'align-left-md',
    'align_sm' => 'align-left-sm',
    'align_xs' => 'align-left-xs',
    'padding_top'    => '',
    'padding_right'  => '',
    'padding_bottom' => '',
    'padding_left'   => '',
    'br_top'   => '',
    'br_right'   => '',
    'br_bottom'   => '',
    'br_left'   => '',
    'animation'   => '',
    'el_class'   => '',
    'icon_list' => 'fontawesome',
    'icon_fontawesome' => '',
    'icon_material_design' => '',
    'icon_etline' => '',
    'icon_flaticon' => '',
    'icon_themify' => '',
), $atts));
$icon_name = "icon_" . $icon_list;
$icon_class = isset(${$icon_name}) ? ${$icon_name} : '';
$link = vc_build_link($button_link);
$a_href = '';
$a_target = '';
if ( strlen( $link['url'] ) > 0 ) {
    $a_href = $link['url'];
    $a_target = strlen( $link['target'] ) > 0 ? $link['target'] : '_self';
}
$style_padding = array(
    'padding-top'    => $padding_top.'px',
    'padding-right'  => $padding_right.'px',
    'padding-bottom' => $padding_bottom.'px',
    'padding-left'   => $padding_left.'px',
    'border-top-left-radius'   => $br_top.'px',
    '-webkit-border-top-left-radius'   => $br_top.'px',
    'border-top-right-radius'   => $br_right.'px',
    '-webkit-border-top-right-radius'   => $br_right.'px',
    'border-bottom-left-radius'   => $br_left.'px',
    '-webkit-border-bottom-left-radius'   => $br_left.'px',
    'border-bottom-right-radius'   => $br_bottom.'px',
    '-webkit-border-bottom-right-radius'   => $br_bottom.'px',
);
$styles = '';
foreach ($style_padding as $key => $value) {
    if (!empty($value) && $value != 'px') {
        $styles .= $key . ':' . $value . ';';
    }
}

$animation_tmp = isset($animation) ? $animation : '';
$animation_classes = $this->getCSSAnimation( $animation_tmp );

?>
<div class="ct-button-wrapper <?php echo esc_attr($align_lg.' '.$align_md.' '.$align_sm.' '.$align_xs.' '.$animation_classes); ?>">

    <a <?php echo !empty($styles) ? 'style="' . esc_attr($styles) . '"' : '' ?> href="<?php echo esc_url($a_href);?>" target="<?php  echo esc_attr($a_target); ?>" class="<?php echo esc_attr($el_class); ?> btn <?php if($icon_class) { echo 'btn-icon'; } ?> <?php echo esc_attr($button_style.' '.$button_size); ?>">
        <span><?php echo esc_attr($button_text); ?></span>
        <?php if($icon_class):?>
            <i class="<?php echo esc_attr($icon_class); ?>"></i>
        <?php endif; ?>
    </a>

</div>