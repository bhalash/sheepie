<?php get_header();
if (is_search()) {
    global $wp_query; 
    $count = 0;
    $result_count = search_results_count(get_query_var('paged'), $wp_query->found_posts);
}

if (is_search()) {
    if (have_posts()) {
        get_search_form();

        while (have_posts()) {
            the_post();  

            if ($count > 0) {
                printf('<hr />');
            }

            get_template_part('article', 'excerpt');
            $count++;
        }
    } else {
        get_template_part('article','missing');
    }
}

if (is_search()) {
    get_template_part('pagination');
}

get_footer(); ?>