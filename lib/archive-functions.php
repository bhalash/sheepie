<?php

/**
 * Blog Archive and Statistics Functions
 * -----------------------------------------------------------------------------
 * This is a simple dumb list of the site's archives by date, by category and by
 * tag. You are welcome to insert any custom taxonomies and post types wherever.
 *
 * @category   PHP Script
 * @package    Archive Functions
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2015 Mark Grealish
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU GPL v3.0
 * @version    1.0
 * @link       https://github.com/bhalash/archive-functions
 */

if (!defined('ABSPATH')) {
    die('-1');
}

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

function arc_blog_age($format = '%a') {
    $dates = array();

    $dates['first'] = new DateTime(get_posts(array(
        'posts_per_page' => 1,
        'order' => 'ASC'
    ))[0]->post_date);

    $dates['last'] = new DateTime(get_posts(array(
        'posts_per_page' => 1
    ))[0]->post_date);

    $blog_age = $dates['first']->diff($dates['last'])->format($format);
    return $blog_age;
}

/**
 * Convert Number to Month
 * -----------------------------------------------------------------------------
 * @param   int          $number             The month of the year as a number.
 * @param   string       $format             Format for date.
 * @return  string                           The month as a word.
 * @link    http://stackoverflow.com/a/18467892/1431.00
 */

function arc_get_month_from_number($number, $format = 'M') {
    return date_create_from_format('!m', $number % 12)->format($format);
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

function arc_timed_archives_count() {
    global $wpdb;

    $from_date = preg_replace('/-.*/', '', get_posts(array(
        'posts_per_page' => 1,
        'order' => 'ASC'
    ))[0]->post_date);

    for ($i = date('Y'); $i >= $from_date; $i--) {
        $counts[$i] = array();

        $month = $wpdb->get_results($wpdb->prepare(
            "SELECT MONTH(post_date) AS post_month, count(ID) AS post_count"
                . " from {$wpdb->posts} WHERE post_status = 'publish'"
                . " AND YEAR(post_date) = %d GROUP BY post_month;",
            $i
        ), OBJECT_K);

        foreach ($month as $m) {
            $counts[$i][$m->post_month] = $m->post_count;
        }
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

function arc_category_archives_count() {
    // TODO
}

/**
 * Post Interval Average
 * -----------------------------------------------------------------------------
 * Return the blog's average posts per day, rounded to $percision.
 *
 * @param   int     $precision          Rounding precision.
 * @return  int     $posts_per_day      Number of posts per day.
 */

function arc_post_interval($precision = 2) {
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

function arc_get_comment_authors_count($echo = false) {
    $authors = array();

    foreach (get_comments() as $comment) {
        if (!in_array($comment->comment_author_email, $authors)) {
            if (!empty($comment->comment_author_email)) {
                $authors[] = $comment->comment_author_email;
            }
        }
    }

    $authors = count($authors);

    if (!$echo) {
        return $authors;
    }

    printf($authors);
}

/**
 * Year First Post
 * -----------------------------------------------------------------------------
 */

function arc_year_first_post($year, $has_image = true) {
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

function arc_blog_statistics($echo = false) {
    $stats = array();

    $anchor = sprintf('<a title="%s" href="%s">%s</a>',
        get_bloginfo('name'),
        home_url(),
        get_bloginfo('name')
    );

    $categories = __('The blog %s has %s posts in %s categories, that are labelled with %s tags.', 'sheepie');
    $visitors = __('%s different visitors have left a total of %s comments.', 'sheepie');
    $average = __('On average, a new post has been published every %s days over the last %s days.', 'sheepie');

    $stats[] = sprintf($categories, $anchor, wp_count_posts()->publish, count(get_categories()), count(get_tags()));
    $stats[] = sprintf($visitors, get_comment_authors_count(), wp_count_comments()->total_comments);
    $stats[] = sprintf($average, post_interval(), blog_age());

    $stats = implode(' ', $stats);

    if (!$echo) {
        return $stats;
    }

    printf($stats);
}

/**
 * Get Total Number of Pages in Query
 * -----------------------------------------------------------------------------
 * @return  int      Total number of pages in current query, rounded up.
 */

function arc_query_page_total() {
    global $wp_query;

    return ceil($wp_query->found_posts / get_option('posts_per_page'));
}

/**
 * See if Query Has Pages
 * -----------------------------------------------------------------------------
 * @return bool     Query has pages, true/false.
 */

function arc_query_has_pages() {
    return (arc_query_page_total() > 1);
}

/**
 * Pagination Post Counter
 * -----------------------------------------------------------------------------
 * Fetch and display total post count in format of 'Page 1 of 10'.
 * This only counts published, public posts; drafts, pages, custom
 * post types and private posts are all excluded unless you specify
 * inclusion.
 *
 * @param   bool        $echo       Echo results, true/false.
 * @param   string      $message    Message to output.
 * @return  string      $count      The post count.
 */

function arc_archive_page_count($echo = true, $message = 'Page %s of %s') {
    $page = (get_query_var('paged')) ? get_query_var('paged') : 1;
    $count = sprintf($message, $page, arc_query_page_total());

    if (!$echo) {
        return $count;
    }

    printf($count);
}

/**
 * Search Result Count
 * -----------------------------------------------------------------------------
 * Return a count of results for the search in the format
 * 'Results 1 to 10 of 200'
 *
 * @param   int     $page_num       Current page nunber.
 * @param   int     $total_results  Total number of search results.
 * @return  string                  Count of results.
 */

function arc_search_results_count($echo = false) {
    global $wp_query;

    $total = $wp_query->found_posts;

    $page = (get_query_var('paged')) ? get_query_var('paged') : 1;
    $posts_per_page = get_option('posts_per_page');

    /* Position within the query.
     * i.e. page = 3, posts_per_page = 10
     * 3 * 10 = 30, so we're on the page that ends with the 30th post.
     */

    $position = $page * $posts_per_page;

    // $position - 30 - 10 + 1 = 21, so we're on the page that begins with 21.
    $count_low  = ($position - $posts_per_page) + 1;

    // Stops an overage on the final page of the search.
    $count_high = ($position > $total_results) ? $total : $position;

    $count = sprintf(__('Results %s to %s of %s', 'sheepie'),
        $count_low,
        $count_high,
        $total
    );

    if (!$echo) {
        return $count;
    }

    printf($count);
}

/**
 * Generate Ascending and Descending Search Link
 * -----------------------------------------------------------------------------
 * @param   string      $order          'asc' or 'desc'
 * @param   bool        $echo           Echo it, true/false.
 * @return  string      $url            Generated URL.
 */

function arc_search_url($order = null, $echo = true) {
    if (!$order) {
        $order = 'asc';
    }

    $query = get_search_query();
    $url = array();

    $url[] = esc_url(home_url('/'));
    $url[] = '?s=';
    $url[] = esc_attr($query);
    $url[] = '&sort=date';
    $url[] = '&order=';
    $url[] = $order;

    $url = implode('', $url);

    if (!$echo) {
        return $url;
    }

    printf($url);
}

?>
