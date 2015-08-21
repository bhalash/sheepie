<?php 

/**
 * Load Theme Stylesheets
 * -----------------------------------------------------------------------------
 * @category   PHP Script
 * @package    Sheepie
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2015 Mark Grealish
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU GPL v3.0
 * @version    3.0
 * @link       https://github.com/bhalash/sheepie
 */

$google_fonts = array(
    // All Google Fonts to be loaded.
    'Open Sans:300,400,700,800',
    'Source Code Pro:300,400'
);

$theme_styles = array(
    // Compressed, compiled theme CSS.
    'main-style' => THEME_CSS . 'main.css',
);

$conditional_styles = array(
    // Internet Explorer conditiional CSS.
    'ie-fallback' => array(
        THEME_CSS . 'ie.css',
        'lte IE 9'
    )
);

/**
 * Parse Google Fonts from Array
 * -----------------------------------------------------------------------------
 * @param   array   $fonts          Array of fonts to be used.
 * @return  string  $google_url     Parsed URL of fonts to be enqueued.
 */

function google_font_url($fonts) {
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
 * Load Theme Custom Styles
 * -----------------------------------------------------------------------------
 * Load all theme CSS.
 */

function load_theme_styles() {
    global $theme_styles, $google_fonts, $conditional_styles;

    foreach ($theme_styles as $name => $style) {
        wp_enqueue_style($name, $style, array(), THEME_VERSION);
    }

    if (!empty($google_fonts)) {
        wp_register_style('google-fonts', google_font_url($google_fonts));
        wp_enqueue_style('google-fonts');
    }

    foreach ($conditional_styles as $name => $style) {
        $path = $style[0];
        $condition = $style[1];

        wp_enqueue_style($name, $path, array(), THEME_VERSION);
        wp_style_add_data($name, 'conditional', $condition);
    }
}

/**
 * Actions
 * -----------------------------------------------------------------------------
 */

add_action('wp_enqueue_scripts', 'load_theme_styles');

?>
