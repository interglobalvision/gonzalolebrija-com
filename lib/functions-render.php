<?php

  // RENDER FUNCTIONS

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