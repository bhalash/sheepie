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
    <div class="error-content">
        <h1><?php _e('Error 404', LOCALE); ?></h1>
        <p><?php _e('Page not found. :(', LOCALE); ?></p>
        <p><small><a href="<?php printf(site_url()); ?>"><?php _e('back to home', LOCALE); ?></a></small></p>
    </div>
</div>

<?php get_footer(); ?>
