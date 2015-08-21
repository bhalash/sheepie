<?php

/**
 * 404 Template
 * -----------------------------------------------------------------------------
 * @category   PHP Script
 * @package    Sheepie
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2015 Mark Grealish
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU GPL v3.0
 * @version    3.0
 * @link       https://github.com/bhalash/sheepie
 */

get_header(); ?>

<div id="error">
    <h1><?php _e('Error 404', TTD); ?></h1>
    <p><?php _e('Page not found. :(', TTD); ?></p>
    <p><small><a href="<?php printf(site_url()); ?>"><?php _e('back to home', TTD); ?></a></small></p>
</div>

<?php get_footer(); ?>
