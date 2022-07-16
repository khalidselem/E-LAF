<?php
vc_map(array(
    'name' => 'Button',
    'base' => 'ct_button',
    'class'    => 'ct-icon-element',
    'description' => esc_html__( 'Button Displayed', 'lawsight' ),
    'category' => esc_html__('CaseThemes Shortcodes', 'lawsight'),
    'params' => array(
        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Text', 'lawsight' ),
            'param_name' => 'button_text',
            'value' => '',
            'admin_label' => true,
            'group' => esc_html__('Button Settings', 'lawsight')
        ),
        array(
            'type' => 'vc_link',
            'class' => '',
            'heading' => esc_html__('Link', 'lawsight'),
            'param_name' => 'button_link',
            'value' => '',
            'group' => esc_html__('Button Settings', 'lawsight')
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__('Button Style', 'lawsight'),
            'param_name' => 'button_style',
            'value' => array(
                'Default' => 'btn-default',
                'Gray' => 'btn-gray',
                'Gradient' => 'btn-gradient',
                'Dark' => 'btn-dark',
                'Third' => 'btn-third',
            ),
            'group' => esc_html__('Button Settings', 'lawsight'),
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__('Button Size', 'lawsight'),
            'param_name' => 'button_size',
            'value' => array(
                'Default' => 'size-default',
                'Large' => 'size-lg',
            ),
            'group' => esc_html__('Button Settings', 'lawsight'),
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__('Align Large', 'lawsight'),
            'param_name' => 'align_lg',
            'value' => array(
                'Left' => 'align-left',
                'Center' => 'align-center',
                'Right' => 'align-right',
            ),
            'edit_field_class' => 'vc_col-sm-3 vc_column',
            'group' => esc_html__('Button Settings', 'lawsight'),
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__('Align Medium', 'lawsight'),
            'param_name' => 'align_md',
            'value' => array(
                'Left' => 'align-left-md',
                'Center' => 'align-center-md',
                'Right' => 'align-right-md',
            ),
            'edit_field_class' => 'vc_col-sm-3 vc_column',
            'group' => esc_html__('Button Settings', 'lawsight'),
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__('Align Small', 'lawsight'),
            'param_name' => 'align_sm',
            'value' => array(
                'Left' => 'align-left-sm',
                'Center' => 'align-center-sm',
                'Right' => 'align-right-sm',
            ),
            'edit_field_class' => 'vc_col-sm-3 vc_column',
            'group' => esc_html__('Button Settings', 'lawsight'),
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__('Align Mini', 'lawsight'),
            'param_name' => 'align_xs',
            'value' => array(
                'Left' => 'align-left-xs',
                'Center' => 'align-center-xs',
                'Right' => 'align-right-xs',
            ),
            'edit_field_class' => 'vc_col-sm-3 vc_column',
            'group' => esc_html__('Button Settings', 'lawsight'),
        ),
        /* Padding */
        array(
            'type' => 'textfield',
            'heading' => esc_html__('Padding Top', 'lawsight'),
            'param_name' => 'padding_top',
            'description' => 'Enter number.',
            'edit_field_class' => 'vc_col-sm-3 vc_column',
            'group' => esc_html__('Button Settings', 'lawsight'),
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__('Padding Right', 'lawsight'),
            'param_name' => 'padding_right',
            'description' => 'Enter number.',
            'edit_field_class' => 'vc_col-sm-3 vc_column',
            'group' => esc_html__('Button Settings', 'lawsight'),
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__('Padding Bottom', 'lawsight'),
            'param_name' => 'padding_bottom',
            'description' => 'Enter number.',
            'edit_field_class' => 'vc_col-sm-3 vc_column',
            'group' => esc_html__('Button Settings', 'lawsight'),
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__('Padding Left', 'lawsight'),
            'param_name' => 'padding_left',
            'description' => 'Enter number.',
            'edit_field_class' => 'vc_col-sm-3 vc_column',
            'group' => esc_html__('Button Settings', 'lawsight'),
        ),
        /* Border radius */
        /* Padding */
        array(
            'type' => 'textfield',
            'heading' => esc_html__('Border Radius Top', 'lawsight'),
            'param_name' => 'br_top',
            'description' => 'Enter number.',
            'edit_field_class' => 'vc_col-sm-3 vc_column',
            'group' => esc_html__('Button Settings', 'lawsight'),
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__('Border Radius Right', 'lawsight'),
            'param_name' => 'br_right',
            'description' => 'Enter number.',
            'edit_field_class' => 'vc_col-sm-3 vc_column',
            'group' => esc_html__('Button Settings', 'lawsight'),
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__('Border Radius Bottom', 'lawsight'),
            'param_name' => 'br_bottom',
            'description' => 'Enter number.',
            'edit_field_class' => 'vc_col-sm-3 vc_column',
            'group' => esc_html__('Button Settings', 'lawsight'),
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__('Border Radius Left', 'lawsight'),
            'param_name' => 'br_left',
            'description' => 'Enter number.',
            'edit_field_class' => 'vc_col-sm-3 vc_column',
            'group' => esc_html__('Button Settings', 'lawsight'),
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__( 'Icon Library', 'lawsight' ),
            'value' => array(
                esc_html__( 'Font Awesome', 'lawsight' ) => 'fontawesome',
                esc_html__( 'Material Design', 'lawsight' ) => 'material_design',
                esc_html__( 'ET Line', 'lawsight' ) => 'etline',
                esc_html__( 'Themify', 'lawsight' ) => 'themify',
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
            'type' => 'iconpicker',
            'heading' => esc_html__( 'Icon Themify', 'lawsight' ),
            'param_name' => 'icon_themify',
            'settings' => array(
                'emptyIcon' => true,
                'type' => 'themify',
                'iconsPerPage' => 200,
            ),
            'dependency' => array(
                'element' => 'icon_list',
                'value' => 'themify',
            ),
            'description' => esc_html__( 'Select icon from library.', 'lawsight' ),
            'group' => esc_html__('Icon', 'lawsight'),
        ),      
        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Extra class name', 'lawsight' ),
            'param_name' => 'el_class',
            'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in Custom CSS.', 'lawsight' ),
            'group'            => esc_html__('Button Settings', 'lawsight')
        ),
        array(
            'type' => 'animation_style',
            'heading' => esc_html__( 'Animation Style', 'lawsight' ),
            'param_name' => 'animation',
            'description' => esc_html__( 'Choose your animation style', 'lawsight' ),
            'admin_label' => false,
            'weight' => 0,
            'group' => esc_html__('Button Settings', 'lawsight'),
        ),
    )
));

class WPBakeryShortCode_ct_button extends CmsShortCode
{

    protected function content($atts, $content = null)
    {
        return parent::content($atts, $content);
    }
}

?>