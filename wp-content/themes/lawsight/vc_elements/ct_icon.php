<?php
vc_map(
    array(
        'name'     => esc_html__('Icons', 'lawsight'),
        'base'     => 'ct_icon',
        'class'    => 'ct-icon-element',
        'description' => esc_html__( 'Icons Displayed', 'lawsight' ),
        'category' => esc_html__('CaseThemes Shortcodes', 'lawsight'),
        'params'   => array(

            array(
                'type' => 'param_group',
                'heading' => esc_html__( 'Icons', 'lawsight' ),
                'param_name' => 'icon',
                'description' => esc_html__( 'Enter values for team item', 'lawsight' ),
                'value' => '',
                'group' => esc_html__('Source Settings', 'lawsight'),
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
                        'param_name' => 'icon_link',
                        'admin_label' => true,
                    ),
                ),
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__( 'Extra class name', 'lawsight' ),
                'param_name' => 'el_class',
                'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in Custom CSS.', 'lawsight' ),
            ),

        )
    )
);

class WPBakeryShortCode_ct_icon extends CmsShortCode
{

    protected function content($atts, $content = null)
    {
        return parent::content($atts, $content);
    }
}

?>