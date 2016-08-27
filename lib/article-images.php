<?php

/**
 * Article Image Functions
 * -----------------------------------------------------------------------------
 * This script contains a number of functions that expand the image functions in
 * WordPress. I do not use the WordPress media manage on my own blog. I am in
 * blogging for the long term, and expect to move away from WordPres eventually.
 *
 * Because of this, I use the first image found in content as the featured image
 * on my posts.
 *
 * This library is self-contained and aimed at developers who might appreciate
 * a wider range of functinos for their own WordPress project. :)
 *
 * @category   PHP Script
 * @package    WordPress Article Images
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2015 Mark Grealish
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU GPL v3.0
 * @version    1.5
 * @link       https://github.com/bhalash/article-images
 */

/**
 * Set Fallback Image Path and URL
 * -----------------------------------------------------------------------------
 * This runs during WordPress init, or whenever else you call it. If the option
 * hasn't been set, or $fallback isn't null, it'll set up the image. Correct
 * format is up to yourself.
 *
 * @param   array       $fallback       Fallback images.
 * @return  array       $fallback       Fallback images array.
 */

function set_post_fallback_image($fallback = null) {
    if ($fallback || !get_option('article_images_fallback') || WP_DEBUG) {
        $fallback = $fallback ?: [
            // Web-accessible URL from directory path.
            'url' => str_replace($_SERVER['DOCUMENT_ROOT'], get_site_url(), __DIR__) . '/fallback.jpg',
            // Path on the local filesystem relative current directory.
            'path' => __DIR__ . '/fallback.jpg',
        ];

        update_option('article_images_fallback', $fallback, true);
        return $fallback;
    }
}

add_action('init', 'set_post_fallback_image', 10, 1);

/**
 * Get Fallback Image Path
 * -----------------------------------------------------------------------------
 * @return  string      $image          Fallback image path.
 */

function fallback_image_path() {
    $image = get_option('article_images_fallback') ?: set_post_fallback_image();
    return $image['path'];
}

/**
 * Get Fallback Image URL
 * -----------------------------------------------------------------------------
 * @return  string      $image          Fallback image URL.
 */

function fallback_image_url() {
    $image = get_option('article_images_fallback') ?: set_post_fallback_image();
    return $image['url'];
}

/**
 * Determine if Post Content has Image
 * -----------------------------------------------------------------------------
 * Because I habitually do not use post thumbnails, I need to instead determine
 * whether the post's content has an image, and thereafter I grab the first one.
 *
 * This extends the functionality of has_post_thumbnail() to include post
 * content images.
 *
 * @param   int/object  $post           Post ID or post object.
 * @return  bool                        Post has any kind of image true/false.
 */

function has_post_image($post) {
    if (!($post = get_post($post))) {
        return false;
    }

    return has_post_thumbnail($post->ID) || has_post_content_image($post);
}

/**
 * See if Post Content Contains Image
 * -----------------------------------------------------------------------------
 * @param   int/object  $post           Post ID or post object.
 * @return  bool                        Post content has image, true/false.
 */

function has_post_content_image($post) {
    if (!($post = get_post($post))) {
        return false;
    }

    return !!preg_match('/<img\s.*?src=".*?\/>/', $post->post_content);
}

/**
 * Return Thumbnail Image URL
 * -----------------------------------------------------------------------------
 * WordPress, by default, only has a handy function to return a glob of HTML-an
 * image inside an anchor-for a post thumbnail. This wrapper extracts and
 * returns only the URL.
 *
 * @param   int/object  $post           Post ID or post object.
 * @param   string      $size           The requested size of the thumbnail.
 * @return  string                      Thumbnail URL.
 */

function post_thumbnail_url($post, $size = 'large') {
    if (!($post = get_post($post))) {
        return '';
    }

    $thumb_id = get_post_thumbnail_id($post->ID);
    return wp_get_attachment_image_src($thumb_id, $size, true)[0];
}

/**
 * Post Attachment Filesystem Path
 * -----------------------------------------------------------------------------
 * @param   int/object  $post           Post ID or post object.
 * @param   string      $size           The requested size of the thumbnail.
 * @return  string                      Filesystem path to the attachment.
 */

function post_thumbnail_path($post, $size = 'large') {
    if (!($post = get_post($post))) {
        return '';
    }

    return get_attached_file(get_post_thumbnail_id($post->ID), 'large');
}

