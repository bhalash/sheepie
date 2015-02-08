<?php get_header();

if (have_posts()) {
    while (have_posts()) {
        the_post();
        get_template_part('article', 'full');
    }
} else {
    get_template_part('article', 'missing');
}

get_footer(); ?>