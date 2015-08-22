<?php

/**
 * Related Article Template
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

<article <?php post_class('related'); ?> id="article-<?php the_ID(); ?>">
    <header>
        <a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
            <div class="excerpt-thumbnail thumbnail <?php header_class($post->ID); ?>" <?php post_image_css($post->ID, true); ?>></div>
            <h6 class="title"><?php the_title(); ?></h6>
        </a>
        <?php if (!is_page()) : ?>
            <small><?php partial('postmeta'); ?></small>
        <?php endif; ?>
    </header>
</article>