/**
 * Retrieve First Content Image
 * -----------------------------------------------------------------------------
 * I chose not to use the featured image feature in WordPress, because
 * I do not want to be ultimately tied to WordPress as a blogging CMS.
 *
 * This functions extracts and returns the first found image in the post,
 * no matter what that image happens to be.
 *
 * @param   int/object  $post           Post ID or post object.
 * @return  string                      Full URL of the first image found.
 * @link    http://goo.gl/WIloQw
 */

function content_first_image($post) {
    if (!($post = get_post($post))) {
        return '';
    }

    preg_match('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $image);
    return (count($image) > 1 && !empty($image[1])) ? $image[1] : '';
}

/**
 * Get Post Image
 * -----------------------------------------------------------------------------
 * Returns an image in this order:
 *
 * 1. Specified post thumbnail in it's large size.
 * 2. First image in post's content.
 * 3. Sitewide fallback image.
 *
 * @param   int/object  $post           Post ID or post object.
 * @param   bool        $echo           Echo image, true/false.
 * @param   string      $size           Desired size, if WordPress image.
 * @return  string                      Thumbnail image, if it exists.
 */

function post_image_url($post, $echo = false, $size = 'large') {
    if (!($post = get_post($post))) {
        return '';
    }

    $image = fallback_image_url();

    if (has_post_thumbnail($post->ID)) {
        $image = post_thumbnail_url($post, $size);
    } else if (has_post_content_image($post)) {
        $image = content_first_image($post);
    }

    if (!$echo) {
        return $image;
    }

    printf($image);
}

/**
 * Content First Image Filesystem Path
 * -----------------------------------------------------------------------------
 * @param   int/object  $post           Post ID or post object.
 * @param   bool        $echo           Echo image, true/false.
 * @param   string      $size           Desired size, if WordPress image.
 * @return  string                      Filesystem path to the attachment.
 */

function post_image_path($post, $echo = false, $size = 'large') {
    if (!($post = get_post($post))) {
        return '';
    }

    $image = fallback_image_path();

    if (has_post_thumbnail($post->ID)) {
        $image = post_thumbnail_path($post, $size);
    } else if (has_post_content_image($post)) {
        $image = url_to_path(content_first_image($post));
    }

    if (!$echo) {
        return $image;
    }

    printf($image);
}

/**
 * Wrap Post Image as Background Style
 * -----------------------------------------------------------------------------
 * @param   int/object  $post           Post ID or post object.
 * @param   bool        $echo           Echo image, true/false.
 * @param   string      $size           Desired size, if WordPress image.
 * @return  string      $image          The image, wrapped as background-image.
 */

function post_image_url_style($post, $echo = false, $size = 'large') {
    if (!($post = get_post($post))) {
        return '';
    }

    $image = sprintf('style="background-image: url(%s);"', post_image_url($post));

    if (!$echo) {
        return $image;
    }

    printf($image);
}

/**
 * Wrap Post Image as <img>
 * -----------------------------------------------------------------------------
 * @param   int/object  $post           Post ID or post object.
 * @return  string      $image          The image, wrapped as <img>
 */

function post_image_url_html($post, $echo = false, $alt = '', $size = 'large') {
    if (!($post = get_post($post))) {
        return '';
    }

    $image = sprintf('<img class="%s" src="%s" alt="%s" />',
        'post-image post-thumbnail',
        post_image_url($post, $size),
        $alt ?: the_title_attribute(['post' => $post, 'echo' => false])
    );

    if (!$echo) {
        return $image;
    }

    printf($image);
}

/**
 * Convert URL to Filesystem Path
 * -----------------------------------------------------------------------------
 * /This does not guarantee the file or folder exists/. You must independently
 * test for its existence!
 *
 * @param   string      $url            URL to be converted into a local path.
 * @return  string                      Path converted from the URL.
 */

function url_to_path($url) {
    $url = preg_replace('/^http(s?):\/\//', '', $url);
    $url = preg_replace('/^www\./', '', $url);
    return sprintf('%s/%s', dirname($_SERVER['DOCUMENT_ROOT']), $url);
}

/**
 * Get Post Image Dimensions
 * -----------------------------------------------------------------------------
 * This function uses the same logical priority as get_post_image, with
 * modifications:
 *
 * 1. Dimensions of specified post thumbnail in it's large size.
 * 2. Dimensions of first image in post's content.
 * 3. Dimensions of sitewide fallback image.
 *
 * The modification is for #2, the content image. If the URL isn't explicitly
 * local, then the URL is first tested as local and then fetched remotely if
 * that fails.
 *
 * @param   string      $image          Path to local image.
 * @return  array                       The dimensions of the image.
 */

function get_local_image_dimensions($image) {
    return file_exists($image) ? array_slice(getimagesize($image), 0, 2) : [0,0];
}

?>
