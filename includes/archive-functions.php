<?php

/**
 * Template Name: Archive Page
 * -----------------------------------------------------------------------------
 * This is a simple dumb list of the site's archives by date, by category and by
 * tag. You are welcome to insert any custom taxonomies and post types wherever.
 * 
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

/**
 * Generate Dated Archive Post Count
 * -----------------------------------------------------------------------------
 * Generate the initial count of posts by year and month, and save it under the
 * given options key. Generating this can be resource intensive, so it makes 
 * sense to store this as a variable.
 * 
 * @param   string      $option_name        Options key for the post count.
 */

function generate_dated_archive_count($option_name) {
    /* Get the year of the first post: 
     * 
     * 1. Get 1 post in ascending order, which is the first post on the blog.
     * 2. Extract the date of the post.
     * 3. Parse that down to the year alone. */

    $first_year = preg_replace('/-.*/', '', get_posts(array(
        'posts_per_page' => 1,
        'order' => 'ASC'
    ))[0]->post_date);

    // Current year.
    $current_year = date('Y');
    $current_month = date('m');

    $post_counts = array(
        'last_checked' => array(
            $current_year, $current_month
        )
    );

    // Years that the blog has been in operation.
    for ($i = $current_year; $i >= $first_year; $i--) {
        // Years the blog has been in operation.
        $post_counts[$i] = array();

        for ($j = 1; $j <= 12; $j++) {
            $monthly_count = new WP_Query(array(
                'posts_per_page' => -1,
                'date_query' => array(
                    'year' => $i, 
                    'month' => $j
                )
            ));

            $post_counts[$i][] = $monthly_count->post_count;
            wp_reset_query();
        }
    }

    update_option($option_name, $post_counts);
    return $post_counts;
}

/**
 * Update Dated Archive Post Count
 * -----------------------------------------------------------------------------
 * Compare the current year
 * 
 * @param   string      $option_name        Options key for the post count.
 */

function update_dated_archive_count($option_name) {
    return get_option($option_name);
}

?>