<article <?php post_class('archive'); ?> id="article-<?php the_ID(); ?>">
    <header>
        <?php if (!is_page()) : ?>
            <small><time datetime="<?php the_time('Y-m-d H:i'); ?>"><?php the_time(get_option('date_format')) ?></time> in <?php the_category(', '); ?></small>
        <?php endif; ?>
        <h3 class="title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h3>
    </header>
    <div class="excerpt">
        <?php the_excerpt(); ?>
        <?php // printf('<p>"%s..."</p>', rmwb_excerpt()); ?>
    </div>
    <footer>
        <small><?php edit_post_link('edit post', ' ', ''); ?></small>
    </footer>
</article>