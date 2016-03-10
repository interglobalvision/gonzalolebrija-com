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
    'name'       => __( 'Start date', 'cmb2' ),
    'desc'       => __( 'start of the exhibition', 'cmb2' ),
    'id'         => $prefix . 'start_date',
    'type'       => 'text_date',
  ) );

  $exposiciones_meta->add_field( array(
    'name'       => __( 'End date', 'cmb2' ),
    'desc'       => __( 'end of the exhibition', 'cmb2' ),
    'id'         => $prefix . 'end_date',
    'type'       => 'text_date',
  ) );

  $exposiciones_meta->add_field( array(
    'name'       => __( 'Works gallery', 'cmb2' ),
    'desc'       => __( 'as a wordpress gallery', 'cmb2' ),
    'id'         => $prefix . 'works_gallery',
    'type'       => 'wysiwyg',
  ) );

  $exposiciones_meta->add_field( array(
    'name'       => __( 'Installation gallery', 'cmb2' ),
    'desc'       => __( 'as a wordpress gallery', 'cmb2' ),
    'id'         => $prefix . 'installation_gallery',
    'type'       => 'wysiwyg',
  ) );

  // works

  $obra_meta = new_cmb2_box( array(
    'id'            => $prefix . 'obra_metabox',
    'title'         => __( 'Meta', 'cmb2' ),
    'object_types'  => array( 'obra', ), // Post type
  ) );

  $obra_meta->add_field( array(
    'name'       => __( 'Year', 'cmb2' ),
    'desc'       => __( '', 'cmb2' ),
    'id'         => $prefix . 'year',
    'type'       => 'text',
  ) );

  $obra_meta->add_field( array(
    'name'       => __( 'Medium', 'cmb2' ),
    'desc'       => __( '', 'cmb2' ),
    'id'         => $prefix . 'medium',
    'type'       => 'text',
  ) );

  $obra_meta->add_field( array(
    'name'       => __( 'Size', 'cmb2' ),
    'desc'       => __( '', 'cmb2' ),
    'id'         => $prefix . 'size',
    'type'       => 'text',
  ) );

  $obra_meta->add_field( array(
    'name'       => __( 'Gallery', 'cmb2' ),
    'desc'       => __( 'as a wordpress gallery', 'cmb2' ),
    'id'         => $prefix . 'gallery',
    'type'       => 'wysiwyg',
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
    'name'       => __( 'Year', 'cmb2' ),
    'desc'       => __( '', 'cmb2' ),
    'id'         => $prefix . 'year',
    'type'       => 'text',
  ) );

  $publicaciones_meta->add_field( array(
    'name'       => __( 'Gallery', 'cmb2' ),
    'desc'       => __( 'as a wordpress gallery', 'cmb2' ),
    'id'         => $prefix . 'gallery',
    'type'       => 'wysiwyg',
  ) );


}
?>
