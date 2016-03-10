<form id="search-form" role="search" method="get" class="search-form" action="<?php echo home_url( '/' ); ?>">
  <?php echo __('[:es]Buscar:[:en]Search:'); ?><input type="search" id="search-field" value="<?php echo get_search_query() ?>" name="s" title="<?php echo esc_attr_x( 'Search for:', 'label' ) ?>" />
  <button type="submit" id="search-submit" class="u-hidden">search</button>
</form>
