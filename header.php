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
<body <?php body_class(); ?>  onload="prettyPrint()">
    <div id="main">
        <div id="header">
            <div class="mask">
                <div class="interior">
                    <h3><a title="Go home" href="<?php echo site_url(); ?>"><?php echo get_bloginfo('name'); ?></a></h3>
                    <div class="description">
                        <p><?php echo get_bloginfo('description'); ?></p>
                        <nav class="menu">
                            <?php if (has_nav_menu('sidebar')) {
                                wp_nav_menu(array(
                                    'menu_id' => 'sidebar',
                                    'sort_column' => 'menu_order'
                                ));
                            } else {
                                printf('<p class="menu-warn">Please set your sidebar navigation menu in the <a href="%s">Appearance menu!</a></p>', get_admin_url() . 'nav-menus.php');
                            } ?>
                            <div class="nav-search">
                                <?php get_search_form(); ?>
                            </div>
                        </nav>
                    </div>
                    <nav class="social">
                        <ul>
                            <li class="email"><a title="" href="mailto:mark@bhalash.com"></a></li>
                            <li class="twitter"><a title="" href="//www.twitter.com/bhalash"></a></li>
                            <li class="github"><a title="" href="//www.github.com/bhalash"></a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <div id="content">
            <div class="interior">