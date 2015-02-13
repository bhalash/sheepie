<article <?php post_class(); ?> id="article-<?php the_ID(); ?>">
    <header>
        <?php if (!is_page()) : ?>
            <small><time datetime="<?php the_time('Y-m-d H:i'); ?>"><?php the_time(get_option('date_format')) ?></time> in <?php the_category(', '); ?></small>
        <?php endif; ?>
        <h3 class="title"><a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
    </header>
    <?php the_content('Read the rest of this post &raquo;'); ?>
    <footer>
        <small><?php edit_post_link('edit post', ' ', ''); ?></small>
    </footer>
</article>