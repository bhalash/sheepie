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

(function($, document, window) {
    /**
     * DOM Cleanup
     */

    $('pre').wrapInner('<code></code>');
    $('figure br, p:empty').remove();

    /**
     * Sheepie jQuery object.
     */

    $.sheepie = {};

    $.sheepie.parse = function(selector) {
        return (selector.match(/^[#\.]/)) ? selector : '.' + selector;
    }

    /**
     * Event Subscribe/Unsubscribe
     */

    $.sheepie.observer = $({});

    var actions = {
        trigger: 'broadcast',
        on: 'subscribe',
        off: 'unsubscribe'
    };

    $.each(actions, function(name, action) {
        $[action] = function() {
            $.sheepie.observer[name].apply($.sheepie.observer, arguments);
        }
    });

    /**
     * Set up modal toggles to operate.
     *
     * @param {object} event DOM event.
     */

    $(document).on('keydown', function(event) {
        switch (event.keyCode) {
            case 27: $.broadcast('/modal/hide'); break;
        }
    });

    /**
     * Set up modal toggles to operate.
     *
     * @param {object} event DOM event.
     * @returns {bool} false Prevent DOM event propagation.
     */

    $(document).on('click', '.toggle', function(event) {
        if ($(this).data('toggle')) {
            $.broadcast('/modal/toggle', $(this).data('toggle'));
            return false;
        }
    });

    /**
     * Set lightbox image when article iamge clicked.
     *
     * @param {object} event DOM event.
     * @returns {bool} false Prevent DOM event propagation.
     */

    $('article').on('click tap', 'a img', function(event) {
        var data = {
            src: $(this).data('src') || $(this).attr('src'),
            alt: $(this).data('alt') || $(this).attr('alt')
        };

        $.broadcast('/article/image/click', data);
        return false;
    });

    /**
     * Hide lightbox when clicked.
     *
     * @param {object} event DOM event.
     */

    $('.lightbox').on('click tap', function(event) {
        $.broadcast('/modal/hide', 'lightbox');
        return false;
    });

    /**
     * Show article image in lightbox.
     *
     * @param {object} event DOM event.
     * @param {object} data Image data with which to populate image.
     */

    $.subscribe('/article/image/click', function(event, data) {
        if (data) {
            $('.lightbox__image').attr(data).ready(function() {
                $.broadcast('/modal/show', 'lightbox');
            });
        }
    });

    /**
     * Hide all modals/named modal.
     *
     * @param {object} event DOM event.
     * @param {string} modal Modal to hide.
     */

    $.subscribe('/modal/hide', function(event, modal) {
        if (modal) {
            modal = $.sheepie.parse(modal);
        }

        return $(modal || '.modal').hide();
    });

    /**
     * Display named modal.
     *
     * @param {object} event DOM event.
     * @param {string} modal Modal to show.
     */

    $.subscribe('/modal/show', function(event, modal) {
        if (!modal) {
            return false;
        }

        var type = '';

        type = $.sheepie.parse(modal);
        $('.modal').not(type).hide();
        $(type).removeClass('hidden').show();
        $.broadcast('/modal/shown', modal);
    });

    /**
     * Toggle modal state.
     *
     * @param {object} event DOM event.
     * @param {string} modal Modal to toggle.
     */

    $.subscribe('/modal/toggle', function(event, modal) {
        if (!modal) {
            return false;
        }

        var state = 'hide',
            type = '';

        type = $.sheepie.parse(modal);

        if ($(type).css('display') === 'none') {
            state = 'show';
        }

        $.broadcast('/modal/' + state, modal);
    });

    /**
     * Modal search show callback.
     *
     * @param {object} event DOM event.
     * @param {string} modal Modal to toggle.
     */

    $.subscribe('/modal/shown', function(event, modal) {
        if (modal === 'modal-search') {
            $('.modal-search__input').focus();
        }
    });
})(jQuery, document, window);
