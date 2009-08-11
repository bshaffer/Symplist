<?php echo link_to($plugin['title'], $plugin->getRoute()) ?>
<span class='rating'>
  <?php include_component('plugin', 'rating', array('rating' => $plugin->getRating())) ?>
</span>