<?php 
extract(shortcode_atts(array(
    'portfolio_client' => '',
    'portfolio_date' => '',
    'portfolio_website' => '',
), $atts));
?>

<ul class="ct-portfolio-details">
    <li>
        <label><i class="fa fa-tag"></i><?php echo esc_html__('Category:', 'lawsight'); ?></label>
        <?php the_terms( get_the_ID(), 'portfolio-category', '', ', ' ); ?>
    </li>

    <?php if(!empty($portfolio_date)) { ?>
        <li>
            <i class="fa fa-calendar"></i>
            <label><?php echo esc_html__('Date:', 'lawsight'); ?></label>
            <span><?php echo esc_attr($portfolio_date); ?></span>
        </li>
    <?php } else { ?>
        <li>
            <i class="fa fa-calendar"></i>
            <label><?php echo esc_html__('Date:', 'lawsight'); ?></label>
            <span><?php $date_formart = get_option('date_format'); echo get_the_date($date_formart, get_the_ID()); ?></span>
        </li>
    <?php } ?>

    <?php if(!empty($portfolio_client)) : ?>
        <li>
            <i class="fa fa-user"></i>
            <label><?php echo esc_html__('Client:', 'lawsight'); ?></label>
            <span><?php echo esc_attr($portfolio_client); ?></span>
        </li>
    <?php endif; ?>
    <?php if(!empty($portfolio_website)) : ?>
        <li>
            <i class="fa fa-external-link"></i>
            <label><?php echo esc_html__('Website:', 'lawsight'); ?></label>
            <span><?php echo esc_attr($portfolio_website); ?></span>
        </li>
    <?php endif; ?>
</ul>      