<?php get_header(); ?>
<?php if (have_posts()) : ?>
    <?php while (have_posts()) : ?>
        <article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
            <h1 class="post-title"><a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>
            <hr>
            <?php the_content('Read the rest of this post &raquo;'); ?>
        </article>
    <?php endwhile; ?>
<?php endif; ?>
<div class="site-nav">
    <div class="nav-left"><a href="#prev"></a></div>
    <div class="nav-right"><a href="#next"></a></div>
</div>
<?php get_footer(); ?>
