<?php

/**
 * Next/Previous Post Pagination Link
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

<nav class="pagination" id="post-pagination">
    <p class="previous previous-post">
        <small><?php next_post_link('%link', '&larr; %title', false); ?></small>
    </p>
    <p class="next next-post">
        <small><?php previous_post_link('%link', '%title &rarr;', false); ?></small>
    </p>
</nav>
