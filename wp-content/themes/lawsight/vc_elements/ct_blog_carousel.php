<?php
$term_list = cms_get_grid_term_list('post');
$args = array(
    'name' => 'Blog Carousel',
    'base' => 'ct_blog_carousel',
    'class' => 'ct-icon-element',
    'description' => esc_html__( 'Post in Carousel', 'lawsight' ),
    'category' => esc_html__('CaseThemes Shortcodes', 'lawsight'),
    'params' => array(

        array(
            'type' => 'cms_template_img',
            'param_name' => 'cms_template',
            'shortcode' => 'ct_blog_carousel',
            'heading' => esc_html__('Shortcode Template', 'lawsight'),
            'admin_label' => true,
            'std' => 'ct_blog_carousel.php',
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
            'type'       => 'checkbox',
            'heading'    => esc_html__('Custom Source', 'lawsight'),
            'param_name' => 'custom_source',
            'value'      => '1',
            'description'        => 'Check here if you want custom source',
            'group'      => esc_html__('Source Settings', 'lawsight')
        ),
        array(
            'type'       => 'autocomplete',
            'heading'    => esc_html__('Select Categories', 'lawsight'),
            'param_name' => 'source',
            'description' => esc_html__('Leave blank to select all category', 'lawsight'),
            'settings'   => array(
                'multiple' => true,
                'values'   => $term_list['auto_complete'],
            ),
            'dependency' => array(
                'element'=>'custom_source',
                'value'=>array(
                    'true',
                )
            ),
            'group'      => esc_html__('Source Settings', 'lawsight'),
        ),
        array(
            'type'       => 'autocomplete',
            'class'      => '',
            'heading'    => esc_html__('Select Post Name', 'lawsight'),
            'param_name' => 'post_ids',
            'description' => esc_html__('Leave blank to show all post', 'lawsight'),
            'settings'   => array(
                'multiple' => true,
                'values'   => cms_get_type_posts_data('post')
            ),
            'dependency' => array(
                'element'=>'custom_source',
                'value'=>array(
                    'true',
                )
            ),
            'group'      => esc_html__('Source Settings', 'lawsight'),
        ),
        array(
            'type'       => 'dropdown',
            'heading'    => esc_html__('Order by', 'lawsight'),
            'param_name' => 'orderby',
            'value'      => array(
                'Date'   => 'date',
                'ID'     => 'ID',
                'Author' => 'author',
                'Title'  => 'title',
                'Random' => 'rand',
            ),
            'std'        => 'date',
            'group'      => esc_html__('Source Settings', 'lawsight')
        ),
        array(
            'type'       => 'dropdown',
            'heading'    => esc_html__('Sort order', 'lawsight'),
            'param_name' => 'order',
            'value'      => array(
                'Ascending'  => 'ASC',
                'Descending' => 'DESC',
            ),
            'std'        => 'DESC',
            'group'      => esc_html__('Source Settings', 'lawsight')
        ),
        array(
            'type'       => 'textfield',
            'heading'    => esc_html__('Total items', 'lawsight'),
            'param_name' => 'limit',
            'value'      => '6',
            'group'      => esc_html__('Source Settings', 'lawsight'),
            'description' => esc_html__('Set max limit for items in carousel. Enter number only', 'lawsight'),
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Image Size', 'lawsight' ),
            'param_name' => 'img_size',
            'value' => '',
            'description' => esc_html__( "Enter image size (Example: 'thumbnail', 'medium', 'large', 'full' or other sizes defined by theme). Alternatively enter size in pixels (Example: 200x100 (Width x Height).", 'lawsight' ),
            'group'      => esc_html__('Source Settings', 'lawsight')
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Readmore Text', 'lawsight' ),
            'param_name' => 'readmore_text',
            'value' => '',
            'description' => esc_html__( "Default: View more", 'lawsight' ),
            'group'      => esc_html__('Source Settings', 'lawsight')
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__('Readmore Button Style', 'lawsight'),
            'param_name' => 'btn_style',
            'value' => array(
                'Button Gray' => 'btn-gray',
                'Button Dark' => 'btn-dark',
            ),
            'group' => esc_html__('Source Settings', 'lawsight'),
        ),
    ));

$args = lawsight_add_vc_extra_param($args);
vc_map($args);

class WPBakeryShortCode_ct_blog_carousel extends CmsShortCode
{

    protected function content($atts, $content = null)
    {
        $html_id = cmsHtmlID('ct-blog-carousel');
        $atts['html_id'] = $html_id;
        return parent::content($atts, $content);
    }
}

?>