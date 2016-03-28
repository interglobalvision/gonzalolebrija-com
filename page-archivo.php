<?php
get_header();

$archivo_post_types = array(
  'post',
  'exposiciones',
  'obra',
  'journal',
  'publicaciones',
);

// Get yearl url param
$year = empty($_GET['año']) ? null : $_GET['año'];

$query_params = array(
  'year'  =>  $year,
  'posts_per_page'  =>  -1,
  'post_type'  => $archivo_post_types,
);

$archivo_query = new WP_Query($query_params);

$years = get_all_years($archivo_post_types, 'DESC');

$filter_terms = array_merge( get_exhibition_types($archivo_query), get_posts_taxonomies($archivo_query) );

?>

<!-- main content -->

<main id="main-content" class="container">

  <div class="row">

    <div class="col col-4">
      <ul id="year-filter">
<?php
foreach($years as $year) {
  echo '<li><a href="?año=' . $year . '">' . $year . '</a></li>';
}
?>
      </ul>
    </div>

    <div class="col col-6">
      <ul id="type-filter">
<?php
foreach($filter_terms as $filter_term) {
?>
        <li><a href="#" data-filter="<?php echo $filter_term['slug']; ?>"><?php echo $filter_term['name']; ?></a></li>
<?php
}
?>
      </ul>
    </div>

    <!-- main posts loop -->
    <section id="posts" class="col col-14 u-float">

<?php
if ( $archivo_query->have_posts() ) {
  while( $archivo_query->have_posts() ) {
    $archivo_query->the_post();
    $meta = get_post_meta($post->ID);
    $types = '';

    // Define post type / expo type
    if ( $post->post_type === 'exposiciones' ) {
      $types = wp_get_post_terms($post->ID, 'tipo_de_exposicion', array('fields' => 'slugs'));
      $types = implode(' ', $types);
    } else {
      $types = $post->post_type;
    } 
?>

      <article <?php post_class(); ?> id="post-<?php the_ID(); ?>" data-filter-type="<?php echo $types; ?>">
        <a href="<?php the_permalink() ?>">
          <h3 class="post-title"><?php the_title(); ?><h3>
        </a>
      </article>

<?php
  }
} else {
?>
    <article class="u-alert"><?php _e('Sorry, no posts matched your criteria :{'); ?></article>
<?php
} ?>

    <?php get_template_part('partials/pagination'); ?>

    <!-- end posts -->
    </section>

  </div>

<!-- end main-content -->

</main>

<?php
get_footer();
?>
