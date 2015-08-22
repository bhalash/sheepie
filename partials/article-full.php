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
    <?php partial('postheader'); ?>
    <div class="main">
        <?php the_content(__('Read the rest of this post &raquo;', TTD)); ?>
    </div>

    <?php if (is_single()) : ?>
        <?php partial('pagination'); ?>
        <hr>
        <footer>
            <div class="avatar">
                <?php avatar_background($author, 96, 'author-photo'); ?>
            </div>
            <div class="author-info">
                <p>
                    <small><?php partial('postmeta'); ?></small>
                </p>
                <h4><?php the_author_meta('display_name'); ?></h4>
                <p><?php the_author_meta('user_description'); ?></p>
            </div>
        </footer>
    <?php endif; ?>
</article>
