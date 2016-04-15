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

?>

<!-- main content -->

<main id="main-content" class="container">

  <div class="row">

    <div class="col col-8">

      <a href="<?php echo home_url('noticias/'); ?>" class="large-arrow only-mobile">&larr;</a>

      <ul id="month-filter" class="filter-list only-desktop">
        <?php

          $months = get_all_months(array('post'), 'DESC');

          foreach($months as $month) {

            $monthMoment = new \Moment\Moment($month->month . '/1/' . $month->year);
            $link = get_month_link($monthMoment->format('Y'), $monthMoment->format('n'));

            echo '<li>';
            if (get_the_time('n') == $monthMoment->format('n')) {
              echo '<a class="filter-term font-capitalize active" href="' . $link . '">' . $monthMoment->format($date_format) . '</a>';
            } else {
              echo '<a class="filter-term font-capitalize" href="' . $link . '">' . $monthMoment->format($date_format) . '</a>';
            }
            echo '</li>';
          }
        ?>

        <li>&nbsp;</li>
        <li><a href="<?php echo home_url('noticias/'); ?>" class="filter-term filter-term-all font-capitalize"><?php echo __('[:es]Todos[:en]All'); ?></a></li>
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

        <header id="single-post-header" class="u-align-center">

          <a href="<?php the_permalink() ?>"><h4 id="single-post-date" class="font-capitalize"><?php the_time('M., Y'); ?></h4></a>

          <a href="<?php the_permalink() ?>"><h2 id="single-post-title"><?php the_title(); ?></h2></a>

        </header>

        <div class="copy larger-copy">
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
