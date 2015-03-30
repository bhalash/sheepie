<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <!-- Bless the Maker and His water. Bless the coming and going of Him. May His passage cleanse the world. May He keep the world for His people. -->
    <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <?php $paged = (get_query_var('paged')) ? get_query_var('paged') : 1; ?>
    <?php // FIXME ?>
    <title><?php bloginfo('name'); ?> | <?php is_front_page() ? bloginfo('description') : wp_title(''); ?></title>
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
    <link rel="icon" type="image/png" href="<?php echo get_stylesheet_directory_uri(); ?>/images/favicon.png" />
    <?php social_meta(); ?>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <nav id="top-menu">
        <?php wp_nav_menu(array('theme_location' => 'top-menu')); ?>
    </nav>
    <div id="main">
        <div id="header">
            <?php // Header navigation. 
            global $wp_query;
            ?>
            <div id="titles">
                <h2>
                    <?php if (!is_single() && !is_search()) {
                        // If is index page.
                        printf('<a title="%s" href="%s">%s</a>', __('Go home'), get_bloginfo('url'), get_bloginfo('name')); 
                    } else if (is_search()) {
                        // Else if is search page.
                        printf('%s \'%s\'', __('Results for'), get_search_query()); 
                    } else {
                        // Else if is single article (probably).
                        printf(
                            '<a href="%s" rel="bookmark" title="%s %s">%s</a>',
                            get_the_permalink(),
                            __('Permanent link to'), 
                            get_the_title(), 
                            get_the_title()
                        );
                    } ?>
                </h2>
                <p>
                    <?php if (!is_single() && !is_search()) {
                        bloginfo('description');
                    } else if (is_search()) {
                        printf('%s', search_results_count(get_query_var('paged'), $wp_query->found_posts));
                    } else { ?>
                        <time datetime="<?php the_time('Y-m-d H:i'); ?>"><?php the_time(get_option('date_format')) ?></time> <?php echo __('in'); ?> <?php the_category(', '); edit_post_link(__('edit post'), ' / ', ''); ?>
                    <?php }; ?>
                </p>
                <nav id="top-social">
                    <?php wp_nav_menu(array('theme_location' => 'top-social')); ?>
                </nav>
            </div>
        </div>
        <div id="content">
            <div class="content">