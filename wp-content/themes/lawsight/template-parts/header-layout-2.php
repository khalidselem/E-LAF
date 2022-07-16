<?php
/**
 * Template part for displaying default header layout
 */
$sticky_on = lawsight_get_opt( 'sticky_on', false );
$search_on = lawsight_get_opt( 'search_on', false );
$topbar_time = lawsight_get_opt( 'topbar_time' );
$topbar_address = lawsight_get_opt( 'topbar_address' );
$topbar_phone = lawsight_get_opt( 'topbar_phone' );
$phone_result = preg_replace('#[+ () ]*#', '', $topbar_phone);
$topbar_phone2 = lawsight_get_opt( 'topbar_phone2' );
$phone_result2 = preg_replace('#[+ () ]*#', '', $topbar_phone2);
?>
<header id="masthead">
    <div id="header-wrap" class="header-layout2 header-trans <?php if($sticky_on == 1) { echo 'is-sticky'; } else { echo 'no-sticky'; } ?>">
        <?php if(!empty($topbar_time) || !empty($topbar_address)) : ?>
            <div id="header-top-bar" class="header-top-bar">
                <div class="container">
                    <div class="row">
                        <?php if(!empty($topbar_time)) : ?>
                            <div class="topbar-time"><i class="fa fa-clock-o"></i><?php echo esc_attr($topbar_time); ?></div>
                        <?php endif; ?>
                        <?php if(!empty($topbar_address)) : ?>
                            <div class="topbar-address"><i class="fa fa-map-marker-alt"></i><?php echo esc_attr($topbar_address); ?></div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <div id="header-main" class="header-main">
            <div class="container">
                <div class="row">
                    <div class="header-branding">
                        <?php get_template_part( 'template-parts/header-branding' ); ?>
                    </div>
                    <?php if(!empty($topbar_phone)) : ?>
                        <div class="header-phone">
                            <div class="header-phone-icon"><i class="flaticon-phone-call"></i></div>
                            <div class="header-phone-meta">
                                <a href="tel:<?php echo esc_attr($phone_result); ?>"><?php echo esc_attr($topbar_phone); ?></a>
                                <a href="tel:<?php echo esc_attr($phone_result2); ?>"><?php echo esc_attr($topbar_phone2); ?></a>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="header-navigation">
                        <nav class="main-navigation">
                            <div class="main-navigation-inner">
                                <div class="menu-mobile-close"><i class="zmdi zmdi-close"></i></div>
                                <?php if(!empty($topbar_phone)) : ?>
                                    <div class="header-phone-mobile">
                                        <a class="btn" href="tel:<?php echo esc_attr($phone_result); ?>">
                                            <i class="flaticon-phone-call"></i>
                                            <span><?php echo esc_attr($topbar_phone); ?></span>
                                        </a>
                                    </div>
                                <?php endif; ?>
                                <?php if(!empty($topbar_phone2)) : ?>
                                    <div class="header-phone-mobile">
                                        <a class="btn" href="tel:<?php echo esc_attr($phone_result2); ?>">
                                            <i class="flaticon-phone-call"></i>
                                            <span><?php echo esc_attr($topbar_phone2); ?></span>
                                        </a>
                                    </div>
                                <?php endif; ?>
                                <?php lawsight_header_mobile_search(); ?>
                                <?php get_template_part( 'template-parts/header-menu' ); ?>
                            </div>
                        </nav>
                    </div>
                    <div class="header-icon-right">
                        <?php if($search_on) : ?>
                            <span class="header-right-item h-btn-search"><i class="flaticon-magnifying-glass"></i></span>
                        <?php endif; ?>
                        <div class="header-social">
                            <?php lawsight_social_icon_header(); ?>
                        </div>
                    </div>
                    <div class="menu-mobile-overlay"></div>
                </div>
            </div>
            <div id="main-menu-mobile">
                <span class="btn-nav-mobile open-menu">
                    <span></span>
                </span>
            </div>
        </div>
    </div>
</header>