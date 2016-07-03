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
     * Remove a specified selector from the DOM.
     * @param {string} selector
     * @return {array} selector
     */

    var remove = function(selector) {
        selector = document.querySelectorAll(selector);

        [].forEach.call(selector, function(element) {
            element.parentNode.removeChild(element);
        });

        return selector;
    }

    var toRemove = ['figure br'];
    
    toRemove.forEach(remove);
})(document, window);
