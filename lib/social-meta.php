<?php

/**
 * Site Header Social Meta
 * -----------------------------------------------------------------------------
 *  Social Meta generates
 *
 * @category   PHP Script
 * @package    Social Meta
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2015 Mark Grealish
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU GPL v3.0
 * @version    3.1
 * @link       https://github.com/bhalash/social-meta
 *
 * This file is part of Social Meta.
 *
 * Social Meta is free software: you can redistribute it and/or modify it under
 * the terms of the GNU General Public License as published by the Free Software
 * Foundation, either version 3 of the License, or (at your option) any later
 * version.
 *
 * Social Meta is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU General Public License for more
 * details
 *
 * You should have received a copy of the GNU General Public License along with
 * Social Meta. If not, see <http://www.gnu.org/licenses/>.
 */

if (!defined('ABSPATH')) {
    die('-1');
}

/**
 * Load Article Images (if it hasn't been loaded)
 * -----------------------------------------------------------------------------
 * This small standalone librairy is required to correctly get /any/ relevant
 * image from the post, and get its dimensions, for Facebook's Open Graph
 * reader.
 *
 * @link https://github.com/bhalash/article-images
 */

if (!function_exists('set_fallback_image')) {
    require_once('article-images.php');
}

class Social_Meta {
    static $instantiated = false;

    private static $errors = array(
        'unique' => 'Error: Social Meta may only be instantiated once.',
        'image' => 'Error: A fallback image must be provided. See README.md.',
        'facebook' => 'Error: a Facebook account must be provided.'
    );

    // Supplied Twitter and Facebook accounts.
    private static $facebook = null;
    private static $twitter = null;

    // Meta information array.
    public static $meta = [];

    public function __construct($args) {
        if (self::$instantiated) {
            /* Throw error if more than once instance is running, because more
             * than one instance leads to a mess of code in header */
            throw new Exception(self::$errors['unique']);
        }

        if (isset($args['fallback']) && get_option('article_images_fallback') !== $args['fallback']) {
            set_fallback_image($args['fallback_image']);
        }

        if (!isset($args['facebook'])) {
            throw new Exception(self::$errors['facebook']);
        }

        if (isset($args['twitter'])) {
            self::$twitter = $args['twitter'];
        }

        self::$facebook = $args['facebook'];
        self::$instantiated = true;
        add_action('wp_head', [$this, 'social_meta']);
    }

    /**
     * Output Open Graph and Twitter Card Tags
     * -------------------------------------------------------------------------
     * Call the Open Graph and Twitter Card functions.
     */

    public function social_meta() {
        if (!is_404() && !is_search()) {
            // Generate base social meta.
            $this->generate_post_meta();

            // Output Open Graph meta tags.
            $this->open_graph_tags();

            if (self::$twitter) {
                // Output Twitter Card meta tags, if set.
                $this->twitter_card_tags();
            }
        }
    }

    /**
     * Dynamic Excerpt
     * -------------------------------------------------------------------------
     * WordPress's get_the_exerpt() and wp_trim_excerpt() functions only work
     * within the post loop, and the $post object's post_excerpt only contains
     * the hand-generate excerpt from the post edit screen. This function
     * generates a dynamic excerpt from the top of the post content, with an
     * optional word length.
     *
     * @param   object          $post           The post object.
     * @param   int             $word_limit     Excerpt length in words.
     * @return  string          $excerpt        Generated post excerpt.
     */

    private function generate_meta_desc($post, $word_limit = 55) {
        $desc = '';

        if ($post && (is_single() || is_page())) {
            $desc = apply_filters('the_excerpt', $post->post_excerpt);

            if (!$desc) {
                $desc = preg_replace('/<\/p>.*$/s', '', apply_filters('the_content', $post->post_content));
                $desc = strip_tags($desc);

                if (str_word_count($desc) >= $word_limit) {
                    // Trim description to set length and add ellipsis.
                    $desc = explode(' ', $desc);
                    $desc = array_slice($desc, 0, $word_limit);
                    $desc[] = '[...]';
                    $desc = implode(' ', $desc);
                }
            }
        }

        if (!$desc) {
            $desc = get_bloginfo('description');
        }

        return $desc;
    }

