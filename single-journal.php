<?php
get_header();
?>

<!-- main content -->

<main id="main-content" class="container">

  <div class="row">

    <div class="col col-3">

      <a href="<?php echo home_url('journal/'); ?>" class="large-arrow">&larr;</a>

    </div>

    <!-- main posts loop -->
    <section id="posts" class="col col-21">

<?php
if( have_posts() ) {
  while( have_posts() ) {
    the_post();
    $meta = get_post_meta($post->ID);
?>

      <article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

        <?php
          if (!empty($meta['_igv_image_id'])) {
            echo wp_get_attachment_image($meta['_igv_image_id'][0], 'journal-large-single');
          }
        ?>

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