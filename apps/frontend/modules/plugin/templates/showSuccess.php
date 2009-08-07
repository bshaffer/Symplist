<?php use_helper('Comment') ?>

<h1><?php echo $plugin['title'] ?></h1>
<p>
  <?php echo $plugin['description'] ?>
</p>
<?php if ($plugin['author_id']): ?>
  <span class='author'><?php echo link_to($plugin['Author']->getUsername(), $plugin['Author']->getRoute()) ?></span>  
<?php else: ?>
  <span class='claim'><?php echo link_to('Claim This Plugin', '@homepage') ?></span>
<?php endif ?>


<?php echo get_comments($plugin) ?>