<?php

/**
 * Theme Responsive Header
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

<div id="header">
    <div class="header-interior">
        <div class="header-title header-child">
            <h2 class="site-name">
                <?php printf('<a class="%s" href="%s">%s</a>',
                    'header-site-name',
                    home_url(),
                    get_bloginfo('name')
                ); ?>
            </h2>
        </div>

        <div class="header-description header-child">
            <span>
                <?php bloginfo('description'); ?>
            </span>
        </div>

        <?php wp_nav_menu(array(
            'theme_location' => 'top-social',
            'container' => 'div',
            'container_class' => 'header-socialrow header-child'
        )); ?>

        <div class="header-buttonrow header-child">
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