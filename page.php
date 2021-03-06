<?php
get_header();
?>

<!-- main content -->

<main id="main-content" class="container">

  <div id="mobile-page-submenu" class="only-mobile">
    <?php render_page_submenu($post); ?>
  </div>

  <div class="row">

    <div class="col col-6 only-desktop">
      <?php
        render_page_submenu($post);

        if (is_page('info')) {
          $cv = IGV_get_option('_igv_cv_download');
          if (!empty($cv)) {
            echo '<a href="' . $cv . '" target="_blank">CV</a>';
          }
        }
      ?>
    </div>

    <!-- main posts loop -->
    <section id="page" class="col col-14">

<?php
if( have_posts() ) {
  while( have_posts() ) {
    the_post();
?>

      <article <?php post_class(); ?> id="page-<?php the_ID(); ?>">

        <div class="copy copy-indented">
          <?php the_content(); ?>
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