    /**
     * Generate Meta Info title
     * -------------------------------------------------------------------------
     * @param   object          $post       Post object.
     * @return  string          $title      Meta Title.
     */

    private function generate_meta_title($post) {
        $title = '';

        if ($post && (is_single() || is_page())) {
            $title = apply_filters('the_title', $post->post_title);
        }

        $title = $title ?: wp_title('-', false, 'right');
        $title = $title ?: get_bloginfo('name');

        return $title;
    }

    /**
     * Post Information
     * -------------------------------------------------------------------------
     * @param   int         $post            ID of the post.
     * @param   array       $a_into          Post meta information.
     */

    private function generate_post_meta($post = null) {
        if (!($post = get_post($post))) {
            global $post;
        }

        if (!$post) {
            return;
        }

        $title = $this->generate_meta_title($post);
        $description = $this->generate_meta_desc($post);

        $meta = [
            'ID' => $post,
            'title' => $title,
            'description' => $description,
            'site_name' => get_bloginfo('name'),
            'url' => get_site_url() . $_SERVER['REQUEST_URI'],
            'image' => post_image_url($post),
            'image_size' => get_local_image_dimensions(post_image_path($post)),
            'type' => (is_single() || is_page()) ? 'article' : 'website',
            'locale' => get_locale(),
        ];

        self::$meta = $meta;
    }

    /**
     * Twitter Card Meta Information
     * -------------------------------------------------------------------------
     * This function /should/ present all of the relevant and correct
     * information for Twitter Card.
     */

    private function twitter_card_tags() {
        $meta =& self::$meta;

        $twitter_meta = [
            'twitter:site' => self::$twitter,
            'twitter:card' => 'summary_large_image',
            'twitter:title' => $meta['title'],
            'twitter:description' => $meta['description'],
            'twitter:image' => $meta['image'],
            'twitter:url' => $meta['url']
        ];

        foreach ($twitter_meta as $key => $value) {
            printf('<meta name="%s" content="%s">', $key, $value);
        }
    }

    /**
     * Open Graph Meta Information
     * -------------------------------------------------------------------------
     * This function /should/ present all of the relevant and correct
     * information for Open Graph scrapers.
     */

    private function open_graph_tags() {
        global $post;
        $meta =& self::$meta;

        $facebook_meta = [
            'og:title' => $meta['title'],
            'og:site_name' => $meta['site_name'],
            'og:url' => $meta['url'],
            'og:description' => $meta['description'],
            'og:image' => $meta['image'],
            'og:image:width' => $meta['image_size'][0],
            'og:image:height' => $meta['image_size'][1],
            'og:type' => $meta['type'],
            'og:locale' => $meta['locale'],
        ];

        if (is_single() || is_page()) {
            $single_meta = $this->facebook_single_info($post);
            $facebook_meta = array_merge($facebook_meta, $single_meta);
        }

        foreach ($facebook_meta as $key => $value) {
            printf('<meta property="%s" content="%s">', $key, $value);
        }
    }

    /**
     * Facebook Single Post Information
     * -------------------------------------------------------------------------
     * Facebook requires some extra categorization information for single posts:
     *
     * 1. Category. First post category is ascending numerical order is chosen.
     * 2. Tags. All tags are iteratively added.
     * 3. Publisher URL. Site URL is chosen.
     *
     * @param   int     $post            ID of the post.
     * @return  array   $single_meta        Extra meta infromation for the post.
     */

    private function facebook_single_info($post) {
        $category = 'article';

        if (!is_page()) {
            $category = get_the_category($post->ID)[0]->cat_name;
            $category = $category ?: get_category(get_option('default_category'))->cat_name;
        }

        $taglist = ['single'];

        foreach (wp_get_post_tags($post->ID) as $tag) {
            $taglist[] = $tag->name;
        }

        $single_meta = [
            'article:section' => $category,
            'article:tag' => implode(' ', $taglist),
            'article:publisher' => self::$facebook
        ];

        return $single_meta;
    }
}

?>
