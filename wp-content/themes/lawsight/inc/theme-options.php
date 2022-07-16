<?php
if (!class_exists('ReduxFramework')) {
    return;
}
if (class_exists('ReduxFrameworkPlugin')) {
    remove_action('admin_notices', array(ReduxFrameworkPlugin::instance(), 'admin_notices'));
}

if(class_exists('Newsletter')) {
    $forms = array_filter( (array) get_option( 'newsletter_forms', array() ) );

    $newsletter_forms = array(
        'default' => esc_html__( 'Default Form', 'lawsight' )
    );

    if ( $forms )
    {
        $index = 1;
        foreach ( $forms as $key => $form )
        {
            $newsletter_forms[ $key ] = sprintf( esc_html__( 'Form %s', 'lawsight' ), $index );
            $index ++;
        }
    }
} else {
    $newsletter_forms = '';
}

$opt_name = lawsight_get_opt_name();
$theme = wp_get_theme();

$args = array(
    // TYPICAL -> Change these values as you need/desire
    'opt_name'             => $opt_name,
    // This is where your data is stored in the database and also becomes your global variable name.
    'display_name'         => $theme->get('Name'),
    // Name that appears at the top of your panel
    'display_version'      => $theme->get('Version'),
    // Version that appears at the top of your panel
    'menu_type'            => class_exists('CaseThemeCore') ? 'submenu' : '',
    //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
    'allow_sub_menu'       => true,
    // Show the sections below the admin menu item or not
    'menu_title'           => esc_html__('Theme Options', 'lawsight'),
    'page_title'           => esc_html__('Theme Options', 'lawsight'),
    // You will need to generate a Google API key to use this feature.
    // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
    'google_api_key'       => '',
    // Set it you want google fonts to update weekly. A google_api_key value is required.
    'google_update_weekly' => false,
    // Must be defined to add google fonts to the typography module
    'async_typography'     => false,
    // Use a asynchronous font on the front end or font string
    //'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
    'admin_bar'            => true,
    // Show the panel pages on the admin bar
    'admin_bar_icon'       => 'dashicons-admin-generic',
    // Choose an icon for the admin bar menu
    'admin_bar_priority'   => 50,
    // Choose an priority for the admin bar menu
    'global_variable'      => '',
    // Set a different name for your global variable other than the opt_name
    'dev_mode'             => true,
    // Show the time the page took to load, etc
    'update_notice'        => true,
    // If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
    'customizer'           => true,
    // Enable basic customizer support
    //'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
    //'disable_save_warn' => true,                    // Disable the save warning when a user changes a field
    'show_options_object' => false,
    // OPTIONAL -> Give you extra features
    'page_priority'        => null,
    // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
    'page_parent'          => class_exists('CaseThemeCore') ? $theme->get('TextDomain') : '',
    // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
    'page_permissions'     => 'manage_options',
    // Permissions needed to access the options panel.
    'menu_icon'            => '',
    // Specify a custom URL to an icon
    'last_tab'             => '',
    // Force your panel to always open to a specific tab (by id)
    'page_icon'            => 'icon-themes',
    // Icon displayed in the admin panel next to your menu_title
    'page_slug'            => 'theme-options',
    // Page slug used to denote the panel, will be based off page title then menu title then opt_name if not provided
    'save_defaults'        => true,
    // On load save the defaults to DB before user clicks save or not
    'default_show'         => false,
    // If true, shows the default value next to each field that is not the default value.
    'default_mark'         => '',
    // What to print by the field's title if the value shown is default. Suggested: *
    'show_import_export'   => true,
    // Shows the Import/Export panel when not used as a field.

    // CAREFUL -> These options are for advanced use only
    'transient_time'       => 60 * MINUTE_IN_SECONDS,
    'output'               => true,
    // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
    'output_tag'           => true,
    // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
    // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.

    // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
    'database'             => '',
    // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
    'use_cdn'              => true,
    // If you prefer not to use the CDN for Select2, Ace Editor, and others, you may download the Redux Vendor Support plugin yourself and run locally or embed it in your code.

    // HINTS
    'hints'                => array(
        'icon'          => 'el el-question-sign',
        'icon_position' => 'right',
        'icon_color'    => 'lightgray',
        'icon_size'     => 'normal',
        'tip_style'     => array(
            'color'   => 'red',
            'shadow'  => true,
            'rounded' => false,
            'style'   => '',
        ),
        'tip_position'  => array(
            'my' => 'top left',
            'at' => 'bottom right',
        ),
        'tip_effect'    => array(
            'show' => array(
                'effect'   => 'slide',
                'duration' => '500',
                'event'    => 'mouseover',
            ),
            'hide' => array(
                'effect'   => 'slide',
                'duration' => '500',
                'event'    => 'click mouseleave',
            ),
        ),
    ),
    'templates_path'       => class_exists('CaseThemeCore') ? casethemescore()->path('APP_DIR') . '/templates/redux/' : '',
);

Redux::SetArgs($opt_name, $args);

/*--------------------------------------------------------------
# General
--------------------------------------------------------------*/

Redux::setSection($opt_name, array(
    'title'  => esc_html__('General', 'lawsight'),
    'icon'   => 'el-icon-home',
    'fields' => array(
        array(
            'id'       => 'show_page_loading',
            'type'     => 'switch',
            'title'    => esc_html__('Enable Page Loading', 'lawsight'),
            'subtitle' => esc_html__('Enable page loading effect when you load site.', 'lawsight'),
            'default'  => false
        ),
        array(
            'id'       => 'loading_type',
            'type'     => 'select',
            'title'    => esc_html__('Loading Style', 'lawsight'),
            'options'  => array(
                'style1'  => esc_html__('Style 1', 'lawsight'),
                'style2'  => esc_html__('Style 2', 'lawsight'),
                'style3'  => esc_html__('Style 3', 'lawsight'),
                'style4'  => esc_html__('Style 4', 'lawsight'),
                'style5'  => esc_html__('Style 5', 'lawsight'),
                'style6'  => esc_html__('Style 6', 'lawsight'),
                'style7'  => esc_html__('Style 7', 'lawsight'),
                'style8'  => esc_html__('Style 8', 'lawsight'),
                'style9'  => esc_html__('Style 9', 'lawsight'),
                'style10'  => esc_html__('Style 10', 'lawsight'),
            ),
            'default'  => 'style1',
            'required' => array( 0 => 'show_page_loading', 1 => 'equals', 2 => '1' ),
            'force_output' => true
        ),
        array(
            'id'       => 'smoothscroll',
            'type'     => 'switch',
            'title'    => esc_html__('Smooth Scroll', 'lawsight'),
            'default'  => false
        ),
        array(
            'id'       => 'body_background',
            'type'     => 'background',
            'title'    => esc_html__('Body Boxed Background', 'lawsight'),
            'required' => array( 0 => 'layout_boxed', 1 => 'equals', 2 => '1' ),
            'force_output' => true
        ),
        array(
            'id'       => 'dev_mode',
            'type'     => 'switch',
            'title'    => esc_html__('Dev Mode (not recommended)', 'lawsight'),
            'description' => 'no minimize , generate css over time...',
            'default'  => false
        ),
        array(
            'id'       => 'favicon',
            'type'     => 'media',
            'title'    => esc_html__('Favicon', 'lawsight'),
            'default' => ''
        ),
    )
));

