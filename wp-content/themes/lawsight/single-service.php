<?php
/**
 * The template for displaying all single service
 *
 * @package LawSight
 */
get_header(); 
$sidebar_pos = 'left';
?>
<div class="container content-container">
    <div class="row content-row">
        <div id="primary" <?php lawsight_primary_class( $sidebar_pos, 'content-area' ); ?>>
            <main id="main" class="site-main">
                <?php

                    while ( have_posts() )
                    {
                        the_post();
                        get_template_part( 'template-parts/content-service/content', get_post_format() );
                    }
                ?>
            </main><!-- #main -->
        </div><!-- #primary -->
        <?php if ( 'left' == $sidebar_pos || 'right' == $sidebar_pos ) : ?>
            <aside id="secondary" <?php lawsight_secondary_class( $sidebar_pos, 'widget-area' ); ?>>
                <?php dynamic_sidebar( 'sidebar-service' ); ?>
            </aside>
        <?php endif; ?>
    </div>
</div>
<?php get_footer();
