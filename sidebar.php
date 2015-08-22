<?php

/**
 * Sidebar Template
 * -----------------------------------------------------------------------------
 * @category   PHP Script
 * @package    Sheepie
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2015 Mark Grealish
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU GPL v3.0
 * @version    3.0
 * @link       https://github.com/bhalash/sheepie
 */

if (is_404()) {
    return;
}

?>

<div id="sidebar">
    <div class="sidebar-interior">
        <h2 class="sidebar-title">
            <?php printf('<a class="%s" href="%s">%s</a>',
                'sidebar-site-name',
                home_url(),
                get_bloginfo('name')
            ); ?>
        </h2>

        <p class="sidebar-description">
            <span>
                <?php bloginfo('description'); ?>
            </span>
        </p>

        <div class="sidebar-social">
            <?php wp_nav_menu(array('theme_location' => 'top-social')); ?>
        </div>
        <button class="bigsearch-toggle">search</button>
    </div>
</div>
<div id="bigsearch">
    <form role="search" id="bigsearch-form" method="get" class="right left bottom" action="<?php printf(esc_url(home_url('/'))); ?>" autocomplete="off">
        <fieldset>
            <input id="s" class="search-input-class" name="s" placeholder="<?php _e('search', TTD); ?>" type="search" required="required" autofocus>
        </fieldset>
    </form>
</div>
