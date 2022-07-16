<?php
if ( ! class_exists( 'ReduxFrameworkInstances' ) )
{
    return;
}

/*
 * Convert HEX to GRBA
 */
if(!function_exists('lawsight_rgba')){
    function lawsight_rgba($hex,$opacity = 1) {
        $hex = str_replace("#",null, $hex);
        $color = array();
        if(strlen($hex) == 3) {
            $color['r'] = hexdec(substr($hex,0,1).substr($hex,0,1));
            $color['g'] = hexdec(substr($hex,1,1).substr($hex,1,1));
            $color['b'] = hexdec(substr($hex,2,1).substr($hex,2,1));
            $color['a'] = $opacity;
        }
        else if(strlen($hex) == 6) {
            $color['r'] = hexdec(substr($hex, 0, 2));
            $color['g'] = hexdec(substr($hex, 2, 2));
            $color['b'] = hexdec(substr($hex, 4, 2));
            $color['a'] = $opacity;
        }
        $color = "rgba(".implode(', ', $color).")";
        return $color;
    }
}

/*
 * Convert HEX to Dark & Lighten
 */
function lawsight_lighten( $hex, $percent ) {
    
    // validate hex string
    
    $hex = preg_replace( '/[^0-9a-f]/i', '', $hex );
    $new_hex = '#';
    
    if ( strlen( $hex ) < 6 ) {
        $hex = $hex[0] + $hex[0] + $hex[1] + $hex[1] + $hex[2] + $hex[2];
    }
    
    // convert to decimal and change luminosity
    for ($i = 0; $i < 3; $i++) {
        $dec = hexdec( substr( $hex, $i*2, 2 ) );
        $dec = min( max( 0, $dec + $dec * $percent ), 255 ); 
        $new_hex .= str_pad( dechex( $dec ) , 2, 0, STR_PAD_LEFT );
    }       
    
    return $new_hex;
}

class CSS_Generator
{
    /**
     * scssc class instance
     *
     * @access protected
     * @var scssc
     */
    protected $scssc = null;

    /**
     * ReduxFramework class instance
     *
     * @access protected
     * @var ReduxFramework
     */
    protected $redux = null;

    /**
     * Debug mode is turn on or not
     *
     * @access protected
     * @var boolean
     */
    protected $dev_mode = true;

    /**
     * opt_name of ReduxFramework
     *
     * @access protected
     * @var string
     */
    protected $opt_name = '';


    /**
     * Constructor
     */
    function __construct() {
        $this->opt_name = lawsight_get_opt_name();

        if ( empty( $this->opt_name ) ) {
            return;
        }
        $this->dev_mode = lawsight_get_opt( 'dev_mode', '0' ) === '1' ? true : false;
        add_filter( 'cms_scssc_on', '__return_true' );
        add_action( 'init', array( $this, 'init' ) );
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue' ), 20 );
    }

    /**
     * init hook - 10
     */
    function init() {
        if ( ! class_exists( 'scssc' ) ) {
            return;
        }

        $this->redux = ReduxFrameworkInstances::get_instance( $this->opt_name );

        if ( empty( $this->redux ) || ! $this->redux instanceof ReduxFramework ) {
            return;
        }
        add_action( 'wp', array( $this, 'generate_with_dev_mode' ) );
        add_action( "redux/options/{$this->opt_name}/saved", function () {
            $this->generate_file();
        } );
    }

    function generate_with_dev_mode() {
        if ( $this->dev_mode === true ) {
            $this->generate_file();
        }
    }

    /**
     * Generate options and css files
     */
    function generate_file() {
        $scss_dir = get_template_directory() . '/assets/scss/';
        $css_dir  = get_template_directory() . '/assets/css/';

        $this->scssc = new scssc();
        $this->scssc->setImportPaths( $scss_dir );

        $_options = $scss_dir . 'variables.scss';

        $this->redux->filesystem->execute( 'put_contents', $_options, array(
            'content' => preg_replace( "/(?<=[^\r]|^)\n/", "\r\n", $this->options_output() )
        ) );
        $css_file = $css_dir . 'theme.css';

        $this->scssc->setFormatter( 'scss_formatter' );
        $this->redux->filesystem->execute( 'put_contents', $css_file, array(
            'content' => preg_replace( "/(?<=[^\r]|^)\n/", "\r\n", $this->scssc->compile( '@import "theme.scss"' ) )
        ) );
    }

