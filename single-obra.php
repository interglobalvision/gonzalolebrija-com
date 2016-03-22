<?php
get_header();
$lang = qtranxf_getLanguage();
?>

<!-- main content -->

<main id="main-content" class="container">

  <div class="row">

    <div class="col col-6">

      <ul>
      <?php
        // this needs active state for current year. but wp_get_archives doesnt do that so perhaps we add a class with js string matching!?!?
        $args = array(
          'type'            => 'yearly',
          'limit'           => '',
          'format'          => 'html',
          'before'          => '',
          'after'           => '',
          'show_post_count' => false,
          'echo'            => 1,
          'order'           => 'DESC'
        );
        wp_get_archives($args);
      ?>
        <li>&nbsp;</li>
        <li><a href="<?php echo home_url('obra/'); ?>"><?php echo __('[:es]Todas[:en]All'); ?></a></li>
      </ul>

    </div>

<?php
if( have_posts() ) {
  while( have_posts() ) {
    the_post();
    $meta = get_post_meta($post->ID);
?>

      <article <?php post_class('u-float'); ?> id="single-work-<?php the_ID(); ?>">

        <div class="col col-9">

          <h2 id="single-work-title" class="font-italic">
            <?php
              the_title();
              if (!empty($meta['_igv_year'])) {
                echo '<br/>' . $meta['_igv_year'][0];
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

          <?php the_content(); ?>

          <nav id="single-work-nav">

            <?php previous_post_link('%link', __('[:es]obra anterior[:en]previous work')); ?> / <?php next_post_link('%link', __('[:es]siguiente obra[:en]next work')); ?>

            <nav id="single-work-gallery-nav">
              <span class="js-gallery-prev u-pointer"><</span> <span id="gallery-index-active">0</span> / <span id="gallery-index-length">0</span> <span class="js-gallery-next u-pointer">></span>
            </nav>

          </nav>

        </div>

        <div class="col col-9">

          <?php
            if (!empty($meta['_igv_gallery'])) {
              echo do_shortcode(__($meta['_igv_gallery'][0]));
            }
          ?>

        </div>

      </article>

<?php
  }
} else {
?>
    <div class="u-alert col col-18"><?php _e('Sorry, no posts matched your criteria'); ?></div>
<?php
} ?>


<!-- end main-content -->

</main>

<?php
get_footer();
?>