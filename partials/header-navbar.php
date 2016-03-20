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

?>

<header class="navbar noprint" id="navbar">
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
                'menu_class' => 'clearfix navbar__social',
                'link_before' => '<span class="navbar__socialicon social__icon">',
                'link_after' => '</span>'
            )); ?>

            <div class="clearfix navbar__buttonrow navbar__child">
                <button class="navbar__button button button--search-navbar toggle bigsearch__toggle social search" id="searchtoggle__navbar" data-bind="css: {close: elements.search()}, click: toggle.search">
                    <span class="button__icon social__icon" data-bind=""></span>
                </button>
            </div>
        </div>
    </div>
</header>
