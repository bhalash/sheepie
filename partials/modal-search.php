<?php

/**
 * Modal Search Input
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

?>

<div class="hidden modal-search modal noprint" id="modal-search">
    <form class="modal-search__form" method="get" action="<?php echo esc_url(home_url('/')); ?>" autocomplete="off" novalidate>
        <fieldset>
            <input class="modal-search__input" id="modal-search__input" name="s" type="search" placeholder="<?php _e('search', 'sheepie'); ?>" required="required">
            <label class="modal-search__label" for="modal-search__input"><?php _e('search', 'sheepie'); ?></label>
        </fieldset>
    </form>
    <div class="social close">
        <a class="toggle" data-toggle="modal-search" href="">
            <span class="round social__icon">Search</span>
        </a>
    </div>
</div>
