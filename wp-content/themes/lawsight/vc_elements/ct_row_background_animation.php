<?php
vc_map(array(
    'name' => 'Row Background Animation',
    'base' => 'ct_row_background_animation',
    'class'    => 'ct-icon-element',
    'description' => esc_html__( 'Row Background Animation Displayed', 'lawsight' ),
    'category' => esc_html__('CaseThemes Shortcodes', 'lawsight'),
    'params' => array(

        array(
            'type' => 'attach_image',
            'heading' => esc_html__( 'Icon Image', 'lawsight' ),
            'param_name' => 'image_animation',
            'value' => '',
            'description' => esc_html__( 'Select icon image from media library.', 'lawsight' ),
        ),
    )
));

class WPBakeryShortCode_ct_row_background_animation extends CmsShortCode
{

    protected function content($atts, $content = null)
    {
        return parent::content($atts, $content);
    }
}

?>