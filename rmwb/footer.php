</div>
</div>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
<script src="<?php echo get_stylesheet_directory_uri(); ?>/social.js"></script>
<script src="<?php echo get_stylesheet_directory_uri(); ?>/functions.js"></script>
<script>
    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-2156640-5']);
    _gaq.push(['_setDomainName', 'bhalash.com']);
    _gaq.push(['_trackPageview']);

    (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();
</script>
<?php wp_footer(); ?>
</body>
</html>
