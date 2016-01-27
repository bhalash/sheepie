<?php

/**
 * Dated Archive Template
 * -----------------------------------------------------------------------------
 * @category   PHP Script
 * @package    Sheepie
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2015 Mark Grealish
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU GPL v3.0
 * @version    1.0
 * @link       https://github.com/bhalash/sheepie
 */

// Null to avoid warnings.
$year = get_query_var('year') ?: null;
$month = get_query_var('monthnum') ?: null;
$day = get_query_var('day') ?: null;

$current_month = -1;

get_header();
sheepie_partial('gohome');

printf('<h2 class="%s"><a href="%s">%s</a></h2>',
    'title vspace--double',
    get_year_link($year),
    $year
);

$archive_posts = new WP_Query([
    'posts_per_page' => -1,
    'order' => 'asc',
    'orderby' => 'date',
    'date_query' => [
        'year' => $year,
        'month' => $month,
        'day' => $day
    ]
]);

while($archive_posts->have_posts()) {
    $archive_posts->the_post();

    if ($current_month !== get_the_date('n')) {
        $current_month = get_the_date('n');

        printf('<h3 class="%s"><a href="%s">%s</a></h3>',
            'title vcenter--full',
            get_month_link($year, $current_month),
            arc_get_month_from_number($current_month, 'F')
        );

        printf('<hr>');
    }

    sheepie_partial('article', 'excerpt');
}

wp_reset_query();
get_footer();

?>
