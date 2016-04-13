<?php
function scripts_and_styles_method() {

  $templateuri = get_template_directory_uri() . '/js/';

  // library.js is to bundle plugins. my.js is your scripts. enqueue more files as needed
  $jslib = $templateuri . 'library.js';
  wp_enqueue_script( 'jslib', $jslib,'','',true);

/*   $myscripts = WP_DEBUG ? $templateuri . "main.js" : $templateuri . "main.min.js"; */
  $myscripts = $templateuri . "main.js";
  wp_register_script( 'myscripts', $myscripts );

  $is_admin = current_user_can('administrator') ? 1 : 0;
  $jsVars = array(
  	'themeUrl' => get_template_directory_uri(),
  	'isAdmin' => $is_admin,
  );

  wp_localize_script( 'myscripts', 'WP', $jsVars );
  wp_enqueue_script( 'myscripts', $myscripts,'','',true);

  // enqueue stylesheet here. file does not exist until stylus file is processed
  wp_enqueue_style( 'site', get_stylesheet_directory_uri() . '/css/site.css' );

  // dashicons for admin
  if (is_admin()){
    wp_enqueue_style( 'dashicons' );
  }

}
add_action('wp_enqueue_scripts', 'scripts_and_styles_method');

if ( function_exists( 'add_theme_support' ) ) {
  add_theme_support( 'post-thumbnails' );
}

if ( function_exists( 'add_image_size' ) ) {
  add_image_size( 'admin-thumb', 150, 150, false );
  add_image_size( 'opengraph', 1200, 630, true );

  add_image_size( 'gallery', 984, 560, false );

  add_image_size( 'hover-grid-thumb', 9999, 420, false );
  add_image_size( 'hover-grid-thumb-small', 9999, 320, false );

  add_image_size( 'journal-large-single', 9999, 9999, false );

  add_image_size( 'col-9', 480, 99999, false );
}

// Register Nav Menus
/*
register_nav_menus( array(
	'menu_location' => 'Location Name',
) );
*/

add_action( 'init', 'init_moment_php', 9999 );
function init_moment_php() {
  if ( ! class_exists( 'Moment' ) )
    require_once 'lib/moment-php/src/Moment.php';
    require_once 'lib/moment-php/src/MomentException.php';
    require_once 'lib/moment-php/src/MomentFromVo.php';
    require_once 'lib/moment-php/src/MomentHelper.php';
    require_once 'lib/moment-php/src/MomentLocale.php';
    require_once 'lib/moment-php/src/MomentPeriodVo.php';
    require_once 'lib/moment-php/src/FormatsInterface.php';
}

get_template_part( 'lib/gallery' );
get_template_part( 'lib/post-types' );
get_template_part( 'lib/meta-boxes' );
get_template_part( 'lib/theme-options' );

add_action( 'init', 'cmb_initialize_cmb_meta_boxes', 9999 );
function cmb_initialize_cmb_meta_boxes() {
  // Add CMB2 plugin
  if ( ! class_exists( 'cmb2_bootstrap_202' ) )
    require_once 'lib/CMB2/init.php';
    require_once 'lib/CMB2-Post-Search-field/lib/init.php';
}

// Remove WP Emoji
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

// Disable that freaking admin bar
add_filter('show_admin_bar', '__return_false');

// Turn off version in meta
function no_generator() { return ''; }
add_filter( 'the_generator', 'no_generator' );

// Show thumbnails in admin lists
add_filter('manage_posts_columns', 'new_add_post_thumbnail_column');
function new_add_post_thumbnail_column($cols){
  $cols['new_post_thumb'] = __('Thumbnail');
  return $cols;
}
add_action('manage_posts_custom_column', 'new_display_post_thumbnail_column', 5, 2);
function new_display_post_thumbnail_column($col, $id){
  switch($col){
    case 'new_post_thumb':
    if ( function_exists('the_post_thumbnail') ) {
      echo the_post_thumbnail( 'admin-thumb' );
      }
    else
    echo 'Not supported in theme';
    break;
  }
}

// remove automatic <a> links from images in blog
function wpb_imagelink_setup() {
	$image_set = get_option( 'image_default_link_type' );
	if ($image_set !== 'none') {
		update_option('image_default_link_type', 'none');
	}
}
add_action('admin_init', 'wpb_imagelink_setup', 10);

// custom login logo
/*
function custom_login_logo() {
  echo '<style type="text/css">h1 a { background-image:url(' . get_bloginfo( 'template_directory' ) . '/images/login-logo.png) !important; background-size:300px auto !important; width:300px !important; }</style>';
}
add_action( 'login_head', 'custom_login_logo' );
*/

// CUSTOM EXCERPT MORE TEXT
function custom_excerpt_more( $more ) {
	return ' <span class="font-small-caps">' . __('[:es]Leer más[:en]Read more') . '</span>';
}
add_filter( 'excerpt_more', 'custom_excerpt_more' );

// UTILITY FUNCTIONS

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

// to replace file_get_contents
function url_get_contents($Url) {
  if (!function_exists('curl_init')){
      die('CURL is not installed!');
  }
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $Url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $output = curl_exec($ch);
  curl_close($ch);
  return $output;
}

// get ID of page by slug
function get_id_by_slug($page_slug) {
	$page = get_page_by_path($page_slug);
	if ($page) {
		return $page->ID;
	} else {
		return null;
	}
}
// is_single for custom post type
function is_single_type($type, $post) {
  if (get_post_type($post->ID) === $type) {
    return true;
  } else {
    return false;
  }
}

// echo submenu of page children
function echo_page_children_submenu($children) {
  if ($children) {
    echo '<ul class="submenu">';
    foreach($children as $child) {
      echo '<li><a href="' . get_the_permalink($child->ID) . '">' . $child->post_title . '</a></li>';
    }
    echo '</ul>';
  }
}

// print var in <pre> tags
function pr($var) {
  echo '<pre>';
  print_r($var);
  echo '</pre>';
}

// Debug page and template request
function debug_page_request() {
  global $wp, $template;
  define("D4P_EOL", "\r\n");
  echo '<!-- Request: ';
  echo empty($wp->request) ? "None" : esc_html($wp->request);
  echo ' -->'.D4P_EOL;
  echo '<!-- Matched Rewrite Rule: ';
  echo empty($wp->matched_rule) ? None : esc_html($wp->matched_rule);
  echo ' -->'.D4P_EOL;
  echo '<!-- Matched Rewrite Query: ';
  echo empty($wp->matched_query) ? "None" : esc_html($wp->matched_query);
  echo ' -->'.D4P_EOL;
  echo '<!-- Loaded Template: ';
  echo basename($template);
  echo ' -->'.D4P_EOL;
}
?>
