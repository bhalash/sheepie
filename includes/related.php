<?php

/**
 * Related Posts
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

/**
 * Get Related Posts from the Same Category
 * -----------------------------------------------------------------------------
 * Fetch posts related to given post, by category.
 * 
 * @param   int/object        $post       Post object.
 * @param   int               $count      Number of related posts to fetch.
 * @param   int               $timeout    Delay in hours for transient API. 
 * @param   array             $range      Date range to to back in time.
 * @return  array             $related    Array of related posts.
 */

function get_related($post = null, $count = 3, $timeout = 12, $range = null) {
    if (!($post = get_post($post))) {
        global $post;
    }

    $trans = 'single_post_related_' . $post->ID;
    $timeout *= HOUR_IN_SECONDS;
    $query_cat = array();

    if (!($categories = get_the_category($post->ID))) {
        $categories = get_option('default_category');
    }

    foreach ($categories as $cat) {
        $query_cat[] = $cat->cat_ID;
    }

    if (!$range) {
        $range = array(
            'after' => date('Y-m-j') . ' -21 days',
            'before' => date('Y-m-j')
        );
    }

    if (!($related = get_transient($trans))) {
        $related = get_posts(array(
            'category__in' => $query_cat,
            'date_query' => array(
                'inclusive' => true,
                'after' => $range['after'],
                'before' => $range['before']
            ),
            'numberposts' => $count,
            'order' => 'DESC',
            'orderby' => 'rand',
            'perm' => 'readable',
            'post_status' => 'publish',
            'post__not_in' => array($post->ID)
        )); 

        set_transient($trans, $related, $timeout);
    }

    if ($missing = $count - sizeof($related)) {
        // Filler isn't cached because that could cause problems.
        $related = related_filler($post, $missing, $related);
    }

    return $related;
}

/**
 * Related Posts Filler
 * -----------------------------------------------------------------------------
 * @param   int/object        $post       Post object.
 * @param   int               $count      Number of related posts to fetch.
 * @param   array             $related    Array of related posts to exclude.
 * @return  array             Filler posts.
 */

function related_filler($post, $count, $related) {
    $exlude = array(); 
    $exclude[] = $post->ID;

    foreach ($related as $r) {
        $exclude[] = $r->ID;
    }
    
    $filler = get_posts(array(
        'numberposts' => $count,
        'order' => 'DESC',
        'orederby' => 'rand',
        'post__not_in' => $exclude
    ));

    return array_merge($related, $filler);
}

?>
