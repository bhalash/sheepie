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
    <header class="article--related__header vspace--half">
        <a class="article--related__link" href="<?php the_permalink(); ?>" rel="bookmark" <?php post_image_url_style($post, true); ?>>
            <span class="title article--related__title"><?php the_title(); ?></span><br />
        </a>
    </header>
</article>
