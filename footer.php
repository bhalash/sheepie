<?php

/**
 * PHP Footer File
 * -----------------------------------------------------------------------------
 * @category   PHP Script
 * @package    Sheepie
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2015 Mark Grealish
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU GPL v3.0
 * @version    1.0
 * @link       https://github.com/bhalash/sheepie
 */

?>
        <?php get_sidebar(); ?>
        <nav class="menu">
            <?php wp_nav_menu([
                'theme_location' => 'top-social',
                'container' => '',
                'menu_class' => 'menu__list',
                'link_before' => '<span class="social__icon">',
                'link_after' => '</span>',
                'items_wrap' =>  sheepie_nav_menu_search()
            ]); ?>
        </nav>
    </main> <?php // End #main ?>
    <?php if (!is_404()) {
        sheepie_partial('modal', 'lightbox');
        sheepie_partial('modal', 'search');
    }

    wp_footer(); ?>
</body>
</html>
