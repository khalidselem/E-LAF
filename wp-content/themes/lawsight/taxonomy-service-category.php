<?php
/**
 * The template for displaying Category Service
 *
 * @package LawSight
 */
get_header();
?>

<div class="container content-container">

    <div class="row content-row">
        <div id="primary" class="col-12">
            <main id="main" class="site-main">
                <?php
                    $term = get_term_by( 'slug', get_query_var( 'service-category' ), get_query_var( 'taxonomy' ) );
                    echo apply_filters('the_content','[ct_service_grid cms_template="ct_service_grid--layout2.php" limit="12" img_size="" layout="masonry" filter="false" col_xs="1" col_sm="2" col_md="2" col_lg="3" col_xl="3" source="'.$term->slug.'|service-category"]');
                ?>
            </main><!-- #main -->
        </div><!-- #primary -->

    </div>
</div>

<?php get_footer(); ?>