<?php $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$next = $paged + 1; 
$previous = $paged - 1; ?>

<div id="pagination">
    <div class="previous">
        <?php previous_posts_link('&larr; Page ' . $previous); ?>
    </div>
    <div class="next">
        <?php next_posts_link('Page ' . $next . ' &rarr;'); ?>
    </div>
</div>