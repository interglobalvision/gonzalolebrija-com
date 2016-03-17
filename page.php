<?php
get_header();
?>

<!-- main content -->

<main id="main-content" class="container">

  <div class="row">

    <div class="col col-6">
<?php

      $children = get_children(array(
        'post_parent' => $post->ID,
      	'post_type'   => 'page',
      	'numberposts' => -1,
      ));

      // if page has children create submenu
      if ($children) {
        echo_page_children_submenu($children);
      }

      // if page has parent list the siblings
      if ($post->post_parent) {

        $children = get_children(array(
          'post_parent' => $post->post_parent,
        	'post_type'   => 'page',
        	'numberposts' => -1,
        ));
        if ($children) {
          echo_page_children_submenu($children);
        }

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

      <article <?php post_class(); ?> id="page-<?php the_ID(); ?>">

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