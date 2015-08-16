<?php

/**
 * Single Post Template
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

get_header();
get_template_part(THEME_PARTIALS . 'gohome');

if (have_posts()) {
    while (have_posts()) {
        the_post();
        get_template_part(PARTIAL_ARTICLES, 'full');
        
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
