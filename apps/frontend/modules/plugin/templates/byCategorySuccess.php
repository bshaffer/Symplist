<?php use_helper('Pager') ?>
<?php $results = $pager->getResults()?>
<?php if ($results->count() > 0): ?>
  <?php echo get_pager_controls($pager) ?>
  <ol start='<?php echo $pager->getFirstIndice() ?>'>
  <?php foreach ($results as $plugin): ?>
    <li>
      <?php include_partial('plugin/plugin', array('plugin' => $plugin)) ?>
    </li>
  <?php endforeach ?>
  </ol>
  <?php echo get_pager_controls($pager) ?>
<?php else: ?>
  <h3>No Results Found</h3>
<?php endif ?>