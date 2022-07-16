<?php
$args = array(
    'name' => 'Social',
    'base' => 'ct_social',
    'class'    => 'ct-icon-element',
    'description' => esc_html__( 'Social Displayed', 'lawsight' ),
    'category' => esc_html__('CaseThemes Shortcodes', 'lawsight'),
    'params' => array(
        
        array(
            'type' => 'param_group',
            'heading' => esc_html__( 'Social', 'lawsight' ),
            'param_name' => 'social',
            'description' => esc_html__( 'Enter values for team item', 'lawsight' ),
            'value' => '',
            'params' => array(
                array(
                    'type' => 'iconpicker',
                    'heading' => esc_html__( 'Icon', 'lawsight' ),
                    'param_name' => 'icon',
                    'value' => '',
                    'settings' => array(
                        'emptyIcon' => true,
                        'type' => 'fontawesome',
                        'iconsPerPage' => 200,
                    ),
                    'description' => esc_html__( 'Select icon from library.', 'lawsight' ),
                    'admin_label' => true,
                ),
                array(
                    'type' => 'textfield',
                    'heading' =>esc_html__('Link', 'lawsight'),
                    'param_name' => 'social_link',
                    'admin_label' => true,
                ),
                array(
                    'type' => 'colorpicker',
                    'heading' => esc_html__('Color', 'lawsight'),
                    'param_name' => 'social_color',
                    'value' => '',
                ),
            ),
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__( 'Align', 'lawsight' ),
            'param_name' => 'align',
            "value" => array(
                'Left' => 'left',
                'Center' => 'center',
                'Right' => 'right',
            ),
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Extra class name', 'lawsight' ),
            'param_name' => 'el_class',
            'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in Custom CSS.', 'lawsight' ),
            'group'      => esc_html__('Extra', 'lawsight'),
        ),
    ));
vc_map($args);

class WPBakeryShortCode_ct_social extends CmsShortCode
{

    protected function content($atts, $content = null)
    {
        return parent::content($atts, $content);
    }
}

?>