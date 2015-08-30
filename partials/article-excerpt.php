<?php

/**
 * Excerpted Article
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
    <div class="main">
        <header>
            <h5 class="title excerpt-title">
                <?php sheepie_partial('posttitle'); ?>
            </h5>
            <?php if (!is_page()) : ?>
                <span class="meta"><?php sheepie_partial('postmeta'); ?></span>
            <?php endif; ?>
        </header>
        <?php the_excerpt(); ?>
    </div>
</article>
