<?php use_helper('Pager') ?>
<?php echo get_pager_controls($pager) ?>
<ol start='<?php echo $pager->getFirstIndice() ?>'>
<?php foreach ($pager->getResults() as $plugin): ?>
  <li><?php echo link_to($plugin['title'], $plugin->getRoute()) ?></li>
<?php endforeach ?>
</ol>
<?php echo get_pager_controls($pager) ?>