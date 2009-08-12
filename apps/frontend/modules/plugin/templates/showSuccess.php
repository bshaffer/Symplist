<?php use_helper('Comment') ?>

<h1><?php echo $plugin['title'] ?></h1>

<span class='rating'>
  <?php include_component('plugin', 'rating', array('rating' => $plugin->getRating())) ?>
</span>
<p>
  <?php echo $plugin['description'] ?>
</p>
<?php if ($plugin['user_id']): ?>
  <span class='plugin-author'>Registered by <?php echo link_to($plugin['User']->getUsername(), $plugin['User']->getRoute(), array('class' => 'author-link')) ?></span>  
<?php else: ?>
  <span class='claim'><?php echo link_to('Claim This Plugin', '@plugin_claim?title='.$plugin['title']) ?></span>
<?php endif ?>


<?php echo get_comments($plugin) ?>