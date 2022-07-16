<?php
/**
 * The template for displaying the footer.
 * Contains the closing of the #content div and all content after.
 *
 * @package LawSight
 */
$back_totop_on = lawsight_get_opt('back_totop_on', true); ?>

		</div><!-- #content inner -->
	</div><!-- #content -->

	<?php lawsight_footer(); ?>
	
	<?php lawsight_popup_search(); ?>
	
	<?php lawsight_hidden_sidebar(); ?>

	<?php if (isset($back_totop_on) && $back_totop_on) : ?>
	    <a href="#" class="ct-scroll-top">
	    	<i class="ti-angle-up"></i>
	    </a>
	<?php endif; ?>

	</div><!-- #page -->
	
	<?php echo lawsight_get_opt( 'site_footer_code', '' ); ?>
	
	<?php wp_footer(); ?>
	
	</body>
</html>
