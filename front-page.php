<?php
get_header();

$date = time();

if (qtranxf_getLanguage() == 'es') {
  $locale = 'es_ES';
} else {
  $locale = 'en_US';
}

\Moment\Moment::setLocale($locale);

$date_format = 'd M, y';
?>

<div id="home-header" class="container font-serif">
  <div class="row">
    <div class="col col-6">
      <h4><a href="<?php echo home_url(); ?>"><?php bloginfo('name'); ?></a></h4>
      <?php echo qtranxf_generateLanguageSelectCode('both'); ?>
    </div>
    <div class="col col-12 u-align-center">
      <h1 id="home-site-title" class="font-bold"><a href="<?php echo home_url(); ?>">GL.</a></h1>
    </div>
    <div class="col col-6">
      <?php get_search_form(); ?>
    </div>
  </div>
</div>

<!-- main content -->

<main id="main-content" class="container">

  <div class="row only-desktop">
    <div class="col col-6">
      <div class="home-column">
        <a href="<?php echo home_url('exposiciones/'); ?>"><h4 class="border-bottom"><?php echo __('[:es]Exposiciones actuales[:en]Current Exhibitions'); ?></h4></a>
        <?php
          $args = array(
            'post_type' => 'exposiciones',
            'posts_per_page' => 2,
            'meta_query' => array(
              'relation' => 'AND',
              array(
                'key'     => '_igv_start_date',
                'value'   => $date,
                'compare' => '<='
              ),
              array(
                'key'     => '_igv_end_date',
                'value'   => $date,
                'compare' => '>='
              )
            )
          );
          $current_exhibitions = new WP_Query($args);
          if ($current_exhibitions->have_posts()) {
            while ($current_exhibitions->have_posts()) {
              $current_exhibitions->the_post();
              $meta = get_post_meta($post->ID);
              $start = $m = new \Moment\Moment('@' . $meta['_igv_start_date'][0]);
              $end = $m = new \Moment\Moment('@' . $meta['_igv_end_date'][0]);
        ?>
          <div class="home-column-post">
            <a href="<?php the_permalink() ?>">
              <h3 class="home-column-post-title"><?php the_title(); ?></h3>
              <h4><?php echo $start->format($date_format) . ' - ' . $end->format($date_format) ?></h4>
              <?php the_post_thumbnail('col-6'); ?>
              <div class="home-column-post-copy">
                <?php echo wp_trim_words($post->post_content, 20, ' <span class="font-small-caps">READ MORE</span>'); ?>
              </div>
            </a>
          </div>
        <?php
            }
          }
          wp_reset_postdata();
        ?>
      </div>
    </div>
    <div class="col col-12">
      <a href="<?php echo home_url('noticias/'); ?>"><h4 class="border-bottom"><?php echo __('[:es]Noticias[:en]News'); ?></h4></a>
        <?php
          $args = array(
            'post_type' => 'post',
            'posts_per_page' => 1,
          );
          $news = new WP_Query($args);
          if ($news->have_posts()) {
            $news->the_post();
            get_template_part('partials/home-news-post');
          }
          wp_reset_postdata();
        ?>
    </div>
    <div class="col col-6">
      <div class="home-column">
        <a href="<?php echo home_url('exposiciones/'); ?>"><h4 class="border-bottom"><?php echo __('[:es]Próximas exposiciones[:en]Upcoming Exhibitions'); ?></h4></a>
        <?php
          $args = array(
            'post_type' => 'exposiciones',
            'posts_per_page' => 2,
            'meta_query' => array(
              array(
                'key'     => '_igv_start_date',
                'value'   => $date,
                'compare' => '>'
              ),
            )
          );
          $future_exhibitions = new WP_Query($args);
          if ($future_exhibitions->have_posts()) {
            while ($future_exhibitions->have_posts()) {
              $future_exhibitions->the_post();
              $meta = get_post_meta($post->ID);
        ?>
          <div class="home-column-post">
            <a href="<?php the_permalink() ?>">
              <h3 class="home-column-post-title"><?php the_title(); ?></h3>
              <h4><?php if (!empty($meta['_igv_location'][0])) {echo $meta['_igv_location'][0]; } ?></h4>
              <?php the_post_thumbnail('col-6'); ?>
              <div class="home-column-post-copy">
                <?php echo wp_trim_words($post->post_content, 20, ' <span class="font-small-caps">READ MORE</span>'); ?>
              </div>
            </a>
          </div>
        <?php
            }
          }
          wp_reset_postdata();
        ?>
      </div>
    </div>
  </div>

  <div class="row only-desktop">
    <div class="col col-6">
      <div class="home-column">
        <a href="<?php echo home_url('publicaciones/'); ?>"><h4 class="border-bottom"><?php echo __('[:es]Publicaciones[:en]Publications'); ?></h4></a>
        <?php
          $args = array(
            'post_type' => 'publicaciones',
            'posts_per_page' => 2,
          );
          $publications = new WP_Query($args);
          if ($publications->have_posts()) {
            while ($publications->have_posts()) {
              $publications->the_post();
              $meta = get_post_meta($post->ID);
        ?>
          <div class="home-column-post">
            <a href="<?php the_permalink() ?>">
              <h3 class="home-column-post-title"><?php the_title(); ?></h3>
              <?php the_post_thumbnail('col-6'); ?>
              <div class="home-column-post-copy">
                <?php echo wp_trim_words($post->post_content, 20, ' <span class="font-small-caps">READ MORE</span>'); ?>
              </div>
            </a>
          </div>
        <?php
            }
          }
          wp_reset_postdata();
        ?>
      </div>
    </div>
    <div class="col col-12">
        <?php
          $args = array(
            'post_type' => 'post',
            'posts_per_page' => 1,
            'offset' => 1
          );
          $news = new WP_Query($args);
          if ($news->have_posts()) {
            $news->the_post();
            get_template_part('partials/home-news-post');
          }
          wp_reset_postdata();
        ?>
    </div>
    <div class="col col-6">
      <div class="home-column">
        <a href="<?php echo home_url('obra/'); ?>"><h4 class="border-bottom"><?php echo __('[:es]Obra[:en]Works'); ?></h4></a>
        <?php
          $args = array(
            'post_type' => 'obra',
            'posts_per_page' => 1,
            'orderby' => 'rand',
          );
          $works = new WP_Query($args);
          if ($works->have_posts()) {
            $works->the_post();
            $meta = get_post_meta($post->ID);
        ?>
          <div class="home-column-post">
            <a href="<?php the_permalink() ?>">
              <?php the_post_thumbnail('col-6'); ?>
              <h4 class="home-column-post-title u-align-center"><?php the_title(); ?> <?php if (!empty($meta['_igv_year'][0])) {echo $meta['_igv_year'][0]; } ?></h4>
            </a>
          </div>
        <?php
          }
          wp_reset_postdata();
        ?>
        <a href="<?php echo home_url('obra/'); ?>"><h4 class="border-bottom"><?php echo __('[:es]En exhibición[:en]Works on view'); ?></h4></a>
        <?php
          $args = array(
            'post_type' => 'exposiciones',
            'posts_per_page' => 2,
            'meta_query' => array(
              'relation' => 'AND',
              array(
                'key'     => '_igv_start_date',
                'value'   => $date,
                'compare' => '<='
              ),
              array(
                'key'     => '_igv_end_date',
                'value'   => $date,
                'compare' => '>='
              )
            )
          );
          $current_exhibitions = new WP_Query($args);
          if ($current_exhibitions->have_posts()) {

            $work_ids = array();

            while ($current_exhibitions->have_posts()) {
              $current_exhibitions->the_post();
              $meta = get_post_meta($post->ID, '_igv_exposicion_images');
              if ($meta) {
                foreach ($meta[0] as $work) {
                  if (isset($work['work'])) {
                    $work_ids[] = $work['work'];
                  }
                }

              }

            }

            if (!empty($work_ids) ) {
              $work_id = $work_ids[rand(0, (count($work_ids) - 1))];

              $args = array(
                'post_type' => 'obra',
                'posts_per_page' => 1,
                'p' => $work_id,
              );
              $works = new WP_Query($args);
              if ($works->have_posts()) {
                $works->the_post();
                $meta = get_post_meta($post->ID);
          ?>
            <div class="home-column-post">
              <a href="<?php the_permalink() ?>">
                <?php the_post_thumbnail('col-6'); ?>
                <h4 class="home-column-post-title u-align-center"><?php the_title(); ?> <?php if (!empty($meta['_igv_year'][0])) {echo $meta['_igv_year'][0]; } ?></h4>
              </a>
            </div>
            <?php
              }
              wp_reset_postdata();
            }
          }
        ?>
      </div>
    </div>
  </div>

