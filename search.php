<?php

/**
 * Search Results Template
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

if (is_search()) {
    global $wp_query; 
    $count = 0;
    $result_count = search_results_count(get_query_var('paged'), $wp_query->found_posts);
}

if (is_search()) {
    if (have_posts()) {
        get_search_form();

        while (have_posts()) {
            the_post();  

            if ($count > 0) {
                printf('<hr />');
            }

            get_template_part(THEME_ARTICLES . 'article', 'excerpt');
            $count++;
        }
    } else {
        get_template_part(THEME_ARTICLES . 'article', 'missing');
    }
}

if (is_search()) {
    get_template_part(THEME_PARTIALS . '/pagination');
}

get_footer(); ?>