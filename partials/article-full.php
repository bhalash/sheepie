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

?>

<article <?php post_class('full'); ?> id="article-<?php the_ID(); ?>">
    <header class="full">
        <h4 class="title full-title">
            <?php sheepie_partial('posttitle'); ?>
        </h4>
        <?php if (!is_page()) : ?>
            <span class="article-meta"><small><?php sheepie_partial('postmeta'); ?></small></span>
        <?php endif; ?>
    </header>
    <div class="article-main full-main">
        <?php the_content(__('Read the rest of this post &raquo;', 'sheepie')); ?>
    </div>

    <?php wp_link_pages(array(
        'before' => sprintf('<p class="%s">%s', 'page-links', __('Page: ', 'sheepie')),
        'after' => '</p>'
    )); ?>

    <?php if (is_single()) : ?>
        <?php sheepie_partial('pagination', 'post'); ?>
        <hr>
        <footer class="full avatar-box article-meta">
            <div class="avatar">
                <?php sheepie_avatar_background_html($author, 96, 'author-photo'); ?>
            </div>
            <div class="author-info">
                <h4>by <?php the_author_meta('display_name'); ?></h4>
                <p class="article-meta">
                    <small><?php sheepie_partial('postmeta'); ?></small>
                </p>
                <p><?php the_author_meta('user_description'); ?></p>
                <p class="article-tags">
                    <small><?php the_tags(__('Tagged: ', 'sheepie'), ', '); ?></small>
                </p>
            </div>
        </footer>
    <?php endif; ?>
</article>
