<?php

/**
 * 404 Template
 * -----------------------------------------------------------------------------
 * @category   PHP Script
 * @package    Sheepie
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2015 Mark Grealish
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU GPL v3.0
 * @version    1.0
 * @link       https://github.com/bhalash/sheepie
 */

get_header(); ?>

<div class="error" id="error--404">
    <div class="error__content">
        <h1 class="error__message"><?php _e('Error 404', 'sheepie'); ?></h1>
        <p class="error__description"><?php _e('Page not found. :&#40;', 'sheepie'); ?></p>
        <p class="error__home"><a href="<?php printf(site_url()); ?>"><?php _e('back to home', 'sheepie'); ?></a></p>
    </div>
</div>

<?php get_footer(); ?>
