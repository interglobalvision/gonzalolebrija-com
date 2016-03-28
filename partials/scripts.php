<section id="scripts">
<?php if (!WP_DEBUG) { ?>
  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<?php } ?>
  <script>window.jQuery || document.write('<script src="<?php bloginfo('stylesheet_directory'); ?>/js/vendor/jquery-2.1.1.min.js"><\/script>')</script>
  <?php wp_footer(); ?>
</section>
