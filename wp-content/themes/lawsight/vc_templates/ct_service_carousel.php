<?php
$atts_extra = shortcode_atts(array(
    'source'               => '',
    'orderby'              => 'date',
    'order'                => 'DESC',
    'limit'                => '6',
    'post_ids'             => '',
    'el_class'             => '',
    'except_length'             => '',
    'service_icon'             => '',
), $atts);
$atts = array_merge($atts_extra, $atts);
extract($atts);
extract(cms_get_posts_of_grid('service', $atts));
extract(lawsight_get_param_carousel($atts));
wp_enqueue_script( 'owl-carousel' );
wp_enqueue_script( 'lawsight-carousel' );
wp_enqueue_script( 'waypoints' );
wp_enqueue_script( 'vc_waypoints' );
wp_enqueue_style( 'vc_animate-css' );
$service_icon = (array) vc_param_group_parse_atts($service_icon);
?>

<div id="<?php echo esc_attr($html_id) ?>" class="ct-grid ct-grid-service-layout1 owl-carousel <?php echo esc_attr($el_class); ?>" <?php echo !empty($carousel_data) ?  esc_attr($carousel_data) : '' ?>>

    <?php
    if (is_array($posts)):
        foreach ($posts as $key => $post) {
            the_post(); 
            $icon_type = isset($service_icon[$key]['icon_type']) ? $service_icon[$key]['icon_type'] : 'icon';
            $icon_list = isset($service_icon[$key]['icon_list']) ? $service_icon[$key]['icon_list'] : 'fontawesome';
            $icon_fontawesome = isset($service_icon[$key]['icon_fontawesome']) ? $service_icon[$key]['icon_fontawesome'] : '';
            $icon_material_design = isset($service_icon[$key]['icon_material_design']) ? $service_icon[$key]['icon_material_design'] : '';
            $icon_flaticon = isset($service_icon[$key]['icon_flaticon']) ? $service_icon[$key]['icon_flaticon'] : '';
            $icon_etline = isset($service_icon[$key]['icon_etline']) ? $service_icon[$key]['icon_etline'] : '';
            $icon_image = isset($service_icon[$key]['icon_image']) ? $service_icon[$key]['icon_image'] : '';
            $icon_image_url = '';
            if (!empty($icon_image)) {
                $attachment_image = wp_get_attachment_image_src($icon_image, 'full');
                $icon_image_url = $attachment_image[0];
            }
            $icon_name = "icon_" . $icon_list;
            $icon_class = isset(${$icon_name}) ? ${$icon_name} : '';
            $service_except = get_post_meta($post->ID, 'service_except', true);
            $service_custom_link = get_post_meta($post->ID, 'service_custom_link', true);
            $media_class = '';
            if (has_post_thumbnail($post->ID) && wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), false)) {
                $media_class = 'featured';
            }
            ?>
            <div class="ct-carousel-item">
                <div class="grid-item-inner <?php echo esc_attr($media_class); ?>">
                    <div class="grid-item-holder">
                        <?php if(!empty($icon_image_url) && $icon_type == 'image' ) { ?>
                            <div class="item-icon">
                                <img src="<?php echo esc_url( $icon_image_url ); ?>" alt="<?php echo esc_attr(get_the_title($post->ID)); ?>"/>
                            </div>
                        <?php } else { ?>
                            <?php if($icon_class):?>
                                <div class="item-icon">
                                    <i class="<?php echo esc_attr($icon_class); if(empty($icon_color)) { echo ' text-gradient'; } ?>" style="<?php if(!empty($icon_color)) { echo 'color:'.esc_attr($icon_color).';'; } ?>"></i>
                                </div>
                            <?php endif;?>
                        <?php } ?>
                        <h3 class="item-title">
                            <a href="<?php if(!empty($service_custom_link)) { echo esc_url($service_custom_link); } else { echo esc_url(get_permalink( $post->ID )); } ?>"><?php echo esc_attr(get_the_title($post->ID)); ?></a>
                        </h3>
                        <?php if(!empty($except_length)) { ?>
                            <div class="item-except"><?php echo wp_trim_words( $service_except, $except_length, '...' ); ?></div>
                        <?php } else { ?>
                            <div class="item-except"><?php echo wp_kses_post($service_except); ?></div>
                        <?php } ?>
                    </div>
                    <?php if (has_post_thumbnail($post->ID) && wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), false)) : ?>
                        <?php  $thumbnail_url = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full', false); ?>
                        <div class="grid-item-hover bg-image" style="background-image: url(<?php echo esc_url($thumbnail_url[0]); ?>);">
                            <a class="btn btn-gradient" href="<?php if(!empty($service_custom_link)) { echo esc_url($service_custom_link); } else { echo esc_url(get_permalink( $post->ID )); } ?>"><?php echo esc_html__('Consult now', 'lawsight'); ?></a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php }
    endif; ?>
    
</div>