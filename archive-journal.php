<?php
get_header();
?>

<!-- main content -->

<main id="main-content" class="container">

  <div class="row">

    <div class="col col-6">

    </div>

    <!-- main posts loop -->
    <section id="posts" class="u-float">

<?php
if( have_posts() ) {
  while( have_posts() ) {
    the_post();
?>

      <article <?php post_class('col col-6 hover-grid-item hover-grid-item-small u-flex-center'); ?> id="post-<?php the_ID(); ?>">
        <a href="<?php the_permalink() ?>">
          <?php the_post_thumbnail('hover-grid-thumb-small'); ?>
          <div class="hover-grid-title font-serif font-italic"><?php the_title(); ?></div>
        </a>
      </article>

<?php
  }
} else {
?>
    <article class="u-alert"><?php _e('Sorry, no posts matched your criteria'); ?></article>
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