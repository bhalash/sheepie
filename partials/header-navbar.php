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

<header class="navbar noprint vspace--triple" id="navbar">
    <h3 class="navbar__title title vspace--half">
        <?php printf('<a class="%s" href="%s">%s</a>',
            'navbar__title-link',
            home_url(),
            get_bloginfo('name')
        ); ?>
    </h3>

    <p class="navbar__description vspace--half">
        <?php bloginfo('description'); ?>
    </p>

    <nav class="navbar__social">
        <?php wp_nav_menu(array(
            'theme_location' => 'top-social',
            'container' => '',
            'menu_class' => 'navbar__social-list',
            'link_before' => '<span class="navbar__social-icon social__icon">',
            'link_after' => '</span>',
            'items_wrap' =>  sheepie_nav_menu_search()
        )); ?>
    </nav>
</header>
