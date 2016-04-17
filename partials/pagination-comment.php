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

<nav class="pagination pagination--comment noprint" id="pagination--comment">
    <p class="pagination__previous previous-comment meta">
        <?php previous_comments_link(__('Previous', 'sheepie')); ?>
    </p>
    <p class="pagination__count meta">
        <?php get_comment_pages_count(); ?>
    </p>
    <p class="pagination__next next-comment meta">
        <?php next_comments_link(__('Next', 'sheepie')); ?>
    </p>
</nav>
