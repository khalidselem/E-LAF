<?php
if (!function_exists('lawsight_font_flaticon')) :

    add_filter( 'vc_iconpicker-type-flaticon', 'lawsight_font_flaticon' );
    /**
    * awesome class.
    * 
    * @return string[]
    * @author CaseThemes
    */
    function lawsight_font_flaticon( $icons ) {
        $flaticon = array (
            array( 'flaticon-menu'                   => esc_html( 'flaticon-menu' ) ),
            array( 'flaticon-magnifying-glass'                   => esc_html( 'flaticon-magnifying-glass' ) ),
            array( 'flaticon-courthouse'                   => esc_html( 'flaticon-courthouse' ) ),
            array( 'flaticon-handcuffs'                   => esc_html( 'flaticon-handcuffs' ) ),
            array( 'flaticon-gun'                   => esc_html( 'flaticon-gun' ) ),
            array( 'flaticon-legal-paper'                   => esc_html( 'flaticon-legal-paper' ) ),
            array( 'flaticon-open-book'                   => esc_html( 'flaticon-open-book' ) ),
            array( 'flaticon-case'                   => esc_html( 'flaticon-case' ) ),
            array( 'flaticon-real-estate'                   => esc_html( 'flaticon-real-estate' ) ),
            array( 'flaticon-placeholder'                   => esc_html( 'flaticon-placeholder' ) ),
            array( 'flaticon-chat'                   => esc_html( 'flaticon-chat' ) ),
            array( 'flaticon-phone-call'                   => esc_html( 'flaticon-phone-call' ) ),
            array( 'flaticon-fingerprint'                   => esc_html( 'flaticon-fingerprint' ) ),
            array( 'flaticon-shield'                   => esc_html( 'flaticon-shield' ) ),
            array( 'flaticon-on-time-support'                   => esc_html( 'flaticon-on-time-support' ) ),
            array( 'flaticon-monthly-calendar'                   => esc_html( 'flaticon-monthly-calendar' ) ),
            array( 'flaticon-link-symbol'                   => esc_html( 'flaticon-link-symbol' ) ),
            array( 'flaticon-briefcase'                   => esc_html( 'flaticon-briefcase' ) ),
            array( 'flaticon-teamwork'                   => esc_html( 'flaticon-teamwork' ) ),
            array( 'flaticon-multiple-users-silhouette'                   => esc_html( 'flaticon-multiple-users-silhouette' ) ),

        );
        return array_merge( $icons, $flaticon );
    }
endif;