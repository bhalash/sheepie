<article <?php post_class('related'); ?> id="article-<?php the_ID(); ?>">
    <header>
        <div class="foobar" style="background-image: url('<?php echo content_first_image(); ?>');">
            <a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"></a>
        </div>
        <h5 class="title"><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h5>
        <?php if (!is_page()) : ?>
            <small><time datetime="<?php the_time('Y-m-d H:i'); ?>"><?php the_time(get_option('date_format')) ?></time></small>
        <?php endif; ?>
    </header>
    <footer>
        <small><?php edit_post_link('edit post', ' ', ''); ?></small>
    </footer>
</article>