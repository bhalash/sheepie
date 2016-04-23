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

<article <?php post_class(['full', 'article']); ?> id="article--<?php the_ID(); ?>">
    <header class="full__header vspace--full">
        <h3 class="title full__title vspace--quarter">
            <?php sheepie_partial('posttitle'); ?>
        </h3>
        <?php if (!is_page()) : ?>
            <?php echo sheepie_postmeta('h4', 'noprint vspace--half'); ?>
        <?php endif; ?>
    </header>
    <div class="full__content vspace--double">
        <?php the_content(__('Read the rest of this post &raquo;', 'sheepie')); ?>
    </div>

    <?php wp_link_pages(array(
        'before' => sprintf('<p class="%s">%s', 'pagination--article page-links', __('Page: ', 'sheepie')),
        'after' => '</p>'
    )); ?>

    <?php if (is_single()) : ?>
        <hr class="vcenter--double crimp">
        <footer class="footer vspace--double">
            <div class="footer__author">
                <?php echo sheepie_avatar(get_the_author_meta('ID'), get_the_author(), 'footer__avatar', ['size' => 150]); ?>
                <div class="footer__bio">
                    <h3 class="vspace--quarter title">by <?php the_author_meta('display_name'); ?></h3>
                    <h4 class="vspace--quarter meta"><?php the_tags(__('Tagged: ', 'sheepie'), ', '); ?></h4>
                    <p><?php the_author_meta('user_description'); ?></p>
                </div>
            </div>
        </footer>
    <?php else : ?>
        <hr class="vcenter--triple">
    <?php endif; ?>
</article>
