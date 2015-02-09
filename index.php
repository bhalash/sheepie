<?php get_header();
    global $paged;
    $count = 0;
    if (have_posts()) {
        while (have_posts()) {
            the_post();

            if ($count > 0) {
                printf('<hr />');
            }

            get_template_part('article', ($count == 0 && $paged == 0) ? 'full' : 'archive');
            $count++;
        }
    } else {
        get_template_part('article','missing');
    }

get_template_part('pagination');
get_footer(); ?>