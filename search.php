<?php get_header();
    global $wp_query; 
    $count = 0;
    $result_count = search_results_count(get_query_var('paged'), $wp_query->found_posts);

    if (have_posts()) {
        printf('<h5>%s for \'%s\'</h5>', $result_count, get_search_query());

        ?>
        <div class="page-search">
            <?php get_search_form(); ?>
        </div>
        <p class="results-count">Sort results by <a href="<?php bloginfo('url');?>?s=<?php echo get_search_query();?>&orderby=post_date&order=DESC">date</a> | <a href="<?php bloginfo('url');?>?s=<?php echo get_search_query();?>&orderby=relevance&order=DESC">relevance</a></p>
        <div class="archive">
        <?php 

        while (have_posts()) {
            the_post();  

            if ($count > 0) {
                printf('<hr />');
            }

            get_template_part('article', ($count == 0) ? 'full' : 'archive');
            $count++;
        }
    } else {
        get_template_part('article','missing');
    }

printf('</div>');
get_template_part('pagination');
get_footer(); ?>