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
 *
 * This file is part of Sheepie.
 *
 * Sheepie is free software: you can redistribute it and/or modify it under the
 * terms of the GNU General Public License as published by the Free Software 
 * Foundation, either version 3 of the License, or (at your option) any later
 * version.
 * 
 * Sheepie is distributed in the hope that it will be useful, but WITHOUT ANY 
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License along with 
 * Sheepie. If not, see <http://www.gnu.org/licenses/>.
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