/*--------------------------------------------------------------
# Header
--------------------------------------------------------------*/

Redux::setSection($opt_name, array(
    'title'  => esc_html__('Header', 'lawsight'),
    'icon'   => 'el-icon-website',
    'fields' => array(
        array(
            'id'       => 'header_layout',
            'type'     => 'image_select',
            'title'    => esc_html__('Layout', 'lawsight'),
            'subtitle' => esc_html__('Select a layout for header.', 'lawsight'),
            'options'  => array(
                '1' => get_template_directory_uri() . '/assets/images/header-layout/h1.jpg',
                '2' => get_template_directory_uri() . '/assets/images/header-layout/h2.jpg',
                '3' => get_template_directory_uri() . '/assets/images/header-layout/h3.jpg',
            ),
            'default'  => '1'
        ),
        array(
            'id'       => 'get_revslide',
            'type'     => 'select',
            'title'    => esc_html__('Select Slider Revolution', 'lawsight'),
            'options'  => lawsight_build_shortcode_rev_slider(),
            'default'  => '',
            'required'     => array( 0 => 'header_layout', 1 => 'equals', 2 => '4' ),
            'force_output' => true
        ),
        array(
            'id'       => 'search_on',
            'type'     => 'switch',
            'title'    => esc_html__('Icon Search', 'lawsight'),
            'default'  => false
        ),
        array(
            'id'       => 'hidden_sidebar_on',
            'type'     => 'switch',
            'title'    => esc_html__('Icon Hidden Sidebar', 'lawsight'),
            'default'  => false
        ),
        array(
            'id'       => 'sticky_on',
            'type'     => 'switch',
            'title'    => esc_html__('Sticky Header', 'lawsight'),
            'subtitle' => esc_html__('Header will be sticked when applicable.', 'lawsight'),
            'default'  => false
        ),
    )
));

Redux::setSection($opt_name, array(
    'title'      => esc_html__('Top Bar', 'lawsight'),
    'icon'       => 'el el-resize-vertical',
    'subsection' => true,
    'fields'     => array(
        array(
            'id'       => 'topbar_phone',
            'type'     => 'text',
            'title'    => esc_html__('Phone 1', 'lawsight'),
            'desc'     => 'Enter phone 1.',
            'default'  => '',
        ),
        array(
            'id'       => 'topbar_phone2',
            'type'     => 'text',
            'title'    => esc_html__('Phone 2', 'lawsight'),
            'desc'     => 'Enter phone 2.',
            'default'  => '',
        ),
        array(
            'id'          => 'phone_color',
            'type'        => 'color',
            'title'       => esc_html__('Phone - Color', 'lawsight'),
            'transparent' => false,
            'default'     => '',
            'output'   => array(''),
        ),
        array(
            'id'          => 'sticky_phone_color',
            'type'        => 'color',
            'title'       => esc_html__('Phone - Sticky Color', 'lawsight'),
            'transparent' => false,
            'default'     => '',
            'output'   => array(''),
        ),
        array(
            'id'       => 'topbar_time',
            'type'     => 'text',
            'title'    => esc_html__('Time', 'lawsight'),
            'desc'     => 'Enter time.',
            'default'  => '',
            'desc'     => 'Apply header layout 2,3.',
        ),
        array(
            'id'          => 'time_color',
            'type'        => 'color',
            'title'       => esc_html__('Time - Color', 'lawsight'),
            'transparent' => false,
            'default'     => '',
            'output'   => array('#header-wrap .header-top-bar .topbar-time'),
        ),
        array(
            'id'       => 'topbar_address',
            'type'     => 'text',
            'title'    => esc_html__('Address', 'lawsight'),
            'desc'     => 'Enter address.',
            'default'  => '',
            'desc'     => 'Apply header layout 2,3.',
        ),
        array(
            'id'          => 'address_color',
            'type'        => 'color',
            'title'       => esc_html__('Address - Color', 'lawsight'),
            'transparent' => false,
            'default'     => '',
            'output'   => array('#header-wrap .header-top-bar .topbar-address'),
        ),
        array(
            'id'       => 'topbar_background',
            'type'     => 'background',
            'title'    => esc_html__('Top Bar Background Color', 'lawsight'),
            'output'   => array('#header-wrap .header-top-bar, #header-wrap .header-top-bar.style2'),
            'background-repeat' => false,
            'background-image' => false,
            'background-position' => false,
            'background-size' => false,
            'background-attachment' => false,
            'transparent' => false,
        ),
    )
));

Redux::setSection($opt_name, array(
    'title'      => esc_html__('Logo', 'lawsight'),
    'icon'       => 'el el-picture',
    'subsection' => true,
    'fields'     => array(
        array(
            'id'       => 'logo',
            'type'     => 'media',
            'title'    => esc_html__('Logo Dark', 'lawsight'),
            'default' => array(
                'url'=>get_template_directory_uri().'/assets/images/logo-dark.png'
            )
        ),
        array(
            'id'       => 'logo_light',
            'type'     => 'media',
            'title'    => esc_html__('Logo Light', 'lawsight'),
            'default' => array(
                'url'=>get_template_directory_uri().'/assets/images/logo-light.png'
            )
        ),
        array(
            'id'       => 'logo_maxh',
            'type'     => 'dimensions',
            'title'    => esc_html__('Logo Max Height on Desktop (Screen > 992px)', 'lawsight'),
            'subtitle' => esc_html__('Enter number.', 'lawsight'),
            'width'    => false,
            'unit'     => 'px'
        ),

        array(
            'id'       => 'logo_maxh_mobile',
            'type'     => 'dimensions',
            'title'    => esc_html__('Logo Max Height on Mobile (Screen < 991px)', 'lawsight'),
            'subtitle' => esc_html__('Enter number.', 'lawsight'),
            'width'    => false,
            'unit'     => 'px'
        ),
    )
));

