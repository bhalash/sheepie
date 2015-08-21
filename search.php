<?php

/**
 * Search Results Template
 * -----------------------------------------------------------------------------
 * @category   PHP Script
 * @package    Sheepie
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2015 Mark Grealish
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU GPL v3.0
 * @version    3.0
 * @link       https://github.com/bhalash/sheepie
 */

get_header();
global $paged;

if (!is_single() && $paged > 0) {
    get_template_part(THEME_PARTIALS . '/pagination');
}

if (have_posts()) {
    while (have_posts()) {
        the_post();
        get_template_part(PARTIAL_ARTICLES, 'full');
        printf('<hr>');
    }
} else {
    get_template_part(PARTIAL_ARTICLES, 'missing');
}

get_template_part(THEME_PARTIALS . '/pagination');
get_footer(); ?>
