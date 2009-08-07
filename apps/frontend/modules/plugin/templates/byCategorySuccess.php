<?php use_helper('Pager') ?>
<?php echo get_pager_controls($pager) ?>
<ul>
<?php foreach ($pager->getResults() as $plugin): ?>
  <li><?php echo link_to($plugin['title'], $plugin->getRoute()) ?></li>
<?php endforeach ?>
</ul>