<?php

/**
 * Search Results Template
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
sheepie_partial('gohome');
get_search_form();

if (have_posts()) {
    while (have_posts()) {
        the_post();
        sheepie_partial('article', 'excerpt');
        printf('<hr class="%s">', 'vcenter--full');
    }
} else {
    sheepie_partial('article', 'missing');
}

sheepie_partial('pagination', 'site');
get_footer();

?>
