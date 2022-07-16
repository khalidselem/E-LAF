<?php
    if(class_exists('WPCF7')) {
        $cf7 = get_posts( 'post_type="wpcf7_contact_form"&numberposts=-1' );

        $contact_forms = array();
        if ( $cf7 ) {
            foreach ( $cf7 as $cform ) {
                $contact_forms[ $cform->post_title ] = $cform->ID;
            }
        } else {
            $contact_forms[ esc_html__( 'No contact forms found', 'lawsight' ) ] = 0;
        }

        vc_map(array(
            'name' => 'Contact Form',
            'base' => 'ct_contact_form',
            'class'    => 'ct-icon-element',
            'description' => esc_html__( 'Contact Form 7', 'lawsight' ),
            'category' => esc_html__('CaseThemes Shortcodes', 'lawsight'),
            'params' => array(

                array(
                    'type' => 'dropdown',
                    'heading' => esc_html__( 'Select Contact Form', 'lawsight' ),
                    'param_name' => 'id',
                    'value' => $contact_forms,
                    'save_always' => true,
                    'admin_label' => true,
                    'description' => esc_html__( 'Choose previously created contact form from the drop down list.', 'lawsight' ),
                ),
                array(
                    'type' => 'dropdown',
                    'heading' => esc_html__('Styles', 'lawsight'),
                    'param_name' => 'styles',
                    'value' => array(
                        'Style 1' => 'style1',
                        'Style 2' => 'style2',
                        'Style 3' => 'style3',
                        'Style 4' => 'style4',
                        'Style 5' => 'style5',
                    ),
                ),
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__('Title', 'lawsight'),
                    'param_name' => 'title',
                    'dependency' => array(
                        'element'=>'styles',
                        'value'=>array(
                            'style3',
                        )
                    ),
                ),
                array(
                    'type' => 'textarea',
                    'heading' => esc_html__('Description', 'lawsight'),
                    'param_name' => 'description',
                    'dependency' => array(
                        'element'=>'styles',
                        'value'=>array(
                            'style3',
                        )
                    ),
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

        class WPBakeryShortCode_ct_contact_form extends CmsShortCode
        {

            protected function content($atts, $content = null)
            {
                return parent::content($atts, $content);
            }
        }
    }
?>