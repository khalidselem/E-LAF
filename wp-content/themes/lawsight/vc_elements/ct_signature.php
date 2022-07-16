<?php
vc_map(array(
    'name' => 'Signature',
    'base' => 'ct_signature',
    'class'    => 'ct-icon-element',
    'description' => esc_html__( 'Signature Displayed', 'lawsight' ),
    'category' => esc_html__('CaseThemes Shortcodes', 'lawsight'),
    'params' => array(

        array(
            'type' => 'attach_image',
            'heading' => esc_html__( 'Signature Image', 'lawsight' ),
            'param_name' => 'signature_image',
            'value' => '',
            'description' => esc_html__( 'Select signature image from media library.', 'lawsight' ),
        ),

        array(
            'type' => 'textfield',
            'heading' => esc_html__('Title', 'lawsight'),
            'param_name' => 'title',
            'description' => 'Enter title.',
            'admin_label' => true,
        ),

        array(
            'type' => 'textfield',
            'heading' => esc_html__('Position', 'lawsight'),
            'param_name' => 'position',
            'description' => 'Enter position.',
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

class WPBakeryShortCode_ct_signature extends CmsShortCode
{

    protected function content($atts, $content = null)
    {
        return parent::content($atts, $content);
    }
}

?>