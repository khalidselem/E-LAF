<?php
/**
 * The header for our theme.
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @package LawSight
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <?php echo lawsight_get_opt( 'site_header_code', '' ); ?>
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
    <?php 
    	lawsight_page_loading();
        
        lawsight_header_layout();
        
        lawsight_page_title_layout();
    ?>
    <div id="content" class="site-content">
    	<div class="content-inner">
