<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package LawSight
 */

get_header(); 

$subtitle_404_page = lawsight_get_opt( 'subtitle_404_page' );
$title_404_page = lawsight_get_opt( 'title_404_page' );
$btn_text_404_page = lawsight_get_opt( 'btn_text_404_page' );
?>

    <div class="container content-container">
        <div class="row">
            <div id="primary" class="col-12">
                <main id="main" class="site-main">
                    <div class="error404-inner">
                        <h3 class="title-404"><?php if(!empty($title_404_page)) { echo esc_attr($title_404_page); } else { echo esc_html__( 'Opps! Page is not found ', 'lawsight' ); } ?></h3>
                        <div class="h-gap">
                            <span>
                                <i></i>
                                <i></i>
                                <i></i>
                                <i></i>
                            </span>
                        </div>
                        <span class="subtitle-404"><?php if(!empty($subtitle_404_page)) { echo esc_attr($subtitle_404_page); } else { echo esc_html__('Sorry, we can’t seem to find what you’re looking for.', 'lawsight'); } ?></span>
                        <div class="image-404"><img src="<?php echo esc_url(get_template_directory_uri().'/assets/images/image-404.png'); ?>" alt="<?php echo esc_html__('Banner 404', 'lawsight'); ?>" /></div>
                        <a class="btn btn-gradient" href="<?php echo esc_url(home_url('/')); ?>"><?php if(!empty($btn_text_404_page)) { echo esc_attr($btn_text_404_page); } else { echo esc_html__('GO HOME NOW', 'lawsight'); } ?></a>
                    </div>
                </main><!-- #main -->
            </div><!-- #primary -->
        </div>
    </div>

<?php
get_footer();
