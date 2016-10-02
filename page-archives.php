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
 * @version    1.0
 * @link       https://github.com/bhalash/sheepie
 */

get_header();

if (!function_exists('arc_year_first_post')) {
    return;
}

?>

<h3 class="title vspace--half"><?php _e('Statistics', 'sheepie'); ?></h3>
<p><?php arc_blog_statistics(true); ?></p>
<hr class="vcenter--double">
<div class="archive">

    <?php foreach (arc_timed_archives_count() as $year => $calendar) {
        // Archives by date.
        $first_post = arc_year_first_post($year, true);

        printf('<div class="archive-card vspace--full" id="archive-card-%s">', $year);

        // Print year name with background image from post of that year.
        printf('<h2 class="%s" %s><a title="%s" href="%s">%s</a></h2>',
            'archive-year-name',
            post_image_url_style($first_post, false),
            __('Archives for the year ', 'sheepie') . $year,
            get_year_link($year),
            $year
        );

        // One "card" per year.
        printf('<ul class="%s" id="%s">', 'archive-card-year', $year);

        foreach ($calendar as $month => $count) {
            // Per-month items.
            printf('<li class="%s" id="%s">', 'archive-card-month', $year . '-' . $month);
            // Actual count or whatever else you want at the bottom.
            printf('<a class="%s" href="%s">', 'archive-card-data', get_month_link($year, $month));
            printf('<span class="%s">%s</span>', 'month-name', arc_get_month_from_number($month));
            printf('<span class="%s">%s</span>', 'month-count', $count);
            printf('</a>');
            printf('</li>');
        }

        printf('</ul></div>');
    } ?>

</div>
<hr class="vcenter--double">
<?php get_footer(); ?>
