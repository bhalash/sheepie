a = $('#site-col-0');
b = $('#site-col-1');
c = $('#content');

function leftContainerSize() {
    // Sets sidebar width @ 250px.
    a.css('width', 250);
    a.css('height', b.height()); 
} 

function rightContainerSize() {
    // Right column set to window width - 300px.
    // There's a set min-width of 1000px.
    b.css('width', $(window).width() - a.width());
}

function commentTextarea() {
    // Sets the sizes for search form elements.
    var tx = $('#comment-entry textarea');
    tx.css('width', $(c).width() - 8);
    tx.attr('rows', 10);
}

function socialWidgetHeight() {
    var wid = $('#sidebar-social a *');
    wid.css('width', wid.height());
}

function clearSearch(obj) {
    var string = 'Search R.M.W.B.';
    var button = $('form [name=search-submit]');

    if (obj.value == string) {
        obj.value = '';
    }
    else if (obj.value == '') {
        obj.value = string;
    }

    if (button.hasClass('hidden')) {
        button.removeClass('hidden');
        button.addClass('shown');
        button.fadeIn(1000);
    }

    else if (button.hasClass('shown')) {
        button.removeClass('shown');
        button.addClass('hidden');
        button.fadeOut(1000);
    }
}

$(document).ready(
    function() {
        commentTextarea();
        leftContainerSize();
        rightContainerSize();
        socialWidgetHeight();
    }
);

$(window).on('resize',
    function() {
        commentTextarea();
        leftContainerSize();
        rightContainerSize();
        socialWidgetHeight();
    }
);    