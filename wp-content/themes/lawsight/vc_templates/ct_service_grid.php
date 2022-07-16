<?php
$atts_extra = shortcode_atts(array(
    'source'               => '',
    'orderby'              => 'date',
    'order'                => 'DESC',
    'limit'                => '6',
    'gap'                  => '30',
    'post_ids'             => '',
    'col_xl'               => 4,
    'col_lg'               => 4,
    'col_md'               => 3,
    'col_sm'               => 1,
    'col_xs'               => 1,
    'layout'               => 'basic',
    'pagination_type'      => 'loadmore',
    'filter'               => 'true',
    'filter_default_title' => 'All',
    'el_class'             => '',
    'except_length'             => '',
    'service_icon'             => '',
    'border_color'             => '',
    'title_color'             => '',
    'content_color'             => '',
    'readmore_text'             => '',
), $atts);
$atts = array_merge($atts_extra, $atts);
extract($atts);
$tax = array();
extract(cms_get_posts_of_grid('service', $atts, array('service-category')));
$filter_default_title = !empty($filter_default_title) ? $filter_default_title : 'All';

$col_xl = 12 / $col_xl;
$col_lg = 12 / $col_lg;
$col_md = 12 / $col_md;
$col_sm = 12 / $col_sm;
$col_xs = 12 / $col_xs;
$grid_sizer = "col-xl-{$col_xl} col-lg-{$col_lg} col-md-{$col_md} col-sm-{$col_sm} col-xs-{$col_xs}";

$gap_item = intval($gap / 2);

wp_enqueue_style(
    'inline-style',
    get_template_directory_uri() . '/assets/css/inline-style.css'
);
$grid_class = '';
if ($layout == 'masonry') {
    wp_enqueue_script('isotope');
    wp_enqueue_script('imagesloaded');
    wp_enqueue_script('lawsight-isotope', get_template_directory_uri() . '/assets/js/isotope.ct.js', array('jquery'), '1.0.0', true);
    $grid_class = 'ct-grid-inner ct-grid-masonry row';
    if($pagination_type == 'loadmore' || $pagination_type === 'pagination') {
        $html_id = str_replace('-', '_', $html_id);
        wp_enqueue_script('ct-loadmore-grid', get_template_directory_uri() . '/assets/js/ct-loadmore-grid.js', array('jquery'), 'all', true);
        wp_localize_script('ct-loadmore-grid', 'ct_load_more_' . $html_id, array(
            'startPage' => $paged,
            'maxPages'  => $max,
            'total'     => $total,
            'perpage'   => $limit,
            'nextLink'  => $next_link,
            'layout'    => $layout
        ));
    }
} else {
    $grid_class = 'ct-grid-inner row';
}
$html_id_el = '#'.$html_id;
$custom_css = "
        $html_id_el .ct-grid-inner {
            margin: 0 -{$gap_item}px;
        }
        $html_id_el .ct-grid-inner .grid-item, $html_id_el .ct-grid-inner .grid-sizer {
            padding: {$gap_item}px;
        }";
wp_add_inline_style('inline-style', $custom_css);
wp_enqueue_script( 'waypoints' );
wp_enqueue_script( 'vc_waypoints' );
wp_enqueue_style( 'vc_animate-css' );
$service_icon = (array) vc_param_group_parse_atts($service_icon);
?>

