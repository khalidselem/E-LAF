<?php
$term_list = cms_get_grid_term_list('service');
$args = array(
    'name' => 'Services Carousel',
    'base' => 'ct_service_carousel',
    'class' => 'ct-icon-element',
    'description' => esc_html__( 'Services in Carousel', 'lawsight' ),
    'category' => esc_html__('CaseThemes Shortcodes', 'lawsight'),
    'params' => array(

        array(
            'type' => 'cms_template_img',
            'param_name' => 'cms_template',
            'shortcode' => 'ct_service_carousel',
            'heading' => esc_html__('Shortcode Template', 'lawsight'),
            'admin_label' => true,
            'std' => 'ct_service_carousel.php',
            'group' => esc_html__('Template', 'lawsight'),
        ),

        array(
            'type'       => 'dropdown',
            'heading'    => esc_html__('Overlay Color', 'lawsight'),
            'param_name' => 'overlay_color',
            'value'      => array(
                'Primary'   => 'overlay-primary',
                'Secondary'   => 'overlay-secondary',
            ),
            'std'        => 'overlay-primary',
            'group'      => esc_html__('Template', 'lawsight'),
            'dependency' => array(
                'element'=>'cms_template',
                'value'=>array(
                    'ct_service_carousel--layout2.php',
                )
            ),
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
                'values'   => cms_get_type_posts_data('service')
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
            'type'       => 'textfield',
            'heading'    => esc_html__('Except Length', 'lawsight'),
            'param_name' => 'except_length',
            'value'      => '',
            'group'      => esc_html__('Source Settings', 'lawsight'),
        ),
        array(
            'type' => 'param_group',
            'heading' => esc_html__( 'Icons', 'lawsight' ),
            'value' => '',
            'param_name' => 'service_icon',
            'group'      => esc_html__('Source Settings', 'lawsight'),
            'params' => array(
                array(
                    'type' => 'dropdown',
                    'heading' => esc_html__('Icon Type', 'lawsight'),
                    'param_name' => 'icon_type',
                    'value' => array(
                        'Icon' => 'icon',
                        'Image' => 'image',
                    ),
                    'group' => esc_html__('Icon', 'lawsight'),
                ),
                array(
                    'type' => 'attach_image',
                    'heading' => esc_html__( 'Icon Image', 'lawsight' ),
                    'param_name' => 'icon_image',
                    'value' => '',
                    'description' => esc_html__( 'Select icon image from media library.', 'lawsight' ),
                    'dependency' => array(
                        'element'=>'icon_type',
                        'value'=>array(
                            'image',
                        )
                    ),
                    'group' => esc_html__('Icon', 'lawsight'),
                ),
                array(
                    'type' => 'dropdown',
                    'heading' => esc_html__( 'Icon Library', 'lawsight' ),
                    'value' => array(
                        esc_html__( 'Font Awesome', 'lawsight' ) => 'fontawesome',
                        esc_html__( 'Material Design', 'lawsight' ) => 'material_design',
                        esc_html__( 'Flaticon', 'lawsight' ) => 'flaticon',
                        esc_html__( 'ET Line', 'lawsight' ) => 'etline',
                    ),
                    'param_name' => 'icon_list',
                    'description' => esc_html__( 'Select icon library.', 'lawsight' ),
                    'dependency' => array(
                        'element' => 'icon_type',
                        'value' => 'icon',
                    ),
                    'group' => esc_html__('Icon', 'lawsight'),
                ),
                array(
                    'type' => 'iconpicker',
                    'heading' => esc_html__( 'Icon Material', 'lawsight' ),
                    'param_name' => 'icon_material_design',
                    'settings' => array(
                        'emptyIcon' => true,
                        'type' => 'material-design',
                        'iconsPerPage' => 200,
                    ),
                    'dependency' => array(
                        'element' => 'icon_list',
                        'value' => 'material_design',
                    ),
                    'description' => esc_html__( 'Select icon from library.', 'lawsight' ),
                    'group' => esc_html__('Icon', 'lawsight'),
                ),
                array(
                    'type' => 'iconpicker',
                    'heading' => esc_html__( 'Icon FontAwesome', 'lawsight' ),
                    'param_name' => 'icon_fontawesome',
                    'value' => '',
                    'settings' => array(
                        'emptyIcon' => true,
                        'type' => 'fontawesome',
                        'iconsPerPage' => 200,
                    ),
                    'dependency' => array(
                        'element' => 'icon_list',
                        'value' => 'fontawesome',
                    ),
                    'description' => esc_html__( 'Select icon from library.', 'lawsight' ),
                    'group' => esc_html__('Icon', 'lawsight'),
                    'admin_label' => true,
                ),  
                array(
                    'type' => 'iconpicker',
                    'heading' => esc_html__( 'Flaticon', 'lawsight' ),
                    'param_name' => 'icon_flaticon',
                    'settings' => array(
                        'emptyIcon' => true,
                        'type' => 'flaticon',
                        'iconsPerPage' => 200,
                    ),
                    'dependency' => array(
                        'element' => 'icon_list',
                        'value' => 'flaticon',
                    ),
                    'description' => esc_html__( 'Select icon from library.', 'lawsight' ),
                    'group' => esc_html__('Icon', 'lawsight'),
                    'admin_label' => true,
                ),
                array(
                    'type' => 'iconpicker',
                    'heading' => esc_html__( 'Icon ET Line', 'lawsight' ),
                    'param_name' => 'icon_etline',
                    'settings' => array(
                        'emptyIcon' => true,
                        'type' => 'etline',
                        'iconsPerPage' => 200,
                    ),
                    'dependency' => array(
                        'element' => 'icon_list',
                        'value' => 'etline',
                    ),
                    'description' => esc_html__( 'Select icon from library.', 'lawsight' ),
                    'group' => esc_html__('Icon', 'lawsight'),
                    'admin_label' => true,
                ),
            ),
        ),

    ));

$args = lawsight_add_vc_extra_param($args);
vc_map($args);

class WPBakeryShortCode_ct_service_carousel extends CmsShortCode
{

    protected function content($atts, $content = null)
    {
        $html_id = cmsHtmlID('ct-service-carousel');
        $atts['html_id'] = $html_id;
        return parent::content($atts, $content);
    }
}

?>