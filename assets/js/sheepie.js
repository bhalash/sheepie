/**
 * Sheepie functions.
 *
 * @author Mark Grealish <mark@bhalash.com>
 * @copyright 2015 Mark Grealish
 * @license GPL-3.0
 * @version 1.0
 * @link https://github.com/bhalash/sheepie
 */

(function(document, window) {
    /**
     * Loop DOM elements.
     *
     * @param {string} selector
     * @param {function} callback
     */

    function loopDom(selector, callback) {
        [].forEach.call(document.querySelectorAll(selector), callback);
    }

    /**
     * Remove a specified selector from the DOM.
     * @example
     *
     *  ['div', 'h3'].forEach(removeSelector);
     *
     * @param {string} selector
     */

    function removeSelector(selector) {
        loopDom(selector, function(element) {
            element.parentNode.removeChild(element);
        });
    }

    /**
     * Add the supplied data-attribute to each instance of a selector.
     *
     * @example
     *
     *  addDataToSelector('div', { ponies: 'Awesome!' }); // data-ponies="Awesome!"
     *
     * @param {string} selector
     */

    function addDataToSelector(selector, data) {
        loopDom(selector, function(element) {
            Object.keys(data).forEach(function(key) {
                element.dataset[key] = data[key];
            });
        });
    }

    ['figure br'].forEach(removeSelector);
    addDataToSelector('main img', { click: 'modal:show:lightbox' });
})(document, window);
