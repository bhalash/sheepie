<?php

/**
 * Tag Archive Template
 * -----------------------------------------------------------------------------
 * @category   PHP Script
 * @package    Sheepie
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2015 Mark Grealish
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU GPL v3.0
 * @version    1.0
 * @link       https://github.com/bhalash/sheepie
 */

$tag = get_tag(get_query_var('tag_id'));

get_header();
sheepie_partial('gohome');

printf('<h2 class="%s"><a href="%s">%s</a></h2>',
    'title vspace--double',
    get_tag_link($tag->term_taxonomy_id),
    $tag->name
);

$tag_posts = get_posts(array(
    'posts_per_page' => 30,
    'orderby' => 'date',
    'tax_query' => array(
        'taxonomy' => $tag->taxonomy,
        'field' => 'slug',
        'terms' => $tag->slug
    )
));

foreach ($tag_posts as $post) {
    setup_postdata($post);
    sheepie_partial('article', 'excerpt');
}

wp_reset_query();

printf('<hr class="%s">', 'vcenter--triple');
sheepie_partial('pagination', 'site');
get_footer();

?>
