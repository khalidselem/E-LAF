<?php
vc_map(array(
    'name' => 'Heading',
    'base' => 'ct_heading',
    'class'    => 'ct-icon-element',
    'description' => esc_html__( 'Heading Displayed', 'lawsight' ),
    'category' => esc_html__('CaseThemes Shortcodes', 'lawsight'),
    'params' => array(
        array(
            'type' => 'dropdown',
            'heading' => esc_html__('Styles', 'lawsight'),
            'param_name' => 'styles',
            'value' => array(
                'Style Default' => 'style1',
                'Style Modern' => 'style2',
            ),
            'group' => esc_html__('Title', 'lawsight'),
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__('Text Source', 'lawsight'),
            'param_name' => 'text_source',
            'value' => array(
                'Custom Text' => 'custom-text',
                'Post or Page Title' => 'post-page-title',
            ),
            'admin_label' => true,
            'group' => esc_html__('Title', 'lawsight'),
        ),
        array(
            'type' => 'textarea',
            'heading' => esc_html__( 'Text', 'lawsight' ),
            'param_name' => 'text',
            'value' => '',
            'admin_label' => true,
            'dependency' => array(
                'element'=>'text_source',
                'value'=>array(
                    'custom-text',
                )
            ),
            'group' => esc_html__('Title', 'lawsight'),
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__('Element tag', 'lawsight'),
            'param_name' => 'tag',
            'value' => array(
                'h1' => 'h1',
                'h2' => 'h2',
                'h3' => 'h3',
                'h4' => 'h4',
                'h5' => 'h5',
                'h6' => 'h6',
                'p' => 'p',
                'div' => 'div',
            ),
            'std' => 'h3',
            'group' => esc_html__('Title', 'lawsight'),
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__('Text align large', 'lawsight'),
            'param_name' => 'align_lg',
            'value' => array(
                'left' => 'align-left',
                'right' => 'align-right',
                'center' => 'align-center',
            ),
            'edit_field_class' => 'vc_col-sm-3 vc_column',
            'group' => esc_html__('Title', 'lawsight'),
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__('Text align medium', 'lawsight'),
            'param_name' => 'align_md',
            'value' => array(
                'left' => 'align-left-md',
                'right' => 'align-right-md',
                'center' => 'align-center-md',
            ),
            'edit_field_class' => 'vc_col-sm-3 vc_column',
            'group' => esc_html__('Title', 'lawsight'),
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__('Text align small', 'lawsight'),
            'param_name' => 'align_sm',
            'value' => array(
                'left' => 'align-left-sm',
                'right' => 'align-right-sm',
                'center' => 'align-center-sm',
            ),
            'edit_field_class' => 'vc_col-sm-3 vc_column',
            'group' => esc_html__('Title', 'lawsight'),
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__('Text align mini', 'lawsight'),
            'param_name' => 'align_xs',
            'value' => array(
                'left' => 'align-left-xs',
                'right' => 'align-right-xs',
                'center' => 'align-center-xs',
            ),
            'edit_field_class' => 'vc_col-sm-3 vc_column',
            'group' => esc_html__('Title', 'lawsight'),
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__('Margin top', 'lawsight'),
            'param_name' => 'margin_top',
            'description' => 'Enter number.',
            'edit_field_class' => 'vc_col-sm-3 vc_column',
            'group' => esc_html__('Title', 'lawsight'),
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__('Margin right', 'lawsight'),
            'param_name' => 'margin_right',
            'description' => 'Enter number.',
            'edit_field_class' => 'vc_col-sm-3 vc_column',
            'group' => esc_html__('Title', 'lawsight'),
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__('Margin bottom', 'lawsight'),
            'param_name' => 'margin_bottom',
            'description' => 'Enter number.',
            'edit_field_class' => 'vc_col-sm-3 vc_column',
            'group' => esc_html__('Title', 'lawsight'),
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__('Margin left', 'lawsight'),
            'param_name' => 'margin_left',
            'description' => 'Enter number.',
            'edit_field_class' => 'vc_col-sm-3 vc_column',
            'group' => esc_html__('Title', 'lawsight'),
        ),

        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Font size large', 'lawsight' ),
            'param_name' => 'font_size',
            'value' => '',
            'description' => 'Enter number.',
            'edit_field_class' => 'vc_col-sm-3 vc_column',
            'group' => esc_html__('Title', 'lawsight'),
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Font size medium', 'lawsight' ),
            'param_name' => 'font_size_md',
            'value' => '',
            'description' => 'Enter number.',
            'edit_field_class' => 'vc_col-sm-3 vc_column',
            'group' => esc_html__('Title', 'lawsight'),
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Font size small', 'lawsight' ),
            'param_name' => 'font_size_sm',
            'value' => '',
            'description' => 'Enter number.',
            'edit_field_class' => 'vc_col-sm-3 vc_column',
            'group' => esc_html__('Title', 'lawsight'),
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Font size mini', 'lawsight' ),
            'param_name' => 'font_size_xs',
            'value' => '',
            'description' => 'Enter number.',
            'edit_field_class' => 'vc_col-sm-3 vc_column',
            'group' => esc_html__('Title', 'lawsight'),
        ),

        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Line height large', 'lawsight' ),
            'param_name' => 'line_height',
            'value' => '',
            'description' => 'Enter number.',
            'edit_field_class' => 'vc_col-sm-3 vc_column',
            'group' => esc_html__('Title', 'lawsight'),
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Line height medium', 'lawsight' ),
            'param_name' => 'line_height_md',
            'value' => '',
            'description' => 'Enter number.',
            'edit_field_class' => 'vc_col-sm-3 vc_column',
            'group' => esc_html__('Title', 'lawsight'),
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Line height small', 'lawsight' ),
            'param_name' => 'line_height_sm',
            'value' => '',
            'description' => 'Enter number.',
            'edit_field_class' => 'vc_col-sm-3 vc_column',
            'group' => esc_html__('Title', 'lawsight'),
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Line height mini', 'lawsight' ),
            'param_name' => 'line_height_xs',
            'value' => '',
            'description' => 'Enter number.',
            'edit_field_class' => 'vc_col-sm-3 vc_column',
            'group' => esc_html__('Title', 'lawsight'),
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__('Text Transform', 'lawsight'),
            'param_name' => 'text_transform',
            'value' => array(
                'None' => 'none',
                'Inherit' => 'inherit',
                'Uppercase' => 'uppercase',
                'Capitalize' => 'capitalize',
                'Lowercase' => 'lowercase',
            ),
            'std' => 'none',
            'group' => esc_html__('Title', 'lawsight'),
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__('Font Weight', 'lawsight'),
            'param_name' => 'font_weight',
            'value' => array(
                'Default' => '',
                'Bold 700' => '700',
                'Bold 800' => '800',
                'SemiBold' => '600',
                'Medium' => '500',
                'Normal' => '400',
                'Light' => '300',
            ),
            'std' => 'none',
            'group' => esc_html__('Title', 'lawsight'),
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Letter Spacing', 'lawsight' ),
            'param_name' => 'letter_spacing',
            'value' => '',
            'description' => 'Enter ..px, ..em',
            'group' => esc_html__('Title', 'lawsight'),
        ),
        array(
            'type' => 'colorpicker',
            'heading' => esc_html__('Text Color', 'lawsight'),
            'param_name' => 'text_color',
            'value' => '',
            'group' => esc_html__('Title', 'lawsight'),
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__('Show Gap', 'lawsight'),
            'param_name' => 'show_gap',
            'value' => array(
                'No' => 'hide',
                'Yes' => 'show',
            ),
            'group' => esc_html__('Title', 'lawsight'),
        ),
        array(
            'type' => 'colorpicker',
            'heading' => esc_html__('Gap Color', 'lawsight'),
            'param_name' => 'gap_color',
            'value' => '',
            'group' => esc_html__('Title', 'lawsight'),
            'dependency' => array(
                'element'=>'show_gap',
                'value'=>array(
                    'show',
                )
            ),
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__('Custom Google Fonts', 'lawsight'),
            'param_name' => 'custom_fonts',
            'value' => array(
                'No' => 'false',
                'Yes' => 'true',
            ),
            'group' => esc_html__('Title', 'lawsight'),
        ),
        array(
            'type' => 'google_fonts',
            'param_name' => 'google_fonts',
            'value' => 'font_family:Abril%20Fatface%3Aregular|font_style:400%20regular%3A400%3Anormal',
            'settings' => array(
                'fields' => array(
                    'font_family_description' => esc_html__( 'Select font family.', 'lawsight' ),
                    'font_style_description' => esc_html__( 'Select font styling.', 'lawsight' ),
                ),
            ),
            'dependency' => array(
                'element'=>'custom_fonts',
                'value'=>array(
                    'true',
                )
            ),
            'group' => esc_html__('Title', 'lawsight'),
        ),
        array(
            'type' => 'vc_link',
            'heading' => esc_html__( 'Link for title', 'lawsight' ),
            'param_name' => 'title_link',
            'value' => '',
            'group' => esc_html__('Title', 'lawsight'),
        ),
        
        /* Sub Title */
        array(
            'type' => 'textarea',
            'heading' => esc_html__( 'Sub Title', 'lawsight' ),
            'param_name' => 'subtitle',
            'value' => '',
            'group'      => esc_html__('Sub Title', 'lawsight'),
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Font Size', 'lawsight' ),
            'param_name' => 'subtitle_font_size',
            'value' => '',
            'description' => 'Enter number.',
            'group'      => esc_html__('Sub Title', 'lawsight'),
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Line Height', 'lawsight' ),
            'param_name' => 'subtitle_line_height',
            'value' => '',
            'description' => 'Enter number.',
            'group'      => esc_html__('Sub Title', 'lawsight'),
        ),
        array(
            'type' => 'colorpicker',
            'heading' => esc_html__('Color', 'lawsight'),
            'param_name' => 'subtitle_color',
            'value' => '',
            'group'      => esc_html__('Sub Title', 'lawsight'),
        ),
        /* Sub Title */
        array(
            'type' => 'textarea',
            'heading' => esc_html__( 'Description', 'lawsight' ),
            'param_name' => 'description',
            'value' => '',
            'group'      => esc_html__('Description', 'lawsight'),
        ),
        array(
            'type' => 'colorpicker',
            'heading' => esc_html__('Color', 'lawsight'),
            'param_name' => 'description_color',
            'value' => '',
            'group'      => esc_html__('Description', 'lawsight'),
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__('Font Weight', 'lawsight'),
            'param_name' => 'description_font_weight',
            'value' => array(
                'Default' => 'inherit',
                'Bold 700' => '700',
                'Bold 800' => '800',
                'SemiBold' => '600',
                'Medium' => '500',
                'Normal' => '400',
                'Light' => '300',
            ),
            'std' => 'none',
            'group' => esc_html__('Description', 'lawsight'),
        ),
        /* Extra */
        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Extra class name', 'lawsight' ),
            'param_name' => 'el_class',
            'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in Custom CSS.', 'lawsight' ),
            'group'      => esc_html__('Extra', 'lawsight'),
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

class WPBakeryShortCode_ct_heading extends CmsShortCode
{

    protected function content($atts, $content = null)
    {
        $html_id = cmsHtmlID('ct-heading');
        $atts['html_id'] = $html_id;
        return parent::content($atts, $content);
    }
}

?>