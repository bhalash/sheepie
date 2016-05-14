/**
 * Sheepie JavaScript Functions
 *
 * @author Mark Grealish <mark@bhalash.com>
 * @copyright 2015 Mark Grealish
 * @license GPL-3.0
 * @version 1.0
 * @link https://github.com/bhalash/sheepie
 */

(function($, document, window) {
    /**
     * DOM Cleanup
     *
     * 1. Add <code> tag necessary for Highlight.js.
     * 2. Remove WordPress-inserted elements which break layout in <figure>.
     */

    $('pre').wrapInner('<code/>');
    $('figure br').add('p:empty').remove();

    /**
     * Event subscribe/unsubscribe.
     *
     * @link https://davidwalsh.name/pubsub-javascript
     * @link https://gist.github.com/cowboy/661855
     */

    $.observer = $({});

    /**
     * Break up arguments object into useful data.
     *
     * For each action fragment (see below), broadcast an action with that
     * fragment's data:
     *
     *  'modal:show:lightbox' =
     *      'modal'
     *      'modal:show'
     *      'modal:show:lightbox'
     *
     * @param {object} args - Arguments object.
     * @returns {array} actions - Mapped actions array.
     *
     */

    $.observer.triggers = function(args) {
        var args = Array.prototype.slice.apply(args),
            actions = args[0].split(':'),
            actionsStr = '';

        return actions.map(function(action, index) {
            if (index) {
                actionsStr = actionsStr.concat(':');
            }

            actionsStr = actionsStr.concat(action);
            return [actionsStr].concat(args.slice(1));
        });
    }

    /**
     * Pub/sub actions.
     *
     * See the link for detailed information.
     *
     * @link https://gist.github.com/cowboy/661855
     */

    $.each({ on: 'subscribe', off: 'unsubscribe' }, function(name, action) {
        $[action] = function() {
            $.observer[name].apply($.observer, arguments);
        }
    });

    $.broadcast = function() {
        $.observer.triggers(arguments).forEach(function(action) {
            $.observer.trigger.apply($.observer, action);
        });
    }

    /**
     * Prevent click action from triggering when data-click elements are, well,
     * clicked.
     *
     * @param {object} event - DOM event.
     * @param {bool} false - Prevent normal click action from occurring.
     */

    $(document).on('click tap', '[data-click]', function(event) {
        var element = event.currentTarget;
        $.broadcast($(element).data('click'), [$(element).data(), element]);
        return false;
    });

    /**
     * Broadcast to hide all modals when <Esc> is depressed.
     *
     * @param {object} event - DOM event.
     */

    $(document).on('keydown', function(event) {
        switch (event.keyCode) {
            case 27: $.broadcast('modal:hide'); break;
        }
    });

    /**
     * Show lightbox when action click detected.
     *
     * @param {object} event - DOM event.
     * @param {object} data - Binding event data.
     * @param {object} element - Event triggering element.
     */

    $.subscribe('modal:show:lightbox', function(event, data, element) {
        data = {
            src: $(element).data('src') || $(element).attr('src'),
            alt: $(element).data('alt') || $(element).attr('alt')
        };

        $('.lightbox__image').attr(data).ready(function() {
            $.broadcast('modal:show', { target: 'lightbox' });
        });
    });

    /**
     * Focus modal search input on click.
     */

    $.subscribe('modal:show:search', function() {
        $('.modal-search__input').focus();
    });

    /**
     * Show specified modal.
     *
     * Show modal if data is set.
     *
     * @param {object} event - DOM event.
     * @param {object} data - Binding event data.
     */

    $.subscribe('modal:show', function(event, data) {
        if (data && data.target) {
            $.broadcast('modal:hide');
            $('[data-modal="' + data.target + '"]').removeClass('hidden').show();
        }
    });

    /**
     * Hide specified/all modals.
     *
     * If there is no data set, hide all modals.
     *
     * @param {object} event - DOM event.
     * @param {object} data - Binding event data.
     */

    $.subscribe('modal:hide', function(event, data) {
        var modal = '[data-modal]';

        if (data && data.target) {
            modal = '[data-modal="' + data.target + '"]';
        }

        $(modal).hide();
    });
})(jQuery, document, window);
