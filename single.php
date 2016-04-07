<?php
get_header();
?>

<!-- main content -->

<main id="main-content" class="container">

  <div class="row">

    <div class="col col-8">

      <ul>
      <?php
        // this needs active state for current year. but wp_get_archives doesnt do that so perhaps we add a class with js string matching!?!?
        // the date format is also incorrect and there is no way to set it. so perhaps we need to write a custom version of this function
        $args = array(
          'type'            => 'monthly',
          'limit'           => '',
          'format'          => 'html',
          'before'          => '',
          'after'           => '',
          'show_post_count' => false,
          'echo'            => 1,
          'order'           => 'ASC'
        );
        wp_get_archives($args);
      ?>
        <li>&nbsp;</li>
        <li><a href="<?php echo home_url('noticias/'); ?>"><?php echo __('[:es]Todas[:en]All'); ?></a></li>
      </ul>

    </div>

    <!-- main posts loop -->
    <section id="post" class="col col-12">

<?php
if( have_posts() ) {
  while( have_posts() ) {
    the_post();
?>

      <article <?php post_class(); ?> id="single-post-<?php the_ID(); ?>">

        <header id="single-post-header">

          <a href="<?php the_permalink() ?>"><h4 id="single-post-date font-capitalize"><?php the_time('M., Y'); ?></h4></a>

          <a href="<?php the_permalink() ?>"><h2 id="single-post-title"><?php the_title(); ?></h2></a>

        </header>

        <div class="copy">
          <?php the_content(); ?>
        </div>

      </article>

<?php
  }
} else {
?>
    <article class="u-alert"><?php _e('Sorry, no posts matched your criteria'); ?></article>
<?php
} ?>

    <!-- end posts -->
    </section>


<!-- end main-content -->

</main>

<?php
get_footer();
?>
