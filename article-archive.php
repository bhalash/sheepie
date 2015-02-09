<article <?php post_class('archive-article'); ?> id="article-<?php the_ID(); ?>" style="background-image: url('<?php echo content_first_image(); ?>');">
    <div class="mask">
        <a href="<?php the_permalink(); ?>" rel="bookmark">
            <header>
                <?php if (!is_page()) : ?>
                    <p><small><time datetime="<?php the_time('Y-m-d H:i'); ?>"><?php the_time(get_option('date_format')) ?></time></small></p>
                <?php endif; ?>
                <h3><?php the_title(); ?></h3>
            </header>
            <?php printf('<p class="excerpt">"%s..."</p>', rmwb_excerpt()); ?>
        </a>
        <footer>
            <small><?php edit_post_link('edit post', ' ', ''); ?></small>
        </footer>
    </div>
</article>