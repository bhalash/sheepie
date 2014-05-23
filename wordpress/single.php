<?php get_header(); ?>
<div class="content-right">
    <div class="content-right-interior">
    <?php if (have_posts()) : ?>
        <?php while (have_posts()) : the_post(); ?>
            <article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
                <h3 class="post-title"><?php the_title(); ?></a></h3>
                <p class="post-meta-top">
                    Posted by <a title="Find more posts by <?php the_author(); ?>" href="<?php echo home_url(); ?>/?s&author=<?php the_author(); ?>"><?php the_author(); ?></a> 
                    on <time><?php the_time(get_option('date_format')) ?>.</time> <?php comments_popup_link('', '1 Comment.', '% Comments.'); ?>
                    <?php edit_post_link('Edit post.', ' ', ''); ?>
                </p>
                <?php the_content('Read the rest of this post &raquo;'); ?>
                <p class="post-meta-bottom">
                    <strong>Tagged:</strong> <?php the_tags('', ', ' ,  ''); ?><br />
                    <strong>Categorized:</strong> <?php the_category(', '); ?><br />
                    <strong>Admin:</strong> <?php edit_post_link('edit post', ' ', ''); ?>
                </p>
            </article>
        <?php endwhile; else: ?>
            <article> 
                <h3 class="post-title">No joy, sorry</h3>
                <p>Sorry, no posts were found that match your criteria!</p>
            </article>
        <?php endif; ?>
    <?php comments_template(); ?> 
    <?php get_footer(); ?>