Redux::setSection($opt_name, array(
    'title'      => esc_html__('Navigation', 'lawsight'),
    'icon'       => 'el el-lines',
    'subsection' => true,
    'fields'     => array(
        array(
            'id'          => 'font_menu',
            'type'        => 'typography',
            'title'       => esc_html__('Custom Google Font', 'lawsight'),
            'google'      => true,
            'font-backup' => true,
            'all_styles'  => true,
            'font-style'  => false,
            'font-weight'  => true,
            'text-align'  => false,
            'font-size'  => false,
            'line-height'  => false,
            'color'  => false,
            'output'      => array('.primary-menu li a'),
            'units'       => 'px',
        ),
        array(
            'id'       => 'menu_font_size',
            'type'     => 'text',
            'title'    => esc_html__('Font Size', 'lawsight'),
            'validate' => 'numeric',
            'desc'     => 'Enter number',
            'msg'      => 'Please enter number',
            'default'  => ''
        ),
        array(
            'id'       => 'menu_text_transform',
            'type'     => 'select',
            'title'    => esc_html__('Text Transform', 'lawsight'),
            'options'  => array(
                ''  => esc_html__('Capitalize', 'lawsight'),
                'uppercase' => esc_html__('Uppercase', 'lawsight'),
                'lowercase'  => esc_html__('Lowercase', 'lawsight'),
                'initial'  => esc_html__('Initial', 'lawsight'),
                'inherit'  => esc_html__('Inherit', 'lawsight'),
                'none'  => esc_html__('None', 'lawsight'),
            ),
            'default'  => ''
        ),
        array(
            'id'      => 'main_menu_color',
            'type'    => 'link_color',
            'title'   => esc_html__('Menu Item Color', 'lawsight'),
            'default' => array(
                'regular' => '',
                'hover'   => '',
                'active'   => '',
            ),
        ),
        array(
            'id'      => 'main_menu_bgcolor',
            'type'    => 'link_color',
            'regular'    => false,
            'title'   => esc_html__('Menu Item Background Color', 'lawsight'),
            'default' => array(
                'hover'   => '',
                'active'   => '',
            ),
            'required' => array( 0 => 'header_layout', 1 => 'equals', 2 => '8' ),
            'force_output' => true
        ),
    )
));

Redux::setSection($opt_name, array(
    'title'      => esc_html__('Header Sticky', 'lawsight'),
    'icon'       => 'el el-circle-arrow-down',
    'subsection' => true,
    'fields'     => array(
        array(
            'id'          => 'header_bgcolor_sticky',
            'type'        => 'color',
            'title'       => esc_html__('Background Color', 'lawsight'),
            'transparent' => false,
            'default'     => ''
        ),
        array(
            'id'      => 'main_menu_color_sticky',
            'type'    => 'link_color',
            'title'   => esc_html__('Menu Item Color', 'lawsight'),
            'default' => array(
                'regular' => '',
                'hover'   => '',
                'active'   => '',
            ),
        ),
    )
));

Redux::setSection($opt_name, array(
    'title'      => esc_html__('Header Mobile', 'lawsight'),
    'icon'       => 'el el-iphone-home',
    'subsection' => true,
    'fields'     => array(
        array(
            'id'          => 'mobile_header_bgcolor',
            'type'        => 'color',
            'title'       => esc_html__('Mobile Background Color', 'lawsight'),
            'transparent' => false,
            'default'     => ''
        ),
        array(
            'id'          => 'mobile_icon_menu_color',
            'type'        => 'color',
            'title'       => esc_html__('Mobile Icon Menu Color', 'lawsight'),
            'transparent' => false,
            'default'     => ''
        ),
        array(
            'id'       => 'search_mobile_on',
            'type'     => 'button_set',
            'title'    => esc_html__('Search', 'lawsight'),
            'options'  => array(
                'show'  => esc_html__('Show', 'lawsight'),
                'hidden'  => esc_html__('Hidden', 'lawsight'),
            ),
            'default'  => 'show'
        ),
    )
));

/*--------------------------------------------------------------
# Social Link
--------------------------------------------------------------*/

Redux::setSection($opt_name, array(
    'title'  => esc_html__('Social Link', 'lawsight'),
    'icon'   => 'el el-share',
    'subsection' => true,
    'fields' => array(

        array(
            'id'      => 'h_social_facebook_url',
            'type'    => 'text',
            'title'   => esc_html__('Facebook URL', 'lawsight'),
            'default' => '',
        ),
        array(
            'id'      => 'h_social_twitter_url',
            'type'    => 'text',
            'title'   => esc_html__('Twitter URL', 'lawsight'),
            'default' => '',
        ),
        array(
            'id'      => 'h_social_inkedin_url',
            'type'    => 'text',
            'title'   => esc_html__('Inkedin URL', 'lawsight'),
            'default' => '',
        ),
        array(
            'id'      => 'h_social_instagram_url',
            'type'    => 'text',
            'title'   => esc_html__('Instagram URL', 'lawsight'),
            'default' => '',
        ),
        array(
            'id'      => 'h_social_google_url',
            'type'    => 'text',
            'title'   => esc_html__('Google URL', 'lawsight'),
            'default' => '',
        ),
        array(
            'id'      => 'h_social_skype_url',
            'type'    => 'text',
            'title'   => esc_html__('Skype URL', 'lawsight'),
            'default' => '',
        ),
        array(
            'id'      => 'h_social_pinterest_url',
            'type'    => 'text',
            'title'   => esc_html__('Pinterest URL', 'lawsight'),
            'default' => '',
        ),
        array(
            'id'      => 'h_social_vimeo_url',
            'type'    => 'text',
            'title'   => esc_html__('Vimeo URL', 'lawsight'),
            'default' => '',
        ),
        array(
            'id'      => 'h_social_youtube_url',
            'type'    => 'text',
            'title'   => esc_html__('Youtube URL', 'lawsight'),
            'default' => '',
        ),
        array(
            'id'      => 'h_social_yelp_url',
            'type'    => 'text',
            'title'   => esc_html__('Yelp URL', 'lawsight'),
            'default' => '',
        ),
        array(
            'id'      => 'h_social_tumblr_url',
            'type'    => 'text',
            'title'   => esc_html__('Tumblr URL', 'lawsight'),
            'default' => '',
        ),
        array(
            'id'      => 'h_social_tripadvisor_url',
            'type'    => 'text',
            'title'   => esc_html__('Tripadvisor URL', 'lawsight'),
            'default' => '',
        ),
    )
));


/*--------------------------------------------------------------
# Page Title area
--------------------------------------------------------------*/

