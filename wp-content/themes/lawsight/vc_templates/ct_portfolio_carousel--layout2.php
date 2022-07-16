<?php
$atts_extra = shortcode_atts(array(
    'source'               => '',
    'orderby'              => 'date',
    'order'                => 'DESC',
    'limit'                => '6',
    'post_ids'             => '',
    'el_class'             => '',
    'img_size'             => '414x450',
), $atts);
$atts = array_merge($atts_extra, $atts);
extract($atts);
extract(cms_get_posts_of_grid('portfolio', $atts));
extract(lawsight_get_param_carousel($atts));
wp_enqueue_script( 'owl-carousel' );
wp_enqueue_script( 'lawsight-carousel' );
wp_enqueue_script( 'waypoints' );
wp_enqueue_script( 'vc_waypoints' );
wp_enqueue_style( 'vc_animate-css' );
?>

<div id="<?php echo esc_attr($html_id) ?>" class="ct-carousel-portfolio-layout2 owl-carousel <?php echo esc_attr($el_class); ?>" <?php echo !empty($carousel_data) ?  esc_attr($carousel_data) : '' ?>>

    <?php
    if (is_array($posts)):
        foreach ($posts as $key => $post) {
            the_post();
            $img_id = get_post_thumbnail_id($post->ID);
            $img = wpb_getImageBySize( array(
                'attach_id'  => $img_id,
                'thumb_size' => $img_size,
                'class'      => '',
            ));
            $thumbnail = $img['thumbnail']; 
            ?>
            <div class="ct-carousel-item">
                <div class="grid-item-inner">
                    <?php if (has_post_thumbnail($post->ID) && wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), false)) : ?>
                        <?php  $thumbnail_url = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full', false); ?>
                        <div class="item-featured">
                            <?php echo wp_kses_post($thumbnail); ?>
                            <div class="item-overlay">
                                <a href="<?php echo esc_url(get_permalink( $post->ID )); ?>"><i class="ct-icon-plus"></i></a>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="item-holder">
                        <div class="item-category"><?php the_terms( $post->ID, 'portfolio-category', '', ', ' ); ?></div>
                        <div class="item-gap"></div>
                        <h3 class="item-title"><a href="<?php echo esc_url(get_permalink( $post->ID )); ?>"><?php echo esc_attr(get_the_title($post->ID)); ?></a></h3>
                    </div>
                </div>
            </div>
        <?php }
    endif; ?>
    
</div>