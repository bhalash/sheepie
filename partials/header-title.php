<?php

/**
 * Theme Headline
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

$margin_class = (is_single() || is_page()) ? 'vspace--full' : 'vspace--double';

?>

<header class="headline noprint <?php echo $margin_class; ?>" id="headline">
    <h2 class="title vspace--half">
        <?php if (is_single() || is_page()) : ?>
            <?php printf('<a href="%s">%s</a>', get_the_permalink(), get_the_title()); ?>
        <?php else: ?>
            <?php printf('<a href="%s">%s</a>', home_url(), get_bloginfo('name')); ?>
        <?php endif; ?>
    </h2>

    <p>
        <?php if (is_single() || is_page()) : ?>
            <?php echo sheepie_postmeta(); ?>
        <?php else : ?>
            <span class="text--italic"><?php bloginfo('description'); ?></span>
         <?php endif; ?>
    </p>
    <hr class="vcenter--full">
</header>
