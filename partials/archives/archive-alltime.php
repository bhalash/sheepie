<?php

/**
 * Archive for Posts of All Time
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

printf('<div class="yearly-archive">');
$timed_archive_counts = timed_archives_count();

foreach ($timed_archive_counts as $year => $months) {
    // Grab first five posts in each year.
    $first_id = get_posts(array('year' => $year, 'order' => 'ASC'));

    foreach ($first_id as $id) {
        /* Pick the first post that has an image in its content. While your own 
         * mileage will vary, this suits me fine since virtually every post has
         * at least one image in content. */
        if (has_post_image($id->ID)) {
            $first_id = $id->ID;
            break;
        }
    }

    printf('<div class="yearly-archive-card" id="archive-card-%s">', $year);
    printf('<h2 %s><a title="%s" href="%s">%s</a></h2>', post_image_background($first_id, false), __('Archives for the year ', TTD) . $year, get_year_link($year), $year);
    printf('<ul>');

    foreach ($months as $month => $count) {
        printf('<li><a href="%s">%s (%s)</a></li>', get_month_link($year, $month), get_month_from_number($month), $count);
    }

    printf('</ul></div>');
}

printf('</div>');

?>