<?php

/**
 * Template Name: Search Page
 * -----------------------------------------------------------------------------
 * This is a simple dumb list of the site's archives by date, by category and by
 * tag. You are welcome to insert any custom taxonomies and post types wherever.
 * 
 * @category   PHP Script
 * @package    Sheepie
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2015 Mark Grealish
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU GPL v3.0
 * @version    3.0
 * @link       https://github.com/bhalash/sheepie
 */

get_header();

?>

<div id="search">
    <form role="search" id="search-full-page" method="get" class="right left bottom" action="<?php printf(esc_url(home_url('/'))); ?>" autocomplete="off">
        <fieldset>
            <input id="s" class="search-input-class" name="s" placeholder="<?php _e('search', LOCALE); ?>" type="search" required="required" autofocus>
        </fieldset>
    </form>
</div>

<?php

get_footer();

?>
