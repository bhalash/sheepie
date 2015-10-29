<?php

/**
 * Template Sidebar
 * -----------------------------------------------------------------------------
 * @category   PHP Script
 * @package    Sheepie
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2015 Mark Grealish
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU GPL v3.0
 * @version    1.0
 * @link       https://github.com/bhalash/sheepie
 */

if (is_active_sidebar('theme-widgets')) {
    printf('<hr class="%s">', 'vcenter--double');
    printf('<div id="%s">', 'widgets');
    dynamic_sidebar('theme-widgets');
    printf('</div>');
}

?>
