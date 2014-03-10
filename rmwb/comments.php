<div class="post-comments">
    <?php if (post_password_required()) : ?>
        <h3 class="comment-reply-title">This post is password protected. Enter the password to view comments.</h3>
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
                    <h3 class="comment-reply-title">Comments are closed.</h3>
                <?php endif; ?>
        <?php endif; ?>
    <?php endif; ?>
</div>
<div class="comment-entry">
    <?php 
    $comment_form_fields = array (
        'author' => '<input aria-required="true" class="comment-form-author" id="author" name="author" placeholder="Name*" type="text">',
        'email' => '<input aria-required="true" class="comment-form-email" id="email" name="email" placeholder="Email*" type="email">',
        'url' => '<input aria-required="true" class="comment-form-url" id="url" name="url" placeholder="Website" type="url">'
        );

    comment_form( 
        array (
            'title_reply' => 'Say something witty:',
            'comment_field' => '<p><textarea aria-required="true" class="comment-form-comment" id="comment" name="comment" rows="10"></textarea></p>',
            'fields' => $comment_form_fields
        )
    ); ?>
</div>