<?php $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$next = $paged + 1; 
$previous = $paged - 1; ?>

<nav id="pagination">
    <span class="previous">
        <?php if (is_single()) {
            next_post_link('&larr; %link');
        } else {
            previous_posts_link('&larr; Page ' . $previous);
        } ?>
    </span>
    <?php if (!is_single()) : ?> 
        <span class="count"><?php archive_page_count(); ?></span>
    <?php endif; ?>
    <span class="next">
        <?php if (is_single()) {
            previous_post_link('%link &rarr;');
        } else {
            next_posts_link('Page ' . $next . ' &rarr;'); 
        } ?>
    </span>
</nav>