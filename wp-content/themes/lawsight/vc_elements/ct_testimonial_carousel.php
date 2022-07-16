<?php
$args = array(
    'name' => 'Testimonial Carousel',
    'base' => 'ct_testimonial_carousel',
    'class'    => 'ct-icon-element',
    'description' => esc_html__( 'Testimonial Displayed', 'lawsight' ),
    'category' => esc_html__('CaseThemes Shortcodes', 'lawsight'),
    'params' => array(

        /* Template */
        array(
            'type' => 'cms_template_img',
            'param_name' => 'cms_template',
            'shortcode' => 'ct_testimonial_carousel',
            'heading' => esc_html__('Shortcode Template', 'lawsight'),
            'admin_label' => true,
            'group' => esc_html__('Template', 'lawsight'),
            'std' => 'ct_testimonial_carousel.php'
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
            'heading' => esc_html__( 'Testimonial Item', 'lawsight' ),
            'value' => '',
            'param_name' => 'testimonial_item',
            'dependency' => array(
                'element'=>'cms_template',
                'value'=>array(
                    'ct_testimonial_carousel.php',
                    'ct_testimonial_carousel--layout2.php',
                    'ct_testimonial_carousel--layout3.php',
                )
            ),
            'params' => array(
                array(
                    'type' => 'textfield',
                    'heading' =>esc_html__('Title', 'lawsight'),
                    'param_name' => 'title',
                    'admin_label' => true,
                ),
                array(
                    'type' => 'textfield',
                    'heading' =>esc_html__('Position', 'lawsight'),
                    'param_name' => 'position',

                ),
                array(
                    'type' => 'textarea',
                    'heading' => esc_html__('Content', 'lawsight'),
                    'param_name' => 'content',
                ),
                array(
                    'type' => 'attach_image',
                    'heading' => esc_html__( 'Image', 'lawsight' ),
                    'param_name' => 'image',
                    'value' => '',
                    'description' => esc_html__( 'Select image from media library.', 'lawsight' ),
                ),
            ),
        ),

    ));

$args = lawsight_add_vc_extra_param($args);
vc_map($args);

class WPBakeryShortCode_ct_testimonial_carousel extends CmsShortCode
{

    protected function content($atts, $content = null)
    {
        return parent::content($atts, $content);
    }
}

?>