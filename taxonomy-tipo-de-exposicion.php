<?php
get_header();

var_dump(get_query_var('tipo-de-exposicion'));

?>

<!-- main content -->

<main id="main-content" class="container">

  <div class="row">

    <div class="col col-6">

      <ul class="filter-menu">
      <?php
        $exhibition_types = get_terms('tipo-de-exposicion');

        if ($exhibition_types) {
          foreach ($exhibition_types as $type) {
      ?>
        <li class="filter-term"><a href="<?php echo get_term_link($type->term_id); ?>"><?php echo $type->name; ?></a></li>
      <?php
          }
        }
      ?>
        <li>&nbsp;</li>
        <li><a href="<?php echo home_url('exposiciones/'); ?>" class="filter-term filter-term-all active"><?php echo __('[:es]Todas[:en]All'); ?></a></li>
      </ul>

    </div>

    <!-- main posts loop -->
    <section id="posts" class="u-float">

<?php
if( have_posts() ) {
  while( have_posts() ) {
    the_post();
?>

      <article <?php post_class('col col-6 hover-grid-item u-flex-center'); ?> id="post-<?php the_ID(); ?>">
        <a href="<?php the_permalink() ?>">
          <?php the_post_thumbnail('hover-grid-thumb'); ?>
          <div class="hover-grid-title font-serif font-italic"><?php the_title(); ?></div>
        </a>
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

  </div>

<!-- end main-content -->

</main>

<?php
get_footer();
?>