<?php
/**
 * Newsletter form for VC
 * Require Newsletter plugin to be installed
 */

if(class_exists('Newsletter')) {
    $forms = array_filter( (array) get_option( 'newsletter_forms', array() ) );

    $forms_list = array(
        esc_html__( 'Default Form', 'lawsight' ) => 'default'
    );

    if ( $forms )
    {
        $index = 1;
        foreach ( $forms as $key => $form )
        {
            $forms_list[ sprintf( esc_html__( 'Form %s', 'lawsight' ), $index ) ] = $key;
            $index ++;
        }
    }

    vc_map(array(
        "name" => 'Newsletter',
        "base" => "ct_newsletter",
        'class'    => 'ct-icon-element',
        'description' => esc_html__( 'Newsletter Form', 'lawsight' ),
        "category" => esc_html__('CaseThemes Shortcodes', 'lawsight'),
        "params" => array(
            array(
                "type" => "textfield",
                "heading" => esc_html__( "Element Title", 'lawsight' ),
                "param_name" => "el_title",
            ),

            array(
                'type'        => 'dropdown',
                'heading'     => esc_html__( 'Newsletter Form', 'lawsight' ),
                'description' => esc_html__( 'Pick default or custom forms from Newsletter Plugin.', 'lawsight' ),
                'value'       => $forms_list,
                'admin_label' => true,
                'param_name'  => 'form'
            ),

            array(
                'type' => 'attach_image',
                'heading' => esc_html__( 'Box Background Image', 'lawsight' ),
                'param_name' => 'el_image',
                'value' => '',
                'description' => esc_html__( 'Select image from media library.', 'lawsight' ),
            ),
            

            array(
                "type" => "textfield",
                "heading" => esc_html__( "Extra class name", 'lawsight' ),
                "param_name" => "el_class",
                "description" => esc_html__( "Style particular content element differently - add a class name and refer to it in Custom CSS.", 'lawsight' ),
                'group' => esc_html__('Extra', 'lawsight'),
            ),
            array(
                'type' => 'animation_style',
                'heading' => esc_html__( 'Animation Style', 'lawsight' ),
                'param_name' => 'animation',
                'description' => esc_html__( 'Choose your animation style', 'lawsight' ),
                'admin_label' => false,
                'weight' => 0,
                'group' => esc_html__('Extra', 'lawsight'),
            ),
        )
    ));

    class WPBakeryShortCode_ct_newsletter extends CmsShortCode
    {

        protected function content($atts, $content = null)
        {
            return parent::content($atts, $content);
        }
    }
} ?>