<?php 

/**
 * Load Theme JavaScript
 * -----------------------------------------------------------------------------
 * @category   PHP Script
 * @package    Sheepie
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2015 Mark Grealish
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU GPL v3.0
 * @version    3.0
 * @link       https://github.com/bhalash/sheepie
 */

$theme_javascript = array(
    'highlight-js' => THEME_JS . 'highlight.js',
    'google-analytics' => THEME_JS . 'analytics.js',
    'lightbox' => THEME_JS . 'lightbox.js',
    'functions' => THEME_JS . 'functions.js'
);

$conditional_scripts = array(
    // Internet Explorer conditional JS.
    'html5-shiv' => array(
        THEME_URL . '/node_modules/html5shiv/dist/html5shiv.min.js',
        'lte IE 9'
    )
);

/** 
 * Load Theme JavaScript
 * -----------------------------------------------------------------------------
 */

function load_theme_scripts() {
    global $theme_javascript, $conditional_scripts, $wp_scripts;

    foreach ($theme_javascript as $name => $script) {
        if (!WP_DEBUG) {
            // Instead load minified version if you aren't debugging.
            $script = str_replace(THEME_JS, THEME_JS . 'min/', $script);
            $script = str_replace('.js', '.min.js', $script);
        }

        wp_enqueue_script($name, $script, array('jquery'), THEME_VERSION, true);
    }

    foreach ($conditional_scripts as $name => $script) {
        $path = $script[0];
        $condition = $script[1];

        wp_enqueue_script($name, $path, array(), THEME_VERSION, false);
        wp_script_add_data($name, 'conditional', $condition);
    }
}

/*
 * Load Site JS in Footer
 * -----------------------------------------------------------------------------
 * @link http://www.kevinleary.net/move-javascript-bottom-wordpress/#comment-56740
 */

function clean_header() {
    remove_action('wp_head', 'wp_print_scripts');
    remove_action('wp_head', 'wp_print_head_scripts', 9);
    remove_action('wp_head', 'wp_enqueue_scripts', 1);
}

/**
 * Actions
 * -----------------------------------------------------------------------------
 */

add_action('wp_enqueue_scripts', 'clean_header');
add_action('wp_enqueue_scripts', 'load_theme_scripts');
?>
