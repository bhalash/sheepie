<?php get_header();
    global $wp_query; 
    $count = 0;
    $result_count = search_results_count(get_query_var('paged'), $wp_query->found_posts);

    if (have_posts()) {
        printf('<h5>%s for \'%s\'</h5>', $result_count, get_search_query());
        get_search_form();
        
        ?>
        <p class="results-count">Sort results by <a href="<?php bloginfo('url');?>?s=<?php echo get_search_query();?>&orderby=post_date&order=DESC">date</a> | <a href="<?php bloginfo('url');?>?s=<?php echo get_search_query();?>&orderby=relevance&order=DESC">relevance</a></p>
        <hr />
        <?php 

        while (have_posts()) {
            the_post();

            if ($count > 0) {
                printf('<hr />'); 
            }
            
            $count++;
            get_template_part('article', 'excerpt');
        }
    } else {
        get_template_part('article','missing');
    }

get_footer(); ?>