<?php
get_header();
$lang = qtranxf_getLanguage();
?>

<!-- main content -->

<main id="main-content" class="container">

  <div class="row">

<?php
if( have_posts() ) {
  while( have_posts() ) {
    the_post();
    $meta = get_post_meta($post->ID);

    if (!empty($meta['_igv_in_progress'][0])) {
      $in_progress = $meta['_igv_in_progress'][0];
    } else {
      $in_progress = false;
    }

    if (!empty($meta['_igv_gallery'][0])) {
      $gallery = true;
    } else {
      $gallery = false;
    }

    $years = get_all_years(array('obra'), 'DESC');
    $year_post = get_the_time('Y');
?>

    <div class="col col-6">

      <a href="<?php echo home_url('obra/'); ?>" class="large-arrow only-mobile">&larr;</a>

      <ul id="year-filter" class="filter-menu only-desktop">
<?php
foreach($years as $year) {
  $active_class = $year == $year_post ? 'active' : '';
?>
        <li><a href="<?php echo home_url('obra/'); ?>?a=<?php echo $year; ?>" class="filter-term <?php echo $active_class; ?>"><?php echo $year; ?></a></li>
<?php
}
?>
        <li>&nbsp;</li>
        <li><a href="<?php echo home_url('obra/'); ?>" class="filter-term <?php echo $year_param === 'all' ? 'active' : ''; ?>"><?php echo __('[:es]Todos[:en]All'); ?></a></li>
      </ul>

    </div>

      <article <?php post_class('u-float'); ?> id="single-work-<?php the_ID(); ?>">

        <div class="col col-9">

          <header id="single-work-header">

            <h2 id="single-work-title">
              <span class="font-italic"><?php the_title(); ?></span>
              <?php
                echo '<br/>' . the_date('Y','','',false);
                if ($in_progress) {
                  echo ' ' . __('[:es](en progreso)[:en](in progress)');
                }
              ?>
            </h2>

            <div id="single-work-meta">
              <?php
                if (!empty($meta['_igv_medium_' . $lang])) {
                  echo '<div>' . $meta['_igv_medium_' . $lang][0] . '</div>';
                }
                if (!empty($meta['_igv_size'])) {
                  echo $meta['_igv_size'][0];
                }
              ?>
            </div>

          </header>

          <div id="single-work-copy">
            <?php the_content(); ?>
          </div>

          <nav id="single-work-nav" class="u-cf">

            <nav id="single-work-pagination" class="u-float only-desktop">
              <?php
                previous_post_link('%link', __('[:es]obra anterior[:en]previous work'));
                if (get_previous_post_link() && get_next_post_link()) {
                  echo ' / ';
                }
                next_post_link('%link', __('[:es]siguiente obra[:en]next work')); ?>
            </nav>

            <?php if ($gallery) { ?>
            <nav id="single-work-gallery-nav" class="u-float">
              <span class="js-gallery-prev u-pointer"><</span> <span id="gallery-index-active">0</span> / <span id="gallery-index-length">0</span> <span class="js-gallery-next u-pointer">></span>
            </nav>
            <?php } ?>

          </nav>

        </div>

        <div class="col col-9">

          <?php
            if (!empty($meta['_igv_gallery'])) {
              echo do_shortcode(__($meta['_igv_gallery'][0]));
            } else if (!empty($meta['_igv_video_id'])) {
          ?>
          <div class="u-video-embed-container">
            <iframe src="https://player.vimeo.com/video/<?php echo $meta['_igv_video_id'][0]; ?>?title=0&byline=0&portrait=0" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
          </div>
          <?php
            } else {
              the_post_thumbnail('col-9');
            }
          ?>

        </div>

      </article>

<?php
  }
} else {
?>
    <div class="col col-6"></div>
    <div class="u-alert col col-18"><?php _e('Sorry, no posts matched your criteria'); ?></div>
<?php
} ?>


<!-- end main-content -->

</main>

<?php
get_footer();
?>
