<?php get_header();
    global $paged;

    get_template_part('pagination');
    printf('<hr />'); 
    
    if (have_posts()) {
        while (have_posts()) {
            the_post();
            // get_template_part('article', 'excerpt');
            get_template_part('article', 'full');
            printf('<hr class="double-margin" />');
        }
    } else {
        get_template_part('article','missing');
    }

get_template_part('pagination');
get_footer(); ?>