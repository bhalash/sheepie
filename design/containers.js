a = '#site-col-0';
b = '#site-col-1';
c = '#content';

function ColZeroSize() {
    // Sets sidebar width @ 250px.
    $(a).css('width', 250);
    $(a).css('height', $(b).height()); 
} 

function ColOneSize() {
    // Right column set to window width - 300px.
    // There's a set min-width of 1000px.
    $(b).css('width', $(window).width() - $(a).width());
} 

function SocialWidgetSizes() {
    // Sets the widths for the sidebar social widgets. 
    var w = '#sidebar-social li';
    $(w).css('width', ($('#sidebar').width() / 4) - 5);
    $(w).css('height', $(w).width());
}

function CommentFormSizes() {
    // Sets the sizes for search form elements.
    $('#comment-entry textarea').css('width', $(c).width() - 8);
    $('#comment-entry textarea').attr('rows', 10);
}

function SidebarSearchWidth() {
    // Sidebar search widget width. 
    // Added extra padding, because Internet Explorer.
	$('form [name=search').css('width', $('#sidebar').width() - 40);
}

$(document).ready(
    function() {
	    ColZeroSize();
        ColOneSize();
        CommentFormSizes();
	    SidebarSearchWidth();
        SocialWidgetSizes();
    }
);

$(window).on('resize',
    function() {
        ColZeroSize();
        ColOneSize();
        CommentFormSizes();
	    SidebarSearchWidth();
        SocialWidgetSizes();
    }
);    