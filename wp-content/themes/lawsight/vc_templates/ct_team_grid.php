<?php
$atts_extra = shortcode_atts(array(
    'content_list'                  => '',
    'title_color'             => '',
    'position_color'             => '',
    'col_xl'               => 4,
    'col_lg'               => 4,
    'col_md'               => 3,
    'col_sm'               => 2,
    'col_xs'               => 1,
    'el_class'             => '',
    'img_size'             => 'full',
), $atts);
$atts = array_merge($atts_extra, $atts);
extract($atts);

$col_xl = 12 / $col_xl;
$col_lg = 12 / $col_lg;
$col_md = 12 / $col_md;
$col_sm = 12 / $col_sm;
$col_xs = 12 / $col_xs;
$grid_sizer = "col-xl-{$col_xl} col-lg-{$col_lg} col-md-{$col_md} col-sm-{$col_sm} col-{$col_xs}";
wp_enqueue_script('isotope');
wp_enqueue_script('imagesloaded');
wp_enqueue_script('lawsight-isotope', get_template_directory_uri() . '/assets/js/isotope.ct.js', array('jquery'), '1.0.0', true);
$team_content_list = (array) vc_param_group_parse_atts( $content_list );
wp_enqueue_script( 'waypoints' );
wp_enqueue_script( 'vc_waypoints' );
wp_enqueue_style( 'vc_animate-css' );
?>

<div id="<?php echo esc_attr($html_id) ?>" class="ct-grid ct-grid-team1 <?php echo esc_attr($el_class); ?>">

    <div class="ct-grid-inner ct-grid-masonry row" data-gutter="15">
        <div class="grid-sizer <?php echo esc_attr($grid_sizer); ?>"></div>
        <?php foreach ($team_content_list as $key => $value) {
            $title = isset($value['title']) ? $value['title'] : '';
            $position = isset($value['position']) ? $value['position'] : '';
            $content_label = isset($value['content_label']) ? $value['content_label'] : '';
            $item_link = isset($value['item_link']) ? $value['item_link'] : '';
            $link = vc_build_link($item_link);
            $a_href = '';
            $a_target = '';
            if ( strlen( $link['url'] ) > 0 ) {
                $a_href = $link['url'];
                $a_target = strlen( $link['target'] ) > 0 ? $link['target'] : '_self';
            }
            $social = isset($value['social']) ? $value['social'] : '';
            $el_social = (array) vc_param_group_parse_atts( $social );
            $image = isset($value['image']) ? $value['image'] : '';
            $img = wpb_getImageBySize( array(
                'attach_id'  => $image,
                'thumb_size' => $img_size,
                'class'      => '',
            ));
            $thumbnail = $img['thumbnail'];
            $item_class = "grid-item col-xl-{$col_xl} col-lg-{$col_lg} col-md-{$col_md} col-sm-{$col_sm} col-{$col_xs}";
            ?>
            <div class="<?php echo esc_attr($item_class); ?>">
                <div class="grid-item-inner ct-team-item-inner <?php if(!empty($image)) { echo 'image-show'; } ?>">
                    <?php if(!empty($image)) { ?>
                        <div class="team-featured">
                            <a href="<?php echo esc_url($a_href);?>" target="<?php  echo esc_attr($a_target); ?>"><?php echo wp_kses_post($thumbnail); ?></a>
                        </div>
                    <?php } ?>
                    <div class="team-holder">
                        <div class="ct-team-holder-inner">
                            <h3 class="team-title">
                                <a href="<?php echo esc_url($a_href);?>" target="<?php  echo esc_attr($a_target); ?>"><?php echo esc_attr($title); ?></a>
                            </h3>
                            <span class="team-position">
                                <?php echo esc_attr($position); ?>
                            </span>
                            <div class="team-info">
                                <div class="team-info-inner">
                                    <div class="team-heading">
                                        <?php if(!empty($content_label)) { echo esc_attr($content_label); } else { echo esc_html__('Contact info', 'lawsight'); } ?>
                                    </div>
                                    <div class="team-social">
                                        <?php foreach ($el_social as $key => $value) {
                                            $social_link = isset($value['social_link']) ? $value['social_link'] : '';
                                            $icon_class = isset($value['icon']) ? $value['icon'] : ''; ?>
                                            <a href="<?php echo esc_url($social_link); ?>" target="_blank"><i class="<?php echo esc_attr( $icon_class ); ?>"></i></a>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>

</div>