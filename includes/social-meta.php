<?php 

/**
 * Site Header Social Meta
 * -----------------------------------------------------------------------------
 * @category   PHP Script
 * @package    Sheepie
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2015 Mark Grealish
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU General Public License v3.0
 * @version    3.0
 * @link       https://github.com/bhalash/sheepie
 *
 * This file is part of Sheepie.
 * 
 * Sheepie is free software: you can redistribute it and/or modify it under the
 * terms of the GNU General Public License as published by the Free Software 
 * Foundation, either version 3 of the License, or (at your option) any later
 * version.
 * 
 * Sheepie is distributed in the hope that it will be useful, but WITHOUT ANY 
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License along with 
 * Sheepie. If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * Social Meta Fallback
 * -----------------------------------------------------------------------------
 */

if (!isset($social_fallback)) {
    $social_fallback = array(
        // Social fallback is called in cases where the post is missing n info.
        'publisher' => $_SERVER['SERVER_NAME'],
        // TODO
        'image' => THEME_IMAGES . 'fallback.jpg',
        'description' => get_bloginfo('description'),
        'twitter' => '@bhalash'
    );
}

/**
 * Output Open Graph and Twitter Card Tags
 * -----------------------------------------------------------------------------
 * Call the Open Graph and Twitter Card functions.
 */

function social_meta() {
    open_graph_tags();
    twitter_card_tags();
}

/**
 * Twitter Card
 * -----------------------------------------------------------------------------
 * This function /should/ present all of the relevant and correct
 * information for Twitter Card. 
 */

function twitter_card_tags() {
    global $social_fallback, $post;
    $the_post = get_post($post->ID);
    setup_postdata($the_post);

    $site_meta = array(
        'twitter:card' => 'summary',
        'twitter:site' => $social_fallback['twitter'],
        'twitter:title' => get_the_title(),
        'twitter:description' => (is_single()) ? get_the_excerpt() : $social_fallback['description'],
        'twitter:image:src' => content_first_image($post->ID),
        'twitter:url' => get_site_url() . $_SERVER['REQUEST_URI'],
    );

    foreach ($site_meta as $key => $value) {
        printf('<meta name="%s" content="%s">', $key, $value);
    }
}

/**
 * Open Graph
 * -----------------------------------------------------------------------------
 * This function /should/ present all of the relevant and correct
 * information for Open Graph scrapers. 
 */

function open_graph_tags() {
    global $social_fallback, $post;
    $the_post = get_post($post->ID);
    setup_postdata($the_post);

    $site_meta = array(
        'og:title' => get_the_title(),
        'og:site_name' => get_bloginfo('name'),
        'og:url' => get_site_url() . $_SERVER['REQUEST_URI'],
        'og:description' => (is_single()) ? get_the_excerpt() : $social_fallback['description'],
        'og:image' => content_first_image($post->ID),
        'og:type' => (is_single()) ? 'article' : 'website',
        'og:locale' => get_locale(),
    );

    if (is_single()) {
        // If single post, add category and tag information.
        $category = get_the_category($post->ID);

        $tags = get_the_tags();
        $taglist = array();
        $i = 0;

        foreach ($tags as $key => $value) {
            if ($i > 0) {
                $taglist[] = ', ';
            }

            $taglist[] = $value->name;
            $i++;
        }

        $article_meta = array(
            'article:section' => $category[0]->cat_name,
            'article:tag' => implode('', $taglist),
            'article:publisher' => $social_fallback['publisher'],
        );

        $site_meta = array_merge($site_meta, $article_meta);
    }

    foreach ($site_meta as $key => $value) {
        // Iterate all information and output.
        printf('<meta property="%s" content="%s">', $key, $value);
    }
}

/**
 * Filters, Options and Actions
 * -----------------------------------------------------------------------------
 */

add_action('wp_head', 'social_meta');

?>