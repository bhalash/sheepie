<?php

/**
 * Full Article Template
 * -----------------------------------------------------------------------------
 * @category   PHP Script
 * @package    Sheepie
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2015 Mark Grealish
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU GPL v3.0
 * @version    3.0
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
            <span class="meta"><?php sheepie_partial('postmeta'); ?></span>
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
        <?php sheepie_partial('pagination'); ?>
        <hr>
        <footer class="full avatar-box">
            <div class="avatar">
                <?php sheepie_avatar_background_html($author, 96, 'author-photo'); ?>
            </div>
            <div class="author-info">
                <p>
                    <small><?php sheepie_partial('postmeta'); ?></small>
                </p>
                <h4><?php the_author_meta('display_name'); ?></h4>
                <p><?php the_author_meta('user_description'); ?></p>
            </div>
        </footer>
    <?php endif; ?>
</article>
