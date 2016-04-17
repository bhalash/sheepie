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

$page = (get_query_var('paged')) ? get_query_var('paged') : 1;

?>

<nav class="noprint pagination pagination--site" id="pagination--site">
    <p class="pagination__previous previous-page meta">
        <?php previous_posts_link(__('Page ', 'sheepie') . ($page - 1)); ?>
    </p>
    <?php if (function_exists('arc_query_has_pages') && arc_query_has_pages()) : ?>
        <p class="pagination__count meta">
            <?php arc_archive_page_count(true); ?>
        </p>
    <?php endif; ?>
    <p class="pagination__next next-page meta">
        <?php next_posts_link(__('Page ', 'sheepie') . ($page + 1)); ?>
    </p>
</nav>
