<?php

/**
 * Lightbox
 * -----------------------------------------------------------------------------
 * I separated this template because of the 404 switch. It was easier to wrap it
 * all up here.
 *
 * @category   PHP Script
 * @package    Sheepie
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2015 Mark Grealish
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU GPL v3.0
 * @version    1.0
 * @link       https://github.com/bhalash/sheepie
 */

?>

<div class="disp--hidden lightbox noprint" id="lightbox" data-bind="css: { 'disp--hidden': !elements.lightbox() }">
    <a class="lightbox__anchor" href="#!" data-bind="click: show, attr: {title: lightbox.text, href: lightbox.link}">
        <img class="lightbox__image vcenter--double" data-bind="attr: {src: lightbox.image, alt: lightbox.text}" />
        <span class="lightbox__title color--white--text" data-bind="text: lightbox.text"><?php _e('Lightbox Title', 'sheepie'); ?></span>
    </a>
</div>
