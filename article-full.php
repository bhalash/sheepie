<article <?php post_class('full'); ?> id="article-<?php the_ID(); ?>">
    <header>
        <?php if (!is_single()) : ?>
            <h3 class="title"><a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
            <?php if (!is_page()) : ?>
                <small><time datetime="<?php the_time('Y-m-d H:i'); ?>"><?php the_time(get_option('date_format')) ?></time> in <?php the_category(', '); edit_post_link('edit post', ' / ', ''); ?></small>
            <?php endif; ?>
        <?php endif; ?>
    </header>
    <?php the_content('Read the rest of this post &raquo;'); ?>
    <?php if (is_single()) : ?>
        <hr>
        <footer>
            <div class="avatar-wrapper">
                <?php echo get_avatar(get_the_author_meta('ID'), 96); ?>
            </div>
            <div class="author-info">
                <p><small><time datetime="<?php the_time('Y-m-d H:i'); ?>"><?php the_time(get_option('date_format')) ?></time> in <?php the_category(', '); edit_post_link('edit post', ' / ', ''); ?></small></p>
                <h4><?php the_author_meta('display_name'); ?></h4>
                <p><?php the_author_meta('user_description'); ?></p>
            </div>
        </footer>
    <?php endif; ?>
 </article>