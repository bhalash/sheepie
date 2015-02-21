<?php $category = get_the_category($post->ID); 
    
$related_posts = new WP_Query(array(
    'post_status' => 'published',
    'cat' => $category[0]->cat_ID,
    'posts_per_page' => 20,
    'orderby' => 'rand',
    'order' => 'DESC',
    'post__not_in' => array(
        get_the_ID()
    ),
    'date_query' => array(
        'inclusive' => false,
        'after' => get_the_date('Y-m-j') . ' -180 days',
        'before' => get_the_date('Y-m-j') . ' -7 days',
    )
)); 

if ($related_posts->have_posts()) {
    printf('<hr><div class="%s">', 'related-articles');
    $count = 0;

    while ($related_posts->have_posts()) {
        if ($count >= 3) {
            break;
        }

        $related_posts->the_post();
        get_template_part('article', 'related');
        $count++;
    }

    printf('</div>');
}

wp_reset_postdata(); ?>