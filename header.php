<?php

/**
 * PHP Header File
 * -----------------------------------------------------------------------------
 * @category   PHP Script
 * @package    Sheepie
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2015 Mark Grealish
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU GPL v3.0
 * @version    1.0
 * @link       https://github.com/bhalash/sheepie
 */

global $post;
$charset = get_bloginfo('charset');
$html = get_bloginfo('html_type');

?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<!-- The mystery of life isn't a problem to solve, but a reality to experience. -->
<meta http-equiv="Content-Type" content="<?php printf('%s; charset=%s', $html, $charset); ?>" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta charset="<?php bloginfo('charset'); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?> data-bind="event: {keyup: closeOnEscape}">
    <?php // I split off the nav and header code for my sanity (neatness). ?>
    <?php sheepie_partial('head'); ?>
    <main class="main" id="main">
        <div class="main__interior" id="main__interior">
