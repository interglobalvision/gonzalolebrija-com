<?php
get_header();

if (qtranxf_getLanguage() == 'es') {
  $locale = 'es_ES';
} else {
  $locale = 'en_US';
}

\Moment\Moment::setLocale($locale);

// current time
$now = new \Moment\Moment();

$date_format = 'M., y';

$monthNumber = get_query_var('monthnum');
?>

<!-- main content -->

<main id="main-content" class="container">

  <div class="row">

    <div class="col col-6">
      <ul id="month-filter" class="filter-list">
        <?php

          $months = get_all_months(array('post'), 'DESC');

          foreach($months as $month) {

            $monthMoment = new \Moment\Moment($month->month . '/1/' . $month->year);
            $link = get_month_link($monthMoment->format('Y'), $monthMoment->format('n'));

            echo '<li>';
            if ($monthNumber == $monthMoment->format('n')) {
              echo '<a class="filter-term active" href="' . $link . '">' . $monthMoment->format($date_format) . '</a>';
            } else {
              echo '<a class="filter-term" href="' . $link . '">' . $monthMoment->format($date_format) . '</a>';
            }
            echo '</li>';
          }
        ?>

        <li>&nbsp;</li>
        <li><a href="<?php echo home_url('noticias/'); ?>" class="filter-term filter-term-all <?php echo $year_param === 'all' ? 'active' : ''; ?>"><?php echo __('[:es]Todos[:en]All'); ?></a></li>

      </ul>

    </div>

    <!-- main posts loop -->
    <section id="posts">

<?php
if( have_posts() ) {
  while( have_posts() ) {
    the_post();
?>

      <article <?php post_class('col col-18 archive-noticia-post u-align-center'); ?> id="post-<?php the_ID(); ?>">

        <header class="post-header">

          <a href="<?php the_permalink() ?>"><h4 class="post-date"><?php the_time('M., Y'); ?></h4></a>

          <a href="<?php the_permalink() ?>"><h2 class="post-title font-spaced js-fix-widows"><?php the_title(); ?></h2></a>

        </header>

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