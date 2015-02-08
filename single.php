<?php get_header();

if (have_posts()) {
    while (have_posts()) {
        the_post();
        get_template_part('article', 'full');
        // FIXME
        comments_template();
    }
} else {
    get_template_part('article', 'missing');
}

get_footer(); ?>