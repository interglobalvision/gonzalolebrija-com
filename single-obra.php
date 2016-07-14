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

      <article <?php post_class('u-cf'); ?> id="single-work">

        <div class="col col-18">
          <?php
            if (!empty($meta['_igv_gallery'])) {
              echo do_shortcode(__($meta['_igv_gallery'][0]));
          ?>
          <nav id="single-work-gallery-nav" class="u-align-right">
            <span id="swiper-caption-holder"></span> <span id="single-work-gallery-pagination-holder"><span class="js-gallery-prev u-pointer">< </span><span id="single-work-gallery-pagination"></span><span class="js-gallery-next u-pointer"> ></span></span>
          </nav>
          <?php
            } else if (!empty($meta['_igv_video_id'])) {
          ?>
          <div class="u-video-embed-container">
            <iframe src="https://player.vimeo.com/video/<?php echo $meta['_igv_video_id'][0]; ?>?title=0&byline=0&portrait=0" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
          </div>
          <?php
            } else {
              the_post_thumbnail('col-18');
            }
          ?>
        </div>

        <header id="single-work-header" class="col col-6">
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

          <nav id="single-work-nav" class="u-cf">

            <nav id="single-work-pagination" class="u-float only-desktop">
              <?php
                previous_post_link('%link', __('[:es]obra anterior[:en]previous work'));
                if (get_previous_post_link() && get_next_post_link()) {
                  echo ' / ';
                }
                next_post_link('%link', __('[:es]siguiente obra[:en]next work')); ?>
            </nav>

          </nav>

        </header>

        <div class="col col-12">

          <div id="single-work-content" class="copy larger-copy">
            <?php
              the_content();
            ?>
          </div>
            <?php
              if (!empty($meta['_igv_download'])) {
            ?>
            <a href="<?php echo $meta['_igv_download'][0]; ?>" download class="font-underline"><?php echo __('[:es]Descargar ficha[:en]Download file'); ?></a>
            <?php
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
