<div class="post-comments">
    <?php if (post_password_required()) : ?>
        <p>This post is password protected. Enter the password to view comments.</p>
    <?php return; endif; ?>
    <?php if (have_comments()) : ?>
        <h3 class="comment-reply-title"><?php comments_number('No Comments:', '1 Comment:', '% Comments:');?></h3>
        <?php wp_list_comments(
            array ( 
                'callback' => 'rmwb_comments',
                'avatar_size' => 0,
                'style' => 'div'
            )
        ); ?>
     <?php else : ?>
        <?php if (comments_open()) : ?>
            <?php else : ?>
                <?php if(!is_page()) : ?>
                    <p class="nocomments">Comments are closed.</p>
                <?php endif; ?>
        <?php endif; ?>
    <?php endif; ?>
</div>
<div class="comment-entry">
    <?php 
    $comment_form_fields = array (
        'author' => '<input class="comment-author" name="comment-author" placeholder="Name*" type="text">',
        'email' => '<input class="comment-email" name="comment-email" placeholder="Email*" type="email">',
        'url' => '<input class="website" name="comment-website" placeholder="Website" type="url">'
        );

    comment_form( 
        array (
            'title_reply' => 'Say something witty:',
            'comment_field' => '<textarea class="comment-text" name="comment-text" rows="10"></textarea><br />',
            'label_submit' => 'Post Comment',
            'fields' => $comment_form_fields
        )
    ); ?>
</div>