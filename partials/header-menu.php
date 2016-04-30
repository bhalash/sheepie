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

<header class="navbar noprint vspace--double" id="navbar">
    <h2 class="navbar__title title vspace--half text--center">
        <?php if (is_single() || is_page()) : ?>
            <?php printf('<a class="%s" href="%s">%s</a>', 'navbar__title-link', get_the_permalink(), get_the_title()); ?>
        <?php else: ?>
            <?php printf('<a class="%s" href="%s">%s</a>', 'navbar__title-link', home_url(), get_bloginfo('name')); ?>
        <?php endif; ?>
    </h2>

    <p class="navbar__description text--italic text--center">
        <?php if (is_single() || is_page()) : ?>
            <?php echo sheepie_postmeta('span', ''); ?>
        <?php else : ?>
            <?php bloginfo('description'); ?>
         <?php endif; ?>
    </p>
    <hr class="vcenter--full">
</header>
