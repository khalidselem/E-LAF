<?php
vc_map(array(
    'name' => 'Process',
    'base' => 'ct_process',
    'class'    => 'ct-icon-element',
    'description' => esc_html__( 'Process Displayed', 'lawsight' ),
    'category' => esc_html__('CaseThemes Shortcodes', 'lawsight'),
    'params' => array(

        array(
            'type' => 'param_group',
            'heading' => esc_html__( 'Process Lists', 'lawsight' ),
            'param_name' => 'ct_process_list',
            'value' => '',
            'params' => array(

                array(
                    'type' => 'textfield',
                    'heading' => esc_html__( 'Year', 'lawsight' ),
                    'param_name' => 'year',
                    'value' => '',
                ),
                array(
                    'type' => 'textarea',
                    'heading' => esc_html__('Title', 'lawsight'),
                    'param_name' => 'title',
                    'description' => 'Enter title.',
                    'admin_label' => true,
                ),
                array(
                    'type' => 'textarea',
                    'heading' => esc_html__('Description', 'lawsight'),
                    'param_name' => 'description',
                    'description' => 'Enter description.',
                ),
            ),
        ),

        array(
            'type' => 'colorpicker',
            'heading' => esc_html__('Year Color', 'lawsight'),
            'param_name' => 'year_color',
            'value' => '',
        ),
        
        array(
            'type' => 'colorpicker',
            'heading' => esc_html__('Title Color', 'lawsight'),
            'param_name' => 'title_color',
            'value' => '',
        ),

        array(
            'type' => 'colorpicker',
            'heading' => esc_html__('Description Color', 'lawsight'),
            'param_name' => 'description_color',
            'value' => '',
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

class WPBakeryShortCode_ct_process extends CmsShortCode
{

    protected function content($atts, $content = null)
    {
        return parent::content($atts, $content);
    }
}

?>