<?php

/**
 * Article Reading Time Functions
 * -----------------------------------------------------------------------------
 * @category   PHP Script
 * @package    Sheepie
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2015 Mark Grealish
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU General Public License v3.0
 * @version    3.0
 * @link       https://github.com/bhalash/sheepie
 */

/**
 * Article Reading Time in Seconds
 * -----------------------------------------------------------------------------
 * Inpsired by Medium; see: http://www.bhalash.com/archives/13544802870
 *
 * Return the reading time of the article in seconds, based on an average 
 * WPM of 300. You are free to override this.
 * 
 * @param   int     $post_id 
 * @param   int     $average_wpm    Average reading speed.
 * @return  int     $reading_time   Reading time in seconds.
 */

function article_reading_time($post = null, $wpm = 300, $return_minutes = false) {
    if (!($post = get_post($post))) {
        global $post;
    }

    $reading_time = 0;

    $wps = round($wpm / 60);
    $time = str_word_count(strip_tags($post));
    $reading_tine = round($time / $wps);

    if ($return_minutes) {
        $reading_time = article_reading_time_minutes($reading_time);
    }

    return $reading_time;
}

/**
 * Article Reading Time in Seconds
 * -----------------------------------------------------------------------------
 * Convert the reading time in seconds, to the reding time in minutes.
 * 
 * @param   int     $seconds        Reading time in seconds.
 * @return  int     $minutes        Reading time in minutes.
 */

function article_reading_time_minutes($seconds) {
    $minutes = 0;

    if ($seconds % 60 <= 30) {
        $minutes = floor($seconds / 60);
    } else {
        $minutes = ceil($seconds / 60);
    }

    return $minutes;
}

/**
 * Article Reading Time in Seconds
 * -----------------------------------------------------------------------------
 * Converts a given minutes time to words. Only does up to 99 minutes,
 * because, honestly, if your article's reading time is above that then
 * you went horribly wrong somewhere.
 * 
 * @param   int     $seconds        Reading time in minutes.
 * @return  string  $time_words     Reading time of article expressed as a phrase.
 * 
 */

function reading_time_in_words($reading_time) {
    if (!$reading_time) {
        return false;
    }

    $words = array(
        'singles' => array(
            'one','two','three','four','five','six','seven','eight','nine'
        ),
        'teens' => array(
            'eleven','twelve','thirteen','fourteen','fifteen','sixteen',
            'seventeen','eighteen','nineteen'
        ),
        'tens' => array(
            'ten','twenty','thirty','forty','fifty','sixty','seventy','eighty',
            'ninety'
        )
    );

    // Reading time in words.
    $sentence = array();

    if ($reading_time <= 0) {
        // <0 - 0
        $sentence[] = $words['singles'][0];
    } elseif ($reading_time < 10) {
        // 1 - 9
        $sentence[] = $words['singles'][$reading_time - 1];
    } elseif ($reading_time > 10 && $reading_time < 20) {
        // 11 - 19
        $sentence[] = $words['teens'][$reading_time - 11];
    } elseif ($reading_time % 10 === 0) {
        // 10, 20, etc.
        $sentence[] = $words['tens'][($reading_time / 10) - 1];
    } elseif ($reading_time > 99) {
         // > 99
        $sentence[] = 'greater than';
        $sentence[] = $words['singles'][8];
        $sentence[] = '-';
        $sentence[] = $words['tens'][8];
    } else {
        // 31, 56, 77, etc.
        $sentence[] = $words['tens'][($reading_time % 100) / 10 - 1];
        $sentence[] = '-';
        $sentence[] = $words['singles'][($reading_time % 10) - 1];
    }

    return implode('', $sentence);
}

/**
 * Reading Time Wrapper
 * -----------------------------------------------------------------------------
 * Take in post and return its reading time in minutes as a phrase.
 *
 * @param   int     $post_id 
 * @return  string  $time_phrase    Reading time as a phrase/words.
 * @link    http://www.bhalash.com/archives/13544802870
 */

function rmwb_reading_time($post = null) {
    if (!($post = get_post($post))) {
        global $post;
    }

    $time = article_reading_time($post, true);
    $time_phrase = reading_time_in_words($time);
    $minute_word = ($time <= 1) ? ' minute.' : ' minutes.';
    return ucfirst($time_phrase) . $minute_word;
}

?>
