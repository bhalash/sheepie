<div class="post-comments">
    <?php if (post_password_required()) : ?>
        <p>This post is password protected. Enter the password to view comments.</p>
    <?php return; endif; ?>
    <?php if (have_comments()) : ?>
        <h3 class="comment-header"><?php comments_number('No Comments:', '1 Comment:', '% Comments:');?></h3>
        <?php wp_list_comments(
            array( 
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
    <h3 class="comment-header">Say something witty:</h3>
    <p>Your email address will not be published. Required fields are marked *:</p>
    <form class="commentform">
        <p class="comment-author-info">
            <input class="comment-name" name="comment-name" placeholder="Name*" type="text">
            <input class="comment-email" name="comment-email" placeholder="Email*" type="email">
            <input class="website" name="comment-website" placeholder="Website" type="url">
            <textarea class="comment-text" name="comment-text" rows="10"></textarea><br />
            <input class="comment-submit" type="submit" value="Post Comment" />
        </p>
    </form>
</div>