<!-- mobile content -->

  <div id="mobile-home">
    <div class="mobile-home-section border-bottom">
      <a href="<?php echo home_url('noticias/'); ?>"><h5 class="u-align-center"><?php echo __('[:es]Noticias[:en]News'); ?></h5></a>
    <?php
      $args = array(
        'post_type' => 'post',
        'posts_per_page' => 2,
      );
      $news = new WP_Query($args);
      if ($news->have_posts()) {
        while ($news->have_posts()) {
          $news->the_post();
    ?>
      <div class="mobile-home-post">
        <a href="<?php the_permalink() ?>">
          <header>
            <h5 class="mobile-home-news-post-date"><?php the_time('M., y') ?></h5>
            <h4 class="mobile-home-news-post-title font-serif js-fix-widows"><?php the_title(); ?></h4>
          </header>
          <?php the_post_thumbnail('mobile'); ?>
        </a>
      </div>
    <?php
        }
      }
      wp_reset_postdata();
    ?>
    </div>

    <div class="mobile-home-section border-bottom">
      <a href="<?php echo home_url('noticias/'); ?>"><h5 class="u-align-center"><?php echo __('[:es]Exposiciones actuales[:en]Current Exhibitions'); ?></h5></a>

      <?php
        $args = array(
          'post_type' => 'exposiciones',
          'posts_per_page' => 2,
          'meta_query' => array(
            'relation' => 'AND',
            array(
              'key'     => '_igv_start_date',
              'value'   => $date,
              'compare' => '<='
            ),
            array(
              'key'     => '_igv_end_date',
              'value'   => $date,
              'compare' => '>='
            )
          )
        );
        $current_exhibitions = new WP_Query($args);
        if ($current_exhibitions->have_posts()) {
          while ($current_exhibitions->have_posts()) {
            $current_exhibitions->the_post();
            $meta = get_post_meta($post->ID);
            $start = $m = new \Moment\Moment('@' . $meta['_igv_start_date'][0]);
            $end = $m = new \Moment\Moment('@' . $meta['_igv_end_date'][0]);
      ?>
        <div class="mobile-home-post">
          <a href="<?php the_permalink() ?>">
            <h4 class="mobile-home-news-exhibition-title font-serif font-italic"><?php the_title(); ?></h4>
            <h5 class="mobile-home-news-exhibition-dates"><?php echo $start->format($date_format) . ' - ' . $end->format($date_format) ?></h5>
            <?php the_post_thumbnail('mobile'); ?>
            <div class="mobile-home-post-copy">
              <?php echo wp_trim_words($post->post_content, 20, ' <span class="font-small-caps">READ MORE</span>'); ?>
            </div>
          </a>
        </div>
      <?php
          }
        }
        wp_reset_postdata();
      ?>
    </div>

    <div class="mobile-home-section">
     <a href="<?php echo home_url('exposiciones/'); ?>"><h5 class="u-align-center"><?php echo __('[:es]Próximas exposiciones[:en]Upcoming Exhibitions'); ?></h5></a>
      <?php
        $args = array(
          'post_type' => 'exposiciones',
          'posts_per_page' => 2,
          'meta_query' => array(
            array(
              'key'     => '_igv_start_date',
              'value'   => $date,
              'compare' => '>'
            ),
          )
        );
        $future_exhibitions = new WP_Query($args);
        if ($future_exhibitions->have_posts()) {
          while ($future_exhibitions->have_posts()) {
            $future_exhibitions->the_post();
            $meta = get_post_meta($post->ID);
      ?>
        <div class="mobile-home-post">
          <a href="<?php the_permalink() ?>">
            <h4 class="mobile-home-news-exhibition-title font-serif font-italic"><?php the_title(); ?></h4>
            <h5><?php if (!empty($meta['_igv_location'][0])) {echo $meta['_igv_location'][0]; } ?></h5>
          </a>
        </div>
      <?php
          }
        }
        wp_reset_postdata();
      ?>
    </div>
  </div>

<!-- end main-content -->
</main>

<?php
get_footer();
?>
