<?php

/**
 * Main Index Template
 * -----------------------------------------------------------------------------
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

$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$next = $paged + 1; 
$previous = $paged - 1; ?>

<?php if (is_single()) : ?>
    <hr>
<?php endif; ?>
<nav id="pagination">
    <p class="previous<?php echo (is_single()) ? '-post' : ''; ?>">
        <?php if (is_single()) {
            next_post_link('%link', '&larr; %title', false);
        } else {
            previous_posts_link('&larr; Page ' . $previous);
        } ?>
    </p>

    <p class="count">
        <?php if (!is_single() && !is_search()) : ?>
            <span><?php archive_page_count(); ?></span>
        <?php endif; ?>
    </p>

    <p class="next<?php echo (is_single()) ? '-post' : ''; ?>">
        <?php if (is_single()) {
            previous_post_link('%link', '%title &rarr;', false);
        } else {
            next_posts_link('Page ' . $next . ' &rarr;'); 
        } ?>
    </p>
</nav>