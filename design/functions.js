function leftContainerSize() {
    // Sets sidebar width @ 250px.
    var a = $('#site-col-0');
    var b = $('#site-col-1');
    a.css('width', 250);
    a.css('height', b.height()); 
} 

function rightContainerSize() {
    // Right column set to window width - 300px.
    // There's a set min-width of 1000px.
    var a = $('#site-col-0');
    var b = $('#site-col-1');
    b.css('width', $(window).width() - a.width());
}

function commentTextarea() {
    // Sets the sizes for search form elements.
    var mainCol = $('#content');
    var tx = $('#comment-entry textarea');
    tx.css('width', $(mainCol).width() - 8);
    tx.attr('rows', 10);
}

function socialWidgetHeight() {
    // Social link height, to keep them perfectly circular.
    var wid = $('#sidebar-social a');
    wid.css('height', wid.width());
}

function clearInput(obj) {
    // Clears the default value from inputs.
    var inputStr = [
        'Search RMWB',
        'Name*',
        'Email*',
        'Website'
    ]

    switch (obj.value) {
        case inputStr[0]: 
            clearValue(obj);
            break;
        case inputStr[1]:
            clearValue(obj);
            break;
        case inputStr[2]: 
            clearValue(obj);
            break;
        case inputStr[3]: 
            clearValue(obj);
            break;
        default:
            break;
    }
}

function clearValue(obj) {
    obj.value = '';
}

function restoreInput(obj) {
    // Restore the default value to inputs if they are empty.
    var inputName = [
        'search-input',
        'name-input',
        'email-input',
        'website-input'
    ];

    var inputStr = [
        'Search RMWB',
        'Name*',
        'Email*',
        'Website'
    ]

    if (obj.value == '') {
        switch (obj.name) {
            case inputName[0]: 
                restoreValue(obj,inputStr[0]);
                break;
            case inputName[1]: 
                restoreValue(obj,inputStr[1]);
                break;
            case inputName[2]: 
                restoreValue(obj,inputStr[2]);
                break;
            case inputName[3]: 
                restoreValue(obj,inputStr[3]);
                break;
            default:
                break;
        }
    }
}

function restoreValue(obj, str) {
    obj.value = str;
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