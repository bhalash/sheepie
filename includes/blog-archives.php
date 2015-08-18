<?php 

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
    $first_post_date = new DateTime(get_posts(array(
        'posts_per_page' => 1,
        'order' => 'ASC'
    ))[0]->post_date);

    $last_post_date = new DateTime(get_posts(array(
        'posts_per_page' => 1
    ))[0]->post_date);

    return $first_post_date->diff($last_post_date)->format($format);
}

/**
 * Convert Number to Month
 * -----------------------------------------------------------------------------
 * @param   int          $number             The month of the year as a number.
 * @return  string                           The month as a word.
 * @link    https://stackoverflow.com/questions/18467669/convert-number-to-month-name-in-php
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
 * @param   string      $option_name        Options key for the post count.
 * @return  array       $counts             Returned counts for the 
 * @link    https://wordpress.stackexchange.com/questions/60859/post-count-per-day-month-year-since-blog-began
 */

function timed_archives_count() {
    global $wpdb;

    /* Get the year of the first post: 
     * -------------------------------------------------------------------------
     * 1. Get 1 post in ascending order. This is the first post on the blog.
     * 2. Extract the date of the post.
     * 3. Parse that down to the year alone. */
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
 * @link    https://wordpress.stackexchange.com/questions/60859/post-count-per-day-month-year-since-blog-began
 */

function category_archives_count() {

}

/**
 * Post Interval Average
 * -----------------------------------------------------------------------------
 * Return the blog's posts per day, rounded to $percision.
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

/*
 * Print Blog Statistics
 * -----------------------------------------------------------------------------
 * Rattle off some useful statistics about the age and amount of content on the 
 * blog.
 */

function blog_statistics() {
    printf(__('The blog <a title="%s" href="%s">%s</a> has %s posts in %s categories, that are labelled with %s tags. ', TTD),
        get_bloginfo('name'),
        home_url(),
        get_bloginfo('name'),
        wp_count_posts()->publish,
        count(get_categories()),
        count(get_tags())
    );

    printf(__('%s different visitors have left a total of %s comments. ', TTD),
        get_comment_authors_count(),
        wp_count_comments()->total_comments
    );

    printf(__('On average, a new post has been published every %s days over the last %s days.', TTD),
        post_interval(),
        blog_age()
    );
}

?>
