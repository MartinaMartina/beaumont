<div class="searchform">
    <form method="get" action="<?php echo home_url();?>">
        <input type="text" name="s" class="search-field" value="<?php echo get_search_query();?>" placeholder="<?php esc_html_e('Search...','simple-elegant');?>" />
        <button class="submit" title="<?php esc_html_e('Go','simple-elegant');?>"><i class="fa fa-search"></i></button>
    </form>
</div><!-- .searchsearch -->