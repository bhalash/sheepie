<?php

/**
 * Theme Responsive Header
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

if (is_404()) {
    return;
}

$action = esc_url(home_url('/'));

?>

<header class="navbar" id="navbar">
    <div class="navbar__contentwrap color--rmwb--bg">
        <div class="navbar__content">
            <div class="navbar__child navbar__titlewrapper">
                <h2 class="navbar__title">
                    <?php printf('<a class="%s" href="%s">%s</a>',
                        'navbar__title-link',
                        home_url(),
                        get_bloginfo('name')
                    ); ?>
                </h2>
            </div>

            <div class="navbar__description navbar__child">
                <span class="font--small">
                    <?php bloginfo('description'); ?>
                </span>
            </div>

            <?php wp_nav_menu(array(
                'theme_location' => 'top-social',
                'container' => 'div',
                'container_class' => 'navbar__social-wrapper navbar__child',
                'menu_class' => 'navbar__social',
                'link_before' => '<span class="navbar__socialicon">',
                'link_after' => '</span>'
            )); ?>

            <div class="navbar__buttonrow navbar__child">
                <button class="navbar__button button button--search-navbar toggle bigsearch__toggle" id="searchtoggle__navbar" data-bind="click: toggleSearch">
                    <span class="button__icon search" data-bind="css: {close: display.search()}"></span> 
                </button>
            </div>
        </div>
    </div>
</header>

<div class="disp--hidden bigsearch color--rmwb--bg" id="bigsearch" data-bind="css: {'disp--hidden': !display.search()}">
    <form class="bigsearch__form" method="get" action="<?php printf($action); ?>" autocomplete="off" novalidate>
        <fieldset>
            <input class="bigsearch__input" id="bigsearch__input" name="s" type="search" placeholder="<?php _e('search', 'sheepie'); ?>" required="required" data-bind="hasfocus: display.search()"> 
            <label class="bigsearch__label" for="bigsearch__input"><?php _e('search', 'sheepie'); ?></label>
        </fieldset>
    </form>

    <button class="button button--search-bigsearch bigsearch__toggle" id="searchtoggle__search" data-bind="click: toggleSearch"> 
        <span class="button__icon search" data-bind="css: {close: display.search()}"></span> 
    </button>
</div>

<div class="lightbox" id="lightbox" style="display: none;" data-bind="visible: display.lightbox()">
    <a class="lightbox__anchor" href="#!" data-bind="click: show, attr: {title: lightbox.text, href: lightbox.link}">
        <img class="lightbox__image" data-bind="attr: {src: lightbox.image, alt: lightbox.text}" />
    </a>
</div>
