<?php

/**
 * Site Pagination Link
 * -----------------------------------------------------------------------------
 * @category   PHP Script
 * @package    Sheepie
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2015 Mark Grealish
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU GPL v3.0
 * @version    1.0
 * @link       https://github.com/bhalash/sheepie
 */

$pages = (get_query_var('pages')) ? get_query_var('pages') : 1;
$next = $pages + 1; 
$previous = $pages - 1; 

?>

<nav class="pagination" id="site-pagination">
    <p class="pagination-previous previous-page">
        <small><?php previous_posts_link(__('&larr; Page ', 'sheepie') . $previous); ?></small>
    </p>
    <?php if (function_exists('arc_query_has_pages') && arc_query_has_pages()) : ?>
        <p class="pagination-count">
            <small><span><?php arc_archive_page_count(true); ?></span></small>
        </p>
    <?php endif; ?>
    <p class="pagination-next next-page">
        <small><?php next_posts_link(__('Page ', 'sheepie') . $next . ' &rarr;');  ?></small>
    </p>
</nav>
