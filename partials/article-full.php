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

$margin = (!is_single()) ? 'vspace--triple' : '';

?>

<article <?php post_class(['article', 'article--full', $margin]); ?> id="article--full--<?php the_ID(); ?>">
    <header class="article--full__header vspace--full">
        <h3 class="title article--full__title vspace--quarter">
            <?php sheepie_partial('posttitle'); ?>
        </h3>
        <?php if (!is_page()) : ?>
            <?php echo sheepie_postmeta('h4', 'noprint vspace--half'); ?>
        <?php endif; ?>
    </header>
    <div class="article__content">
        <?php the_content(__('Read the rest of this post &raquo;', 'sheepie')); ?>
    </div>

    <?php wp_link_pages(array(
        'before' => sprintf('<p class="%s">%s', 'pagination--article page-links', __('Page: ', 'sheepie')),
        'after' => '</p>'
    )); ?>

    <?php if (is_single()) : ?>
        <footer class="article--full__footer">
            <?php sheepie_partial('pagination', 'post'); ?>
            <hr class="vcenter--double">
            <div class="article--full__author">
                <?php echo sheepie_avatar(get_the_author_meta('ID'), get_the_author(), 'article--full__avatar', ['size' => 150]); ?>
                <div class="article--full__bio">
                    <h3 class="article--full__bio-blurb vspace--quarter title">by <?php the_author_meta('display_name'); ?></h3>
                    <h4 class="vspace--quarter meta"><?php the_tags(__('Tagged: ', 'sheepie'), ', '); ?></h4>
                    <p class="article--full__bio-blurb"><?php the_author_meta('user_description'); ?></p>
                </div>
            </div>
        </footer>
    <?php else : ?>
        <hr class="vcenter--triple">
    <?php endif; ?>
</article>
