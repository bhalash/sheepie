<?php

/**
 * Full Article Template
 * -----------------------------------------------------------------------------
 * @category   PHP Script
 * @package    Sheepie
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2015 Mark Grealish
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU GPL v3.0
 * @version    1.0
 * @link       https://github.com/bhalash/sheepie
 */

$author = get_the_author_meta('ID');
$post_classes = array('article', 'article--full', 'vspace--half');

?>

<article <?php post_class($post_classes); ?> id="article--full--<?php the_ID(); ?>">
    <header class="article--full__header vspace--full">
        <?php if (!is_page()) : ?>
            <h6 class="article--meta font--small vspace--half noprint"><?php sheepie_postmeta(); ?></h6>
        <?php endif; ?>
        <h2 class="title article--full__title">
            <?php sheepie_partial('posttitle'); ?>
        </h2>
    </header>
    <div class="article__content">
        <?php the_content(__('Read the rest of this post &raquo;', 'sheepie')); ?>
    </div>

    <?php wp_link_pages(array(
        'before' => sprintf('<p class="%s">%s', 'pagination--article page-links', __('Page: ', 'sheepie')),
        'after' => '</p>'
    )); ?>

    <?php if (is_single()) : ?>
        <?php sheepie_partial('pagination', 'post'); ?>
        <hr class="vcenter--double">
        <footer class="article--full__footer avatar">
            <div class="article--full__avatar avatar__container noprint">
                <?php sheepie_avatar_background_html($author, 96, 'avatar__photo'); ?>
            </div>
            <div class="article--full__author avatar__text">
                <h4 class="vspace--half">by <?php the_author_meta('display_name'); ?></h4>
                <h4 class="article--full__meta font--small vspace--quarter"><?php sheepie_postmeta(); ?></h4>
                <p class="article--full__bio"><?php the_author_meta('user_description'); ?></p>
                <p class="article--full__tags">
                    <span class="font--small"><?php the_tags(__('Tagged: ', 'sheepie'), ', '); ?></span>
                </p>
            </div>
        </footer>
    <?php else: ?>
        <hr class="vcenter--triple">
    <?php endif; ?>
</article>
