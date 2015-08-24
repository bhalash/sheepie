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

$action = esc_url(home_url('/'));

?>

<div id="sidebar">
    <div class="sidebar-interior">
        <div class="sidebar-title sidebar-child">
            <h2 class="site-name">
                <?php printf('<a class="%s" href="%s">%s</a>',
                    'sidebar-site-name',
                    home_url(),
                    get_bloginfo('name')
                ); ?>
            </h2>
        </div>

        <div class="sidebar-description sidebar-child">
            <span>
                <?php bloginfo('description'); ?>
            </span>
        </div>

        <?php wp_nav_menu(array(
            'theme_location' => 'top-social',
            'container' => 'div',
            'container_class' => 'sidebar-socialrow sidebar-child'
        )); ?>

        <div class="sidebar-buttonrow sidebar-child">
            <button class="bigsearch-toggle search"></button>
        </div>
    </div>
</div>
<div id="bigsearch">
    <form role="search" class="bigsearch-form" method="get" action="<?php printf($action); ?>" autocomplete="off">
        <fieldset>
            <input class="bigsearch-input" name="s" placeholder="<?php _e('search', LOCALE); ?>" type="search" required="required">
        </fieldset>
    </form>
</div>
