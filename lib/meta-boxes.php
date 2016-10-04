<?php

/* Get post objects for select field options */
function get_post_objects( $query_args ) {
$args = wp_parse_args( $query_args, array(
    'post_type' => 'post',
) );
$posts = get_posts( $args );
$post_options = array();
if ( $posts ) {
    foreach ( $posts as $post ) {
        $post_options [ $post->ID ] = $post->post_title;
    }
}
return $post_options;
}


/**
 * Include and setup custom metaboxes and fields.
 *
 * @category YourThemeOrPlugin
 * @package  Metaboxes
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/WebDevStudios/CMB2
 */

/**
 * Hook in and add metaboxes. Can only happen on the 'cmb2_init' hook.
 */
add_action( 'cmb2_init', 'igv_cmb_metaboxes' );
function igv_cmb_metaboxes() {

  // Start with an underscore to hide fields from custom fields list
  $prefix = '_igv_';

  /**
   * Metaboxes declarations here
   * Reference: https://github.com/WebDevStudios/CMB2/blob/master/example-functions.php
   */

   // exhibitions

  $exposiciones_meta = new_cmb2_box( array(
    'id'            => $prefix . 'exposiciones_metabox',
    'title'         => __( 'Meta', 'cmb2' ),
    'object_types'  => array( 'exposiciones', ), // Post type
  ) );

  $exposiciones_meta->add_field( array(
    'name'       => __( 'Location', 'cmb2' ),
/*     'desc'       => __( '...', 'cmb2' ), */
    'id'         => $prefix . 'location',
    'type'       => 'text',
  ) );

  $exposiciones_meta->add_field( array(
    'name'       => __( 'Start date', 'cmb2' ),
    'desc'       => __( 'start of the exhibition', 'cmb2' ),
    'id'         => $prefix . 'start_date',
    'type'       => 'text_date_timestamp',
    'date_format' => 'd/m/Y'
  ) );

  $exposiciones_meta->add_field( array(
    'name'       => __( 'End date', 'cmb2' ),
    'desc'       => __( 'end of the exhibition', 'cmb2' ),
    'id'         => $prefix . 'end_date',
    'type'       => 'text_date_timestamp',
    'date_format' => 'd/m/Y'
  ) );

  $exposiciones_images = $exposiciones_meta->add_field( array(
      'id'          => $prefix . 'exposicion_images',
      'type'        => 'group',
      'description' => __( 'Add images to the exhibition', 'cmb2' ),
      'options'     => array(
          'group_title'   => __( 'Image {#}', 'cmb2' ), // since version 1.1.4, {#} gets replaced by row number
          'add_button'    => __( 'Add Another Image', 'cmb2' ),
          'remove_button' => __( 'Remove Image', 'cmb2' ),
          'sortable'      => false, // beta
          // 'closed'     => true, // true to have the groups closed by default
      ),
  ) );

  $exposiciones_meta->add_group_field( $exposiciones_images, array(
      'name' => 'Image',
      'id'   => 'image',
      'type' => 'file',
      'attributes'  => array(
        'required'    => 'required',
      ),
  ) );

  $exposiciones_meta->add_group_field( $exposiciones_images, array(
      'name' => 'Related work (optional)',
      'description' => __( 'Relate a work to this image. (Clicking the image will go to the work single page). To do this open a search and find the work. The data in this field should be a number. e.g. 43 or 6', 'cmb2' ),
      'id'   => 'work',
      'type' => 'post_search_text',
      'post_type' => 'obra',
  ) );

  // works

  $obra_meta = new_cmb2_box( array(
    'id'            => $prefix . 'obra_metabox',
    'title'         => __( 'Meta', 'cmb2' ),
    'object_types'  => array( 'obra', ), // Post type
  ) );

  $obra_meta->add_field( array(
    'name'       => __( 'Work in progress?', 'cmb2' ),
    'desc'       => __( '', 'cmb2' ),
    'id'         => $prefix . 'in_progress',
    'type'       => 'checkbox',
  ) );

  $obra_meta->add_field( array(
    'name'       => __( 'Medium ES', 'cmb2' ),
    'desc'       => __( 'en español', 'cmb2' ),
    'id'         => $prefix . 'medium_es',
    'type'       => 'text',
  ) );

  $obra_meta->add_field( array(
    'name'       => __( 'Medium EN', 'cmb2' ),
    'desc'       => __( 'in english', 'cmb2' ),
    'id'         => $prefix . 'medium_en',
    'type'       => 'text',
  ) );

  $obra_meta->add_field( array(
    'name'       => __( 'Size', 'cmb2' ),
    'desc'       => __( '', 'cmb2' ),
    'id'         => $prefix . 'size',
    'type'       => 'text',
  ) );

  $obra_meta->add_field( array(
    'name'       => __( 'Video', 'cmb2' ),
    'desc'       => __( 'if video not slideshow. [vimeo embed id or ???]', 'cmb2' ),
    'id'         => $prefix . 'video_id',
    'type'       => 'text',
  ) );

  $obra_meta->add_field( array(
    'name'       => __( 'Gallery', 'cmb2' ),
    'desc'       => __( 'as a wordpress gallery', 'cmb2' ),
    'id'         => $prefix . 'gallery',
    'type'       => 'wysiwyg',
  ) );

  $obra_meta->add_field( array(
    'name'       => __( 'Download', 'cmb2' ),
    'desc'       => __( 'as a file. PDF or similar', 'cmb2' ),
    'id'         => $prefix . 'download',
    'type'       => 'file',
  ) );

  // journal

  $journal_meta = new_cmb2_box( array(
    'id'            => $prefix . 'journal_metabox',
    'title'         => __( 'Meta', 'cmb2' ),
    'object_types'  => array( 'journal', ), // Post type
  ) );

  $journal_meta->add_field( array(
    'name'       => __( 'Large image', 'cmb2' ),
    'desc'       => __( 'scan of feature or similar', 'cmb2' ),
    'id'         => $prefix . 'image',
    'type'       => 'file',
  ) );

  // publications

  $publicaciones_meta = new_cmb2_box( array(
    'id'            => $prefix . 'publicaciones_metabox',
    'title'         => __( 'Meta', 'cmb2' ),
    'object_types'  => array( 'publicaciones', ), // Post type
  ) );

  $publicaciones_meta->add_field( array(
    'name'       => __( 'Gallery', 'cmb2' ),
    'desc'       => __( 'as a wordpress gallery', 'cmb2' ),
    'id'         => $prefix . 'gallery',
    'type'       => 'wysiwyg',
  ) );

  // contact page

  $contact_id = get_id_by_slug('info/contacto');

  $contact_meta = new_cmb2_box( array(
    'id'            => $prefix . '$contact_metabox',
    'title'         => __( 'Contact', 'cmb2' ),
    'object_types'  => array( 'page', ), // Post type
    'show_on'      => array( 'key' => 'id', 'value' => $contact_id ),
  ) );

  $contact_meta->add_field( array(
    'name'       => __( '2da', 'cmb2' ),
    'desc'       => __( '...', 'cmb2' ),
    'id'         => $prefix . 'second_column',
    'type'       => 'wysiwyg',
  ) );

  $contact_meta->add_field( array(
    'name'       => __( '3da', 'cmb2' ),
    'desc'       => __( '...', 'cmb2' ),
    'id'         => $prefix . 'third_column',
    'type'       => 'wysiwyg',
  ) );

}
?>
