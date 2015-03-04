<article <?php post_class(); ?> id="article-<?php the_ID(); ?>">
    <header>
        <h3 class="title"><a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
        <?php if (!is_page()) : ?>
            <small><time datetime="<?php the_time('Y-m-d H:i'); ?>"><?php the_time(get_option('date_format')) ?></time> in <?php the_category(', '); edit_post_link('edit post', ' / ', ''); ?></small>
        <?php endif; ?>
    </header>
    <?php the_content('Read the rest of this post &raquo;'); ?>
    <footer>
        <hr />
        <?php get_template_part('pagination'); ?>
        <hr />
        <h4><?php the_author_meta('display_name'); ?></h4>
        <p><?php the_author_meta('description'); ?></p>
    </footer>
</article>