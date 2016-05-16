<div class="home-news-post">
  <a href="<?php the_permalink() ?>">
    <header class="home-news-post-header u-align-center">
      <h4 class="home-news-post-date font-capitalize"><?php the_time('M., y') ?></h4>
      <h2 class="js-fix-widows"><?php the_title(); ?></h2>
    </header>
    <?php the_post_thumbnail('col-12'); ?>
    <div class="home-news-post-copy">
      <?php the_excerpt();?>
    </div>
  </a>
</div>