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
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU GPL v3.0
 * @version    3.0
 * @link       https://github.com/bhalash/sheepie
 */

get_header();

// Archives by date.

printf('<h5 class="title">%s</h5>', __('Archives by Year', LOCALE));
printf('<div class="archive">');

foreach (timed_archives_count() as $year => $calendar) {
    $first_post = year_first_post($year, true);

    printf('<div class="archive-card vspace-full" id="archive-card-%s">', $year);

    // Print year name with background image from post of that year.
    printf('<h2 class="%s" %s><a title="%s" href="%s">%s</a></h2>',
        'archive-year-name',
        post_image_css($first_post, false),
        __('Archives for the year ', LOCALE) . $year,
        get_year_link($year),
        $year
    );

    // One "card" per year.
    printf('<ul class="%s" id="%s">', 'archive-card-year', $year);

    foreach ($calendar as $month => $count) {
        // Per-month items.
        printf('<li class="%s" id="%s">',
            'archive-card-month', 
            $year . '-' . $month
        );

        // Actual count or whatever else you want at the bottom.
        printf('<a class="%s" href="%s">',
            'archive-card-data',
            get_month_link($year, $month)
        );
        
        printf('<span class="%s">%s</span>',
            'month-name',
            get_month_from_number($month)
        );

        printf('<span class="%s">%s</span>',
            'month-count',
            $count
        );

        printf('</a>');
        printf('</li>');
    }

    printf('</ul></div>');
}

printf('</div>');
printf('<hr>');

// Arhives by category.
// TODO

printf('<h5 class="title">%s</h5>', __('Archives by Category', LOCALE));
printf('<hr>');

// Archives by tag.
// TODO

// Statistics.

printf('<h5 class="title">%s</h5>', __('Blog Statistics', LOCALE));
printf('<p>%s</p>', blog_statistics());

// Keep any custom taxonomies below here. Or not. I'm a comment, not a cop. ;)
get_footer();

?>
