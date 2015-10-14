/**
 * Linked Element State Toggle
 * -----------------------------------------------------------------------------
 * @category   JavaScript File
 * @package    Sheepie
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2015 Mark Grealish
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU GPL v3.0
 * @version    1.0
 * @link       https://github.com/bhalash/sheepie
 */

(function($) { 
    $.fn.link = function(args) {
        var defaults = {
            child: '',
            childClass: '',
            target: '',
            targetClass: '',
            linkedClass: '.linked-class-toggle-0907',
            isTargetInput: false,
            toggled: false
        };

        var opts = {};

        function clickToggle(event, override) {
            if (typeof override !== 'boolean' && !opts.toggled) {
                // Hide all other linked elements.
                $(opts.linkedClass).not(this).trigger('click', false);
            }

            // opts.toggled can be overriden. Otherwise, just invert it.
            opts.toggled = (typeof override === 'boolean') ? override : !opts.toggled;

            $(opts.button).children(opts.child).toggleClass(opts.childClass, opts.toggled);
            $(opts.target).toggleClass(opts.targetClass, opts.toggled);

            if (opts.toggled && opts.isTargetInput) {
                $(opts.target).find('input').focus();
            }
        } 

        function closeOnEscape(event) {
            // Will /probably/ only work if target has tabindex set.
            if (event.keyCode === 27) {
                $(opts.button).trigger('click', false);
            }
        }

        opts = $.extend({}, defaults, args);
        opts.button = this;

        /* There is a class for all linked elements. On button click all are
         * hidden. */

        this.addClass(opts.linkedClass.substring(1))
            .on('click', clickToggle)
            .trigger('click', opts.toggled)

        // Trigger false on escape keyup and window resize.
        $(window).on('keyup', closeOnEscape);

        return this;
    }
})(jQuery);
