<?php
extract(shortcode_atts(array(
    'content_info' => '',
    'content_color' => '',
    'content_type' => 'text',
    'icon_list' => 'fontawesome',
    'icon_fontawesome' => '',
    'icon_fontawesome5' => '',
    'icon_material_design' => '',
    'icon_flaticon' => '',
    'icon_color' => '',
    'button_text' => '',
    'button_link' => '',
    'el_class' => '',
    'style' => 'style1',
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
?>
<div class="ct-contact-info <?php echo esc_attr($style.' '.$el_class); ?>">
	<div class="contact-info-inner">
        <?php if($icon_class):?>
            <div class="ct-contact-info-icon <?php if(!empty($icon_color)) { echo 'colored'; } ?>">
                <i class="<?php echo esc_attr($icon_class); ?>" style="<?php if(!empty($icon_color)) { echo 'color:'.esc_attr($icon_color).';'; } ?>"></i>
            </div>
        <?php endif;?>
        <div class="ct-contact-info-content" style="<?php if(!empty($content_color)) { echo 'color:'.esc_attr($content_color).';'; } ?>">
            <?php if($content_type == 'text') : ?>
                <?php echo wp_kses_post( $content_info ); ?>
            <?php endif; ?>
            <?php if($content_type == 'tel') : ?>
                <?php 
                    $content_info_result = preg_replace('#[+ () ]*#', '', $content_info);
                ?>
                <a href="tel:<?php echo esc_attr( $content_info_result ); ?>"><?php echo wp_kses_post( $content_info ); ?></a>
            <?php endif; ?>
            <?php if($content_type == 'email') : ?>
                <a href="mailto:<?php echo esc_attr( $content_info ); ?>"><?php echo wp_kses_post( $content_info ); ?></a>
            <?php endif; ?>
            <?php if($content_type == 'map') : ?>
                <?php echo wp_kses_post( $content_info ); ?>
                <?php if(!empty($button_text)) : ?>
                    <div class="view-map" >
                        <a href="<?php echo esc_url($a_href);?>" target="<?php  echo esc_attr($a_target); ?>">
                            <i class="text-gradient fa fa-street-view"></i>
                            <span><?php echo wp_kses_post($button_text); ?></span>
                        </a>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
	</div>
</div>