<?php

/**
 * Post Title
 * -----------------------------------------------------------------------------
 * @category   PHP Script
 * @package    Sheepie
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2015 Mark Grealish
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU GPL v3.0
 * @version    3.0
 * @link       https://github.com/bhalash/sheepie
 */

printf('<a href="%s" rel="%s" title="%s%s">%s</a>',
    get_the_permalink(),
    'bookmark',
    __('Permanent link to ', LOCALE),
    the_title_attribute(array('echo' => false)),
    get_the_title()
); 

?>
