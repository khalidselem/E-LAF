<?php
$atts_extra = shortcode_atts(array(
    'source'               => '',
    'orderby'              => 'date',
    'order'                => 'DESC',
    'limit'                => '6',
    'post_ids'             => '',
    'img_size'             => '600x398',
    'el_class'             => '',
    'readmore_text'             => '',
    'btn_style'             => 'btn-gray',
), $atts);
$atts = array_merge($atts_extra, $atts);
extract($atts);
extract(cms_get_posts_of_grid('post', $atts));
extract(lawsight_get_param_carousel($atts));
wp_enqueue_script( 'owl-carousel' );
wp_enqueue_script( 'lawsight-carousel' );
wp_enqueue_script( 'waypoints' );
wp_enqueue_script( 'vc_waypoints' );
wp_enqueue_style( 'vc_animate-css' );
?>

<div id="<?php echo esc_attr($html_id) ?>" class="ct-grid ct-carousel-blog-layout1 owl-carousel <?php echo esc_attr($el_class); ?>" <?php echo !empty($carousel_data) ?  esc_attr($carousel_data) : '' ?>>

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
                    <?php if (has_post_thumbnail($post->ID) && wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), false)) { ?>
                        <div class="entry-featured">
                            <a  href="<?php echo esc_url(get_permalink( $post->ID )); ?>">
                                <?php echo wp_kses_post($thumbnail); ?>
                            </a>
                            <div class="item-overlay"></div>
                            <a class="item-more" href="<?php echo esc_url(get_permalink( $post->ID )); ?>"><i class="ct-icon-plus"></i></a>
                        </div>
                    <?php } ?>
                    <div class="item-body">
                        <ul class="item-meta">
                            <li class="item-date"><i class="fa fa-calendar"></i><?php $date_formart = get_option('date_format'); echo get_the_date($date_formart, $post->ID); ?></li>
                            <li class="item-author"><i class="fa fa-user"></i><?php the_author_posts_link(); ?></li>
                        </ul>
                        <h3 class="item-title" style="<?php if(!empty($item_title_color)) { echo 'color:'.esc_attr($item_title_color).';'; } ?>">
                            <a href="<?php echo esc_url(get_permalink( $post->ID )); ?>"><?php echo esc_attr(get_the_title($post->ID)); ?></a>
                        </h3>
                        <div class="item-more">
                            <a class="btn size-default <?php echo esc_attr($btn_style); ?>" href="<?php echo esc_url(get_permalink( $post->ID )); ?>">
                                <?php
                                    if(!empty($readmore_text)) {
                                        echo esc_attr($readmore_text);
                                    } else {
                                        echo esc_html__('View more', 'lawsight');
                                    }
                                ?>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php }
    endif; ?>
    
</div>