Redux::setSection($opt_name, array(
    'title'  => esc_html__('Page Title', 'lawsight'),
    'icon'   => 'el-icon-map-marker',
    'fields' => array(
        array(
            'id'       => 'ptitle_on',
            'type'     => 'button_set',
            'title'    => esc_html__('Displayed', 'lawsight'),
            'options'  => array(
                'show'  => esc_html__('Show', 'lawsight'),
                'hidden'  => esc_html__('Hidden', 'lawsight'),
            ),
            'default'  => 'show'
        ),

        array(
            'id'       => 'ptitle_bg',
            'type'     => 'background',
            'title'    => esc_html__('Background', 'lawsight'),
            'subtitle' => esc_html__('Page title background.', 'lawsight'),
            'output'   => array('#pagetitle'),
            'required' => array( 0 => 'ptitle_on', 1 => 'equals', 2 => 'show' ),
            'force_output' => true
        ),
        array(
            'id'       => 'pagetitle_bg_color',
            'type'     => 'color_rgba',
            'title'    => esc_html__('Background Color Overlay', 'lawsight'),
            'output' => array('background-color' => '#pagetitle.bg-overlay:before'),
            'required' => array( 0 => 'ptitle_on', 1 => 'equals', 2 => 'show' ),
            'force_output' => true
        ),
        array(
            'id'       => 'ptitle_color',
            'type'     => 'color',
            'title'    => esc_html__('Title Color', 'lawsight'),
            'subtitle' => esc_html__('Page title color.', 'lawsight'),
            'output'   => array('#pagetitle h1.page-title'),
            'default'  => '',
            'transparent' => false,
            'required' => array( 0 => 'ptitle_on', 1 => 'equals', 2 => 'show' ),
            'force_output' => true
        ),
        array(
            'id'             => 'page_title_padding',
            'type'           => 'spacing',
            'output'         => array('body #pagetitle'),
            'right'   => false,
            'left'    => false,
            'mode'           => 'padding',
            'units'          => array('px'),
            'units_extended' => 'false',
            'title'          => esc_html__('Page Title Padding', 'lawsight'),
            'default'            => array(
                'padding-top'   => '',
                'padding-bottom'   => '',
                'units'          => 'px',
            ),
            'required' => array( 0 => 'ptitle_on', 1 => 'equals', 2 => 'show' ),
            'force_output' => true
        ),
        array(
            'id'       => 'ptitle_breadcrumb_on',
            'type'     => 'button_set',
            'title'    => esc_html__('Breadcrumb', 'lawsight'),
            'options'  => array(
                'show'  => esc_html__('Show', 'lawsight'),
                'hidden'  => esc_html__('Hidden', 'lawsight'),
            ),
            'default'  => 'show',
        ),
        array(
            'id'      => 'breadcrumb_home_text',
            'type'    => 'text',
            'title'   => esc_html__('Breadcrumb Home Text', 'lawsight'),
            'default' => '',
            'desc'           => esc_html__('Default: Home', 'lawsight'),
            'required' => array( 0 => 'ptitle_breadcrumb_on', 1 => 'equals', 2 => 'show' ),
            'force_output' => true
        ),
    )
));

/*--------------------------------------------------------------
# WordPress default content
--------------------------------------------------------------*/

Redux::setSection($opt_name, array(
    'title' => esc_html__('Content', 'lawsight'),
    'icon'  => 'el-icon-pencil',
    'fields'     => array(
        array(
            'id'       => 'content_bg_color',
            'type'     => 'color_rgba',
            'title'    => esc_html__('Background Color', 'lawsight'),
            'subtitle' => esc_html__('Content background color.', 'lawsight'),
            'output' => array('background-color' => '#content, .site-layout-default .site-footer:before')
        ),
        array(
            'id'             => 'content_padding',
            'type'           => 'spacing',
            'output'         => array('#content'),
            'right'   => false,
            'left'    => false,
            'mode'           => 'padding',
            'units'          => array('px'),
            'units_extended' => 'false',
            'title'          => esc_html__('Content Padding', 'lawsight'),
            'desc'           => esc_html__('Default: Top-75px, Bottom-100px', 'lawsight'),
            'default'            => array(
                'padding-top'   => '',
                'padding-bottom'   => '',
                'units'          => 'px',
            )
        ),
        array(
            'id'      => 'search_field_placeholder',
            'type'    => 'text',
            'title'   => esc_html__('Search Form - Text Placeholder', 'lawsight'),
            'default' => '',
            'desc'           => esc_html__('Default: Search Keywords...', 'lawsight'),
        ),
    )
));


Redux::setSection($opt_name, array(
    'title'      => esc_html__('Archive', 'lawsight'),
    'icon'       => 'el-icon-list',
    'subsection' => true,
    'fields'     => array(
        array(
            'id'       => 'archive_sidebar_pos',
            'type'     => 'button_set',
            'title'    => esc_html__('Sidebar Position', 'lawsight'),
            'subtitle' => esc_html__('Select a sidebar position for blog home, archive, search...', 'lawsight'),
            'options'  => array(
                'left'  => esc_html__('Left', 'lawsight'),
                'right' => esc_html__('Right', 'lawsight'),
                'none'  => esc_html__('Disabled', 'lawsight')
            ),
            'default'  => 'right'
        ),
        array(
            'id'       => 'archive_author_on',
            'title'    => esc_html__('Author', 'lawsight'),
            'subtitle' => esc_html__('Show author name on each post.', 'lawsight'),
            'type'     => 'switch',
            'default'  => true,
        ),
        array(
            'id'       => 'archive_date_on',
            'title'    => esc_html__('Date', 'lawsight'),
            'subtitle' => esc_html__('Show date posted on each post.', 'lawsight'),
            'type'     => 'switch',
            'default'  => true,
        ),
        array(
            'id'       => 'archive_categories_on',
            'title'    => esc_html__('Categories', 'lawsight'),
            'subtitle' => esc_html__('Show category names on each post.', 'lawsight'),
            'type'     => 'switch',
            'default'  => true,
        ),
        array(
            'id'       => 'archive_comments_on',
            'title'    => esc_html__('Comments', 'lawsight'),
            'subtitle' => esc_html__('Show comments count on each post.', 'lawsight'),
            'type'     => 'switch',
            'default'  => true,
        ),
        array(
            'id'      => 'readmore_text',
            'type'    => 'text',
            'title'   => esc_html__('Read More Text', 'lawsight'),
            'default' => '',
        ),
    )
));

