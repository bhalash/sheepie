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

?>

<article <?php post_class(['article', 'article--full', 'vspace--double']); ?> id="article--full--<?php the_ID(); ?>">
    <header class="article--full__header vspace--double">
        <h1 class="title article--full__title vspace--full">
            <?php sheepie_partial('posttitle'); ?>
        </h1>
        <?php if (!is_page()) : ?>
            <?php echo sheepie_postmeta('h3', 'text--small noprint vspace--half'); ?>
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
        <?php sheepie_partial('pagination', 'post'); ?>
        <footer class="article--full__footer">
            <hr class="vcenter--double">
            <div class="article--full__author">
                <?php sheepie_avatar_background_html(get_the_author_meta('ID'), 150, 'article--full__avatar'); ?>
                <div class="article--full__bio">
                    <h3 class="article--full__bio-blurb vspace--quarter">by <?php the_author_meta('display_name'); ?></h3>
                    <h4 class="text--small vspace--quarter"><?php the_tags(__('Tagged: ', 'sheepie'), ', '); ?></h4>
                    <p class="article--full__bio-blurb text--italic"><?php the_author_meta('user_description'); ?></p>
                </div>
            </div>
        </footer>
    <?php endif; ?>
</article>
