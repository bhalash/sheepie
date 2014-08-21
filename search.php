<?php get_header(); ?>
<div class="right-wrap">
    <div class="content">
        <?php get_search_form(); ?>
        <div class="hidden search-query-hidden"><?php echo get_search_query(); ?></div>
        <?php if (have_posts()) : ?>
            <p class="search-info">
                <?php global $wp_query; search_results_count(get_query_var('paged'), $wp_query->found_posts); ?> 
                <span>Sort results by <a href="<?php bloginfo('url');?>?s=<?php echo get_search_query();?>&orderby=post_date&order=DESC">date</a> | <a href="<?php bloginfo('url');?>?s=<?php echo get_search_query();?>&orderby=relevance&order=DESC">relevance</a></span>
            </p>
            <hr />
            <?php while (have_posts()) : the_post(); ?>
                <article <?php post_class(); ?> id="article-<?php the_ID(); ?>">
                    <h2>
                        <a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a>
                    </h2>
                    <?php the_excerpt('Read the rest of this post &raquo;'); ?>
                    <p class="meta">
                        <?php $year = get_the_time('Y'); ?>
                        <?php $month = get_the_time('m'); ?>
                        <small>
                            by <a title="Find more posts by <?php the_author(); ?>" href="<?php echo home_url(); ?>/?s&author=<?php the_author(); ?>"><?php the_author(); ?></a>
                            - <time datetime="<?php the_time('Y-m-d H:i'); ?>"><a href="<?php echo get_month_link($year, $month); ?>"><?php the_time(get_option('date_format')) ?></a></time>
                            <br />
                            <?php edit_post_link('Edit post.', ' ', ''); ?>
                        </small>
                    </p>
                </article>
            <?php endwhile; ?>
        <?php else : ?>
            <article> 
                <h3>No joy, sorry</h3>
                <p>Sorry, no posts were found that match your criteria!</p>
            </article>
        <?php endif; ?>
        <div class="pagination">
            <div class="left">
                <?php previous_posts_link('&#8592; Previous Page'); ?>
            </div>
            <div class="right">
                <?php next_posts_link('Next Page &#8594;'); ?>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>