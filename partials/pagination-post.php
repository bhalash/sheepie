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

<nav class="pagination pagination--post noprint" id="pagination--post">
    <p class="pagination__previous previous-post">
        <span class="font--small"><?php next_post_link('%link', '%title', false); ?></span>
    </p>
    <p class="pagination__next next-post">
        <span class="font--small"><?php previous_post_link('%link', '%title', false); ?></span>
    </p>
</nav>
