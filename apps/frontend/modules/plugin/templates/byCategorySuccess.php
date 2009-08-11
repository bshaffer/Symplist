<?php use_helper('Pager') ?>
<?php echo get_pager_controls($pager) ?>
<ol start='<?php echo $pager->getFirstIndice() ?>'>
<?php foreach ($pager->getResults() as $plugin): ?>
  <li>
    <?php include_partial('plugin/list_item', array('plugin' => $plugin)) ?>
  </li>
<?php endforeach ?>
</ol>
<?php echo get_pager_controls($pager) ?>