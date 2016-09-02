<?php

  // CUSTOM FUNCTIONS

// Custom img attributes to be compatible with lazysize
function add_lazysize_on_srcset($attr) {

  if (!is_admin()) {

    // Add lazysize class
    $attr['class'] .= ' lazyload';

    if (isset($attr['srcset'])) {
      // Add lazysize data-srcset
      $attr['data-srcset'] = $attr['srcset'];
      // Remove default srcset
      unset($attr['srcset']);
    } else {
      // Add lazysize data-src
      $attr['data-src'] = $attr['src'];
    }

    // Set default to white blank
    $attr['src'] = 'data:image/gif;iVBORw0KGgoAAAANSUhEUgAAAAQAAAABCAQAAABTNcdGAAAAC0lEQVR42mNkgAIAABIAAmXG3J8AAAAASUVORK5CYII=';

  }

  return $attr;

}
add_filter('wp_get_attachment_image_attributes', 'add_lazysize_on_srcset');

// Obra archive query

add_action('pre_get_posts', 'alter_query');
function alter_query($query) {
  if ($query->is_main_query() && $query->is_post_type_archive('obra')) {
    $query->set('orderby', 'rand');
    $query->set('posts_per_page', -1);
  }
}

// custom read more text
function custom_excerpt_more( $more ) {
	return ' <span class="font-small-caps">' . __('[:es]Leer más[:en]Read more') . '</span>';
}
add_filter( 'excerpt_more', 'custom_excerpt_more' );

// Return an array of exhibition terms from these $posts.
function get_filter_terms($posts, $type = false) {
  if ( empty( $posts ) ) {
    return '';
  }

  $terms = array();

  foreach($posts->posts as $post) {

    $post_type = get_post_type_object( $post->post_type );
    if ($post->post_type === 'exposiciones' && $type === 'exposiciones') {
      $post_terms = wp_get_post_terms( $post->ID, 'tipo-de-exposicion' );
      foreach($post_terms as $post_term) {
        if ( in_array($post_term->slug, array_column($terms, 'slug')) == false ) {
          $terms[] = array(
            'slug'  =>  $post_term->slug,
            'name'  =>  $post_term->name,
          );
        }
      }
    } else if( $post->post_type !== 'exposiciones' && !$type ) {
      $post_type = get_post_type_object( $post->post_type );
      if ( in_array($post_type->name, array_column($terms, 'slug')) == false ) {
        $terms[] = array(
          'slug'  =>  $post_type->name,
          'name'  =>  $post_type->label,
        );
      }
    }
  }
  // pr( $terms );
  return $terms;
}

// Return a list of years
function get_all_years($post_types, $order) {
  global $wpdb;

  $where = '';

  // Construct WHERE clausule for the query
  // For all $post_types and with status 'publish'
  // Ex. WHERE ( post_type = "post" OR post_type = "exposiciones" OR post_type = "obra" ) AND post_status = "publish "
  for ($i = 0; $i < count($post_types); ++$i) {
    if ( $i == 0 ) {
      $where .= 'WHERE ( ';
    } else {
      $where .= ' OR ';
    }
    $where .= 'post_type = "' . $post_types[$i] . '"';
  }
  $where .= ' ) AND post_status = "publish " ';

  $order = strtoupper( $order );
  if ( $order !== 'ASC' ) {
    $order = 'DESC';
  }

  $years = array();

  // The 'last_changed' incrementor is used to invalidate the $key cache.
  // This way we invalidate the cache on add, delete, and update.
  $last_changed = wp_cache_get( 'last_changed', 'posts' );
  if ( ! $last_changed ) {
    $last_changed = microtime();
    wp_cache_set( 'last_changed', $last_changed, 'posts' );
  }

  // Final query
  $query = "SELECT YEAR(post_date) AS `year` FROM $wpdb->posts $where GROUP BY YEAR(post_date) ORDER BY post_date $order";

  // By creating a cache key that's a hash of igv + last_changed + md5 (from query)
  // we have a simple method for cache invalidation: whenever new activity
  // (or whatever) is created, bump last_changed. Now all cache using a key
  // generated from last_changed is invalidated.
  $key = md5( $query );
  $key = "igv_get_all_years:$key:$last_changed";
  if ( ! $results = wp_cache_get( $key, 'posts' ) ) {
    $results = $wpdb->get_results( $query );
    wp_cache_set( $key, $results, 'posts' );
  }

  if ( $results ) {
    foreach ( (array) $results as $result) {
      $years[] = $result->year;
    }
  }

  return $years;
}

// Return a list of months which have posts for the specified post type
function get_all_months($post_types, $order) {
  global $wpdb;

  $where = '';

  // Construct WHERE clausule for the query
  // For all $post_types and with status 'publish'
  // Ex. WHERE ( post_type = "post" OR post_type = "exposiciones" OR post_type = "obra" ) AND post_status = "publish "
  for ($i = 0; $i < count($post_types); ++$i) {
    if ( $i == 0 ) {
      $where .= 'WHERE ( ';
    } else {
      $where .= ' OR ';
    }
    $where .= 'post_type = "' . $post_types[$i] . '"';
  }
  $where .= ' ) AND post_status = "publish " ';

  $order = strtoupper( $order );
  if ( $order !== 'ASC' ) {
    $order = 'DESC';
  }

  $months = array();

  // The 'last_changed' incrementor is used to invalidate the $key cache.
  // This way we invalidate the cache on add, delete, and update.
  $last_changed = wp_cache_get( 'last_changed', 'posts' );
  if ( ! $last_changed ) {
    $last_changed = microtime();
    wp_cache_set( 'last_changed', $last_changed, 'posts' );
  }

  // Final query
  $query = "SELECT YEAR(post_date) AS `year`, MONTH(post_date) AS `month` FROM $wpdb->posts $where GROUP BY MONTH(post_date) ORDER BY post_date $order";

  // By creating a cache key that's a hash of igv + last_changed + md5 (from query)
  // we have a simple method for cache invalidation: whenever new activity
  // (or whatever) is created, bump last_changed. Now all cache using a key
  // generated from last_changed is invalidated.
  $key = md5( $query );
  $key = "igv_get_all_years:$key:$last_changed";
  if ( ! $results = wp_cache_get( $key, 'posts' ) ) {
    $results = $wpdb->get_results( $query );
    wp_cache_set( $key, $results, 'posts' );
  }

  if ( $results ) {
    foreach ( (array) $results as $result) {
      $months[] = $result;
    }
  }

  return $months;
}