<div id="<?php echo esc_attr($html_id) ?>" class="ct-grid ct-grid-service-layout1 <?php echo esc_attr($el_class); ?>">

    <?php if ($filter == "true" and $layout == 'masonry'): ?>
        <div class="grid-filter-wrap">
            <span class="filter-item active" data-filter="*"><?php echo esc_html($filter_default_title); ?></span>
            <?php foreach ($categories as $category): ?>
                <?php $category_arr = explode('|', $category); ?>
                <?php $tax[] = $category_arr[1]; ?>
                <?php $term = get_term_by('slug',$category_arr[0], $category_arr[1]); ?>
                <span class="filter-item" data-filter="<?php echo esc_attr('.' . $term->slug); ?>">
                    <?php echo esc_html($term->name); ?>
                </span>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <div class="<?php echo esc_attr($grid_class); ?>" data-gutter="<?php echo esc_attr($gap_item); ?>">
        <?php if ($layout == 'masonry') : ?>
            <div class="grid-sizer <?php echo esc_attr($grid_sizer); ?>"></div>
        <?php endif; ?>
        <?php
        if (is_array($posts)):
            foreach ($posts as $key => $post) {
                $item_class   = "grid-item col-xl-{$col_xl} col-lg-{$col_lg} col-md-{$col_md} col-sm-{$col_sm} col-xs-{$col_xs}";
                $filter_class = cms_get_term_of_post_to_class($post->ID, array_unique($tax));
                $service_except = get_post_meta($post->ID, 'service_except', true);
                $service_custom_link = get_post_meta($post->ID, 'service_custom_link', true);
                $icon_type = isset($service_icon[$key]['icon_type']) ? $service_icon[$key]['icon_type'] : 'icon';
                $icon_list = isset($service_icon[$key]['icon_list']) ? $service_icon[$key]['icon_list'] : 'fontawesome';
                $icon_fontawesome = isset($service_icon[$key]['icon_fontawesome']) ? $service_icon[$key]['icon_fontawesome'] : '';
                $icon_material_design = isset($service_icon[$key]['icon_material_design']) ? $service_icon[$key]['icon_material_design'] : '';
                $icon_flaticon = isset($service_icon[$key]['icon_flaticon']) ? $service_icon[$key]['icon_flaticon'] : '';
                $icon_etline = isset($service_icon[$key]['icon_etline']) ? $service_icon[$key]['icon_etline'] : '';
                $icon_color = isset($service_icon[$key]['icon_color']) ? $service_icon[$key]['icon_color'] : '';
                $icon_image = isset($service_icon[$key]['icon_image']) ? $service_icon[$key]['icon_image'] : '';
                $icon_image_url = '';
                if (!empty($icon_image)) {
                    $attachment_image = wp_get_attachment_image_src($icon_image, 'full');
                    $icon_image_url = $attachment_image[0];
                }
                $icon_name = "icon_" . $icon_list;
                $icon_class = isset(${$icon_name}) ? ${$icon_name} : '';
                $media_class = '';
                if (has_post_thumbnail($post->ID) && wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), false)) {
                    $media_class = 'featured';
                }
                ?>
                <div class="<?php echo esc_attr($item_class . ' ' . $filter_class); ?>">
                    <div class="grid-item-inner <?php echo esc_attr($media_class); ?> wpb_animate_when_almost_visible wpb_fadeInUp fadeInUp">
                        <div class="grid-item-holder" style="<?php if(!empty($border_color)) { echo 'border-color:'.esc_attr($border_color).';'; } ?>">
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
                            <h3 class="item-title" style="<?php if(!empty($title_color)) { echo 'color:'.esc_attr($title_color).';'; } ?>">
                                <a href="<?php if(!empty($service_custom_link)) { echo esc_url($service_custom_link); } else { echo esc_url(get_permalink( $post->ID )); } ?>"><?php echo esc_attr(get_the_title($post->ID)); ?></a>
                            </h3>
                            <?php if(!empty($except_length)) { ?>
                                <div class="item-except" style="<?php if(!empty($content_color)) { echo 'color:'.esc_attr($content_color).';'; } ?>"><?php echo wp_trim_words( $service_except, $except_length, '...' ); ?></div>
                            <?php } else { ?>
                                <div class="item-except" style="<?php if(!empty($content_color)) { echo 'color:'.esc_attr($content_color).';'; } ?>"><?php echo wp_kses_post($service_except); ?></div>
                            <?php } ?>
                        </div>
                        <?php if (has_post_thumbnail($post->ID) && wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), false)) : ?>
                            <?php  $thumbnail_url = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full', false); ?>
                            <div class="grid-item-hover bg-image" style="background-image: url(<?php echo esc_url($thumbnail_url[0]); ?>);">
                                <a class="btn btn-gradient" href="<?php if(!empty($service_custom_link)) { echo esc_url($service_custom_link); } else { echo esc_url(get_permalink( $post->ID )); } ?>">
                                    <?php if(!empty($readmore_text)) {
                                        echo esc_attr($readmore_text);
                                    } else {
                                        echo esc_html__('Consult now', 'lawsight'); 
                                    }?>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php } 
        endif; ?>
    </div>

    <?php if ($layout == 'masonry' && $pagination_type == 'pagination') { ?>
        <div class="ct-grid-pagination">
            <?php lawsight_posts_pagination(); ?>
        </div>
    <?php } ?>
    <?php if (!empty($next_link) && $layout == 'masonry' && $pagination_type == 'loadmore') { ?>
        <div class="ct-load-more text-center">
            <span class="btn">
                <i class=""></i>
                <?php echo esc_html__('Load more', 'lawsight') ?>
            </span>
        </div>
    <?php } ?>

</div>