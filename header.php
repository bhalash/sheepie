<?php

/**
 * PHP Header File
 * -----------------------------------------------------------------------------
 * @category   PHP Script
 * @package    Sheepie
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2015 Mark Grealish
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU General Public License v3.0
 * @version    3.0
 * @link       https://github.com/bhalash/sheepie
 *
 * This file is part of Sheepie.
 * 
 * Sheepie is free software: you can redistribute it and/or modify it under the
 * terms of the GNU General Public License as published by the Free Software 
 * Foundation, either version 3 of the License, or (at your option) any later
 * version.
 * 
 * Sheepie is distributed in the hope that it will be useful, but WITHOUT ANY 
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License along with 
 * Sheepie. If not, see <http://www.gnu.org/licenses/>.
 */

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
    <div class="side-by-side" id="site">
        <div class="<?php header_class($post->ID); ?>" id="header" <?php post_image_css($post->ID, true); ?>>
            <?php // 1. Output a pretty background image, if it exists. ?>
            <div id="header-content">
                <h2 id="header-title">
                    <a title="<?php bloginfo('name'); ?>" href="<?php printf(home_url()); ?>"><?php bloginfo('name'); ?></a>
                </h2>

                <p id="header-description">
                    <?php // 2. Either site information or post meta content. ?>
                    <span>
                        <?php bloginfo('description'); ?>
                    </span>
                </p>

                <div id="header-social">
                    <?php // 3. Social navigation menu. ?>
                    <?php wp_nav_menu(array('theme_location' => 'top-social')); ?>
                </div>
            </div>
        </div>
        <div id="content">
            <div id="interior">
