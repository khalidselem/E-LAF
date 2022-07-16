<?php
vc_map(array(
    'name' => 'Pricing',
    'base' => 'ct_pricing',
    'class' => 'ct-icon-element',
    'description' => esc_html__( 'Pricing Displayed', 'lawsight' ),
    'category' => esc_html__('CaseThemes Shortcodes', 'lawsight'),
    'params' => array(

        /* Layout Classic */
        array(
            'type' => 'textfield',
            'heading' => __ ( 'Title', 'lawsight' ),
            'param_name' => 'title',
            'value' => '',
            'group' => esc_html__('Source Settings', 'lawsight'),
            'admin_label' => true,
        ),
        array(
            'type' => 'textarea',
            'heading' => __ ( 'Description', 'lawsight' ),
            'param_name' => 'description',
            'value' => '',
            'group' => esc_html__('Source Settings', 'lawsight'),
        ),
        array(
            'type' => 'textfield',
            'heading' => __ ( 'Price', 'lawsight' ),
            'param_name' => 'price',
            'value' => '',
            'group' => esc_html__('Source Settings', 'lawsight'),
        ),
        array(
            'type' => 'textfield',
            'heading' => __ ( 'Time', 'lawsight' ),
            'param_name' => 'pricing_time',
            'value' => '',
            'group' => esc_html__('Source Settings', 'lawsight'),
        ),

        array(
            'type' => 'textfield',
            'heading' => __ ( 'Text Button', 'lawsight' ),
            'param_name' => 'text_button',
            'value' => '',
            'group' => esc_html__('Source Settings', 'lawsight'),
        ),

        array(
            'type' => 'vc_link',
            'heading' => __ ( 'Link Button', 'lawsight' ),
            'param_name' => 'link_button',
            'value' => '',
            'group' => esc_html__('Source Settings', 'lawsight'),
        ),

        /* Icon */
        array(
            'type' => 'dropdown',
            'heading' => esc_html__('Icon Type', 'lawsight'),
            'param_name' => 'icon_type',
            'value' => array(
                'Icon' => 'icon',
                'Image' => 'image',
            ),
            'group' => esc_html__('Icon', 'lawsight'),
        ),
        array(
            'type' => 'attach_image',
            'heading' => esc_html__( 'Icon Image', 'lawsight' ),
            'param_name' => 'icon_image',
            'value' => '',
            'description' => esc_html__( 'Select icon image from media library.', 'lawsight' ),
            'dependency' => array(
                'element'=>'icon_type',
                'value'=>array(
                    'image',
                )
            ),
            'group' => esc_html__('Icon', 'lawsight'),
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__( 'Icon Library', 'lawsight' ),
            'value' => array(
                esc_html__( 'Font Awesome', 'lawsight' ) => 'fontawesome',
                esc_html__( 'Material Design', 'lawsight' ) => 'material_design',
                esc_html__( 'Flaticon', 'lawsight' ) => 'flaticon',
                esc_html__( 'ET Line', 'lawsight' ) => 'etline',
            ),
            'param_name' => 'icon_list',
            'description' => esc_html__( 'Select icon library.', 'lawsight' ),
            'dependency' => array(
                'element' => 'icon_type',
                'value' => 'icon',
            ),
            'group' => esc_html__('Icon', 'lawsight'),
        ),
        array(
            'type' => 'iconpicker',
            'heading' => esc_html__( 'Icon Material', 'lawsight' ),
            'param_name' => 'icon_material_design',
            'settings' => array(
                'emptyIcon' => true,
                'type' => 'material-design',
                'iconsPerPage' => 200,
            ),
            'dependency' => array(
                'element' => 'icon_list',
                'value' => 'material_design',
            ),
            'description' => esc_html__( 'Select icon from library.', 'lawsight' ),
            'group' => esc_html__('Icon', 'lawsight'),
        ),
        array(
            'type' => 'iconpicker',
            'heading' => esc_html__( 'Icon FontAwesome', 'lawsight' ),
            'param_name' => 'icon_fontawesome',
            'value' => '',
            'settings' => array(
                'emptyIcon' => true,
                'type' => 'fontawesome',
                'iconsPerPage' => 200,
            ),
            'dependency' => array(
                'element' => 'icon_list',
                'value' => 'fontawesome',
            ),
            'description' => esc_html__( 'Select icon from library.', 'lawsight' ),
            'group' => esc_html__('Icon', 'lawsight'),
            'admin_label' => true,
        ),  
        array(
            'type' => 'iconpicker',
            'heading' => esc_html__( 'Flaticon', 'lawsight' ),
            'param_name' => 'icon_flaticon',
            'settings' => array(
                'emptyIcon' => true,
                'type' => 'flaticon',
                'iconsPerPage' => 200,
            ),
            'dependency' => array(
                'element' => 'icon_list',
                'value' => 'flaticon',
            ),
            'description' => esc_html__( 'Select icon from library.', 'lawsight' ),
            'group' => esc_html__('Icon', 'lawsight'),
            'admin_label' => true,
        ),
        array(
            'type' => 'iconpicker',
            'heading' => esc_html__( 'Icon ET Line', 'lawsight' ),
            'param_name' => 'icon_etline',
            'settings' => array(
                'emptyIcon' => true,
                'type' => 'etline',
                'iconsPerPage' => 200,
            ),
            'dependency' => array(
                'element' => 'icon_list',
                'value' => 'etline',
            ),
            'description' => esc_html__( 'Select icon from library.', 'lawsight' ),
            'group' => esc_html__('Icon', 'lawsight'),
            'admin_label' => true,
        ),
        
        /* Extra */
        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Extra class name', 'lawsight' ),
            'param_name' => 'el_class',
            'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in Custom CSS.', 'lawsight' ),
            'group'            => esc_html__('Extra', 'lawsight')
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

class WPBakeryShortCode_ct_pricing extends CmsShortCode
{

    protected function content($atts, $content = null)
    {
        return parent::content($atts, $content);
    }
}

?>