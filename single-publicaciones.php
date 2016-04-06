<?php
get_header();
?>

<!-- main content -->

<main id="main-content" class="container">

  <div class="row">

    <div class="col col-6">

      <a href="<?php echo home_url('publicaciones/'); ?>" class="large-arrow">&larr;</a>

    </div>

<?php
if( have_posts() ) {
  while( have_posts() ) {
    the_post();
    $meta = get_post_meta($post->ID);
?>

      <article <?php post_class('u-cf'); ?> id="single-publicacion">

        <div class="col col-18">
          <?php
            if (!empty($meta['_igv_gallery'])) {
              echo do_shortcode($meta['_igv_gallery'][0]);
            }
          ?>
        </div>

        <div class="col col-6">
          <a href="<?php the_permalink() ?>"><h2 class="post-title"><?php
            the_title();
            echo ', ' . get_the_time('Y', $post->ID);
          ?></h2></a>

          <?php get_template_part('partials/gallery-nav'); ?>
        </div>

        <div class="col col-12">

          <div class="copy larger-copy">
            <?php the_content(); ?>
          </div>

        </div>

      </article>

<?php
  }
} else {
?>
    <article class="u-alert col col-18"><?php _e('Sorry, no posts matched your criteria'); ?></article>
<?php
} ?>


<!-- end main-content -->

</main>

<?php
get_footer();
?>