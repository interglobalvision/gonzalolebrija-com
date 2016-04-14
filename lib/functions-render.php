<?php

  // RENDER FUNCTIONS

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