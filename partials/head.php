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

<header id="navbar">
    <div class="navbar-head">
        <div class="navbar-head-content">
            <div class="navbar-title navbar-child">
                <h2 class="site-name">
                    <?php printf('<a class="%s" href="%s">%s</a>',
                        'navbar-site-name',
                        home_url(),
                        get_bloginfo('name')
                    ); ?>
                </h2>
            </div>

            <div class="navbar-description navbar-child">
                <span>
                    <?php bloginfo('description'); ?>
                </span>
            </div>

            <?php wp_nav_menu(array(
                'theme_location' => 'top-social',
                'container' => 'div',
                'container_class' => 'navbar-socialrow navbar-child'
            )); ?>

            <div class="navbar-buttonrow navbar-child">
                <button id="navrow-search-toggle" class="bigsearch-toggle toggle">
                    <span class="toggle-icon search"></span> 
                </button>
            </div>
        </div>
    </div>
    <div class="disp--hidden" id="bigsearch">
        <form class="bigsearch-form" method="get" action="<?php printf($action); ?>" autocomplete="off" novalidate>
            <fieldset>
                <input class="bigsearch-input" id="bigsearch-input" name="s" type="search" placeholder="<?php _e('search', 'sheepie'); ?>" required="required">
                <label class="bigsearch-label" for="bigsearch-input"><?php _e('search', 'sheepie'); ?></label>
            </fieldset>
        </form>
        <button class="bigsearch-toggle toggle" id="bigsearch-search-toggle">
            <span class="toggle-icon search"></span> 
        </button>
    </div>
</header>
