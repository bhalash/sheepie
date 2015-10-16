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

?>

<nav class="pagination pagination--comment" id="pagination--comment">
    <p class="pagination__previous previous-comment">
        <span class="font--span"><?php previous_comments_link(__('&larr; Previous', 'sheepie')); ?></small>
    </p>
    <p class="pagination__count">
        <span class="font--span"><?php get_comment_pages_count(); ?></small>
    </p>
    <p class="pagination__next next-comment">
        <span class="font--span"><?php next_comments_link(__('Next &rarr;', 'sheepie')); ?></small>
    </p>
</nav>
