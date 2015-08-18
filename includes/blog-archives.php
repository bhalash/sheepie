<?php

/**
 * Blog Archive and Statistics Functions
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
 * Get the Blog's Age
 * -----------------------------------------------------------------------------
 * Return the age of the blog in $format. Defaults to days.
 * 
 * @param   string      $format         DateInterval format.
 * @return  string      $blog_age       Age of the blog in $format.
 * @link    https://php.net/manual/en/datetime.diff.php
 * @link    https://php.net/manual/en/class.dateinterval.php 
 */

function blog_age($format = '%a') {
    $trans_name = 'shp_blog_age'; 
    $trans_expiry = 24 * HOUR_IN_SECONDS;

    if (!($dates = get_transient($trans_name))) {
        $dates = array();

        $dates['first'] = new DateTime(get_posts(array(
            'posts_per_page' => 1,
            'order' => 'ASC'
        ))[0]->post_date);

        $dates['last'] = new DateTime(get_posts(array(
            'posts_per_page' => 1
        ))[0]->post_date);

        set_transient($trans_name, $dates, $trans_expiry);
    }

    $blog_age = $dates['first']->diff($dates['last'])->format($format);
    return $blog_age;
}

/**
 * Convert Number to Month
 * -----------------------------------------------------------------------------
 * @param   int          $number             The month of the year as a number.
 * @return  string                           The month as a word.
 * @link    http://stackoverflow.com/a/18467892/1433400
 */

function get_month_from_number($number) {
    return date_create_from_format('!m', $number % 12)->format('F');
}

/**
 * Generate Dated Archive Post Count
 * -----------------------------------------------------------------------------
 * Generate the initial count of posts by year and month, and save it under the
 * given options key. Generating this can be resource intensive, so it makes 
 * sense to store this as a variable.
 * 
 * 1. Get 1 post in ascending order. This is the first post on the blog.
 * 2. Extract the date of the post.
 * 3. Parse that down to the year alone.
 * 
 * @param   string      $option_name        Options key for the post count.
 * @return  array       $counts             Returned counts for the 
 * @link    http://wordpress.stackexchange.com/a/60862
 */

function timed_archives_count() {
    $trans_name = 'shp_timed_archives_count';
    $trans_expiry = 24 * HOUR_IN_SECONDS;

    if (!($counts = get_transient($trans_name))) {
        global $wpdb;

        $from_date = preg_replace('/-.*/', '', get_posts(array(
            'posts_per_page' => 1,
            'order' => 'ASC'
        ))[0]->post_date);

        for ($i = date('Y'); $i >= $from_date; $i--) {
            $counts[$i] = array();

            $month = $wpdb->get_results($wpdb->prepare(
                "SELECT MONTH(post_date) AS post_month, count(ID) AS post_count from " .
                "{$wpdb->posts} WHERE post_status = 'publish' AND YEAR(post_date) = %d " .
                "GROUP BY post_month;", $i
            ), OBJECT_K);

            foreach ($month as $m) {
                $counts[$i][$m->post_month] = $m->post_count;
            }
        }

        set_transient($trans_name, $counts, $trans_expiry);
    }

    return $counts;
}

/**
 * Generate Category Archive Post Count
 * -----------------------------------------------------------------------------
 * Generate the initial count of posts by year and month, and save it under the
 * given options key. Generating this can be resource intensive, so it makes 
 * sense to store this as a variable.
 * 
 * @param   string      $option_name        Options key for the post count.
 * @return  array       $counts             Returned counts for the 
 * @link    http://wordpress.stackexchange.com/a/60862
 */

function category_archives_count() {

}

/**
 * Post Interval Average
 * -----------------------------------------------------------------------------
 * Return the blog's average posts per day, rounded to $percision.
 * 
 * @param   int     $precision          Rounding precision.
 * @return  int     $posts_per_day      Number of posts per day.
 */

function post_interval($precision = 2) {
    $blog_age_days = blog_age('%a');
    $post_count = wp_count_posts()->publish;
    return round($blog_age_days / $post_count, $precision);
}

/**
 * Count Comment Authors
 * -----------------------------------------------------------------------------
 * WordPress doesn't appear to have a convenient way to count unique comment
 * authors. 
 * 
 * @return int      $count          count of comment authors.
 */

function get_comment_authors_count($echo = false) {
    $trans_name = 'shp_comment_author_count';
    $trans_expiry = 24 * HOUR_IN_SECONDS;

    if (!($authors = get_transient($trans_name))) {
        $authors = array();

        foreach (get_comments() as $comment) {
            if (!in_array($comment->comment_author_email, $authors)) {
                if (!empty($comment->comment_author_email)) {
                    $authors[] = $comment->comment_author_email;
                }
            }
        }

        $authors = count($authors);
        set_transient($trans_name, $authors, $trans_expiry);
    }

    if (!$echo) {
        return $authors;
    }

    printf($authors);
}

/**
 * Year First Post
 * -----------------------------------------------------------------------------
 */

function year_first_post($year, $has_image = true) {
    $trans_name = 'shp_year_first_post_' . $year;
    $trans_expiry = 24 * HOUR_IN_SECONDS;

    if (!($first_post = get_transient($trans_name))) {
        $yearly_posts = get_posts(array(
            'year' => $year,
            'order' => 'ASC'
        ));

        if ($has_image) {
            foreach ($yearly_posts as $post) {
                if (has_post_image($post->ID)) {
                    $first_post = $post;
                }
            }
        } else {
            $first_post = $yearly_posts[0];
        }

        set_transient($trans_name, $first_post, $trans_expiry);
    }

    return $first_post;
}

/*
 * Print Blog Statistics
 * -----------------------------------------------------------------------------
 * Rattle off some useful statistics about the age and amount of content on the 
 * blog.
 * 
 * @param   bool        $echo           Echo stats, true/false.
 * @return  string      $stats          Blog stats, printed or returned.
 */

function blog_statistics($echo = false) {
    $trans_name = 'shp_blog_statistics';
    $trans_expiry = 24 * HOUR_IN_SECONDS;

    if (!($stats = get_transient($trans_name))) {
        $stats = array();

        $anchor = sprintf('<a title="%s" href="%s">%s</a>',
            get_bloginfo('name'),
            home_url(),
            get_bloginfo('name')
        );

        $categories = __('The blog %s has %s posts in %s categories, that are labelled with %s tags.', TTD);
        $visitors = __('%s different visitors have left a total of %s comments.', TTD);
        $average = __('On average, a new post has been published every %s days over the last %s days.', TTD);

        $stats[] = sprintf($categories, $anchor, wp_count_posts()->publish, count(get_categories()), count(get_tags()));
        $stats[] = sprintf($average, get_comment_authors_count(), wp_count_comments()->total_comments);
        $stats[] = sprintf($average, post_interval(), blog_age());

        $stats = implode(' ', $stats);
        set_transient($trans_name, $stats, $tranas_expiry);
    }

    if (!$echo) {
        return $stats;
    }

    printf($stats);
}

?>
