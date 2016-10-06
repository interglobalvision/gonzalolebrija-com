    <footer id="footer" class="container font-serif">
      <div class="row">
        <div class="col col-24 border-bottom"></div>
      </div>
      <div id="footer-content" class="row">
        <div class="col col-12">
          ©<?php echo date('Y'); ?> Gonzalo Lebrija.
        </div>
        <div class="col col-12 u-align-right">
          <?php echo __('[:es]Todos los derechos reservados.[:en]All rights reserved.'); ?>
        </div>
      </div>
    </footer>

  </section>

  <?php get_template_part('partials/mobile-menu'); ?>

  <?php get_template_part('partials/scripts'); ?>

  <?php
    $facebook = IGV_get_option('_igv_socialmedia_facebook_url');
    $twitter = IGV_get_option('_igv_socialmedia_twitter');
    $instagram = IGV_get_option('_igv_socialmedia_instagram');

    $logo = IGV_get_option('_igv_metadata_logo');
  ?>
  <script type="application/ld+json">
    {
      "@context": "http://schema.org",
      "@type": "Organization",
      "url": "<?php echo site_url(); ?>",
      <?php
        if ($logo) {
          echo '"logo": "' . $logo . '",';
        }
      ?>
      "sameAs" : [
        <?php
          if (!empty($facebook)) {
            echo '"' . $facebook . '",';
          }

          if (!empty($twitter)) {
            echo '"https://twitter.com/' . $twitter . '",';
          }

          if (!empty($instagram)) {
            echo '"https://instagram.com/' . $instagram . '",';
          }
        ?>
        ]
    }
  </script>

  </body>
</html>