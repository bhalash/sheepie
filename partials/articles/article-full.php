<?php

/**
 * Full Article Template
 * -----------------------------------------------------------------------------
 * @category   PHP Script
 * @package    Sheepie
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2015 Mark Grealish
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU General Public License v3.0
 * @version    3.0
 * @link       https://github.com/bhalash/sheepie
 */

?>

<article <?php post_class('full'); ?> id="article-<?php the_ID(); ?>">
    <?php get_template_part(THEME_PARTIALS . 'header', 'full'); ?>

    <div class="main">
        <?php the_content(__('Read the rest of this post &raquo;', TTD)); ?>
    </div>

    <?php if (is_single()) {
        get_template_part(THEME_PARTIALS . '/pagination');
        get_template_part(THEME_PARTIALS . 'footer', 'full');
    } ?>
</article>
