a = '#site-col-0';
b = '#site-col-1';

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

function SidebarSearchWidth() {
    // Sidebar search widget width. 
    // Added extra padding, because Internet Explorer.
	$('form [name=search').css('width', $('#sidebar').width() - 40);
}

$(document).ready(
    function() {
       $('.post-meta').css('margin-top', 41);        

	    ColZeroSize();
        ColOneSize();
	    SidebarSearchWidth();
    }
);

$(window).on('resize',
    function() {
        ColZeroSize();
        ColOneSize();
	    SidebarSearchWidth();
    }
);    