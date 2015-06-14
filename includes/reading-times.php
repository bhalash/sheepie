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

function article_reading_time($post_id = null, $average_wpm = 300, $return_minutes = false) {
    $reading_time = 0;

    if (is_null($post_id_id)) {
        $post_id = get_the_ID();
    }

    $average_wps = round($average_wpm / 60);
    $time = str_word_count(strip_tags($post_id));
    $reading_tine = round($time / $average_wps);

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
    $time_word = array();

    if ($reading_time <= 0) {
        // <0 - 0
        $time_word[] = $words['singles'][0];
    } elseif ($reading_time < 10) {
        // 1 - 9
        $time_word[] =$words['singles'][$reading_time - 1];
    } elseif ($reading_time > 10 && $reading_time < 20) {
        // 11 - 19
        $time_word[] = $words['teens'][$reading_time - 11];
    } elseif ($reading_time % 10 === 0) {
        // 10, 20, etc.
        $time_word[] = $words['tens'][($reading_time / 10) - 1];
    } elseif ($reading_time > 99) {
         // > 99
        $time_word[] = 'greater than';
        $time_word[] = $words['singles'][8];
        $time_word[] = '-';
        $time_word[] = $words['tens'][8];
    } else {
        // 31, 56, 77, etc.
        $time_word[] = $words['tens'][($reading_time % 100) / 10 - 1];
        $time_word[] = '-';
        $time_word[] = $words['singles'][($reading_time % 10) - 1];
    }

    return implode('', $time_word);
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

function rmwb_reading_time($post_id = null) {
    if (is_null($post_id)) {
        $post_id = get_the_ID();
    }

    $time = article_reading_time($post_id, true);
    $time_phrase = reading_time_in_words($time);
    $minute_word = ($time <= 1) ? ' minute.' : ' minutes.';
    return ucfirst($time_phrase) . $minute_word;
}

?>
