<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <!-- Bless the Maker and His water. Bless the coming and going of Him. May His passage cleanse the world. May He keep the world for His people. -->
    <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <?php $paged = (get_query_var('paged')) ? get_query_var('paged') : 1; ?>
    <title>
        <?php 
            if ($paged > 1) { 
                echo 'Page ' . $paged . ' | '; 
                echo bloginfo('name');
            } else {
                wp_title('|', true, 'right'); 
                echo bloginfo('name');
            } 
        ?>
    </title>
    <link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro|Source+Code+Pro" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri(); ?>/prettify.css" />
    <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
    <link rel="icon" type="image/png" href="<?php echo get_stylesheet_directory_uri(); ?>/img/icon.png" />
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>  onload="prettyPrint()">
    <div class="site-container">
        <div class="left-wrap">
            <div class="content">
                <header>
                    <ul class="title">
                        <?php split_title(get_bloginfo('name')); ?>
                    </ul>
                    <?php get_search_form(); ?>
                </header>
                <?php get_sidebar(); ?>
            </div>
        </div>