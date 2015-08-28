<?php

/**
 * Searchform Template
 * -----------------------------------------------------------------------------
 * @category   PHP Script
 * @package    Sheepie
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2015 Mark Grealish
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU GPL v3.0
 * @version    3.0
 * @link       https://github.com/bhalash/sheepie
 */

global $wp_query;

$query = get_search_query();
$action = esc_url(home_url('/'));
$total = $wp_query->found_posts;

?>

<form role="search" class="searchform vspace-half" id="searchform" method="get" action="<?php printf($action); ?>" autocomplete="off">
    <fieldset>
        <input class="searchform-input" name="s" placeholder="<?php _e('search', 'sheepie'); ?>" type="text" required="required" value="<?php printf($query); ?>">
    </fieldset>
</form>
<div class="clearfix search-results-meta">
    <span class="total meta left-float"><?php printf($total); ?> results</span>
    <span class="total meta right-float">
        Sort by: 

        <a href="<?php search_url('asc'); ?>"><?php _e('oldest', 'sheepie'); ?></a> |
        <a href="<?php search_url('desc'); ?>"><?php _e('newest', 'sheepie'); ?></a>
    </span>
</div>
<hr>
