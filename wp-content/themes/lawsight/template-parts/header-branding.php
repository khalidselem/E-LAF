<?php
/**
 * Template part for displaying site branding
 */

$logo_dark = lawsight_get_opt( 'logo', array( 'url' => get_template_directory_uri().'/assets/images/logo-dark.png', 'id' => '' ) );
$logo_light = lawsight_get_opt( 'logo_light', array( 'url' => get_template_directory_uri().'/assets/images/logo-light.png', 'id' => '' ) );

$custom_header = lawsight_get_page_opt( 'custom_header', false );
$logo_light_page = lawsight_get_page_opt( 'logo_light' );
if($custom_header && !empty($logo_light_page['url'])) {
    $logo_light['url'] = $logo_light_page['url'];
}
$logo_dark_page = lawsight_get_page_opt( 'logo_dark' );
if($custom_header && !empty($logo_dark_page['url'])) {
    $logo_dark['url'] = $logo_dark_page['url'];
}

if (class_exists('ReduxFramework')) {
    if ($logo_dark['url']) {
        printf(
            '<a class="logo-dark" href="%1$s" title="%2$s" rel="home"><img src="%3$s" alt="%2$s"/></a>',
            esc_url( home_url( '/' ) ),
            esc_attr( get_bloginfo( 'name' ) ),
            esc_url( $logo_dark['url'] )
        );
    }
    if ($logo_light['url']) {
        printf(
            '<a class="logo-light" href="%1$s" title="%2$s" rel="home"><img src="%3$s" alt="%2$s"/></a>',
            esc_url( home_url( '/' ) ),
            esc_attr( get_bloginfo( 'name' ) ),
            esc_url( $logo_light['url'] )
        );
    }
} else {
    printf(
        '<a class="logo-main" href="%1$s" title="%2$s" rel="home"><img src="%3$s" alt="'.esc_attr__('Logo Light', 'lawsight').'"/></a>',
        esc_url( home_url( '/' ) ),
        esc_attr( get_bloginfo( 'name' ) ),
        esc_url( get_template_directory_uri().'/assets/images/logo-light.png' )
    );
}