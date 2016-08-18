<?php

  // RENDER FUNCTIONS


// Render year filters for work

  // filter function
function usort_posts_by_title($a, $b) {
  return strcmp($a->post_title, $b->post_title);
}

function render_work_submenu($postId = false) {
  $args = array(
    'post_type' => 'obra',
    'posts_per_page' => -1,
    'orderby' => 'title',
    'order' => 'ASC',
  );

  $all_works = get_posts($args);

  // this sorts the array but the title value inside the post object
  usort($all_works, 'usort_posts_by_title');

  foreach($all_works as $work) {
    $active_class = $work->ID == $postId ? 'active' : '';
  ?>
          <li><a href="<?php echo get_permalink($work->ID); ?>" class="filter-term <?php echo $active_class; ?>"><?php echo $work->post_title; ?></a></li>
  <?php
  }
}

// Render taxonomy filters for expos

function render_expo_submenu($tax_slug = false) {

  $exhibition_types = get_terms('tipo-de-exposicion');
  if ($exhibition_types) {
    foreach ($exhibition_types as $type) {
  ?>
  <li><a class="filter-term <?php if ($tax_slug === $type->slug) {echo 'active';}?>" href="<?php echo get_term_link($type->term_id); ?>"><?php echo $type->name; ?></a></li>
  <?php
    }
  }
  ?>
  <li>&nbsp;</li>
  <li><a href="<?php echo home_url('exposiciones/'); ?>" class="filter-term filter-term-all <?php echo $tax_slug ? '' : 'active'; ?>"><?php echo __('[:es]Todas[:en]All'); ?></a></li>
<?php
}

// Render month filter list for achives

function render_months_submenu($date_format, $monthNumber) {

  if (qtranxf_getLanguage() == 'es') {
    $locale = 'es_ES';
  } else {
    $locale = 'en_US';
  }

  \Moment\Moment::setLocale($locale);

  $months = get_all_months(array('post'), 'DESC');

  foreach($months as $month) {
    $monthMoment = new \Moment\Moment($month->month . '/1/' . $month->year);
    $link = get_month_link($monthMoment->format('Y'), $monthMoment->format('n'));

    echo '<li>';
    if ($monthNumber == $monthMoment->format('n')) {
      echo '<a class="filter-term font-capitalize active" href="' . $link . '">' . $monthMoment->format($date_format) . '</a>';
    } else {
      echo '<a class="filter-term font-capitalize" href="' . $link . '">' . $monthMoment->format($date_format) . '</a>';
    }
    echo '</li>';
  }
}

// Render page's submenu
function render_page_submenu($post) {
  $children = get_children(array(
    'post_parent' => $post->ID,
  	'post_type'   => 'page',
  	'numberposts' => -1,
  ));

  // if page has children create submenu
  if ($children) {
    echo_page_children_submenu($children);
  }

  // if page has parent list the siblings
  if ($post->post_parent) {

    $children = get_children(array(
      'post_parent' => $post->post_parent,
    	'post_type'   => 'page',
    	'numberposts' => -1,
    ));
    if ($children) {
      echo_page_children_submenu($children);
    }

  }
}

// Echo submenu of page children
function echo_page_children_submenu($children) {
  if ($children) {
    echo '<ul class="submenu">';
    foreach($children as $child) {
      echo '<li><a href="' . get_the_permalink($child->ID) . '">' . $child->post_title . '</a></li>';
    }
    echo '</ul>';
  }
}