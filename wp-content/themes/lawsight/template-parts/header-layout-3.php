<?php
/**
 * Template part for displaying default header layout
 */
$sticky_on = lawsight_get_opt( 'sticky_on', false );
$search_on = lawsight_get_opt( 'search_on', false );
$topbar_time = lawsight_get_opt( 'topbar_time' );
$topbar_address = lawsight_get_opt( 'topbar_address' );
$hidden_sidebar_on = lawsight_get_opt( 'hidden_sidebar_on', false );
?>
<header id="masthead">
    <div id="header-wrap" class="header-layout3 <?php if($sticky_on == 1) { echo 'is-sticky'; } else { echo 'no-sticky'; } ?>">
        <?php if(!empty($topbar_time) || !empty($topbar_address)) : ?>
            <div id="header-top-bar" class="header-top-bar style2">
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
                    <div class="header-left">
                        <div class="header-branding">
                            <?php get_template_part( 'template-parts/header-branding' ); ?>
                        </div>
                        <div class="header-navigation">
                            <nav class="main-navigation">
                                <div class="main-navigation-inner">
                                    <div class="menu-mobile-close"><i class="zmdi zmdi-close"></i></div>
                                    <?php lawsight_header_mobile_search(); ?>
                                    <?php get_template_part( 'template-parts/header-menu' ); ?>
                                </div>
                            </nav>
                        </div>
                        <div class="header-icon">
                            <?php if($search_on) : ?>
                                <span class="header-right-item h-btn-search"><i class="flaticon-magnifying-glass"></i></span>
                            <?php endif; ?>
                            <?php if($hidden_sidebar_on) : ?>
                                <span class="header-right-item h-btn-sidebar"><i class="flaticon-menu"></i></span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="site-header-right">
                        <?php if($search_on) : ?>
                            <span class="header-right-item h-btn-search"><i class="flaticon-magnifying-glass"></i></span>
                        <?php endif; ?>
                        <?php if($hidden_sidebar_on) : ?>
                            <span class="header-right-item h-btn-sidebar"><i class="flaticon-menu"></i></span>
                        <?php endif; ?>
                    </div>
                    <div class="menu-mobile-overlay"></div>
                </div>
            </div>
            <div id="main-menu-mobile">
                <span class="btn-nav-mobile open-menu">
                    <span></span>
                </span>
                <?php if($hidden_sidebar_on) : ?>
                    <span class="h-btn-sidebar"><i class="fa fa-sign-out"></i></span>
                <?php endif; ?>
            </div>
        </div>
    </div>
</header>