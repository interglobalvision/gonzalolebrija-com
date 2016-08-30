<?php
get_header();

if (qtranxf_getLanguage() == 'es') {
  $locale = 'es_ES';
} else {
  $locale = 'en_US';
}

\Moment\Moment::setLocale($locale);

// get possible year (a) param
$year_param = empty($_GET['a']) ? null : $_GET['a'];

if ($year_param) {
  query_posts($query_string . '&year=' . $year_param . '&posts_per_page=-1&orderby=rand');
}

$posts_per_pseudo_page = 9;

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
          <?php render_work_submenu(); ?>
        </ul>
      </div>
    </div>
  </div>

<!-- desktop -->

  <div class="row">
    <div id="obra-archive-submenu" class="col col-6 only-desktop">
      <ul class="filter-menu">
        <?php render_work_submenu(); ?>
      </ul>
    </div>

    <!-- main posts loop -->
    <section id="posts" class="u-float">

<?php
if( have_posts() ) {

  $i = 0;

  while( have_posts() ) {
    the_post();
?>

      <article <?php
        if ($i < $posts_per_pseudo_page) {
          post_class('col col-6 hover-grid-item u-flex-center');
        } else {
          post_class('col col-6 hover-grid-item pseudo-lazy-work u-flex-center');
        }
      ?> id="post-<?php the_ID(); ?>">
        <a href="<?php the_permalink() ?>">
          <?php the_post_thumbnail('hover-grid-thumb'); ?>
          <div class="hover-grid-title font-serif font-italic"><?php the_title(); ?></div>
        </a>
      </article>
<?php
    $i++;
  }
} else {
?>
    <article class="u-alert"><?php _e('Sorry, no posts matched your criteria :{'); ?></article>
<?php
} ?>
      <nav id="works-lazy-loader" class="u-align-center u-pointer"><?php echo __('[:es]Más Obras[:en]Load More'); ?></nav>
    <!-- end posts -->
    </section>


  </div>

<!-- end main-content -->

</main>

<?php
get_footer();
?>