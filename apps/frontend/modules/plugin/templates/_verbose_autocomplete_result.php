<h6><?php echo link_to($plugin['title'], '@plugin?title='.$plugin['title']) ?></h6>
<?php include_component('plugin', 'rating', array('rating' => $plugin['rating'])) ?>
<?php if ($plugin['description']): ?>
  <p><?php echo strip_tags($plugin['description']).'...' ?></p>
<?php endif ?>
