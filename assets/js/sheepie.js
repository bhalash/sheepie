/**
 * Miscellaneous JavaScript Functions
 * -----------------------------------------------------------------------------
 * @category   JavaScript File
 * @package    Sheepie
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2015 Mark Grealish
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU GPL v3.0
 * @version    1.0
 * @link       https://github.com/bhalash/sheepie
 */

/*
 * Wrap Pre Elements
 * -------------------------------------------------------------------------
 * highlight.js operates on the <code> child or <pre> elements. This wraps the
 * content of an element with <code> before initializing highlight.js.
 *
 * This does the same thing as jQuery's $(foo).wrapInner(), albeit with less
 * regex selector magic.
 *
 *  if ($('pre').length) {
 *      $('pre:not(:has(> code))').wrapInner('<code></code>');
 *  }
 */

(function() {
    return function() {
        function wrapInsideElement(selector, wrapper) {
            selector = document.querySelectorAll(selector);
            wrapper = wrapper.replace(/(^<.*\/|>$)/g, '');

            [].forEach.call(selector, function(element) {
                if (element.querySelectorAll(wrapper).length === 0) {
                    var newChild = document.createElement(wrapper);

                    while (element.childNodes.length) {
                        newChild.appendChild(element.childNodes[0]);
                    }

                    element.appendChild(newChild);
                }
            });
        }

        wrapInsideElement('pre', '<code></code>');

        /**
         * Remove Photobox Breaks
         * -------------------------------------------------------------------------
         * WordPress can insert <br> tags between elements if it detects either a
         * space or a line break. This can break the formatting. Runs once.
         *
         * Does exactly the same thing as jQuery's $(foo).remove().
         */

        function removeSelector(selector) {
            selector = document.querySelectorAll(selector);

            if (selector.length) {
                [].forEach.call(selector, function(element) {
                    element.parentNode.removeChild(element);
                });
            }
        }

        removeSelector('[class^=article-photobox] br');

        /*
         * Lightbox and Search Controller
         * -----------------------------------------------------------------------------
         *  Built around Knockout.js, this controller manages the search and
         *  lightbox display on the site, in conjunction with a tiny PHP function
         *  to add the click directive to article images.
         */

        var sheepieController = function() {
            return function() {
                var self = this;

                /*
                 * View States
                 * -----------------------------------------------------------------
                 *  Add whatever extra states here.
                 */

                self.display = {
                    search: ko.observable(false),
                    lightbox: ko.observable(false)
                };

                /*
                 * Lightbox Attributes
                 * -----------------------------------------------------------------
                 * Pulled from the bound image. Link isn't used, although it is useful
                 * for future use.
                 */

                self.lightbox = {
                    text: ko.observable(null),
                    image: ko.observable(null),
                    link: ko.observable(null)
                };

                /*
                 * Change State
                 * -----------------------------------------------------------------
                 * The modal (search, lightbox) element on this site have an
                 * exclusive appearance: only one at a time should display.
                 *
                 *  1. Hide all the eiements, except name.
                 *  2. If name exists, invert its state.
                 *
                 * @param   string      name        State to toggle true.
                 */

                self.show = function(name) {
                    for (var i in self.display) {
                        if (name && name in self.display && self.display[i]() === self.display[name]()) {
                            continue;
                        }

                        self.display[i](false);
                    }

                    if (name && name in self.display) {
                        self.display[name](!self.display[name]());
                    }
                };

                /*
                 * Set State to: Whatever
                 * -----------------------------------------------------------------
                 */

                self.toggleLightbox = function() {
                    self.show('lightbox');
                };

                self.toggleSearch = function() {
                    self.show('search');
                };

                /*
                 * Close Lightbox/Search/Whatever on Escape
                 * -----------------------------------------------------------------
                 *  @param  object      data        Data passed.
                 *  @param  object      event       Event and element information.
                 */

                self.closeOnEscape = function(data, event) {
                    if (event.keyCode === 27) {
                        self.show(null);
                    }
                };

                /*
                 * Set Lightbox Data and Open Lightbox
                 * -----------------------------------------------------------------
                 *  @param  object      data        Data passed.
                 *  @param  object      event       Event and element information.
                 */

                self.showLightbox = function(data, event) {
                    self.lightbox.text(event.target.attributes.alt.value);
                    self.lightbox.image(event.target.attributes.src.value);
                    self.lightbox.link(event.target.parentNode.attributes.href.value);

                    self.show('lightbox');
                };
            }
        }

        ko.applyBindings(new sheepieController());
    }
})()();

/**
 * Google Analytics
 * -----------------------------------------------------------------------------
 */

(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

ga('create', 'UA-2156640-5', 'auto');
ga('send', 'pageview');
