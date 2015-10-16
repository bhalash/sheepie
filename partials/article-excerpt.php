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

$post_classes = array('article', 'article--excerpt');

?>

<article <?php post_class($post_classes); ?> id="article--excerpt--<?php the_ID(); ?>">
    <header class="article--excerpt__header">
        <h4 class="article--excerpt__title title">
            <?php sheepie_partial('posttitle'); ?>
        </h4>
        <?php if (!is_page()) : ?>
            <span class="postmeta font--small"><?php sheepie_postmeta(); ?></span>
        <?php endif; ?>
    </header>
    <div class="article__content article--excerpt__content">
        <?php printf('<p class="font-size--small">%s</p>', get_the_excerpt()); ?>
    </div>
</article>
