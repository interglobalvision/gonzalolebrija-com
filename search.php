<?php
get_header();
?>

<!-- main content -->

<main id="main-content" class="container">

  <div class="row">

    <div class="col col-6">

      <?php
        if (have_posts()) {
          if ($wp_query->post_count === 1) {
              echo $wp_query->post_count . ' ' . __('[:es]Resultado[:en]Result');
          } else {
            echo $wp_query->post_count . ' ' . __('[:es]Resultados[:en]Results');
          }
        } else {
          echo __('[:es]Sin resultados[:en]No results');
        }
      ?>

    </div>

    <!-- main posts loop -->
    <section id="posts" class="col col-18">

<?php
if( have_posts() ) {
  while( have_posts() ) {
    the_post();
?>

      <article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

        <header class="post-header">

          <a href="<?php the_permalink() ?>"><h5 class="post-type">
            <?php
              if (get_post_type() !== 'post') {
                echo get_post_type();
              } else {
                echo __('[:es]Noticias[:en]News');
              }
            ?>
          </h5></a>

          <a href="<?php the_permalink() ?>"><h2 class="post-title"><?php the_title(); ?></h2></a>

        </header>

      </article>

<?php
  }
}
?>

    <?php get_template_part('partials/pagination'); ?>

    <!-- end posts -->
    </section>

  </div>

<!-- end main-content -->

</main>

<?php
get_footer();
?>