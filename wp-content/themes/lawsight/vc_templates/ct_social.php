<?php
extract(shortcode_atts(array(
    'social' => '',
    'align' => 'left',
    'el_class' => '',
), $atts));
$ct_social = array();
$ct_social = (array) vc_param_group_parse_atts( $social );

if(!empty($ct_social)) : ?>
    <div class="ct-social text-<?php echo esc_attr($align); ?> <?php echo esc_attr($el_class); ?>">
        <?php foreach ($ct_social as $key => $value) {
            $social_link = isset($value['social_link']) ? $value['social_link'] : '';
            $social_color = isset($value['social_color']) ? $value['social_color'] : '';
            $icon_class = isset($value['icon']) ? $value['icon'] : ''; ?>
            <a href="<?php echo esc_url($social_link); ?>" target="_blank"><i class="<?php echo esc_attr( $icon_class ); ?>" style="<?php if(!empty($text_color)) { echo 'background-color:'.esc_attr($social_color).';'; } ?>"></i></a>
        <?php } ?>
    </div>
<?php endif;?>