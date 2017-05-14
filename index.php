<?php

/**
 * Main Index Template
 * -----------------------------------------------------------------------------
 * @category   PHP Script
 * @package    Sheepie
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2015 Mark Grealish
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU GPL v3.0
 * @version    1.0
 * @link       https://github.com/bhalash/sheepie
 */

get_header();
global $paged;

printf('<div class="articles">');

if (have_posts()) {
    while (have_posts()) {
        the_post();
        sheepie_partial('article', 'full');
    }
} else {
    sheepie_partial('article', 'missing');
}

printf('</div>');

sheepie_partial('pagination', 'site');
get_footer();

?>
