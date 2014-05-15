<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<!-- Bless the Maker and His water. Bless the coming and going of Him. May His passage cleanse the world. May He keep the world for His people. -->
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php wp_title('&laquo;', true, 'right'); bloginfo('name'); ?></title>
<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<link rel="icon" type="image/png" href="<?php echo get_stylesheet_directory_uri(); ?>/img/icon.png" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <div class="site-container">
        <div class="content-left">
            <div class="content-left-interior">
                <header>
                    <ul>
                        <li class="header-title-inset"><a href="<?php echo home_url(); ?>/">Real</a></li>
                        <li><a href="<?php echo home_url(); ?>/">Men</a></li>
                        <li class="header-title-inset"><a href="<?php echo home_url(); ?>/">Wear</a></li>
                        <li><a href="<?php echo home_url(); ?>/">Beards</a></li>
                    </ul>
                </header>
                <ul class="social">
                    <li><a class="social-widget" id="twitter" title="Follow @bhalash on Twitter" href="http://www.twitter.com/bhalash"></a></li>
                    <li><a class="social-widget" id="facebook" title="Contact Mark on Facebook" href="http://www.facebook.com/bhalash"></a></li>
                    <li><a class="social-widget" id="instagram" title="Follow @bhalash on Instagram" href="http://www.instagram.com/bhalash"></a></li>
                    <li><a class="social-widget" id="github" title="Friend Bhalash on GitHub" href="http://www.github.com/bhalash"></a></li>
                </ul>
                <form action="<?php echo get_site_url(); ?>" class="sidebar-search" method="get">
                    <p>
                        <input class="search-input" id="s" name="s" placeholder="Search RMWB" tabindex="1" type="text" />
                        <input class="search-submit" type="submit" value="" />
                    </p>
                </form>
                <?php get_sidebar(); ?>
            </div>
        </div> 