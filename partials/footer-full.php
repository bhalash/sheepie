<?php

/**
 * Full Article Footer
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

<hr>
<footer>
    <div class="avatar-wrapper">
        <?php printf(get_avatar(get_the_author_meta('ID'), 96)); ?>
    </div>
    <div class="author-info">
        <p><small><time datetime="<?php the_time('Y-m-d H:i'); ?>"><?php the_time(get_option('date_format')) ?></time> in <?php the_category(', '); edit_post_link('edit post', ' / ', ''); ?></small></p>
        <h4><?php the_author_meta('display_name'); ?></h4>
        <p><?php the_author_meta('user_description'); ?></p>
    </div>
</footer>
