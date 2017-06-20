<?php

// ENQUEUE

function scripts_and_styles_method() {

  $templateuri = get_template_directory_uri() . '/js/';

  // library.js is to bundle plugins. my.js is your scripts. enqueue more files as needed
  $jslib = $templateuri . 'library.js';
  wp_enqueue_script( 'jslib', $jslib,'','',true);

/*   $myscripts = WP_DEBUG ? $templateuri . "main.js" : $templateuri . "main.min.js"; */
  $myscripts = $templateuri . "main.min.js";
  wp_register_script( 'myscripts', $myscripts );

  $is_admin = current_user_can('administrator') ? 1 : 0;
  $jsVars = array(
  	'themeUrl' => get_template_directory_uri(),
  	'isAdmin' => $is_admin,
  );

  wp_localize_script( 'myscripts', 'WP', $jsVars );
  wp_enqueue_script( 'myscripts', $myscripts,'','',true);

  // enqueue stylesheet here. file does not exist until stylus file is processed
  wp_enqueue_style( 'site', get_stylesheet_directory_uri() . '/css/site.min.css' );

  // dashicons for admin
  if (is_admin()){
    wp_enqueue_style( 'dashicons' );
  }

}
add_action('wp_enqueue_scripts', 'scripts_and_styles_method');

// SET IMAGE SIZES

if ( function_exists( 'add_theme_support' ) ) {
  add_theme_support( 'post-thumbnails' );
}

if ( function_exists( 'add_image_size' ) ) {
  add_image_size( 'admin-thumb', 150, 150, false );
  add_image_size( 'opengraph', 1200, 630, true );

  add_image_size( 'gallery', 984, 540, false );

  add_image_size( 'hover-grid-thumb', 9999, 420, false );
  add_image_size( 'hover-grid-thumb-small', 9999, 320, false );

  add_image_size( 'journal-large-single', 9999, 9999, false );

  add_image_size( 'mobile', 580, 9999, false );

  add_image_size( 'col-12', 648, 99999, false );
  add_image_size( 'col-9', 480, 99999, false );
  add_image_size( 'col-6', 312, 99999, false );

}

// INCLUDE MOMENT-PHP

add_action( 'init', 'init_moment_php', 11 );
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

// INCLUDE CMB2

add_action( 'init', 'cmb_initialize_cmb_meta_boxes', 11 );
function cmb_initialize_cmb_meta_boxes() {
  if ( ! class_exists( 'cmb2_bootstrap_202' ) )
    require_once 'lib/CMB2/init.php';
    require_once 'lib/CMB2-Post-Search-field/lib/init.php';
}

// INCLUDE LIB

get_template_part( 'lib/gallery' );
get_template_part( 'lib/post-types' );
get_template_part( 'lib/meta-boxes' );
get_template_part( 'lib/theme-options' );

// INCLUDE FUNCTIONS

get_template_part( 'lib/functions-utility' );
get_template_part( 'lib/functions-custom' );
get_template_part( 'lib/functions-render' );


// GENERIC WORDPRESS CUSTOMIZATION

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

// Remove automatic <a> links from images in blog
function wpb_imagelink_setup() {
	$image_set = get_option( 'image_default_link_type' );
	if ($image_set !== 'none') {
		update_option('image_default_link_type', 'none');
	}
}
add_action('admin_init', 'wpb_imagelink_setup', 10);
?>
