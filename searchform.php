<?php

/**
 * Searchform Template
 * -----------------------------------------------------------------------------
 * @category   PHP Script
 * @package    Sheepie
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2015 Mark Grealish
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU GPL v3.0
 * @version    1.0
 * @link       https://github.com/bhalash/sheepie
 */

global $wp_query;

$query = get_search_query();
$action = esc_url(home_url('/'));
$total = $wp_query->found_posts;

$result = 'result';
$result .= $total > 1 ? 's' : '';

?>

<form class="searchform vspace--half" id="searchform" method="get" action="<?php printf($action); ?>" autocomplete="off">
    <fieldset>
        <input class="searchform__input" id="searchform__input" name="s" placeholder="<?php _e('search', 'sheepie'); ?>" type="text" required="required" value="<?php printf($query); ?>">
    </fieldset>
</form>
<div class="clearfix searchform__meta">
    <span class="searchform__meta--left left-float"><?php printf('%d %s', $total, $result); ?></span>
    <?php if (function_exists('arc_search_url')) : ?>
        <span class="searchform__meta--right right-float">
            Sort by: 

            <a class="searchform__sort--by-oldest" href="<?php arc_search_url('asc'); ?>"><?php _e('oldest', 'sheepie'); ?></a> |
            <a class="searchform__sort--by-newest" href="<?php arc_search_url('desc'); ?>"><?php _e('newest', 'sheepie'); ?></a>
        </span>
    <?php endif; ?>
</div>
<hr>
