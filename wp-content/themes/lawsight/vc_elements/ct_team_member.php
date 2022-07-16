<?php
vc_map(
    array(
        'name'     => esc_html__('Team Member', 'lawsight'),
        'base'     => 'ct_team_member',
        'class'    => 'ct-icon-element',
        'description' => esc_html__( 'Team Member Displayed', 'lawsight' ),
        'category' => esc_html__('CaseThemes Shortcodes', 'lawsight'),
        'params'   => array(

            array(
                'type' => 'cms_template_img',
                'param_name' => 'cms_template',
                'shortcode' => 'ct_team_member',
                'heading' => esc_html__('Shortcode Template', 'lawsight'),
                'admin_label' => true,
                'std' => 'ct_team_member.php',
                'group' => esc_html__('Template', 'lawsight'),
            ),
            
            /* Source Settings */
            array(
                'type' => 'textfield',
                'heading' =>esc_html__('Title', 'lawsight'),
                'param_name' => 'title',
                'admin_label' => true,
                'group' => esc_html__('Source Settings', 'lawsight'),
            ),
            array(
                'type' => 'textfield',
                'heading' =>esc_html__('Position', 'lawsight'),
                'param_name' => 'position',
                'group' => esc_html__('Source Settings', 'lawsight'),
            ),
            array(
                'type' => 'attach_image',
                'heading' => esc_html__( 'Image', 'lawsight' ),
                'param_name' => 'image',
                'value' => '',
                'description' => esc_html__( 'Select image from media library.', 'lawsight' ),
                'group' => esc_html__('Source Settings', 'lawsight'),
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__( 'Image size', 'lawsight' ),
                'param_name' => 'img_size',
                'value' => '',
                'description' => esc_html__( "Enter image size (Example: 'thumbnail', 'medium', 'large', 'full' or other sizes defined by theme). Alternatively enter size in pixels (Example: 200x100 (Width x Height).", "lawsight" ),
                'group'      => esc_html__('Source Settings', 'lawsight'),
            ),
            array(
                'type' => 'vc_link',
                'class' => '',
                'heading' => esc_html__('Link', 'lawsight'),
                'param_name' => 'item_link',
                'value' => '',
                'group' => esc_html__('Source Settings', 'lawsight')
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
                "group" => esc_html__("Extra", 'lawsight'),
            ),
        )
    )
);

class WPBakeryShortCode_ct_team_member extends CmsShortCode
{
    protected function content($atts, $content = null)
    {
        return parent::content($atts, $content);
    }
}

?>