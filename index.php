<?php get_header();

    $count = 0;
    if (have_posts()) {
        while (have_posts()) {
            the_post();

            if ($count > 0) {
                printf('<hr />');
            }
                
            get_template_part('article', 'full');
            $count++;
        }
    } else {
        get_template_part('article','missing');
    }

include('pagination.php');
get_footer(); ?>