Redux::setSection($opt_name, array(
    'title'      => esc_html__('Single Post', 'lawsight'),
    'icon'       => 'el-icon-file-edit',
    'subsection' => true,
    'fields'     => array(
        array(
            'id'       => 'post_sidebar_pos',
            'type'     => 'button_set',
            'title'    => esc_html__('Sidebar Position', 'lawsight'),
            'subtitle' => esc_html__('Select a sidebar position', 'lawsight'),
            'options'  => array(
                'left'  => esc_html__('Left', 'lawsight'),
                'right' => esc_html__('Right', 'lawsight'),
                'none'  => esc_html__('Disabled', 'lawsight')
            ),
            'default'  => 'right'
        ),
        array(
            'id'       => 'post_text_align',
            'type'     => 'button_set',
            'title'    => esc_html__('Text Align', 'lawsight'),
            'options'  => array(
                'inherit'  => esc_html__('Inherit', 'lawsight'),
                'justify'  => esc_html__('Justify', 'lawsight'),
            ),
            'default'  => 'inherit'
        ),
        array(
            'id'       => 'post_author_on',
            'title'    => esc_html__('Author', 'lawsight'),
            'subtitle' => esc_html__('Show author name on single post.', 'lawsight'),
            'type'     => 'switch',
            'default'  => true
        ),
        array(
            'id'       => 'post_date_on',
            'title'    => esc_html__('Date', 'lawsight'),
            'subtitle' => esc_html__('Show date on single post.', 'lawsight'),
            'type'     => 'switch',
            'default'  => true
        ),
        array(
            'id'       => 'post_categories_on',
            'title'    => esc_html__('Categories', 'lawsight'),
            'subtitle' => esc_html__('Show category names on single post.', 'lawsight'),
            'type'     => 'switch',
            'default'  => true
        ),
        array(
            'id'       => 'post_tags_on',
            'title'    => esc_html__('Tags', 'lawsight'),
            'subtitle' => esc_html__('Show tags count on single post.', 'lawsight'),
            'type'     => 'switch',
            'default'  => true
        ),
        array(
            'id'       => 'post_comments_on',
            'title'    => esc_html__('Comments', 'lawsight'),
            'subtitle' => esc_html__('Show comments count on single post.', 'lawsight'),
            'type'     => 'switch',
            'default'  => true
        ),
        array(
            'id'       => 'post_social_share_on',
            'title'    => esc_html__('Social Share', 'lawsight'),
            'subtitle' => esc_html__('Show social share on single post.', 'lawsight'),
            'type'     => 'switch',
            'default'  => false,
        ),
        array(
            'id'       => 'post_navigation_on',
            'title'    => esc_html__('Navigation', 'lawsight'),
            'subtitle' => esc_html__('Show navigation on single post.', 'lawsight'),
            'type'     => 'switch',
            'default'  => false,
        ),
        array(
            'id'       => 'post_comments_form_on',
            'title'    => esc_html__('Comments Form', 'lawsight'),
            'subtitle' => esc_html__('Show comments form on single post.', 'lawsight'),
            'type'     => 'switch',
            'default'  => true
        ),
        array(
            'id'       => 'post_feature_image_on',
            'title'    => esc_html__('Feature Image', 'lawsight'),
            'subtitle' => esc_html__('Show feature image on single post.', 'lawsight'),
            'type'     => 'switch',
            'default'  => true
        ),
        array(
            'id'       => 'post_related_post',
            'title'    => esc_html__('Related', 'lawsight'),
            'subtitle' => esc_html__('Show related on single post.', 'lawsight'),
            'type'     => 'switch',
            'default'  => false
        ),
    )
));

Redux::setSection($opt_name, array(
    'title'      => esc_html__('Service', 'lawsight'),
    'icon'       => 'el el-wrench',
    'subsection' => true,
    'fields'     => array(
        array(
            'id'      => 'service_name',
            'type'    => 'text',
            'title'   => esc_html__('Service Name', 'lawsight'),
            'default' => '',
            'desc'     => 'Default: Services',
        ),
        array(
            'id'      => 'service_slug',
            'type'    => 'text',
            'title'   => esc_html__('Service Slug', 'lawsight'),
            'default' => '',
            'desc'     => 'Default: service',
        ),
        array(
            'id'      => 'tax_service_slug',
            'type'    => 'text',
            'title'   => esc_html__('Service Categories Slug', 'lawsight'),
            'default' => '',
            'desc'     => 'Default: service-category',
        ),
        array(
            'id'      => 'tax_service_name',
            'type'    => 'text',
            'title'   => esc_html__('Service Categories Name', 'lawsight'),
            'default' => '',
            'desc'     => 'Default: Service Category',
        ),
    )
));

Redux::setSection($opt_name, array(
    'title'      => esc_html__('Portfolio', 'lawsight'),
    'icon'       => 'el el-briefcase',
    'subsection' => true,
    'fields'     => array(
        array(
            'id'      => 'portfolio_name',
            'type'    => 'text',
            'title'   => esc_html__('Portfolio Name', 'lawsight'),
            'default' => '',
            'desc'     => 'Default: Portfolio',
        ),
        array(
            'id'      => 'portfolio_slug',
            'type'    => 'text',
            'title'   => esc_html__('Portfolio Slug', 'lawsight'),
            'default' => '',
            'desc'     => 'Default: portfolio',
        ),
        array(
            'id'      => 'tax_portfolio_slug',
            'type'    => 'text',
            'title'   => esc_html__('Portfolio Categories Slug', 'lawsight'),
            'default' => '',
            'desc'     => 'Default: portfolio-category',
        ),
        array(
            'id'      => 'tax_portfolio_name',
            'type'    => 'text',
            'title'   => esc_html__('Portfolio Categories Name', 'lawsight'),
            'default' => '',
            'desc'     => 'Default: Portfolio Category',
        ),
    )
));

/*--------------------------------------------------------------
# Footer
--------------------------------------------------------------*/

Redux::setSection($opt_name, array(
    'title'  => esc_html__('Footer', 'lawsight'),
    'icon'   => 'el el-website',
    'fields' => array(
        array(
            'id'       => 'footer_layout',
            'type'     => 'button_set',
            'title'    => esc_html__('Layout', 'lawsight'),
            'subtitle' => esc_html__('Select a layout for upper footer area.', 'lawsight'),
            'options'  => array(
                '1'  => esc_html__('Default', 'lawsight'),
                'custom'  => esc_html__('Custom', 'lawsight'),
            ),
            'default'  => '1'
        ),
        array(
            'id'          => 'footer_layout_custom',
            'type'        => 'select',
            'title'       => esc_html__('Custom Layout', 'lawsight'),
            'desc'        => sprintf(esc_html__('To use this Option please %sClick Here%s to add your custom footer layout first.','lawsight'),'<a href="' . esc_url( admin_url( 'edit.php?post_type=footer' ) ) . '">','</a>'),
            'options'     => lawsight_list_post('footer'),
            'default'     => '',
            'required' => array( 0 => 'footer_layout', 1 => 'equals', 2 => 'custom' ),
            'force_output' => true
        ),
        array(
            'id'       => 'back_totop_on',
            'type'     => 'switch',
            'title'    => esc_html__('Back to Top Button', 'lawsight'),
            'subtitle' => esc_html__('Show back to top button when scrolled down.', 'lawsight'),
            'default'  => true,
        ),
        array(
            'id'       => 'newsletter',
            'type'     => 'button_set',
            'title'    => esc_html__('Newsletter', 'lawsight'),
            'options'  => array(
                'show'  => esc_html__('Show', 'lawsight'),
                'hide'  => esc_html__('Hide', 'lawsight'),
            ),
            'default'  => 'show'
        ),
        array(
            'id'      => 'newsletter_title',
            'type'    => 'text',
            'title'   => esc_html__('Newsletter Title', 'lawsight'),
            'default' => '',
            'required' => array( 0 => 'newsletter', 1 => 'equals', 2 => 'show' ),
            'force_output' => true
        ),
        array(
            'id'       => 'newsletter_bg',
            'type'     => 'background',
            'title'    => esc_html__('Newsletter Background', 'lawsight'),
            'output'   => array('.ct-newsletter'),
            'background-color' => false,
            'required' => array( 0 => 'newsletter', 1 => 'equals', 2 => 'show' ),
            'force_output' => true
        ),
    )
));

