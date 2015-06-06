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

get_header();

/**
 * Archives by Date
 * -----------------------------------------------------------------------------
 */

$yearly_archive_key = 'sheepie_dated_archive_count';

delete_option($yearly_archive_key);

printf('<h5 class="title">%s</h5>', __('Archives by Year', TTD));
printf('<pre>');

if (!get_option($yearly_archive_key)) {
    $argh = generate_dated_archive_count($yearly_archive_key);
} else {
    $argh = update_dated_archive_count($yearly_archive_key);
}

$argh = get_option($yearly_archive_key);
var_dump($argh);

printf('</pre>');

// for ($i = $start_year; $i <= $end_year; $i++) {
//     // Iterate years.
//     $year = get_year_link($i);
//     printf('<h5 class="title"><a href="%s">%s</a></h5>', $year, $i);
// }

// $dates = wp_get_archives(array(
//     'type' => 'monthly',
//     'limit' => '',
//     'format' => 'html', 
//     'before' => '',
//     'after' => '',
//     'show_post_count' => false,
//     'echo' => 0,
//     'order' => 'DESC'
// ));

// foreach ($dates as $date) {
//     printf('date');
// }

printf('<hr>');

/**
 * Archives by Category 
 * -----------------------------------------------------------------------------
 */

printf('<h5 class="title">%s</h5>', __('Archives by Category', TTD));
// $categories = get_categories(); 

// foreach ($categories as $category) {
//     printf('%s ', $category->cat_name);
// }

printf('<hr>');

/**
 * Archives by Tag
 * -----------------------------------------------------------------------------
 * I use tags indiscriminately for the purposes of labelling. 
 */

// printf('<h5 class="title">%s</h5>', __('Archives by Tag', ttd));
// $tags = get_tags(); 

// foreach ($tags as $tag) {
//     printf('%s ', $tag->name);
// }

/**
 * Statistics
 * -----------------------------------------------------------------------------
 */

printf('<h5 class="title">%s</h5>', __('Blog Statistics', ttd));
printf('<p>%s</p>', blog_statistics());

// Keep any custom taxonomies below here. Or not. I'm a comment, not a cop. ;)
get_footer(); ?>