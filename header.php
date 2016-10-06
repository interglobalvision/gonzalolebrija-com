<!DOCTYPE html>
<html lang="en" prefix="og: http://ogp.me/ns#">
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title><?php wp_title('|',true,'right'); bloginfo('name'); ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="apple-touch-icon" sizes="180x180" href="<?php bloginfo('stylesheet_directory'); ?>/img/dist/apple-touch-icon.png">
  <link rel="icon" type="image/png" href="<?php bloginfo('stylesheet_directory'); ?>/img/dist/favicon-32x32.png" sizes="32x32">
  <link rel="icon" type="image/png" href="<?php bloginfo('stylesheet_directory'); ?>/img/dist/favicon-16x16.png" sizes="16x16">
  <link rel="manifest" href="<?php bloginfo('stylesheet_directory'); ?>/img/favicon/manifest.json">
  <link rel="mask-icon" href="<?php bloginfo('stylesheet_directory'); ?>/img/dist/safari-pinned-tab.svg" color="#5bbad5">
  <link rel="shortcut icon" href="<?php bloginfo('stylesheet_directory'); ?>/img/dist/favicon.ico">
  <meta name="msapplication-config" content="<?php bloginfo('stylesheet_directory'); ?>/img/favicon/browserconfig.xml">
  <meta name="theme-color" content="#ffffff">

  <?php get_template_part('partials/seo'); ?>

  <link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />


  <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<!--[if lt IE 9]><p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p><![endif]-->

  <section id="main-container">

    <!-- start content -->
    <header id="header">
      <div class="container">
        <div id="header-top" class="row">
          <div class="col col-6">
            <h1 id="site-title">
              <a href="<?php echo home_url(); ?>"><?php bloginfo('name'); ?></a>
              <nav class="mobile-menu-open u-pointer"><span class="genericon genericon-menu"></span></nav>
            </h1>
          </div>
          <div class="col col-18 only-desktop">
            <ul id="menu">
              <li class="menu-item"><a href="<?php echo home_url('noticias/'); ?>"><?php echo __('[:es]Noticias[:en]News'); ?></a></li>
              <li class="menu-item"><a href="<?php echo home_url('exposiciones/'); ?>"><?php echo __('[:es]Exposiciones[:en]Exhibitions'); ?></a></a></li>
              <li class="menu-item"><a href="<?php echo home_url('obra/'); ?>"><?php echo __('[:es]Obra[:en]Work'); ?></a></a></li>
              <li class="menu-item"><a href="<?php echo home_url('journal/'); ?>"><?php echo __('[:es]Journal[:en]Journal'); ?></a></a></li>
              <li class="menu-item"><a href="<?php echo home_url('publicaciones/'); ?>"><?php echo __('[:es]Publicaciones[:en]Publications'); ?></a></a></li>
              <li class="menu-item"><a href="<?php echo home_url('archivo/'); ?>"><?php echo __('[:es]Archivo[:en]Archive'); ?></a></a></li>
              <li class="menu-item"><a href="<?php echo home_url('info/'); ?>"><?php echo __('[:es]Info[:en]Info'); ?></a></a></li>
            </ul>
          </div>
        </div>

        <div id="header-bottom" class="row font-serif only-desktop">
          <div class="col col-18">
            <?php echo qtranxf_generateLanguageSelectCode('both'); ?>
          </div>
          <div class="col col-6">
            <?php get_search_form(); ?>
          </div>
        </div>

        <div class="row">
          <div class="col col-24 border-bottom"></div>
        </div>
      </div>
    </header>