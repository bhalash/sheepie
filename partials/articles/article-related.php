<?php

/**
 * Related Article Template
 * -----------------------------------------------------------------------------
 * @category   PHP Script
 * @package    Sheepie
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2015 Mark Grealish
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU General Public License v3.0
 * @version    3.0
 * @link       https://github.com/bhalash/sheepie
 */

?>

<article <?php post_class('related columnar'); ?> id="article-<?php the_ID(); ?>">
    <header>
        <a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
            <div class="related-thumbnail <?php header_class($post->ID); ?>" <?php post_image_css($post->ID, true); ?>></div>
            <h6 class="title"><?php the_title(); ?></h6>
        </a>
        <?php if (!is_page()) : ?>
            <small><time datetime="<?php the_time('Y-m-d H:i'); ?>"><?php the_time(get_option('date_format')) ?></time></small>
        <?php endif; ?>
    </header>
    <footer>
        <span><small><?php edit_post_link('edit post', ' ', ''); ?></small></span>
    </footer>
</article>
