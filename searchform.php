<form action="<?php echo get_site_url(); ?>" id="search" method="get">
    <p>
        <input name="s" placeholder="Search the site" tabindex="1" type="text" value="<?php echo get_search_query(); ?>" />
        <button type="submit"></button>
    </p>
</form>