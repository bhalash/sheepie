<?php $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$next = $paged + 1; 
$previous = $paged - 1; ?>

<?php if (is_single()) : ?>
    <hr>
<?php endif; ?>
<nav id="pagination">
    <div class="previous<?php echo (is_single()) ? '-post' : ''; ?>">
        <?php if (is_single()) {
            next_post_link('%link', '&larr; %title', false);
        } else {
            previous_posts_link('&larr; Page ' . $previous);
        } ?>
    </div>

    <div class="count"><?php if (!is_single()) : ?><span><?php archive_page_count(); ?></span><?php endif; ?></div>

    <div class="next<?php echo (is_single()) ? '-post' : ''; ?>">
        <?php if (is_single()) {
            previous_post_link('%link', '%title &rarr;', false);
        } else {
            next_posts_link('Page ' . $next . ' &rarr;'); 
        } ?>
    </div>
</nav>