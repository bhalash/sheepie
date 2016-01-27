<?php

/**
 * Single Post Template
 * -----------------------------------------------------------------------------
 * @category   PHP Script
 * @package    Sheepie
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2015 Mark Grealish
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU GPL v3.0
 * @version    1.0
 * @link       https://github.com/bhalash/sheepie
 */

get_header();
sheepie_partial('gohome');

if (have_posts()) {
    while (have_posts()) {
        the_post();
        sheepie_partial('article', 'full');

        if (function_exists('rp_get_related')) {
            printf('<hr class="%s">', 'vcenter--double noprint');
            printf('<div class="%s">', 'related flex--three-col--article noprint');

            $related = rp_get_related([
                'range' => [
                    'after' => date('Y-m-j') . '-180 days',
                    'before' => date('Y-m-j')
                ]
            ]);

            foreach ($related as $post) {
                setup_postdata($post);
                sheepie_partial('article', 'related');
            }

            printf('</div>');
            wp_reset_postdata();
        }

        comments_template();
    }
} else {
    sheepie_partial('article', 'missing');
}

get_footer();

?>
