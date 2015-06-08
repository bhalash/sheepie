<?php

/**
 * Fetch Related Posts
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

$category = get_the_category($post->ID); 

// 3 posts is a good number.
$desired_related_count = 3;
    
$related_posts = new WP_Query(array(
    // The next two lines force the exclusion of private posts.
    'perm' => 'readable',
    'post_status' => 'publish',
    'cat' => $category[0]->cat_ID,
    'posts_per_page' => $desired_related_count,
    'orderby' => 'rand',
    'order' => 'DESC',
    'post__not_in' => array(
        get_the_ID()
    ),
    'date_query' => array(
        'inclusive' => false,
        'after' => get_the_date('Y-m-j') . ' -180 days',
        'before' => get_the_date('Y-m-j') . ' -7 days',
    )
)); 

if ($related_posts->found_posts < $desired_related_count) {
    /*
     * Related Posts Filler
     * -------------------------------------------------------------------------
     * As you go farther back in time in the blog archives, there will be fewer
     * matching related posts. In that case, I would prefer to just grab any
     * random post from this period and add it to the original loop as a filler.
     */

    $filler_count = $desired_related_count - $related_posts->found_posts;
    $excluded_posts = array();

    foreach($related_posts->posts as $post => $key) {
        // Add any found posts to the array of excluded images.
        array_push($excluded_posts, $post->ID);
    }

    $related_posts_filler = new WP_Query(array(
        // The next two lines force the exclusion of private posts.
        'perm' => 'readable',
        'post_status' => 'publish',
        // Exclude already chosen posts.
        'post__not_in' => $excluded_posts,
        'posts_per_page' => $filler_count,
        'orderby' => 'rand',
        'order' => 'DESC',
        'date_query' => array(
            'inclusive' => false,
            'after' => get_the_date('Y-m-j') . ' -180 days',
            'before' => get_the_date('Y-m-j') . ' -7 days',
        )
    ));

    // // Merge queries.
    $join_query = new WP_Query();
    $join_query->posts = array_merge($related_posts->posts, $related_posts_filler->posts);
    $join_query->post_count = $related_posts->post_count + $related_posts_filler->post_count;
    $related_posts = $join_query;
}

if ($related_posts->have_posts()) {
    printf('<hr><div class="%s">', 'related-articles');

    while ($related_posts->have_posts()) {
        $related_posts->the_post();
        get_template_part(THEME_ARTICLES, 'related');
    }

    printf('</div>');
}

wp_reset_postdata(); ?>