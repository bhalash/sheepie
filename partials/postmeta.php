<?php

/**
 * Post Meta Information
 * -----------------------------------------------------------------------------
 * Date, time, category and edit link.
 * 
 * @category   PHP Script
 * @package    Sheepie
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2015 Mark Grealish
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU GPL v3.0
 * @version    3.0
 * @link       https://github.com/bhalash/sheepie
 */

printf('<time datetime="%s">%s</a>',
    get_the_time('Y-m-d H:i'),
    get_the_time(get_option('date_format'))
);

_e(' in ', LOCALE);
the_category(', ');
edit_post_link(__('edit post', LOCALE), ' / ', ''); 

?>
