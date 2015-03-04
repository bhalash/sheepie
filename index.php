<?php get_header();
    global $paged;

    if (get_query_var('paged') > 1) {
        get_template_part('pagination');
        printf('<hr />'); 
    }
    
    if (have_posts()) {
        while (have_posts()) {
            the_post();
            get_template_part('article', 'archive');
            printf('<hr />');
        }
    } else {
        get_template_part('article','missing');
    }

get_template_part('pagination');
get_footer(); ?>