<?php
get_header();
?>

<!-- main content -->

<main id="main-content" class="container">

  <div class="row">

    <div class="col col-6 only-desktop"></div>

    <!-- main posts loop -->
    <section id="page">

<?php
if( have_posts() ) {
  while( have_posts() ) {
    the_post();
    $second = get_post_meta($post->ID, '_igv_second_column', true);
    $third = get_post_meta($post->ID, '_igv_third_column', true);
?>

      <article <?php post_class(); ?> id="page-<?php the_ID(); ?>">

        <div class="col col-5">
          <div class="copy">
            <?php the_content(); ?>
          </div>
        </div>

        <div class="col col-5 ">
          <div class="copy">
          <?php
            if ($second) {
              echo apply_filters('the_content', $second);
            }
          ?>
          </div>
        </div>

        <div class="col col-5">
          <div class="copy">
          <?php
            if ($third) {
              echo apply_filters('the_content', $third);
            }
          ?>
          </div>
        </div>

      </article>

    <!-- end page -->
    </section>

<?php
  }
} else {
?>
    <section id="page" class="col col-14">
      <article class="u-alert"><?php _e('Sorry, no posts matched your criteria :{'); ?></article>
    </section>
<?php
} ?>

<!-- end main-content -->

</main>

<?php
get_footer();
?>
