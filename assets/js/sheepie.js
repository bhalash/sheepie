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
     * Event Subscribe/Unsubscribe
     * -------------------------------------------------------------------------
     */

    var observer = $({});

    var actions = {
        trigger: 'publish',
        on: 'subscribe',
        off: 'unsubscribe'
    };

    $.each(actions, function(name, action) {
        $[action] = function() {
            observer[name].apply(observer, arguments);
        }
    });

    /**
     * Keybind Switchboard
     * -------------------------------------------------------------------------
     */

    $(document).on('keydown', function(event) {
        switch (event.keyCode) {
            case 27: $.publish('/modal/hide'); break;
        }
    });

    /**
     * DOM Cleanup
     * -------------------------------------------------------------------------
     */

    $('pre').wrapInner('<code></code>');
    $('figure br, p:empty').remove();

    /**
     * Publishers
     * -------------------------------------------------------------------------
     */

    $(document).on('click tap', 'a img', function(event) {
        var data = {
            src: $(this).attr('src'),
            alt: $(this).attr('alt')
        };

        $.publish('/article/image/click', data);
        return false;
    });

    $('#lightbox').on('click tap', function(event) {
        $.publish('/modal/hide');
        return false;
    });

    /**
     * Subscribers
     * -------------------------------------------------------------------------
     */

    $.subscribe('/article/image/click', function(event, data) {
        $('.lightbox__image').attr(data).ready(function() {
            $('.lightbox').removeClass('hidden').show();
        });
    });

    $.subscribe('/modal/hide', function(event, selector) {
        $(selector || '.modal').hide();
    });
})(jQuery, document, window);
