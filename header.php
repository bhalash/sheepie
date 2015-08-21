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
    <div class="<?php header_class($post->ID); ?>" id="header">
        <?php // 1. Output a pretty background image, if it exists. ?>
        <div class="header-content">
            <h2 class="header-title">
                <a title="<?php bloginfo('name'); ?>" href="<?php printf(home_url()); ?>"><?php bloginfo('name'); ?></a>
            </h2>

            <p class="header-description">
                <?php // 2. Either site information or post meta content. ?>
                <span>
                    <?php bloginfo('description'); ?>
                </span>
            </p>

            <div class="header-social">
                <?php // 3. Social navigation menu. ?>
                <?php wp_nav_menu(array('theme_location' => 'top-social')); ?>
            </div>
        </div>
    </div>
    <div id="content">
        <div id="interior">
