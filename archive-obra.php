<?php
get_header();

if (qtranxf_getLanguage() == 'es') {
  $locale = 'es_ES';
} else {
  $locale = 'en_US';
}

\Moment\Moment::setLocale($locale);

$year_param = empty($_GET['a']) ? 'all' : $_GET['a'];

if ($year_param) {
  global $query_string;
  query_posts($query_string . '&year=' . $year_param);
}

?>

<!-- main content -->

<main id="main-content" class="container">

  <div class="row">

    <div class="col col-6">

      <ul class="filter-menu">
      <?php
        $year_archive = get_all_years(array('obra'), 'DESC');

        if ($year_archive) {
          foreach ($year_archive as $year) {
            $active_class = $year == $year_param ? 'active' : '';
      ?>
        <li><a href="?a=<?php echo $year; ?>" class="filter-term <?php echo $active_class; ?>"><?php echo $year; ?></a></li>
      <?php
          }
        }
      ?>
        <li>&nbsp;</li>
        <li><a href="<?php echo home_url('obra/'); ?>" class="filter-term filter-term-all <?php echo $year_param === 'all' ? 'active' : ''; ?>"><?php echo __('[:es]Todas[:en]All'); ?></a></li>
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