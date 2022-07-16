<?php
vc_map(array(
    'name' => 'Video Player',
    'base' => 'ct_video_player',
    'class'    => 'ct-icon-element',
    'description' => 'Embed Youtube/Vimeo player',
    'category' => esc_html__('CaseThemes Shortcodes', 'lawsight'),
    'params' => array(

        array(
            'type' => 'vc_link',
            'heading' => esc_html__( 'Video Url', 'lawsight' ),
            'param_name' => 'video_link',
            'value' => 'https://www.youtube.com/watch?v=SF4aHwxHtZ0',
            'description' => 'Video url on Youtube, Vimeo'
        ),
        array(
            'type' => 'attach_image',
            'heading' => esc_html__( 'Video Intro', 'lawsight' ),
            'param_name' => 'video_intro',
            'value' => '',
            'description' => esc_html__( 'Select icon image from media library.', 'lawsight' ),
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__('Video Button Styles', 'lawsight'),
            'param_name' => 'btn_styles',
            'value' => array(
                'Style 1' => 'style1',
                'Style 2' => 'style2',
            ),
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__('Intro Styles', 'lawsight'),
            'param_name' => 'intro_styles',
            'value' => array(
                'Style 1' => 'style1',
                'Style 2' => 'style2',
            ),
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Intro Size', 'lawsight' ),
            'param_name' => 'intro_size',
            'value' => '',
            'description' => esc_html__( 'Enter image size (Example: "thumbnail", "medium", "large", "full" or other sizes defined by theme). Alternatively enter size in pixels (Example: 200x100 (Width x Height).', 'lawsight' ),
        ),

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

class WPBakeryShortCode_ct_video_player extends CmsShortCode
{

    protected function content($atts, $content = null)
    {
        return parent::content($atts, $content);
    }
}

?>