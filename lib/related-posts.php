<?php

/**
 * Related Posts
 * -----------------------------------------------------------------------------
 * @category   PHP Script
 * @package    Sheepie Related Posts
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2015 Mark Grealish
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU GPL v3.0
 * @version    1.1
 * @link       https://github.com/bhalash/related-posts
 */

if (!defined('ABSPATH')) {
    die('-1');
}

/**
 * Get Related Posts from the Same Category
 * -----------------------------------------------------------------------------
 * Fetch posts related to given post, by category.
 *
 * @param   array             $args       Array of arguments.
 * @return  array             $related    Array of related posts.
 */

function rp_get_related($args) {
    $args = wp_parse_args($args, [
        'post' => get_the_id(),
        'count' => 3,
        'cache' => true,
        'range' => [
            'after' => date('Y-m-j') . '-180 days',
            'before' => date('Y-m-j')
        ]
    ]);

    if (!($post = get_post($args['post']))) {
        global $post;
    }

    $categories = get_the_category($post->ID) ?: get_option('default_category');
    $query_cat = [];

    foreach ($categories as $cat) {
        $query_cat[] = $cat->cat_ID;
    }

    $related = get_posts([
        'category__in' => $query_cat,
        'date_query' => [
            'inclusive' => true,
            'after' => $args['range']['after'],
            'before' => $args['range']['before']
        ],
        'numberposts' => $args['count'],
        'order' => 'DESC',
        'orderby' => 'rand',
        'perm' => 'readable',
        'post_status' => 'publish',
        'post__not_in' => [$post->ID]
    ]);

    if ($missing = $args['count'] - sizeof($related)) {
        $related = rp_filler_posts($post, $missing, $related);
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

function rp_filler_posts($post, $count, $related_posts) {
    $excluded_posts = [$post->ID];

    foreach ($related_posts as $related) {
        $excluded_posts[] = $related->ID;
    }

    $filler_posts = get_posts([
        'numberposts' => $count,
        'order' => 'DESC',
        'orederby' => 'rand',
        'post__not_in' => $excluded_posts
    ]);

    return array_merge($related_posts, $filler_posts);
}

?>
