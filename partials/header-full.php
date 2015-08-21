<?php

/**
 * Article Header
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

<header>
    <h3 class="title"><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php printf('%s %s', _e('Permanent link to ', TTD), the_title_attribute()); ?>"><?php the_title(); ?></a></h3>
    <?php if (!is_page()) : ?>
        <small>
            <time datetime="<?php the_time('Y-m-d H:i'); ?>">
                <?php the_time(get_option('date_format')) ?>
            </time>
            <?php _e(' in ', TTD); the_category(', '); edit_post_link(__('edit post', TTD), ' / ', ''); ?>
            </small>
    <?php endif; ?>
</header>
