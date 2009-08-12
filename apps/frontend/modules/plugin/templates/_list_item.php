<?php echo link_to($plugin['title'], $plugin->getRoute()) ?> 
<span class='num_votes'>(<?php echo $plugin->getNumVotes() . ($plugin->getNumVotes() == 1 ? ' vote' : ' votes') ?>)</span>
<span class='rating'>
  <?php include_component('plugin', 'rating', array('rating' => $plugin->getRating())) ?>
</span>