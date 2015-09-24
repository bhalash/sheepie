<?php

/**
 * Comment Pagination Links
 * -----------------------------------------------------------------------------
 * @category   PHP Script
 * @package    Sheepie
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2015 Mark Grealish
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU GPL v3.0
 * @version    1.0
 * @link       https://github.com/bhalash/sheepie
 */

$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$next = $paged + 1; 
$previous = $paged - 1; 

?>

<nav class="pagination" id="comment-pagination">
    <p class="previous previous-comment">
        <small><?php previous_comments_link(__('&larr; Previous', 'sheepie')); ?></small>
    </p>

    <p class="count">
        <small><?php get_comment_pages_count(); ?></small>
    </p>

    <p class="next next-comment">
        <small><?php next_comments_link(__('Next &rarr;', 'sheepie')); ?></small>
    </p>
</nav>
