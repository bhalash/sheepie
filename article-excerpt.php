<article <?php post_class(); ?> id="article-<?php the_ID(); ?>">
    <header>
        <small><time datetime="<?php the_time('Y-m-d H:i'); ?>"><?php the_time(get_option('date_format')) ?></time> in <?php the_category(', '); ?></small>
        <h3><a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
    </header>
    <?php the_excerpt('Read the rest of this post &raquo;'); ?>
    <footer>
        <small><?php edit_post_link('edit post', ' ', ''); ?></small>
    </footer>
</article>