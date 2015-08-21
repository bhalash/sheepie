<?php

/**
 * Missing Article Template
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

<article <?php post_class(); ?> id="article-<?php the_ID(); ?>">
    <header>
        <h3><?php _e('Article not found.', TTD); ?></h3>
    </header>
    <div class="main">
        <p><?php _e('No posts were found that match your criteria! :(', TTD); ?></p>
    </div>
</article>
