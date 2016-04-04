<?php
get_header();

if (qtranxf_getLanguage() == 'es') {
  $locale = 'es_ES';
} else {
  $locale = 'en_US';
}

\Moment\Moment::setLocale($locale);

$date_format = 'd M., y';

$archivo_post_types = array(
  'post',
  'exposiciones',
  'obra',
  'journal',
  'publicaciones',
);

// Get yearl url param
$year_param = empty($_GET['a']) ? 'all' : $_GET['a'];

$query_params = array(
  'year'  =>  $year_param,
  'posts_per_page'  =>  -1,
  'post_type'  => $archivo_post_types,
);

$archivo_query = new WP_Query($query_params);

$years = get_all_years($archivo_post_types, 'DESC');

$filter_terms = array_merge( get_filter_terms($archivo_query, 'exposiciones'), get_filter_terms($archivo_query) );
?>

<!-- main content -->

<main id="main-content" class="container">

  <div class="row">

    <div class="col col-4">
      <ul id="year-filter">
<?php
foreach($years as $year) {
  $active_class = $year == $year_param ? 'active' : '';
?>
        <li><a href="?a=<?php echo $year; ?>" class="filter-term <?php echo $active_class; ?>"><?php echo $year; ?></a></li>
<?php
}
?>
        <li>&nbsp;</li>
        <li><a href="<?php echo home_url('archivo/'); ?>" class="filter-term filter-term-all <?php echo $year_param === 'all' ? 'active' : ''; ?>"><?php echo __('[:es]Todos[:en]All'); ?></a></li>
      </ul>
    </div>

    <div class="col col-6">
      <ul id="type-filter" class="filters col col-3">
<?php
foreach($filter_terms as $filter_term) {
?>
        <li><a href="#" class="filter-term" data-filter="<?php echo $filter_term['slug']; ?>"><?php echo $filter_term['name']; ?></a></li>
<?php
}
?>
        <li>&nbsp;</li>
        <li><a href="#" data-filter="all" class="filter-term filter-term-all active"><?php echo __('[:es]Todas[:en]All'); ?></a></li>
      </ul>
    </div>

    <!-- main posts loop -->
    <section id="archivo-posts" class="col col-14">

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

      $meta = get_post_meta($post->ID);
      $isExposicion = true;

    } else {
      $types = $post->post_type;

      $isExposicion = false;
    }
?>

      <article <?php post_class('archivo-post filtered-content'); ?> id="post-<?php the_ID(); ?>" data-filter-type="<?php echo $types; ?>">
        <a href="<?php the_permalink() ?>">
          <h2 class="post-title font-italic font-spaced"><?php the_title(); ?><h2>
          <?php
            if ($isExposicion && !empty($meta['_igv_start_date'][0]) && !empty($meta['_igv_end_date'][0])) {
              $start = $m = new \Moment\Moment('@' . $meta['_igv_start_date'][0]);
              $end = $m = new \Moment\Moment('@' . $meta['_igv_end_date'][0]);
          ?>
            <h4><?php echo $start->format($date_format) . ' - ' . $end->format($date_format); ?></h4>
          <?php
            } else {
          ?>
            <h4><?php echo get_the_time($date_format); ?></h4>
          <?php
            }
          ?>
        </a>
      </article>

<?php
  }
} else {
?>
    <article class="u-alert"><?php _e('Sorry, no posts matched your criteria :{'); ?></article>
<?php
} ?>

    <!-- end posts -->
    </section>

  </div>

<!-- end main-content -->

</main>

<?php
get_footer();
?>
