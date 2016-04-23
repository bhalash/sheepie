<?php

/**
 * Excerpted Article
 * -----------------------------------------------------------------------------
 * @category   PHP Script
 * @package    Sheepie
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2015 Mark Grealish
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU GPL v3.0
 * @version    1.0
 * @link       https://github.com/bhalash/sheepie
 */

?>

<article <?php post_class(['article', 'excerpt', 'vspace--full']); ?> id="article--<?php the_ID(); ?>">
    <header class="excerpt__header">
        <h3 class="excerpt__title title">
            <?php sheepie_partial('posttitle'); ?>
        </h3>
        <?php if (!is_page()) : ?>
            <span class="postmeta text--small"><?php sheepie_postmeta(); ?></span>
        <?php endif; ?>
    </header>
    <div class="article__content excerpt__content">
        <?php printf('<p class="font-size--small">%s</p>', get_the_excerpt()); ?>
    </div>
</article>
