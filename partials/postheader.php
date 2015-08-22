<?php

/**
 * Full Post Header
 * -----------------------------------------------------------------------------
 * @category   PHP Script
 * @package    Sheepie
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2015 Mark Grealish
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU GPL v3.0
 * @version    3.0
 * @link       https://github.com/bhalash/sheepie
 */

?>

<header>
    <h3 class="title">
        <?php printf('<a href="%s" rel="%s" title="%s%s">%s</a>',
            get_the_permalink(),
            'bookmark',
            __('Permanent link to ', TTD),
            the_title_attribute(array('echo' => false)),
            get_the_title()
        ); ?>
    </h3>
    <?php if (!is_page()) : ?>
        <small><?php partial('postmeta'); ?></small>
    <?php endif; ?>
</header>
