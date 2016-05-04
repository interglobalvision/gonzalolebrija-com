<?php
if (get_next_posts_link() || get_previous_posts_link()) {
?>
  <!-- post pagination -->
  <nav id="pagination" class="u-float">
    <div class="col col-18">
<?php
$previous = get_previous_posts_link(__('[:es]más nuevo[:en]newer'));
$next = get_next_posts_link(__('[:es]más viejo[:en]older'));
if ($previous) {
  echo $previous;
}
if ($previous && $next) {
  echo ' / ';
}
if ($next) {
  echo $next;
}
?>
    </div>
  </nav>
<?php
}
?>