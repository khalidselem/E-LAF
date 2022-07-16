<?php
extract(shortcode_atts(array(
    'id'        => '',
    'animation' => '',
    'styles'  => 'style1',
    'title'  => '',
    'description'  => '',
    'el_class'  => '',
), $atts));
$animation_tmp = isset($animation) ? $animation : '';
$animation_classes = $this->getCSSAnimation( $animation_tmp );
if(class_exists('WPCF7')) { ?>
    <div class="ct-contact-form-default <?php echo esc_attr( $el_class.' '.$animation_classes.' '.$styles )?>">
        <div class="ct-contact-form-inner">
        	<?php if($styles == 'style3') : ?>
        		<div class="ct-contact-form-meta">
		        	<h3><?php echo wp_kses_post($title); ?></h3>
		        	<span><?php echo wp_kses_post($description); ?></span>
		        </div>
	        <?php endif; ?>
            <?php echo do_shortcode('[contact-form-7 id="'.esc_attr( $id ).'"]'); ?>
        </div>
    </div>
<?php } ?>