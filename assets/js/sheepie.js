/**
 * Sheepie JavaScript Functions
 * -----------------------------------------------------------------------------
 * @category   JavaScript File
 * @package    Sheepie
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2015 Mark Grealish
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU GPL v3.0
 * @version    1.0
 * @link       https://github.com/bhalash/sheepie
 */

(function() {
    /*
     * Wrap Pre Elements
     * -------------------------------------------------------------------------
     * highlight.js operates on the <code> child or <pre> elements. This wraps
     * the content of an element with <code> before initializing highlight.js.
     *
     * This does the same thing as jQuery's $(foo).wrapInner(), albeit with less
     * regex selector magic.
     *
     *  if ($('pre').length) {
     *      $('pre:not(:has(> code))').wrapInner('<code></code>');
     *  }
     */

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

    // WordPress sometimes inserts <br> between <a> elements inside a <figure>.
    removeSelector('[class^=article-photobox] br');
    // WordPress always inserts an empty <p> element before <figure> elements.
    removeSelector('p:empty');

    /*
     * Sheepie Actions Controller
     * -------------------------------------------------------------------------
     */

    var sheepieController = function() {
        return function() {
            var self = this;

            /*
             * View States
             * -----------------------------------------------------------------
             *  Add whatever extra states here.
             */

            self.elements = {
                search: ko.observable(false),
                lightbox: ko.observable(false)
            };

            // Current state.
            self.shown = null;

            /*
             * Toggle a Given State
             * -----------------------------------------------------------------
             *  TODO: Dymaically generate these.
             */

            self.toggleLightbox = function() {
                self.show('lightbox');
            };

            self.toggleSearch = function() {
                self.show('search');
            };

            /*
             * KnockoutJS Keybind Actions
             * -----------------------------------------------------------------
             *  @param  object      data        Data passed.
             *  @param  object      event       Event and element information.
             */

            self.switchboard = function(data, event) {
                switch(event.keyCode) {
                    case 27:
                        // Close whatever is open on <escape>.
                        self.show(null); break;
                    case 37:
                    case 39:
                        // Log <left> and <right> arrow key presses.
                        self.lightbox.change(event); break;
                }
            };

            /*
             * Change State
             * -----------------------------------------------------------------
             * The modal (search, lightbox) element on this site have an
             * exclusive appearance: only one at a time should.elements.
             *
             *  1. Hide all the eiements, except name.
             *  2. If name exists, invert its state.
             *
             * @param   string      name        State to toggle true.
             */

            self.show = function(name) {
                for (var i in self.elements) {
                    if (self.shown === name) {
                        continue;
                    }

                    self.elements[i](false);
                }

                if (name && name in self.elements) {
                    // Invert state.
                    self.elements[name](!self.elements[name]());
                }

                self.shown = name || null;
            };

            /*
             * Lightbox
             * -----------------------------------------------------------------
             */

            self.lightbox = {
                /*
                 * Lightbox Attributes
                 * -------------------------------------------------------------
                 * Pulled from the bound image. href isn't used, although it may
                 * be useful in future
                 */

                text: ko.observable(null),
                image: ko.observable(null),
                link: ko.observable(null)
            };

            /*
             * Set Lightbox Data and Open Lightbox
             * -----------------------------------------------------------------
             */

            self.lightbox.show = function(data, event) {
                var image = event.target;

                self.lightbox.text(image.attributes.alt.value);
                self.lightbox.image(image.attributes.src.value);
                self.lightbox.link(image.parentNode.attributes.href.value);

                self.show('lightbox');
            };

            /*
             * Set Lightbox Data and Open Lightbox
             * -----------------------------------------------------------------
             */

            self.lightbox.change = function(crap) {
                // TODO: On left-or-right arrow keypress, traverse the DOM
                // for the previous/change image in the same article.
                console.log(crap.keyCode);
            }
        }
    }

    ko.applyBindings(new sheepieController());
})();