Redux::setSection($opt_name, array(
    'title'      => esc_html__('Footer Top', 'lawsight'),
    'icon'       => 'el-icon-list',
    'subsection' => true,
    'fields'     => array(
        array(
            'id'       => 'footer_top_column',
            'type'     => 'button_set',
            'title'    => esc_html__('Footer Top Columns', 'lawsight'),
            'options'  => array(
                '1'  => esc_html__('1 Column', 'lawsight'),
                '2'  => esc_html__('2 Column', 'lawsight'),
                '3'  => esc_html__('3 Column', 'lawsight'),
                '4'  => esc_html__('4 Column', 'lawsight'),
            ),
            'default'  => '4',
            'required' => array( 0 => 'footer_layout', 1 => 'equals', 2 => '1' ),
            'force_output' => true
        ),
        array(
            'id'       => 'footer_top_bg',
            'type'     => 'background',
            'title'    => esc_html__('Footer Top Background', 'lawsight'),
            'output'   => array('.footer-layout1 .top-footer'),
            'required' => array( 0 => 'footer_layout', 1 => 'equals', 2 => '1' ),
            'force_output' => true
        ),
        array(
            'id'       => 'footer_top_padding',
            'type'     => 'spacing',
            'title'    => esc_html__('Footer Top Paddings', 'lawsight'),
            'subtitle' => esc_html__('Content paddings. Default, Top:103px - Bottom:86px ', 'lawsight'),
            'mode'     => 'padding',
            'units'    => array('em', 'px', '%'),
            'top'      => true,
            'right'    => false,
            'bottom'   => true,
            'left'     => false,
            'output'   => array('body .site-footer .top-footer'),
            'default'  => array(
                'top'    => '',
                'right'  => '',
                'bottom' => '',
                'left'   => '',
                'units'  => 'px',
            )
        ),
        array(
            'id'    => 'footer_top_color',
            'type'  => 'color',
            'title' => esc_html__('Text Color', 'lawsight'),
            'output'   => array('body .site-footer .top-footer'),
            'transparent' => false,
            'required' => array( 0 => 'footer_layout', 1 => 'equals', 2 => '1' ),
            'force_output' => true,
        ),
        array(
            'id'      => 'footer_top_link_color',
            'type'    => 'link_color',
            'title'   => esc_html__('Links Color', 'lawsight'),
            'regular' => true,
            'hover'   => true,
            'active'  => false,
            'visited' => false,
            'output'  => array('body .site-footer .top-footer a, .site-footer .top-footer ul.menu li a, .site-footer .top-footer .widget_pages ul li a, .site-footer .top-footer .widget_meta ul li a, .site-footer .top-footer .widget_categories ul li a, .site-footer .top-footer .widget_archive ul li a'),
            'transparent' => false,
            'required' => array( 0 => 'footer_layout', 1 => 'equals', 2 => '1' ),
            'force_output' => true,
        ),
    )
));

Redux::setSection($opt_name, array(
    'title'      => esc_html__('Footer Bottom', 'lawsight'),
    'icon'       => 'el-icon-list',
    'subsection' => true,
    'fields'     => array(
        array(
            'id'=>'footer_copyright',
            'type' => 'textarea',
            'title' => esc_html__('Copyright', 'lawsight'),
            'validate' => 'html_custom',
            'default' => '',
            'subtitle' => esc_html__('Custom HTML Allowed: a,br,em,strong,span,p,div,h1->h6,[ct_year]', 'lawsight'),
            'allowed_html' => array(
                'a' => array(
                    'href' => array(),
                    'title' => array(),
                    'target' => array(),
                    'class' => array(),
                ),
                'br' => array(),
                'em' => array(),
                'strong' => array(),
                'span' => array(),
                'p' => array(),
                'div' => array(
                    'class' => array()
                ),
                'h1' => array(
                    'class' => array()
                ),
                'h2' => array(
                    'class' => array()
                ),
                'h3' => array(
                    'class' => array()
                ),
                'h4' => array(
                    'class' => array()
                ),
                'h5' => array(
                    'class' => array()
                ),
                'h6' => array(
                    'class' => array()
                ),
                'ul' => array(
                    'class' => array()
                ),
                'li' => array(),
            ),
            'required' => array( 0 => 'footer_layout', 1 => 'equals', 2 => '1' ),
            'force_output' => true
        ),
        array(
            'id'       => 'footer_bottom_bg',
            'type'     => 'background',
            'title'    => esc_html__('Background Color', 'lawsight'),
            'subtitle' => esc_html__('Footer bottom background color.', 'lawsight'),
            'default'  => '',
            'output'   => array('.site-footer .bottom-footer'),
            'background-repeat' => false,
            'background-attachment' => false,
            'background-position' => false,
            'background-image' => false,
            'background-clip' => false,
            'background-origin' => false,
            'background-size' => false,
            'transparent' => false,
            'required' => array( 0 => 'footer_layout', 1 => 'equals', 2 => '1' ),
            'force_output' => true,
        ),
        array(
            'id'    => 'footer_bottom_color',
            'type'  => 'color',
            'title' => esc_html__('Text Color', 'lawsight'),
            'output'   => array('body .site-footer .bottom-footer'),
            'transparent' => false,
            'required' => array( 0 => 'footer_layout', 1 => 'equals', 2 => '1' ),
            'force_output' => true,
        ),
        array(
            'id'      => 'footer_bottom_link_color',
            'type'    => 'link_color',
            'title'   => esc_html__('Links Color', 'lawsight'),
            'regular' => true,
            'hover'   => true,
            'active'  => false,
            'visited' => false,
            'output'  => array('body .site-footer .bottom-footer a, body .site-footer .bottom-footer .bottom-copyright a, .site-footer .bottom-footer .bottom-social a'),
            'transparent' => false,
            'required' => array( 0 => 'footer_layout', 1 => 'equals', 2 => '1' ),
            'force_output' => true,
        ),
    )
));

/*--------------------------------------------------------------
# Social Link
--------------------------------------------------------------*/

