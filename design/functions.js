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
    // Social link height, to keep them perfectly circular.
    var wid = $('#sidebar-social a');
    wid.css('height', wid.width());
}

function clearSearch(obj) {
    // Toggles text in the search side bar. 
    var string = 'Search RMWB';

    if (obj.value == string) {
        obj.value = '';
    }
    else if (obj.value == '') {
        obj.value = string;
    }
}

function clearComName(obj) {
    var string = 'Name*';

    if (obj.value == string) {
        obj.value = '';
    }
    else if (obj.value == '') {
        obj.value = string;
    }
}

function clearComEmail(obj) {
    var string = 'Email*';

    if (obj.value == string) {
        obj.value = '';
    }
    else if (obj.value == '') {
        obj.value = string;
    }
}

function clearComWeb(obj) {
    var string = 'Website';

    if (obj.value == string) {
        obj.value = '';
    }
    else if (obj.value == '') {
        obj.value = string;
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