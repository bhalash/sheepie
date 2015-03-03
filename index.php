<?php get_header();
    global $paged;
    $count = 0;
    if (have_posts()) {
        while (have_posts()) {
            the_post();
            get_template_part('article', ($count == 0 && !is_search()) ? 'full' : 'archive');

            if ($count < get_option('posts_per_page')) {
                printf('<hr />');
            }

            $count++;
        }
    } else {
        get_template_part('article','missing');
    }

get_template_part('pagination');
get_footer(); ?>