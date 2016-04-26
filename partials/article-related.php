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

?>

<article <?php post_class(['vspace--half', 'article', 'related']); ?> id="article--<?php the_ID(); ?>">
    <header class="vspace--half">
        <h4 class="title">
            <a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
        </h4>
    </header>
    <p class="related__excerpt text--small">
        <?php if (strlen(get_the_excerpt()) < 40) : ?>
            <a class="related__thumbnail" href="<?php the_permalink(); ?>" rel="bookmark" <?php post_image_url_style($post, true); ?>></a>
        <?php else: ?>
            <?php echo substr(get_the_excerpt(), 0, 200); ?>...
        <?php endif; ?>
    </p>
</article>
