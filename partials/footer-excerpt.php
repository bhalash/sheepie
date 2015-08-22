<?php

/**
 * Excerpt Article Footer
 * -----------------------------------------------------------------------------
 * @category   PHP Script
 * @package    Sheepie
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2015 Mark Grealish
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU GPL v3.0
 * @version    3.0
 * @link       https://github.com/bhalash/sheepie
 */

if (!is_page()) : ?>
    <footer>
        <p>
            <small>
                <time datetime="<?php the_time('Y-m-d H:i'); ?>">
                    <?php the_time(get_option('date_format')) ?>
                </time> in <?php the_category(', '); edit_post_link('edit post', ' / ', ''); ?>
            </small>
        </p>
    </footer>
<?php endif; ?>
