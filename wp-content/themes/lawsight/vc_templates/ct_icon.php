<?php
extract(shortcode_atts(array(
    'icon'             => '',
    'el_class'             => '',
), $atts));
$html_id = cmsHtmlID('ct-icon');
$icon = (array) vc_param_group_parse_atts($icon);
if(!empty($icon)) : ?>
    <div id="<?php echo esc_attr($html_id) ?>" class="ct-icon <?php echo esc_attr($el_class); ?>">
        <?php foreach ($icon as $key => $value) {
            $icon_link = isset($value['icon_link']) ? $value['icon_link'] : '';
            $icon_class = isset($value['icon']) ? $value['icon'] : ''; 
            $link = vc_build_link($icon_link);
            $a_href = '';
            $a_target = '';
            if ( strlen( $link['url'] ) > 0 ) {
                $a_href = $link['url'];
                $a_target = strlen( $link['target'] ) > 0 ? $link['target'] : '_self';
            }
            ?>
            <a href="<?php echo esc_url($a_href); ?>" target="<?php echo esc_attr($a_target); ?>"><i class="<?php echo esc_attr( $icon_class ); ?> text-gradient"></i></a>
        <?php } ?>
    </div>
<?php endif; ?>