<?php

/**
 * Single Post Template
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
get_template_part(THEME_PARTIALS . 'gohome');

if (have_posts()) {
    while (have_posts()) {
        the_post();
        get_template_part(PARTIAL_ARTICLES, 'full');
        
        printf('<hr>');
        printf('<div class="%s">', 'column-of-three related-articles');

        foreach (get_related() as $post) {
            setup_postdata($post);
            get_template_part(PARTIAL_ARTICLES, 'related');
        }

        printf('</div>');

        wp_reset_postdata();
        comments_template();
    }
} else {
    get_template_part(PARTIAL_ARTICLES, 'missing');
}

get_footer(); ?>
