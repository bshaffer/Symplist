<div class='plugin-header'>
<?php echo link_to($plugin->getTitle(), $plugin->getRoute(), array('class' => 'plugin-title')) ?> 
  <span class='rating small'>
    <?php include_component('plugin', 'rating', array('rating' => $plugin->getRating())) ?>
  </span>
  <span class='num_votes'>(<?php echo $plugin->getNumVotes() . ($plugin->getNumVotes() == 1 ? ' vote' : ' votes') ?>)</span>
</div>
<?php if ($summary = $plugin->getSummary()): ?>
<p>
  <?php echo $summary ?>
</p>  
<?php endif ?>
