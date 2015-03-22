<?php get_header();

if (have_posts()) {
    while (have_posts()) {
        the_post();
        get_template_part('article', 'full');
        get_template_part('pagination');
        get_template_part('related');
        comments_template();
    }
} else {
    get_template_part('article', 'missing');
}

get_footer(); ?>