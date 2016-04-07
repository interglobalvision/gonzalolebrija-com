<?php
get_header();


if (qtranxf_getLanguage() == 'es') {
  $locale = 'es_ES';
} else {
  $locale = 'en_US';
}

\Moment\Moment::setLocale($locale);

$date_format = 'd M., y';

?>

<!-- main content -->

<main id="main-content" class="container">

  <div class="row">

<?php
if( have_posts() ) {
  while( have_posts() ) {
    the_post();
    $meta = get_post_meta($post->ID);
    $images = get_post_meta($post->ID, '_igv_exposicion_images', true);

    $post_terms = get_the_terms($post->ID, 'tipo_de_exposicion');

    if (!empty($post_terms)) {
      $post_term_id = $post_terms[0]->term_id;
    } else {
      $post_term_id = 0;
    }
?>

    <div class="col col-8">

      <ul class="filter-menu">
      <?php
        $exhibition_types = get_terms('tipo_de_exposicion');

        if ($exhibition_types) {
          foreach ($exhibition_types as $type) {
            if ($post_term_id === $type->term_id) {
      ?>
        <li><a class="filter-term active" href="<?php echo get_term_link($type->term_id); ?>"><?php echo $type->name; ?></a></li>
      <?php
            } else {
      ?>
        <li><a href="<?php echo get_term_link($type->term_id); ?>"><?php echo $type->name; ?></a></li>
      <?php
            }
          }
        }
      ?>
        <li>&nbsp;</li>
        <li><a href="<?php echo home_url('exposiciones/'); ?>"><?php echo __('[:es]Todas[:en]All'); ?></a></li>
      </ul>

    </div>

    <!-- main posts loop -->
    <section id="exposicion" class="col col-14">

      <article <?php post_class(); ?> id="single-post-<?php the_ID(); ?>">

        <header id="single-exposicion-header" class="u-align-center">

          <a href="<?php the_permalink() ?>"><h3 id="single-exposicion-title" class="font-italic"><?php the_title(); ?></h3></a>

          <?php
            if (!empty($meta['_igv_start_date'][0]) && !empty($meta['_igv_end_date'][0])) {
              $start = $m = new \Moment\Moment('@' . $meta['_igv_start_date'][0]);
              $end = $m = new \Moment\Moment('@' . $meta['_igv_end_date'][0]);
          ?>
            <h4><?php echo $start->format($date_format) . ' - ' . $end->format($date_format); ?></h4>
          <?php
            }
          ?>

          <ul id="single-exposicion-nav" class="u-inline-list">
            <li class="exposicion-filter active u-pointer" data-target="text"><?php echo __('[:es]Texto[:en]Text'); ?></li>
            <li class="exposicion-filter u-pointer" data-target="images"><?php echo __('[:es]Imágenes[:en]Images'); ?></li>
          </ul>


        </header>

        <div id="exposicion-text" class="exposicion-content active">
          <div class="copy">
            <?php the_content(); ?>
          </div>
        </div>

        <div id="exposicion-images" class="exposicion-content">
          <?php
            if (!empty($images)) {
              foreach ($images as $image) {
          ?>
            <div class="exposicion-image">
          <?php
                if (!empty($image['work'])) {
                  echo '<a href="' . get_the_permalink($image['work']) . '">';
                }
                echo wp_get_attachment_image($image['image_id'], 'gallery');
                if (!empty($image['work'])) {
                  echo '</a>';
                }
          ?>
            </div>
          <?php
              }
            }
          ?>
        </div>

      </article>

    <!-- end posts -->
    </section>

<?php
  }
} else {
?>
    <div class="col col-6"></div>
    <article class="col col-14 u-alert"><?php _e('Sorry, no posts matched your criteria'); ?></article>
<?php
} ?>


<!-- end main-content -->

</main>

<?php
get_footer();
?>