Redux::setSection($opt_name, array(
    'title'  => esc_html__('Social Link', 'lawsight'),
    'icon'   => 'el el-share',
    'subsection' => true,
    'fields' => array(

        array(
            'id'      => 'social_label',
            'type'    => 'text',
            'title'   => esc_html__('Social Label', 'lawsight'),
            'default' => '',
        ),

        array(
            'id'      => 'social_facebook_url',
            'type'    => 'text',
            'title'   => esc_html__('Facebook URL', 'lawsight'),
            'default' => '#',
        ),
        array(
            'id'      => 'social_twitter_url',
            'type'    => 'text',
            'title'   => esc_html__('Twitter URL', 'lawsight'),
            'default' => '#',
        ),
        array(
            'id'      => 'social_inkedin_url',
            'type'    => 'text',
            'title'   => esc_html__('Inkedin URL', 'lawsight'),
            'default' => '#',
        ),
        array(
            'id'      => 'social_instagram_url',
            'type'    => 'text',
            'title'   => esc_html__('Instagram URL', 'lawsight'),
            'default' => '',
        ),
        array(
            'id'      => 'social_google_url',
            'type'    => 'text',
            'title'   => esc_html__('Google URL', 'lawsight'),
            'default' => '',
        ),
        array(
            'id'      => 'social_skype_url',
            'type'    => 'text',
            'title'   => esc_html__('Skype URL', 'lawsight'),
            'default' => '',
        ),
        array(
            'id'      => 'social_pinterest_url',
            'type'    => 'text',
            'title'   => esc_html__('Pinterest URL', 'lawsight'),
            'default' => '',
        ),
        array(
            'id'      => 'social_vimeo_url',
            'type'    => 'text',
            'title'   => esc_html__('Vimeo URL', 'lawsight'),
            'default' => '',
        ),
        array(
            'id'      => 'social_youtube_url',
            'type'    => 'text',
            'title'   => esc_html__('Youtube URL', 'lawsight'),
            'default' => '',
        ),
        array(
            'id'      => 'social_yelp_url',
            'type'    => 'text',
            'title'   => esc_html__('Yelp URL', 'lawsight'),
            'default' => '',
        ),
        array(
            'id'      => 'social_tumblr_url',
            'type'    => 'text',
            'title'   => esc_html__('Tumblr URL', 'lawsight'),
            'default' => '',
        ),
        array(
            'id'      => 'social_tripadvisor_url',
            'type'    => 'text',
            'title'   => esc_html__('Tripadvisor URL', 'lawsight'),
            'default' => '',
        ),
    )
));


/*--------------------------------------------------------------
# Colors
--------------------------------------------------------------*/

Redux::setSection($opt_name, array(
    'title'  => esc_html__('Colors', 'lawsight'),
    'icon'   => 'el-icon-file-edit',
    'fields' => array(
        array(
            'title' => esc_html__('Preset Color 1', 'lawsight'),
            'type'  => 'section',
            'id' => 'preset1',
            'indent' => true
        ),
        array(
            'id'          => 'primary_color',
            'type'        => 'color',
            'title'       => esc_html__('Primary Color', 'lawsight'),
            'transparent' => false,
            'default'     => '#d5aa6d'
        ),
        array(
            'id'          => 'secondary_color',
            'type'        => 'color',
            'title'       => esc_html__('Secondary Color', 'lawsight'),
            'transparent' => false,
            'default'     => '#9b6f45'
        ),
        array(
            'id'      => 'link_color',
            'type'    => 'link_color',
            'title'   => esc_html__('Link Colors', 'lawsight'),
            'default' => array(
                'regular' => '#d5aa6d',
                'hover'   => '#9b6f45',
                'active'  => '#9b6f45'
            ),
            'output'  => array('a')
        ),
    )
));

/*--------------------------------------------------------------
# Typography
--------------------------------------------------------------*/
$custom_font_selectors_1 = Redux::getOption($opt_name, 'custom_font_selectors_1');
$custom_font_selectors_1 = !empty($custom_font_selectors_1) ? explode(',', $custom_font_selectors_1) : array();
Redux::setSection($opt_name, array(
    'title'  => esc_html__('Typography', 'lawsight'),
    'icon'   => 'el-icon-text-width',
    'fields' => array(
        array(
            'id'       => 'body_default_font',
            'type'     => 'select',
            'title'    => esc_html__('Body Default Font', 'lawsight'),
            'options'  => array(
                'Muli'  => esc_html__('Default', 'lawsight'),
                'Google-Font'  => esc_html__('Google Font', 'lawsight'),
            ),
            'default'  => 'Muli',
        ),
        array(
            'id'          => 'font_main',
            'type'        => 'typography',
            'title'       => esc_html__('Body Google Font', 'lawsight'),
            'subtitle'    => esc_html__('This will be the default font of your website.', 'lawsight'),
            'google'      => true,
            'font-backup' => true,
            'all_styles'  => true,
            'line-height'  => true,
            'font-size'  => true,
            'text-align'  => false,
            'color'  => false,
            'output'      => array('body'),
            'units'       => 'px',
            'required' => array( 0 => 'body_default_font', 1 => 'equals', 2 => 'Google-Font' ),
            'force_output' => true
        ),
        array(
            'id'          => 'body_color',
            'type'        => 'color',
            'title'       => esc_html__('Body Color', 'lawsight'),
            'transparent' => false,
            'default'     => '',
            'required' => array( 0 => 'body_default_font', 1 => 'equals', 2 => 'Google-Font' ),
            'force_output' => true,
            'output'      => array('body, .single-hentry.archive .entry-content, .single-post .content-area, .ct-related-post .item-holder .item-content'),
        ),
        array(
            'id'       => 'heading_default_font',
            'type'     => 'select',
            'title'    => esc_html__('Heading Default Font', 'lawsight'),
            'options'  => array(
                'Poppins'  => esc_html__('Default', 'lawsight'),
                'Google-Font'  => esc_html__('Google Font', 'lawsight'),
            ),
            'default'  => 'Poppins',
        ),
        array(
            'id'          => 'font_h1',
            'type'        => 'typography',
            'title'       => esc_html__('H1', 'lawsight'),
            'subtitle'    => esc_html__('This will be the default font for all H1 tags of your website.', 'lawsight'),
            'google'      => true,
            'font-backup' => true,
            'all_styles'  => true,
            'text-align'  => false,
            'color'  => false,
            'output'      => array('h1', '.h1', '.text-heading'),
            'units'       => 'px',
            'required' => array( 0 => 'heading_default_font', 1 => 'equals', 2 => 'Google-Font' ),
            'force_output' => true
        ),
        array(
            'id'          => 'font_h2',
            'type'        => 'typography',
            'title'       => esc_html__('H2', 'lawsight'),
            'subtitle'    => esc_html__('This will be the default font for all H2 tags of your website.', 'lawsight'),
            'google'      => true,
            'font-backup' => true,
            'all_styles'  => true,
            'text-align'  => false,
            'color'  => false,
            'output'      => array('h2', '.h2'),
            'units'       => 'px',
            'required' => array( 0 => 'heading_default_font', 1 => 'equals', 2 => 'Google-Font' ),
            'force_output' => true
        ),
        array(
            'id'          => 'font_h3',
            'type'        => 'typography',
            'title'       => esc_html__('H3', 'lawsight'),
            'subtitle'    => esc_html__('This will be the default font for all H3 tags of your website.', 'lawsight'),
            'google'      => true,
            'font-backup' => true,
            'all_styles'  => true,
            'text-align'  => false,
            'color'  => false,
            'output'      => array('h3', '.h3'),
            'units'       => 'px',
            'required' => array( 0 => 'heading_default_font', 1 => 'equals', 2 => 'Google-Font' ),
            'force_output' => true
        ),
        array(
            'id'          => 'font_h4',
            'type'        => 'typography',
            'title'       => esc_html__('H4', 'lawsight'),
            'subtitle'    => esc_html__('This will be the default font for all H4 tags of your website.', 'lawsight'),
            'google'      => true,
            'font-backup' => true,
            'all_styles'  => true,
            'text-align'  => false,
            'color'  => false,
            'output'      => array('h4', '.h4'),
            'units'       => 'px',
            'required' => array( 0 => 'heading_default_font', 1 => 'equals', 2 => 'Google-Font' ),
            'force_output' => true
        ),
        array(
            'id'          => 'font_h5',
            'type'        => 'typography',
            'title'       => esc_html__('H5', 'lawsight'),
            'subtitle'    => esc_html__('This will be the default font for all H5 tags of your website.', 'lawsight'),
            'google'      => true,
            'font-backup' => true,
            'all_styles'  => true,
            'text-align'  => false,
            'color'  => false,
            'output'      => array('h5', '.h5'),
            'units'       => 'px',
            'required' => array( 0 => 'heading_default_font', 1 => 'equals', 2 => 'Google-Font' ),
            'force_output' => true
        ),
        array(
            'id'          => 'font_h6',
            'type'        => 'typography',
            'title'       => esc_html__('H6', 'lawsight'),
            'subtitle'    => esc_html__('This will be the default font for all H6 tags of your website.', 'lawsight'),
            'google'      => true,
            'font-backup' => true,
            'all_styles'  => true,
            'text-align'  => false,
            'color'  => false,
            'output'      => array('h6', '.h6'),
            'units'       => 'px',
            'required' => array( 0 => 'heading_default_font', 1 => 'equals', 2 => 'Google-Font' ),
            'force_output' => true
        )
    )
));

