<?php get_header(); ?>
<div class="content-right">
    <div class="interior">
        <?php if (have_posts()) : ?>
            <?php while (have_posts()) : the_post(); ?>
                <article <?php post_class(); ?> id="article-<?php the_ID(); ?>">
                    <h3 class="article-title"><a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
                    <p class="meta">
                        <?php edit_post_link('Edit page.', ' ', ''); ?>
                    </p>
                    <?php the_content('Read the rest of this post &raquo;'); ?>
                </article>
            <?php endwhile; ?> 
        <?php else: ?>
            <article> 
                <h3 class="article-title">No joy, sorry</h3>
                <p>Sorry, no posts were found that match your criteria!</p>
            </article>
        <?php endif; ?>
    </div>
</div>
<?php get_footer(); ?>