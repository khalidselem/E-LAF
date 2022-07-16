<?php
vc_map(array(
    'name' => 'Contact Info',
    'base' => 'ct_contact_info',
    'class'    => 'ct-icon-element',
    'description' => esc_html__( 'Contact Info Displayed', 'lawsight' ),
    'category' => esc_html__('CaseThemes Shortcodes', 'lawsight'),
    'params' => array(

        /* Content */
        
        array(
            'type' => 'dropdown',
            'heading' => esc_html__('Style', 'lawsight'),
            'param_name' => 'style',
            'value' => array(
                'Style 1' => 'style1',
                'Style 2' => 'style2',
            ),
        ),

        array(
            'type' => 'textarea',
            'heading' =>esc_html__('Content', 'lawsight'),
            'param_name' => 'content_info',
            'admin_label' => true,
        ),

        array(
            'type' => 'colorpicker',
            'heading' => esc_html__('Content Color', 'lawsight'),
            'param_name' => 'content_color',
            'value' => '',
        ),

        array(
            'type' => 'dropdown',
            'heading' => esc_html__('Content Type', 'lawsight'),
            'param_name' => 'content_type',
            'value' => array(
                'Text' => 'text',
                'Tel' => 'tel',
                'Email' => 'email',
                'Map' => 'map',
            ),
        ),

        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Button Text', 'lawsight' ),
            'param_name' => 'button_text',
            'value' => '',
            'dependency' => array(
                'element'=>'content_type',
                'value'=>array(
                    'map',
                )
            ),
        ),
        array(
            'type' => 'vc_link',
            'class' => '',
            'heading' => esc_html__('Button Link', 'lawsight'),
            'param_name' => 'button_link',
            'value' => '',
            'dependency' => array(
                'element'=>'content_type',
                'value'=>array(
                    'map',
                )
            ),
        ),

        /* Icon */
        array(
            'type' => 'dropdown',
            'heading' => esc_html__( 'Icon Library', 'lawsight' ),
            'value' => array(
                esc_html__( 'Font Awesome', 'lawsight' ) => 'fontawesome',
                esc_html__( 'Font Awesome 5', 'lawsight' ) => 'fontawesome5',
                esc_html__( 'Material Design', 'lawsight' ) => 'material_design',
                esc_html__( 'Flaticon', 'lawsight' ) => 'flaticon',
            ),
            'param_name' => 'icon_list',
            'description' => esc_html__( 'Select icon library.', 'lawsight' ),
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
            'heading' => esc_html__( 'Icon FontAwesome 4', 'lawsight' ),
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
        ),  
        array(
            'type' => 'iconpicker',
            'heading' => esc_html__( 'Icon FontAwesome 5', 'lawsight' ),
            'param_name' => 'icon_fontawesome5',
            'value' => '',
            'settings' => array(
                'emptyIcon' => true,
                'type' => 'awesome5',
                'iconsPerPage' => 200,
            ),
            'dependency' => array(
                'element' => 'icon_list',
                'value' => 'fontawesome5',
            ),
            'description' => esc_html__( 'Select icon from library.', 'lawsight' ),
            'group' => esc_html__('Icon', 'lawsight'),
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
        ),
        array(
            'type' => 'colorpicker',
            'heading' => esc_html__('Icon Color', 'lawsight'),
            'param_name' => 'icon_color',
            'value' => '',
            'group' => esc_html__('Icon', 'lawsight'),
        ),
        

        /* Extra */
        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Extra class name', 'lawsight' ),
            'param_name' => 'el_class',
            'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in Custom CSS.', 'lawsight' ),
            'group'            => esc_html__('Extra', 'lawsight')
        ),
    )
));

class WPBakeryShortCode_ct_contact_info extends CmsShortCode
{

    protected function content($atts, $content = null)
    {
        return parent::content($atts, $content);
    }
}

?>