Redux::setSection($opt_name, array(
    'title'      => esc_html__('Fonts Selectors', 'lawsight'),
    'icon'       => 'el el-fontsize',
    'subsection' => true,
    'fields'     => array(
        array(
            'id'          => 'custom_font_1',
            'type'        => 'typography',
            'title'       => esc_html__('Custom Font', 'lawsight'),
            'subtitle'    => esc_html__('This will be the font that applies to the class selector.', 'lawsight'),
            'google'      => true,
            'font-backup' => true,
            'all_styles'  => true,
            'text-align'  => false,
            'output'      => $custom_font_selectors_1,
            'units'       => 'px',

        ),
        array(
            'id'       => 'custom_font_selectors_1',
            'type'     => 'textarea',
            'title'    => esc_html__('CSS Selectors', 'lawsight'),
            'subtitle' => esc_html__('Add class selectors to apply above font.', 'lawsight'),
            'validate' => 'no_html'
        )
    )
));

/*--------------------------------------------------------------
# Shop
--------------------------------------------------------------*/
if(class_exists('Woocommerce')) {
    Redux::setSection($opt_name, array(
        'title'  => esc_html__('Shop', 'lawsight'),
        'icon'   => 'el el-shopping-cart',
        'fields' => array(
            array(
                'id'       => 'sidebar_shop',
                'type'     => 'button_set',
                'title'    => esc_html__('Sidebar Position', 'lawsight'),
                'subtitle' => esc_html__('Select a sidebar position for archive shop.', 'lawsight'),
                'options'  => array(
                    'left'  => esc_html__('Left', 'lawsight'),
                    'right' => esc_html__('Right', 'lawsight'),
                    'none'  => esc_html__('Disabled', 'lawsight')
                ),
                'default'  => 'right'
            ),
            array(
                'title' => esc_html__('Products displayed per page', 'lawsight'),
                'id' => 'product_per_page',
                'type' => 'slider',
                'subtitle' => esc_html__('Number product to show', 'lawsight'),
                'default' => 12,
                'min'  => 6,
                'step' => 1,
                'max' => 50,
                'display_value' => 'text'
            ),
            array(
                'id'       => 'shop_content_padding',
                'type'     => 'spacing',
                'title'    => esc_html__('Content Paddings', 'lawsight'),
                'subtitle' => esc_html__('Content paddings.', 'lawsight'),
                'mode'     => 'padding',
                'units'    => array('em', 'px', '%'),
                'top'      => true,
                'right'    => false,
                'bottom'   => true,
                'left'     => false,
                'output'   => array('.woocommerce #content, .woocommerce-page #content'),
                'default'  => array(
                    'top'    => '',
                    'right'  => '',
                    'bottom' => '',
                    'left'   => '',
                    'units'  => 'px',
                )
            ),
        )
    ));
}

/* 404 Page /--------------------------------------------------------- */
Redux::setSection($opt_name, array(
    'title'  => esc_html__('404 Page', 'lawsight'),
    'icon'   => 'el-cog-alt el',
    'fields' => array(

        array(
            'id'      => 'subtitle_404_page',
            'type'    => 'text',
            'title'   => esc_html__('Sub Title', 'lawsight'),
            'default' => '',
            'desc' => esc_html__('Default: opps! We are sorry', 'lawsight')
        ),
        array(
            'id'       => 'title_404_page',
            'type'     => 'textarea',
            'title'    => esc_html__('Title', 'lawsight'),
            'default' => '',
            'desc' => esc_html__('Default: We are here as an error page 404', 'lawsight')
        ),
        array(
            'id'       => 'btn_text_404_page',
            'type'     => 'text',
            'title'    => esc_html__('Button Text', 'lawsight'),
            'default' => '',
            'desc' => esc_html__('Default: Take me go back home', 'lawsight')
        ),
    ),
));

/* Custom Code /--------------------------------------------------------- */
Redux::setSection($opt_name, array(
    'title'  => esc_html__('Custom Code', 'lawsight'),
    'icon'   => 'el-icon-edit',
    'fields' => array(

        array(
            'id'       => 'site_header_code',
            'type'     => 'textarea',
            'theme'    => 'chrome',
            'title'    => esc_html__('Header Custom Codes', 'lawsight'),
            'subtitle' => esc_html__('It will insert the code to wp_head hook.', 'lawsight'),
        ),
        array(
            'id'       => 'site_footer_code',
            'type'     => 'textarea',
            'theme'    => 'chrome',
            'title'    => esc_html__('Footer Custom Codes', 'lawsight'),
            'subtitle' => esc_html__('It will insert the code to wp_footer hook.', 'lawsight'),
        ),

    ),
));

/* Custom CSS /--------------------------------------------------------- */
Redux::setSection($opt_name, array(
    'title'  => esc_html__('Custom CSS', 'lawsight'),
    'icon'   => 'el-icon-adjust-alt',
    'fields' => array(

        array(
            'id'   => 'customcss',
            'type' => 'info',
            'desc' => esc_html__('Custom CSS', 'lawsight')
        ),

        array(
            'id'       => 'site_css',
            'type'     => 'ace_editor',
            'title'    => esc_html__('CSS Code', 'lawsight'),
            'subtitle' => esc_html__('Advanced CSS Options. You can paste your custom CSS Code here.', 'lawsight'),
            'mode'     => 'css',
            'validate' => 'css',
            'theme'    => 'chrome',
            'default'  => ""
        ),

    ),
));