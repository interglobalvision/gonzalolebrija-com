<nav id="mobile-active-menu">
  <div class="container">
    <h1 class="mobile-site-title">
      <a href="<?php echo home_url(); ?>"><?php bloginfo('name'); ?></a>
      <nav class="mobile-menu-close u-pointer">&times;</nav>
    </h1>
    <ul class="mobile-menu">
      <li class="mobile-menu-item"><a href="<?php echo home_url('noticias/'); ?>"><?php echo __('[:es]Noticias[:en]News'); ?></a></li>
      <li class="mobile-menu-item"><a href="<?php echo home_url('exposiciones/'); ?>"><?php echo __('[:es]Exposiciones[:en]Exhibitions'); ?></a></a></li>
      <li class="mobile-menu-item"><a href="<?php echo home_url('obra/'); ?>"><?php echo __('[:es]Obra[:en]Work'); ?></a></a></li>
      <li class="mobile-menu-item"><a href="<?php echo home_url('journal/'); ?>"><?php echo __('[:es]Journal[:en]Journal'); ?></a></a></li>
      <li class="mobile-menu-item"><a href="<?php echo home_url('publicaciones/'); ?>"><?php echo __('[:es]Publicaciones[:en]Publications'); ?></a></a></li>
      <li class="mobile-menu-item"><a href="<?php echo home_url('archivo/'); ?>"><?php echo __('[:es]Archivo[:en]Archive'); ?></a></a></li>
      <li class="mobile-menu-item"><a href="<?php echo home_url('info/'); ?>"><?php echo __('[:es]Info[:en]Info'); ?></a></a></li>
    </ul>
    <?php echo qtranxf_generateLanguageSelectCode('both'); ?>
    <ul id="mobile-search">
      <li><?php get_search_form(); ?></li>
    </ul>
  </div>
</nav>