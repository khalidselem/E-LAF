<?php
vc_map(array(
    'name' => 'Box Background Image',
    'base' => 'ct_box_background_image',
    'class'    => 'ct-icon-element',
    'description' => esc_html__( 'Signature Displayed', 'lawsight' ),
    'category' => esc_html__('CaseThemes Shortcodes', 'lawsight'),
    'params' => array(

        array(
            'type' => 'attach_image',
            'heading' => esc_html__( 'Background Image', 'lawsight' ),
            'param_name' => 'bg_image',
            'value' => '',
            'description' => esc_html__( 'Select background image from media library.', 'lawsight' ),
        ),

        array(
            'type' => 'attach_image',
            'heading' => esc_html__( 'Layer Image', 'lawsight' ),
            'param_name' => 'layer_image',
            'value' => '',
            'description' => esc_html__( 'Select layer image from media library.', 'lawsight' ),
        ),

        array(
            'type' => 'textfield',
            'heading' => esc_html__('Box Height Desktop', 'lawsight'),
            'param_name' => 'box_height',
            'description' => 'Enter number.',
        ),

        array(
            'type' => 'textfield',
            'heading' => esc_html__('Box Height Mobile', 'lawsight'),
            'param_name' => 'box_height_mobile',
            'description' => 'Enter number.',
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

class WPBakeryShortCode_ct_box_background_image extends CmsShortCode
{

    protected function content($atts, $content = null)
    {
        return parent::content($atts, $content);
    }
}

?>