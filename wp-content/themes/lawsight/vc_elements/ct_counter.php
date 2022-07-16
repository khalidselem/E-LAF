<?php
vc_map(array(
    'name' => 'Counter',
    'base' => 'ct_counter',
    'class'    => 'ct-icon-element',
    'description' => esc_html__( 'Counter Displayed', 'lawsight' ),
    'category' => esc_html__('CaseThemes Shortcodes', 'lawsight'),
    'params' => array(

        /* Template */
        array(
            'type' => 'cms_template_img',
            'param_name' => 'cms_template',
            'shortcode' => 'ct_counter',
            'heading' => esc_html__('Shortcode Template', 'lawsight'),
            'admin_label' => true,
            'std' => 'ct_counter.php',
            'group' => esc_html__('Template', 'lawsight'),
        ),

        /* Style */
        array(
            'type' => 'dropdown',
            'heading' => esc_html__('Style', 'lawsight'),
            'param_name' => 'style',
            'value' => array(
                'Style 1' => 'style1',
                'Style 2' => 'style2',
            ),
            'group' => esc_html__('Template', 'lawsight'),
            'dependency' => array(
                'element'=>'cms_template',
                'value'=>array(
                    'ct_counter.php',
                )
            ),
        ),
        
        /* Title */
        array(
            'type' => 'textarea',
            'heading' => esc_html__('Title', 'lawsight'),
            'param_name' => 'title',
            'description' => 'Enter title.',
            'group' => esc_html__('Title', 'lawsight'),
            'admin_label' => true,
        ),
        array(
            'type' => 'colorpicker',
            'heading' => esc_html__('Color', 'lawsight'),
            'param_name' => 'title_color',
            'value' => '',
            'group' => esc_html__('Title', 'lawsight'),
        ),

        array(
            'type' => 'textarea',
            'heading' => esc_html__('Description', 'lawsight'),
            'param_name' => 'description',
            'description' => 'Enter description.',
            'group' => esc_html__('Title', 'lawsight'),
            'dependency' => array(
                'element'=>'cms_template',
                'value'=>array(
                    'ct_counter--layout2.php',
                )
            ),
        ),

        /* Digit */
        array(
            'type' => 'textfield',
            'heading' => esc_html__('Digit', 'lawsight'),
            'param_name' => 'digit',
            'description' => 'Enter digit.',
            'group' => esc_html__('Digit', 'lawsight'),
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__('Prefix', 'lawsight'),
            'param_name' => 'prefix',
            'description' => 'Enter prefix.',
            'group' => esc_html__('Digit', 'lawsight'),
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__('Suffix', 'lawsight'),
            'param_name' => 'suffix',
            'description' => 'Enter suffix.',
            'group' => esc_html__('Digit', 'lawsight'),
        ),
        array(
            'type' => 'colorpicker',
            'heading' => esc_html__('Color', 'lawsight'),
            'param_name' => 'digit_color',
            'value' => '',
            'group' => esc_html__('Digit', 'lawsight'),
        ),

        array(
            'type' => 'dropdown',
            'heading' => esc_html__('Use Grouping', 'lawsight'),
            'param_name' => 'grouping',
            'value' => array(
                'No' => '0',
                'Yes' => '1',
            ),
            'group' => esc_html__('Digit', 'lawsight'),
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__('Separator', 'lawsight'),
            'param_name' => 'separator',
            'group' => esc_html__('Digit', 'lawsight'),
            'dependency' => array(
                'element'=>'grouping',
                'value'=>array(
                    '1',
                )
            ),
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
        ),
        array(
            'type' => 'colorpicker',
            'heading' => esc_html__('Icon Color', 'lawsight'),
            'param_name' => 'icon_color',
            'value' => '',
            'group' => esc_html__('Icon', 'lawsight'),
            'dependency' => array(
                'element' => 'icon_type',
                'value' => 'icon',
            ),
            'edit_field_class' => 'vc_col-sm-6 vc_column',
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__('Icon Font Size', 'lawsight'),
            'param_name' => 'icon_font_size',
            'group' => esc_html__('Icon', 'lawsight'),
            'description' => 'Enter number.',
            'dependency' => array(
                'element' => 'icon_type',
                'value' => 'icon',
            ),
            'edit_field_class' => 'vc_col-sm-6 vc_column',
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

class WPBakeryShortCode_ct_counter extends CmsShortCode
{

    protected function content($atts, $content = null)
    {
        return parent::content($atts, $content);
    }
}

?>