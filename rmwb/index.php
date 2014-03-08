<?php get_header();  ?>
<div class="content-right">
    <div class="content-right-interior">
    <?php if (have_posts()) : ?>
        <?php while (have_posts()) : the_post(); ?>
            <article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
                <h3 class="post-title"><a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
                <p class="post-meta-top">
                    Posted by <a title="Find more posts by <?php the_author(); ?>" href="<?php echo home_url(); ?>/?s&author=<?php the_author(); ?>"><?php the_author(); ?></a> 
                    on <time><?php the_time(get_option('date_format')) ?>.</time> <?php comments_popup_link('', '1 Comment.', '% Comments.'); ?>
                    <?php edit_post_link('Edit post.', ' ', ''); ?>
                </p>
                <hr>
                <?php the_content('Read the rest of this post &raquo;'); ?>
            </article>
        <?php endwhile; else: ?>
            <p>Sorry, no posts match your criteria!</p>
        <?php endif; ?>
    <div class="site-nav">
        <div class="nav-left"><a href="#prev"></a></div>
        <div class="nav-right"><a href="#next"></a></div>
    </div>
    <?php get_footer(); ?>