function socialWidgetHeight() {
    // Widget width is dynamic and proportional to the div container size. 
    // Height = width.
    var soc = $('.social a');
    soc.css('height', soc.width() + 'px'); 
}

$('.social-widget').hover(
    // Sets the on-and-off hover times and colours for the social widgets. 
    function() {
        var wCol = '#fff';

        switch ($(this).attr('id')) {
            case 'email':       wCol = '#ec4724'; break;
            case 'facebook':    wCol = '#3B5998'; break;
            case 'github':      wCol = '#171516'; break;
            case 'google':      wCol = '#db5442'; break;
            case 'instagram':   wCol = '#3f729b'; break;
            case 'linkedin':    wCol = '#0274b3'; break;
            case 'pinterest':   wCol = '#cb2027'; break;
            case 'rss':         wCol = '#FF6600'; break;
            case 'twitter':     wCol = '#00aced'; break;
            default: break;
        }

        $(this).stop().animate({backgroundColor: wCol}, 300); 
    }, function() {
        $(this).stop().animate({backgroundColor: '#343537'}, 500);
    }
);

$(document).ready(
    function() {
        socialWidgetHeight();
    }
);

$(window).on('resize',
    function() {
        socialWidgetHeight();
    }
);