<div class="post-comments">
<?php $args = array(
    'walker'            => null,
    'max_depth'         => '',
    'style'             => 'ul',
    'callback'          => null,
    'end-callback'      => null,
    'type'              => 'all',
    'page'              => '',
    'per_page'          => '',
    'avatar_size'       => 0,
    'reverse_top_level' => null,
    'reverse_children'  => ''
); ?>
<?php if (post_password_required()) : ?>
    <p>This post is password protected. Enter the password to view comments.</p>
<?php return; endif; ?>
<?php if (have_comments()) : ?>
    <h3 class="comment-header"><?php comments_number('No Comments', '1 Comment', '% Comments');?></h3>
    <hr>
    <ul class="commentlist">
        <?php wp_list_comments($args); ?>
    </ul>
 <?php else : ?>
    <?php if (comments_open()) : ?>
        <?php else : ?>
            <?php if(!is_page()) : ?>
                <p class="nocomments">Comments are closed.</p>
            <?php endif; ?>
    <?php endif; ?>
<?php endif; ?>
</div>