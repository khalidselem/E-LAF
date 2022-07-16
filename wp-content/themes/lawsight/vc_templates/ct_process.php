<?php
extract(shortcode_atts(array(
    'ct_process_list' => '',
    'year_color' => '',
    'title_color' => '',
    'description_color' => '',
    'animation' => '',
    'el_class' => '',
), $atts));
$ct_process = (array) vc_param_group_parse_atts($ct_process_list);
$animation_tmp = isset($animation) ? $animation : '';
$animation_classes = $this->getCSSAnimation( $animation_tmp );
$html_id = cmsHtmlID('ct-process');
if(!empty($ct_process)) : ?>
    <div id="<?php echo esc_attr($html_id);?>" class="ct-process-layout1 <?php echo esc_attr( $el_class.' '.$animation_classes ); ?>">
        <?php foreach ($ct_process as $key => $value) {
            $title = isset($value['title']) ? $value['title'] : '';
            $description = isset($value['description']) ? $value['description'] : '';
            $year = isset($value['year']) ? $value['year'] : '';
            ?>
            <div class="ct-process-item process-<?php echo esc_attr( $key + 1 ); ?>">
                <?php if($year):?>
                    <div class="ct-process-year sub-title" style="<?php if(!empty($year_color)) { echo 'color:'.esc_attr($year_color).';'; } ?>">
                        <?php echo esc_attr($year); ?>
                    </div>
                <?php endif;?>
                <?php if($title):?>
                    <h3 class="ct-process-title" style="<?php if(!empty($title_color)) { echo 'color:'.esc_attr($title_color).';'; } ?>">
                        <?php echo apply_filters('the_title',$title);?>
                    </h3>
                <?php endif;?>
                <?php if(!empty($description)) : ?>
                    <div class="ct-process-desc" style="<?php if(!empty($description_color)) { echo 'color:'.esc_attr($description_color).';'; } ?>">
                        <?php echo wp_kses_post( $description ); ?>
                    </div>
                <?php endif;?>
            </div>
        <?php } ?>
    </div>
<?php endif; ?>