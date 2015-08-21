<?php
/*
 * Template Name: Search Form
 * -----------------------------------------------------------------------------
 * @category   PHP Script
 * @package    Sheepie
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2015 Mark Grealish
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU General Public License v3.0
 * @version    3.0
 * @link       https://github.com/bhalash/sheepie
 */

get_header(); ?>

<div class="page-search">
    <?php get_search_form(); ?>
    <?php get_template_part('search'); ?>
</div>
<?php get_footer(); ?>
