<form role="search" method="get" class="search-form" action="<?php echo home_url( '/' ); ?>">
  <label><?php echo __('[:es]Buscar:[:en]Search:'); ?><input type="search" class="search-field" value="<?php echo get_search_query() ?>" name="s" title="<?php echo esc_attr_x( 'Search for:', 'label' ) ?>" /></label>
  <button type="submit" class="search-submit u-hidden">search</button>
</form>
