<?php
get_header();
?>

<!-- main content -->

<main id="main-content" class="container">

  <div class="row">

    <div class="col col-6">

    </div>

    <!-- main posts loop -->
    <section id="posts">

<?php
if( have_posts() ) {
  while( have_posts() ) {
    the_post();
?>

      <article <?php post_class('col col-18'); ?> id="post-<?php the_ID(); ?>">

        <header class="post-header">

          <a href="<?php the_permalink() ?>"><h4 class="post-date"><?php the_time('M., Y'); ?></h4></a>

          <a href="<?php the_permalink() ?>"><h2 class="post-title"><?php the_title(); ?></h2></a>

        </header>

        <div class="copy">
          <?php the_content(); ?>
        </div>

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


<!-- end main-content -->

</main>

<?php
get_footer();
?>