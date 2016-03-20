<?php

/**
 * Main Search Form
 * -----------------------------------------------------------------------------
 * I separated this template because of the 404 switch. It was easier to wrap it
 * all up here.
 *
 * @category   PHP Script
 * @package    Sheepie
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2015 Mark Grealish
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU GPL v3.0
 * @version    1.0
 * @link       https://github.com/bhalash/sheepie
 */

$search_action = esc_url(home_url('/'));

?>

<div class="disp--hidden bigsearch color--rmwb--bg noprint" id="bigsearch" data-bind="css: {'disp--hidden': !elements.search()}">
    <form class="bigsearch__form" method="get" action="<?php printf($search_action); ?>" autocomplete="off" novalidate>
        <fieldset>
            <input class="bigsearch__input" id="bigsearch__input" name="s" type="search" placeholder="<?php _e('search', 'sheepie'); ?>" required="required" data-bind="hasfocus: elements.search()">
            <label class="bigsearch__label" for="bigsearch__input"><?php _e('search', 'sheepie'); ?></label>
        </fieldset>
    </form>

    <button class="button button--search-bigsearch bigsearch__toggle social search" id="searchtoggle__search" data-bind="css: {close: elements.search()}, click: toggle.search">
        <span class="button__icon social__icon" data-bind=""></span>
    </button>
</div>
