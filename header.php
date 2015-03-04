<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <!-- Bless the Maker and His water. Bless the coming and going of Him. May His passage cleanse the world. May He keep the world for His people. -->
    <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <?php $paged = (get_query_var('paged')) ? get_query_var('paged') : 1; ?>
    <title><?php wp_title('/', true, 'left'); ?></title>
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
    <link rel="icon" type="image/png" href="<?php echo get_stylesheet_directory_uri(); ?>/images/favicon.png" />
    <?php social_meta(); ?>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <div id="main">
        <?php if (!is_single()) : ?>
            <div <?php printf('%s', (get_query_var('paged') < 2) ? 'class="full-height"' : ''); ?> id="header">
                <div class="mask">
                    <div class="interior">
                        <h1><a title="Go home" href="<?php echo site_url(); ?>"><?php echo get_bloginfo('name'); ?></a></h1>
                        <div class="description">
                            <h4><?php echo get_bloginfo('description'); ?></h4>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <div id="content">
            <div class="interior">