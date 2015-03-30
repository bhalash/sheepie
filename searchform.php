<form class="search" action="<?php bloginfo('url'); ?>" method="get">
    <p>
        <input type="text" class="search-text" name="s" tabindex="1" placeholder="Search the site" value="<?php echo (is_search()) ? get_search_query() : ''; ?>" />
        <button type="submit"></button>
    </p>
</form>