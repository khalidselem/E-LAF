<?php
$footer_copyright = lawsight_get_opt('footer_copyright');
$social_label = lawsight_get_opt('social_label');
$back_totop_on = lawsight_get_opt('back_totop_on', true);
$footer_bg_image_on = lawsight_get_page_opt('footer_bg_image_on');
if(class_exists('Newsletter')) { 
    $newsletter = lawsight_get_opt('newsletter', 'hide');
    $newsletter_page = lawsight_get_page_opt('newsletter', 'themeoption');
    if($newsletter_page != '') {
        $newsletter = $newsletter_page;
    }
    $newsletter_title = lawsight_get_opt('newsletter_title');
    if($newsletter == 'show') { ?>
        <div class="ct-newsletter-wrap">
            <div class="ct-newsletter">
                <div class="ct-newsletter-inner">
                    <?php if(!empty($newsletter_title)) : ?>
                        <h3 class="ct-newsletter-title">
                            <?php echo wp_kses_post($newsletter_title); ?>
                        </h3>
                    <?php endif; ?>
                    <?php echo do_shortcode( '[newsletter_form]' ); ?>
                </div>
            </div>
        </div>
    <?php } ?>
<?php } ?>
<footer id="colophon" class="site-footer footer-layout1">
    <?php if ( is_active_sidebar( 'sidebar-footer-1' ) || is_active_sidebar( 'sidebar-footer-2' ) || is_active_sidebar( 'sidebar-footer-3' ) || is_active_sidebar( 'sidebar-footer-4' ) ) : ?>
        <div class="top-footer <?php echo esc_attr($footer_bg_image_on); ?>">
            <div class="container">
                <div class="row">
                    <?php lawsight_footer_top(); ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <div class="bottom-footer">
        <div class="container">
            <div class="row">
                <div class="bottom-copyright">
                    <?php if ($footer_copyright) {
                        echo apply_filters('the_content', $footer_copyright);
                    } else {
                        echo wp_kses_post(''.esc_attr(date("Y")).' &copy; All rights reserved by <a target="_blank" href="https://themeforest.net/user/case-themes/portfolio">CaseThemes</a>');
                    } ?>
                </div>
                <div class="bottom-social">
                    <?php if(!empty($social_label)) : ?>
                        <label><?php echo esc_attr($social_label); ?></label>
                    <?php endif; ?>
                    <?php lawsight_social_icon(); ?>
                </div>
            </div>
        </div>
    </div>
</footer>