    /**
     * Output options to _variables.scss
     *
     * @access protected
     * @return string
     */
    protected function options_output()
    {
        ob_start();

        /* Preset 1 */
        $primary_color = lawsight_get_opt( 'primary_color', '#d5aa6d' );
        if ( ! lawsight_is_valid_color( $primary_color ) )
        {
            $primary_color = '#d5aa6d';
        }
        printf( '$primary_color: %s;', esc_attr( $primary_color ) );

        $secondary_color = lawsight_get_opt( 'secondary_color', '#9b6f45' );
        if ( ! lawsight_is_valid_color( $secondary_color ) )
        {
            $secondary_color = '#9b6f45';
        }
        printf( '$secondary_color: %s;', esc_attr( $secondary_color ) );

        $third_color = lawsight_get_opt( 'third_color', '#d5aa6d' );
        if ( ! lawsight_is_valid_color( $third_color ) )
        {
            $third_color = '#d5aa6d';
        }
        printf( '$third_color: %s;', esc_attr( $third_color ) );

        /* Link */
        $link_color = lawsight_get_opt( 'link_color', '#d5aa6d' );
        if ( !empty($link_color['regular']) && isset($link_color['regular']) )
        {
            printf( '$link_color: %s;', esc_attr( $link_color['regular'] ) );
        } else {
            echo '$link_color: #d5aa6d;';
        }

        $link_color_hover = lawsight_get_opt( 'link_color', '#9b6f45' );
        if ( !empty($link_color['hover']) && isset($link_color['hover']) )
        {
            printf( '$link_color_hover: %s;', esc_attr( $link_color['hover'] ) );
        } else {
            echo '$link_color_hover: #9b6f45;';
        }

        $link_color_active = lawsight_get_opt( 'link_color', '#9b6f45' );
        if ( !empty($link_color['active']) && isset($link_color['active']) )
        {
            printf( '$link_color_active: %s;', esc_attr( $link_color['active'] ) );
        } else {
            echo '$link_color_active: #9b6f45;';
        }

        /* Font */
        $body_default_font = lawsight_get_opt( 'body_default_font', 'Muli' );
        if (isset($body_default_font)) {
            echo '
                $body_default_font: '.esc_attr( $body_default_font ).';
            ';
        }

        $heading_default_font = lawsight_get_opt( 'heading_default_font', 'Poppins' );
        if (isset($heading_default_font)) {
            echo '
                $heading_default_font: '.esc_attr( $heading_default_font ).';
            ';
        }

        return ob_get_clean();
    }

    /**
     * Hooked wp_enqueue_scripts - 20
     * Make sure that the handle is enqueued from earlier wp_enqueue_scripts hook.
     */
    function enqueue()
    {
        $css = $this->inline_css();
        $this->dev_mode = true;
        if ( !empty($css) )
        {
            wp_add_inline_style( 'lawsight-theme', $this->dev_mode ? $css : lawsight_css_minifier( $css ) );
        }
    }

    /**
     * Generate inline css based on theme options
     */
    protected function inline_css()
    {
        ob_start();
        /* BG Body */
        $body_background = lawsight_get_opt( 'body_background' );
        $layout_boxed = lawsight_get_opt( 'layout_boxed', false );
        $layout_boxed_page = lawsight_get_page_opt( 'layout_boxed', false );
        if($layout_boxed_page) {
            $layout_boxed = $layout_boxed_page;
        }
        if($layout_boxed && isset($body_background)) {
            echo 'body {
                background-color: '.esc_attr( $body_background['background-color'] ).';
                background-size: '.esc_attr( $body_background['background-size'] ).';
                background-attachment: '.esc_attr( $body_background['background-attachment'] ).';
                background-repeat: '.esc_attr( $body_background['background-repeat'] ).';
                background-position: '.esc_attr( $body_background['background-position'] ).';
                background-image: url('.esc_attr( $body_background['background-image'] ).');
            }';
        }

        /* Logo */
        $logo_maxh = lawsight_get_opt( 'logo_maxh' );
        $logo_maxh_mobile = lawsight_get_opt( 'logo_maxh_mobile' );

        if (!empty($logo_maxh['height']) && $logo_maxh['height'] != 'px')
        {
            printf( '#header-wrap .header-branding a img { max-height: %s; }', esc_attr($logo_maxh['height']) );
        }

