<?php

/**
 * Site Pagination Link
 * -----------------------------------------------------------------------------
 * @category   PHP Script
 * @package    Sheepie
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2015 Mark Grealish
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU GPL v3.0
 * @version    3.0
 * @link       https://github.com/bhalash/sheepie
 */

$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$next = $paged + 1; 
$previous = $paged - 1; 

?>

<nav id="pagination">
    <p class="previous<?php echo (is_single()) ? '-post' : ''; ?>">
        <small>
            <?php if (is_single()) {
                next_post_link('%link', '&larr; %title', false);
            } else {
                previous_posts_link('&larr; Page ' . $previous);
            } ?>
        </small>
    </p>

    <p class="count">
        <?php if (!is_single() && query_has_pages()) : ?>
            <small><span><?php archive_page_count(true); ?></span></small>
        <?php endif; ?>
    </p>

    <p class="next<?php echo (is_single()) ? '-post' : ''; ?>">
        <small>
            <?php if (is_single()) {
                previous_post_link('%link', '%title &rarr;', false);
            } else {
                next_posts_link('Page ' . $next . ' &rarr;'); 
            } ?>
        </small>
    </p>
</nav>
