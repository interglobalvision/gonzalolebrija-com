<?php
get_header();
?>

<!-- main content -->

<main id="main-content" class="container">

<!--   mobile submenus -->

  <nav id="mobile-submenu-open" class="u-pointer">></nav>

  <div id="mobile-archive-submenu">
    <nav id="mobile-submenu-close" class="u-pointer"><</nav>

    <div id="mobile-submenu-header">
      <div class="container">
        <h1 class="mobile-site-title">
          <a href="<?php echo home_url(); ?>"><?php bloginfo('name'); ?></a>
          <nav class="mobile-menu-open u-pointer"><span class="genericon genericon-menu"></span></nav>
        </h1>
      </div>
    </div>

    <div id="mobile-submenu-main">
      <div class="container">
        <ul class="filter-list mobile-menu">
          <?php render_expo_submenu(); ?>
        </ul>
      </div>
    </div>
  </div>

<!-- desktop -->

  <div class="row">

    <div id="archive-submenu" class="col col-6">
      <ul class="filter-menu">
        <?php render_expo_submenu(); ?>
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