        if (!empty($logo_maxh_mobile['height']) && $logo_maxh_mobile['height'] != 'px') {
            echo '@media screen and (max-width: 991px) {';
                echo '#header-wrap .header-branding a img {
                    max-height: '.esc_attr( $logo_maxh_mobile['height'] ).' !important;
                }';
            echo '}';
        }

        $mobile_header_bgcolor = lawsight_get_opt( 'mobile_header_bgcolor' );
        if(!empty($mobile_header_bgcolor)) {
            echo '@media screen and (max-width: 991px) {';
                echo 'body #header-wrap #header-main {
                    background-color: '.esc_attr( $mobile_header_bgcolor ).' !important;
                }';
            echo '}';
        }

        $mobile_icon_menu_color = lawsight_get_opt( 'mobile_icon_menu_color' );
        if(!empty($mobile_icon_menu_color)) {
            echo '@media screen and (max-width: 991px) {';
                echo '#main-menu-mobile .btn-nav-mobile::before, #main-menu-mobile .btn-nav-mobile::after, #main-menu-mobile .btn-nav-mobile span {
                    background-color: '.esc_attr( $mobile_icon_menu_color ).' !important;
                }';
            echo '}';
        }

        /* Top bar */
        $phone_color = lawsight_get_opt( 'phone_color' );
        if ( !empty( $phone_color ) ) {
            printf( '#header-wrap.header-layout2 .header-phone a, #header-wrap.header-layout2 .header-phone .header-phone-icon { color: %s !important; }', esc_attr($phone_color) );
            printf( '#header-wrap.header-layout2 .header-phone:before { background-color: %s !important; opacity: 0.52; }', esc_attr($phone_color) );
        }
        $sticky_phone_color = lawsight_get_opt( 'sticky_phone_color' );
        if ( !empty( $sticky_phone_color ) ) {
            printf( '#header-wrap.header-layout2 #header-main.h-fixed .header-phone a, #header-wrap.header-layout2 #header-main.h-fixed .header-phone .header-phone-icon { color: %s !important; }', esc_attr($sticky_phone_color) );
            printf( '#header-wrap.header-layout2 #header-main.h-fixed .header-phone:before { background-color: %s !important; opacity: 0.52; }', esc_attr($sticky_phone_color) );
        }

        /* Menu */
        $menu_text_transform = lawsight_get_opt( 'menu_text_transform' );
        if ( !empty( $menu_text_transform ) ) {
            printf( '.primary-menu > li > a { text-transform: %s !important; }', esc_attr($menu_text_transform) );
        }
        $menu_font_size = lawsight_get_opt( 'menu_font_size' );
        if ( !empty( $menu_font_size ) ) {
            printf( '.primary-menu > li > a { font-size: %s'.'px !important; }', esc_attr($menu_font_size) );
        }
        $main_menu_color = lawsight_get_opt( 'main_menu_color' );
        if ( !empty( $main_menu_color['regular'] ) ) {
            printf( '.primary-menu > li > a, .header-icon-right .h-btn-search { color: %s !important; }', esc_attr($main_menu_color['regular']) );
        }
        if ( !empty( $main_menu_color['hover'] ) ) {
            printf( '.primary-menu > li > a:hover, .header-icon-right .h-btn-search:hover { color: %s !important; }', esc_attr($main_menu_color['hover']) );
        }
        if ( !empty( $main_menu_color['hover'] ) ) {
            printf( '.primary-menu > li > a:hover:before { background-color: %s !important; }', esc_attr($main_menu_color['hover']) );
        }
        if ( !empty( $main_menu_color['active'] ) ) {
            printf( '.primary-menu > li > a.current, .primary-menu > li.current_page_item > a, .primary-menu > li.current-menu-item > a, .primary-menu > li.current_page_ancestor > a, .primary-menu > li.current-menu-ancestor > a { color: %s !important; }', esc_attr($main_menu_color['active']) );
        }
        if ( !empty( $main_menu_color['active'] ) ) {
            printf( '.primary-menu > li > a.current:before, .primary-menu > li.current_page_item > a:before, .primary-menu > li.current-menu-item > a:before, .primary-menu > li.current_page_ancestor > a:before, .primary-menu > li.current-menu-ancestor > a:before { background-color: %s !important; }', esc_attr($main_menu_color['active']) );
        }

        /* Header Sticky */
        $header_bgcolor_sticky = lawsight_get_opt( 'header_bgcolor_sticky' );
        $main_menu_color_sticky = lawsight_get_opt( 'main_menu_color_sticky' );
        if ( !empty( $header_bgcolor_sticky ) ) {
            printf( '#header-wrap.is-sticky #header-main.h-fixed, #header-wrap.is-sticky-offset #header-main.h-fixed { background-color: %s !important; background-image: none !important; }', esc_attr($header_bgcolor_sticky) );
        }
        if ( !empty( $main_menu_color_sticky['regular'] ) ) {
            printf( '#header-main.h-fixed .primary-menu > li > a, #header-main.h-fixed .header-right .h-btn-search, #header-main.h-fixed .header-icon-right .h-btn-search { color: %s !important; }', esc_attr($main_menu_color_sticky['regular']) );
        }
        if ( !empty( $main_menu_color_sticky['hover'] ) ) {
            printf( '#header-main.h-fixed .primary-menu > li > a:hover, #header-main.h-fixed .header-right .h-btn-search:hover, #header-main.h-fixed .header-icon-right .h-btn-search:hover { color: %s !important; }', esc_attr($main_menu_color_sticky['hover']) );
        }
        if ( !empty( $main_menu_color_sticky['hover'] ) ) {
            printf( '#header-main.h-fixed .primary-menu > li > a:hover:before, #header-main.h-fixed .hidden-sidebar-icon:hover:before { background-color: %s !important; }', esc_attr($main_menu_color_sticky['hover']) );
        }
        if ( !empty( $main_menu_color_sticky['active'] ) ) {
            printf( '#header-main.h-fixed .primary-menu > li > a.current, #header-main.h-fixed .primary-menu > li.current_page_item > a, #header-main.h-fixed .primary-menu > li.current-menu-item > a, #header-main.h-fixed .primary-menu > li.current_page_ancestor > a, #header-main.h-fixed .primary-menu > li.current-menu-ancestor > a { color: %s !important; }', esc_attr($main_menu_color_sticky['active']) );
        }
        if ( !empty( $main_menu_color_sticky['active'] ) ) {
            printf( '#header-main.h-fixed .primary-menu > li > a.current:before, #header-main.h-fixed .primary-menu > li.current_page_item > a:before, #header-main.h-fixed .primary-menu > li.current-menu-item > a:before, #header-main.h-fixed .primary-menu > li.current_page_ancestor > a:before, #header-main.h-fixed .primary-menu > li.current-menu-ancestor > a:before { background-color: %s !important; }', esc_attr($main_menu_color_sticky['active']) );
        }

        /* Content */
        $post_text_align = lawsight_get_opt( 'post_text_align', 'inherit' );
        if($post_text_align == 'justify') {
            echo '.single-post .content-area .entry-content p {
                text-align: justify;
            }';
        }

        /* Footer */
        $footer_top_color = lawsight_get_opt( 'footer_top_color' );
        $footer_top_color_page = lawsight_get_page_opt( 'footer_top_color' );
        if(!empty($footer_top_color_page)) {
            $footer_top_color = $footer_top_color_page;
        }
        if ( ! empty( $footer_top_color ) ) {
            echo '.site-footer .top-footer .contact-info {
                color: ' . esc_attr( $footer_top_color ) . ';
            }';
        }
        $footer_top_link_color = lawsight_get_opt( 'footer_top_link_color' );
        $footer_top_link_color_page = lawsight_get_page_opt( 'footer_top_link_color' );
        if(!empty($footer_top_link_color_page)) {
            $footer_top_link_color = $footer_top_link_color_page;
        }
        if ( ! empty( $footer_top_link_color['hover'] ) ) {
            echo '.site-footer .contact-info ul li i {
                color: ' . esc_attr( $footer_top_link_color['hover'] ) . ';
            }';
            echo '.site-footer .top-footer ul.menu li a::after, .site-footer .top-footer .widget_pages ul li a::after, .site-footer .top-footer .widget_meta ul li a::after, .site-footer .top-footer .widget_categories ul li a::after, .site-footer .top-footer .widget_archive ul li a::after {
                background-color: ' . esc_attr( $footer_top_link_color['hover'] ) . ';
            }';
        } 

        /* Custom Css */
        $custom_css = lawsight_get_opt( 'site_css' );
        if(!empty($custom_css)) { echo esc_attr($custom_css); }

        return ob_get_clean();
    }
}

new CSS_Generator();