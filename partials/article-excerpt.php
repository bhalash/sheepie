<?php

/**
 * PHP Header File
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

<article <?php post_class('excerpt'); ?> id="article-<?php the_ID(); ?>">
    <?php partial('postheader'); ?>

    <div class="main">
        <p><?php custom_excerpt(); ?> <a href="<?php the_permalink(); ?>">...</a></p>
    </div>

    <?php if (!is_page()) : ?>
        <footer>
            <p>
                </small><?php partial('postmeta'); ?>
            </p>
        </footer>
    <?php endif; ?>
</article>
