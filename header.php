<?php

/**
 * PHP Header File
 * -----------------------------------------------------------------------------
 * @category   PHP Script
 * @package    Sheepie
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2015 Mark Grealish
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU GPL v3.0
 * @version    3.0
 * @link       https://github.com/bhalash/sheepie
 */

global $post;

?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<!-- The mystery of life isn't a problem to solve, but a reality to experience. -->
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta charset="<?php bloginfo('charset'); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
<title><?php wp_title('-', true, 'right'); ?></title>
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <?php if (!is_404()) : ?>
        <div id="sidebar">
            <?php // 1. Output a pretty background image, if it exists. ?>
            <div class="sidebar-interior">
                <h2 class="sidebar-title">
                    <a title="<?php bloginfo('name'); ?>" href="<?php printf(home_url()); ?>"><?php bloginfo('name'); ?></a>
                </h2>

                <p class="sidebar-description">
                    <?php // 2. Either site information or post meta content. ?>
                    <span>
                        <?php bloginfo('description'); ?>
                    </span>
                </p>

                <div class="sidebar-social">
                    <?php // 3. Social navigation menu. ?>
                    <?php wp_nav_menu(array('theme_location' => 'top-social')); ?>
                </div>
                <button class="bigsearch-toggle">search</button>
            </div>
        </div>
    <?php endif; ?>
    <div id="content">
        <div id="bigsearch">
            <form role="search" id="bigsearch-form" method="get" class="right left bottom" action="<?php printf(esc_url(home_url('/'))); ?>" autocomplete="off">
                <fieldset>
                    <input id="s" class="search-input-class" name="s" placeholder="<?php _e('search', TTD); ?>" type="search" required="required" autofocus>
                </fieldset>
            </form>
        </div>
        <div class="content-interior">
