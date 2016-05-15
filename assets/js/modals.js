(function($, document, window) {
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
     * Show specified modal.
     *
     * Show modal if data is set.
     *
     * @param {object} event - DOM event.
     * @param {object} data - Binding event data.
     */

    $.subscribe('modal:show', function(event, data) {
        if (data.target) {
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

        if (data.target) {
            modal = '[data-modal="' + data.target + '"]';
        }

        $(modal).hide();
    });
})(jQuery, document, window);
