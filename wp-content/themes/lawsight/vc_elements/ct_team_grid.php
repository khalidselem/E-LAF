<?php
vc_map(
    array(
        'name'     => esc_html__('Team Grid', 'lawsight'),
        'base'     => 'ct_team_grid',
        'class'    => 'ct-icon-element',
        'description' => esc_html__( 'Team Displayed', 'lawsight' ),
        'category' => esc_html__('CaseThemes Shortcodes', 'lawsight'),
        'params'   => array(
            array(
                'type' => 'cms_template_img',
                'param_name' => 'cms_template',
                'shortcode' => 'ct_team_grid',
                'heading' => esc_html__('Shortcode Template', 'lawsight'),
                'admin_label' => true,
                'std' => 'ct_team_grid.php',
                'group' => esc_html__('Template', 'lawsight'),
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__( 'Extra class name', 'lawsight' ),
                'param_name' => 'el_class',
                'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in Custom CSS.', 'lawsight' ),
                'group'            => esc_html__('Template', 'lawsight')
            ),

            array(
                'type' => 'param_group',
                'heading' => esc_html__( 'Content', 'lawsight' ),
                'param_name' => 'content_list',
                'description' => esc_html__( 'Enter values for team item', 'lawsight' ),
                'value' => '',
                'group' => esc_html__('Source Settings', 'lawsight'),
                'params' => array(
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
                        'heading' =>esc_html__('Title', 'lawsight'),
                        'param_name' => 'title',
                        'admin_label' => true,
                        'group' => esc_html__('Source Settings', 'lawsight'),
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' =>esc_html__('Position', 'lawsight'),
                        'param_name' => 'position',
                        'admin_label' => true,
                        'group' => esc_html__('Source Settings', 'lawsight'),
                    ),
                    array(
                        'type' => 'vc_link',
                        'class' => '',
                        'heading' => esc_html__('Link', 'lawsight'),
                        'param_name' => 'item_link',
                        'value' => '',
                        'group' => esc_html__('Source Settings', 'lawsight')
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' =>esc_html__('Contact Label', 'lawsight'),
                        'param_name' => 'content_label',
                        'admin_label' => true,
                        'group' => esc_html__('Source Settings', 'lawsight'),
                    ),
                    array(
                        'type' => 'param_group',
                        'heading' => esc_html__( 'Social', 'lawsight' ),
                        'param_name' => 'social',
                        'description' => esc_html__( 'Enter values for team social', 'lawsight' ),
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
                                'param_name' => 'social_link',
                                'admin_label' => true,
                            ),
                        ),
                    ),
                ),
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__( 'Image size', 'lawsight' ),
                'param_name' => 'img_size',
                'value' => '',
                'description' => esc_html__( "Enter image size (Example: 'thumbnail', 'medium', 'large', 'full' or other sizes defined by theme). Alternatively enter size in pixels (Example: 200x100 (Width x Height).", 'lawsight' ),
                'group'      => esc_html__('Source Settings', 'lawsight')
            ),
            array(
                'type' => 'colorpicker',
                'heading' => esc_html__('Title Color', 'lawsight'),
                'param_name' => 'title_color',
                'value' => '',
                'group' => esc_html__('Source Settings', 'lawsight'),
            ),
            array(
                'type' => 'colorpicker',
                'heading' => esc_html__('Position Color', 'lawsight'),
                'param_name' => 'position_color',
                'value' => '',
                'group' => esc_html__('Source Settings', 'lawsight'),
            ),
            array(
                "type"             => "dropdown",
                "heading"          => esc_html__( "Columns XS", 'lawsight' ),
                "param_name"       => "col_xs",
                "edit_field_class" => "ct-col-5",
                "value"            => array( 1, 2, 3, 4 ),
                "std"              => 1,
                "group"            => 'Column Settings',
            ),
            array(
                "type"             => "dropdown",
                "heading"          => esc_html__( "Columns SM", 'lawsight' ),
                "param_name"       => "col_sm",
                "edit_field_class" => "ct-col-5",
                "value"            => array( 1, 2, 3, 4 ),
                "std"              => 2,
                "group"            => 'Column Settings',
            ),
            array(
                "type"             => "dropdown",
                "heading"          => esc_html__( "Columns MD", 'lawsight' ),
                "param_name"       => "col_md",
                "edit_field_class" => "ct-col-5",
                "value"            => array( 1, 2, 3, 4, 5 ),
                "std"              => 3,
                "group"            => 'Column Settings',
            ),
            array(
                "type"             => "dropdown",
                "heading"          => esc_html__( "Columns LG", 'lawsight' ),
                "param_name"       => "col_lg",
                "edit_field_class" => "ct-col-5",
                "value"            => array( 1, 2, 3, 4, 5, 6 ),
                "std"              => 4,
                "group"            => 'Column Settings',
            ),
            array(
                "type"             => "dropdown",
                "heading"          => esc_html__( "Columns XL", 'lawsight' ),
                "param_name"       => "col_xl",
                "edit_field_class" => "ct-col-5",
                "value"            => array( 1, 2, 3, 4, 5, 6 ),
                "std"              => 4,
                "group"            => 'Column Settings',
            ),
        )
    )
);

class WPBakeryShortCode_ct_team_grid extends CmsShortCode
{
    protected function content($atts, $content = null)
    {
        $html_id = cmsHtmlID('cms-grid-team');
        $atts['html_id'] = $html_id;
        return parent::content($atts, $content);
    }
}

?>