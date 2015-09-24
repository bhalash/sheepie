<?php 

/**
 * Sheepie Theme Scripts
 * -----------------------------------------------------------------------------
 * @category   PHP Script
 * @package    Sheepie
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2015 Mark Grealish
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU GPL v3.0
 * @version    1.0
 * @link       https://github.com/bhalash/sheepie
 */


function sheepie_scripts() { 
    $assets = get_template_directory_uri() . '/assets/';
    $js_path = $assets . 'js/';
    $css_path = $assets . 'css/';
    $node_path = get_template_directory_uri() . '/node_modules/';

    $sheepie_js = array(
        'highlight-js' => $js_path . 'highlight.js',
        'lightbox' => $js_path . 'lightbox.js',
        'functions' => $js_path . 'functions.js'
    );

    $sheepie_conditional_js = array(
        // Internet Explorer conditional JS.
        'html5-shiv' => array(
            $node_path . 'html5shiv/dist/html5shiv.min.js',
            'lte IE 9'
        ),
        'jquery-placeholder' => array(
            $node_path . 'jquery-placeholder/jquery.placeholder.min.js',
            'lte IE 9'
        ),
        'ie-functions' => array(
            $js_path . 'ie-functions.js',
            'lte IE 9'
        )
    );

    $sheepie_fonts = array(
        // All Google Fonts to be loaded.
        'Open Sans:1.0,400,700,800',
        'Source Code Pro:1.0,400'
    );

    $sheepie_css = array(
        // Compressed, compiled theme CSS.
        'main-style' => $css_path . 'main.css',
    );

    $sheepie_conditional_css = array(
        // Internet Explorer conditiional CSS.
        'ie-fallback' => array(
            $css_path . 'ie.css',
            'lte IE 9'
        )
    );

    sheepie_js($sheepie_js, $sheepie_conditional_js, $js_path);
    sheepie_css($sheepie_css, $sheepie_conditional_css, $sheepie_fonts);
}

add_action('wp_enqueue_scripts', 'sheepie_scripts');

/*
 * Load Site JS in Footer
 * -----------------------------------------------------------------------------
 * @link http://www.kevinleary.net/move-javascript-bottom-wordpress/#comment-56740
 */

function sheepie_clean_header() {
    remove_action('wp_head', 'wp_print_scripts');
    remove_action('wp_head', 'wp_print_head_scripts', 9);
    remove_action('wp_head', 'wp_enqueue_scripts', 1);
}

add_action('wp_enqueue_scripts', 'sheepie_clean_header');

/** 
 * Sheepie JavaScript Loader
 * -----------------------------------------------------------------------------
 * Load all theme JavaScript.
 * 
 * @param   array       $sheepie_js                Main scripts..
 * @param   array       $sheepie_conditional_js    IE conditional scripts.
 * @param   string      $js_path                   Path to JavaScript assets.
 */

function sheepie_js($sheepie_js, $sheepie_conditional_js, $js_path) {
    if (!is_404()) {
        foreach ($sheepie_js as $name => $script) {
            if (!WP_DEBUG) {
                // Instead load minified version if you aren't debugging.
                $script = str_replace($js_path, $js_path . 'min/', $script);
                $script = str_replace('.js', '.min.js', $script);
            }

            wp_enqueue_script($name, $script, array('jquery'), $GLOBALS['sheepie_version'], true);
        }
    }

    foreach ($sheepie_conditional_js as $name => $script) {
        $path = $script[0];
        $condition = $script[1];

        wp_enqueue_script($name, $path, array(), $GLOBALS['sheepie_version'], false);
        wp_script_add_data($name, 'conditional', $condition);
    }

    if (is_singular()) {
        wp_enqueue_script('comment-reply');
    }
}

/**
 * Sheepie CSS Loader
 * -----------------------------------------------------------------------------
 * Load all theme CSS.
 * 
 * @param   array       $sheepie_css                Ordinary, main stylehseets.
 * @param   array       $sheepie_conditional_css    IE conditional stylesheets.
 * @param   array       $sheepie_fonts              Google fonts to be loaded.
 */

function sheepie_css($sheepie_css, $sheepie_conditional_css, $sheepie_fonts) {
    foreach ($sheepie_css as $name => $style) {
        wp_enqueue_style($name, $style, array(), $GLOBALS['sheepie_version']);
    }

    if (!empty($sheepie_fonts)) {
        wp_register_style('google-fonts', sheepie_google_font_url($sheepie_fonts));
        wp_enqueue_style('google-fonts');
    }

    foreach ($sheepie_conditional_css as $name => $style) {
        $path = $style[0];
        $condition = $style[1];

        wp_enqueue_style($name, $path, array(), $GLOBALS['sheepie_version']);
        wp_style_add_data($name, 'conditional', $condition);
    }
}

/**
 * Parse Google Fonts from Array
 * -----------------------------------------------------------------------------
 * @param   array   $fonts          Array of fonts to be used.
 * @return  string  $google_url     Parsed URL of fonts to be enqueued.
 */

function sheepie_google_font_url($fonts) {
    global $google_fonts;
    $google_url = array('//fonts.googleapis.com/css?family=');

    foreach ($fonts as $key => $value) {
        $google_url[] = str_replace(' ', '+', $value);

        if ($key < sizeof($google_fonts) - 1) {
            $google_url[] = '|';
        }
    }

    return implode('', $google_url);
}

/**
 * Tiny MCE Editor Stylehseet
 * -----------------------------------------------------------------------------
 * Load all theme CSS.
 */

function sheepie_theme_add_editor_styles() {
    add_editor_style(get_template_directory_uri() . '/assets/css/editor.css'); 
}

add_action( 'admin_init', 'sheepie_theme_add_editor_styles' );

?>
