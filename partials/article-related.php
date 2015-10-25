<?php

/**
 * Related Article Template
 * -----------------------------------------------------------------------------
 * @category   PHP Script
 * @package    Sheepie
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2015 Mark Grealish
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU GPL v3.0
 * @version    1.0
 * @link       https://github.com/bhalash/sheepie
 */

$post_classes = array('article', 'article--related', 'vspace--half');

?>

<article <?php post_class($post_classes); ?> id="article--related--<?php the_ID(); ?>">
    <a class="article--related__link" href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
        <header class="article--related__header vspace--half">
                <div class="thumbnail article--related__thumbnail" <?php post_image_css($post->ID, true); ?>></div>
        </header>
        <h4 class="title article--related__title vspace--quarter">
            <?php the_title(); ?>
        </h4>
    </a>
    <footer class="article--related__footer">
        <h4 class="font--small"><?php sheepie_postmeta(); ?></h4>
    </footer>
</article>
