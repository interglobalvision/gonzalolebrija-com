<?php
get_header();

$date_format = 'M., y';

$monthNumber = get_query_var('monthnum');
?>

<!-- main content -->

<main id="main-content" class="container">

<!--   mobile submenus -->

  <nav id="mobile-submenu-open" class="u-pointer">></nav>

  <div id="mobile-archive-submenu">
    <nav id="mobile-submenu-close" class="u-pointer"><</nav>

    <div id="mobile-submenu-header">
      <div class="container">
        <h1 class="mobile-site-title">
          <a href="<?php echo home_url(); ?>"><?php bloginfo('name'); ?></a>
          <nav class="mobile-menu-open u-pointer"><span class="genericon genericon-menu"></span></nav>
        </h1>
      </div>
    </div>

    <div id="mobile-submenu-main">
      <div class="container">
        <ul id="month-filter" class="filter-list mobile-menu">
          <?php
            render_months_submenu($date_format, $monthNumber);
          ?>
          <li>&nbsp;</li>
          <li><a href="<?php echo home_url('noticias/'); ?>" class="filter-term filter-term-all font-capitalize <?php echo $monthNumber ? '' : 'active'; ?>"><?php echo __('[:es]Todos[:en]All'); ?></a></li>
        </ul>
      </div>
    </div>
  </div>

<!-- desktop -->

  <div class="row">

    <div id="archive-submenu" class="col col-6">
      <ul id="month-filter" class="filter-list">
        <?php
          render_months_submenu($date_format, $monthNumber);
        ?>
        <li>&nbsp;</li>
        <li><a href="<?php echo home_url('noticias/'); ?>" class="filter-term filter-term-all font-capitalize <?php echo $monthNumber ? '' : 'active'; ?>"><?php echo __('[:es]Todos[:en]All'); ?></a></li>
      </ul>
    </div>

    <!-- main posts loop -->
    <section id="posts">

<?php
if( have_posts() ) {
  while( have_posts() ) {
    the_post();
?>

      <article <?php post_class('col col-18 archive-noticia-post u-align-center'); ?> id="post-<?php the_ID(); ?>">

        <header class="post-header">

          <a href="<?php the_permalink() ?>"><h4 class="post-date font-capitalize"><?php the_time('M., Y'); ?></h4></a>

          <a href="<?php the_permalink() ?>"><h2 class="post-title font-spaced js-fix-widows"><?php the_title(); ?></h2></a>

        </header>

      </article>

<?php
  }
} else {
?>
    <article class="u-alert"><?php _e('Sorry, no posts matched your criteria :{'); ?></article>
<?php
} ?>

    <?php get_template_part('partials/pagination'); ?>

    <!-- end posts -->
    </section>


<!-- end main-content -->

</main>

<?php
get_footer();
?>